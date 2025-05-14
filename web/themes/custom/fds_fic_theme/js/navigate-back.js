(function ($, Drupal, drupalSettings) {
  Drupal.behaviors.navigateBack = {
    attach: function (context, settings) {
      // Function to check if the current page is one of the search pages
      function isSearchPage(url) {
        return url.includes('/soeg');
      }

      // Store the current page URL if it's not a search page
      if (!isSearchPage(window.location.href)) {
        localStorage.setItem('lastNonSearchPage', window.location.href);
      }

      // Handle the close button click
      $('.search-close-btn', context).once('navigate-back').click(function (e) {
        e.preventDefault();
        e.stopPropagation();

        // Retrieve the last non-search page URL from localStorage
        const lastNonSearchPage = localStorage.getItem('lastNonSearchPage');

        // Navigate back to the last non-search page or front page
        if (lastNonSearchPage && lastNonSearchPage !== window.location.href) {
          window.location.href = lastNonSearchPage;
        } else {
          // If no valid previous page is found, go to the front page
          window.location.href = drupalSettings.path.baseUrl || '/';
        }
      });
    }
  };
})(jQuery, Drupal, drupalSettings);
