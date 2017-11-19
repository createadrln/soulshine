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
define('DB_NAME', 'soulshine');

/** MySQL database username */
define('DB_USER', 'soulshine');

/** MySQL database password */
define('DB_PASSWORD', 'soulshine');

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
define('AUTH_KEY', 'u1tFC6y5 BPcYPIIq Py5RDz3a rfguOKYW uiU8cglc');
define('SECURE_AUTH_KEY', 'nd7h3upZ FXWEN2al 4yKMT2zh nVvtIHWO kddwgZuR');
define('LOGGED_IN_KEY', '4VW5aCSH Q46aEesD DZ8AZbJr hQqAlrcz RTJIvqwG');
define('NONCE_KEY', 'iQ4y6jBZ AtCpdY14 POUQgVwg kLpHNpjx Lav4KM65');
define('AUTH_SALT', '1qHlfLaS Nxx8cThe vmbhQeZV kzJDfftM tTwlmilv');
define('SECURE_AUTH_SALT', '6zAPlkJL pqLGrqBX yzxKWpYk cm7pEDUY pxv8kSXk');
define('LOGGED_IN_SALT', 'nLOC2sSn M4GaxnpI Mfky3AKQ WxySiQig LClE27GK');
define('NONCE_SALT', 'eohyeqtF VG1rgvoZ kptKBdbJ 2t5XNxvF hnYbOAzJ');
define('DISALLOW_FILE_EDIT', true);
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
