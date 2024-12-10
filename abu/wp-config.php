<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'kleanco1_wp_13znw2hj' );

/** Database username */
define( 'DB_USER', 'kleanco1_usr_13znw2hj' );

/** Database password */
define( 'DB_PASSWORD', '$kle!anc$o1_us$r_13&znw2hj' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define('AUTH_KEY',         'g#Kf#-k]gn9A{`2dzP?#dCfeeB-iv;=VF|q`~6bxJ>0Y(?O.%|TC2EgdP[xf<!lL');
define('SECURE_AUTH_KEY',  'Sc454v(7mQSF6vV7@Hd=m?Wt qn]:tGx-B0u=>kaSL*|7jF}4C6Op%|GA@k^*mfT');
define('LOGGED_IN_KEY',    'Apvk?o-jIJDs7=a$!(tiC>NR-3HYFl{Bm~pM-[m~$0do-y!MTVgMe&cNBL7jW=l!');
define('NONCE_KEY',        '>9lj~D2/<BkD(lP3X$Hm6AjG%WLq&FA@B}z9=.L+o^E9w+M{1vYG:Y`SMpH7[scU');
define('AUTH_SALT',        'fdqv|F-|r[+ld2#b6/<YcJf!$~KJ#JBpUKXa[6l~Y5,bL#Zc_f}8w>5q#+[-&2@P');
define('SECURE_AUTH_SALT', '!u8]`iWx9qy}x5N+D{gKJw&mYp-|m0$3N8N.&nZq<8C=PN#,Gi3sW2(|!=xHyB&;');
define('LOGGED_IN_SALT',   'D#0$)U-!a]p3eG<2#/,t7`&w_kQJoG.>9z,ARW+58tp8o~LT2(|9m;+=wJ-:MuUC');
define('NONCE_SALT',       'jQ_b,uZ8(Pjws!A^4LZ|zwhPM<Q!|w[g@G5dH;?&uG3]-|{?EN>v%$*p|6E7e9]u');
/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'eq7vprUE_';

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
