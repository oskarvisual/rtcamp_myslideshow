<?php
class MySlidehow_Shortcode {
	private array $myslideshow_options;

	public function __construct() {
		$this->myslideshow_options = get_option( 'myslideshow_options' );
	}

	public function run():void {
		add_action('wp_enqueue_scripts', function () {
			wp_enqueue_style( 'dashicons' );

			wp_enqueue_style( MYSLIDESHOW_NAME . "-glider", MYSLIDESHOW_PLUGIN_URL . 'shortcodes/css/glider.min.css', [], MYSLIDESHOW_VERSION, 'all');

			wp_enqueue_style( MYSLIDESHOW_NAME, MYSLIDESHOW_PLUGIN_URL . 'shortcodes/css/myslideshow.css', [], MYSLIDESHOW_VERSION, 'all');
			
			wp_enqueue_script( MYSLIDESHOW_NAME . '-glider', MYSLIDESHOW_PLUGIN_URL . 'shortcodes/js/glider.min.js', array( 'jquery' ), MYSLIDESHOW_VERSION, false );

			wp_enqueue_script( MYSLIDESHOW_NAME, MYSLIDESHOW_PLUGIN_URL . 'shortcodes/js/myslideshow.js', array( 'jquery' ), MYSLIDESHOW_VERSION, false );
		});

		$this->myslideshow_shortcode();
	}

	private function myslideshow_shortcode()  {
		add_shortcode( MYSLIDESHOW_NAME, function ($shortcode_attributes) {
			$attributes = shortcode_atts([
				'slides' => 1,
				'title' => 1,
				'arrows' => 1,
				'dots' => 1
			], $shortcode_attributes);

			ob_start();

			echo '<div class="glider-contain">';

				printf('<div class="glider myslideshow" id="myslideshow" data-slides="%s" data-arrows="%s" data-dots="%s">', $attributes['slides'], $attributes['arrows'], $attributes['dots']);

					if(isset($this->myslideshow_options['myslideshow_images'])){
						$images = json_decode($this->myslideshow_options['myslideshow_images'], true);

						if(is_array($images)){
							foreach ($images as $key => $image) {
								echo '<div class="myslideshow__item">';

									
									if(!empty(@$image["url"])){
										printf('<a href="%s">', esc_url(@$image["url"]));
									}
										printf('<img src="%s" class="myslideshow__image" title="%s" alt="%s" />', wp_get_attachment_image_url(intval(@$image["id"]), 'full', false ), esc_attr(@$image["title"]), esc_attr(@$image["alt"]));

										if(!empty(@$image["title"]) && $attributes['title'] == 1){
											printf('<h2 class="myslideshow__title">%s</h2>', esc_html(@$image["title"]));
										}

									if(!empty(@$image["url"])){
										echo '</a>';
									}

								echo '</div>';

							}
						}
					}

				echo '</div>';

				if($attributes['arrows'] == 1){
					echo '<button aria-label="Previous" class="glider-prev myslideshow__button myslideshow__button--prev" id="myslideshow-prev"><span class="dashicons dashicons-arrow-left-alt2"></span></button>';

					echo '<button aria-label="Next" class="glider-next myslideshow__button myslideshow__button--next" id="myslideshow-next"><span class="dashicons dashicons-arrow-right-alt2"></span></button>';
				}

				if($attributes['dots'] == 1){
					echo '<div role="tablist" class="glider-dots myslideshow__dots" id="myslideshow-dots"></div>';
				}
			
			echo '</div>';

			return ob_get_clean();
		});
	}
}
