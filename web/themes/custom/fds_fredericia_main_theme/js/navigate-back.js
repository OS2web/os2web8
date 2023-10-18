(function ($, Drupal, drupalSettings) {
  Drupal.behaviors.navigateBack = {
    attach: function (context, settings) {
      // Store the current URL when it's not a search page.
      if (window.location.href.indexOf('/s?sq=') === -1) {
        localStorage.setItem('lastNonSearchPage', window.location.href);
      }

      $('.search-close-btn', context).once('navigate-back').click(function (e) {
        e.preventDefault();

        const storedURL = localStorage.getItem('lastNonSearchPage');

        if (storedURL) {
          window.location.href = storedURL;
        } else {
          window.location.href = drupalSettings.path.baseUrl; // Navigate to the front page
        }
      });
    }
  };
})(jQuery, Drupal, drupalSettings);
