(function ($, Drupal, drupalSettings) {
  Drupal.behaviors.navigateBack = {
    attach: function (context, settings) {
      // Function to check if the current page is one of the search pages
      function isSearchPage(url) {
        return url.includes('/s?sq=') || url.includes('/sog-selvbetjening?sq=') || url.includes('/sog-dagsorden?sq=');
      }

      // Store the current page URL if it's not a search page
      if (!isSearchPage(window.location.href)) {
        localStorage.setItem('lastNonSearchPage', window.location.href);
      }

      // Handle the close button click
      $('.search-close-btn', context).once('navigate-back').click(function (e) {
        e.preventDefault();

        // Retrieve the last non-search page URL from localStorage
        const lastNonSearchPage = localStorage.getItem('lastNonSearchPage');

        // Determine if there's a valid non-search page to redirect to
        if (lastNonSearchPage) {
          window.location.href = lastNonSearchPage;
        } else {
          // Redirect to the front page if no valid non-search page is found
          window.location.href = drupalSettings.path.baseUrl;
        }
      });
    }
  };
})(jQuery, Drupal, drupalSettings);
