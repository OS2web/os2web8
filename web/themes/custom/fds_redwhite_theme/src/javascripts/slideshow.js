/*
 * Used for paragraph slideshow.
 */

// Slideshow popup.
(function() {
  function handleClick(event) {
    event.preventDefault();

    var link = this;
    var image = link.querySelector('img');
    var text = image.getAttribute('alt');
    var pathToImage = link.getAttribute('href');
    var wrapper = link.closest('.field--name-field-os2web-slideshow-image');
    var modalNodeElement = wrapper.querySelector('.modal');

    createModal(modalNodeElement, text, pathToImage);
  }

  function createModal(modalNodeElement, text, imagePath) {
    var modalId = modalNodeElement.getAttribute('id');
    var modalBody = modalNodeElement.querySelector('.modal__content');
    modalBody.innerHTML = ''; // Empty the modal content.

    // Create and add image.
    var image = document.createElement('img');
    image.src = imagePath;
    image.alt = text;

    modalBody.appendChild(image);

    // Set text.
    var caption = document.createElement('h4');
    caption.innerText = text;

    modalBody.appendChild(caption);

    // Open modal.
    MicroModal.show(modalId);
  }

  var links = document.querySelectorAll('.field--name-field-os2web-slideshow-image .field__item a');

  for (var i = 0; i < links.length; i++) {
    var link = links[i];

    link.addEventListener('click', handleClick)
  }
})();

// Tiny Slider slideshow img.
(function() {
  var selector = '.field--name-field-os2web-slideshow-image .field__items';

  if (document.querySelector(selector) !== null) {

    // Run tiny slider.
    tns({
      container: selector,
      items: 1,
      autoplay: true,
      autoplayHoverPause: true,
      gutter: 32,
      rewind: true,


    });
  }
})();
