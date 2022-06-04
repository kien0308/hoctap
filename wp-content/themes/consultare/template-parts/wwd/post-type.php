<?php
/**
 * Template part for displaying Post Types Slider
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Consultare
 */

$consultare_wwd_args = consultare_get_section_args( 'wwd' );

$consultare_loop = new WP_Query( $consultare_wwd_args );

if ( $consultare_loop->have_posts() ) :
	?>
	<div class="wwd-block-list">
		<div class="row">
		<?php
		while ( $consultare_loop->have_posts() ) :
			$consultare_loop->the_post();

			$icon           = consultare_gtm( 'consultare_wwd_custom_icon_' . absint( $consultare_loop->current_post ) );
			$highlight_item = consultare_gtm( 'consultare_wwd_highlight_item_' . absint( $consultare_loop->current_post ) );
			?>
			<div class="wwd-block-item post-type">
				<div class="wwd-block-wrapper inner-block-shadow">
					
					<div class="wwd-block-inner">
						<?php if ( $icon ) : ?>
						<a class="wwd-fonts-icon" href="<?php the_permalink(); ?>" >
							<i class="<?php echo esc_attr( $icon ); ?>"></i>
						</a>
						<?php endif; ?>

						<div class="wwd-block-inner-content">
							<?php the_title( '<h3 class="wwd-item-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">','</a></h3>'); ?>
						</div><!-- .wwd-block-inner-content -->

					</div><!-- .wwd-block-inner -->
				</div><!-- .wwd-block-wrapper -->
			</div><!-- .wwd-block-item -->
		<?php
		endwhile;
		?>
		</div><!-- .row -->
	</div><!-- .wwd-block-list -->
<?php
endif;

wp_reset_postdata();
