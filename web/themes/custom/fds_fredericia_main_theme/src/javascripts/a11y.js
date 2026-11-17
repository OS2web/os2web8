// Accessibility helpers for Fredericia.
(function () {
  function enhanceSearch() {
    var searchInputs = document.querySelectorAll('.search-input__input');
    var searchSubmits = document.querySelectorAll('.search-input__button');

    for (var i = 0; i < searchInputs.length; i++) {
      var input = searchInputs[i];
      if (!input.getAttribute('aria-label')) {
        input.setAttribute('aria-label', 'Indtast søgeord');
      }
    }

    for (var j = 0; j < searchSubmits.length; j++) {
      var submit = searchSubmits[j];
      if (!submit.getAttribute('aria-label')) {
        submit.setAttribute('aria-label', 'Søg');
      }
      // Keep icon-only look (CSS hides text), but give WAVE/AT an accessible name.
      if (!submit.value) {
        submit.value = 'Søg';
      }
    }
  }

  function enhanceScrollTop() {
    var buttons = document.querySelectorAll('.scroll-top-button');
    for (var k = 0; k < buttons.length; k++) {
      var button = buttons[k];
      if (!button.getAttribute('aria-label')) {
        button.setAttribute('aria-label', 'Scroll til toppen');
      }
      if (!button.getAttribute('title')) {
        button.setAttribute('title', 'Scroll til toppen');
      }
    }
    return buttons.length > 0;
  }

  enhanceSearch();
  enhanceScrollTop();

  // scroll_top_button injects the link via Drupal.behaviors after load.
  if (document.body && !enhanceScrollTop()) {
    var observer = new MutationObserver(function () {
      if (enhanceScrollTop()) {
        observer.disconnect();
      }
    });
    observer.observe(document.body, { childList: true, subtree: true });
  }
})();
