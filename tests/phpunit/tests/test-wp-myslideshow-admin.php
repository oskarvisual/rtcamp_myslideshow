<?php
/**
 * MySlideshow plugin tests
 *
 * @category  Test Admin
 * @package   MySlideshow
 * @author    Oscar Fernandez <oskarvisual@gmail.com>
 * @copyright 2022 MySlideshow
 * @license   GPLv2 or later
 * @link      https://www.linkedin.com/in/oscarfer/
 */

/** A class that extends the WP_UnitTestCase class. */
class Test_WP_MySlideshow_Admin extends WP_UnitTestCase {

	/**
	 * Class Test_WP_MySlideshow_Admin
	 *
	 * @var myslideshow_admin var to assigns the myslideshow_admin object. */
	private $myslideshow_admin;

	/**
	 * Class MySlideshow_Admin
	 *
	 * @var myslideshow_options array to assigns the myslideshow_options optionAssigns. */
	private array $myslideshow_options;

	/**
	 * It sets up the plugin
	 */
	public function setUp():void {
		parent::setUp();

		$this->myslideshow_options = get_option( 'myslideshow_options' );

		/* Setting the current user to be an administrator. */
		$current_user = new WP_User( 1 );
		$current_user->set_role( 'administrator' );

		/* Setting the current user to be an administrator. */
		wp_set_current_user( 1 );
		Util::set_admin_role( true );

		/* Including the class-myslideshow-plugin.php file. */
		require_once MYSLIDESHOW_PLUGIN_DIR . 'admin/class-myslideshow-admin.php';
	}

	/**
	 * It checks if the action is registered
	 */
	public function test_setup():void {
		/* Checking if the action is not registered. */
		$this->assertFalse( Util::has_action( 'admin_enqueue_scripts', $this->myslideshow_admin, 'admin_enqueue_scripts' ) );
		$this->assertFalse( Util::has_action( 'admin_menu', $this->myslideshow_admin, 'register_settings_page' ) );
		$this->assertFalse( Util::has_action( 'admin_init', $this->myslideshow_admin, 'init_common_options' ) );

		/* Creating a new instance of the MySlideshow_Plugin class. */
		$this->myslideshow_admin = new MySlideshow_Admin();

		/* Checking if the action is registered. */
		$this->assertTrue( Util::has_action( 'admin_enqueue_scripts', $this->myslideshow_admin, 'admin_enqueue_scripts' ) );
		$this->assertTrue( Util::has_action( 'admin_menu', $this->myslideshow_admin, 'register_settings_page' ) );
		$this->assertTrue( Util::has_action( 'admin_init', $this->myslideshow_admin, 'init_common_options' ) );
	}

	/**
	 * It checks sanitize function
	 */
	public function test_form_sanitize():void {
		$this->myslideshow_admin = new MySlideshow_Admin();

		require_once ABSPATH . 'wp-admin/includes/media.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';

		$images = array(
			media_sideload_image( 'https://loremflickr.com/cache/resized/65535_51919515453_200d29dcae_320_240_nofilter.jpg', null, null, 'id' ),
			media_sideload_image( 'https://loremflickr.com/cache/resized/65535_52215297981_6ca7bb37e1_n_320_240_nofilter.jpg', null, null, 'id' ),
			media_sideload_image( 'https://loremflickr.com/cache/resized/65535_51909301278_0817277668_n_320_240_nofilter.jpg', null, null, 'id' ),
		);

		$this->assertCount( 3, $images );

		$input = array(
			'myslideshow_title'  => 'My Slideshow<h1><?php evil ?>',
			'myslideshow_images' => array(
				array(
					'id'    => $images[0],
					'title' => 'Title 1',
					'alt'   => 'Alt 1',
					'url'   => 'https://google.com',
				),
				array(
					'id'    => $images[1],
					'title' => 'Title 2',
					'alt'   => 'Alt 2',
					'url'   => 'https://google.com',
				),
				array(
					'id'    => $images[2],
					'title' => 'Title 3',
					'alt'   => 'Alt 2',
					'url'   => 'https://google.com',
				),
			),
		);

		$output = $this->myslideshow_admin->sanitize_options( $input );

		$this->assertIsArray( $output );

		$this->assertCount( 2, $output );

		$this->assertSame( 'My Slideshow', $output['myslideshow_title'] );

		$this->assertSame(
			sprintf(
				'[{"id":%d,"title":"Title 1","alt":"Alt 1","url":"https:\/\/google.com"},{"id":%d,"title":"Title 2","alt":"Alt 2","url":"https:\/\/google.com"},{"id":%d,"title":"Title 3","alt":"Alt 2","url":"https:\/\/google.com"}]',
				esc_html( $images[0] ),
				esc_html( $images[1] ),
				esc_html( $images[2] ),
			),
			$output['myslideshow_images']
		);
	}

	/**
	 * It checks callbacks inputs
	 */
	public function test_form_callbacks():void {
		$this->myslideshow_admin = new MySlideshow_Admin();

		ob_start();
		$this->myslideshow_admin->title_callback();
		$field = ob_get_clean();

		$this->assertSame(
			$field,
			'<input class="regular-text" type="text" name="myslideshow_options[myslideshow_title]" id="myslideshow_title" value="My Slideshow">'
		);

		ob_start();
		$this->myslideshow_admin->upload_callback();
		$field = ob_get_clean();

		$this->assertSame( 
			$field, 
			'<input type="button" value="Upload Images" class="button-primary" id="upload_image"/>' 
		);

		$this->assertCount( 0, json_decode( $this->myslideshow_options['myslideshow_images'] ) );

		ob_start();
		$this->myslideshow_admin->slider_callback();
		$field = ob_get_clean();
		
		$this->assertSame( 
			$field, 
			'<ul class="myslideshow" id="slider"></ul>'
		);

		$images = array(
			media_sideload_image( 'https://loremflickr.com/cache/resized/65535_51919515453_200d29dcae_320_240_nofilter.jpg', null, null, 'id' ),
			media_sideload_image( 'https://loremflickr.com/cache/resized/65535_52215297981_6ca7bb37e1_n_320_240_nofilter.jpg', null, null, 'id' ),
			media_sideload_image( 'https://loremflickr.com/cache/resized/65535_51909301278_0817277668_n_320_240_nofilter.jpg', null, null, 'id' ),
		);

		$this->assertCount( 3, $images );

		$input = array(
			'myslideshow_title'  => 'My Slideshow<h1><?php evil ?>',
			'myslideshow_images' => array(
				array(
					'id'    => $images[0],
					'title' => 'Title 1',
					'alt'   => 'Alt 1',
					'url'   => 'https://google.com',
				),
				array(
					'id'    => $images[1],
					'title' => 'Title 2',
					'alt'   => 'Alt 2',
					'url'   => 'https://google.com',
				),
				array(
					'id'    => $images[2],
					'title' => 'Title 3',
					'alt'   => 'Alt 2',
					'url'   => 'https://google.com',
				),
			),
		);

		$output = $this->myslideshow_admin->sanitize_options( $input );

		ob_start();
		$this->myslideshow_admin->slider_callback();
		$field = ob_get_clean();

		$field_2 = '<ul class="myslideshow" id="slider">';

		if ( isset( $this->myslideshow_options['myslideshow_images'] ) ) {

			$images = json_decode( $this->myslideshow_options['myslideshow_images'], true );

			if ( is_array( $images ) ) {
				foreach ( $images as $key => $image ) {
					$field_2 .= sprintf( '<li class="myslideshow__item" id="slider-item-%s">', esc_attr( $image['id'] ) );

					$field_2 .= '<span class="myslideshow__move dashicons dashicons-move"></span>';

					$field_2 .= sprintf( '<span class="myslideshow__delete dashicons dashicons-trash" data-id="%s"></span>', esc_attr( $image['id'] ) );

					$field_2 .= '<div class="myslideshow__content">';

					$field_2 .= '<div class="myslideshow__thumbnail">';

					$field_2 .= sprintf( '<img src="%s" class="myslideshow__image" />', esc_attr( wp_get_attachment_image_url( intval( $image['id'] ), 'thumbnail', false ) ) );

					$field_2 .= '</div>';

					$field_2 .= '<div class="myslideshow__form">';

					$field_2 .= sprintf( '<input type="hidden" name="myslideshow_options[myslideshow_images][%s][id]" value="%s" />', esc_attr( $image['id'] ), esc_attr( $image['id'] ) );

					$field_2 .= '<table class="form-table" role="presentation">';

					$field_2 .= '<tbody>';

					$field_2 .= '<tr>';

					$field_2 .= '<th scope="row">Image Title Text</th>';

					$field_2 .= '<td>';

					$field_2 .= sprintf( '<input class="regular-text" type="text" name="myslideshow_options[myslideshow_images][%s][title]" value="%s" />', esc_attr( $image['id'] ), esc_attr( $image['title'] ) );

					$field_2 .= '</td>';

					$field_2 .= '</tr>';

					$field_2 .= '<tr>';

					$field_2 .= '<th scope="row">Image Alt Text</th>';

					$field_2 .= '<td>';

					$field_2 .= sprintf( '<input class="regular-text" type="text" name="myslideshow_options[myslideshow_images][%s][alt]" value="%s" />', esc_attr( $image['id'] ), esc_attr( $image['alt'] ) );

					$field_2 .= '</td>';

					$field_2 .= '</tr>';

					$field_2 .= '<tr>';

					$field_2 .= '<th scope="row">Link URL (optional)</th>';

					$field_2 .= '<td>';

					$field_2 .= sprintf( '<input class="regular-text" type="text" name="myslideshow_options[myslideshow_images][%s][url]" value="%s" />', esc_attr( $image['id'] ), esc_attr( $image['url'] ) );

					$field_2 .= '</td>';

					$field_2 .= '</tr>';

					$field_2 .= '</tbody>';

					$field_2 .= '</table>';

					$field_2 .= '</div>';

					$field_2 .= '</div>';

					$field_2 .= '</li>';
				}
			}
		}

		$field_2 .= '</ul>';
		
		$this->assertSame( 
			$field, 
			$field_2
		);
	}
}
