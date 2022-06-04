<?php

namespace WordPress\Plugin\Encyclopedia;

use WP_Term;

abstract class Prefix_Filter
{
    public static function generate($current_prefix = '', int $depth = 0, ?WP_Term $taxonomy_term = null): array
    {
        $arr_filter = []; # This will be the function result
        $active_prefix = '';

        do {
            do {
                $arr_available_filters = static::getFilters($active_prefix, $taxonomy_term);

                if (empty($arr_available_filters))
                    break 2;
                elseif (count($arr_available_filters) == 1) {
                    $available_filter = reset($arr_available_filters);
                    if ($available_filter->items > 1 && $active_prefix != $available_filter->prefix) { # We found one prefix only
                        $active_prefix = $available_filter->prefix;
                        continue;
                    } else { # We found only one item or the items have the same prefix as we are using at the moment ($active_prefix)
                        break 2;
                    }
                } else
                    break;
            } while (count($arr_available_filters) < 2);

            $arr_filter_line = [];
            $active_prefix = '';

            foreach ($arr_available_filters as $available_filter) {
                if (StriPos($current_prefix, $available_filter->prefix) === 0)
                    $active_prefix = $available_filter->prefix;

                $filter = (object) [
                    'prefix' => MB_Convert_Case($available_filter->prefix, MB_CASE_TITLE),  # UCFirst for multibyte chars
                    'items' => $available_filter->items, # number of available items with this prefix
                    'link' => Post_Type::getArchiveLink($available_filter->prefix, $taxonomy_term),
                    'active' => $active_prefix == $available_filter->prefix,
                    'disabled' => false
                ];

                if (empty($filter->link))
                    $filter->disabled = true;

                $arr_filter_line[$available_filter->prefix] = $filter;
            }
            $arr_filter[] = $arr_filter_line;

            # Check filter depth limit
            if ($depth && count($arr_filter) >= $depth) break;
        } while ($active_prefix);

        # Run a filter
        $arr_filter = apply_Filters('encyclopedia_prefix_filter_links', $arr_filter, $depth);

        return $arr_filter;
    }

    public static function getFilters(string $prefix = '', ?WP_Term $taxonomy_term = null): array
    {
        global $wpdb;

        $prefix_length = MB_StrLen($prefix) + 1;

        $tables = ["{$wpdb->posts} as posts"];

        $where = [
            'posts.post_status  =     "publish"',
            'posts.post_title   !=    ""',
            'posts.post_title   LIKE  "' . esc_sql($prefix) . '%"'
        ];

        if ($taxonomy_term) {
            $tables[] = "{$wpdb->term_relationships} AS term_relationships";
            $where[] = 'term_relationships.object_id = posts.id';
            $where[] = "term_relationships.term_taxonomy_id = {$taxonomy_term->term_taxonomy_id}";
        } else {
            $where[] = sprintf('posts.post_type = "%s"', Post_Type::post_type_name);
        }

        $stmt = '
            SELECT
                LOWER(SUBSTRING(posts.post_title,1,' . $prefix_length . ')) prefix,
                COUNT(ID) items
            FROM    ' . join(',', $tables) . '
            WHERE   ' . join(' AND ', $where) . '
            GROUP BY prefix
            ORDER BY prefix ASC';

        $arr_filter = $wpdb->get_Results($stmt);

        foreach ($arr_filter as &$filter) {
            $filter->prefix = trim($filter->prefix);
            if (mb_strlen($filter->prefix) < $prefix_length)
                $filter = null;
        }
        unset($filter);

        $arr_filter = array_filter($arr_filter);
        $arr_filter = array_values($arr_filter);
        $arr_filter = apply_Filters('encyclopedia_available_prefix_filters', $arr_filter, $prefix, $taxonomy_term);

        return $arr_filter;
    }

    public static function printFilter(string $current_filter = '', int $filter_depth = 0, ?WP_Term $taxonomy_term = null): void
    {
        $prefix_filter = static::generate($current_filter, $filter_depth, $taxonomy_term);

        if (!empty($prefix_filter)) {
            echo Template::load('encyclopedia-prefix-filter.php', ['filter' => $prefix_filter]);
        }
    }
}
