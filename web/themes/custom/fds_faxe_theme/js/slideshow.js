/*
 * Used for paragraph slideshow.
 */

// Slideshow popup.
// (function() {
//   function handleClick(event) {
//     event.preventDefault();

//     var link = this;
//     var image = link.querySelector('img');
//     var text = image.getAttribute('title');
//     var pathToImage = link.getAttribute('href');
//     var wrapper = link.closest('.field--name-field-os2web-slideshow-image');
//     var modalNodeElement = wrapper.querySelector('.modal');

//     createModal(modalNodeElement, text, pathToImage);
//   }

//   function createModal(modalNodeElement, text, imagePath) {
//     var modalId = modalNodeElement.getAttribute('id');
//     var modalBody = modalNodeElement.querySelector('.modal__content');
//     modalBody.innerHTML = ''; // Empty the modal content.

//     // Create and add image.
//     var image = document.createElement('img');
//     image.src = imagePath;
//     image.alt = text;

//     modalBody.appendChild(image);

//     // Set text.
//     var caption = document.createElement('h4');
//     caption.innerText = text;

//     modalBody.appendChild(caption);

//     // Open modal.
//     MicroModal.show(modalId);
//   }

//   var links = document.querySelectorAll('.field--name-field-os2web-slideshow-image .field__item a');

//   for (var i = 0; i < links.length; i++) {
//     var link = links[i];

//     link.addEventListener('click', handleClick)
//   }
// })();

// Tiny Slider slideshow img.
(function() {
  var selector = '.paragraph--type--os2web-slideshow';

  // var transitionEndCallback = function (info, eventName) {
  //   // Add tab
  //   for (var i = 0; i < info.slideItems.length; i++) {
  //     var slide = info.slideItems[i];
  //     if (slide.classList.contains('tns-slide-active')) {
  //       slide.querySelector('a').removeAttribute('tabindex');
  //     }
  //     else {
  //       slide.querySelector('a').setAttribute('tabindex', '-1');
  //     }
  //   }
  // }

//   if (document.querySelector(selector) !== null) {
//
//     // Run tiny slider.
//     tns({
//       container: selector,
//       items: 1,
//       autoplay: true,
//       autoplayHoverPause: true,
//       mouseDrag: true,
//       gutter: 0,
//       rewind: true,
//       controls: false,
//       nested: false,
//     });
//
//     // // bind function to event
//     // slider.events.on('transitionEnd', transitionEndCallback);
//     // transitionEndCallback(slider.getInfo());
//   }
// })();

  /*
   * Used for paragraph slideshow.
   */

// Tiny Slider slideshow img.
  (function() {

    let selectorMedia = '.paragraph--type--os2web-slideshow .field--name-field-media > .field__item';
    if (document.querySelectorAll(selectorMedia) !== null) {
      if (document.querySelectorAll(selectorMedia).length < 2) { selectorMedia = null; }
    }

    if (selectorMedia) {
      var selector = '.paragraph--type--os2web-slideshow .field--name-field-media';
      if (document.querySelector(selector) !== null) {
        // Run tiny slider.
        tns({
          container: selector,
          items: 1,
          autoplay: true,
          autoHeight: true,
          autoplayHoverPause: true,
          mouseDrag: true,
          gutter: 0,
          rewind: true,
          controls: false,
          nested: false,
        });
      }
    }

  })();


