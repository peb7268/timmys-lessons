<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wingdb');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

define('WP_HOME','http://wingfactory.com');
define('WP_SITEURL','http://wingfactory.com');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '#5n`AuF^=r:j|u#8!~*q?Tj=7JW(lE7n{N6?nGC|h81-b47eyI_5~?AYF&SEKuV{');
define('SECURE_AUTH_KEY',  'UR_804c#<n2p^+Llj7-;1{Pg62@reW[k2-XVGUKW$Kh6=A)f$Q`5/vUAkX.W P:D');
define('LOGGED_IN_KEY',    '|n;nsfR-A+n^@u`O8-D;!pw{6/[LL0)wy3aDetV[.Bsg^o tk@PLA~(Co&63@S4l');
define('NONCE_KEY',        '>D[bzCo`zY40f&PU-$iEWIpY?%o>SF]SP*wn.T<4#t[bTZ`/8mlkbQ$D7K4t?KHP');
define('AUTH_SALT',        'xLYQ7~5#+`Ph4[JLW8re+K8<R7$qHs)}{XmRa}_4o^ Kw0w=]#.c?!~FS!`*.~d!');
define('SECURE_AUTH_SALT', '(<^DDx$O4*_[XwBjbO?{P?g(*l7mR#I$<3ohG/nsXsgNrw[dGN@Ffo1nyy PPET+');
define('LOGGED_IN_SALT',   '!b90/A#r.eyYu&>O9B{HDSWD1Q)T*z2z |6(#j_%m0ftKJP (sHt^HIuL.~$YS6+');
define('NONCE_SALT',       '28>F:`8b9Mj1s;!X{/-4w^n{>W%`[L3c*n$t4mk@AE|f|L[jgXzW1Zs|saVjW>$@');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
