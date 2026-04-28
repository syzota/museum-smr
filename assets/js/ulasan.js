/* ══════════════════════════════════════════════
   assets/js/ulasan.js
   Fetch komentar dari /api/ulasan.php, submit baru
══════════════════════════════════════════════ */

document.addEventListener('DOMContentLoaded', () => {
  fetchKomentar();
  initSidebar();
});

// ── Fetch & render ────────────────────────────────────────────────────────────
async function fetchKomentar() {
  try {
    const res  = await fetch('api/ulasan.php');
    if (!res.ok) throw new Error('HTTP ' + res.status);
    const data = await res.json();
    renderGrid(data.komentar || []);
  } catch (err) {
    document.getElementById('ulasan-grid').innerHTML =
      '<div class="ulasan-empty" style="grid-column:1/-1;padding:48px;text-align:center;">Gagal memuat ulasan. Silakan coba lagi.</div>';
  }
}

function renderGrid(list) {
  const grid  = document.getElementById('ulasan-grid');
  const label = document.getElementById('komentar-total-label');

  if (label) label.textContent = list.length + ' Ulasan';

  if (!list.length) {
    grid.innerHTML = '<div class="ulasan-empty" style="grid-column:1/-1;padding:48px;text-align:center;">Belum ada ulasan. Jadilah yang pertama!</div>';
    return;
  }

  grid.innerHTML = list.map((k, idx) => {
    const bg = idx % 2 === 1 ? 'background:var(--parchment);' : '';
    return `
       <div class="ulasan-full-card" style="${bg}">

    <div style="display:flex;justify-content:space-between;align-items:center;">
      <span class="ulasan-name">${escHtml(k.nama)}</span>

      ${
        currentUserId && k.user_id == currentUserId
        ? `
        <div class="menu-wrapper">
          <div class="menu-trigger" onclick="toggleMenu(${k.id})">⋮</div>
          <div class="menu-dropdown" id="menu-${k.id}">
            <div class="menu-item delete" onclick="hapusUlasan(${k.id})">
              Hapus
            </div>
          </div>
        </div>
        `
        : ''
      }

    </div>

    <div class="ulasan-text">"${escHtml(k.isi_komentar)}"</div>

    <div class="ulasan-meta">
      <span class="ulasan-date">${formatTanggal(k.tanggal)}</span>
    </div>

  </div>
`;
  }).join('');
}

// ── Prepend satu kartu baru tanpa reload ──────────────────────────────────────
function prependCard(k) {
  const grid = document.getElementById('ulasan-grid');

  // Hapus state "belum ada ulasan" kalau ada
  const empty = grid.querySelector('.ulasan-empty');
  if (empty) empty.remove();

  // Re-index warna bergantian berdasarkan jumlah kartu yang sudah ada
  const existing = grid.querySelectorAll('.ulasan-full-card').length;
  const bg = existing % 2 === 1 ? 'background:var(--parchment);' : '';

  const card = document.createElement('div');
  card.className = 'ulasan-full-card';
  card.style.cssText = bg + 'animation:fadeSlideIn 0.4s ease;';
  card.innerHTML = `
    <div class="ulasan-text">"${escHtml(k.isi_komentar)}"</div>
    <div class="ulasan-meta">
      <span class="ulasan-name">${escHtml(k.nama)}</span>
      <span class="ulasan-date">${formatTanggal(k.tanggal)}</span>
    </div>`;

  grid.insertBefore(card, grid.firstChild);

  // Update label jumlah
  const label = document.getElementById('komentar-total-label');
  if (label) {
    const n = grid.querySelectorAll('.ulasan-full-card').length;
    label.textContent = n + ' Ulasan';
  }
}

function toggleMenu(id) {
  document.querySelectorAll('.menu-dropdown').forEach(menu => {
    if (menu.id !== `menu-${id}`) menu.classList.remove('show');
  });

  const menu = document.getElementById(`menu-${id}`);
  if (menu) menu.classList.toggle('show');
}

async function hapusUlasan(id) {
  if (!confirm('Yakin mau hapus ulasan ini?')) return;

  try {
    const res = await fetch('api/ulasan.php', {
      method: 'DELETE',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ id: id })
    });

    const data = await res.json();

    if (!res.ok) {
      alert(data.error || 'Gagal menghapus ulasan.');
      return;
    }

    fetchKomentar();
  } catch (err) {
    alert('Gagal menghubungi server.');
  }
}

// ── Submit komentar ───────────────────────────────────────────────────────────
async function submitKomentar() {
  const btn      = document.getElementById('btn-submit');
  const statusEl = document.getElementById('form-status');
  const textarea = document.getElementById('field-komentar');
  const isi      = textarea?.value?.trim() ?? '';

  if (isi.length < 5) {
    showStatus(statusEl, 'Komentar terlalu pendek.', 'error');
    return;
  }

  btn.disabled    = true;
  btn.textContent = 'Mengirim…';

  try {
    const res  = await fetch('api/ulasan.php', {
      method:  'POST',
      headers: { 'Content-Type': 'application/json' },
      body:    JSON.stringify({ isi_komentar: isi }),
    });
    const data = await res.json();

    if (res.status === 401) {
      showStatus(statusEl, 'Sesi berakhir, mengalihkan ke login…', 'error');
      setTimeout(() => { location.href = 'login.php'; }, 1500);
      return;
    }
    if (!res.ok) {
      showStatus(statusEl, data.error || 'Terjadi kesalahan.', 'error');
      return;
    }

    // Sukses — tambahkan kartu langsung tanpa reload
    textarea.value = '';
    showStatus(statusEl, 'Komentar berhasil dikirim!', 'ok');
    prependCard(data.komentar);

  } catch (err) {
    showStatus(statusEl, 'Gagal menghubungi server.', 'error');
  } finally {
    btn.disabled    = false;
    btn.textContent = 'Kirim →';
  }
}

// ── Helpers ───────────────────────────────────────────────────────────────────
function showStatus(el, msg, type) {
  if (!el) return;
  el.textContent  = msg;
  el.style.color  = type === 'ok' ? '#2d6a4f' : '#c0392b';
}

function formatTanggal(str) {
  if (!str) return '';
  const d = new Date(str);
  return isNaN(d) ? str : d.toLocaleDateString('id-ID', { day:'numeric', month:'short', year:'numeric' });
}

function escHtml(s) {
  if (!s) return '';
  const map = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#39;',
    '/': '&#x2F;',
    '`': '&#96;',
    '=': '&#61;',
    '(': '&#40;',
    ')': '&#41;',
    '[': '&#91;',
    ']': '&#93;',
    '{': '&#123;',
    '}': '&#125;',
    '!': '&#33;',
    '+': '&#43;',
    '-': '&#45;'
  };
  return String(s).replace(/[&<>"'`=\/\(\)\[\]\{\}!\+\-]/g, (char) => map[char]);
}

// ── Sidebar ───────────────────────────────────────────────────────────────────
function initSidebar() {
  const body    = document.body;
  const sidebar = document.getElementById('global-sidebar');
  const openers = document.querySelectorAll('[data-sidebar-toggle]');
  const closers = document.querySelectorAll('[data-sidebar-close]');
  if (!sidebar || !openers.length) return;
  const open  = () => { body.classList.add('sidebar-open');    sidebar.setAttribute('aria-hidden','false'); };
  const close = () => { body.classList.remove('sidebar-open'); sidebar.setAttribute('aria-hidden','true');  };
  openers.forEach(b => b.addEventListener('click', () => body.classList.contains('sidebar-open') ? close() : open()));
  closers.forEach(b => b.addEventListener('click', close));
}