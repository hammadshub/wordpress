<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'htmltopdf' );

/** Database username */
define( 'DB_USER', 'htmltopdf' );

/** Database password */
define( 'DB_PASSWORD', 'htmltopdf123' );

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
define( 'AUTH_KEY',         'q^S`>W,XpcXv_E~Z/FNha%9Eaxj>]#)Q1$&40+41p9w=Ojx`KYx%NrVM+sJ}#]z5' );
define( 'SECURE_AUTH_KEY',  'A3rHNfwFd/F0k`8cLy1M?;&Uhl1BT5]=qF`owq).Vpe`=-0fcBOY|oGJ(2owhmHd' );
define( 'LOGGED_IN_KEY',    'uQ[/1]*HbB5VEu7IqLsIW9-q0N^U1tY)*ODAO-7yvosAs*q9QrR2)&`m8CzYEX.3' );
define( 'NONCE_KEY',        '`-lzsI$&F&Nu1dupp]4~sImQh6 U^+kXE~2C 7}n!9UFLzBvz(VK7d( aziSnazR' );
define( 'AUTH_SALT',        'v$.l4]1y$3n)lgx798mFtjPrVrl|%}C^d AaRCP+9_E#NViGVta&t)1dM<J][4Ww' );
define( 'SECURE_AUTH_SALT', 'Z&.1f4Eyo4DTbx7$w~6VI|od5,@LF5)w3IngHf|.#RWHNf-UX*a:WWKBMkxOo6f~' );
define( 'LOGGED_IN_SALT',   '!f5S-f|d9x~Zw:AL_RQ>:y`r<>XC%U34Idu;hTA]fUmEL-?:v];fKHy:S7]kysS-' );
define( 'NONCE_SALT',       '<o#R7v#f>RjT@Yx;).kX{,Bn:E|vw&!w]0?Y2{F_FJAw#@$Z(f!8y(j>2Z%zsb?*' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
