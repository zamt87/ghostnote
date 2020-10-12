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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'ghostnoteagency_zt' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'zkPhnC*#Jimd,CfGT1Kp_q`*_dJg;4/flQ>3C))`9Xf+scVHN8Ms>Cy9g,v(UYe~' );
define( 'SECURE_AUTH_KEY',  '+`COP&~sWR8<-(Wf c`<gNa=Fbv2#Ct9xL,=7EY0<g!]$dl:C|lV7;%Q +/>Mk>.' );
define( 'LOGGED_IN_KEY',    '?6#)%!BPE|7K9>l29bS9FY[J>6aVWf]]>t;be4#{<[baC+y.E`M&$T;d~dW~2pp|' );
define( 'NONCE_KEY',        '`0h=l4>XY|9Q7UL!AwC*Ea},VGgn0xqkHX^H 9A[agWX/L!A$[^NR`9kC8`06Uq-' );
define( 'AUTH_SALT',        'mZ%ky]tR@(jf&Hl9}S=H1jqL,><q>^4R=1K1H#dYc]?}rW3]Y.VFgTjQg#T`p2%W' );
define( 'SECURE_AUTH_SALT', 'rI>@jQ3eZ:/ebE~DLa$x$=FYy4?L?_HcE4ymK34w}+5<2|oG[b<J]~JthQ,7`xok' );
define( 'LOGGED_IN_SALT',   'r#k[J,Hi|YE}If#)XxAFgW1:)E[hy`Z+NN 5xc`i;!k|NCbR(HFcb)MB2By0dkY(' );
define( 'NONCE_SALT',       'I-iWSQ(kpEXi.f?{;3SkRjle8LWA^%A7kE5UkcG]4~|_R0*V::qZ2)y2~1@n;=,g' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
