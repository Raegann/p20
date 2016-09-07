<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'd86508_praha20');

/** MySQL database username */
define('DB_USER', 'a86508_praha20');

/** MySQL database password */
define('DB_PASSWORD', '0OnZ9K5LxZ_');

/** MySQL hostname */
define('DB_HOST', 'wm74.wedos.net');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '@MKY)HJ+otG(R1j$_-!Ll4x-7Rastu`<>[>D[;^iIR!){zzi*p_%@Sj#<X Zrref');
define('SECURE_AUTH_KEY',  ':~&Vc%3|yyb;y#?B[.vGFM)cBr}GV7S8L<ewCfJd8/0WA5Hhl)#aC^!-6m[%H)wk');
define('LOGGED_IN_KEY',    'sz<u]3mTm7>oZfy[4[3XfcXgYVQ28]7{ 9Y`IEqT6,s1u+?6e!Q_x[~h;TDgZJi&');
define('NONCE_KEY',        '$rw~sV|R}be!uT`|9MXw}csUUYmh{=bx20^V{;${__oPZ1-`!9M ;q@M9t(;R_JL');
define('AUTH_SALT',        'o:L3v:jfjh|.}?TE@AtKC*s4oRxoN|+K#Nt~34,rm8TH+WV^ ?fQkb(^Y)u8]8@0');
define('SECURE_AUTH_SALT', '6wo&R*%9o8%y5FRLe!aJox%pVhYU*8B0ntF}t{$$&U<_p`U,7`F48u;[N3DmQ tw');
define('LOGGED_IN_SALT',   '9(sEp5Q;0U!?N:zJ`nBZ$}Uc48LKYl$Xf&]<-?|9]^`RfDW!=-vs$NN?EW5z1,gr');
define('NONCE_SALT',       'ksB+]!n<9?J%6Y~w?rD2YF+/v-#3mULvr;hVB[&2+%DA@X(z/9[,tJZv/:LAa{%A');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */

ini_set('log_errors','On');
ini_set('display_errors','Off');
ini_set('error_reporting', E_ALL );
define('WP_DEBUG', false);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);

define('WP_DEBUG', true);


/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

