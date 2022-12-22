<?php
class MySlideShowAdmin {
	private array $myslideshow_options;

	public function __construct() {

	}

	public function run() {
		add_action( 'admin_menu', array( $this, 'myslideshow_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'myslideshow_page_init' ) );

		add_action('admin_enqueue_scripts', function () {
			wp_enqueue_media();

	    	wp_enqueue_style( MYSLIDESHOW_NAME . '-admin-style', MYSLIDESHOW_PLUGIN_URL . 'admin/css/myslideshow-admin.css', array(), MYSLIDESHOW_VERSION, 'all' );

			wp_enqueue_script( MYSLIDESHOW_NAME . '-admin-script', MYSLIDESHOW_PLUGIN_URL . 'admin/js/myslideshow-admin.js', array( 'jquery' ), MYSLIDESHOW_VERSION, false );
	    });
	}

	public function myslideshow_plugin_page() {
		add_menu_page(
			'My SlideShow',
			'My SlideShow',
			'manage_options',
			MYSLIDESHOW_NAME,
			array( $this, 'myslideshow_create_admin_page' ),
			'dashicons-images-alt',
			75
		);
	}

	public function myslideshow_page_init() {
		register_setting(
			'myslideshow_options_group',
			'myslideshow_options',
			array( $this, 'myslideshow_sanitize' )
		);

		add_settings_section(
			'myslideshow_setting_section',
			'My SlideShow',
			array( $this, 'myslideshow_section_info' ),
			'myslideshow-admin'
		);

		add_settings_field(
			'myslideshow_title',
			'Title',
			array( $this, 'myslideshow_title_callback' ),
			'myslideshow-admin',
			'myslideshow_setting_section'
		);

		add_settings_field(
			'myslideshow_images',
			'Images',
			array( $this, 'myslideshow_slider_callback' ),
			'myslideshow-admin',
			'myslideshow_setting_section'
		);

		add_settings_field(
			'myslideshow_upload',
			'Upload',
			array( $this, 'myslideshow_upload_callback' ),
			'myslideshow-admin',
			'myslideshow_setting_section'
		);
	}

	public function myslideshow_create_admin_page() {
		$this->myslideshow_options = get_option( 'myslideshow_options' );

		echo '<div class="wrap">';

			settings_errors();

			echo '<form method="post" action="options.php">';
				settings_fields( 'myslideshow_options_group' );
				do_settings_sections( 'myslideshow-admin' );
				submit_button();
			echo '</form>';	

		echo '</div>';
	}

	public function myslideshow_sanitize($input) {

	}

	public function myslideshow_section_info() {
		
	}

	public function myslideshow_title_callback() {

	}

	public function myslideshow_upload_callback() {
		
	}

	public function myslideshow_slider_callback() {

	}

}