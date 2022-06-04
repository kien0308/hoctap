<?php
/**
 * Slider Options
 *
 * @package Consultare
 */

class Consultare_Slider_Options {
	public function __construct() {
		// Register Slider Options.
		add_action( 'customize_register', array( $this, 'register_options' ), 98 );

		// Add default options.
		add_filter( 'consultare_customizer_defaults', array( $this, 'add_defaults' ) );
	}

	/**
	 * Add options to defaults
	 */
	public function add_defaults( $default_options ) {
		$defaults = array(
			'consultare_slider_visibility' => 'disabled',
			'consultare_slider_number'     => 2,
		);

		$updated_defaults = wp_parse_args( $defaults, $default_options );

		return $updated_defaults;
	}

	/**
	 * Add slider section and its controls
	 */
	public function register_options( $wp_customize ) {
		Consultare_Customizer_Utilities::register_option(
			array(
				'settings'          => 'consultare_slider_visibility',
				'type'              => 'select',
				'sanitize_callback' => 'consultare_sanitize_select',
				'label'             => esc_html__( 'Visible On', 'consultare' ),
				'section'           => 'consultare_ss_slider',
				'choices'           => Consultare_Customizer_Utilities::section_visibility(),
			)
		);

		$wp_customize->selective_refresh->add_partial( 'consultare_slider_visibility', array(
			'selector' => '#slider-section',
		) );

		Consultare_Customizer_Utilities::register_option(
			array(
				'type'              => 'number',
				'settings'          => 'consultare_slider_number',
				'label'             => esc_html__( 'Number', 'consultare' ),
				'description'       => esc_html__( 'Please refresh the customizer page once the number is changed.', 'consultare' ),
				'section'           => 'consultare_ss_slider',
				'sanitize_callback' => 'absint',
				'input_attrs'       => array(
					'min'   => 1,
					'max'   => 80,
					'step'  => 1,
					'style' => 'width:100px;',
				),
				'active_callback'   => array( $this, 'is_slider_visible' ),
			)
		);

		$numbers = consultare_gtm( 'consultare_slider_number' );

		for( $i = 0, $j = 1; $i < $numbers; $i++, $j++ ) {
			Consultare_Customizer_Utilities::register_option(
				array(
					'custom_control'    => 'Consultare_Simple_Notice_Custom_Control',
					'sanitize_callback' => 'consultare_text_sanitization',
					'settings'          => 'consultare_slider_notice_' . $i,
					'label'             => esc_html__( 'Item #', 'consultare' )  . $j,
					'section'           => 'consultare_ss_slider',
					'active_callback'   => array( $this, 'is_slider_visible' ),
					'transport'         => 'postMessage',
				)
			);

			Consultare_Customizer_Utilities::register_option(
				array(
					'custom_control'    => 'Consultare_Dropdown_Posts_Custom_Control',
					'sanitize_callback' => 'absint',
					'settings'          => 'consultare_slider_page_' . $i,
					'label'             => esc_html__( 'Select Page', 'consultare' ),
					'section'           => 'consultare_ss_slider',
					'active_callback'   => array( $this, 'is_slider_visible' ),
					'input_attrs'       => array(
						'post_type'      => 'page',
						'posts_per_page' => -1,
						'orderby'        => 'name',
						'order'          => 'ASC',
					),
				)
			);

			Consultare_Customizer_Utilities::register_option(
				array(
					'type'              => 'text',
					'sanitize_callback' => 'consultare_text_sanitization',
					'settings'          => 'consultare_slider_custom_top_subtitle_' . $i,
					'label'             => esc_html__( 'Top Subtitle', 'consultare' ),
					'section'           => 'consultare_ss_slider',
					'active_callback'   => array( $this, 'is_slider_visible' ),
				)
			);
		}
	}

	/**
	 * Slider visibility active callback.
	 */
	public function is_slider_visible( $control ) {
		return ( consultare_display_section( $control->manager->get_setting( 'consultare_slider_visibility' )->value() ) );
	}
}

/**
 * Initialize class
 */
$consultare_ss_slider = new Consultare_Slider_Options();
