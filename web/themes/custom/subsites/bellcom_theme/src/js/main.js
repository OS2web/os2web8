'use strict';

document.addEventListener('DOMContentLoaded', () => {
  AOS.init();

});


const hamburgerBtn = document.querySelector('.hamburger');

const menuElement = document.querySelector('.region--header');

hamburgerBtn.addEventListener('click', () => {
  menuElement.classList.add('is-open');
});
