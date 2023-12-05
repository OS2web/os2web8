document.addEventListener("DOMContentLoaded", function() {
  var accordionButtons = document.querySelectorAll('.accordion-button');

  function hideSiblingContents(currentButton) {
    var isNestedAccordion = currentButton.closest('.entity-default').parentElement.tagName === 'DIV';

    if (isNestedAccordion) {
      return;
    }

    var parentListItem = currentButton.closest('li');
    var siblingAccordions = parentListItem.parentElement.querySelectorAll(':scope > li > .entity-default > .accordion-content.opened');

    siblingAccordions.forEach(function(content) {
      if (content !== currentButton.nextElementSibling) {
        content.classList.remove('opened');
        content.previousElementSibling.setAttribute('aria-expanded', 'false');
      }
    });
  }

  function toggleAccordion(button, isOpening) {
    var contentId = button.getAttribute('aria-controls');
    var content = document.getElementById(contentId);

    if (isOpening) {
      content.classList.add('opened');
      button.setAttribute('aria-expanded', 'true');
      window.location.hash = contentId;
    } else {
      content.classList.remove('opened');
      button.setAttribute('aria-expanded', 'false');
    }
  }

  accordionButtons.forEach(function(button) {
    button.addEventListener('click', function(event) {
      var isOpening = !button.nextElementSibling.classList.contains('opened');
      hideSiblingContents(button);
      toggleAccordion(button, isOpening);
    });
  });

  if (window.location.hash) {
    var hash = window.location.hash.substring(1); // Remove the '#' from the hash
    var targetAccordionButton = document.querySelector(`[aria-controls="${hash}"]`);
    if (targetAccordionButton) {
      toggleAccordion(targetAccordionButton, true);
    }
  }
});
