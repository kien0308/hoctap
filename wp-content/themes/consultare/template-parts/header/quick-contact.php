<?php
/**
 * Header Search
 *
 * @package Consultare
 */

$consultare_phone      = consultare_gtm( 'consultare_header_phone' );
$consultare_email      = consultare_gtm( 'consultare_header_email' );
$consultare_address    = consultare_gtm( 'consultare_header_address' );
$consultare_open_hours = consultare_gtm( 'consultare_header_open_hours' );

if ( $consultare_phone || $consultare_email || $consultare_address || $consultare_open_hours ) : ?>
	<div class="inner-quick-contact">
		<ul>
			<?php if ( $consultare_phone ) : ?>
				<li class="quick-call">
					<span><?php esc_html_e( 'Phone', 'consultare' ); ?></span><a href="tel:<?php echo preg_replace( '/\s+/', '', esc_attr( $consultare_phone ) ); ?>"><?php echo esc_html( $consultare_phone ); ?></a> </li>
			<?php endif; ?>

			<?php if ( $consultare_email ) : ?>
				<li class="quick-email"><span><?php esc_html_e( 'Email', 'consultare' ); ?></span><a href="<?php echo esc_url( 'mailto:' . esc_attr( antispambot( $consultare_email ) ) ); ?>"><?php echo esc_html( antispambot( $consultare_email ) ); ?></a> </li>
			<?php endif; ?>

			<?php if ( $consultare_address ) : ?>
				<li class="quick-address"><span><?php esc_html_e( 'Address', 'consultare' ); ?></span><?php echo esc_html( $consultare_address ); ?></li>
			<?php endif; ?>

			<?php if ( $consultare_open_hours ) : ?>
				<li class="quick-open-hours"><span><?php esc_html_e( 'Open Hours', 'consultare' ); ?></span><?php echo esc_html( $consultare_open_hours ); ?></li>
			<?php endif; ?>
		</ul>
	</div><!-- .inner-quick-contact -->
<?php endif; ?>

