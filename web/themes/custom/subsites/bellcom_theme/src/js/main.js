'use strict';

document.addEventListener('DOMContentLoaded', () => {
  AOS.init();

});


const hamburgerBtn = document.querySelector('.hamburger');
const menuElement = document.querySelector('.region.region--header');
const bodyElement = document.querySelector('body');

hamburgerBtn.addEventListener('click', () => {
  menuElement.classList.toggle('is-open');
  bodyElement.classList.toggle('is-fixed');
});

window.onresize = function () {
  var w = window.outerWidth;
  if (w > 768) {
    menuElement.classList.remove('is-open');
    bodyElement.classList.remove('is-fixed');
  }
};
