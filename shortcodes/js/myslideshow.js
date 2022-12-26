(function( $ ) {
  /* A directive to the browser to use strict mode. */
  'use strict';

  $(function() {

    /* Setting the default values for the variables. */
	let slides = 1;
    let arrows = {};
    let dots = '';

    /* This is a conditional statement that checks if the data attribute `data-slides` is greater than
	or equal to 1. If it is, then the variable `slides` is set to the value of the data attribute. */
	if($('#myslideshow').data('slides') >= 1){
      slides = $('#myslideshow').data('slides');
    }

    /* This is a conditional statement that checks if the data attribute `data-arrows` is equal to 1.
	If it is, then the variable `arrows` is set to the value of the data attribute. */
	if($('#myslideshow').data('arrows') == 1){
      arrows = {
        prev: '#myslideshow-prev',
        next: '#myslideshow-next'
      };
    }

    /* This is a conditional statement that checks if the data attribute `data-dots` is equal to 1. If
	it is, then the variable `dots` is set to the value of the data attribute. */
	if($('#myslideshow').data('dots') == 1){
      dots = '#myslideshow-dots';
    }

    /* Creating a new instance of the Glider object. */
	new Glider(document.querySelector('#myslideshow'), {
      'slidesToShow': slides,
      'dots': dots,
      'arrows': arrows
    });

  });
})( jQuery );