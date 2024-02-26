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
var subscribeBtn = document.querySelector('#subscribe-btn');
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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoianMvYnVuZGxlLmpzIiwibWFwcGluZ3MiOiI7Ozs7OztBQUFhOztBQUViQSxRQUFRLENBQUNDLGdCQUFnQixDQUFDLGtCQUFrQixFQUFFLFlBQU07RUFDbERDLEdBQUcsQ0FBQ0MsSUFBSSxFQUFFO0FBRVosQ0FBQyxDQUFDO0FBR0YsSUFBTUMsWUFBWSxHQUFHSixRQUFRLENBQUNLLGFBQWEsQ0FBQyxZQUFZLENBQUM7QUFDekQsSUFBTUMsV0FBVyxHQUFHTixRQUFRLENBQUNLLGFBQWEsQ0FBQyx3QkFBd0IsQ0FBQztBQUNwRSxJQUFNRSxXQUFXLEdBQUdQLFFBQVEsQ0FBQ0ssYUFBYSxDQUFDLE1BQU0sQ0FBQztBQUVsREQsWUFBWSxDQUFDSCxnQkFBZ0IsQ0FBQyxPQUFPLEVBQUUsWUFBTTtFQUMzQ0ssV0FBVyxDQUFDRSxTQUFTLENBQUNDLE1BQU0sQ0FBQyxTQUFTLENBQUM7RUFDdkNGLFdBQVcsQ0FBQ0MsU0FBUyxDQUFDQyxNQUFNLENBQUMsVUFBVSxDQUFDO0VBQ3hDTCxZQUFZLENBQUNJLFNBQVMsQ0FBQ0MsTUFBTSxDQUFDLFFBQVEsQ0FBQztBQUN6QyxDQUFDLENBQUM7QUFFRkMsTUFBTSxDQUFDQyxRQUFRLEdBQUcsWUFBWTtFQUM1QixJQUFJQyxDQUFDLEdBQUdGLE1BQU0sQ0FBQ0csVUFBVTtFQUN6QixJQUFJRCxDQUFDLEdBQUcsR0FBRyxFQUFFO0lBQ1hOLFdBQVcsQ0FBQ0UsU0FBUyxDQUFDTSxNQUFNLENBQUMsU0FBUyxDQUFDO0lBQ3ZDUCxXQUFXLENBQUNDLFNBQVMsQ0FBQ00sTUFBTSxDQUFDLFVBQVUsQ0FBQztJQUN4Q1YsWUFBWSxDQUFDSSxTQUFTLENBQUNNLE1BQU0sQ0FBQyxRQUFRLENBQUM7RUFDekM7QUFDRixDQUFDO0FBRUQsSUFBTUMsWUFBWSxHQUFHZixRQUFRLENBQUNLLGFBQWEsQ0FBQyxnQkFBZ0IsQ0FBQztBQUU3RCxTQUFTVyxhQUFhQSxDQUFBLEVBQUc7RUFDdkJELFlBQVksQ0FBQ1AsU0FBUyxDQUFDTSxNQUFNLENBQUMsU0FBUyxDQUFDO0VBQ3hDRyxxQkFBcUIsQ0FBQ1QsU0FBUyxDQUFDTSxNQUFNLENBQUMsU0FBUyxDQUFDO0FBQ25EO0FBRUFDLFlBQVksQ0FBQ2QsZ0JBQWdCLENBQUMsT0FBTyxFQUFFLFVBQUNpQixDQUFDLEVBQUs7RUFDNUNILFlBQVksQ0FBQ1AsU0FBUyxDQUFDVyxHQUFHLENBQUMsU0FBUyxDQUFDO0VBQ3JDRCxDQUFDLENBQUNFLGNBQWMsRUFBRTtFQUNsQkMsVUFBVSxDQUFDLFlBQU07SUFDZkwsYUFBYSxFQUFFO0VBQ2pCLENBQUMsRUFBRSxJQUFJLENBQUM7QUFDVixDQUFDLENBQUM7QUFHRixJQUFNQyxxQkFBcUIsR0FBR2pCLFFBQVEsQ0FBQ0ssYUFBYSxDQUFDLDJCQUEyQixDQUFDO0FBRWpGWSxxQkFBcUIsQ0FBQ2hCLGdCQUFnQixDQUFDLE9BQU8sRUFBRSxVQUFDaUIsQ0FBQyxFQUFLO0VBQ3JERCxxQkFBcUIsQ0FBQ1QsU0FBUyxDQUFDVyxHQUFHLENBQUMsU0FBUyxDQUFDO0VBQzlDRCxDQUFDLENBQUNFLGNBQWMsRUFBRTtFQUNsQkMsVUFBVSxDQUFDLFlBQU07SUFDZkwsYUFBYSxFQUFFO0VBQ2pCLENBQUMsRUFBRSxJQUFJLENBQUM7QUFDVixDQUFDLENBQUMsQyIsInNvdXJjZXMiOlsid2VicGFjazovL0JlbGxjb20vLi9zcmMvanMvbWFpbi5qcyJdLCJzb3VyY2VzQ29udGVudCI6WyIndXNlIHN0cmljdCc7XG5cbmRvY3VtZW50LmFkZEV2ZW50TGlzdGVuZXIoJ0RPTUNvbnRlbnRMb2FkZWQnLCAoKSA9PiB7XG4gIEFPUy5pbml0KCk7XG5cbn0pO1xuXG5cbmNvbnN0IGhhbWJ1cmdlckJ0biA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJy5oYW1idXJnZXInKTtcbmNvbnN0IG1lbnVFbGVtZW50ID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcignLnJlZ2lvbi5yZWdpb24tLWhlYWRlcicpO1xuY29uc3QgYm9keUVsZW1lbnQgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCdib2R5Jyk7XG5cbmhhbWJ1cmdlckJ0bi5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsICgpID0+IHtcbiAgbWVudUVsZW1lbnQuY2xhc3NMaXN0LnRvZ2dsZSgnaXMtb3BlbicpO1xuICBib2R5RWxlbWVudC5jbGFzc0xpc3QudG9nZ2xlKCdpcy1maXhlZCcpO1xuICBoYW1idXJnZXJCdG4uY2xhc3NMaXN0LnRvZ2dsZSgnYWN0aXZlJyk7XG59KTtcblxud2luZG93Lm9ucmVzaXplID0gZnVuY3Rpb24gKCkge1xuICB2YXIgdyA9IHdpbmRvdy5vdXRlcldpZHRoO1xuICBpZiAodyA+IDc2OCkge1xuICAgIG1lbnVFbGVtZW50LmNsYXNzTGlzdC5yZW1vdmUoJ2lzLW9wZW4nKTtcbiAgICBib2R5RWxlbWVudC5jbGFzc0xpc3QucmVtb3ZlKCdpcy1maXhlZCcpO1xuICAgIGhhbWJ1cmdlckJ0bi5jbGFzc0xpc3QucmVtb3ZlKCdhY3RpdmUnKTtcbiAgfVxufTtcblxuY29uc3Qgc3Vic2NyaWJlQnRuID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcignI3N1YnNjcmliZS1idG4nKTtcblxuZnVuY3Rpb24gcmVtb3ZlU3VjY2VzcygpIHtcbiAgc3Vic2NyaWJlQnRuLmNsYXNzTGlzdC5yZW1vdmUoJ3N1Y2Nlc3MnKTtcbiAgc3Vic2NyaWJlQnRuVGV4dEltYWdlLmNsYXNzTGlzdC5yZW1vdmUoJ3N1Y2Nlc3MnKTtcbn1cblxuc3Vic2NyaWJlQnRuLmFkZEV2ZW50TGlzdGVuZXIoJ2NsaWNrJywgKGUpID0+IHtcbiAgc3Vic2NyaWJlQnRuLmNsYXNzTGlzdC5hZGQoJ3N1Y2Nlc3MnKTtcbiAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuICBzZXRUaW1lb3V0KCgpID0+IHtcbiAgICByZW1vdmVTdWNjZXNzKCk7XG4gIH0sIDMwMDApO1xufSk7XG5cblxuY29uc3Qgc3Vic2NyaWJlQnRuVGV4dEltYWdlID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcignI3N1YnNjcmliZS1idG4tdGV4dC1pbWFnZScpO1xuXG5zdWJzY3JpYmVCdG5UZXh0SW1hZ2UuYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCAoZSkgPT4ge1xuICBzdWJzY3JpYmVCdG5UZXh0SW1hZ2UuY2xhc3NMaXN0LmFkZCgnc3VjY2VzcycpO1xuICBlLnByZXZlbnREZWZhdWx0KCk7XG4gIHNldFRpbWVvdXQoKCkgPT4ge1xuICAgIHJlbW92ZVN1Y2Nlc3MoKTtcbiAgfSwgMzAwMCk7XG59KTtcblxuXG5cblxuIl0sIm5hbWVzIjpbImRvY3VtZW50IiwiYWRkRXZlbnRMaXN0ZW5lciIsIkFPUyIsImluaXQiLCJoYW1idXJnZXJCdG4iLCJxdWVyeVNlbGVjdG9yIiwibWVudUVsZW1lbnQiLCJib2R5RWxlbWVudCIsImNsYXNzTGlzdCIsInRvZ2dsZSIsIndpbmRvdyIsIm9ucmVzaXplIiwidyIsIm91dGVyV2lkdGgiLCJyZW1vdmUiLCJzdWJzY3JpYmVCdG4iLCJyZW1vdmVTdWNjZXNzIiwic3Vic2NyaWJlQnRuVGV4dEltYWdlIiwiZSIsImFkZCIsInByZXZlbnREZWZhdWx0Iiwic2V0VGltZW91dCJdLCJzb3VyY2VSb290IjoiIn0=