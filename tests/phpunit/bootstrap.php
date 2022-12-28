<?php
/**
 * MySlideshow bootstrap tests
 *
 * @category  Test
 * @package   MySlideshow
 * @author    Oscar Fernandez <oskarvisual@gmail.com>
 * @copyright 2022 MySlideshow
 * @license   GPLv2 or later
 * @link      https://www.linkedin.com/in/oscarfer/
 */

/* Loading the polyfills for PHPUnit. */
require dirname( dirname( __FILE__ ) ) . '/vendor/yoast/phpunit-polyfills/phpunitpolyfills-autoload.php';

/* Loading the class-util.php file. */
require_once dirname( __FILE__ ) . '/util/class-util.php';

/** Path to test lib bootstrap.php */
$test_lib_bootstrap_file = dirname( __FILE__ ) . '/includes/bootstrap.php';

if ( ! file_exists( $test_lib_bootstrap_file ) ) {
	echo esc_html( PHP_EOL . 'Error : unable to find ' . $test_lib_bootstrap_file . PHP_EOL );
	exit( '' . PHP_EOL );
}

/** Set plugin and options for activation */
$GLOBALS['wp_tests_options'] = array(
	'active_plugins' => array(
		'myslideshow/myslideshow.php',
	),
	'wpsp_test'      => true,
);

/** Call test-lib's bootstrap.php */
require_once $test_lib_bootstrap_file;
