<?php
/**
 * MySlideshow WordPress Plugin
 *
 * @category  Plugin
 * @package   MySlideshow
 * @author    Oscar Fernandez <oskarvisual@gmail.com>
 * @copyright 2022 MySlideshow
 * @license   GPLv2 or later
 * @link      https://www.linkedin.com/in/oscarfer/
 * @since     1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:       MySlideshow
 * Plugin URI:        https://rtcamp.com/assignments/wordpress-plugin/
 * Description:       This plugin allows you to add a slideshow on the site
 * Version:           1.0.0
 * Requires at least: 5.8
 * Requires PHP:      7.4
 * Author:            Oscar Fernandez
 * Author URI:        https://www.linkedin.com/in/oscarfer/
 * Text Domain:       myslideshow
 * License:           GPL v3 or later
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/* Defining constants for the plugin. */
define( 'MYSLIDESHOW_VERSION', '1.0.0' );
define( 'MYSLIDESHOW_NAME', 'myslideshow' );
define( 'MYSLIDESHOW_MINIMUM_WP_VERSION', '5.0' );
define( 'MYSLIDESHOW_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'MYSLIDESHOW_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/* Including the class-myslideshow-plugin.php file. */
require_once MYSLIDESHOW_PLUGIN_DIR . 'includes/class-myslideshow-plugin.php';

/* This is a WordPress hook that is called when the plugin is activated or deactivated. */
register_activation_hook( __FILE__, array( 'MySlideshow_Plugin', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'MySlideshow_Plugin', 'plugin_deactivation' ) );

/**
 * It creates a new instance of the MySlideshow_Plugin class and runs it.
 */
function run_myslideshow_plugin() {
	$myslideshow_plugin = new MySlideshow_Plugin();
	$myslideshow_plugin->run();
}

/* It creates a new instance of the MySlideshow_Plugin class and runs it. */
run_myslideshow_plugin();
