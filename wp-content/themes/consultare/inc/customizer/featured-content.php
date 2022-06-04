<?php
/**
 * Featured Content Options
 *
 * @package Consultare
 */

class Consultare_Featured_Content_Options {
	public function __construct() {
		// Register Featured Content Options.
		add_action( 'customize_register', array( $this, 'register_options' ), 99 );

		// Add default options.
		add_filter( 'consultare_customizer_defaults', array( $this, 'add_defaults' ) );
	}

	/**
	 * Add options to defaults
	 */
	public function add_defaults( $default_options ) {
		$defaults = array(
			'consultare_featured_content_visibility'  => 'disabled',
			'consultare_featured_content_number'      => 3,
			'consultare_featured_content_button_link' => '#',
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
				'settings'          => 'consultare_featured_content_visibility',
				'type'              => 'select',
				'sanitize_callback' => 'consultare_sanitize_select',
				'label'             => esc_html__( 'Visible On', 'consultare' ),
				'section'           => 'consultare_ss_featured_content',
				'choices'           => Consultare_Customizer_Utilities::section_visibility(),
			)
		);

		// Add Edit Shortcut Icon.
		$wp_customize->selective_refresh->add_partial( 'consultare_featured_content_visibility', array(
			'selector' => '#featured-content-section',
		) );

		Consultare_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'sanitize_callback' => 'consultare_text_sanitization',
				'settings'          => 'consultare_featured_content_section_top_subtitle',
				'label'             => esc_html__( 'Section Top Sub-title', 'consultare' ),
				'section'           => 'consultare_ss_featured_content',
				'active_callback'   => array( $this, 'is_section_visible' ),
			)
		);

		Consultare_Customizer_Utilities::register_option(
			array(
				'settings'          => 'consultare_featured_content_section_title',
				'type'              => 'text',
				'sanitize_callback' => 'consultare_text_sanitization',
				'label'             => esc_html__( 'Section Title', 'consultare' ),
				'section'           => 'consultare_ss_featured_content',
				'active_callback'   => array( $this, 'is_section_visible' ),
			)
		);

		Consultare_Customizer_Utilities::register_option(
			array(
				'settings'          => 'consultare_featured_content_section_subtitle',
				'type'              => 'text',
				'sanitize_callback' => 'consultare_text_sanitization',
				'label'             => esc_html__( 'Section Subtitle', 'consultare' ),
				'section'           => 'consultare_ss_featured_content',
				'active_callback'   => array( $this, 'is_section_visible' ),
			)
		);

		Consultare_Customizer_Utilities::register_option(
			array(
				'settings'          => 'consultare_featured_content_number',
				'type'              => 'number',
				'label'             => esc_html__( 'Number', 'consultare' ),
				'description'       => esc_html__( 'Please refresh the customizer page once the number is changed.', 'consultare' ),
				'section'           => 'consultare_ss_featured_content',
				'sanitize_callback' => 'absint',
				'input_attrs'       => array(
					'min'   => 1,
					'max'   => 80,
					'step'  => 1,
					'style' => 'width:100px;',
				),
				'active_callback'   => array( $this, 'is_section_visible' ),
			)
		);

		$numbers = consultare_gtm( 'consultare_featured_content_number' );

		for( $i = 0, $j = 1; $i < $numbers; $i++, $j++ ) {
			Consultare_Customizer_Utilities::register_option(
				array(
					'custom_control'    => 'Consultare_Dropdown_Posts_Custom_Control',
					'sanitize_callback' => 'absint',
					'settings'          => 'consultare_featured_content_page_' . $i,
					'label'             => esc_html__( 'Page #', 'consultare' )  . $j,
					'section'           => 'consultare_ss_featured_content',
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

		Consultare_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'sanitize_callback' => 'consultare_text_sanitization',
				'settings'          => 'consultare_featured_content_button_text',
				'label'             => esc_html__( 'Button Text', 'consultare' ),
				'section'           => 'consultare_ss_featured_content',
				'active_callback'   => array( $this, 'is_section_visible' ),
			)
		);

		Consultare_Customizer_Utilities::register_option(
			array(
				'type'              => 'url',
				'sanitize_callback' => 'esc_url_raw',
				'settings'          => 'consultare_featured_content_button_link',
				'label'             => esc_html__( 'Button Link', 'consultare' ),
				'section'           => 'consultare_ss_featured_content',
				'active_callback'   => array( $this, 'is_section_visible' ),
			)
		);

		Consultare_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'Consultare_Toggle_Switch_Custom_control',
				'settings'          => 'consultare_featured_content_button_target',
				'sanitize_callback' => 'consultare_switch_sanitization',
				'label'             => esc_html__( 'Open link in new tab?', 'consultare' ),
				'section'           => 'consultare_ss_featured_content',
				'active_callback'   => array( $this, 'is_section_visible' ),
			)
		);
	}

	/**
	 * Featured Content visibility active callback.
	 */
	public function is_section_visible( $control ) {
		return ( consultare_display_section( $control->manager->get_setting( 'consultare_featured_content_visibility' )->value() ) );
	}
}

/**
 * Initialize class
 */
$consultare_ss_featured_content = new Consultare_Featured_Content_Options();
