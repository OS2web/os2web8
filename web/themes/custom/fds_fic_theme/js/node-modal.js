(function (Drupal, once) {
  'use strict';

  Drupal.behaviors.ficNodeModal = {
    attach: function attach(context) {
      once('fic-node-modal', '.js-fic-node-modal', context).forEach(function (wrapper) {
        var dialog = wrapper.querySelector('.js-fic-node-modal-dialog');
        var backdrop = wrapper.querySelector('.js-fic-node-modal-backdrop');
        var closeButtons = wrapper.querySelectorAll('.js-fic-node-modal-close');
        var reopenButton = wrapper.querySelector('.js-fic-node-modal-reopen');
        var autoOpen = wrapper.getAttribute('data-auto-open') === '1';
        var reopenEnabled = wrapper.getAttribute('data-reopen-enabled') === '1';
        var persistenceEnabled = wrapper.getAttribute('data-persistence-enabled') === '1';
        var persistenceDays = parseInt(wrapper.getAttribute('data-persistence-days'), 10);
        var persistenceKey = wrapper.getAttribute('data-persistence-key') || '';
        var isOpen = false;
        var previousFocusedElement = null;
        var focusableSelector = 'a[href], area[href], input:not([disabled]):not([type="hidden"]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), [tabindex]:not([tabindex="-1"])';

        if (!dialog || !backdrop) {
          return;
        }

        if (!Number.isFinite(persistenceDays) || persistenceDays < 1) {
          persistenceDays = 30;
        }

        function getCookieInformationApi() {
          if (window.CookieInformation) {
            return window.CookieInformation;
          }

          if (window.cookieInformation) {
            return window.cookieInformation;
          }

          return null;
        }

        function hasCookieInformationConsent() {
          var api = getCookieInformationApi();
          if (!api) {
            return false;
          }

          try {
            if (typeof api.getConsentGivenFor === 'function') {
              var categories = [
                'cookie_cat_preference',
                'cookie_cat_preferences',
                'cookie_cat_statistic',
                'cookie_cat_statistics',
                'cookie_cat_marketing',
                'preferences',
                'statistics',
                'marketing'
              ];

              return categories.some(function (category) {
                return api.getConsentGivenFor(category) === true;
              });
            }

            if (typeof api.getConsentLevel === 'function') {
              return Number(api.getConsentLevel()) > 0;
            }
          }
          catch (error) {
            return false;
          }

          return false;
        }

        function canUsePersistence() {
          if (!persistenceEnabled || !persistenceKey) {
            return false;
          }

          // Privacy-safe default: if consent signal cannot be verified, do not persist.
          return hasCookieInformationConsent();
        }

        function readStorage(storageKey) {
          try {
            return window.localStorage.getItem(storageKey);
          }
          catch (error) {
            return null;
          }
        }

        function writeStorage(storageKey, value) {
          try {
            window.localStorage.setItem(storageKey, value);
            return true;
          }
          catch (error) {
            return false;
          }
        }

        function removeStorage(storageKey) {
          try {
            window.localStorage.removeItem(storageKey);
            return true;
          }
          catch (error) {
            return false;
          }
        }

        function readCookie(cookieName) {
          var escapedName = cookieName.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
          var match = document.cookie.match(new RegExp('(?:^|; )' + escapedName + '=([^;]*)'));
          return match ? decodeURIComponent(match[1]) : null;
        }

        function writeCookie(cookieName, cookieValue, days) {
          var expires = new Date();
          expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000));
          document.cookie = cookieName + '=' + encodeURIComponent(cookieValue) + '; expires=' + expires.toUTCString() + '; path=/; SameSite=Lax';
        }

        function eraseCookie(cookieName) {
          document.cookie = cookieName + '=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/; SameSite=Lax';
        }

        function getPersistenceState() {
          if (!canUsePersistence()) {
            return null;
          }

          return readStorage(persistenceKey) || readCookie(persistenceKey);
        }

        function setDismissedState() {
          if (!canUsePersistence()) {
            return;
          }

          // localStorage first, cookie fallback for stricter environments.
          if (!writeStorage(persistenceKey, 'dismissed')) {
            writeCookie(persistenceKey, 'dismissed', persistenceDays);
          }
          else {
            writeCookie(persistenceKey, 'dismissed', persistenceDays);
          }
        }

        function clearDismissedState() {
          if (!persistenceEnabled || !persistenceKey) {
            return;
          }

          removeStorage(persistenceKey);
          eraseCookie(persistenceKey);
        }

        function trapFocus(event) {
          if (!isOpen || event.key !== 'Tab') {
            return;
          }

          var focusableElements = dialog.querySelectorAll(focusableSelector);
          if (!focusableElements.length) {
            event.preventDefault();
            dialog.focus();
            return;
          }

          var first = focusableElements[0];
          var last = focusableElements[focusableElements.length - 1];
          var active = document.activeElement;

          if (event.shiftKey && active === first) {
            event.preventDefault();
            last.focus();
          }
          else if (!event.shiftKey && active === last) {
            event.preventDefault();
            first.focus();
          }
        }

        function setHiddenState(open) {
          isOpen = open;
          dialog.hidden = !open;
          backdrop.hidden = !open;

          if (open) {
            wrapper.classList.add('is-open');
            document.body.classList.add('fic-node-modal-open');
            previousFocusedElement = document.activeElement;
            dialog.focus();
          }
          else {
            wrapper.classList.remove('is-open');
            document.body.classList.remove('fic-node-modal-open');
            if (reopenEnabled && reopenButton) {
              reopenButton.hidden = false;
            }
            if (previousFocusedElement && typeof previousFocusedElement.focus === 'function') {
              previousFocusedElement.focus();
            }
          }
        }

        function openModal() {
          setHiddenState(true);
        }

        function closeModal() {
          setDismissedState();
          setHiddenState(false);
        }

        closeButtons.forEach(function (button) {
          button.addEventListener('click', closeModal);
        });

        backdrop.addEventListener('click', closeModal);

        dialog.addEventListener('click', function (event) {
          // If user clicks the overlay area accidentally inside dialog wrapper.
          if (event.target === dialog) {
            closeModal();
          }
        });

        document.addEventListener('keydown', function (event) {
          if (!isOpen) {
            return;
          }

          if (event.key === 'Escape') {
            closeModal();
          }

          trapFocus(event);
        });

        if (reopenButton) {
          reopenButton.addEventListener('click', function () {
            reopenButton.hidden = true;
            clearDismissedState();
            openModal();
          });
        }

        var isDismissed = getPersistenceState() === 'dismissed';

        if (autoOpen && !isDismissed) {
          openModal();
        }
        else if (reopenEnabled && reopenButton) {
          reopenButton.hidden = false;
        }
      });
    }
  };
})(Drupal, once);
