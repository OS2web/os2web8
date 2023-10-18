(function ($, Drupal, drupalSettings) {
  Drupal.behaviors.navigateBack = {
    attach: function (context, settings) {
      $('.search-close-btn', context).once('navigate-back').click(function (e) {
        e.preventDefault();

        let referrer = document.referrer;
        let currentLocation = window.location.href;

        // Check if the referrer is the search page without pagination
        let isSearchPage = referrer.indexOf('/s?sq=') !== -1 && referrer.indexOf('page=') === -1;

        // Check if the previous page was within your site and is not a paginated page or the search page
        if (referrer.indexOf(window.location.hostname) !== -1 && !isSearchPage && !referrer.match(/page=\d+/)) {
          window.history.back();
        } else {
          window.location.href = drupalSettings.path.baseUrl; // Navigate to the front page
        }
      });
    }
  };
})(jQuery, Drupal, drupalSettings);
