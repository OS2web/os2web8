(function () {
  const html = jQuery("html");
  const sizes = [10, 12, 13, 15, 17, 20];

  function getCurrentFontSize() {
    return parseInt(html.css("font-size"), 10) || sizes[0];
  }

  function getClosestSizeIndex(fontSize) {
    let closestIndex = 0;
    let closestDistance = Math.abs(sizes[0] - fontSize);

    for (let i = 1; i < sizes.length; i++) {
      const distance = Math.abs(sizes[i] - fontSize);
      if (distance < closestDistance) {
        closestDistance = distance;
        closestIndex = i;
      }
    }

    return closestIndex;
  }

  function applyFontSize(fontSize) {
    localStorage.setItem("fontSize", fontSize);
    html.css("font-size", fontSize + "px");
  }

  function modifyFontSize(flag) {
    let index = sizes.indexOf(getCurrentFontSize());

    // Current size is outside the known steps (e.g. browser default 16px).
    if (index === -1) {
      index = getClosestSizeIndex(getCurrentFontSize());
    }

    if (flag === "increase" && index < sizes.length - 1) {
      index += 1;
    }
    else if (flag === "decrease" && index > 0) {
      index -= 1;
    }

    applyFontSize(sizes[index]);
  }

  jQuery(document).ready(function () {
    jQuery(".js-increase-font-size").on("click", function () {
      modifyFontSize("increase");
    });
    jQuery(".js-decrease-font-size").on("click", function () {
      modifyFontSize("decrease");
    });

    const storedFontSize = parseInt(localStorage.getItem("fontSize"), 10);
    if (sizes.indexOf(storedFontSize) !== -1) {
      applyFontSize(storedFontSize);
    }
  });
})();
