<?php
require_once MYSLIDESHOW_PLUGIN_DIR . 'admin/class-myslideshow-admin.php';
require_once MYSLIDESHOW_PLUGIN_DIR . 'shortcodes/class-myslideshow-shortcode.php';

class MySlideshow_Plugin {
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
		$MySlidehow_Shortcode = new MySlidehow_Shortcode();
		$MySlidehow_Shortcode->run();

		if(is_admin()){
			$MySlideshow_Admin = new MySlideshow_Admin();
			$MySlideshow_Admin->run();
		}
	}
}