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
	 *
	 * @return bool of add_option.
	 */
	public static function plugin_activation():bool {
		if ( get_option( 'myslideshow_options' ) ) {
			return true;
		}

		return add_option(
			'myslideshow_options',
			array(
				'myslideshow_title'  => 'My Slideshow',
				'myslideshow_images' => wp_json_encode( array() ),
			)
		);
	}

	/**
	 * It deletes the options from the database.
	 *
	 * @return bool of delete_option.
	 */
	public static function plugin_deactivation():bool {
		return delete_option( 'myslideshow_options' );
	}

	/**
	 * Check options from the database.
	 *
	 * @return bool of option.
	 */
	public static function plugin_check():bool {
		return ( get_option( 'myslideshow_options' ) ) ? true : false;
	}

	/**
	 * Run The Plugin
	 *
	 * First checks if the option exists in the database. If it does not exist, it creates it
	 * If the user is in the admin area, instantiate the admin class and run it.
	 * * Instantiate the shortcode class and run it
	 */
	public function run():void {
		if ( ! $this->plugin_check() ) {
			$this->plugin_activation();
		}

		if ( is_admin() ) {
			new MySlideshow_Admin();
		}

		new MySlideshow_Shortcode();
	}
}
