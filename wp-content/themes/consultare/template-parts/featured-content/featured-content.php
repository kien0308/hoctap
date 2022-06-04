<?php
/**
 * Template part for displaying Service
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Consultare
 */

$consultare_visibility = consultare_gtm( 'consultare_featured_content_visibility' );

if ( ! consultare_display_section( $consultare_visibility ) ) {
	return;
}
?>
<div id="featured-content-section" class="featured-content-section section page style-two">
	<div class="section-latest-posts">
		<div class="container">
			<?php consultare_section_title( 'featured_content' ); ?>
			
			<div class="section-carousel-wrapper">
			<?php 
				get_template_part( 'template-parts/featured-content/post-type' );

				$consultare_button_text   = consultare_gtm( 'consultare_featured_content_button_text' );
				$consultare_button_link   = consultare_gtm( 'consultare_featured_content_button_link' );
				$consultare_button_target = consultare_gtm( 'consultare_featured_content_button_target' ) ? '_blank' : '_self';

				if ( $consultare_button_text ) : ?>
				<div class="more-wrapper clear-fix">
					<a href="<?php echo esc_url( $consultare_button_link ); ?>" class="ff-button" target="<?php echo esc_attr( $consultare_button_target ); ?>"><?php echo esc_html( $consultare_button_text ); ?></a>
				</div><!-- .more-wrapper -->
				<?php endif; ?>
			</div>
		</div><!-- .container -->
	</div><!-- .latest-posts-section -->
</div><!-- .section-latest-posts -->
