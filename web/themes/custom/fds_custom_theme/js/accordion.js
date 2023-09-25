document.addEventListener("DOMContentLoaded", function() {
  var accordionButtons = document.querySelectorAll('.js-accordion-add-link');

  function hideAllContents() {
    var allContents = document.querySelectorAll('.accordion-content.opened');
    allContents.forEach(function(content) {
      content.classList.remove('opened');
      // Handle aria-expanded for accessibility
      content.previousElementSibling.setAttribute('aria-expanded', 'false');
    });
  }

  accordionButtons.forEach(function(button) {
    button.addEventListener('click', function(event) {
      console.log('clicked');
      var contentId = button.getAttribute('aria-controls');
      var content = document.getElementById(contentId);
      var isOpening = !content.classList.contains('opened');

      // Hide all other contents
      hideAllContents();

      if (isOpening) {
        content.classList.add('opened');
        // Handle aria-expanded for accessibility
        button.setAttribute('aria-expanded', 'true');
      }
    });
  });
});
