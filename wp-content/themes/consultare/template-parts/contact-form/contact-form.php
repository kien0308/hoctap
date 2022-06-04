<?php
/**
 * Template part for displaying Hero Content
 *
 * @package Consultare
 */

$consultare_visibility = consultare_gtm( 'consultare_contact_form_visibility' );

if ( ! consultare_display_section( $consultare_visibility ) ) {
	return;
}

get_template_part( 'template-parts/contact-form/content-contact' );
