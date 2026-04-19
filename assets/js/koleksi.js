function setFilter(btn, cat) {
  const group = btn.closest('.koleksi-filter');
  if (!group) return;
  group.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
}

function setRating(n) {
  const stars = document.querySelectorAll('.star-btn');
  stars.forEach((s, i) => s.classList.toggle('selected', i < n));
  const label = document.querySelector('.star-select span');
  if (label) label.textContent = n + ' / 5';
}

(function () {
  const body = document.body;
  const sidebar = document.getElementById('global-sidebar');
  const openers = document.querySelectorAll('[data-sidebar-toggle]');
  const closers = document.querySelectorAll('[data-sidebar-close]');
  if (!sidebar || !openers.length) return;
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
})();

