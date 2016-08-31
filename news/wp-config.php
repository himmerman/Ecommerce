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
define('DB_NAME', 'kingbeng_news_blog');

/** MySQL database username */
define('DB_USER', 'kingbeng_news');

/** MySQL database password */
define('DB_PASSWORD', 'benji2468');

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
define('AUTH_KEY',         'LZuq7yiVs10Vir9NNWGYCddRU1iEWHuFroFBtCm1FMiIhVLJ7W5XD9IGx0F2hnTN');
define('SECURE_AUTH_KEY',  'U5NLLSHD6Q3GsPX298jtapgSX0vlrrNj8Zcnai5pzUr8TQ1HF9fczUPnPYXMRDvd');
define('LOGGED_IN_KEY',    'SdiR3jaN00a6Boabe1AfnvuvOgV0yrx1AmUTMqmEOKdcr5me2IKbkyAAnWC76t8S');
define('NONCE_KEY',        'GxVvbY8fQS2cFrBhXdsBjAepBdkH7JxRim0wVDOZ5zro2FvMdkDfozmoV0tX5GhZ');
define('AUTH_SALT',        '6WZ3KO4aVoWJzBmBS4QVfPZXAn5UNe1BZzEgUWNP4C7yIOT6ixqCItJdnqglEEh0');
define('SECURE_AUTH_SALT', 'B9XVt8G4D4LNiMBKuYFk9U0ucwcwyKn0CT7Boe0iIwIAq9tnXfra9j0KLmSeYcWI');
define('LOGGED_IN_SALT',   '7dqcUGTSY21S4hKK3FzIi8ywuLIgnQ9INWF8tKaoPCBdY5hbOXd1uxuO4ApZH4WU');
define('NONCE_SALT',       'xuziUXuz9mwXvxJwadGfXEIdyer6lhiKQ67T1VdMqcyylWu8iL84AgqDPRrLpq1S');

/**
 * Other customizations.
 */
define('FS_METHOD','direct');define('FS_CHMOD_DIR',0755);define('FS_CHMOD_FILE',0644);
define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');

/**
 * Turn off automatic updates since these are managed upstream.
 */
define('AUTOMATIC_UPDATER_DISABLED', true);


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
