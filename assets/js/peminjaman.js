/* ─────────────────────────────────────────────────────────
   Museum Kota Samarinda — peminjaman.js  v2
   Sinkron dengan tabel peminjaman_ruang di DB
───────────────────────────────────────────────────────── */

/* ── SIDEBAR TOGGLE ─────────────────────────────────── */
(function () {
  const body    = document.body;
  const sidebar = document.getElementById('global-sidebar');
  const openers = document.querySelectorAll('[data-sidebar-toggle]');
  const closers = document.querySelectorAll('[data-sidebar-close]');
  if (!sidebar || !openers.length) return;
  function openSidebar() {
  sidebar.classList.add('open'); 
  sidebar.setAttribute('aria-hidden', 'false');
  }
  function closeSidebar() {
  sidebar.classList.remove('open'); 
  sidebar.setAttribute('aria-hidden', 'true');
  }
  function toggleSidebar() { body.classList.contains('sidebar-open') ? closeSidebar() : openSidebar(); }
  openers.forEach(btn => btn.addEventListener('click', toggleSidebar));
  closers.forEach(btn => btn.addEventListener('click', closeSidebar));
})();

const WA_NUMBER = '628125334435';

/* ── CALENDAR ────────────────────────────────────────── */
const MONTHS_ID = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
const DAYS_ID   = ['Min','Sen','Sel','Rab','Kam','Jum','Sab'];

let CALENDAR_EVENTS = {};
let calYear  = new Date().getFullYear();
let calMonth = new Date().getMonth();

async function loadCalendarEvents() {
  try {
    const res = await fetch('api/peminjaman.php?calendar=1', {
      headers: { 'Accept': 'application/json' }
    });
    const result = await res.json().catch(() => ({}));
    if (!res.ok) throw new Error(result.error || 'Gagal memuat kalender');

    CALENDAR_EVENTS = {};
    (result.events || []).forEach((ev) => {
      const startDate = new Date(String(ev.start_date) + 'T12:00:00');
      const endDate   = new Date(String(ev.end_date) + 'T12:00:00');

      if (Number.isNaN(startDate.getTime()) || Number.isNaN(endDate.getTime())) return;

      for (let d = new Date(startDate); d <= endDate; d.setDate(d.getDate() + 1)) {
        const key = `${d.getFullYear()}-${d.getMonth() + 1}-${d.getDate()}`;
        if (!CALENDAR_EVENTS[key]) CALENDAR_EVENTS[key] = [];
        CALENDAR_EVENTS[key].push({
          label: ev.label,
          type: ev.type,
          source: ev.source || null
        });
      }
    });
  } catch (err) {
    console.warn('Gagal memuat kalender:', err.message);
    CALENDAR_EVENTS = {};
  }
}

function renderCalendar() {
  const grid  = document.getElementById('calendar-grid');
  const title = document.getElementById('cal-month-title');
  if (!grid || !title) return;

  title.textContent = `${MONTHS_ID[calMonth]} ${calYear}`;

  const firstDay    = new Date(calYear, calMonth, 1).getDay();
  const daysInMonth = new Date(calYear, calMonth + 1, 0).getDate();
  const today       = new Date();
  let html = '';

  DAYS_ID.forEach(d => { html += `<div class="cal-dow">${d}</div>`; });
  for (let i = 0; i < firstDay; i++) html += `<div class="cal-cell muted"></div>`;

  for (let d = 1; d <= daysInMonth; d++) {
    const key     = `${calYear}-${calMonth + 1}-${d}`;
    const events  = CALENDAR_EVENTS[key] || [];
    const isToday = today.getFullYear() === calYear && today.getMonth() === calMonth && today.getDate() === d;
    const isPast  = new Date(calYear, calMonth, d) < new Date(today.getFullYear(), today.getMonth(), today.getDate());

    const eventsHtml = events.length
      ? events.map(ev => {
          const safeLabel = String(ev.label || '').replace(/</g, '&lt;').replace(/>/g, '&gt;');
          return `<div class="cal-event ${ev.type}" title="${safeLabel}">${safeLabel}</div>`;
        }).join('')
      : '<div class="cal-event available">Tersedia</div>';

    html += `
      <div class="cal-cell${isPast ? ' muted' : ''}${isToday ? ' cal-today' : ''}">
        <div class="cal-date"><strong>${d}</strong></div>
        <div class="cal-events">${eventsHtml}</div>
      </div>`;
  }

  const remaining = (7 - ((firstDay + daysInMonth) % 7)) % 7;
  for (let i = 0; i < remaining; i++) html += `<div class="cal-cell muted"></div>`;
  grid.innerHTML = html;
}

document.getElementById('cal-prev')?.addEventListener('click', () => {
  if (--calMonth < 0) { calMonth = 11; calYear--; }
  
});
document.getElementById('cal-next')?.addEventListener('click', () => {
  if (++calMonth > 11) { calMonth = 0; calYear++; }
  renderCalendar();
});
document.getElementById('cal-today-btn')?.addEventListener('click', () => {
  const t = new Date(); calYear = t.getFullYear(); calMonth = t.getMonth();
  renderCalendar();
});
(async function initCalendar() {
  await loadCalendarEvents();
  renderCalendar();
})();
renderCalendar();

/* ── DURASI → DATETIME CONVERTER ────────────────────── */
// Opsi durasi di select → [jam_mulai, jam_selesai]
const DURASI_MAP = {
  '½ Hari (Pagi: 08:00–12:00)':   ['08:00', '12:00'],
  '½ Hari (Sore: 13:00–17:00)':   ['13:00', '17:00'],
  '1 Hari Penuh (08:00–17:00)':   ['08:00', '17:00'],
  '2–3 Hari':                     ['08:00', '17:00'],  // tanggal_selesai di-handle +2 hari
  '1 Minggu':                     ['08:00', '17:00'],  // tanggal_selesai di-handle +7 hari
};

const DURASI_DAYS_EXTRA = {
  '½ Hari (Pagi: 08:00–12:00)':  0,
  '½ Hari (Sore: 13:00–17:00)':  0,
  '1 Hari Penuh (08:00–17:00)':  0,
  '2–3 Hari':                    2,
  '1 Minggu':                    6,
};

function buildDatetimes(tanggal, durasi) {
  const times    = DURASI_MAP[durasi];
  const daysExtra = DURASI_DAYS_EXTRA[durasi];
  if (!times || tanggal === '') return null;

  const tglMulai   = `${tanggal} ${times[0]}:00`;

  // tanggal_selesai = tanggal + daysExtra hari
  const endDate = new Date(tanggal + 'T12:00:00');
  endDate.setDate(endDate.getDate() + daysExtra);
  const endY = endDate.getFullYear();
  const endM = String(endDate.getMonth() + 1).padStart(2, '0');
  const endD = String(endDate.getDate()).padStart(2, '0');
  const tglSelesai = `${endY}-${endM}-${endD} ${times[1]}:00`;

  return { tglMulai, tglSelesai };
}

/* ── VALIDASI ────────────────────────────────────────── */
function validateEmail(v) { return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v); }
function validatePhone(v) { return /^[0-9+\-\s]{7,20}$/.test(v); }

function setError(id, show, msg) {
  const input = document.getElementById(id);
  const errId = 'e-' + id.replace('f-', '');
  const err   = document.getElementById(errId);
  if (!input || !err) return;
  input.classList.toggle('error', show);
  err.classList.toggle('show', show);
  if (show && msg) err.textContent = msg;
}

// Batas karakter sinkron dengan kolom DB
const FIELD_RULES = {
  'f-nama':      { label: 'Nama / Organisasi', maxLen: 100 },
  'f-instansi':  { label: 'Instansi', maxLen: 100 },
  'f-email':     { label: 'Email', maxLen: 100 },
  'f-telp':      { label: 'Nomor Telepon', maxLen: 20 },
  'f-jenis':     { label: 'Jenis Kegiatan', maxLen: 150 },
};

function validateForm() {
  let ok = true;

  // f-nama: required, max 100
  const nama = document.getElementById('f-nama')?.value.trim() ?? '';
  if (!nama)                         { setError('f-nama', true, 'Nama tidak boleh kosong'); ok = false; }
  else if (nama.length > 100)        { setError('f-nama', true, 'Maksimal 100 karakter'); ok = false; }
  else                                 setError('f-nama', false);

  // f-instansi: required, max 100 (sinkron kolom instansi NOT NULL)
  const instansi = document.getElementById('f-instansi')?.value.trim() ?? '';
  if (!instansi)                     { setError('f-instansi', true, 'Instansi tidak boleh kosong'); ok = false; }
  else if (instansi.length > 100)    { setError('f-instansi', true, 'Maksimal 100 karakter'); ok = false; }
  else                                 setError('f-instansi', false);

  // f-telp: required, format nomor, max 20
  const telp = document.getElementById('f-telp')?.value.trim() ?? '';
  if (!telp)                         { setError('f-telp', true, 'Nomor telepon tidak boleh kosong'); ok = false; }
  else if (!validatePhone(telp))     { setError('f-telp', true, 'Format tidak valid — gunakan angka, +, atau tanda hubung (7–20 karakter)'); ok = false; }
  else                                 setError('f-telp', false);

  // f-email: required, format valid, max 100
  const email = document.getElementById('f-email')?.value.trim() ?? '';
  if (!email)                        { setError('f-email', true, 'Email tidak boleh kosong'); ok = false; }
  else if (!validateEmail(email))    { setError('f-email', true, 'Format email tidak valid'); ok = false; }
  else if (email.length > 100)       { setError('f-email', true, 'Maksimal 100 karakter'); ok = false; }
  else                                 setError('f-email', false);

  // f-tanggal: required, min H+7 dari hari ini
  const tanggal = document.getElementById('f-tanggal')?.value ?? '';
  const minDate = new Date(); minDate.setDate(minDate.getDate() + 7);
  const minISO  = minDate.toISOString().split('T')[0];
  if (!tanggal)                      { setError('f-tanggal', true, 'Tanggal tidak boleh kosong'); ok = false; }
  else if (tanggal < minISO)         { setError('f-tanggal', true, 'Minimal H+7 dari hari ini (booking harus diajukan 7 hari sebelumnya)'); ok = false; }
  else                                 setError('f-tanggal', false);

  // f-durasi: required
  const durasi = document.getElementById('f-durasi')?.value ?? '';
  if (!durasi)                       { setError('f-durasi', true, 'Pilih durasi penggunaan'); ok = false; }
  else                                 setError('f-durasi', false);

  // f-jenis: required, max 150 (sinkron kolom nama_kegiatan varchar(150))
  const jenis = document.getElementById('f-jenis')?.value ?? '';
  if (!jenis)                        { setError('f-jenis', true, 'Pilih jenis kegiatan'); ok = false; }
  else                                 setError('f-jenis', false);

  // f-peserta: required, int 1–500 (sinkron kolom jumlah_peserta int)
  const peserta = parseInt(document.getElementById('f-peserta')?.value ?? '0', 10);
  if (!peserta || peserta < 1)       { setError('f-peserta', true, 'Masukkan jumlah peserta minimal 1 orang'); ok = false; }
  else if (peserta > 250)            { setError('f-peserta', true, 'Maksimal 250 peserta (kapasitas Ruang Terbuka)'); ok = false; }
  else                                 setError('f-peserta', false);

  // f-deskripsi: required (sinkron kolom deskripsi_kegiatan NOT NULL)
  const deskripsi = document.getElementById('f-deskripsi')?.value.trim() ?? '';
  if (!deskripsi)                    { setError('f-deskripsi', true, 'Deskripsi kegiatan wajib diisi'); ok = false; }
  else                                 setError('f-deskripsi', false);

  return ok;
}

// Clear error real-time saat user mengetik
['f-nama','f-instansi','f-telp','f-email','f-tanggal','f-durasi','f-jenis','f-peserta','f-deskripsi'].forEach(id => {
  const el = document.getElementById(id);
  if (el) {
    el.addEventListener('input',  () => setError(id, false));
    el.addEventListener('change', () => setError(id, false));
  }
});

// Set min date pada input tanggal (H+7)
window.addEventListener('DOMContentLoaded', () => {
  const inputTgl = document.getElementById('f-tanggal');
  if (inputTgl) {
    const minDate = new Date();
    minDate.setDate(minDate.getDate() + 7);
    inputTgl.min = minDate.toISOString().split('T')[0];
  }
});

/* ── REF NUMBER ──────────────────────────────────────── */
function generateRef() {
  const now  = new Date();
  const yy   = String(now.getFullYear()).slice(2);
  const mm   = String(now.getMonth() + 1).padStart(2, '0');
  const rand = String(Math.floor(1000 + Math.random() * 9000));
  return `MKS/${yy}${mm}/${rand}`;
}

function formatTanggal(iso) {
  if (!iso) return '—';
  const [y, m, d] = iso.split('-');
  return `${d} ${MONTHS_ID[parseInt(m, 10) - 1]} ${y}`;
}

/* ── MODAL STEP 1 — PRATINJAU ────────────────────────── */
let currentRef = '';

document.getElementById('btn-kirim')?.addEventListener('click', () => {
  if (!validateForm()) {
    document.getElementById('peminjaman-form')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
    return;
  }

  currentRef = generateRef();

  document.getElementById('inv-nomor').textContent    = currentRef;
  document.getElementById('inv-nama').textContent     = document.getElementById('f-nama').value.trim();
  document.getElementById('inv-instansi').textContent = document.getElementById('f-instansi').value.trim();
  document.getElementById('inv-telp').textContent     = document.getElementById('f-telp').value.trim();
  document.getElementById('inv-email').textContent    = document.getElementById('f-email').value.trim();
  document.getElementById('inv-tanggal').textContent  = formatTanggal(document.getElementById('f-tanggal').value);
  document.getElementById('inv-durasi').textContent   = document.getElementById('f-durasi').value;
  document.getElementById('inv-jenis').textContent    = document.getElementById('f-jenis').value;
  document.getElementById('inv-ruang').textContent    = document.getElementById('f-ruang').value || 'Belum dipilih';
  document.getElementById('inv-peserta').textContent  = document.getElementById('f-peserta').value + ' orang';

  const deskrip = document.getElementById('f-deskripsi').value.trim();
  const descEl  = document.getElementById('inv-deskripsi');
  descEl.textContent = deskrip;
  descEl.classList.toggle('empty', !deskrip);

  openModal('modal-step1');
});

document.getElementById('modal-step1-close')?.addEventListener('click', () => closeModal('modal-step1'));
document.getElementById('btn-step1-cancel')?.addEventListener('click', () => closeModal('modal-step1'));

/* ── MODAL STEP 2 — SUBMIT KE DB + WA ───────────────── */
document.getElementById('btn-step1-confirm')?.addEventListener('click', async () => {
  closeModal('modal-step1');

  const tanggal = document.getElementById('f-tanggal').value;
  const durasi  = document.getElementById('f-durasi').value;
  const times   = buildDatetimes(tanggal, durasi);

  // Kirim ke database
  try {
    const payload = {
      nama_peminjam:      document.getElementById('f-nama').value.trim(),
      instansi:           document.getElementById('f-instansi').value.trim(),
      email:              document.getElementById('f-email').value.trim(),
      no_hp:              document.getElementById('f-telp').value.trim(),
      nama_kegiatan:      document.getElementById('f-jenis').value,
      tanggal_mulai:      times?.tglMulai ?? '',
      tanggal_selesai:    times?.tglSelesai ?? '',
      jumlah_peserta:     parseInt(document.getElementById('f-peserta').value, 10),
      deskripsi_kegiatan: document.getElementById('f-deskripsi').value.trim(),
    };

    const res = await fetch('api/peminjaman.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload),
    });

    const result = await res.json().catch(() => ({}));

    if (!res.ok) {
      // Jika session expired / belum login, redirect ke login
      if (result.require_login) {
        window.location.href = 'login.php?redirect=peminjaman.php%23peminjaman-form&require=1';
        return;
      }
      throw new Error(result.error || 'Gagal menyimpan ke server');
    }
  } catch (err) {
  alert('Gagal mengirim permohonan: ' + err.message);
  console.warn('API error:', err.message);
  return;
  }

  // Tampilkan modal step 2 + WA deeplink
  document.getElementById('wa-nomor-ref').textContent  = currentRef;
  document.getElementById('wa-ref-display').textContent = currentRef;

  const nama     = document.getElementById('f-nama').value.trim();
  const instansi = document.getElementById('f-instansi').value.trim();
  const telp     = document.getElementById('f-telp').value.trim();
  const jenis    = document.getElementById('f-jenis').value;
  const ruang    = 'Ruang Terbuka';
  const peserta  = document.getElementById('f-peserta').value;
  const deskrip  = document.getElementById('f-deskripsi').value.trim();

  const msg = [
    `*PERMOHONAN PEMINJAMAN RUANG*`,
    `Museum Kota Samarinda`,
    `Ref: ${currentRef}`,
    ``,
    `*Data Pemohon*`,
    `Nama/Organisasi : ${nama}`,
    `Instansi        : ${instansi}`,
    `No. Telepon     : ${telp}`,
    ``,
    `*Detail Kegiatan*`,
    `Tanggal         : ${formatTanggal(tanggal)}`,
    `Durasi          : ${durasi}`,
    `Jenis Kegiatan  : ${jenis}`,
    `Ruang           : ${ruang}`,
    `Jumlah Peserta  : ${peserta} orang`,
    deskrip ? `\nDeskripsi:\n${deskrip}` : '',
    ``,
    `Mohon konfirmasi ketersediaan ruang. Terima kasih.`,
  ].filter(Boolean).join('\n');

  document.getElementById('btn-wa-link').href = `https://wa.me/${WA_NUMBER}?text=${encodeURIComponent(msg)}`;
  openModal('modal-step2');
});

document.getElementById('btn-wa-done')?.addEventListener('click', () => {
  closeModal('modal-step2');
  ['f-nama','f-instansi','f-telp','f-email','f-tanggal','f-durasi','f-jenis','f-peserta','f-ruang','f-deskripsi'].forEach(id => {
    const el = document.getElementById(id);
    if (el) el.value = '';
  });
  window.scrollTo({ top: 0, behavior: 'smooth' });
});

/* ── MODAL HELPERS ───────────────────────────────────── */
function openModal(id) {
  const overlay = document.getElementById(id);
  if (overlay) { overlay.classList.add('open'); document.body.style.overflow = 'hidden'; }
}
function closeModal(id) {
  const overlay = document.getElementById(id);
  if (overlay) { overlay.classList.remove('open'); document.body.style.overflow = ''; }
}
document.querySelectorAll('.modal-overlay').forEach(overlay => {
  overlay.addEventListener('click', e => { if (e.target === overlay) closeModal(overlay.id); });
});
document.addEventListener('keydown', e => {
  if (e.key === 'Escape') { closeModal('modal-step1'); closeModal('modal-step2'); }
});