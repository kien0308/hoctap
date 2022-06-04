<?php
/**
 * Adds the theme options sections, settings, and controls to the theme customizer
 *
 * @package Consultare
 */

class Consultare_Theme_Options {
	public function __construct() {
		// Register our Panel.
		add_action( 'customize_register', array( $this, 'add_panel' ) );

		// Register Breadcrumb Options.
		add_action( 'customize_register', array( $this, 'register_breadcrumb_options' ) );

		// Register Excerpt Options.
		add_action( 'customize_register', array( $this, 'register_excerpt_options' ) );

		// Register Homepage Options.
		add_action( 'customize_register', array( $this, 'register_homepage_options' ) );

		// Register Layout Options.
		add_action( 'customize_register', array( $this, 'register_layout_options' ) );

		// Register Search Options.
		add_action( 'customize_register', array( $this, 'register_search_options' ) );

		// Add default options.
		add_filter( 'consultare_customizer_defaults', array( $this, 'add_defaults' ) );
	}

	/**
	 * Add options to defaults
	 */
	public function add_defaults( $default_options ) {
		$defaults = array(
			// Header Media.
			'consultare_header_image_visibility' => 'entire-site',

			// Breadcrumb
			'consultare_breadcrumb_show' => 1,

			// Layout Options.
			'consultare_default_layout'          => 'left-sidebar',
			'consultare_homepage_archive_layout' => 'left-sidebar',
			
			// Excerpt Options
			'consultare_excerpt_length'    => 15,
			'consultare_excerpt_more_text' => esc_html__( 'Continue reading', 'consultare' ),

			// Homepage/Frontpage Options.
			'consultare_front_page_category'   => '',
			'consultare_show_homepage_content' => 1,

			// Search Options.
			'consultare_search_text'         => esc_html__( 'Search...', 'consultare' ),

			// Menu Options.
			'consultare_primary_menu_on'        => 1,
			'consultare_primary_menu_search_on' => 1,
		);


		$updated_defaults = wp_parse_args( $defaults, $default_options );

		return $updated_defaults;
	}

	/**
	 * Register the Customizer panels
	 */
	public function add_panel( $wp_customize ) {
		/**
		 * Add our Header & Navigation Panel
		 */
		 $wp_customize->add_panel( 'consultare_theme_options',
		 	array(
				'title' => esc_html__( 'Theme Options', 'consultare' ),
			)
		);
	}

	/**
	 * Add breadcrumb section and its controls
	 */
	public function register_breadcrumb_options( $wp_customize ) {
		// Add Excerpt Options section.
		$wp_customize->add_section( 'consultare_breadcrumb_options',
			array(
				'title' => esc_html__( 'Breadcrumb', 'consultare' ),
				'panel' => 'consultare_theme_options',
			)
		);

		if ( function_exists( 'bcn_display' ) ) {
			Consultare_Customizer_Utilities::register_option(
				array(
					'custom_control'    => 'Consultare_Simple_Notice_Custom_Control',
					'sanitize_callback' => 'sanitize_text_field',
					'settings'          => 'ff_multiputpose_breadcrumb_plugin_notice',
					'label'             =>  esc_html__( 'Info', 'consultare' ),
					'description'       =>  sprintf( esc_html__( 'Since Breadcrumb NavXT Plugin is installed, edit plugin\'s settings %1$shere%2$s', 'consultare' ), '<a href="' . esc_url( get_admin_url( null, 'options-general.php?page=breadcrumb-navxt' ) ) . '" target="_blank">', '</a>' ),
					'section'           => 'ff_multiputpose_breadcrumb_options',
				)
			);

			return;
		}

		Consultare_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'Consultare_Toggle_Switch_Custom_control',
				'settings'          => 'consultare_breadcrumb_show',
				'sanitize_callback' => 'consultare_switch_sanitization',
				'label'             => esc_html__( 'Display Breadcrumb?', 'consultare' ),
				'section'           => 'consultare_breadcrumb_options',
			)
		);

		Consultare_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'Consultare_Toggle_Switch_Custom_control',
				'settings'          => 'consultare_breadcrumb_show_home',
				'sanitize_callback' => 'consultare_switch_sanitization',
				'label'             => esc_html__( 'Show on homepage?', 'consultare' ),
				'section'           => 'consultare_breadcrumb_options',
			)
		);
	}

	/**
	 * Add layouts section and its controls
	 */
	public function register_layout_options( $wp_customize ) {
		// Add layouts section.
		$wp_customize->add_section( 'consultare_layouts',
			array(
				'title' => esc_html__( 'Layouts', 'consultare' ),
				'panel' => 'consultare_theme_options'
			)
		);

		Consultare_Customizer_Utilities::register_option(
			array(
				'type'              => 'select',
				'settings'          => 'consultare_default_layout',
				'sanitize_callback' => 'consultare_sanitize_select',
				'label'             => esc_html__( 'Default Layout', 'consultare' ),
				'section'           => 'consultare_layouts',
				'choices'           => array(
					'left-sidebar'          => esc_html__( 'Left Sidebar', 'consultare' ),
					'no-sidebar-full-width' => esc_html__( 'No Sidebar: Full Width', 'consultare' ),
				),
			)
		);

		Consultare_Customizer_Utilities::register_option(
			array(
				'type'              => 'select',
				'settings'          => 'consultare_homepage_archive_layout',
				'sanitize_callback' => 'consultare_sanitize_select',
				'label'             => esc_html__( 'Homepage/Archive Layout', 'consultare' ),
				'section'           => 'consultare_layouts',
				'choices'           => array(
					'left-sidebar'          => esc_html__( 'Left Sidebar', 'consultare' ),
					'no-sidebar-full-width' => esc_html__( 'No Sidebar: Full Width', 'consultare' ),
				),
			)
		);
	}

	/**
	 * Add excerpt section and its controls
	 */
	public function register_excerpt_options( $wp_customize ) {
		// Add Excerpt Options section.
		$wp_customize->add_section( 'consultare_excerpt_options',
			array(
				'title' => esc_html__( 'Excerpt Options', 'consultare' ),
				'panel' => 'consultare_theme_options',
			)
		);

		Consultare_Customizer_Utilities::register_option(
			array(
				'type'              => 'number',
				'settings'          => 'consultare_excerpt_length',
				'sanitize_callback' => 'absint',
				'label'             => esc_html__( 'Excerpt Length (Words)', 'consultare' ),
				'section'           => 'consultare_excerpt_options',
			)
		);

		Consultare_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'settings'          => 'consultare_excerpt_more_text',
				'sanitize_callback' => 'sanitize_text_field',
				'label'             => esc_html__( 'Excerpt More Text', 'consultare' ),
				'section'           => 'consultare_excerpt_options',
			)
		);
	}

	/**
	 * Add Homepage/Frontpage section and its controls
	 */
	public function register_homepage_options( $wp_customize ) {
		Consultare_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'Consultare_Dropdown_Select2_Custom_Control',
				'sanitize_callback' => 'consultare_text_sanitization',
				'settings'          => 'consultare_front_page_category',
				'description'       => esc_html__( 'Filter Homepage/Blog page posts by following categories', 'consultare' ),
				'label'             => esc_html__( 'Categories', 'consultare' ),
				'section'           => 'static_front_page',
				'input_attrs'       => array(
					'multiselect' => true,
				),
				'choices'           => array( esc_html__( '--Select--', 'consultare' ) => Consultare_Customizer_Utilities::get_terms( 'category' ) ),
			)
		);

		Consultare_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'Consultare_Toggle_Switch_Custom_control',
				'settings'          => 'consultare_show_homepage_content',
				'sanitize_callback' => 'consultare_switch_sanitization',
				'label'             => esc_html__( 'Show Home Content/Blog', 'consultare' ),
				'section'           => 'static_front_page',
			)
		);
	}

	/**
	 * Add Homepage/Frontpage section and its controls
	 */
	public function register_search_options( $wp_customize ) {
		// Add Homepage/Frontpage Section.
		$wp_customize->add_section( 'consultare_search',
			array(
				'title' => esc_html__( 'Search', 'consultare' ),
				'panel' => 'consultare_theme_options',
			)
		);

		Consultare_Customizer_Utilities::register_option(
			array(
				'settings'          => 'consultare_search_text',
				'sanitize_callback' => 'consultare_text_sanitization',
				'label'             => esc_html__( 'Search Text', 'consultare' ),
				'section'           => 'consultare_search',
				'type'              => 'text',
			)
		);
	}

	/**
	 * Array for fonts.
	 */
	public static function get_font_options() {
		$fonts = array(
			'consultare_body_font' => array(
				'label'    => esc_html__( 'Body(Default)', 'consultare' ),
				'selector' => 'body',
			),
			'consultare_title_font' => array(
				'label'    => esc_html__( 'Site Title', 'consultare' ),
				'selector' => '.site-title',
			),
			'consultare_tagline_font' => array(
				'label'    => esc_html__( 'Tagline', 'consultare' ),
				'selector' => '.site-description',
			),
			'consultare_menu_font' => array(
				'label'    => esc_html__( 'Menu', 'consultare' ),
				'selector' => '.main-navigation ul li a',
			),
			'consultare_content_font' => array(
				'label'    => esc_html__( 'Content', 'consultare' ),
				'selector' => '#content, #content p',
			),
			'consultare_headings_font' => array(
				'label'    => esc_html__( 'Headings (h1 to h6)', 'consultare' ),
				'selector' => 'h1, h2, h3, h4, h5, h6',
			),
			'consultare_section_title_font' => array(
				'label'    => esc_html__( 'Section Title', 'consultare' ),
				'selector' => '#hero-content .section-title',
			),
		);

		return $fonts;
	}
}

/**
 * Initialize class
 */
$consultare_theme_options = new Consultare_Theme_Options();
