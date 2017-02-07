$(function () {
  'use strict';

  if ($('#thumbnails')) {
    $('#thumbnails').flexslider({
      animation:     'slide',
      animationLoop: true,
      asNavFor:      '#carousel',
      controlNav:    false,
      itemMargin:    25,
      itemWidth:     146, // 138 + 8 (borders)
      slideshow:     false,
      prevText:      '',
      nextText:      ''
    });

    $('#carousel').flexslider({
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
