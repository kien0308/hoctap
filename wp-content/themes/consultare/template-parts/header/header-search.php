<?php
/**
 * Header Search
 *
 * @package Consultare
 */

$args = wp_parse_args(
    $args,
    array(
		'pull-class' => 'pull-left',
    )
);

?>
<div class="header-search <?php echo esc_attr( $args['pull-class'] ); ?>">
	<div class="primary-search-wrapper">
		<a href="#" class="search-toggle"><span class="screen-reader-text"><?php esc_html_e( 'Search', 'consultare' ); ?></span><i class="fas fa-search"></i><i class="far fa-times-circle"></i></a>
		<div class="search-container displaynone">
			<?php get_search_form(); ?>
		</div><!-- #search-container -->
	</div><!-- .primary-search-wrapper -->
</div><!-- .header-search -->
