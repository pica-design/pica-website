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

//LIVE

define('DB_NAME', 'pica_website');
define('DB_USER', 'root_remote');
define('DB_PASSWORD', '1309piCa');



/** MySQL hostname */
define('DB_HOST', 'mysql.picadesign.com');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'q:4v!P,?4Iiok.0)$K!&2.sxA{+2jn[6@J7r7M)#L]JGFni8EP-Hmb-$XTQ~WXGP');
define('SECURE_AUTH_KEY',  'Z5qU2EuxF0Ip|%rd~Z}}].=byK68zlmlH@U]xI9jR`B77^zlwx*E{A_;=q80/C9$');
define('LOGGED_IN_KEY',    'mtosQ)eVA3rJt|+LjGc$B+zfFW$w>jWiSxwC tY*4aU]F-txB5la8Gv~s.9Eoii:');
define('NONCE_KEY',        '%fKCuyQBt;519=4jLFb3bIYXy4*RR.]n:vu*,UXr/r%#oA+U:j(F0kqCFpubva[{');
define('AUTH_SALT',        'oFLhcM?QUVXR+K%[`iG_+>W=Z*>Z6%h ^2<66{@h }DfJ-Og`+1EgsI:OC;b!^+[');
define('SECURE_AUTH_SALT', 'kRZm)%J2Z[741S3c9#=:IRoyjs)-xrtBskC1w> zo#[4x6M?>dsxW2x>-3jyivrD');
define('LOGGED_IN_SALT',   'efI$*<TwSa{bQh~B|G|wv:R>WM>AD;I;1N@x.Bi3QGAnfXNI:$AP;xIj#:@]/|e{');
define('NONCE_SALT',       '#xst#-<kuH&BV*B( A8[~2Gp@q3exM=E~X/WWLiN<ne:VCrnalk<4iIR66}k~)FM');

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
ini_set('display_errors', 0);
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
