(function ($, Drupal, drupalSettings) {
  Drupal.behaviors.navigateBack = {
    attach: function (context, settings) {
      $('.search-close-btn', context).once('navigate-back').click(function (e) {
        e.preventDefault();

        let referrer = document.referrer;

        // If there's no referrer or it's external, go to the front page
        if (!referrer || referrer.indexOf(window.location.hostname) === -1) {
          window.location.href = drupalSettings.path.baseUrl;
          return;
        }

        // If the referrer is NOT the "/s" pattern, simply navigate back
        if (referrer.indexOf('/s?sq=') === -1) {
          window.history.back();
          return;
        }

        // If we're here, it means the referrer is the "/s" pattern.
        // We'll navigate back until we find a URL that doesn't match the "/s" pattern
        let stepsBack = 1;
        let previousUrl = window.history.go(-stepsBack);

        while (previousUrl.indexOf('/s?sq=') !== -1 && previousUrl.indexOf(window.location.hostname) !== -1) {
          stepsBack++;
          previousUrl = window.history.go(-stepsBack);
        }

        window.history.go(-stepsBack);
      });
    }
  };
})(jQuery, Drupal, drupalSettings);
