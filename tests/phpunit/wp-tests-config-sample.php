<?php
/**
 * The base configuration for WordPress
 *
 * The wp-tests-config.php used to configure tests with a test database
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

/** Change the next line to points to your WordPress dir */
define( 'ABSPATH', '/var/www/html/wordpress/' );

define( 'WP_DEBUG', false );

// WARNING WARNING WARNING!

/** The name of the test database for WordPress */
define( 'DB_NAME', 'wptest' );

/** Test database username */
define( 'DB_USER', 'wptest' );

/** Test database password */
define( 'DB_PASSWORD', 'wptest' );

/** Test database hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Test database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The test database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */

$table_prefix = 'wptests_'; // Only numbers, letters, and underscores please!

/* These are the default values for the site. */
define( 'WP_TESTS_DOMAIN', 'localhost' );
define( 'WP_TESTS_EMAIL', 'admin@example.org' );
define( 'WP_TESTS_TITLE', 'Test Plugin' );

/* This is used by the WordPress core tests to determine which PHP binary to use. */
define( 'WP_PHP_BINARY', 'php' );

/* Setting the language of the WordPress installation. */
define( 'WPLANG', '' );
