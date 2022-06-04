<?php
/**
 * Template part for displaying Hero Content
 *
 * @package Consultare
 */

$consultare_enable = consultare_gtm( 'consultare_hero_content_visibility' );

if ( ! consultare_display_section( $consultare_enable ) ) {
	return;
}

get_template_part( 'template-parts/hero-content/content-hero' );
