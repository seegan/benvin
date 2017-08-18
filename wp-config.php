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
define('DB_NAME', 'benvin');

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
define('AUTH_KEY',         ';*M?*,5q>p<3] Z8S^n76-;l|cr^|yIX!JP^Z/L0: dfj54n^iWoLi^osYi4q&Eu');
define('SECURE_AUTH_KEY',  'Rg0efA9hg0~Y&p+(MY#=BjfbzHDwB8u,oQjA U8p|0T$s<V|IfGXB<ojJfZ?-V|t');
define('LOGGED_IN_KEY',    'b|)8R]1nYS00xLGpjQrd0%--ejAr{$#t4fj@!GBU&|{%On%.#F.}egD~4%8MESKK');
define('NONCE_KEY',        '>s,Uys8xAR1 r$b^RJ~/uP<Ov>;eKZ24E5mBZ-EtFj09hYt+}M+1!12:[J/}^%L/');
define('AUTH_SALT',        '[s,}u;O$#J>GvFzH1.&OI,>9K9<S#cM%+%D/e:Z)qPn&+h o7DNO<B_c0~:.[*wf');
define('SECURE_AUTH_SALT', '>?eSo0I5?{YdRNp?r)P$E.T$$M^um6<V|E-BNQ,^}yU1vWx0$|/HX|KtwPYGf[#<');
define('LOGGED_IN_SALT',   'NVkG)lVrgfv-=T9x_<.IP$G^SpT;v,1gQT9x$mWIs2,:en~_B}MUDUv-L&&&CS)Y');
define('NONCE_SALT',       'jO1p2NsGQ7X&}v2a@7+t`W|3%[X;8q2h%?X~(Tl9L%Z!17eUz:,^3-&pF;KCP{>[');

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
