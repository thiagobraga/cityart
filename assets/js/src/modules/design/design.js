$(function () {
  'use strict';

  var options,
    thumbnails = $('#thumbnails'),
    carousel = $('#carousel');

  if (thumbnails.length) {
    options = {
      animation:     'slide',
      animationLoop: true,
      asNavFor:      '#carousel',
      controlNav:    false,
      itemMargin:    25,
      itemWidth:     146, // 138 + 8 (borders)
      slideshow:     false,
      prevText:      '',
      nextText:      ''
    };

    thumbnails.flexslider(options);

    carousel.flexslider({
      animation:     'slide',
      animationLoop: true,
      directionNav:  false,
      controlNav:    false,
      slideshow:     false,
      smoothHeight:  true,
      sync:          '#thumbnails'
    });
  }

});
