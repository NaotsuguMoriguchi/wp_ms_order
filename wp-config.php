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
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
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
define( 'AUTH_KEY',         '(Vvqp;g)-,j;=s^z|M:8P+Rh8@j>A.AY7WIP^1Pz2,V(;h~CoyC7zx:[43ahVM=G' );
define( 'SECURE_AUTH_KEY',  'CimbZ?5F0/|w>&/#9Ho&}WTXpPh2bA_N<Cw`y_pwAX$Xy!E^S&S!F}Hb9zipG?]m' );
define( 'LOGGED_IN_KEY',    'jebkeyMiaCFc~T`5KuAjKX!0Sza`ic<>CF)6g+D6C;p}L[7y8N#(@?Iw6 {:jQlj' );
define( 'NONCE_KEY',        'FcEv8uM3|mW(cJxpa:F1;C:LC[J}kMDn:|YaPZ3(2a|2Q**RtBkn`XU%%tTJc(zb' );
define( 'AUTH_SALT',        'O_n^zaE>U3H.>llp_]}.4@sYbyJ#!-[%p.p/q7B|enB]3OVJZ#wm)@Vv4:7Hxr=F' );
define( 'SECURE_AUTH_SALT', 'Ry3%M&cBXSb^}d6[}DOxZLmY|4Y==pD+zda8G]fQ_EG5onlp|bF_~i&(%)Q1}6cN' );
define( 'LOGGED_IN_SALT',   'G0iE=u[:NZrMgj~y^-Vu#Mui4deTFI;]nlo(mWj;3Rtp(B>H;?mkEjg, 9-@pv):' );
define( 'NONCE_SALT',       '/^v*4@mb&Ufaq4;%T2W#wQUd34Y]g={xokA|=Nd1D.$G,jksWQK/0^40~+_(/v9+' );

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
