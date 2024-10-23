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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          ')e}$Z#T*vesDZkI=+3{g6NQ;JSt6k#5Os(=ku$+dwLLUG%E~wE9MR]f+7RBIu,R!' );
define( 'SECURE_AUTH_KEY',   'TKU%G-=U_~9b~bQ.Yu={]eTb9OEY0[ct~CFy^lP+{6V%ZxVTpJ*?PJ{To!]sjpG)' );
define( 'LOGGED_IN_KEY',     'n~D[K!i}5_}21$a)D}$NH*8Wg}<lg`( .zo57,!~=?$N)Oh53bwY|mMd5WY}naA>' );
define( 'NONCE_KEY',         'LL,!?Tl^]lwTF,SD8n9>7H; pU86cyDXRPw>qREeJ7G%EbXIH:U&/e!`4?oHCb_ ' );
define( 'AUTH_SALT',         'a)Z|*r`7sr>XC[Q:-_0Y%G(RkP02%xaEgirwaC(~NKlrRg.D+=7+Hq[;IFOa`vs@' );
define( 'SECURE_AUTH_SALT',  'z&4g^ m_=Nkiq`.|lG]toLN^$Pu2[Yxn3+BWVZI1Fo>LnIjkd6dLiL>8{c9jf6/y' );
define( 'LOGGED_IN_SALT',    ',{lFI#W,9Y5-K}B[tYs~:p2pMtD@F1U]w22MGF{Fz/%w[`h|)c)^{AV$n{Vy#E/j' );
define( 'NONCE_SALT',        '7L$xVZ1xk[bt*EdXV#n6-Ooj Q<,P1rQ3BFq=?8;>[;S<Cz1B4:EDoipLxg)/@_x' );
define( 'WP_CACHE_KEY_SALT', ']m{H!0SvVN9gbW?QB6E/,gc*pWTbisQ|`]xVelErMj{!_u21h9yjTTp`mG}0}g]u' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
