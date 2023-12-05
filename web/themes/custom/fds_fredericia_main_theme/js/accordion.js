document.addEventListener("DOMContentLoaded", function() {
  var accordionButtons = document.querySelectorAll('.accordion-button');

  function hideAllContents(currentButton) {
    // Find the closest ancestor that represents the parent accordion container
    var parentAccordion = currentButton.closest('.accordion-container');

    // Only select the opened accordion contents within this container
    var allContents = parentAccordion.querySelectorAll('.accordion-content.opened');
    allContents.forEach(function(content) {
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

      // Hide all other contents within the same accordion container
      hideAllContents(button);

      if (isOpening) {
        content.classList.add('opened');
        button.setAttribute('aria-expanded', 'true');
      }
    });
  });
});
