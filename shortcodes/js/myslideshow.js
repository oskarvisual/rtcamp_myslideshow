(function( $ ) {
  'use strict';

  $(function() {

    let slides = 1;
    let arrows = {};
    let dots = '';

    if($('#myslideshow').data('slides') >= 1){
      slides = $('#myslideshow').data('slides');
    }

    if($('#myslideshow').data('arrows') == 1){
      arrows = {
        prev: '#myslideshow-prev',
        next: '#myslideshow-next'
      };
    }

    if($('#myslideshow').data('dots') == 1){
      dots = '#myslideshow-dots';
    }

    new Glider(document.querySelector('#myslideshow'), {
      'slidesToShow': slides,
      'dots': dots,
      'arrows': arrows
    });

  });
})( jQuery );