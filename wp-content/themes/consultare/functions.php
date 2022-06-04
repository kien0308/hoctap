<?php
/**
 * Consultare functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Consultare
 */

/**
 * Returns theme mod value saved for option merging with default option if available.
 * @since 1.0
 */
function consultare_gtm( $option ) {
	// Get our Customizer defaults
	$defaults = apply_filters( 'consultare_customizer_defaults', true );

	return isset( $defaults[ $option ] ) ? get_theme_mod( $option, $defaults[ $option ] ) : get_theme_mod( $option );
}

if ( ! function_exists( 'consultare_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function consultare_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Consultare, use a find and replace
		 * to change 'consultare' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'consultare', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// Used in archive content, featured content.
		set_post_thumbnail_size( 825, 620, false );

		// Used in slider.
		add_image_size( 'consultare-slider', 1920, 1000, false );

		// Used in hero content.
		add_image_size( 'consultare-hero', 600, 650, false );

		// Used in portfolio, team.
		add_image_size( 'consultare-portfolio', 400, 450, false );

		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary Menu', 'consultare' ),
			'social' => esc_html__( 'Social Menu', 'consultare' ),
		) );


		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'consultare_custom_background_args', array(
			'default-color' => '040402',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );

		// Add theme editor style
		add_editor_style( array( 'css/editor-style.css' ) );

		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );

		// Add support for responsive embeds.
		add_theme_support( 'responsive-embeds' );

		add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ) );
	}
endif;
add_action( 'after_setup_theme', 'consultare_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 */
function consultare_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'consultare_content_width', 1230 );
}
add_action( 'after_setup_theme', 'consultare_content_width', 0 );

if ( ! function_exists( 'consultare_custom_content_width' ) ) :
	/**
	 * Custom content width.
	 *
	 * @since 1.0
	 */
	function consultare_custom_content_width() {
		$layout  = consultare_get_theme_layout();

		if ( 'no-sidebar-full-width' !== $layout ) {
			$GLOBALS['content_width'] = apply_filters( 'consultare_content_width', 890 );
		}
	}
endif;
add_filter( 'template_redirect', 'consultare_custom_content_width' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function consultare_widgets_init() {
	$args = array(
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	);

	register_sidebar( array(
		'name'        => esc_html__( 'Sidebar', 'consultare' ),
		'id'          => 'sidebar-1',
		'description' => esc_html__( 'Add widgets here.', 'consultare' ),
		) + $args
	);

	register_sidebar( array(
		'name'        => esc_html__( 'Footer 1', 'consultare' ),
		'id'          => 'sidebar-2',
		'description' => esc_html__( 'Add widgets here to appear in your footer.', 'consultare' ),
		) + $args
	);

	register_sidebar( array(
		'name'        => esc_html__( 'Footer 2', 'consultare' ),
		'id'          => 'sidebar-3',
		'description' => esc_html__( 'Add widgets here to appear in your footer.', 'consultare' ),
		) + $args
	);

	register_sidebar( array(
		'name'        => esc_html__( 'Footer 3', 'consultare' ),
		'id'          => 'sidebar-4',
		'description' => esc_html__( 'Add widgets here to appear in your footer.', 'consultare' ),
		) + $args
	);

	if ( class_exists( 'WooCommerce' ) ) {
		//Optional Primary Sidebar for Shop
		register_sidebar( array(
			'name'        => esc_html__( 'WooCommerce Sidebar', 'consultare' ),
			'id'          => 'sidebar-woo',
			'description' => esc_html__( 'This is Optional Sidebar for WooCommerce Pages', 'consultare' ),
			) + $args
		);
	}

	// Registering 404 Error Page Content
	register_sidebar( array(
		'name'          => esc_html__( '404 Page Not Found Content', 'consultare' ),
		'id'            => 'sidebar-notfound',
		'description'   => esc_html__( 'Replaces the default 404 Page Not Found Content', 'consultare' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	//Optional Sidebar for Homepage instead of main sidebar
	register_sidebar( array(
		'name'          => esc_html__( 'Optional Homepage Sidebar', 'consultare' ),
		'id'            => 'sidebar-optional-homepage',
		'description'   => esc_html__( 'This is Optional Sidebar for Homepage', 'consultare' ),
		) + $args
	);

	//Optional Sidebar for Archive instead of main sidebar
	register_sidebar( array(
		'name'          => esc_html__( 'Optional Archive Sidebar', 'consultare' ),
		'id'            => 'sidebar-optional-archive',
		'description'   => esc_html__( 'This is Optional Sidebar for Archive', 'consultare' ),
		) + $args
	);

	//Optional Sidebar for Page instead of main sidebar
	register_sidebar( array(
		'name'          => esc_html__( 'Optional Page Sidebar', 'consultare' ),
		'id'            => 'sidebar-optional-page',
		'description'   => esc_html__( 'This is Optional Sidebar for Page', 'consultare' ),
		) + $args
	);

	//Optional Sidebar for Post instead of main sidebar
	register_sidebar( array(
		'name'          => esc_html__( 'Optional Post Sidebar', 'consultare' ),
		'id'            => 'sidebar-optional-post',
		'description'   => esc_html__( 'This is Optional Sidebar for Post', 'consultare' ),
		) + $args
	);

	//Optional Sidebar one for page and post
	register_sidebar( array(
		'name'          => esc_html__( 'Optional Sidebar One', 'consultare' ),
		'id'            => 'sidebar-optional-one',
		'description'   => esc_html__( 'This is Optional Sidebar One', 'consultare' ),
		) + $args
	);

	//Optional Sidebar two for page and post
	register_sidebar( array(
		'name'          => esc_html__( 'Optional Sidebar Two', 'consultare' ),
		'id'            => 'sidebar-optional-two',
		'description'   => esc_html__( 'This is Optional Sidebar Two', 'consultare' ),
		) + $args
	);

	//Optional Sidebar Three for page and post
	register_sidebar( array(
		'name'          => esc_html__( 'Optional Sidebar Three', 'consultare' ),
		'id'            => 'sidebar-optional-three',
		'description'   => esc_html__( 'This is Optional Sidebar Three', 'consultare' ),
		) + $args
	);

	// Content Widgets.
	register_sidebar( array(
		'name'        => esc_html__( 'Content Widget Area 1', 'consultare' ),
		'id'          => 'content-widget-1',
		'description' => esc_html__( 'Add widgets here.', 'consultare' ),
		) + $args
	);

	register_sidebar( array(
		'name'        => esc_html__( 'Content Widget Area 2', 'consultare' ),
		'id'          => 'content-widget-2',
		'description' => esc_html__( 'Add widgets here.', 'consultare' ),
		) + $args
	);

	register_sidebar( array(
		'name'        => esc_html__( 'Content Widget Area 3', 'consultare' ),
		'id'          => 'content-widget-3',
		'description' => esc_html__( 'Add widgets here.', 'consultare' ),
		) + $args
	);
}
add_action( 'widgets_init', 'consultare_widgets_init' );

/**
 * Count the number of footer sidebars to enable dynamic classes for the footer
 *
 * @since 1.0
 */
function consultare_footer_sidebar_class() {
	$count = 0;

	if ( is_active_sidebar( 'sidebar-2' ) ) {
		$count++;
	}

	if ( is_active_sidebar( 'sidebar-3' ) ) {
		$count++;
	}

	if ( is_active_sidebar( 'sidebar-4' ) ) {
		$count++;
	}

	if ( is_active_sidebar( 'sidebar-5' ) ) {
		$count++;
	}

	if ( is_active_sidebar( 'sidebar-6' ) ) {
		$count++;
	}

	$class = '';

	switch ( $count ) {
		case '1':
			$class = 'one';
			break;
		case '2':
			$class = 'two';
			break;
		case '3':
			$class = 'three';
			break;
		case '4':
			$class = 'four';
			break;
		case '5':
			$class = 'five';
			break;
	}

	if ( $class ) {
		echo 'class="widget-area footer-widget-area ' . $class . '"'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

if ( ! function_exists( 'consultare_fonts_url' ) ) :
	/**
	 * Register Google fonts for FF Multipurpose
	 *
	 * Create your own consultare_fonts_url() function to override in a child theme.
	 *
	 * @return string Google fonts URL for the theme.
	 *
	 * @since 0.1
	 */
	function consultare_fonts_url() {
		$fonts_url = '';

		/* Translators: If there are characters in your language that are not
		* supported by Heebo, translate this to 'off'. Do not translate
		* into your own language.
		*/
		$roboto_slab = _x( 'on', 'Roboto Slab font: on or off', 'consultare' );
		$poppins = _x( 'on', 'Poppins font: on or off', 'consultare' );

		if ( 'off' !== $roboto_slab && 'off' !== $poppins ) {
			$font_families = array();

			if ( 'off' !== $roboto_slab ) {
				$font_families[] = 'Roboto Slab:300,400,500,600,700,800,900';
			}

			if ( 'off' !== $poppins ) {
				$font_families[] = 'Poppins:300,400,500,600,700,800,900';
			}

			$query_args = array(
				'family' => urlencode( implode( '|', $font_families ) ),
				'subset' => urlencode( 'latin,latin-ext' ),
			);

			$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
		}

		return esc_url_raw( $fonts_url );
	}
endif;

/**
 * Enqueue scripts and styles.
 */
function consultare_scripts() {
	$min  = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	// FontAwesome.
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome/css/all' . $min . '.css', array(), '5.15.3', 'all' );

	// Theme stylesheet.
	wp_enqueue_style( 'consultare-style', get_stylesheet_uri(), array(), consultare_get_file_mod_date( 'style.css' ) );

	// Add google fonts.
	wp_enqueue_style( 'consultare-fonts', consultare_fonts_url(), array(), null );

	// Theme block stylesheet.
	wp_enqueue_style( 'consultare-block-style', get_template_directory_uri() . '/css/blocks' . $min . '.css', array( 'consultare-style' ), consultare_get_file_mod_date( 'css/blocks' . $min . '.css' ) );

	$scripts = array(
		'consultare-skip-link-focus-fix' => array(
			'src'      => '/js/skip-link-focus-fix' . $min . '.js',
			'deps'      => array(),
			'in_footer' => true,
		),
		'consultare-keyboard-image-navigation' => array(
			'src'      => '/js/keyboard-image-navigation' . $min . '.js',
			'deps'      => array(),
			'in_footer' => true,
		),
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	$deps = array( 'jquery' );

	$scripts['consultare-script'] = array(
		'src'       => '/js/functions' . $min . '.js',
		'deps'      => $deps,
		'in_footer' => true,
	);

	// Slider Scripts.
	$enable_slider = consultare_gtm( 'consultare_slider_visibility' );

	if ( consultare_display_section( $enable_slider ) ) {
		wp_enqueue_style( 'swiper-css', get_template_directory_uri() . '/css/swiper' . $min . '.css', array(), consultare_get_file_mod_date( '/css/swiper' . $min . '.css' ), false );

		$scripts['swiper'] = array(
			'src'      => '/js/swiper' . $min . '.js',
			'deps'      => null,
			'in_footer' => true,
		);

		$scripts['swiper-custom'] = array(
			'src'      => '/js/swiper-custom' . $min . '.js',
			'deps'      => array( 'swiper' ),
			'in_footer' => true,
		);
	}

	foreach ( $scripts as $handle => $script ) {
		wp_enqueue_script( $handle, get_theme_file_uri( $script['src'] ), $script['deps'], consultare_get_file_mod_date( $script['src'] ), $script['in_footer'] );
	}

	wp_localize_script( 'consultare-script', 'consultareScreenReaderText', array(
		'expand'   => esc_html__( 'expand child menu', 'consultare' ),
		'collapse' => esc_html__( 'collapse child menu', 'consultare' ),
	) );
}
add_action( 'wp_enqueue_scripts', 'consultare_scripts' );

/**
 * Get file modified date
 */
function consultare_get_file_mod_date( $file ) {
	return date( 'Ymd-Gis', filemtime( get_theme_file_path( $file ) ) );
}

/**
 * Enqueue editor styles for Gutenberg
 */
function consultare_block_editor_styles() {
	// Block styles.
	wp_enqueue_style( 'consultare-block-editor-style', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'css/editor-blocks.css' );

	// Add custom fonts.
	wp_enqueue_style( 'consultare-fonts', consultare_fonts_url(), array(), null );
}
add_action( 'enqueue_block_editor_assets', 'consultare_block_editor_styles' );

/**
 * Implement the Custom Header feature.
 */
require get_theme_file_path( '/inc/custom-header.php' );

/**
 * Breadcrumb.
 */
require get_theme_file_path( '/inc/breadcrumb.php' );

/**
 * Custom template tags for this theme.
 */
require get_theme_file_path( '/inc/template-tags.php' );

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_theme_file_path( '/inc/template-functions.php' );

/**
 * Customizer additions.
 */
require get_theme_file_path( '/inc/customizer/customizer.php' );

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_theme_file_path( '/inc/jetpack.php' );
}

/**
 * Load Theme About Page
 */
require get_parent_theme_file_path( '/inc/theme-about.php' );
