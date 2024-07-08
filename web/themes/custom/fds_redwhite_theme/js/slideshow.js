// Tiny Slider slideshow img.
'use strict';

(function($, Drupal, drupalSettings) {
  var selector = '.field--name-field-os2web-slideshow-image .field__items';

  if (document.querySelector(selector) !== null) {
    // Run tiny slider.
    tns({
      container: selector,
      items: 1,
      autoplay: true,
      autoplayHoverPause: true,
      gutter: 32,
      rewind: true,
    });
  }
})(jQuery, Drupal, drupalSettings);
