$(function () {
  'use strict';

  var owl = $('.owl-carousel');

  if (owl.length) {
    owl.owlCarousel({
      center:              true,
      dots:                false,
      items:               1,
      loop:                true,
      margin:              0,
      nav:                 true,
      responsiveClass:     true,
      thumbs:              true,
      thumbsPrerendered:   true,

      navText: [
        '<i class="ionicons ion-arrow-left-b"></i>',
        '<i class="ionicons ion-arrow-right-b"></i>'
      ]
    });
  }

});
