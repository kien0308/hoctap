<?php

namespace WordPress\Plugin\Encyclopedia;

use WP_Post, WP_Query;

abstract class Core
{
    public static
        $base_url, # url to the plugin directory
        $plugin_file, # the main plugin file
        $plugin_folder; # the path to the folder the plugin files contains

    public static function init(string $plugin_file): void
    {
        static::$plugin_file = $plugin_file;
        static::$plugin_folder = DirName(static::$plugin_file);

        register_Activation_Hook(static::$plugin_file, [static::class, 'installPlugin']);
        register_Deactivation_Hook(static::$plugin_file, [static::class, 'uninstallPlugin']);
        add_Action('plugins_loaded', [static::class, 'loadBaseUrl']);
        add_Action('loop_start', [static::class, 'printPrefixFilter']);
        add_Action('encyclopedia_print_prefix_filter', [static::class, 'printPrefixFilter'], 10, 0);
        add_Filter('wp_robots', [static::class, 'setNoindexTag']);
        add_Filter('get_the_archive_title', [static::class, 'filterArchiveTitle']);
    }

    public static function loadBaseURL(): void
    {
        $absolute_plugin_folder = RealPath(static::$plugin_folder);

        if (StrPos($absolute_plugin_folder, ABSPATH) === 0)
            static::$base_url = site_url() . '/' . SubStr($absolute_plugin_folder, Strlen(ABSPATH));
        else
            static::$base_url = Plugins_Url(BaseName(static::$plugin_folder));

        static::$base_url = Str_Replace("\\", '/', static::$base_url); # Windows Workaround
    }

    public static function installPlugin(): void
    {
        Taxonomies::registerTagTaxonomy();
        Post_Type::registerPostType();
        flush_Rewrite_Rules();
    }

    public static function uninstallPlugin(): void
    {
        flush_Rewrite_Rules();
    }

    public static function isEncyclopediaSearch(WP_Query $query): bool
    {
        if ($query->is_search) {
            # Check post type
            if ($query->get('post_type') == Post_Type::post_type_name) return true;

            # Check taxonomies
            $encyclopedia_taxonomies = get_Object_Taxonomies(Post_Type::post_type_name);
            if (!empty($encyclopedia_taxonomies) && $query->is_Tax($encyclopedia_taxonomies)) return true;
        }

        return false;
    }

    public static function addCrossLinks(string $content, $post = null): string
    {
        $post_id = $post->ID ?? null;
        $post_type = $post->post_type ?? null;

        # Start Cross Linker
        $cross_linker = new Cross_Linker();
        $cross_linker->setSkipElements(apply_Filters('encyclopedia_cross_linking_skip_elements', ['a', 'script', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'button', 'textarea', 'select', 'style', 'pre', 'code', 'kbd', 'tt']));
        if (!$cross_linker->loadContent($content))
            return $content;

        # Build the Query
        $query_args = [
            'post_type' => Post_Type::post_type_name,
            'post__not_in' => [$post_id],
            'nopaging' => true,
            'orderby' => 'post_title_length',
            'order' => 'DESC',
            'no_count_rows' => true,
            'no_found_rows' => true,
            'update_post_term_cache' => false,
            'update_post_meta_cache' => false,
        ];

        # Query the items
        $query = new WP_Query($query_args);

        # Create the links
        foreach ($query->posts as $item) {
            if (apply_Filters('encyclopedia_link_item_in_content', true, $item, $post, $cross_linker)) {
                $cross_linker->linkPhrase($item->post_title, [static::class, 'getCrossLinkItemDetails'], [$item]);
            }
        }

        # Overwrite the content with the parsers document which contains the links to each term
        $content = (string) $cross_linker->getParserDocument();

        return $content;
    }

    public static function getCrossLinkItemDetails(WP_Post $item)
    {
        return (object) [
            'phrase' => $item->post_title,
            'title' => static::getCrossLinkItemTitle($item),
            'url' => get_Permalink($item),
        ];
    }

    public static function getCrossLinkItemTitle(WP_Post $post): string
    {
        $title = $more = $length = false;

        if (empty($post->post_excerpt)) {
            $more = apply_Filters('encyclopedia_link_title_more', '&hellip;');
            #$more = HTML_Entity_Decode($more, ENT_QUOTES, 'UTF-8');
            $length = apply_Filters('encyclopedia_link_title_length', Options::get('cross_link_title_length'));
            $title = strip_Shortcodes($post->post_content);
            $title = WP_Strip_All_Tags($title);
            #$title = HTML_Entity_Decode($title, ENT_QUOTES, 'UTF-8');
            $title = WP_Trim_Words($title, $length, $more);
        } else {
            $title = WP_Strip_All_Tags($post->post_excerpt, true);
            #$title = HTML_Entity_Decode($title, ENT_QUOTES, 'UTF-8');
        }

        $title = apply_Filters('encyclopedia_item_link_title', $title, $post, $more, $length);

        return $title;
    }

    public static function printPrefixFilter(?WP_Query $query = null)
    {
        global $post, $wp_the_query;

        static $loop_already_started;
        if ($loop_already_started)
            return false;

        # If this is a feed we leave
        if (is_Feed())
            return false;

        # If we are in head section we leave
        if (!did_Action('wp_head'))
            return false;

        # get the current query
        if (empty($query))
            $query = $wp_the_query;

        # Run filter
        if (!apply_Filters('encyclopedia_is_prefix_filter_enabled', true, $query))
            return false;

        # Conditions
        if ($query->is_Main_Query() && !$query->get('suppress_filters')) {
            $is_archive_filter = $query->is_Post_Type_Archive(Post_Type::post_type_name) && Options::get('prefix_filter_for_archives');
            $is_taxonomy_filter = ($query->is_tax || $query->is_category || $query->is_tag) && Options::get('prefix_filter_for_archives');
            $is_singular_filter = $query->is_Singular(Post_Type::post_type_name) && Options::get('prefix_filter_for_singulars');

            # Check if we are inside a taxonomy archive
            $taxonomy_term = null;
            if ($is_taxonomy_filter) {
                # save the current taxonomy term
                $taxonomy_term = $query->get_Queried_Object();

                # get all taxonomies associated with the Encyclopedia post type
                $arr_encyclopedia_taxonomies = (array) get_Object_Taxonomies(Post_Type::post_type_name);

                # Check if the prefix filter is activated for this archive
                if (!in_Array($taxonomy_term->taxonomy, $arr_encyclopedia_taxonomies))
                    return false;
            }

            # Get current Filter string
            $current_filter = '';
            if ($query->get('prefix') !== '')
                $current_filter = RawUrlDecode($query->get('prefix'));
            elseif (is_Singular())
                $current_filter = MB_StrToLower(isset($post->post_title) ? $post->post_title : '');

            # Get the Filter depth
            $filter_depth = 0;
            if ($is_archive_filter || $is_taxonomy_filter)
                $filter_depth = (int) Options::get('prefix_filter_archive_depth');
            elseif ($is_singular_filter)
                $filter_depth = (int) Options::get('prefix_filter_singular_depth');

            # print the filter
            if ($is_archive_filter || $is_taxonomy_filter || $is_singular_filter) {
                Prefix_Filter::printFilter($current_filter, $filter_depth, $taxonomy_term);
                $loop_already_started = true;
            }
        }
    }

    public static function setNoindexTag(array $robots): array
    {
        if (is_archive() && StrLen(get_query_var('prefix'))) {
            $robots['noindex'] = true;
        }

        return $robots;
    }

    public static function filterArchiveTitle(string $title): string
    {
        if (is_Post_Type_Archive(Post_Type::post_type_name))
            return Post_Type_Archive_Title('', false);
        else
            return $title;
    }
}
