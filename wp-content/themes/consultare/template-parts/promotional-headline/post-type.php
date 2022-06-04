<?php
/**
 * Template part for displaying Hero Content
 *
 * @package Consultare
 */

$consultare_page = consultare_gtm( 'consultare_promotional_headline_page' );

if ( ! $consultare_page ) {
	return;
}

$consultare_args = array(
	'page_id'        => absint( $consultare_page ),
	'posts_per_page' => 1,
);

$consultare_loop = new WP_Query( $consultare_args );

while ( $consultare_loop->have_posts() ) :
	$consultare_loop->the_post();

	$top_subtitle = consultare_gtm( 'consultare_promotional_headline_section_top_subtitle' );
	$subtitle     = consultare_gtm( 'consultare_promotional_headline_section_subtitle' );
	?>

	<div id="promotional-headline-section-one" class="section promotional-headline-section-one promotional-headline-section text-aligncenter overlay-enabled" <?php echo has_post_thumbnail() ? 'style="background-image: url( ' .esc_url( get_the_post_thumbnail_url() ) . ' )"' : ''; ?>>
	<div class="promotion-inner-wrapper section-promotion">
		<div class="container">
			<div class="promotion-content">
				<div class="promotion-description">
					<div class="section-title-wrap">
						<?php if ( $subtitle ) : ?>
						<p class="section-top-subtitle"><?php echo esc_html( $subtitle ); ?></p>
						<?php endif; ?>

						<?php the_title( '<h2 class="section-title">', '</h2>' ); ?>

						<?php if ( $subtitle ) : ?>
						<p class="section-subtitle"><?php echo esc_html( $subtitle ); ?></p>
						<?php endif; ?>
					</div>

					<?php consultare_display_content( 'promotional_headline' ); ?>
				</div><!-- .promotion-description -->
			</div><!-- .promotion-content -->
		</div><!-- .container -->
	</div><!-- .promotion-inner-wrapper" -->
</div><!-- .section -->
<?php
endwhile;

wp_reset_postdata();
