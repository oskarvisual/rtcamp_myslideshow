(function( $ ) {
	/* A directive to the browser to use strict mode. */
	'use strict';

	$(function() {

		/* It's a jQuery UI function that makes the list items sortable. */
		$( "#slider" ).sortable();

		/* It's a jQuery function that removes the list item when the delete button is clicked. */
		$('.myslideshow__delete').click(function() {
			$("#slider-item-" + $(this).data('id')).remove();
		});

		/* It's a jQuery function that calls the `open_custom_media_window` function when the `#upload_image`
		button is clicked. */
		$('#upload_image').click(open_custom_media_window);

		/* It's a function that opens the media window. */
		function open_custom_media_window() {
			/* It's checking if the `window` variable is undefined. If it is, it will create a new window. */
			if (this.window === undefined) {
				/* It's creating a new media window. */
				this.window = wp.media({
					title: 'Insert Images',
					library: {type: 'image'},
					multiple: true,
					button: {text: 'Insert Images'}
				});

				var self = this;
				this.window.on('select', function() {
					/* It's getting the selected images from the media window and converting it to JSON. */
					var response = self.window.state().get('selection').toJSON();

					/* It's a forEach loop that loops through the response array and create a item to the slider. */
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

			/* It's opening the media window and returning false. */
			this.window.open();
			return false;
		}
	});
})( jQuery );