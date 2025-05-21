/*
 * Used for paragraph slideshow.
 */

// Slideshow popup.
(function () {
  function handleClick(event) {
    event.preventDefault();

    var link = this;
    var image = link.querySelector('img');
    var text = image.getAttribute('title');
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
    link.addEventListener('click', handleClick);
  }
})();

// Tiny Slider slideshow img.
(function () {
  var containers = document.querySelectorAll('.field--name-field-os2web-slideshow-image .field__items');

  containers.forEach(function (container) {
    var slider = tns({
      container: container,
      items: 1,
      autoplay: false,
      autoplayHoverPause: true,
      gutter: 32,
      rewind: true,
      responsive: {
        576: {
          items: 2,
        },
      },
    });

    // Tabindex accessibility handling
    var updateTabIndex = function (info) {
      for (var i = 0; i < info.slideItems.length; i++) {
        var slide = info.slideItems[i];
        var anchor = slide.querySelector('a');
        if (!anchor) continue;

        if (slide.classList.contains('tns-slide-active')) {
          anchor.removeAttribute('tabindex');
        } else {
          anchor.setAttribute('tabindex', '-1');
        }
      }
    };

    slider.events.on('transitionEnd', updateTabIndex);
    updateTabIndex(slider.getInfo());
  });
})();
