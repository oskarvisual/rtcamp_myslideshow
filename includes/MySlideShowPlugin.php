<?php
require_once MYSLIDESHOW_PLUGIN_DIR . 'admin/MySlideShowAdmin.php';
require_once MYSLIDESHOW_PLUGIN_DIR . 'shortcodes/MySlideShowShortcode.php';

class MySlideShowPlugin {
	public static function plugin_activation():void  {
		add_option( 'myslideshow_options' , array(
        	'myslideshow_title' => 'My Slideshow',
        	'myslideshow_images' => json_encode(array())
        ));
	}

	public static function plugin_deactivation():void  {
		delete_option( 'myslideshow_options' );
	}

	public function run():void  {
		$MySlideShowShortcode = new MySlideShowShortcode();
		$MySlideShowShortcode->run();

		if(is_admin()){
			$MySlideShowAdmin = new MySlideShowAdmin();
			$MySlideShowAdmin->run();
		}
	}
}