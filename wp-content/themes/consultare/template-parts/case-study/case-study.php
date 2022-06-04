<?php
/**
 * Template part for displaying Service
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Consultare
 */

$consultare_visibility = consultare_gtm( 'consultare_case_study_visibility' );

if ( ! consultare_display_section( $consultare_visibility ) ) {
	return;
}

$consultare_image = consultare_gtm( 'consultare_case_study_main_image' );
?>
<div id="case-study-section" class="section case-study-section">
	<div class="case-study-inner-wrapper section-case-study">
		<div class="container">
			<div class="case-study-overlap-wrap overlap-enabled">
				<?php if ( $consultare_image ) : ?>
				<div class="ff-grid-6 no-margin no-padding">
					<div class="case-study-thumb">
						<img src="<?php echo esc_url( $consultare_image ); ?>">
					</div><!-- .case-study-thumb -->
				</div><!-- .ff-grid-6 -->
				<?php endif; ?>

				<div class="ff-grid-6 no-margin no-padding">
					<div class="case-study-content">
						<?php consultare_section_title( 'case_study' ); ?>
						<div class="case-study-item-wrapper">
							<?php get_template_part( 'template-parts/case-study/post-type' ); ?>
						</div>
					</div><!-- .case-study-content -->
				</div><!-- .ff-grid-6 -->
			</div><!-- .row -->
		</div><!-- .container -->
	</div><!-- .case-study-inner-wrapper" -->
</div><!-- .section -->
