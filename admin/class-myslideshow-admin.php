<?php
class MySlideshow_Admin {
	private array $myslideshow_options;

	public function __construct() {
		$this->myslideshow_options = get_option( 'myslideshow_options' );
	}

	public function run():void {
		add_action( 'admin_menu', array( $this, 'myslideshow_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'myslideshow_page_init' ) );

		add_action('admin_enqueue_scripts', function () {
			wp_enqueue_media();

	    	wp_enqueue_style( MYSLIDESHOW_NAME . '-admin', MYSLIDESHOW_PLUGIN_URL . 'admin/css/myslideshow-admin.css', array(), MYSLIDESHOW_VERSION, 'all' );

			wp_enqueue_script( MYSLIDESHOW_NAME . '-admin', MYSLIDESHOW_PLUGIN_URL . 'admin/js/myslideshow-admin.js', array( 'jquery' ), MYSLIDESHOW_VERSION, false );
	    });
	}

	public function myslideshow_plugin_page():void {
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

	public function myslideshow_page_init():void {
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

	public function myslideshow_create_admin_page():void  {
		echo '<div class="wrap">';

			settings_errors();

			echo '<form method="post" action="options.php">';
				settings_fields( 'myslideshow_options_group' );
				do_settings_sections( 'myslideshow-admin' );
				submit_button();
			echo '</form>';	

		echo '</div>';
	}

	public function myslideshow_sanitize( $input ):array {
		$sanitary_values = array();

		if ( isset( $input['myslideshow_title'] ) ) {
			$sanitary_values['myslideshow_title'] = sanitize_text_field( $input['myslideshow_title'] );
		}

		if ( isset( $input['myslideshow_images'] ) ) {
			$sanitary_values['myslideshow_images'] = sanitize_text_field( json_encode($input['myslideshow_images']) );
		}

		return $sanitary_values;
	}

	public function myslideshow_section_info():void  {
		
	}

	public function myslideshow_title_callback():void  {
		printf(
			'<input class="regular-text" type="text" name="myslideshow_options[myslideshow_title]" id="myslideshow_title" value="%s">',
			isset( $this->myslideshow_options['myslideshow_title'] ) ? esc_attr( $this->myslideshow_options['myslideshow_title']) : ''
		);
	}

	public function myslideshow_upload_callback():void  {
		echo '<input type="button" value="Upload Images" class="button-primary" id="upload_image"/>';
	}

	public function myslideshow_slider_callback():void  {
		echo '<ul class="myslideshow" id="slider">';
			if(isset($this->myslideshow_options['myslideshow_images'])){
				$images = json_decode($this->myslideshow_options['myslideshow_images'], true);

				if(is_array($images)){
					foreach ($images as $key => $image) {
						printf('<li class="myslideshow__item" id="slider-item-%s">', esc_attr(@$image["id"]));
				      		
				      		echo '<span class="myslideshow__move dashicons dashicons-move"></span>';

				      		printf('<span class="myslideshow__delete dashicons dashicons-trash" data-id="%s"></span>', esc_attr(@$image["id"]));

				      		echo '<div class="myslideshow__content">';

				      			echo '<div class="myslideshow__thumbnail">';

				      				printf('<img src="%s" class="myslideshow__image" />', wp_get_attachment_image_url(intval(@$image["id"]), 'thumbnail', false ));

				      			echo '</div>';

				      			echo '<div class="myslideshow__form">';

						      		printf('<input type="hidden" name="myslideshow_options[myslideshow_images][%s][id]" value="%s" />', esc_attr(@$image["id"]), esc_attr(@$image["id"]));

				      				echo '<table class="form-table" role="presentation">';

				      					echo '<tbody>';

				      						echo '<tr>';

				      							echo '<th scope="row">Image Title Text</th>';

				      							echo '<td>';

				      								printf('<input class="regular-text" type="text" name="myslideshow_options[myslideshow_images][%s][title]" value="%s" />', esc_attr(@$image["id"]), esc_attr(@$image["title"]));

				      							echo '</td>';

				      						echo '</tr>';

				      						echo '<tr>';

				      							echo '<th scope="row">Image Alt Text</th>';

				      							echo '<td>';

				      								printf('<input class="regular-text" type="text" name="myslideshow_options[myslideshow_images][%s][alt]" value="%s" />', esc_attr(@$image["id"]), esc_attr(@$image["alt"]));

				      							echo '</td>';

				      						echo '</tr>';

				      						echo '<tr>';

				      							echo '<th scope="row">Link URL (optional)</th>';

				      							echo '<td>';

				      								printf('<input class="regular-text" type="text" name="myslideshow_options[myslideshow_images][%s][url]" value="%s" />', esc_attr(@$image["id"]), esc_attr(@$image["url"]));

				      							echo '</td>';

				      						echo '</tr>';

				      					echo '</tbody>';

				      				echo '</table>';

				      			echo '</div>';

				      		echo '</div>';

				      	echo '</li>';
					}
				}
			}

		echo '</ul>';
		
	}

}