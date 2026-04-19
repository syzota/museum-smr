(function () {
  const body = document.body;
  const sidebar = document.getElementById('global-sidebar');
  const openers = document.querySelectorAll('[data-sidebar-toggle]');
  const closers = document.querySelectorAll('[data-sidebar-close]');

  if (sidebar && openers.length) {
    function openSidebar() {
      body.classList.add('sidebar-open');
      sidebar.setAttribute('aria-hidden', 'false');
    }

    function closeSidebar() {
      body.classList.remove('sidebar-open');
      sidebar.setAttribute('aria-hidden', 'true');
    }

    function toggleSidebar() {
      if (body.classList.contains('sidebar-open')) closeSidebar();
      else openSidebar();
    }

    openers.forEach((btn) => btn.addEventListener('click', toggleSidebar));
    closers.forEach((btn) => btn.addEventListener('click', closeSidebar));
  }

  const mapCta = document.querySelector('.ps-cta-primary');
  if (mapCta) {
    mapCta.addEventListener('click', function () {
      this.blur();
    });
  }
})();