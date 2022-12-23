<?php
class MySlideShowShortcode {
	private array $myslideshow_options;

	public function __construct() {
		$this->myslideshow_options = get_option( 'myslideshow_options' );
	}

	public function run():void {
		add_action('wp_enqueue_scripts', function () {
			wp_enqueue_style(MYSLIDESHOW_NAME . "-shortcode-glider-style", 'https://cdn.jsdelivr.net/npm/glider-js@1/glider.min.css', [], MYSLIDESHOW_VERSION, 'all');

			wp_enqueue_style(MYSLIDESHOW_NAME . "-shortcode-style", MYSLIDESHOW_PLUGIN_URL . 'shortcodes/css/myslideshow.css', [], MYSLIDESHOW_VERSION, 'all');
			
			wp_enqueue_script( MYSLIDESHOW_NAME . '-shortcode-glider-script', 'https://cdn.jsdelivr.net/npm/glider-js@1/glider.min.js', array( 'jquery' ), MYSLIDESHOW_VERSION, false );

			wp_enqueue_script( MYSLIDESHOW_NAME . '-shortcode-script', MYSLIDESHOW_PLUGIN_URL . 'shortcodes/js/myslideshow.js', array( 'jquery' ), MYSLIDESHOW_VERSION, false );
		});

		$this->myslideshow_shortcode();
	}

	private function myslideshow_shortcode()  {
		add_shortcode(MYSLIDESHOW_NAME, function ($shortcode_attributes) {
			$attributes = shortcode_atts([
				'arrows' => '1',
				'dots' => '1'
			], $shortcode_attributes);

			ob_start();

			echo '<div class="glider-contain">';

				echo '<div class="glider myslideshow">';

					if(isset($this->myslideshow_options['myslideshow_images'])){
						$images = json_decode($this->myslideshow_options['myslideshow_images'], true);

						if(is_array($images)){
							foreach ($images as $key => $image) {
								echo '<div class="myslideshow__item">';

									
									if(!empty(@$image["url"])){
										printf('<a href="%s">', esc_attr($image["url"]));
									}
										printf('<img src="%s" class="myslideshow__image" title="%s" alt="%s" />', wp_get_attachment_image_url(esc_attr($image["id"]), 'full', false ), esc_attr($image["title"]), esc_attr($image["alt"]));

										if(!empty(@$image["url"])){
											printf('<h2 class="myslideshow__title">%s</h2>', esc_attr($image["title"]));
										}

									if(!empty(@$image["url"])){
										echo '</a>';
									}

								echo '</div>';

							}
						}
					}

				echo '</div>';

				echo '<button aria-label="Previous" class="glider-prev">«</button>';

				echo '<button aria-label="Next" class="glider-next">»</button>';

				echo '<div role="tablist" class="dots"></div>';
			
			echo '</div>';

			return ob_get_clean();
		});
	}
}
