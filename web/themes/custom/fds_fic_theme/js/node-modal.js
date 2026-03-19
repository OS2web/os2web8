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
        var isOpen = false;
        var previousFocusedElement = null;

        if (!dialog || !backdrop) {
          return;
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
        });

        if (reopenButton) {
          reopenButton.addEventListener('click', function () {
            reopenButton.hidden = true;
            openModal();
          });
        }

        if (autoOpen) {
          openModal();
        }
        else if (reopenEnabled && reopenButton) {
          reopenButton.hidden = false;
        }
      });
    }
  };
})(Drupal, once);
