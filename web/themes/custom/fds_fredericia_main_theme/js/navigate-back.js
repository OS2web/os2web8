(function ($, Drupal, drupalSettings) {
  Drupal.behaviors.navigateBack = {
    attach: function (context, settings) {
      $('.search-close-btn', context).once('navigate-back').click(function (e) {
        e.preventDefault();

        // Check if the previous page was within your site and is not a paginated page
        if (document.referrer.indexOf(window.location.hostname) !== -1 && !document.referrer.match(/page=\d+/)) {
          window.history.back();
        } else {
          window.location.href = drupalSettings.path.baseUrl; // Navigate to the front page
        }
      });
    }
  };
})(jQuery, Drupal, drupalSettings);
