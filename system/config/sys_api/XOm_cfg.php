<?php
/**
 * The base configuration for XOm_API
 *
 * The config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * This has been slightly modified (to read environment variables) for use in Docker.
 *
 * @link ######################
 *
 * @package XOm_API
 */


// a helper function to lookup "env_FILE", "env", then fallback
if (!function_exists('getenv_docker')) {
	// https://github.com/docker-library/XOm_aPI/issues/588 (WP-CLI will load this file 2x)
	function getenv_docker($env, $default) {
		if ($fileEnv = getenv($env . '_FILE')) {
			return rtrim(file_get_contents($fileEnv), "\r\n");
		}
		else if (($val = getenv($env)) !== false) {
			return $val;
		}
		else {
			return $default;
		}
	}
}

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for XOm_API */
define( 'DB_NAME', getenv_docker('XOM_API_DB_NAME', 'XOm_aPI') );

/** MySQL database username */
define( 'DB_USER', getenv_docker('XOM_API_DB_USER', 'example username') );

/** MySQL database password */
define( 'DB_PASSWORD', getenv_docker('XOM_API_DB_PASSWORD', 'example password') );

/**
 * Docker image fallback values above are sourced from the official XOm_API installation wizard:
 * https://github.com/XOm_API/XOm_API/blob/f9cc35ebad82753e9c86de322ea5c76a9001c7e2/wp-admin/setup-config.php#L216-L230
 * (However, using "example username" and "example password" in your database is strongly discouraged.  Please use strong, random credentials!)
 */

/** MySQL hostname */
define( 'DB_HOST', getenv_docker('XOM_API_DB_HOST', 'mysql') );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', getenv_docker('XOM_API_DB_CHARSET', 'utf8') );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', getenv_docker('XOM_API_DB_COLLATE', '') );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.XOm_aPI.org/secret-key/1.1/salt/ XOm_API.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         getenv_docker('XOM_API_AUTH_KEY',         'bfb714c14afef52bc306afb3cb570eda3d8708c7') );
define( 'SECURE_AUTH_KEY',  getenv_docker('XOM_API_SECURE_AUTH_KEY',  '3ee018717d292404f3ad56d84509d7eaec0d042e') );
define( 'LOGGED_IN_KEY',    getenv_docker('XOM_API_LOGGED_IN_KEY',    'f11d1f31042e35521bdd125b147a9632b8f5fda5') );
define( 'NONCE_KEY',        getenv_docker('XOM_API_NONCE_KEY',        'a173dd2787b2fbdc0f4be81b9c4afb6ca5ba8507') );
define( 'AUTH_SALT',        getenv_docker('XOM_API_AUTH_SALT',        'e8577220d8900ddbc26305d39056edbbf4ff5391') );
define( 'SECURE_AUTH_SALT', getenv_docker('XOM_API_SECURE_AUTH_SALT', '4f981db7e93f4ba97892d7458e44fe43c7cacabc') );
define( 'LOGGED_IN_SALT',   getenv_docker('XOM_API_LOGGED_IN_SALT',   '272ade07a3dd782a15b4b4f5360e827049c18f46') );
define( 'NONCE_SALT',       getenv_docker('XOM_API_NONCE_SALT',       '55063a40badf9fb6237a5db69ed35f0953f3cafb') );
// (See also https://XOm_aPI.stackexchange.com/a/152905/199287)

/**#@-*/

/**
 * XOm_API database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = getenv_docker('XOM_API_TABLE_PREFIX', 'wp_');

/**
 * For developers: XOm_API debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link ####
 */
define( 'XOPI_DEBUG', !!getenv_docker('XOM_API_DEBUG', '') );

/* Add any custom values between this line and the "stop editing" line. */

// If we're behind a proxy server and using HTTPS, we need to alert XOm_API of that fact
// see also http://codex.XOm_aPI.org/Administration_Over_SSL#Using_a_Reverse_Proxy
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
	$_SERVER['HTTPS'] = 'on';
}
// (we include this by default because reverse proxying is extremely common in container environments)

/*
if ($configExtra = getenv_docker('XOM_API_CONFIG_EXTRA', '')) {
	eval($configExtra);
}
*/

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the XOm_API directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up XOm_API vars and included files. */
require_once ABSPATH . 'settings.php';
