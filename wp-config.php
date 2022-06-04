<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'hoctap' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'HHaN1LlO 2+I;F0G-WAvBU=-f^IH9-h(Y#{AH%C{E;*V#!eB{xv6T~`?(X2j3Wv;' );
define( 'SECURE_AUTH_KEY',  '$?=KW{*,LJV=lgSbR>?x>^f#qF?(i?y0LBk]0p~[8i,pdlMpeMk~*@T#f,aKz-mq' );
define( 'LOGGED_IN_KEY',    '}$QSLHP38^#KaIXwHVlBDreg7?5}4spd;F_3Y|t&/c:rz0TXb3?z*Psap7.2<[t*' );
define( 'NONCE_KEY',        '/.4~&4]=Q9KrPB7vXj?=]xB>E%m;rT2/kFSvZAS#cXE.r)+>2glfAKHN}qf`U;%V' );
define( 'AUTH_SALT',        'cpAymL?]ueR=9Xyw6g[;,*F,d!jw`IU=p*$&_BEh`)-FjgCF[CLj[n9o!XjM#L2+' );
define( 'SECURE_AUTH_SALT', 'Kuh%`wW7eS^5F$+v_^>$Gu9Sl;H*9(;-.`U5mgHI{b7zlab>-nrz6eyQ.Hr:C4-N' );
define( 'LOGGED_IN_SALT',   'EPC3uzQ#f]uEMRJ,,UecxWL6o&WJ/c`sg:nl/Y.n;*@?kE?f3SI94b4?xCK2Zy f' );
define( 'NONCE_SALT',       'h<h(:)&!E7auZ-}YV9sdp5C.PNJMs[:MP|]6$<WEZff%MyIP!T{wQ(6PBQjbqKSV' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
