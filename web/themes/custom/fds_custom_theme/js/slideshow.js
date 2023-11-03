/*
 * Used for paragraph slideshow.
 */


// Tiny Slider slideshow img.
(function($, Drupal, drupalSettings) {
  var selector = '.field--name-field-os2web-slideshow-image .field__items';

  if (document.querySelector(selector) !== null) {
    var items = 2;
    if  (typeof drupalSettings.os2web_slideshow_paragraph.items !== 'undefined') {
      items = drupalSettings.os2web_slideshow_paragraph.items;
    }
    // Run tiny slider.
    tns({
      container: selector,
      items: 1,
      autoplay: true,
      autoplayHoverPause: true,
      gutter: 32,
      rewind: true,
      responsive: {
        576: {
          items: 2,
        },
      },
    });


  }

})(jQuery, Drupal, drupalSettings);

(function ($) {
  $(document).ready(function() {
    $('.fancy-slide').fancybox({
      loop: true
      // Add any other Fancybox options you'd like here.
    });
  });
})(jQuery);

