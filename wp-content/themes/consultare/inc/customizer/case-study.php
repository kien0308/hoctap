<?php
/**
 * Case_Study Options
 *
 * @package Consultare
 */

class Consultare_Case_Study_Options {
	public function __construct() {
		// Register Case_Study Options.
		add_action( 'customize_register', array( $this, 'register_options' ), 99 );

		// Add default options.
		add_filter( 'consultare_customizer_defaults', array( $this, 'add_defaults' ) );
	}

	/**
	 * Add options to defaults
	 */
	public function add_defaults( $default_options ) {
		$defaults = array(
			'consultare_case_study_visibility' => 'disabled',
			'consultare_case_study_number'     => 3,
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
				'settings'          => 'consultare_case_study_visibility',
				'type'              => 'select',
				'sanitize_callback' => 'consultare_sanitize_select',
				'label'             => esc_html__( 'Visible On', 'consultare' ),
				'section'           => 'consultare_ss_case_study',
				'choices'           => Consultare_Customizer_Utilities::section_visibility(),
			)
		);

		$wp_customize->selective_refresh->add_partial( 'consultare_case_study_visibility', array(
			'selector' => '#case-study-section',
		) );

		Consultare_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'sanitize_callback' => 'consultare_text_sanitization',
				'settings'          => 'consultare_case_study_section_top_subtitle',
				'label'             => esc_html__( 'Section Top Sub-title', 'consultare' ),
				'section'           => 'consultare_ss_case_study',
				'active_callback'   => array( $this, 'is_case_study_visible' ),
			)
		);

		Consultare_Customizer_Utilities::register_option(
			array(
				'settings'          => 'consultare_case_study_section_title',
				'type'              => 'text',
				'sanitize_callback' => 'consultare_text_sanitization',
				'label'             => esc_html__( 'Section Title', 'consultare' ),
				'section'           => 'consultare_ss_case_study',
				'active_callback'   => array( $this, 'is_case_study_visible' ),
			)
		);

		Consultare_Customizer_Utilities::register_option(
			array(
				'settings'          => 'consultare_case_study_section_subtitle',
				'type'              => 'text',
				'sanitize_callback' => 'consultare_text_sanitization',
				'label'             => esc_html__( 'Section Subtitle', 'consultare' ),
				'section'           => 'consultare_ss_case_study',
				'active_callback'   => array( $this, 'is_case_study_visible' ),
			)
		);

		Consultare_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'WP_Customize_Image_Control',
				'sanitize_callback' => 'esc_url_raw',
				'settings'          => 'consultare_case_study_main_image',
				'label'             => esc_html__( 'Main Image', 'consultare' ),
				'section'           => 'consultare_ss_case_study',
				'active_callback'   => array( $this, 'is_case_study_visible' ),
			)
		);

		Consultare_Customizer_Utilities::register_option(
			array(
				'settings'          => 'consultare_case_study_number',
				'type'              => 'number',
				'label'             => esc_html__( 'Number', 'consultare' ),
				'description'       => esc_html__( 'Please refresh the customizer page once the number is changed.', 'consultare' ),
				'section'           => 'consultare_ss_case_study',
				'sanitize_callback' => 'absint',
				'input_attrs'       => array(
					'min'   => 1,
					'max'   => 80,
					'step'  => 1,
					'style' => 'width:100px;',
				),
				'active_callback'   => array( $this, 'is_case_study_visible' ),
			)
		);

		$numbers = consultare_gtm( 'consultare_case_study_number' );

		for( $i = 0, $j = 1; $i < $numbers; $i++, $j++ ) {
			Consultare_Customizer_Utilities::register_option(
				array(
					'custom_control'    => 'Consultare_Dropdown_Posts_Custom_Control',
					'sanitize_callback' => 'absint',
					'settings'          => 'consultare_case_study_page_' . $i,
					'label'             => esc_html__( 'Page #', 'consultare' )  . $j,
					'section'           => 'consultare_ss_case_study',
					'active_callback'   => array( $this, 'is_case_study_visible' ),
					'input_attrs' => array(
						'post_type'      => 'page',
						'posts_per_page' => -1,
						'orderby'        => 'name',
						'order'          => 'ASC',
					),
				)
			);
		}
	}

	/**
	 * Case_Study visibility active callback.
	 */
	public function is_case_study_visible( $control ) {
		return ( consultare_display_section( $control->manager->get_setting( 'consultare_case_study_visibility' )->value() ) );
	}
}

/**
 * Initialize class
 */
$consultare_ss_case_study = new Consultare_Case_Study_Options();
