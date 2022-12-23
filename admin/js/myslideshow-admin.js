(function( $ ) {
	'use strict';

	$(function() {

		$( "#slider" ).sortable();

		$('.myslideshow__delete').click(function() {
			$("#slider-item-" + $(this).data('id')).remove();
		})

		$('#upload_image').click(open_custom_media_window);

		function open_custom_media_window() {
			if (this.window === undefined) {
				this.window = wp.media({
					title: 'Insert Images',
					library: {type: 'image'},
					multiple: true,
					button: {text: 'Insert Images'}
				});

				var self = this;
				this.window.on('select', function() {
					var response = self.window.state().get('selection').toJSON();

					response.forEach(function(data, index) {
						if(!$("#slider-item-" + data.id).length){
					      $( "#slider" ).append(`
					      	<li class="myslideshow__item" id="slider-item-${data.id}">
					      		
					      		<span class="myslideshow__move dashicons dashicons-move"></span>
					      		<span class="myslideshow__delete dashicons dashicons-trash" data-id="${data.id}"></span>

					      		<div class="myslideshow__content">
					      			<div class="myslideshow__thumbnail">
					      				<img src="${data.sizes.thumbnail.url}" class="myslideshow__image" />
					      			</div>
					      			<div class="myslideshow__form">
							      		<input type="hidden" name="myslideshow_options[myslideshow_images][${data.id}][id]" value="${data.id}" />

					      				<table class="form-table" role="presentation">
					      					<tbody>
					      						<tr>
					      							<th scope="row">Image Title Text</th>
					      							<td>
					      								<input class="regular-text" type="text" name="myslideshow_options[myslideshow_images][${data.id}][title]" value="${data.title}" />
					      							</td>
					      						</tr>
					      						<tr>
					      							<th scope="row">Image Alt Text</th>
					      							<td>
					      								<input class="regular-text" type="text" name="myslideshow_options[myslideshow_images][${data.id}][alt]" value="" />
					      							</td>
					      						</tr>
					      						<tr>
					      							<th scope="row">Link URL (optional)</th>
					      							<td>
					      								<input class="regular-text" type="text" name="myslideshow_options[myslideshow_images][${data.id}][url]" value="" />
					      							</td>
					      						</tr>
					      					</tbody>
					      				</table>
					      			</div>
					      		</div>
					      	</li>`
					      	);
						}
				    });
				});
			}

			this.window.open();
			return false;
		}
	});
})( jQuery );