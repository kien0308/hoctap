<?php
/**
 * Adds the header options sections, settings, and controls to the theme customizer
 *
 * @package Consultare
 */

class Consultare_Header_Options {
	public function __construct() {
		// Register Header Options.
		add_action( 'customize_register', array( $this, 'register_header_options' ) );

		// Add default options.
		add_filter( 'consultare_customizer_defaults', array( $this, 'add_defaults' ) );
	}

	/**
	 * Add options to defaults
	 */
	public function add_defaults( $default_options ) {
		$defaults = array(
			'consultare_header_style'            => 'header-one',
			'consultare_header_top_color_scheme' => 'dark-top-header', 
		);

		$updated_defaults = wp_parse_args( $defaults, $default_options );

		return $updated_defaults;
	}

	/**
	 * Add header options section and its controls
	 */
	public function register_header_options( $wp_customize ) {
		// Add header options section.
		$wp_customize->add_section( 'consultare_header_options',
			array(
				'title' => esc_html__( 'Header Options', 'consultare' ),
				'panel' => 'consultare_theme_options'
			)
		);

		Consultare_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'settings'          => 'consultare_header_top_text',
				'sanitize_callback' => 'consultare_text_sanitization',
				'label'             => esc_html__( 'Text', 'consultare' ),
				'section'           => 'consultare_header_options',
			)
		);

		Consultare_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'settings'          => 'consultare_header_email',
				'sanitize_callback' => 'sanitize_email',
				'label'             => esc_html__( 'Email', 'consultare' ),
				'section'           => 'consultare_header_options',
			)
		);

		Consultare_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'settings'          => 'consultare_header_phone',
				'sanitize_callback' => 'consultare_text_sanitization',
				'label'             => esc_html__( 'Phone', 'consultare' ),
				'section'           => 'consultare_header_options',
			)
		);

		Consultare_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'settings'          => 'consultare_header_address',
				'sanitize_callback' => 'consultare_text_sanitization',
				'label'             => esc_html__( 'Address', 'consultare' ),
				'section'           => 'consultare_header_options',
			)
		);

		Consultare_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'settings'          => 'consultare_header_open_hours',
				'sanitize_callback' => 'consultare_text_sanitization',
				'label'             => esc_html__( 'Open Hours', 'consultare' ),
				'section'           => 'consultare_header_options',
			)
		);

		Consultare_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'settings'          => 'consultare_header_button_text',
				'sanitize_callback' => 'consultare_text_sanitization',
				'label'             => esc_html__( 'Button Text', 'consultare' ),
				'section'           => 'consultare_header_options',
			)
		);

		Consultare_Customizer_Utilities::register_option(
			array(
				'type'              => 'url',
				'settings'          => 'consultare_header_button_link',
				'sanitize_callback' => 'esc_url_raw',
				'label'             => esc_html__( 'Button Link', 'consultare' ),
				'section'           => 'consultare_header_options',
			)
		);

		Consultare_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'Consultare_Toggle_Switch_Custom_control',
				'settings'          => 'consultare_header_button_target',
				'sanitize_callback' => 'consultare_switch_sanitization',
				'label'             => esc_html__( 'Open link in new tab?', 'consultare' ),
				'section'           => 'consultare_header_options',
			)
		);
	}
}

/**
 * Initialize class
 */
$consultare_theme_options = new Consultare_Header_Options();
