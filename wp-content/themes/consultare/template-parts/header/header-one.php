<?php
/**
 * Header One Style Template
 *
 * @package Consultare
 */
$consultare_header_top_text = consultare_gtm( 'consultare_header_top_text' );
$consultare_phone           = consultare_gtm( 'consultare_header_phone' );
$consultare_email           = consultare_gtm( 'consultare_header_email' );
$consultare_address         = consultare_gtm( 'consultare_header_address' );
$consultare_open_hours      = consultare_gtm( 'consultare_header_open_hours' );
$consultare_button_text     = consultare_gtm( 'consultare_header_button_text' );
$consultare_button_link     = consultare_gtm( 'consultare_header_button_link' );
$consultare_button_target   = consultare_gtm( 'consultare_header_button_target' ) ? '_blank' : '_self';
?>
<div class="header-wrapper  main-header-one<?php echo ! $consultare_button_text ? ' button-disabled' : ''; ?>">
	<div id="top-header" class="dark-top-header main-top-header-one">
		<?php if ( $consultare_header_top_text ) : ?>
			<div id="quick-info" class="mobile-on">
            	<p><?php echo esc_html( $consultare_header_top_text ); ?></p>
			</div>
		<?php endif; ?>
		
		<?php get_template_part( 'template-parts/header/mobile-header-top' ); ?>

		<div class="site-top-header">
			<div class="container">
				<?php if ( $consultare_header_top_text ) : ?>
					<div id="quick-info" class="pull-left">
	                	<p><?php echo esc_html( $consultare_header_top_text ); ?></p>
					</div>
				<?php endif; ?>
				<?php if ( has_nav_menu( 'social' ) ): ?>
				<div class="top-head-right pull-left">
					<?php if ( has_nav_menu( 'social' ) ): ?>
					<div id="top-social" class="pull-left">
						<div class="social-nav">
							<nav id="social-primary-navigation" class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Social Links Menu', 'consultare' ); ?>">
								<?php
									wp_nav_menu( array(
										'theme_location' => 'social',
										'menu_class'     => 'social-links-menu',
										'depth'          => 1,
										'link_before'    => '<span class="screen-reader-text">',
									) );
								?>
							</nav><!-- .social-navigation -->
						</div>
					</div><!-- #top-social -->
					<?php endif; ?>
				</div><!-- .top-head-right -->
				<?php endif; ?>
				<?php if ( $consultare_phone || $consultare_email || $consultare_address || $consultare_open_hours ) : ?>
				<div id="quick-contact" class="pull-right">
					<?php get_template_part( 'template-parts/header/quick-contact' ); ?>
				</div>
				<?php endif; ?>
			</div><!-- .container -->
		</div><!-- .site-top-header -->
	</div><!-- #top-header -->
	
	<header id="masthead" class="site-header main-header-one  clear-fix">
		<div class="site-header-main">
			<div class="container">
				<div class="site-branding">
					<?php get_template_part( 'template-parts/header/site-branding' ); ?>
				</div><!-- .site-branding -->

				<div class="right-head pull-right">
					<div id="main-nav" class="pull-left mobile-off">
						<?php get_template_part( 'template-parts/navigation/navigation-primary' ); ?>
					</div><!-- .main-nav -->

					<div class="head-search-cart-wrap mobile-off pull-left">
						<?php get_template_part( 'template-parts/header/header-search' ); ?>
					</div><!-- .head-search-cart-wrap -->
					<?php if ( $consultare_button_text ) : ?>
						<a target="<?php echo esc_attr( $consultare_button_target );?>" href="<?php echo esc_url( $consultare_button_link );?>" class="ff-button header-button pull-right"><?php echo esc_html( $consultare_button_text );?></a>
					<?php endif; ?>
				</div><!-- .right-head -->
			</div><!-- .container -->
		</div><!-- .site-header-main -->
	</header><!-- #masthead -->
</div><!-- .header-wrapper -->
