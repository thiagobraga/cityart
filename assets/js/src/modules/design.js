$(function () {
  'use strict';

  $('.owl-carousel').owlCarousel({
    center:          true,
    dots:            true,
    items:           1,
    loop:            false,
    margin:          0,
    nav:             true,
    responsiveClass: true,

    navText: [
      '<i class="ionicons ion-arrow-left-b"></i>',
      '<i class="ionicons ion-arrow-right-b"></i>'
    ]
  });
});
