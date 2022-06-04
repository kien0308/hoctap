<?php
/**
 * Template part for displaying Slider
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Consultare
 */

$consultare_visibility = consultare_gtm( 'consultare_slider_visibility' );

if ( ! consultare_display_section( $consultare_visibility ) ) {
	return;
}
?>
<div id="slider-section" class="section slider-section no-padding style-one overlay-enabled">
	<div class="swiper-wrapper">
		<?php get_template_part( 'template-parts/slider/post-type' ); ?>
	</div><!-- .swiper-wrapper -->

    <div class="swiper-pagination"></div>

    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
</div><!-- .main-slider -->
