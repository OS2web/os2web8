(function($) {
  const increase = document.querySelectorAll('a[data-increase-font-size]');
  const decrease = document.querySelectorAll('a[data-decrease-font-size]');
  const html = document.querySelector("html");


  increase.forEach(incItem => {
    decrease.forEach(decItem => {
      incItem.addEventListener("keydown", event => {
        if (event.code === "Space" || event.code === "Enter") {
          incItem.click();
        }
      });
      function addFontSizeChange() {
        html.classList.add("fz-change");
        html.style.fontSize = "15px";
        decItem.removeAttribute("disabled", "disabled");
        incItem.setAttribute("disabled", "disabled");
      }

      decItem.addEventListener("keydown", event => {
        if (event.code === "Space" || event.code === "Enter") {
          decItem.click();
        }
      });

      function removeFontSizeChange() {
        html.classList.remove("fz-change");
        html.style.fontSize = "10px";
        decItem.setAttribute("disabled", "disabled");
        incItem.removeAttribute("disabled", "disabled");
      }

      incItem.addEventListener("click", function() {
        window.localStorage.setItem("preferBigFontSize", 1);
        addFontSizeChange();
      });
      decItem.addEventListener("click", function() {
        window.localStorage.setItem("preferBigFontSize", 0);
        removeFontSizeChange();
      });
      if (+window.localStorage.getItem("preferBigFontSize")) {
        addFontSizeChange();
      } else {
        removeFontSizeChange();
      }
    });
  });
})(jQuery);
