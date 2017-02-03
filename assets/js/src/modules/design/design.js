$(function () {
  'use strict';

  $('#carousel').flexslider({
    animation:     'slide',
    animationLoop: false,
    controlNav:    false,
    slideshow:     false,
    sync:          '#thumbnails'
  });

  $('#thumbnails').flexslider({
    animation:     'slide',
    animationLoop: false,
    asNavFor:      '#carousel',
    controlNav:    false,
    itemMargin:    5,
    itemWidth:     210,
    slideshow:     false
  });
});
