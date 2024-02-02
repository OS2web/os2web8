(function ($, Drupal, drupalSettings) {
  Drupal.behaviors.navigateBack = {
    attach: function (context, settings) {
      // Updated check for multiple search pages
      const onSearchPage = window.location.href.indexOf('/s?sq=') !== -1 ||
        window.location.href.includes("/sog-selvbetjening?sq=") ||
        window.location.href.includes("/sog-dagsorden?sq=");

      // If not on a search page, store the current URL
      if (!onSearchPage) {
        localStorage.setItem('lastNonSearchPage', window.location.href);
      }

      $('.search-close-btn', context).once('navigate-back').click(function (e) {
        e.preventDefault();

        const storedURL = localStorage.getItem('lastNonSearchPage');
        const referrerIsExternal = !document.referrer.includes(window.location.host);

        // Redirect logic
        if (storedURL && (!referrerIsExternal || onSearchPage)) {
          window.location.href = storedURL;
        } else {
          window.location.href = drupalSettings.path.baseUrl; // Navigate to the front page
        }
      });
    }
  };
})(jQuery, Drupal, drupalSettings);
