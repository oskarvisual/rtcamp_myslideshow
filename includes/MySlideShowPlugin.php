<?php
class MySlideShowPlugin {
	public function __construct() {
		
	}

	public static function plugin_activation() {
		add_option( 'myslideshow_options' , array(
        	'myslideshow_title' => 'My Slideshow',
        	'myslideshow_images' => json_encode(array())
        ));
	}
	
	public static function plugin_deactivation() {
		delete_option( 'myslideshow_options' );
	}

	public function run() {

	}
}