<?php
/**
 * Template part for displaying Post Types Slider
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Consultare
 */

$consultare_slider_args = consultare_get_section_args( 'slider' );

$consultare_loop = new WP_Query( $consultare_slider_args );

while ( $consultare_loop->have_posts() ) :
	$consultare_loop->the_post();

	$top_subtitle = consultare_gtm( 'consultare_slider_custom_top_subtitle_' . $consultare_loop->current_post );
	?>
	<article id="post-<?php echo esc_attr( get_the_ID() ); ?>" class="swiper-slide type-post caption-animate text-aligncenter <?php echo has_post_thumbnail() ? 'has-post-thumbnail' : ''; ?>">
		<div class="slider-image-wrapper">
			<div class="slider-content-image featured-image">
				<?php
				if ( has_post_thumbnail() ) {
					the_post_thumbnail( 'consultare-slider' );
				} else {
					echo '<img class="wp-post-image no-thumb" src="' . trailingslashit( esc_url( get_template_directory_uri() ) ) . 'images/no-thumb-1920x900.jpg">';
				}
				?>
			</div><!-- .featured-image -->
		</div><!-- .slider-image-wrapper -->

		<div class="slider-content-wrapper">
			<div class="container">
				<div class="slider-title-wrap">
					<?php if ( $top_subtitle ) : ?>
						<h4 class="slider-top-subtitle"><?php echo esc_html( $top_subtitle ); ?></h3>
					<?php endif; ?>
					
					<?php the_title( '<h2 class="slider-title">', '</h2><!-- .slider-title -->' ); ?>
				</div><!-- .slider-title-wrap -->
				
				<div class="slider-content-inner-wrapper">
					<div class="slider-content clear-fix">
						<?php the_excerpt(); ?>
					</div><!-- .entry-content -->
				</div><!-- .slider-content-wrapper -->
			</div><!-- .entry-container -->
		</div><!-- .slider-content-wrapper -->

	</article><!-- .hentry -->
<?php
endwhile;

wp_reset_postdata();
