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
define('DB_NAME', 'bsa');

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
define('AUTH_KEY',         '1$x!gokz:wAZ^5a(/NvIpEj=Et!=l-)dv+~4CG7u^_h!XE-LOd/ V^,+0nW6Vzi4');
define('SECURE_AUTH_KEY',  '{4-Mq5pS::qXee#/ihXn%@s$:lNJRU8Pb,{9{x/sat<J-7r!q]|rL*M24tBWHzoT');
define('LOGGED_IN_KEY',    'gC6G4>2b;3k9WanbZL{5A-{b^8B[i!N:<_!Mm);.NuD]A$Qj&;gO/*(sv j(}0mN');
define('NONCE_KEY',        'yXm*jV$w6)f@]BY[bWi%~^)#3SR&F/PeXPut>iLE>j3KMgx|Y@$-us~k1P2ryH$w');
define('AUTH_SALT',        'lE1t{WOpF[6/02}0`=%MSa(vM{+Ah)q <lXeq E)bb0g 6lPnuks/&0o-6QVsTM<');
define('SECURE_AUTH_SALT', '@HOE6I&>+`={*!7dl~bR4SmA=VDD$V8BF<P{@6/odbhha@upPpqftMk4^ ZhgW5|');
define('LOGGED_IN_SALT',   'mut(lr@2Tq#W%_)1T*Gr7_=/WRpXOquJw4ZPb0NDM{B90s`bZwDza<wk:~ZC[?V ');
define('NONCE_SALT',       '|N%7$)! oxH!un8}+nYqKni^Z#/aj>cm-DP.89jl93Sa39jGioIUSx3+H2^)PRxh');

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

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
