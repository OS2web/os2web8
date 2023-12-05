document.addEventListener("DOMContentLoaded", function() {
  var accordionButtons = document.querySelectorAll('.accordion-button');

  function hideSiblingContents(currentButton) {
    // Check if the clicked button is a nested accordion
    var isNestedAccordion = currentButton.closest('.entity-default').parentElement.tagName === 'DIV';

    // If it's a nested accordion, we don't want to close the parent
    if (isNestedAccordion) {
      return;
    }

    // Get the closest 'li' ancestor to scope the siblings
    var parentListItem = currentButton.closest('li');

    // Select only the sibling accordion contents within this 'li'
    var siblingAccordions = parentListItem.parentElement.querySelectorAll(':scope > li > .entity-default > .accordion-content.opened');

    siblingAccordions.forEach(function(content) {
      if (content !== currentButton.nextElementSibling) {
        content.classList.remove('opened');
        content.previousElementSibling.setAttribute('aria-expanded', 'false');
      }
    });
  }

  accordionButtons.forEach(function(button) {
    button.addEventListener('click', function(event) {
      var contentId = button.getAttribute('aria-controls');
      var content = document.getElementById(contentId);
      var isOpening = !content.classList.contains('opened');

      // Hide all sibling contents
      hideSiblingContents(button);

      // Toggle the current accordion
      if (isOpening) {
        content.classList.add('opened');
        button.setAttribute('aria-expanded', 'true');
      } else {
        content.classList.remove('opened');
        button.setAttribute('aria-expanded', 'false');
      }
    });
  });
});
