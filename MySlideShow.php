<?php
/**
*
* @package           MySlideShow
* @author            Oscar Fernandez
* @link              https://www.linkedin.com/in/oscarfer/
* @since             1.0.0
* @copyright         2022 MySlideShow
* @license           GPL-3.0-or-later
*
* @wordpress-plugin
* Plugin Name:       MySlideShow
* Plugin URI:        https://rtcamp.com/assignments/wordpress-plugin/
* Description:       This plugin test if I'm familiar with WordPress shortcodes.
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
if (!defined('WPINC')) {
	die;
}

define( 'MYSLIDESHOW_VERSION', '1.0.0' );
define( 'MYSLIDESHOW_NAME', 'MySlideShow' );
define( 'MYSLIDESHOW_MINIMUM_WP_VERSION', '5.0' );
define( 'MYSLIDESHOW_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'MYSLIDESHOW_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require MYSLIDESHOW_PLUGIN_DIR . 'includes/MySlideShowPlugin.php';

register_activation_hook( __FILE__, array( 'MySlideShowPlugin', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'MySlideShowPlugin', 'plugin_deactivation' ) );

function runMySlideShowPlugin(){

  $plugin = new MySlideShowPlugin();
  $plugin->run();
}

runMySlideShowPlugin();