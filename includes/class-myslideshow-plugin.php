<?php
/**
 * MySlideshow_Plugin Class
 *
 * @category  Class
 * @package   MySlideshow
 * @author    Oscar Fernandez <oskarvisual@gmail.com>
 * @copyright 2022 MySlideshow
 * @license   GPLv2 or later
 * @link      https://www.linkedin.com/in/oscarfer/
 */

/* Including the files that contain the classes that will be instantiated in the run method. */
require_once MYSLIDESHOW_PLUGIN_DIR . 'admin/class-myslideshow-admin.php';
require_once MYSLIDESHOW_PLUGIN_DIR . 'shortcodes/class-myslideshow-shortcode.php';

/** It creates a class called MySlideshow_Plugin. */
class MySlideshow_Plugin {
	/**
	 * It adds an option to the database
	 */
	public static function plugin_activation():void {
		add_option(
			'myslideshow_options',
			array(
				'myslideshow_title'  => 'My Slideshow',
				'myslideshow_images' => wp_json_encode( array() ),
			)
		);
	}

	/**
	 * It deletes the options from the database.
	 */
	public static function plugin_deactivation():void {
		delete_option( 'myslideshow_options' );
	}

	/**
	 * * If the user is in the admin area, instantiate the admin class and run it.
	 * * Instantiate the shortcode class and run it
	 */
	public function run():void {
		new MySlideshow_Shortcode();

		if ( is_admin() ) {
			new MySlideshow_Admin();
		}
	}
}
