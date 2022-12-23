(function( $ ) {
  'use strict';

  $(function() {

    new Glider(document.querySelector('.glider'), {
      slidesToShow: 1,
      dots: '#dots',
      draggable: true,
      arrows: {
        prev: '.glider-prev',
        next: '.glider-next'
      }
    });

  });
})( jQuery );