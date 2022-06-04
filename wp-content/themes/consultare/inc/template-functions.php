<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Consultare
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function consultare_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class with respect to layout selected.
	$layout  = consultare_get_theme_layout();
	
	$layout_class = 'layout-no-sidebar-full-width';

	if ( 'left-sidebar' === $layout && is_active_sidebar( 'sidebar-1' ) ) {
		$layout_class = 'layout-left-sidebar';
	}

	$classes[] = $layout_class;

	// Add Site Layout Class.
	$classes[] = 'fluid-layout';

	// Add Archive Layout Class.
	$classes[] = 'excerpt-image-left';

	// Add header Style Class.
	$classes['header-class'] = 'header-one';

	// Add Color Scheme Class.
	$classes[] = 'default-color-scheme';

	$consultare_enable = consultare_gtm( 'consultare_header_image_visibility' );

	if ( ! consultare_display_section( $consultare_enable ) || ( ! has_header_image() && ! ( is_header_video_active() && has_header_video() ) ) ) {
    	$classes[] = 'no-header-media';
    }

	return $classes;
}
add_filter( 'body_class', 'consultare_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function consultare_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'consultare_pingback_header' );

if ( ! function_exists( 'consultare_excerpt_length' ) ) :
	/**
	 * Sets the post excerpt length to n words.
	 *
	 * function tied to the excerpt_length filter hook.
	 * @uses filter excerpt_length
	 */
	function consultare_excerpt_length( $length ) {
		if ( is_admin() ) {
			return $length;
		}

		// Getting data from Theme Options
		$length	= consultare_gtm( 'consultare_excerpt_length' );

		return absint( $length );
	} // consultare_excerpt_length.
endif;
add_filter( 'excerpt_length', 'consultare_excerpt_length', 999 );

if ( ! function_exists( 'consultare_excerpt_more' ) ) :
	/**
	 * Replaces "[...]" (appended to automatically generated excerpts) with ... and a option from customizer
	 *
	 * @return string option from customizer prepended with an ellipsis.
	 */
	function consultare_excerpt_more( $more ) {
		if ( is_admin() ) {
			return $more;
		}

		$more_tag_text = consultare_gtm( 'consultare_excerpt_more_text' );

		$link = sprintf( '<a href="%1$s" class="more-link"><span class="more-button">%2$s</span></a>',
			esc_url( get_permalink() ),
			/* translators: %s: Name of current post */
			wp_kses_data( $more_tag_text ). '<span class="screen-reader-text">' . esc_html( get_the_title( get_the_ID() ) ) . '</span>'
		);

		return '&hellip;' . $link;
	}
endif;
add_filter( 'excerpt_more', 'consultare_excerpt_more' );

if ( ! function_exists( 'consultare_custom_excerpt' ) ) :
	/**
	 * Adds Continue reading link to more tag excerpts.
	 *
	 * function tied to the get_the_excerpt filter hook.
	 */
	function consultare_custom_excerpt( $output ) {
		if ( is_admin() ) {
			return $output;
		}

		if ( has_excerpt() && ! is_attachment() ) {
			$more_tag_text = consultare_gtm( 'consultare_excerpt_more_text' );

			$link = sprintf( '<a href="%1$s" class="more-link"><span class="more-button">%2$s</span></a>',
				esc_url( get_permalink() ),
				/* translators: %s: Name of current post */
				wp_kses_data( $more_tag_text ). '<span class="screen-reader-text">' . esc_html( get_the_title( get_the_ID() ) ) . '</span>'
			);

			$output .= '&hellip;' . $link;
		}

		return $output;
	} // consultare_custom_excerpt.
endif;
add_filter( 'get_the_excerpt', 'consultare_custom_excerpt' );

if ( ! function_exists( 'consultare_more_link' ) ) :
	/**
	 * Replacing Continue reading link to the_content more.
	 *
	 * function tied to the the_content_more_link filter hook.
	 */
	function consultare_more_link( $more_link, $more_link_text ) {
		$more_tag_text = consultare_gtm( 'consultare_excerpt_more_text' );

		return str_replace( $more_link_text, wp_kses_data( $more_tag_text ), $more_link );
	} // consultare_more_link.
endif;
add_filter( 'the_content_more_link', 'consultare_more_link', 10, 2 );

/**
 * Filter Homepage Options as selected in theme options.
 */
function consultare_alter_home( $query ) {
	if ( $query->is_home() && $query->is_main_query() ) {
		$cats = consultare_gtm( 'consultare_front_page_category' );

		if ( $cats ) {
			$query->query_vars['category__in'] = explode( ',', $cats );
		}
	}
}
add_action( 'pre_get_posts', 'consultare_alter_home' );

/**
 * Display section as selected in theme options.
 */
function consultare_display_section( $option ) {
	if ( 'entire-site' === $option || 'custom-pages' === $option || ( is_front_page() && 'homepage' === $option ) || ( ! is_front_page() && 'excluding-home' === $option ) ) {
		return true;
	}

	// Section is disabled.
	return false;
}

/**
 * Return theme layout
 * @return layout
 */
function consultare_get_theme_layout() {
	$layout = '';

	if ( is_page_template( 'templates/full-width-page.php' ) ) {
		$layout = 'no-sidebar-full-width';
	} elseif ( is_page_template( 'templates/left-sidebar.php' ) ) {
		$layout = 'left-sidebar';
	} else {
		$layout = consultare_gtm( 'consultare_default_layout' );

		if ( is_home() || is_archive() ) {
			$layout = consultare_gtm( 'consultare_homepage_archive_layout' );
		}
	}

	return $layout;
}

/**
 * Function to add Scroll Up icon
 */
function consultare_scrollup() {
	$disable_scrollup = consultare_gtm( 'consultare_band_disable_scrollup' );

	if ( $disable_scrollup ) {
		return;
	}

	echo '<a href="#masthead" id="scrollup" class="backtotop">' . '<span class="screen-reader-text">' . esc_html__( 'Scroll Up', 'consultare' ) . '</span></a>' ;

}
add_action( 'wp_footer', 'consultare_scrollup', 1 );

/**
 * Return args for specific section type
 */
function consultare_get_section_args( $section_name ) {
	$section_type = consultare_gtm( 'consultare_' . $section_name . '_type' );
	$numbers      = consultare_gtm( 'consultare_' . $section_name . '_number' );

	$post__in = array();

	for( $i = 0; $i < $numbers; $i++ ) {
		$post__in[] = consultare_gtm( 'consultare_' . $section_name . '_page_' . $i );
	}

	$args = array(
		'ignore_sticky_posts' => 1,
		'posts_per_page'      => absint( $numbers ),
		'post__in'            => $post__in,
		'orderby'             => 'post__in',
		'post_type'           => 'page',
	);

	return $args;
}

/**
 * Button Border Radius CSS.
 */
function consultare_button_border_radius() {
	$border_radius = consultare_gtm( 'consultare_button_border_radius' );

	if ( ! $border_radius ) {
		return;
	}

	$css = '.ff-button, .ff-button:visited, button, a.button, input[type="button"], input[type="reset"], input[type="submit"], .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt { border-radius: ' . esc_attr( $border_radius ) . 'px }';

	wp_add_inline_style( 'consultare-style', $css );
}
add_action( 'wp_enqueue_scripts', 'consultare_button_border_radius', 11 );

/**
 * Add Slider Opacity CSS
 */
function consultare_slider_opacity_css() {
	$overlay = consultare_gtm( 'consultare_slider_overlay' );

	if ( $overlay ) {
		$overlay_value = consultare_gtm( 'consultare_slider_overlay_opacity' );

		$css = '#slider-section.overlay-enabled article:before { opacity: ' . esc_attr( $overlay_value ) . '; }';

		wp_add_inline_style( 'consultare-style', $css );
	}
}
add_action( 'wp_enqueue_scripts', 'consultare_slider_opacity_css', 11 );

/**
 * Display content.
 */
function consultare_display_content( $section ) {
	?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div>
	<?php
}

/**
 * Section class format.
 */
function consultare_display_section_classes( $classes ) {
	echo esc_attr( implode( ' ', $classes ) );
}

/**
 * Return theme layout
 * @return layout
 */
function consultare_get_sidebar_id() {
	$sidebar = '';

	$layout = consultare_get_theme_layout();

	if ( 'no-sidebar-full-width' === $layout ) {
		return $sidebar;
	}

	return is_active_sidebar( $sidebar ) ? $sidebar : 'sidebar-1'; // sidebar-1 is main sidebar.
}
