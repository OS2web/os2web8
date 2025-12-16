jQuery(function ($) {
  'use strict';
});

// Language selector.
// Run through all links and truncate Danish to 2 chars. (ex. Da).
(function() {
  var links = document.querySelectorAll('.block-language ul a');

  for (var i = 0; i < links.length; i++) {
    var link = links[i];
    var text = 	link.textContent || link.innerText;
    var truncatedText = text.substring(0, 2);

    // Inject the content back into the DOM.
    if (link.textContent) {
      link.textContent = truncatedText;
    } else {
      link.innerText = truncatedText;
    }
  }
})();

// Accordion.
(function () {
  function handleClose(event) {
    var element = this;
    var listItem = element.closest('li');
    var content = listItem.querySelector('.accordion-content');
    var button = listItem.querySelector('.accordion-button');

    content.setAttribute('aria-expanded', 'false');
    content.setAttribute('aria-hidden', 'true');

    button.setAttribute('aria-expanded', 'false');
  }

  var buttons = document.querySelectorAll('.js-accordion-close-current');

  for (var i = 0; i < buttons.length; i++) {
    var button = buttons[i];

    button.addEventListener('click', handleClose);
  }
})();

// Search.
document.addEventListener('DOMContentLoaded', function() {
  function toggle(event) {
    var element = this;
    var parent = element.closest('.searchy');

    parent.classList.toggle('searchy--visible-form');
  }

  var buttons = document.querySelectorAll('.js-toggle-searchy');

  for (var i = 0; i < buttons.length; i++) {
    var button = buttons[i];

    button.addEventListener('click', toggle);
  }
});

// Open all file-links in a new window.
(function() {
  var links = document.querySelectorAll('.field--type-file .file a');

  function generateValue(text) {
    return 'Hent: ' + text;
  }

  for (var i = 0; i < links.length; i++) {
    var link = links[i];

    link.innerHTML = generateValue(link.innerHTML);
    link.setAttribute('target', '_blank');
  }
})();

// Max height on sidenav lists.
(function() {
  function handleToggle(event) {
    var button = event.target;
    var list = button.closest('.sidenav-list');
    var listItem = button.parentNode;

    listItem.classList.add('limited-height__toggle--hidden');

    list.classList.add('limited-height--overridden');
  }

  function addToggleToList(list) {

    // Create a button.
    var textNode = document.createTextNode('Se flere');
    var buttonNode = document.createElement('BUTTON');
    buttonNode.appendChild(textNode);
    buttonNode.addEventListener('click', handleToggle);

    // Create a list item.
    var listItemNode = document.createElement('LI');
    listItemNode.classList.add('limited-height__toggle');
    listItemNode.appendChild(buttonNode);

    // Inject into list.
    list.appendChild(listItemNode);
  }

  var sidenavLists = document.querySelectorAll('.sidenav-list');

  for (var i = 0; i < sidenavLists.length; i++) {
    var list = sidenavLists[i];

    list.classList.add('limited-height');
    addToggleToList(list);
  }
})();

// Custom mobile navigation.
(function() {
  var menu = document.querySelector('.custom-mobile-navigation');
  var menuPopup = document.querySelector('.custom-mobile-navigation-popup');
  var previousActiveElement = null;
  var focusableElements = null;

  // Get all focusable elements within the menu
  function getFocusableElements() {
    if (!menuPopup) return [];
    
    var selector = 'a[href], button:not([disabled]), textarea:not([disabled]), input:not([disabled]), select:not([disabled]), [tabindex]:not([tabindex="-1"])';
    return Array.from(menuPopup.querySelectorAll(selector)).filter(function(el) {
      return el.offsetWidth > 0 && el.offsetHeight > 0;
    });
  }

  // Trap focus within the menu
  function trapFocus(e) {
    if (!menu.classList.contains('custom-mobile-navigation--open')) {
      return;
    }

    if (!focusableElements || focusableElements.length === 0) {
      focusableElements = getFocusableElements();
    }

    if (focusableElements.length === 0) {
      return;
    }

    var firstElement = focusableElements[0];
    var lastElement = focusableElements[focusableElements.length - 1];

    // If Tab is pressed
    if (e.key === 'Tab') {
      // If Shift+Tab on first element, go to last
      if (e.shiftKey && document.activeElement === firstElement) {
        e.preventDefault();
        lastElement.focus();
      }
      // If Tab on last element, go to first
      else if (!e.shiftKey && document.activeElement === lastElement) {
        e.preventDefault();
        firstElement.focus();
      }
    }
  }

  // Handle Escape key to close menu
  function handleEscape(e) {
    if (e.key === 'Escape' && menu.classList.contains('custom-mobile-navigation--open')) {
      var toggleButton = document.querySelector('.js-custom-mobile-navigation-toggle');
      if (toggleButton) {
        toggleButton.click();
      }
    }
  }

  function handleToggle(event) {
    var button = this;
    var isOpen = menu.classList.contains('custom-mobile-navigation--open');

    menu.classList.toggle('custom-mobile-navigation--open');
    
    // Update aria-expanded attribute on all toggle buttons
    var allToggleButtons = document.querySelectorAll('.js-custom-mobile-navigation-toggle');
    for (var i = 0; i < allToggleButtons.length; i++) {
      allToggleButtons[i].setAttribute('aria-expanded', !isOpen);
    }
    
    // Update button label for screen readers
    var labelSpan = button.querySelector('.visually-hidden');
    if (labelSpan) {
      labelSpan.textContent = !isOpen ? 'Luk menu' : 'Åbn menu';
    }
    
    // Update menu popup aria-hidden
    if (menuPopup) {
      menuPopup.setAttribute('aria-hidden', isOpen ? 'true' : 'false');
    }

    if (!isOpen) {
      // Menu is opening
      previousActiveElement = document.activeElement;
      focusableElements = getFocusableElements();
      
      // Update aria-hidden
      if (menuPopup) {
        menuPopup.setAttribute('aria-hidden', 'false');
      }
      
      // Prevent body scroll when menu is open
      document.body.style.overflow = 'hidden';
      
      // Focus first element in menu (or close button if available)
      var closeButton = menuPopup.querySelector('.custom-mobile-navigation-popup__close');
      var firstFocusable = closeButton || (focusableElements.length > 0 ? focusableElements[0] : null);
      
      if (firstFocusable) {
        setTimeout(function() {
          firstFocusable.focus();
        }, 100);
      }

      // Add event listeners for focus trapping
      document.addEventListener('keydown', trapFocus);
      document.addEventListener('keydown', handleEscape);
    } else {
      // Menu is closing
      // Update aria-hidden
      if (menuPopup) {
        menuPopup.setAttribute('aria-hidden', 'true');
      }
      
      // Restore body scroll
      document.body.style.overflow = '';
      
      // Remove event listeners
      document.removeEventListener('keydown', trapFocus);
      document.removeEventListener('keydown', handleEscape);
      
      // Restore focus to previous element
      if (previousActiveElement && typeof previousActiveElement.focus === 'function') {
        setTimeout(function() {
          previousActiveElement.focus();
        }, 100);
      }
      
      focusableElements = null;
      previousActiveElement = null;
    }
  }

  var buttons = document.querySelectorAll('.js-custom-mobile-navigation-toggle');

  for (var i = 0; i < buttons.length; i += 1) {
    var button = buttons[i];

    button.addEventListener('click', handleToggle);
  }

  // Also close menu when clicking overlay
  var overlay = document.querySelector('.custom-mobile-navigation__overlay');
  if (overlay) {
    overlay.addEventListener('click', function() {
      var toggleButton = document.querySelector('.js-custom-mobile-navigation-toggle');
      if (toggleButton && menu.classList.contains('custom-mobile-navigation--open')) {
        toggleButton.click();
      }
    });
  }
})();


const layoutSidebarRight = document.querySelector('.layout-sidebar-right');
const layoutContent = document.querySelector('.layout-content');
const fieldOs2webPageHeading = document.querySelector('.field--name-field-os2web-page-heading h1');
const fieldOs2webPagePrimaryimage = document.querySelector('.field--name-field-os2web-page-primaryimage');
function changeBlockPadding() {
  if (layoutSidebarRight && fieldOs2webPageHeading && layoutContent && window.innerWidth > 767 && !fieldOs2webPagePrimaryimage) {
    const paddingTop = parseInt(window.getComputedStyle(layoutContent).getPropertyValue("padding-top"))
    const marginTop = parseInt(window.getComputedStyle(fieldOs2webPageHeading).getPropertyValue("margin-top"))
    const marginBottom = parseInt(window.getComputedStyle(fieldOs2webPageHeading).getPropertyValue("margin-bottom"))
    const height =  parseInt(window.getComputedStyle(fieldOs2webPageHeading).getPropertyValue("height"))
    layoutSidebarRight.style.paddingTop = paddingTop + marginTop + marginBottom + height + "px"
  } else {
    layoutSidebarRight.removeAttribute("style");
  }
}

changeBlockPadding()
window.addEventListener("resize", () => {
  changeBlockPadding()
});

// Tooltips on mailto: links.
(function() {
  var links = document.querySelectorAll('a[href^="mailto:"]');

  tippy(links, {
    content: '<div style="position: relative; padding-right: 30px; text-align: center;">' +
      '<button class="tippy-close-button" aria-label="Luk tooltip" style="position: absolute; top: 5px; right: 5px; background: transparent; border: none; color: #fff; font-size: 18px; cursor: pointer; padding: 0; width: 24px; height: 24px; line-height: 24px; text-align: center; z-index: 1000;" title="Luk">×</button>' +
      'Du er nu ved at sende en almindelig e-mail. <br />Hvis din besked indeholder personoplysninger, bør du i stedet sende den som en <br /><a href="/sikkerbesked" style="color: #fff;">sikker besked</a>' +
      '</div>',
    allowHTML: true,
    interactive: true,
    trigger: 'mouseenter focus',
    onShow: function(instance) {
      // Attach close button event listener when tooltip is shown
      var closeBtn = instance.popper.querySelector('.tippy-close-button');
      if (closeBtn) {
        // Remove any existing listeners to avoid duplicates
        var newCloseBtn = closeBtn.cloneNode(true);
        closeBtn.parentNode.replaceChild(newCloseBtn, closeBtn);
        
        newCloseBtn.addEventListener('click', function(e) {
          e.preventDefault();
          e.stopPropagation();
          instance.hide();
        });
        
        // Make it keyboard accessible
        newCloseBtn.addEventListener('keydown', function(e) {
          if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            e.stopPropagation();
            instance.hide();
          }
        });
      }
    },
  });
}());

// menu bar search
(function($) {
  let menusearch = $("button.menu-search");
  if (menusearch.length) {
    $("button.menu-search").on("click", function() {
      let searchvalue = $("input.menu-search").val();
      if (searchvalue.length > 1) {
        document.location.href = '/search/node?keys=' + searchvalue;
      }
    });
    $("input.menu-search").on("keyup", function(e) {
      let code = (e.keyCode ? e.keyCode : e.which);
      if (code==13) {
        let searchvalue = $("input.menu-search").val();
        if (searchvalue.length > 1) {
          document.location.href = '/search/node?keys=' + searchvalue;
        }
      }
    });
  }
})(jQuery);

(function($, Drupal, drupalSettings) {
  var selector = '.field--name-field-os2web-page-paragraph-bann';
  var count = document.querySelectorAll('.field--name-field-os2web-page-paragraph-bann > .field__item');
  if (document.querySelector(selector) !== null && count.length > 1) {
    var items = count.length;
    tns({
      container: selector,
      items: 1,
      autoplay: true,
      autoplayHoverPause: true,
      autoplayButtonOutput: false,
      gutter: 32,
      rewind: false,
      nav: true,
      speed: 600,
      controls: false
    });
  }
})(jQuery, Drupal, drupalSettings);
