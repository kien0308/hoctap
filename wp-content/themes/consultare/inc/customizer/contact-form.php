<?php
/**
 * Contact Form Options
 *
 * @package Consultare
 */

class Consultare_Contact_Form_Options {
	public function __construct() {
		// Register Contact Form Options.
		add_action( 'customize_register', array( $this, 'register_options' ), 99 );

		// Add default options.
		add_filter( 'consultare_customizer_defaults', array( $this, 'add_defaults' ) );
	}

	/**
	 * Add options to defaults
	 */
	public function add_defaults( $default_options ) {
		$defaults = array(
			'consultare_contact_form_visibility' => 'disabled',
			'consultare_contact_form_type'       => 'page',
		);

		$updated_defaults = wp_parse_args( $defaults, $default_options );

		return $updated_defaults;
	}

	/**
	 * Add layouts section and its controls
	 */
	public function register_options( $wp_customize ) {
		Consultare_Customizer_Utilities::register_option(
			array(
				'settings'          => 'consultare_contact_form_visibility',
				'type'              => 'select',
				'sanitize_callback' => 'consultare_sanitize_select',
				'label'             => esc_html__( 'Visible On', 'consultare' ),
				'section'           => 'consultare_ss_contact_form',
				'choices'           => Consultare_Customizer_Utilities::section_visibility(),
			)
		);

		// Add Edit Shortcut Icon.
		$wp_customize->selective_refresh->add_partial( 'consultare_contact_form_visibility', array(
			'selector' => '#contact-form-section',
		) );

		Consultare_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'sanitize_callback' => 'consultare_text_sanitization',
				'settings'          => 'consultare_contact_form_custom_subtitle',
				'label'             => esc_html__( 'Top Subtitle', 'consultare' ),
				'section'           => 'consultare_ss_contact_form',
				'active_callback'   => array( $this, 'is_section_visible' ),
			)
		);

		Consultare_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'Consultare_Dropdown_Posts_Custom_Control',
				'sanitize_callback' => 'absint',
				'settings'          => 'consultare_contact_form_page',
				'label'             => esc_html__( 'Select Page', 'consultare' ),
				'section'           => 'consultare_ss_contact_form',
				'active_callback'   => array( $this, 'is_section_visible' ),
				'input_attrs' => array(
					'post_type'      => 'page',
					'posts_per_page' => -1,
					'orderby'        => 'name',
					'order'          => 'ASC',
				),
			)
		);
	}

	/**
	 * Contact Form visibility active callback.
	 */
	public function is_section_visible( $control ) {
		return ( consultare_display_section( $control->manager->get_setting( 'consultare_contact_form_visibility' )->value() ) );
	}
}

/**
 * Initialize class
 */
$consultare_ss_contact_form = new Consultare_Contact_Form_Options();
