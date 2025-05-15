(function ($, Drupal, drupalSettings) {
  Drupal.behaviors.navigateBack = {
    attach: function (context, settings) {
      // Function to check if the current page is a search page
      function isSearchPage(url) {
        return url.includes('/soeg');
      }

      // Function to go to homepage
      function goToHomepage() {
        window.location.href = drupalSettings.path.baseUrl || '/';
      }

      // Handle the close button click
      $('.search-close-btn', context).once('navigate-back').click(function (e) {
        e.preventDefault();

        // Check if history API is available
        if (window.history && window.history.length > 1) {
          // Go back one step at a time until we find a non-search page
          window.history.back();

          // After going back, check if we landed on another search page
          setTimeout(function checkCurrentPage() {
            if (isSearchPage(window.location.href)) {
              // If we're still on a search page and have history left, go back again
              if (window.history.length > 1) {
                window.history.back();
                setTimeout(checkCurrentPage, 100); // Check again after the next back
              } else {
                goToHomepage();
              }
            }
          }, 100);
        } else {
          goToHomepage();
        }
      });
    }
  };
})(jQuery, Drupal, drupalSettings);
