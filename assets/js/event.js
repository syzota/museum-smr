// ════════════════════════════════════════════════
// EVENT PAGE: Fetch & Display Events (Read Only)
// ════════════════════════════════════════════════

document.addEventListener('DOMContentLoaded', () => {
  const container = document.getElementById('event-list-container');
  if (!container) return;

  // Helper: Format tanggal "2025-03-22" → {dd: "22", mm: "Mar", yyyy: "2025"}
  function formatDate(dateStr) {
    if (!dateStr) return { dd: '--', mm: '---', yyyy: '----' };
    const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    const [y, m, d] = dateStr.split('-');
    return {
      dd: d,
      mm: months[parseInt(m, 10) - 1] || '---',
      yyyy: y
    };
  }

  // Helper: Membuat HTML untuk satu item event (sesuai CSS kamu)
  function createEventHTML(evt) {
    const date = formatDate(evt.tanggal);
    
    // Logika badge sederhana
    let badge = '';
    if (evt.status === 'Penuh') {
      badge = '<span class="efi-tag full">Kuota Penuh</span>';
    } else if (['Pameran', 'Diskusi', 'Edukasi'].includes(evt.kategori)) {
      badge = '<span class="efi-tag">Terbuka Umum</span>';
    }

    return `
      <div class="event-full-item">
        <div class="efi-date">
          <div class="efi-dd">${date.dd}</div>
          <div class="efi-mm">${date.mm}</div>
          <div class="efi-yr">${date.yyyy}</div>
        </div>
        <div class="efi-div"></div>
        <div class="efi-content">
          <div class="efi-cat">${evt.kategori || 'Umum'}</div>
          <div class="efi-title">${evt.nama}</div>
          <div class="efi-meta">${evt.tempat || '-'} · ${evt.jam || '-'} · ${evt.status || 'Gratis'}</div>
          <div class="efi-desc">${evt.deskripsi || '-'}</div>
          ${badge}
        </div>
      </div>
    `;
  }

  // Fungsi utama: Fetch data dari API
  async function loadEvents() {
    // Tampilkan loading state
    container.innerHTML = '<div style="padding:40px;text-align:center;font-family:var(--mono);font-size:11px;color:var(--sepia);">Memuat agenda...</div>';

    try {
      // Panggil API (pastikan path ini benar relatif terhadap event.php)
      const res = await fetch('api/kegiatan.php');
      
      if (!res.ok) throw new Error(`Gagal mengambil data: ${res.status}`);
      
      const events = await res.json();

      // Jika data kosong
      if (!events || events.length === 0) {
        container.innerHTML = '<div style="padding:40px;text-align:center;font-family:var(--alt-serif);color:var(--sepia);">Belum ada agenda event.</div>';
        return;
      }

      // Render semua event ke dalam container
      // Kita join array string HTML menjadi satu blok besar lalu insert ke innerHTML
      container.innerHTML = events.map(createEventHTML).join('');

    } catch (err) {
      console.error('Error loading events:', err);
      container.innerHTML = `<div style="padding:40px;text-align:center;color:var(--rust);">Gagal memuat data.<br><small style="font-family:var(--mono)">${err.message}</small></div>`;
    }
  }

  // Jalankan fungsi load
  loadEvents();
});