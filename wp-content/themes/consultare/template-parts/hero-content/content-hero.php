<?php
/**
 * Template part for displaying Hero Content
 *
 * @package Consultare
 */

$consultare_page = consultare_gtm( 'consultare_hero_content_page' );

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

	$consultare_subtitle = consultare_gtm( 'consultare_hero_content_custom_subtitle' );
	?>

	<div id="hero-content-section" class="hero-content-section section content-position-left default no-video">
		<div class="section-featured-page">
			<div class="container">
				<div class="row">
					<?php if ( has_post_thumbnail() ) : ?>
					<div class="ff-grid-6 featured-page-thumb">
						<div class="featured-page-thumb-wrap">
							<?php the_post_thumbnail( 'consultare-hero', array( 'class' => 'alignnone' ) );?>
						</div>
					</div>
					<?php endif; ?>

					<!-- .ff-grid-6 -->
					<div class="ff-grid-6 featured-page-content">
						<div class="featured-page-section">
							<div class="section-title-wrap">
								<?php if ( $consultare_subtitle ) : ?>
								<p class="section-top-subtitle"><?php echo esc_html( $consultare_subtitle ); ?></p>
								<?php endif; ?>

								<?php the_title( '<h2 class="section-title">', '</h2>' ); ?>
							</div>

							<?php consultare_display_content( 'hero_content' ); ?>
						</div><!-- .featured-page-section -->
					</div><!-- .ff-grid-6 -->
				</div><!-- .row -->
			</div><!-- .container -->
		</div><!-- .section-featured-page -->
	</div><!-- .section -->
<?php
endwhile;

wp_reset_postdata();
