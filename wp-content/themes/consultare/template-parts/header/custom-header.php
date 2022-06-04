<?php
/**
 * Displays header site branding
 *
 * @package Consultare
 */
$consultare_enable = consultare_gtm( 'consultare_header_image_visibility' );

if ( consultare_display_section( $consultare_enable ) ) : ?>
<div id="custom-header">
	<?php is_header_video_active() && has_header_video() ? the_custom_header_markup() : ''; ?>

	<div class="custom-header-content">
		<div class="container">
			<?php consultare_header_title(); ?>

			<?php get_template_part( 'template-parts/header/breadcrumb' ); ?>
		</div> <!-- .container -->
	</div>  <!-- .custom-header-content -->
</div>
<?php
endif;
