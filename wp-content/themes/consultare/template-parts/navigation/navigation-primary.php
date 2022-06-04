<?php
/**
 * Displays Primary Navigation
 *
 * @package Consultare
 */
?>

<button id="primary-menu-toggle" class="menu-primary-toggle menu-toggle" aria-controls="primary-menu" aria-expanded="false">
	<i class="fas fa-bars"></i><span class="menu-label"><?php esc_html_e( 'Menu', 'consultare' ); ?></span>
</button>

<div id="site-header-menu" class="site-primary-menu">
	<nav id="site-primary-navigation" class="main-navigation site-navigation custom-primary-menu" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'consultare' ); ?>">
		<?php wp_nav_menu( array(
			'theme_location'	=> 'menu-1',
			'container_class'	=> 'primary-menu-container',
			'menu_class'		=> 'primary-menu',
		) ); ?>
	</nav><!-- #site-primary-navigation.custom-primary-menu -->
</div><!-- .site-header-main -->
