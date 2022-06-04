<?php
/**
 * WWD Options
 *
 * @package Consultare
 */

class Consultare_WWD_Options {
	public function __construct() {
		// Register WWD Options.
		add_action( 'customize_register', array( $this, 'register_options' ), 99 );

		// Add default options.
		add_filter( 'consultare_customizer_defaults', array( $this, 'add_defaults' ) );
	}

	/**
	 * Add options to defaults
	 */
	public function add_defaults( $default_options ) {
		$defaults = array(
			'consultare_wwd_visibility' => 'disabled',
			'consultare_wwd_type'       => 'category',
			'consultare_wwd_style'      => 'style-one',
			'consultare_wwd_number'     => 5,
			'consultare_wwd_layout'     => 5,
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
				'settings'          => 'consultare_wwd_visibility',
				'type'              => 'select',
				'sanitize_callback' => 'consultare_sanitize_select',
				'label'             => esc_html__( 'Visible On', 'consultare' ),
				'section'           => 'consultare_ss_wwd',
				'choices'           => Consultare_Customizer_Utilities::section_visibility(),
			)
		);

		$wp_customize->selective_refresh->add_partial( 'consultare_wwd_visibility', array(
			'selector' => '#wwd-section',
		) );

		Consultare_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'sanitize_callback' => 'consultare_text_sanitization',
				'settings'          => 'consultare_wwd_section_top_subtitle',
				'label'             => esc_html__( 'Section Top Sub-title', 'consultare' ),
				'section'           => 'consultare_ss_wwd',
				'active_callback'   => array( $this, 'is_wwd_visible' ),
			)
		);

		Consultare_Customizer_Utilities::register_option(
			array(
				'settings'          => 'consultare_wwd_section_title',
				'type'              => 'text',
				'sanitize_callback' => 'consultare_text_sanitization',
				'label'             => esc_html__( 'Section Title', 'consultare' ),
				'section'           => 'consultare_ss_wwd',
				'active_callback'   => array( $this, 'is_wwd_visible' ),
			)
		);

		Consultare_Customizer_Utilities::register_option(
			array(
				'settings'          => 'consultare_wwd_section_subtitle',
				'type'              => 'text',
				'sanitize_callback' => 'consultare_text_sanitization',
				'label'             => esc_html__( 'Section Subtitle', 'consultare' ),
				'section'           => 'consultare_ss_wwd',
				'active_callback'   => array( $this, 'is_wwd_visible' ),
			)
		);

		Consultare_Customizer_Utilities::register_option(
			array(
				'settings'          => 'consultare_wwd_number',
				'type'              => 'number',
				'label'             => esc_html__( 'Number', 'consultare' ),
				'description'       => esc_html__( 'Please refresh the customizer page once the number is changed.', 'consultare' ),
				'section'           => 'consultare_ss_wwd',
				'sanitize_callback' => 'absint',
				'input_attrs'       => array(
					'min'   => 1,
					'max'   => 80,
					'step'  => 1,
					'style' => 'width:100px;',
				),
				'active_callback'   => array( $this, 'is_wwd_visible' ),
			)
		);

		$numbers = consultare_gtm( 'consultare_wwd_number' );

		Consultare_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'Consultare_Simple_Notice_Custom_Control',
				'sanitize_callback' => 'sanitize_text_field',
				'settings'          => 'consultare_wwd_icon_note',
				'label'             =>  esc_html__( 'Info', 'consultare' ),
				'description'       =>  sprintf( esc_html__( 'If you want camera icon, save "fas fa-camera". For more classs, check %1$sthis%2$s. ', 'consultare' ), '<a href="https://fontawesome.com/icons?d=gallery&m=free" target="_blank">', '</a>' ),
				'section'           => 'consultare_ss_wwd',
				'active_callback'   => array( $this, 'is_wwd_visible' ),
			)
		);

		for( $i = 0, $j = 1; $i < $numbers; $i++, $j++ ) {
			Consultare_Customizer_Utilities::register_option(
				array(
					'custom_control'    => 'Consultare_Simple_Notice_Custom_Control',
					'sanitize_callback' => 'consultare_text_sanitization',
					'settings'          => 'consultare_wwd_notice_' . $i,
					'label'             => esc_html__( 'Item #', 'consultare' )  . $j,
					'section'           => 'consultare_ss_wwd',
					'active_callback'   => array( $this, 'is_wwd_visible' ),
				)
			);

			Consultare_Customizer_Utilities::register_option(
				array(
					'custom_control'    => 'Consultare_Dropdown_Posts_Custom_Control',
					'sanitize_callback' => 'absint',
					'settings'          => 'consultare_wwd_page_' . $i,
					'label'             => esc_html__( 'Select Page', 'consultare' ),
					'section'           => 'consultare_ss_wwd',
					'active_callback'   => array( $this, 'is_wwd_visible' ),
					'input_attrs' => array(
						'post_type'      => 'page',
						'posts_per_page' => -1,
						'orderby'        => 'name',
						'order'          => 'ASC',
					),
				)
			);

			Consultare_Customizer_Utilities::register_option(
				array(
					'sanitize_callback' => 'sanitize_text_field',
					'settings'          => 'consultare_wwd_custom_icon_' . $i,
					'label'             => esc_html__( 'Icon Class', 'consultare' ),
					'section'           => 'consultare_ss_wwd',
					'active_callback'   => array( $this, 'is_wwd_visible' ),
				)
			);
		}
	}

	/**
	 * WWD visibility active callback.
	 */
	public function is_wwd_visible( $control ) {
		return ( consultare_display_section( $control->manager->get_setting( 'consultare_wwd_visibility' )->value() ) );
	}
}

/**
 * Initialize class
 */
$consultare_ss_wwd = new Consultare_WWD_Options();
