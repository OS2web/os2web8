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

var subscribeBtn = document.querySelector('#mc-embedded-subscribe');

function removeSuccess() {
  subscribeBtn.classList.remove('success');
  subscribeBtnTextImage.classList.remove('success');
}

subscribeBtn.addEventListener('click', function (e) {
  subscribeBtn.classList.add('success');
  e.preventDefault();
  setTimeout(function () {
    removeSuccess();
  }, 3000);
});
var subscribeBtnTextImage = document.querySelector('#subscribe-btn-text-image');
subscribeBtnTextImage.addEventListener('click', function (e) {
  subscribeBtnTextImage.classList.add('success');
  e.preventDefault();
  setTimeout(function () {
    removeSuccess();
  }, 3000);
});
/******/ })()
;
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly9CZWxsY29tLy4vc3JjL2pzL21haW4uanMiXSwibmFtZXMiOlsiZG9jdW1lbnQiLCJhZGRFdmVudExpc3RlbmVyIiwiQU9TIiwiaW5pdCIsImhhbWJ1cmdlckJ0biIsInF1ZXJ5U2VsZWN0b3IiLCJtZW51RWxlbWVudCIsImJvZHlFbGVtZW50IiwiY2xhc3NMaXN0IiwidG9nZ2xlIiwid2luZG93Iiwib25yZXNpemUiLCJ3Iiwib3V0ZXJXaWR0aCIsInJlbW92ZSIsInN1YnNjcmliZUJ0biIsInJlbW92ZVN1Y2Nlc3MiLCJzdWJzY3JpYmVCdG5UZXh0SW1hZ2UiLCJlIiwiYWRkIiwicHJldmVudERlZmF1bHQiLCJzZXRUaW1lb3V0Il0sIm1hcHBpbmdzIjoiOzs7Ozs7QUFBYTs7QUFFYkEsUUFBUSxDQUFDQyxnQkFBVCxDQUEwQixrQkFBMUIsRUFBOEMsWUFBTTtBQUNsREMsS0FBRyxDQUFDQyxJQUFKO0FBRUQsQ0FIRDtBQU1BLElBQU1DLFlBQVksR0FBR0osUUFBUSxDQUFDSyxhQUFULENBQXVCLFlBQXZCLENBQXJCO0FBQ0EsSUFBTUMsV0FBVyxHQUFHTixRQUFRLENBQUNLLGFBQVQsQ0FBdUIsd0JBQXZCLENBQXBCO0FBQ0EsSUFBTUUsV0FBVyxHQUFHUCxRQUFRLENBQUNLLGFBQVQsQ0FBdUIsTUFBdkIsQ0FBcEI7QUFFQUQsWUFBWSxDQUFDSCxnQkFBYixDQUE4QixPQUE5QixFQUF1QyxZQUFNO0FBQzNDSyxhQUFXLENBQUNFLFNBQVosQ0FBc0JDLE1BQXRCLENBQTZCLFNBQTdCO0FBQ0FGLGFBQVcsQ0FBQ0MsU0FBWixDQUFzQkMsTUFBdEIsQ0FBNkIsVUFBN0I7QUFDQUwsY0FBWSxDQUFDSSxTQUFiLENBQXVCQyxNQUF2QixDQUE4QixRQUE5QjtBQUNELENBSkQ7O0FBTUFDLE1BQU0sQ0FBQ0MsUUFBUCxHQUFrQixZQUFZO0FBQzVCLE1BQUlDLENBQUMsR0FBR0YsTUFBTSxDQUFDRyxVQUFmOztBQUNBLE1BQUlELENBQUMsR0FBRyxHQUFSLEVBQWE7QUFDWE4sZUFBVyxDQUFDRSxTQUFaLENBQXNCTSxNQUF0QixDQUE2QixTQUE3QjtBQUNBUCxlQUFXLENBQUNDLFNBQVosQ0FBc0JNLE1BQXRCLENBQTZCLFVBQTdCO0FBQ0FWLGdCQUFZLENBQUNJLFNBQWIsQ0FBdUJNLE1BQXZCLENBQThCLFFBQTlCO0FBQ0Q7QUFDRixDQVBEOztBQVNBLElBQU1DLFlBQVksR0FBR2YsUUFBUSxDQUFDSyxhQUFULENBQXVCLHdCQUF2QixDQUFyQjs7QUFFQSxTQUFTVyxhQUFULEdBQXlCO0FBQ3ZCRCxjQUFZLENBQUNQLFNBQWIsQ0FBdUJNLE1BQXZCLENBQThCLFNBQTlCO0FBQ0FHLHVCQUFxQixDQUFDVCxTQUF0QixDQUFnQ00sTUFBaEMsQ0FBdUMsU0FBdkM7QUFDRDs7QUFFREMsWUFBWSxDQUFDZCxnQkFBYixDQUE4QixPQUE5QixFQUF1QyxVQUFDaUIsQ0FBRCxFQUFPO0FBQzVDSCxjQUFZLENBQUNQLFNBQWIsQ0FBdUJXLEdBQXZCLENBQTJCLFNBQTNCO0FBQ0FELEdBQUMsQ0FBQ0UsY0FBRjtBQUNBQyxZQUFVLENBQUMsWUFBTTtBQUNmTCxpQkFBYTtBQUNkLEdBRlMsRUFFUCxJQUZPLENBQVY7QUFHRCxDQU5EO0FBU0EsSUFBTUMscUJBQXFCLEdBQUdqQixRQUFRLENBQUNLLGFBQVQsQ0FBdUIsMkJBQXZCLENBQTlCO0FBRUFZLHFCQUFxQixDQUFDaEIsZ0JBQXRCLENBQXVDLE9BQXZDLEVBQWdELFVBQUNpQixDQUFELEVBQU87QUFDckRELHVCQUFxQixDQUFDVCxTQUF0QixDQUFnQ1csR0FBaEMsQ0FBb0MsU0FBcEM7QUFDQUQsR0FBQyxDQUFDRSxjQUFGO0FBQ0FDLFlBQVUsQ0FBQyxZQUFNO0FBQ2ZMLGlCQUFhO0FBQ2QsR0FGUyxFQUVQLElBRk8sQ0FBVjtBQUdELENBTkQsRSIsImZpbGUiOiJqcy9idW5kbGUuanMiLCJzb3VyY2VzQ29udGVudCI6WyIndXNlIHN0cmljdCc7XG5cbmRvY3VtZW50LmFkZEV2ZW50TGlzdGVuZXIoJ0RPTUNvbnRlbnRMb2FkZWQnLCAoKSA9PiB7XG4gIEFPUy5pbml0KCk7XG5cbn0pO1xuXG5cbmNvbnN0IGhhbWJ1cmdlckJ0biA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJy5oYW1idXJnZXInKTtcbmNvbnN0IG1lbnVFbGVtZW50ID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcignLnJlZ2lvbi5yZWdpb24tLWhlYWRlcicpO1xuY29uc3QgYm9keUVsZW1lbnQgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCdib2R5Jyk7XG5cbmhhbWJ1cmdlckJ0bi5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsICgpID0+IHtcbiAgbWVudUVsZW1lbnQuY2xhc3NMaXN0LnRvZ2dsZSgnaXMtb3BlbicpO1xuICBib2R5RWxlbWVudC5jbGFzc0xpc3QudG9nZ2xlKCdpcy1maXhlZCcpO1xuICBoYW1idXJnZXJCdG4uY2xhc3NMaXN0LnRvZ2dsZSgnYWN0aXZlJyk7XG59KTtcblxud2luZG93Lm9ucmVzaXplID0gZnVuY3Rpb24gKCkge1xuICB2YXIgdyA9IHdpbmRvdy5vdXRlcldpZHRoO1xuICBpZiAodyA+IDc2OCkge1xuICAgIG1lbnVFbGVtZW50LmNsYXNzTGlzdC5yZW1vdmUoJ2lzLW9wZW4nKTtcbiAgICBib2R5RWxlbWVudC5jbGFzc0xpc3QucmVtb3ZlKCdpcy1maXhlZCcpO1xuICAgIGhhbWJ1cmdlckJ0bi5jbGFzc0xpc3QucmVtb3ZlKCdhY3RpdmUnKTtcbiAgfVxufTtcblxuY29uc3Qgc3Vic2NyaWJlQnRuID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcignI21jLWVtYmVkZGVkLXN1YnNjcmliZScpO1xuXG5mdW5jdGlvbiByZW1vdmVTdWNjZXNzKCkge1xuICBzdWJzY3JpYmVCdG4uY2xhc3NMaXN0LnJlbW92ZSgnc3VjY2VzcycpO1xuICBzdWJzY3JpYmVCdG5UZXh0SW1hZ2UuY2xhc3NMaXN0LnJlbW92ZSgnc3VjY2VzcycpO1xufVxuXG5zdWJzY3JpYmVCdG4uYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCAoZSkgPT4ge1xuICBzdWJzY3JpYmVCdG4uY2xhc3NMaXN0LmFkZCgnc3VjY2VzcycpO1xuICBlLnByZXZlbnREZWZhdWx0KCk7XG4gIHNldFRpbWVvdXQoKCkgPT4ge1xuICAgIHJlbW92ZVN1Y2Nlc3MoKTtcbiAgfSwgMzAwMCk7XG59KTtcblxuXG5jb25zdCBzdWJzY3JpYmVCdG5UZXh0SW1hZ2UgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcjc3Vic2NyaWJlLWJ0bi10ZXh0LWltYWdlJyk7XG5cbnN1YnNjcmliZUJ0blRleHRJbWFnZS5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsIChlKSA9PiB7XG4gIHN1YnNjcmliZUJ0blRleHRJbWFnZS5jbGFzc0xpc3QuYWRkKCdzdWNjZXNzJyk7XG4gIGUucHJldmVudERlZmF1bHQoKTtcbiAgc2V0VGltZW91dCgoKSA9PiB7XG4gICAgcmVtb3ZlU3VjY2VzcygpO1xuICB9LCAzMDAwKTtcbn0pO1xuXG5cblxuXG4iXSwic291cmNlUm9vdCI6IiJ9