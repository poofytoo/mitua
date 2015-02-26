<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wp');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         'NtVW+892-Ne{bhc0;haJYtZqJ9gUsWY;/|3~-oR|H#i#TD2@o<OG-Rb;F)ilo+/;');
define('SECURE_AUTH_KEY',  'xx-(z7ZtL7ylag(r89?-P.kJCfF!cSPKgCj_[FGYES&yc*,t:I/]!T++E2):R`H|');
define('LOGGED_IN_KEY',    'MtHqdYgsUxy`2*gn&.h1$.P$1(Pv3[npc`F-Y+Z9:6*W(U7q[YC-_G>n`]1Q.J|K');
define('NONCE_KEY',        '9twc+XuS/`]0Oykk6T0_BiSM~GQ8>X$+;ZTL|nyY&w`<j/lcXkM*%V4q0D>MquGE');
define('AUTH_SALT',        'zJW/=&dmJ-kn6NHjTe3h2*NDkDv(FOjZjj+{MqC13WEi4ZgGH=38J:7T<En&~j)k');
define('SECURE_AUTH_SALT', '+!6iX:F &,ES!GRQ-:|el#3#ZB-yFg!=)0{W[@6uX{7127f6)I,LBbu!ls?0KGuY');
define('LOGGED_IN_SALT',   '8)z-p],+pAA`%[v-J!)3<kylnSSK}HRHHu+OW)Z>?N@36WK~Nn8VR+T+{K&-g-d+');
define('NONCE_SALT',       '%nUDG$#p&>Mk[,F}y;>nMD#YA9@cNDt@*+qG?O#x/f- J0!sy %f?#>||tLQ^|xn');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
