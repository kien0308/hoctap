<?php
/**
 * Consultare Theme Customizer
 *
 * @package Consultare
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function consultare_customizer_sections( $wp_customize ) {
	$wp_customize->add_panel( 'consultare_sp_sortable', array(
		'title'       => esc_html__( 'Sections', 'consultare' ),
		'priority'    => 150,
	) );

	$default_sections = consultare_get_default_sortable_sections();

	foreach ( $default_sections as $key => $section ) {
		// Add sections.
		$wp_customize->add_section( 'consultare_ss_' . $key,
			array(
				'title' => $section,
				'panel' => 'consultare_sp_sortable'
			)
		);
	}
}
add_action( 'customize_register', 'consultare_customizer_sections', 1 );

/**
 * Default sortable sections order
 * @return array
 */
function consultare_get_default_sortable_sections() {
	return $default_sections = array (
		'slider'               => esc_html__( 'Slider', 'consultare' ),
		'wwd'                  => esc_html__( 'What We Do', 'consultare' ),
		'hero_content'         => esc_html__( 'Hero Content', 'consultare' ),
		'promotional_headline' => esc_html__( 'Promotion Headline One', 'consultare' ),
		'case_study'           => esc_html__( 'Case Study', 'consultare' ),
		'featured_content'     => esc_html__( 'Featured Content', 'consultare' ),
		'contact_form'         => esc_html__( 'Contact Form', 'consultare' ),
	);
}
