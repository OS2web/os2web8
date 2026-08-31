(function (drupalSettings) {
  'use strict';

  var pixelId = drupalSettings.fds_fic_theme && drupalSettings.fds_fic_theme.facebookPixelId;
  if (!pixelId) {
    return;
  }

  var loaded = false;

  function getCookieInformationApi() {
    return window.CookieInformation || window.cookieInformation || null;
  }

  function hasMarketingConsent() {
    var api = getCookieInformationApi();
    if (!api || typeof api.getConsentGivenFor !== 'function') {
      return false;
    }

    try {
      return api.getConsentGivenFor('cookie_cat_marketing') === true;
    }
    catch (error) {
      return false;
    }
  }

  function loadFacebookPixel() {
    if (loaded) {
      return;
    }

    if (window.fbq) {
      window.fbq('init', pixelId);
      window.fbq('track', 'PageView');
      loaded = true;
      return;
    }

    var n = window.fbq = function () {
      n.callMethod ? n.callMethod.apply(n, arguments) : n.queue.push(arguments);
    };
    if (!window._fbq) {
      window._fbq = n;
    }
    n.push = n;
    n.loaded = true;
    n.version = '2.0';
    n.queue = [];

    var script = document.createElement('script');
    script.async = true;
    script.src = 'https://connect.facebook.net/en_US/fbevents.js';
    var firstScript = document.getElementsByTagName('script')[0];
    if (firstScript && firstScript.parentNode) {
      firstScript.parentNode.insertBefore(script, firstScript);
    }
    else {
      document.head.appendChild(script);
    }

    window.fbq('init', pixelId);
    window.fbq('track', 'PageView');
    loaded = true;
  }

  function maybeLoadFacebookPixel() {
    if (hasMarketingConsent()) {
      loadFacebookPixel();
    }
  }

  window.addEventListener('CookieInformationConsentGiven', maybeLoadFacebookPixel);

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', maybeLoadFacebookPixel);
  }
  else {
    maybeLoadFacebookPixel();
  }

  // Cookie Information may become available shortly after this script.
  var attempts = 0;
  var consentPoll = window.setInterval(function () {
    attempts += 1;
    maybeLoadFacebookPixel();
    if (loaded || attempts >= 100) {
      window.clearInterval(consentPoll);
    }
  }, 100);
})(drupalSettings);
