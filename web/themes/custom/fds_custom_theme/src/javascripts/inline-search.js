(function() {
  const searchToggles = document.querySelectorAll('.js-toggle-inline-search');

  const handleToggle = event => {
    const target = event.target;
    const parentNode = target.closest('.inline-search');

    parentNode.classList.toggle('inline-search--toggled');
  };

  const closeAll = event => {
    const target = event.target;
    const parentNode = target.closest('.inline-search');
    const inlineSearches = document.querySelectorAll('.inline-search');

    // Click is inside ".inside-search" - stop everything.
    if (parentNode) {
      return;
    }

    for(let inlineSearch of inlineSearches) {
      inlineSearch.classList.remove('inline-search--toggled');
    }
  };

  for(let toggle of searchToggles) {
    toggle.addEventListener('click', handleToggle);
  }

  document.addEventListener('click', closeAll, false);
})();
