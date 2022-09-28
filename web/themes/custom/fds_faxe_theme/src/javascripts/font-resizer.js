(function() {
  const html = jQuery("html");
  jQuery(document).ready(function () {
    jQuery(".js-increase-font-size").click(function () {
      modifyFontSize("increase");
    });
    jQuery(".js-decrease-font-size").click(function () {
      modifyFontSize("decrease");
    });


    function modifyFontSize(flag) {
      let currentFontSize = parseInt(html.css("font-size"));
      if (flag == "increase") {
        switch (html.css("font-size")) {
          case "10px":
            currentFontSize = 20;
            break;
        }
      } else if (flag == "decrease") {
        switch (html.css("font-size")) {
          case "20px":
            currentFontSize = 10;
            break;
        }
      }
      localStorage.setItem("fontSize", currentFontSize);
      html.css("font-size", parseInt(currentFontSize));
    }
    html.css("font-size", parseInt(localStorage.getItem("fontSize")));
  });
})();
