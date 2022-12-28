<?php
/**
 * MySlideshow plugin tests
 *
 * @category  Test Shortcode
 * @package   MySlideshow
 * @author    Oscar Fernandez <oskarvisual@gmail.com>
 * @copyright 2022 MySlideshow
 * @license   GPLv2 or later
 * @link      https://www.linkedin.com/in/oscarfer/
 */

/** A class that extends the WP_UnitTestCase class. */
class Test_WP_MySlideshow_Shortcode extends WP_UnitTestCase {

	/**
	 * Class Test_WP_MySlideshow_Shortcode
	 *
	 * @var myslideshow_shortcode var to assigns the myslideshow_shortcode object. */
	private $myslideshow_shortcode;

	/**
	 * It sets up the plugin
	 */
	public function setUp():void {
		parent::setUp();

		/* Including the class-myslideshow-plugin.php file. */
		require_once MYSLIDESHOW_PLUGIN_DIR . 'shortcodes/class-myslideshow-shortcode.php';

		$this->myslideshow_shortcode = new MySlideshow_Shortcode();
	}

	/**
	 * It checks to see if the stylesheet and script are registered
	 */
	public function test_setup() {
		$this->assertTrue( Util::has_action( 'wp_enqueue_scripts', $this->myslideshow_shortcode, 'wp_enqueue_scripts' ) );
	}

	/**
	 * Test the shortcode
	 */
	public function test_shortcode() {
		$this->assertIsString( $this->myslideshow_shortcode->shortcode( array() ) );
		
		$attributes = array(
			'slides' => 1,
			'title'  => 1,
			'arrows' => 1,
			'dots'   => 1,
		);

		$this->assertSame( $this->myslideshow_shortcode->shortcode( $attributes ), '<div class="glider-contain">' . sprintf( '<div class="glider myslideshow" id="myslideshow" data-slides="%s" data-arrows="%s" data-dots="%s">', esc_attr( $attributes['slides'] ), esc_attr( $attributes['arrows'] ), esc_attr( $attributes['dots'] ) ) . '</div><button aria-label="Previous" class="glider-prev myslideshow__button myslideshow__button--prev" id="myslideshow-prev"><span class="dashicons dashicons-arrow-left-alt2"></span></button><button aria-label="Next" class="glider-next myslideshow__button myslideshow__button--next" id="myslideshow-next"><span class="dashicons dashicons-arrow-right-alt2"></span></button><div role="tablist" class="glider-dots myslideshow__dots" id="myslideshow-dots"></div></div>' );
	}
}
