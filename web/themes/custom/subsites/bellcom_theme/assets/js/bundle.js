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
  hamburgerBtn.classList.toggle('active');
});
window.onresize = function () {
  var w = window.outerWidth;
  if (w > 768) {
    menuElement.classList.remove('is-open');
    bodyElement.classList.remove('is-fixed');
    hamburgerBtn.classList.remove('active');
  }
};
/******/ })()
;
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoianMvYnVuZGxlLmpzIiwibWFwcGluZ3MiOiI7Ozs7OztBQUFhOztBQUViQSxRQUFRLENBQUNDLGdCQUFnQixDQUFDLGtCQUFrQixFQUFFLFlBQU07RUFDbERDLEdBQUcsQ0FBQ0MsSUFBSSxFQUFFO0FBRVosQ0FBQyxDQUFDO0FBR0YsSUFBTUMsWUFBWSxHQUFHSixRQUFRLENBQUNLLGFBQWEsQ0FBQyxZQUFZLENBQUM7QUFDekQsSUFBTUMsV0FBVyxHQUFHTixRQUFRLENBQUNLLGFBQWEsQ0FBQyx3QkFBd0IsQ0FBQztBQUNwRSxJQUFNRSxXQUFXLEdBQUdQLFFBQVEsQ0FBQ0ssYUFBYSxDQUFDLE1BQU0sQ0FBQztBQUVsREQsWUFBWSxDQUFDSCxnQkFBZ0IsQ0FBQyxPQUFPLEVBQUUsWUFBTTtFQUMzQ0ssV0FBVyxDQUFDRSxTQUFTLENBQUNDLE1BQU0sQ0FBQyxTQUFTLENBQUM7RUFDdkNGLFdBQVcsQ0FBQ0MsU0FBUyxDQUFDQyxNQUFNLENBQUMsVUFBVSxDQUFDO0VBQ3hDTCxZQUFZLENBQUNJLFNBQVMsQ0FBQ0MsTUFBTSxDQUFDLFFBQVEsQ0FBQztBQUN6QyxDQUFDLENBQUM7QUFFRkMsTUFBTSxDQUFDQyxRQUFRLEdBQUcsWUFBWTtFQUM1QixJQUFJQyxDQUFDLEdBQUdGLE1BQU0sQ0FBQ0csVUFBVTtFQUN6QixJQUFJRCxDQUFDLEdBQUcsR0FBRyxFQUFFO0lBQ1hOLFdBQVcsQ0FBQ0UsU0FBUyxDQUFDTSxNQUFNLENBQUMsU0FBUyxDQUFDO0lBQ3ZDUCxXQUFXLENBQUNDLFNBQVMsQ0FBQ00sTUFBTSxDQUFDLFVBQVUsQ0FBQztJQUN4Q1YsWUFBWSxDQUFDSSxTQUFTLENBQUNNLE1BQU0sQ0FBQyxRQUFRLENBQUM7RUFDekM7QUFDRixDQUFDLEMiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly9CZWxsY29tLy4vc3JjL2pzL21haW4uanMiXSwic291cmNlc0NvbnRlbnQiOlsiJ3VzZSBzdHJpY3QnO1xuXG5kb2N1bWVudC5hZGRFdmVudExpc3RlbmVyKCdET01Db250ZW50TG9hZGVkJywgKCkgPT4ge1xuICBBT1MuaW5pdCgpO1xuXG59KTtcblxuXG5jb25zdCBoYW1idXJnZXJCdG4gPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcuaGFtYnVyZ2VyJyk7XG5jb25zdCBtZW51RWxlbWVudCA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJy5yZWdpb24ucmVnaW9uLS1oZWFkZXInKTtcbmNvbnN0IGJvZHlFbGVtZW50ID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcignYm9keScpO1xuXG5oYW1idXJnZXJCdG4uYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCAoKSA9PiB7XG4gIG1lbnVFbGVtZW50LmNsYXNzTGlzdC50b2dnbGUoJ2lzLW9wZW4nKTtcbiAgYm9keUVsZW1lbnQuY2xhc3NMaXN0LnRvZ2dsZSgnaXMtZml4ZWQnKTtcbiAgaGFtYnVyZ2VyQnRuLmNsYXNzTGlzdC50b2dnbGUoJ2FjdGl2ZScpO1xufSk7XG5cbndpbmRvdy5vbnJlc2l6ZSA9IGZ1bmN0aW9uICgpIHtcbiAgdmFyIHcgPSB3aW5kb3cub3V0ZXJXaWR0aDtcbiAgaWYgKHcgPiA3NjgpIHtcbiAgICBtZW51RWxlbWVudC5jbGFzc0xpc3QucmVtb3ZlKCdpcy1vcGVuJyk7XG4gICAgYm9keUVsZW1lbnQuY2xhc3NMaXN0LnJlbW92ZSgnaXMtZml4ZWQnKTtcbiAgICBoYW1idXJnZXJCdG4uY2xhc3NMaXN0LnJlbW92ZSgnYWN0aXZlJyk7XG4gIH1cbn07XG4iXSwibmFtZXMiOlsiZG9jdW1lbnQiLCJhZGRFdmVudExpc3RlbmVyIiwiQU9TIiwiaW5pdCIsImhhbWJ1cmdlckJ0biIsInF1ZXJ5U2VsZWN0b3IiLCJtZW51RWxlbWVudCIsImJvZHlFbGVtZW50IiwiY2xhc3NMaXN0IiwidG9nZ2xlIiwid2luZG93Iiwib25yZXNpemUiLCJ3Iiwib3V0ZXJXaWR0aCIsInJlbW92ZSJdLCJzb3VyY2VSb290IjoiIn0=