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
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'blog' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
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
define( 'AUTH_KEY',         'H,cs^ gE_lW)5sYIuf(r2Z4>1YRO}ocp8b*WiRUOj0,5VniI[KqpVw3W;TVQgs8y' );
define( 'SECURE_AUTH_KEY',  'VV;0S=73kR0vEkV=WfUr}TCW B#Pxmp1#&s[YqeXU W*;DDw0zrse2?}-./:pesv' );
define( 'LOGGED_IN_KEY',    '!+_atH[E/%tJn~}}DY`FW$%~Gi#Jc)XXr0P4Gc=hZklwz8S<k<.3PK8tX`}n?4W`' );
define( 'NONCE_KEY',        ',gZn1$;B{oeds0q*qjBQLCC_=/)[7sn6yy&SX?xqt;Q+=[H9~#Z&(L>d{KlN!e,v' );
define( 'AUTH_SALT',        'F +cC(;qPZFW}OrIOMloP$$_pZ&gWxCd@C{(>9YIO^<;&idf2:mW;-D,C=Ufm$n|' );
define( 'SECURE_AUTH_SALT', 'QpuKYq<L3XXzyZOsn+XFrt[/H}TjfvFv<,?Fk(K+}o;]m6Ahjm}4&~0VW>st_X ^' );
define( 'LOGGED_IN_SALT',   'Yg1ntIE;vf+v%(e|3V_m#)5]zu+PN)==5`[3G;OR7Tn+f|KXn8jQ(XW2v8dlzTNr' );
define( 'NONCE_SALT',       'I!i`>$dl hD$spRxm;pc>x*<iozJ1{,?x*gnLz+i7jE[5<;E4ENv*~Ef -.B&ZsT' );

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
