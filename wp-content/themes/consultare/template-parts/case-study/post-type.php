<?php
/**
 * Template part for displaying Post Types Slider
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Consultare
 */

$consultare_args = consultare_get_section_args( 'case_study' );

$consultare_loop = new WP_Query( $consultare_args );

if ( $consultare_loop->have_posts() ) :
	while ( $consultare_loop->have_posts() ) :
		$consultare_loop->the_post();
		?>
		
			<div class="case-study-item">
				<?php the_title( '<h3 class="case-study-item-title">','</h3>'); ?>
				
				<div class="item-content">
					<?php consultare_display_content( 'case_study' ); ?>
				</div><!-- .item-content -->
			</div><!-- .case-study-item -->
		<?php
	endwhile;
endif;

wp_reset_postdata();
