<?php
/**
 * Template part for displaying Hero Content
 *
 * @package Consultare
 */

$consultare_page = consultare_gtm( 'consultare_contact_form_page' );

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

	$subtitle = consultare_gtm( 'consultare_contact_form_custom_subtitle' );
	?>
	<div id="contact-form-section" class="section">
		<div class="contact-form-section">
			<div class="container">
				<div class="section-contact">
					<div class="custom-contact-form">
						<div class="section-title-wrap">
							<?php if ( $subtitle ) : ?>
								<p class="section-top-subtitle"><?php echo esc_html( $subtitle ); ?></p>
							<?php endif; ?>
							
							<?php the_title( '<h2 class="section-title">', '</h2>' ); ?>
						</div><!-- .section-title-wrap -->

						<div class="form-section clear-fix">
							<?php the_content(); ?>
						</div>
					</div><!-- .custom-contact-form -->
				</div><!-- .section-contact -->
			</div><!-- .container -->
		</div>
	</div><!-- .section -->
<?php
endwhile;

wp_reset_postdata();
