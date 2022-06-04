<?php
/**
 * Template part for displaying Post Types Slider
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Consultare
 */

$consultare_args = consultare_get_section_args( 'featured_content' );

$consultare_loop = new WP_Query( $consultare_args );

if ( $consultare_loop->have_posts() ) :
	$consultare_layout = consultare_gtm( 'consultare_featured_content_layout' );
	?>
	<div class="featured-content-block-list">
		<div class="row">
			<?php
			while ( $consultare_loop->have_posts() ) :
				$consultare_loop->the_post();
				?>
				<div class="latest-posts-item ff-grid-4">
					<div class="latest-posts-wrapper inner-block-shadow">
						<?php
						$consultare_cats = consultare_get_featured_content_cats();

						if ( has_post_thumbnail() || $consultare_cats ) : ?>
						<div class="latest-posts-thumb">
							<?php if ( has_post_thumbnail() ) : ?>
							<a class="image-hover-zoom" href="<?php the_permalink(); ?>" >
								<?php the_post_thumbnail(); ?>
							</a>
							<?php endif;

							if ( $consultare_cats ) {
								echo $consultare_cats;
							}
							?>
						</div><!-- latest-posts-thumb  -->
						<?php endif; ?>

						<div class="latest-posts-text-content-wrapper">
							<div class="latest-posts-text-content">
								<?php the_title( '<h3 class="latest-posts-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">','</a></h3>'); ?>
								<?php consultare_featured_content_meta();  ?>

								<?php consultare_display_content( 'featured_content' ); ?>
							</div><!-- .latest-posts-text-content -->
						</div><!-- .latest-posts-text-content-wrapper -->
					</div><!-- .latest-posts-wrapper -->
				</div><!-- .latest-posts-item -->
			<?php endwhile; ?>
		</div><!-- .row -->
	</div><!-- .featured-content-block-list -->
<?php
endif;

wp_reset_postdata();
