/*
 * Used for paragraph slideshow.
 */

// Tiny Slider slideshow img.
(function($, Drupal, drupalSettings) {
  var selector = '.field--name-field-os2web-slideshow-media-ref.field--view-mode--default .field__items';

  if (document.querySelector(selector) !== null) {
    var items = 2;
    // Run tiny slider.
    tns({
      container: selector,
      items: 1,
      autoplay: false,
      autoplayHoverPause: true,
      gutter: 32,
      rewind: true,
    });
  }
})(jQuery, Drupal, drupalSettings);
