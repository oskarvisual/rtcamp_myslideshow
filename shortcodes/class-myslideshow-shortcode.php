<?php
/**
 * MySlideshow_Shortcode Class
 *
 * @category  Class
 * @package   MySlideshow
 * @author    Oscar Fernandez <oskarvisual@gmail.com>
 * @copyright 2022 MySlideshow
 * @license   GPLv2 or later
 * @link      https://www.linkedin.com/in/oscarfer/
 */

/** It creates a class called MySlideshow_Shortcode. */
class MySlideshow_Shortcode {
	/**
	 * Class MySlideshow_Shortcode
	 *
	 * @var myslideshow_options array to assigns the myslideshow_options optionAssigns. */
	private array $myslideshow_options;

	/**
	 * It creates a new instance of the class and assigns the value of the myslideshow_options option to
	 * the myslideshow_options property
	 * It adds a function to the `wp_enqueue_scripts` action hook that enqueues the styles and scripts
	 * needed for the slideshow
	 */
	public function __construct() {
		$this->myslideshow_options = get_option( 'myslideshow_options' );

		add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );
		add_shortcode( MYSLIDESHOW_NAME, array( $this, 'shortcode' ) );
	}

	/**
	 * It adds a function to the `wp_enqueue_scripts` action hook that enqueues the styles and scripts
	 * needed for the slideshow
	 */
	public function wp_enqueue_scripts():void {
		wp_enqueue_style( 'dashicons' );
		wp_enqueue_style( MYSLIDESHOW_NAME . '-glider', MYSLIDESHOW_PLUGIN_URL . 'shortcodes/css/glider.min.css', array(), MYSLIDESHOW_VERSION, 'all' );
		wp_enqueue_style( MYSLIDESHOW_NAME, MYSLIDESHOW_PLUGIN_URL . 'shortcodes/css/myslideshow.css', array(), MYSLIDESHOW_VERSION, 'all' );
		wp_enqueue_script( MYSLIDESHOW_NAME . '-glider', MYSLIDESHOW_PLUGIN_URL . 'shortcodes/js/glider.min.js', array( 'jquery' ), MYSLIDESHOW_VERSION, false );
		wp_enqueue_script( MYSLIDESHOW_NAME, MYSLIDESHOW_PLUGIN_URL . 'shortcodes/js/myslideshow.js', array( 'jquery' ), MYSLIDESHOW_VERSION, false );
	}

	/**
	 * It adds a shortcode to WordPress that will display the slideshow
	 *
	 * @param array $shortcode_attributes array of shortcode attributes.
	 */
	public function shortcode( $shortcode_attributes ):string {
		$attributes = shortcode_atts(
			array(
				'slides' => 1,
				'title'  => 1,
				'arrows' => 1,
				'dots'   => 1,
			),
			$shortcode_attributes
		);

		ob_start();

		echo '<div class="glider-contain">';

		printf( '<div class="glider myslideshow" id="myslideshow" data-slides="%s" data-arrows="%s" data-dots="%s">', esc_attr( $attributes['slides'] ), esc_attr( $attributes['arrows'] ), esc_attr( $attributes['dots'] ) );

		if ( isset( $this->myslideshow_options['myslideshow_images'] ) ) {
			$images = json_decode( $this->myslideshow_options['myslideshow_images'], true );

			if ( is_array( $images ) ) {
				foreach ( $images as $key => $image ) {
					echo '<div class="myslideshow__item">';

					if ( ! empty( $image['url'] ) ) {
						printf( '<a href="%s">', esc_url( $image['url'] ) );
					}
					printf( '<img src="%s" class="myslideshow__image" title="%s" alt="%s" />', esc_url( wp_get_attachment_image_url( intval( $image['id'] ), 'full', false ) ), esc_attr( $image['title'] ), esc_attr( $image['alt'] ) );

					if ( ! empty( $image['title'] ) && 1 === $attributes['title'] ) {
						printf( '<h2 class="myslideshow__title">%s</h2>', esc_html( $image['title'] ) );
					}

					if ( ! empty( $image['url'] ) ) {
						echo '</a>';
					}

					echo '</div>';

				}
			}
		}

		echo '</div>';

		if ( 1 === $attributes['arrows'] ) {
			echo '<button aria-label="Previous" class="glider-prev myslideshow__button myslideshow__button--prev" id="myslideshow-prev"><span class="dashicons dashicons-arrow-left-alt2"></span></button>';

			echo '<button aria-label="Next" class="glider-next myslideshow__button myslideshow__button--next" id="myslideshow-next"><span class="dashicons dashicons-arrow-right-alt2"></span></button>';
		}

		if ( 1 === $attributes['dots'] ) {
			echo '<div role="tablist" class="glider-dots myslideshow__dots" id="myslideshow-dots"></div>';
		}

		echo '</div>';

		return ob_get_clean();
	}
}
