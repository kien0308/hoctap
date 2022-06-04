<?php
/**
 * Template part for displaying Hero Content
 *
 * @package Consultare
 */

$consultare_visibility = consultare_gtm( 'consultare_promotional_headline_visibility' );

if ( ! consultare_display_section( $consultare_visibility ) ) {
	return;
}

get_template_part( 'template-parts/promotional-headline/post-type' );
