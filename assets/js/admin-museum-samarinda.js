// ═══════════════════════════════════════════════════════════
//  admin-museum-samarinda.js  —  v2 (connected to DB)
// ═══════════════════════════════════════════════════════════

const PAGE = document.body.dataset.page;

// ─── TOAST ───
function showToast(msg, type = 'success') {
  const t = document.createElement('div');
  t.className = `toast toast-${type}`;
  t.textContent = msg;
  document.getElementById('toast-container').appendChild(t);
  setTimeout(() => t.remove(), 3100);
}

// ─── FORMAT DATE ───
function fmtDate(d) {
  if (!d) return '-';
  return new Date(d + 'T12:00').toLocaleDateString('id-ID',{day:'numeric',month:'short',year:'numeric'});
}

// ─── TAG HELPERS ───
function kondisiTag(k) {
  if (!k || k === '-') return '<span class="tag tag-tan">—</span>';
  const m = {'Sangat Baik':'green','Baik':'green','Cukup':'tan','Rusak Ringan':'red','Rusak Berat':'red'};
  return `<span class="tag tag-${m[k]||'tan'}">${k}</span>`;
}
function statusTag(s) {
  const map = { Aktif:'tag-green', Selesai:'tag-tan', Dibatalkan:'tag-red', pending:'tag-blue', disetujui:'tag-green', ditolak:'tag-red' };
  return `<span class="tag ${map[s]||'tag-tan'}">${s.charAt(0).toUpperCase()+s.slice(1)}</span>`;
}

// ─── FILTER TABLE SEARCH ───
function filterTable(tableId, query) {
  document.querySelectorAll('#'+tableId+' tbody tr').forEach(row => {
    row.style.display = row.textContent.toLowerCase().includes(query.toLowerCase()) ? '' : 'none';
  });
}

// ─── FILTER TABS ───
window.filterKatBerita = (kat, el) => execFilterKat(kat, el, 'sec-berita', 'berita-tbody');

function execFilterKat(kat, el, sectionId, tbodyId) {
    const section = document.getElementById(sectionId);
    if (section) {
        section.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
    }
    el.classList.add('active');

    const target = (kat || "").toLowerCase().trim();
    const rows = document.querySelectorAll('#' + tbodyId + ' tr');

    console.log("DEBUG: Mencari kategori ->", `"${target}"`);

    rows.forEach(row => {
        const rowKat = (row.dataset.kat || "").toLowerCase().trim();
        
        console.log(`DEBUG: Membandingkan dengan baris -> "${rowKat}"`);

        if (target === "" || rowKat === target) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
}
// ─── MODAL OPEN / CLOSE ───
let modalMode = {};
function openModal(modalId, mode, id) {
  modalMode[modalId] = { mode, id };
  document.getElementById(modalId).classList.add('open');
  if (mode === 'create') {
    clearForm(modalId);
    const key = modalId.replace('modal-','');
    const labels  = { koleksi:'Koleksi Baru', kegiatan:'Kegiatan Baru', berita:'Berita Baru' };
    const lblEl   = document.getElementById('modal-'+key+'-label');
    const ttlEl   = document.getElementById('modal-'+key+'-title');
    const btnEl   = document.getElementById('btn-submit-'+key);
    if (lblEl) lblEl.textContent = 'Tambah Data Baru';
    if (ttlEl) ttlEl.textContent = labels[key] || 'Baru';
    if (btnEl) btnEl.textContent = 'Simpan';
  }
}
function closeModal(modalId) {
  const modal = document.getElementById(modalId);
  if (modal) {
    modal.classList.remove('open');
    clearErrors(modalId);
  }
}
function clearForm(modalId) {
  const form = document.querySelector('#'+modalId+' form');
  if (form) form.querySelectorAll('input,select,textarea').forEach(el => { if (el.type !== 'hidden') el.value = ''; });
  clearErrors(modalId);
}
function clearErrors(modalId) {
  document.querySelectorAll('#'+modalId+' .form-error').forEach(e => e.classList.remove('show'));
  document.querySelectorAll('#'+modalId+' .form-control').forEach(e => e.classList.remove('error'));
}
document.querySelectorAll('.modal-overlay').forEach(o => {
  o.addEventListener('click', e => {
    if (e.target === o) closeModal(o.id);
  });
});

// ─── CONFIRM DIALOG ───
let confirmCallback = null;
function showConfirm(title, msg, cb) {
  document.getElementById('confirm-title').textContent = title;
  document.getElementById('confirm-msg').textContent   = msg;
  confirmCallback = cb;
  document.getElementById('confirm-overlay').classList.add('open');
}
function closeConfirm() {
  document.getElementById('confirm-overlay').classList.remove('open');
  confirmCallback = null;
}
const confirmYesBtn = document.getElementById('confirm-yes-btn');
if (confirmYesBtn) confirmYesBtn.addEventListener('click', () => { if (confirmCallback) confirmCallback(); closeConfirm(); });
const confirmOverlay = document.getElementById('confirm-overlay');
if (confirmOverlay) confirmOverlay.addEventListener('click', e => { if (e.target === confirmOverlay) closeConfirm(); });

// ─── VALIDATION HELPERS ───
function setErr(fieldId, errId, show) {
  const f = document.getElementById(fieldId);
  const e = document.getElementById(errId);
  if (f) f.classList.toggle('error', show);
  if (e) e.classList.toggle('show', show);
  return show;
}
function isURL(str) { try { new URL(str); return true; } catch { return false; } }

// ─── ESC KEY ───
document.addEventListener('keydown', e => {
  if (e.key !== 'Escape') return;
  document.querySelectorAll('.modal-overlay.open').forEach(m => closeModal(m.id));
  closeConfirm();
});

// ═══════════════════════════════════════════════════════════
//  AJAX HELPER
// ═══════════════════════════════════════════════════════════
async function apiRequest(url, method = 'GET', data = null) {
  const opts = { method, headers: { 'Content-Type': 'application/json' } };
  if (data) opts.body = JSON.stringify(data);
  const res = await fetch(url, opts);
  if (!res.ok) {
    const err = await res.json().catch(() => ({ error: 'HTTP ' + res.status }));
    throw new Error(err.error || 'HTTP ' + res.status);
  }
  return res.json();
}

// ═══════════════════════════════════════════════════════════
//  DASHBOARD
// ═══════════════════════════════════════════════════════════
function animateNumber(element, target, duration = 1000) {
  if (!element) return;
  const start = 0;
  const steps = 60;
  const increment = (target - start) / steps;
  let current = start;
  const timer = setInterval(() => {
    current += increment;
    if (current >= target) {
      current = target;
      clearInterval(timer);
    }
    element.textContent = Math.floor(current);
  }, duration / steps);
}

if (PAGE === 'dashboard') {
  let statsChart = null;

  (async () => {
    const statElements = ['stat-koleksi', 'stat-kegiatan', 'stat-berita', 'stat-peminjaman'];

    statElements.forEach(id => {
      const el = document.getElementById(id);
      if (el) el.textContent = 'Memuat...';
    });

    try {
      const data = await apiRequest('../api/stats.php');

      statElements.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
          const key = id.replace('stat-', '');
          animateNumber(el, data[key] ?? 0);
        }
      });

      const chartCanvas = document.getElementById('statsChart');
      if (!chartCanvas || typeof Chart === 'undefined') return;

      const ctx = chartCanvas.getContext('2d');
      if (statsChart) statsChart.destroy();

      statsChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['Koleksi', 'Kegiatan', 'Berita', 'Peminjaman'],
          datasets: [{
            label: 'Jumlah',
            data: [
              data.koleksi ?? 0,
              data.kegiatan ?? 0,
              data.berita ?? 0,
              data.peminjaman ?? 0
            ],
            backgroundColor: [
              '#2d7a5e',
              '#8b4513',
              '#3a2e24',
              '#b8956a'
            ],
            borderColor: [
              '#2d7a5e',
              '#8b4513',
              '#3a2e24',
              '#b8956a'
            ],
            borderWidth: 1,
            borderRadius: 12,
            borderSkipped: false
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          animation: false,
          plugins: {
            legend: {
              display: false
            },
            tooltip: {
              backgroundColor: 'rgba(58, 46, 36, 0.96)',
              titleColor: '#faf6f1',
              bodyColor: '#f4ede5',
              borderColor: '#c4b5a0',
              borderWidth: 1,
              padding: 12,
              titleFont: {
                family: 'DM Mono',
                size: 11
              },
              bodyFont: {
                family: 'Spectral',
                size: 13
              }
            }
          },
          scales: {
            x: {
              grid: {
                display: false
              },
              border: {
                display: false
              },
              ticks: {
                color: '#6b5d4f',
                font: {
                  family: 'DM Mono',
                  size: 10
                }
              }
            },
            y: {
              beginAtZero: true,
              min: 0,
              suggestedMax: 100,
              ticks: {
                stepSize: 10,
                maxTicksLimit: 11,
                color: '#9a8d7e',
                font: {
                  family: 'DM Mono',
                  size: 10
                }
              },
              grid: {
                color: 'rgba(196, 181, 160, 0.35)',
                drawBorder: false
              },
              border: {
                display: false
              }
            }
          }
        }
      });
    } catch (err) {
      console.error('Error loading dashboard stats:', err);
      statElements.forEach(id => {
        const el = document.getElementById(id);
        if (el) el.textContent = 'Error';
      });
    }
  })();
}

// ═══════════════════════════════════════════════════════════
//  KOLEKSI
// ═══════════════════════════════════════════════════════════ss
if (PAGE === 'koleksi') {

const katMap = {
  
    'etnografika':    'etnografika', 
    'keramnologi':    'keramnologi',  
    'mangkok':        'mangkok',
    'guci':           'guci',
    'alat musik':     'alat musik',
    'pakaian adat':   'pakaian adat',
    'mandau':         'mandau',       
    'kerajinan tangan': 'kerajinan tangan',
    'bluko':          'bluko',
    'obat tradisional': 'obat tradisional',
    'sarung':         'sarung'
  };

  function katKey(nama) {
    return katMap[nama.toLowerCase()] || nama.toLowerCase();
  }

  async function loadKoleksi() {
    const tbody = document.getElementById('koleksi-tbody');
    tbody.innerHTML = `<tr><td colspan="6" style="text-align:center;padding:40px;color:var(--text-light);font-family:'DM Mono',monospace;font-size:9px;letter-spacing:1px;">Memuat data...</td></tr>`;
    try {
      const rows = await apiRequest('../api/koleksi.php');
      renderKoleksi(rows);
    } catch (err) {
      tbody.innerHTML = `<tr><td colspan="6"><div class="empty-state"><div class="empty-icon">◇</div><div class="empty-text">Gagal memuat data: ${err.message}</div></div></td></tr>`;
    }
  }

function renderKoleksi(rows) {
  const tbody = document.getElementById('koleksi-tbody');
  if (!rows.length) {
    tbody.innerHTML = `<tr><td colspan="6"><div class="empty-state">...</div></td></tr>`;
    return;
  }

  tbody.innerHTML = rows.map(k => {

    const katBersih = (k.kategori || "").toLowerCase().trim();

    return `
      <tr data-kat="${katBersih}"> 
        <td><span style="font-family:'DM Mono',monospace;font-size:8.5px;">${k.nomor || '—'}</span></td>
        <td><strong style="font-family:'Cormorant Garamond',serif;font-size:15px;">${k.nama}</strong></td>
        <td><span class="tag tag-tan">${k.kategori}</span></td>
        <td style="font-size:12px;color:var(--text-mid);">${k.era || '—'}</td>
        <td>${kondisiTag(k.kondisi)}</td>
        <td>
          <div class="td-actions">
            <button class="btn-icon" onclick="editKoleksi(${k.id})" title="Edit">✎</button>
            <button class="btn-icon del" onclick="deleteKoleksi(${k.id})" title="Hapus">⊗</button>
          </div>
        </td>
      </tr>
    `;
  }).join('');
}

  async function submitKoleksi(e) {
      if (e && e.preventDefault) e.preventDefault();
      let valid = true;

      const elNomor    = document.getElementById('k-nomor');
      const elNama     = document.getElementById('k-nama');
      const elKategori = document.getElementById('k-kategori');
      const elEra      = document.getElementById('k-era');
      const elKondisi  = document.getElementById('k-kondisi');
      const elFoto     = document.getElementById('k-foto'); // Ini sekarang input type="file"

      const nomor    = elNomor.value.trim();
      const nama     = elNama.value.trim();
      const kategori = elKategori.value;
      const era      = elEra.value.trim();
      const kondisi  = elKondisi.value;

      if (!nomor || !/^KOL-\d{4}$/.test(nomor))    valid = setErr('k-nomor','e-k-nomor',true) && false;    else setErr('k-nomor','e-k-nomor',false);
      if (!nama || nama.length < 3)               valid = setErr('k-nama','e-k-nama',true) && false;      else setErr('k-nama','e-k-nama',false);
      if (!kategori)                              valid = setErr('k-kategori','e-k-kategori',true) && false; else setErr('k-kategori','e-k-kategori',false);
      if (!era)                                   valid = setErr('k-era','e-k-era',true) && false;        else setErr('k-era','e-k-era',false);
      if (!kondisi)                               valid = setErr('k-kondisi','e-k-kondisi',true) && false; else setErr('k-kondisi','e-k-kondisi',false);
      
      const mode = modalMode['modal-koleksi']?.mode;
      if (mode !== 'edit' && elFoto.files.length === 0) {
          valid = setErr('k-foto','e-k-foto',true) && false;
      } else {
          setErr('k-foto','e-k-foto',false);
      }

      if (!valid) { showToast('Periksa kembali isian formulir','error'); return; }

      const formData = new FormData();
      formData.append('id', document.getElementById('k-id').value || '');
      formData.append('nomor', nomor);
      formData.append('nama', nama);
      formData.append('kategori', kategori);
      formData.append('era', era);
      formData.append('kondisi', kondisi);
      formData.append('asal', document.getElementById('k-asal').value.trim());
      formData.append('lokasi', document.getElementById('k-lokasi').value.trim());
      formData.append('deskripsi', document.getElementById('k-deskripsi').value.trim());
      
      if (elFoto.files[0]) {
          formData.append('foto', elFoto.files[0]);
      }

      try {

          const response = await fetch('../api/koleksi.php', {
              method: 'POST', 
              body: formData
          });

          const result = await response.json();

          if (result.success) {
              showToast(mode === 'edit' ? 'Koleksi berhasil diperbarui' : 'Koleksi berhasil ditambahkan','success');
              closeModal('modal-koleksi');
              loadKoleksi();
          } else {
              throw new Error(result.error || 'Gagal menyimpan');
          }
      } catch (err) { 
          showToast('Gagal menyimpan: ' + err.message,'error'); 
      }
  }

  async function editKoleksi(id) {
      try {
          const k = await apiRequest('../api/koleksi.php?id=' + id);
          openModal('modal-koleksi', 'edit', id);

          // Isi data teks
          document.getElementById('k-id').value        = k.id;
          document.getElementById('k-nomor').value     = k.nomor || '';
          document.getElementById('k-nama').value      = k.nama;
          document.getElementById('k-kategori').value  = k.kategori;
          document.getElementById('k-era').value       = k.era || '';
          document.getElementById('k-kondisi').value   = k.kondisi || '';
          document.getElementById('k-asal').value      = k.asal || '';
          document.getElementById('k-lokasi').value    = k.lokasi || '';
          document.getElementById('k-deskripsi').value = k.deskripsi || '';

          // Update Label & Title
          document.getElementById('modal-koleksi-label').textContent = 'Edit Data';
          document.getElementById('modal-koleksi-title').textContent = 'Perbarui Koleksi';
          document.getElementById('btn-submit-koleksi').textContent  = 'Simpan Perubahan';

          // Logika Preview Foto
          const previewImg = document.getElementById('v-foto-preview');
          const previewCont = document.getElementById('container-preview'); // Container pembungkus

          if (k.foto && previewImg) {
              previewImg.src = '../' + k.foto;
              if (previewCont) previewCont.style.display = 'block'; // Munculkan container
          } else {
              if (previewCont) previewCont.style.display = 'none'; // Sembunyikan kalau gak ada foto
          }

      } catch (err) {
          showToast('Gagal memuat data: ' + err.message, 'error');
      }
  }

  function deleteKoleksi(id) {
    showConfirm('Hapus Koleksi?','Data koleksi ini akan dihapus permanen.', async () => {
      try {
        await apiRequest('../api/koleksi.php','DELETE',{id});
        showToast('Koleksi berhasil dihapus','success');
        loadKoleksi();
      } catch (err) { showToast('Gagal menghapus: '+err.message,'error'); }
    });
  }

  window.submitKoleksi = submitKoleksi;
  window.editKoleksi   = editKoleksi;
  window.deleteKoleksi = deleteKoleksi;
  window.filterKat = (kat, el) => execFilterKat(kat, el, 'sec-koleksi', 'koleksi-tbody');

  loadKoleksi();
}

// ═══════════════════════════════════════════════════════════
//  KEGIATAN
// ═══════════════════════════════════════════════════════════
if (PAGE === 'kegiatan') {

  async function loadKegiatan() {
    const tbody = document.getElementById('kegiatan-tbody');
    tbody.innerHTML = `
      <tr>
        <td colspan="6" style="text-align:center;padding:40px;color:var(--text-light);font-family:'DM Mono',monospace;font-size:9px;letter-spacing:1px;">
          Memuat data...
        </td>
      </tr>
    `;

    try {
      const rows = await apiRequest('../api/kegiatan.php');
      renderKegiatan(rows);
    } catch (err) {
      tbody.innerHTML = `
        <tr>
          <td colspan="6">
            <div class="empty-state">
              <div class="empty-icon">◈</div>
              <div class="empty-text">Gagal memuat data: ${err.message}</div>
            </div>
          </td>
        </tr>
      `;
    }
  }

  function renderKegiatan(rows) {
    const tbody = document.getElementById('kegiatan-tbody');

    if (!rows || !rows.length) {
      tbody.innerHTML = `
        <tr>
          <td colspan="6">
            <div class="empty-state">
              <div class="empty-icon">◈</div>
              <div class="empty-text">Belum ada data kegiatan</div>
            </div>
          </td>
        </tr>
      `;
      return;
    }

    tbody.innerHTML = rows.map(k => `
      <tr data-kat="${(k.kategori || '').toLowerCase().trim()}">
        <td style="font-family:'DM Mono',monospace;font-size:8.5px;letter-spacing:1px;white-space:nowrap;">
          ${fmtDate(k.tanggal)}<br>
          <span style="color:var(--text-light);">${k.jam || '—'} WIB</span>
        </td>
        <td>
          <strong style="font-family:'Cormorant Garamond',serif;font-weight:400;font-size:15px;">
            ${k.nama}
          </strong>
        </td>
        <td style="font-size:12px;color:var(--text-mid);">${k.tempat || '—'}</td>
        <td><span class="tag tag-tan">${k.kategori || '—'}</span></td>
        <td>${statusTag(k.status || 'Aktif')}</td>
        <td>
          <div class="td-actions">
            <button class="btn-icon" onclick="editKegiatan(${k.id})" title="Edit">✎</button>
            <button class="btn-icon del" onclick="deleteKegiatan(${k.id})" title="Hapus">⊗</button>
          </div>
        </td>
      </tr>
    `).join('');
  }

  window.filterKatKeg = function(kat, el) {
    const tabs = document.querySelectorAll('#sec-kegiatan .filter-tab');
    tabs.forEach(t => t.classList.remove('active'));
    if (el) el.classList.add('active');

    const target = (kat || '').toLowerCase().trim();
    const rows = document.querySelectorAll('#kegiatan-tbody tr');

    rows.forEach(row => {
      const rowKat = (row.dataset.kat || '').toLowerCase().trim();
      row.style.display = (target === '' || rowKat === target) ? '' : 'none';
    });
  };

  async function submitKegiatan() {
    let valid = true;

    const nama = document.getElementById('kg-nama').value.trim();
    const tanggal = document.getElementById('kg-tanggal').value;
    const jam = document.getElementById('kg-jam').value;
    const kategori = document.getElementById('kg-kategori').value;
    const tempat = document.getElementById('kg-tempat').value;
    const deskripsi = document.getElementById('kg-deskripsi').value.trim();
    const id = document.getElementById('kg-id').value || null;

    if (!nama || nama.length < 5 || nama.length > 150) valid = setErr('kg-nama', 'e-kg-nama', true) && false; else setErr('kg-nama', 'e-kg-nama', false);
    if (!tanggal) valid = setErr('kg-tanggal', 'e-kg-tanggal', true) && false; else setErr('kg-tanggal', 'e-kg-tanggal', false);
    if (!jam) valid = setErr('kg-jam', 'e-kg-jam', true) && false; else setErr('kg-jam', 'e-kg-jam', false);
    if (!kategori) valid = setErr('kg-kategori', 'e-kg-kategori', true) && false; else setErr('kg-kategori', 'e-kg-kategori', false);
    if (!tempat) valid = setErr('kg-tempat', 'e-kg-tempat', true) && false; else setErr('kg-tempat', 'e-kg-tempat', false);

    if (!valid) {
      showToast('Periksa kembali isian formulir', 'error');
      return;
    }

    const payload = { id, nama, tanggal, jam, kategori, tempat, deskripsi };
    const mode = modalMode['modal-kegiatan']?.mode;
    const method = mode === 'edit' ? 'PUT' : 'POST';

    try {
      await apiRequest('../api/kegiatan.php', method, payload);
      showToast(mode === 'edit' ? 'Kegiatan berhasil diperbarui' : 'Kegiatan berhasil ditambahkan', 'success');
      closeModal('modal-kegiatan');
      loadKegiatan();
    } catch (err) {
      showToast('Gagal menyimpan: ' + err.message, 'error');
    }
  }

  async function editKegiatan(id) {
    try {
      const k = await apiRequest('../api/kegiatan.php?id=' + id);

      openModal('modal-kegiatan', 'edit', id);

      document.getElementById('kg-id').value = k.id || '';
      document.getElementById('kg-nama').value = k.nama || '';
      document.getElementById('kg-tanggal').value = k.tanggal || '';
      document.getElementById('kg-jam').value = k.jam ? k.jam.slice(0, 5) : '';
      document.getElementById('kg-kategori').value = k.kategori || '';
      document.getElementById('kg-tempat').value = k.tempat || '';
      document.getElementById('kg-deskripsi').value = k.deskripsi || '';

      document.getElementById('modal-kegiatan-label').textContent = 'Edit Data';
      document.getElementById('modal-kegiatan-title').textContent = 'Perbarui Kegiatan';
      document.getElementById('btn-submit-kegiatan').textContent = 'Simpan Perubahan';
    } catch (err) {
      showToast('Gagal memuat data: ' + err.message, 'error');
    }
  }

  function deleteKegiatan(id) {
    showConfirm('Hapus Kegiatan?', 'Data kegiatan ini akan dihapus permanen.', async () => {
      try {
        await apiRequest('../api/kegiatan.php', 'DELETE', { id });
        showToast('Kegiatan berhasil dihapus', 'success');
        loadKegiatan();
      } catch (err) {
        showToast('Gagal menghapus: ' + err.message, 'error');
      }
    });
  }

  window.submitKegiatan = submitKegiatan;
  window.editKegiatan = editKegiatan;
  window.deleteKegiatan = deleteKegiatan;

  loadKegiatan();
}

// ═══════════════════════════════════════════════════════════
//  BERITA
// ═══════════════════════════════════════════════════════════
if (PAGE === 'berita') {

  async function loadBerita() {
    const tbody = document.getElementById('berita-tbody');
    tbody.innerHTML = `<tr><td colspan="5" style="text-align:center;padding:40px;color:var(--text-light);font-family:'DM Mono',monospace;font-size:9px;letter-spacing:1px;">Memuat data...</td></tr>`;

    try {
      const rows = await apiRequest('../api/berita.php');
      renderBerita(rows);
    } catch (err) {
      tbody.innerHTML = `<tr><td colspan="5"><div class="empty-state"><div class="empty-icon">◉</div><div class="empty-text">Gagal memuat data: ${err.message}</div></div></td></tr>`;
    }
  }

  function renderBerita(rows) {
    const tbody = document.getElementById('berita-tbody');

    if (!rows.length) {
      tbody.innerHTML = `<tr><td colspan="5"><div class="empty-state"><div class="empty-icon">◉</div><div class="empty-text">Belum ada data berita</div></div></td></tr>`;
      return;
    }

    tbody.innerHTML = rows.map(b => `
      <tr data-kat="${(b.kategori || '').toLowerCase().trim()}">
        <td style="font-family:'DM Mono',monospace;font-size:8.5px;letter-spacing:1px;white-space:nowrap;">
          ${fmtDate(b.tanggal)}
        </td>
        <td style="max-width:380px;">
          <strong style="font-family:'Cormorant Garamond',serif;font-weight:400;font-size:15px;display:block;margin-bottom:3px;">
            ${b.judul}
          </strong>
          <span style="font-size:11.5px;color:var(--text-mid);">
            ${(b.snippet || '').length > 80 ? (b.snippet || '').substring(0, 80) + '…' : (b.snippet || '')}
          </span>
        </td>
        <td><span class="tag tag-tan">${b.kategori || '-'}</span></td>
        <td><span class="tag tag-green">Tayang</span></td>
        <td>
          <div class="td-actions">
            <button class="btn-icon" onclick="editBerita(${b.id})" title="Edit">✎</button>
            <button class="btn-icon del" onclick="deleteBerita(${b.id})" title="Hapus">⊗</button>
          </div>
        </td>
      </tr>
    `).join('');
  }

  function resetPreviewBerita() {
    const previewImg = document.getElementById('b-foto-preview');
    const previewCont = document.getElementById('container-preview-berita');

    if (previewImg) previewImg.src = '';
    if (previewCont) previewCont.style.display = 'none';
  }

  function showPreviewBerita(src) {
    const previewImg = document.getElementById('b-foto-preview');
    const previewCont = document.getElementById('container-preview-berita');

    if (previewImg && previewCont && src) {
      previewImg.src = src;
      previewCont.style.display = 'block';
    }
  }

  const beritaFileInput = document.getElementById('b-foto');
  if (beritaFileInput) {
    beritaFileInput.addEventListener('change', function () {
      const file = this.files[0];

      if (!file) {
        resetPreviewBerita();
        return;
      }

      const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
      if (!allowedTypes.includes(file.type)) {
        setErr('b-foto', 'e-b-foto', true);
        this.value = '';
        resetPreviewBerita();
        showToast('Format thumbnail harus JPG, PNG, atau WebP', 'error');
        return;
      }

      if (file.size > 2 * 1024 * 1024) {
        setErr('b-foto', 'e-b-foto', true);
        this.value = '';
        resetPreviewBerita();
        showToast('Ukuran thumbnail maksimal 2MB', 'error');
        return;
      }

      setErr('b-foto', 'e-b-foto', false);
      showPreviewBerita(URL.createObjectURL(file));
    });
  }

  async function submitBerita() {
    let valid = true;

    const judul = document.getElementById('b-judul').value.trim();
    const kategori = document.getElementById('b-kategori').value;
    const tanggal = document.getElementById('b-tanggal').value;
    const snippet = document.getElementById('b-snippet').value.trim();
    const isi = document.getElementById('b-isi').value.trim();
    const id = document.getElementById('b-id').value || '';
    const fileInput = document.getElementById('b-foto');
    const file = fileInput ? fileInput.files[0] : null;
    const mode = modalMode['modal-berita']?.mode;

    if (!judul || judul.length < 10 || judul.length > 200) {
      valid = setErr('b-judul', 'e-b-judul', true) && false;
    } else {
      setErr('b-judul', 'e-b-judul', false);
    }

    if (!kategori) {
      valid = setErr('b-kategori', 'e-b-kategori', true) && false;
    } else {
      setErr('b-kategori', 'e-b-kategori', false);
    }

    if (!tanggal) {
      valid = setErr('b-tanggal', 'e-b-tanggal', true) && false;
    } else {
      setErr('b-tanggal', 'e-b-tanggal', false);
    }

    if (!snippet || snippet.length < 20 || snippet.length > 300) {
      valid = setErr('b-snippet', 'e-b-snippet', true) && false;
    } else {
      setErr('b-snippet', 'e-b-snippet', false);
    }

    if (file) {
      const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
      if (!allowedTypes.includes(file.type) || file.size > 2 * 1024 * 1024) {
        valid = setErr('b-foto', 'e-b-foto', true) && false;
      } else {
        setErr('b-foto', 'e-b-foto', false);
      }
    } else {
      setErr('b-foto', 'e-b-foto', false);
    }

    if (!valid) {
      showToast('Periksa kembali isian formulir', 'error');
      return;
    }

    const formData = new FormData();
    formData.append('judul', judul);
    formData.append('kategori', kategori);
    formData.append('tanggal', tanggal);
    formData.append('snippet', snippet);
    formData.append('isi', isi);

    if (file) {
      formData.append('foto', file);
    }

    if (mode === 'edit') {
      formData.append('_method', 'PUT');
      formData.append('id', id);
    }

    try {
      const res = await fetch('../api/berita.php', {
        method: 'POST',
        body: formData
      });

      const result = await res.json();

      if (!res.ok || !result.success) {
        throw new Error(result.error || 'Gagal menyimpan data');
      }

      showToast(mode === 'edit' ? 'Berita berhasil diperbarui' : 'Berita berhasil ditambahkan', 'success');
      closeModal('modal-berita');
      clearForm('modal-berita');
      resetPreviewBerita();
      loadBerita();
    } catch (err) {
      showToast('Gagal menyimpan: ' + err.message, 'error');
    }
  }

  async function editBerita(id) {
    try {
      const b = await apiRequest('../api/berita.php?id=' + id);

      openModal('modal-berita', 'edit', id);

      document.getElementById('b-id').value = b.id || '';
      document.getElementById('b-judul').value = b.judul || '';
      document.getElementById('b-kategori').value = b.kategori || '';
      document.getElementById('b-tanggal').value = b.tanggal || '';
      document.getElementById('b-snippet').value = b.snippet || '';
      document.getElementById('b-isi').value = b.isi || '';

      // input file TIDAK BOLEH diisi otomatis
      document.getElementById('b-foto').value = '';

      if (b.foto) {
        const fotoUrl = String(b.foto).startsWith('uploads/')
          ? '../' + b.foto
          : '../uploads/berita/' + b.foto;
        showPreviewBerita(fotoUrl);
      } else {
        resetPreviewBerita();
      }

      document.getElementById('modal-berita-label').textContent = 'Edit Data';
      document.getElementById('modal-berita-title').textContent = 'Perbarui Berita';
      document.getElementById('btn-submit-berita').textContent = 'Simpan Perubahan';
    } catch (err) {
      showToast('Gagal memuat data: ' + err.message, 'error');
    }
  }

  function deleteBerita(id) {
    showConfirm('Hapus Berita?', 'Berita ini akan dihapus permanen.', async () => {
      try {
        await apiRequest('../api/berita.php', 'DELETE', { id });
        showToast('Berita berhasil dihapus', 'success');
        loadBerita();
      } catch (err) {
        showToast('Gagal menghapus: ' + err.message, 'error');
      }
    });
  }

  window.submitBerita = submitBerita;
  window.editBerita = editBerita;
  window.deleteBerita = deleteBerita;

  loadBerita();
}

// ─── SIDEBAR TOGGLE ───
function initSidebarToggle() {
  try {
    const menuToggle = document.getElementById('admin-menu-toggle');
    const backdrop   = document.getElementById('admin-sidebar-backdrop');

    window.openAdminSidebar  = function() { 
      document.body.classList.add('admin-sidebar-open');
      localStorage.setItem('adminSidebar','open');
    };
    window.closeAdminSidebar = function() { 
      document.body.classList.remove('admin-sidebar-open'); 
      localStorage.setItem('adminSidebar','closed'); 
    };
    window.toggleAdminSidebar = function() { 
      document.body.classList.contains('admin-sidebar-open') ? 
        window.closeAdminSidebar() : 
        window.openAdminSidebar(); 
    };

    // Restore sidebar state on page load
    const savedState = localStorage.getItem('adminSidebar');
    if (savedState === 'open') {
      document.body.classList.add('admin-sidebar-open');
    }

    // Event listeners
    if (menuToggle) {
      menuToggle.addEventListener('click', window.toggleAdminSidebar);
    }
    
    // Backdrop should only close sidebar, not toggle
    if (backdrop) {
      backdrop.addEventListener('click', window.closeAdminSidebar);
    }

    // ─── LOGOUT ───
    const btnLogout = document.querySelector('.btn-logout');
    if (btnLogout) {
      btnLogout.addEventListener('click', () => { 
        window.location.href = '../proses/logout.php'; 
      });
    }

    // ─── DATE (dashboard) ───
    const elDate = document.getElementById('current-date');
    if (elDate) {
      elDate.textContent = new Date().toLocaleDateString('id-ID',{
        weekday:'long', year:'numeric', month:'long', day:'numeric'
      }).toUpperCase();
    }
  } catch (err) {
    console.error('Error initializing sidebar:', err);
  }
}

// Initialize when DOM is ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initSidebarToggle);
} else {
  initSidebarToggle();
}

// ═══════════════════════════════════════════════════════════
//  PEMINJAMAN
// ═══════════════════════════════════════════════════════════
if (PAGE === 'peminjaman') {

  let peminjamanFilter = 'semua';

  async function loadPeminjaman() {
    const grid = document.getElementById('peminjaman-grid');
    grid.innerHTML = `<div style="grid-column:1/-1;padding:60px;text-align:center;color:var(--text-light);font-family:'DM Mono',monospace;font-size:9px;letter-spacing:1px;">Memuat data...</div>`;
    try {
      const url = peminjamanFilter !== 'semua'
        ? '../api/peminjaman.php?status=' + peminjamanFilter
        : '../api/peminjaman.php';
      const rows = await apiRequest(url);
      renderPeminjaman(rows);
    } catch (err) {
      grid.innerHTML = `<div style="grid-column:1/-1;padding:60px;text-align:center;color:var(--text-light);font-family:'DM Mono',monospace;font-size:9px;letter-spacing:1px;">Gagal memuat data: ${err.message}</div>`;
    }
  }

  function renderPeminjaman(rows) {
    const grid = document.getElementById('peminjaman-grid');
    if (!rows.length) {
      grid.innerHTML = `<div style="grid-column:1/-1;padding:60px;text-align:center;">
        <div class="empty-icon" style="font-size:32px;opacity:0.3;margin-bottom:10px;">◎</div>
        <div style="font-family:'DM Mono',monospace;font-size:9px;letter-spacing:1.26px;text-transform:uppercase;color:var(--text-light);">
          Tidak ada permohonan${peminjamanFilter !== 'semua' ? ' · '+peminjamanFilter : ''}
        </div>
      </div>`;
      return;
    }
    grid.innerHTML = rows.map(p => `
      <div class="peminj-card">
        <div class="peminj-header">
          <div>
            <div class="peminj-name">${p.nama}</div>
            <div class="peminj-org">${p.organisasi}</div>
          </div>
          ${statusTag(p.status)}
        </div>
        <div class="peminj-meta">
          <strong>Ruang:</strong> ${p.ruang}<br>
          <strong>Tanggal:</strong> ${fmtDate(p.tanggal)} · ${p.durasi}<br>
          <strong>Kegiatan:</strong> ${p.kegiatan}<br>
          <strong>Peserta:</strong> ±${p.peserta} orang<br>
          <strong>Kontak:</strong> ${p.kontak} · ${p.email}
          ${p.deskripsi ? `<br><em style="color:var(--text-light);font-size:11.5px;">${p.deskripsi}</em>` : ''}
        </div>
        <div class="peminj-actions">
          ${p.status === 'pending' ? `
            <button class="btn btn-outline btn-sm" onclick="setStatusPeminj(${p.id},'disetujui')">✓ Setujui</button>
            <button class="btn btn-danger btn-sm"  onclick="setStatusPeminj(${p.id},'ditolak')">✕ Tolak</button>
          ` : `
            <button class="btn btn-outline btn-sm" onclick="setStatusPeminj(${p.id},'pending')">↩ Reset</button>
          `}
          <button class="btn-icon del" onclick="deletePeminj(${p.id})" title="Hapus">⊗</button>
        </div>
      </div>
    `).join('');
  }

  async function setStatusPeminj(id, status) {
    try {
      await apiRequest('../api/peminjaman.php','PUT',{id,status});
      const msg = { disetujui:'Permohonan disetujui', ditolak:'Permohonan ditolak', pending:'Status direset' };
      const typ = { disetujui:'success', ditolak:'error', pending:'warning' };
      showToast(msg[status], typ[status]);
      loadPeminjaman();
    } catch (err) { showToast('Gagal mengubah status: '+err.message,'error'); }
  }

  function deletePeminj(id) {
    showConfirm('Hapus Permohonan?','Data permohonan ini akan dihapus permanen.', async () => {
      try {
        await apiRequest('../api/peminjaman.php','DELETE',{id});
        showToast('Permohonan berhasil dihapus','success');
        loadPeminjaman();
      } catch (err) { showToast('Gagal menghapus: '+err.message,'error'); }
    });
  }

  function filterPeminj(f, el) {
    peminjamanFilter = f;
    document.querySelectorAll('#sec-peminjaman .filter-tab').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
    loadPeminjaman();
  }

  window.setStatusPeminj = setStatusPeminj;
  window.deletePeminj    = deletePeminj;
  window.filterPeminj    = filterPeminj;

  loadPeminjaman();
}