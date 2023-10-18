(function ($, Drupal, drupalSettings) {
  Drupal.behaviors.navigateBack = {
    attach: function (context, settings) {
      // Check if we're on the search page.
      const onSearchPage = window.location.href.indexOf('/s?sq=') !== -1;

      // If not on search page, store the current URL.
      if (!onSearchPage) {
        localStorage.setItem('lastNonSearchPage', window.location.href);
      }

      $('.search-close-btn', context).once('navigate-back').click(function (e) {
        e.preventDefault();

        const storedURL = localStorage.getItem('lastNonSearchPage');
        const referrerIsExternal = !document.referrer.includes(window.location.host);

        // If there's a stored URL and we're not coming from an external source or empty tab, use it.
        if (storedURL && (!referrerIsExternal || onSearchPage)) {
          window.location.href = storedURL;
        } else {
          window.location.href = drupalSettings.path.baseUrl; // Navigate to the front page
        }
      });
    }
  };
})(jQuery, Drupal, drupalSettings);
