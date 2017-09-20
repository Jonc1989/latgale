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
define('DB_NAME', 'latgale');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         'nX[Z^5$ko*awo#%n@&|#SoLi^UGE`]TS;yk=Qm6qoQye;<K-gXRA3Xy+|A[91Y$D');
define('SECURE_AUTH_KEY',  'rix7N!/3V$Y}uD7Xg]!,W8R|C.3jbyFl(gQY^6$ a^jcob@qxcuY~`Rv[9<owgn+');
define('LOGGED_IN_KEY',    '{Nm;nwCv/so*)uZ.5W^%&O+iJ-6E4]3uO>M54*|gD4F[iy>[n@x2C8cw<m!.bM;J');
define('NONCE_KEY',        'y?UF?fqU1 f?@j?%U,x n{*;)pqn9.H5<s-@]?QWjP5.zTTAzLY`DZg$?l,2N3vQ');
define('AUTH_SALT',        'Op.}h*{QWaMI>-UZI`p/8>KuEBbQW%qT%:}9@nm|5$W_JNIW/j8+G,=w knUGJnq');
define('SECURE_AUTH_SALT', 'C;s8KoVOEY~_-cW5/J>1&2=Qf# Nk]~k-!hD><u(=q1FP+h,Y~xOUY<% h*_ D8m');
define('LOGGED_IN_SALT',   'IX:3FK-m>NNXYIHI_h!4phx1LS5r^m^|)B+d2*sY/n+I0M>IiBIV <I@!H:D5)t(');
define('NONCE_SALT',       'c&Ndq1+yyU4E<cBC#yW.lN:y]9KRY|!}omqS1ynz(++njEZ8VPloS:Vc0LBK;k{A');

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
define('WP_DEBUG', false);
define( 'WP_MEMORY_LIMIT', '96M' );


/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
