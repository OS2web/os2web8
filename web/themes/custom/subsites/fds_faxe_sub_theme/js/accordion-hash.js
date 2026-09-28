/**
 * @file
 * Open accordion items when the URL hash changes on the same page.
 *
 * fds_base_theme only opens from hash on initial page load. In-page links
 * like #paragraph-123 therefore need a hashchange (and popstate) handler.
 */
(function () {
  function openAccordionFromHash() {
    var identifier = window.location.hash;

    // Avoid querySelector('#') SyntaxError and empty hashes.
    if (!identifier || identifier.length < 2) {
      return;
    }

    var accordionItem;
    try {
      accordionItem = document.querySelector(identifier);
    }
    catch (e) {
      return;
    }

    if (!accordionItem) {
      return;
    }

    var listItem = accordionItem.closest('li');
    if (!listItem) {
      return;
    }

    var content = accordionItem.closest('div');
    var button = listItem.querySelector('.accordion-button');
    if (!content || !button) {
      return;
    }

    content.setAttribute('aria-expanded', 'true');
    content.setAttribute('aria-hidden', 'false');
    button.setAttribute('aria-expanded', 'true');

    setTimeout(function () {
      button.scrollIntoView({ behavior: 'smooth' });
    }, 200);
  }

  // Initial load is already handled by fds_base_theme/js/accordion.js.
  window.addEventListener('hashchange', openAccordionFromHash);
  window.addEventListener('popstate', openAccordionFromHash);
})();
