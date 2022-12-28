<?php
/**
 * MySlideshow plugin tests
 *
 * @category  Test
 * @package   MySlideshow
 * @author    Oscar Fernandez <oskarvisual@gmail.com>
 * @copyright 2022 MySlideshow
 * @license   GPLv2 or later
 * @link      https://www.linkedin.com/in/oscarfer/
 */

/** A class that extends the WP_UnitTestCase class. */
class Test_WP_MySlideshow_Plugin extends WP_UnitTestCase {

	/**
	 * Class Test_WP_MySlideshow_Plugin
	 *
	 * @var myslideshow_plugin var to assigns the myslideshow_plugin object. */
	private $myslideshow_plugin;

	/**
	 * It sets up the plugin
	 */
	public function setUp():void {
		parent::setUp();

		/* Including the class-myslideshow-plugin.php file. */
		require_once MYSLIDESHOW_PLUGIN_DIR . 'includes/class-myslideshow-plugin.php';

		/* Creating a new instance of the MySlideshow_Plugin class. */
		$this->myslideshow_plugin = new MySlideshow_Plugin();
	}

	/**
	 * Test of Plugin activation
	 */
	public function test_plugin_activation():void {
		$this->assertTrue( $this->myslideshow_plugin->plugin_activation() );
	}

	/**
	 * It checks if the plugin is active.
	 */
	public function test_plugin_check():void {
		$this->assertTrue( $this->myslideshow_plugin->plugin_check() );
	}

	/**
	 * Test of Plugin desactivation
	 */
	public function test_plugin_deactivation():void {
		$this->assertTrue( $this->myslideshow_plugin->plugin_deactivation() );
	}
}
