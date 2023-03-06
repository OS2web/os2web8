/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!************************!*\
  !*** ./src/js/main.js ***!
  \************************/


document.addEventListener('DOMContentLoaded', function () {
  AOS.init();
});
var hamburgerBtn = document.querySelector('.hamburger');
var menuElement = document.querySelector('.region.region--header');
var bodyElement = document.querySelector('body');
hamburgerBtn.addEventListener('click', function () {
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
/******/ })()
;
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoianMvYnVuZGxlLmpzIiwibWFwcGluZ3MiOiI7Ozs7OztBQUFhOztBQUViQSxRQUFRLENBQUNDLGdCQUFnQixDQUFDLGtCQUFrQixFQUFFLFlBQU07RUFDbERDLEdBQUcsQ0FBQ0MsSUFBSSxFQUFFO0FBRVosQ0FBQyxDQUFDO0FBR0YsSUFBTUMsWUFBWSxHQUFHSixRQUFRLENBQUNLLGFBQWEsQ0FBQyxZQUFZLENBQUM7QUFDekQsSUFBTUMsV0FBVyxHQUFHTixRQUFRLENBQUNLLGFBQWEsQ0FBQyx3QkFBd0IsQ0FBQztBQUNwRSxJQUFNRSxXQUFXLEdBQUdQLFFBQVEsQ0FBQ0ssYUFBYSxDQUFDLE1BQU0sQ0FBQztBQUVsREQsWUFBWSxDQUFDSCxnQkFBZ0IsQ0FBQyxPQUFPLEVBQUUsWUFBTTtFQUMzQ0ssV0FBVyxDQUFDRSxTQUFTLENBQUNDLE1BQU0sQ0FBQyxTQUFTLENBQUM7RUFDdkNGLFdBQVcsQ0FBQ0MsU0FBUyxDQUFDQyxNQUFNLENBQUMsVUFBVSxDQUFDO0FBQzFDLENBQUMsQ0FBQztBQUVGQyxNQUFNLENBQUNDLFFBQVEsR0FBRyxZQUFZO0VBQzVCLElBQUlDLENBQUMsR0FBR0YsTUFBTSxDQUFDRyxVQUFVO0VBQ3pCLElBQUlELENBQUMsR0FBRyxHQUFHLEVBQUU7SUFDWE4sV0FBVyxDQUFDRSxTQUFTLENBQUNNLE1BQU0sQ0FBQyxTQUFTLENBQUM7SUFDdkNQLFdBQVcsQ0FBQ0MsU0FBUyxDQUFDTSxNQUFNLENBQUMsVUFBVSxDQUFDO0VBQzFDO0FBQ0YsQ0FBQyxDIiwic291cmNlcyI6WyJ3ZWJwYWNrOi8vQmVsbGNvbS8uL3NyYy9qcy9tYWluLmpzIl0sInNvdXJjZXNDb250ZW50IjpbIid1c2Ugc3RyaWN0JztcblxuZG9jdW1lbnQuYWRkRXZlbnRMaXN0ZW5lcignRE9NQ29udGVudExvYWRlZCcsICgpID0+IHtcbiAgQU9TLmluaXQoKTtcblxufSk7XG5cblxuY29uc3QgaGFtYnVyZ2VyQnRuID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcignLmhhbWJ1cmdlcicpO1xuY29uc3QgbWVudUVsZW1lbnQgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcucmVnaW9uLnJlZ2lvbi0taGVhZGVyJyk7XG5jb25zdCBib2R5RWxlbWVudCA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJ2JvZHknKTtcblxuaGFtYnVyZ2VyQnRuLmFkZEV2ZW50TGlzdGVuZXIoJ2NsaWNrJywgKCkgPT4ge1xuICBtZW51RWxlbWVudC5jbGFzc0xpc3QudG9nZ2xlKCdpcy1vcGVuJyk7XG4gIGJvZHlFbGVtZW50LmNsYXNzTGlzdC50b2dnbGUoJ2lzLWZpeGVkJyk7XG59KTtcblxud2luZG93Lm9ucmVzaXplID0gZnVuY3Rpb24gKCkge1xuICB2YXIgdyA9IHdpbmRvdy5vdXRlcldpZHRoO1xuICBpZiAodyA+IDc2OCkge1xuICAgIG1lbnVFbGVtZW50LmNsYXNzTGlzdC5yZW1vdmUoJ2lzLW9wZW4nKTtcbiAgICBib2R5RWxlbWVudC5jbGFzc0xpc3QucmVtb3ZlKCdpcy1maXhlZCcpO1xuICB9XG59O1xuIl0sIm5hbWVzIjpbImRvY3VtZW50IiwiYWRkRXZlbnRMaXN0ZW5lciIsIkFPUyIsImluaXQiLCJoYW1idXJnZXJCdG4iLCJxdWVyeVNlbGVjdG9yIiwibWVudUVsZW1lbnQiLCJib2R5RWxlbWVudCIsImNsYXNzTGlzdCIsInRvZ2dsZSIsIndpbmRvdyIsIm9ucmVzaXplIiwidyIsIm91dGVyV2lkdGgiLCJyZW1vdmUiXSwic291cmNlUm9vdCI6IiJ9