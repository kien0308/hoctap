<?php
/**
 * Template part for displaying Service
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Consultare
 */

$consultare_visibility = consultare_gtm( 'consultare_wwd_visibility' );

if ( ! consultare_display_section( $consultare_visibility ) ) {
	return;
}

$consultare_bg_image = consultare_gtm( 'consultare_wwd_bg_image' );
?>
<div id="wwd-section" class="wwd-section section page style-one layout-5" <?php echo $consultare_bg_image ? 'style="background-image: url( ' . esc_url( $consultare_bg_image ) . ' )"' : ''; ?>>
	<div class="section-wwd">
		<div class="container">
			<?php consultare_section_title( 'wwd' ); ?>
			
			<div class="section-carousel-wrapper">
			    <?php get_template_part( 'template-parts/wwd/post-type' ); ?>
			</div>
		</div><!-- .container -->
	</div><!-- .section-wwd  -->
</div><!-- .section -->
