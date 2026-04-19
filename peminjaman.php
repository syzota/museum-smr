<?php
require_once __DIR__ . '/config/auth.php';

// Inject status login untuk dipakai JS
$isLoggedIn = isLoggedIn();
$user = currentUser();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Museum Kota Samarinda</title>
<link rel="icon" type="image/png" href="assets/logo.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=DM+Mono:wght@300;400&family=Spectral:ital,wght@0,200;0,300;0,400;1,200;1,300&display=swap" rel="stylesheet">

<link rel="stylesheet" href="assets/css/beranda.css">
<link rel="stylesheet" href="assets/css/peminjaman.css">

</head>
<body>

<!-- Inject login state supaya JS bisa cek -->
<script>
  const USER_LOGGED_IN = <?= $isLoggedIn ? 'true' : 'false' ?>;
  const USER_NAME      = <?= $isLoggedIn ? json_encode($user['nama']) : 'null' ?>;
</script>

<?php require_once __DIR__ . '/templates/global/topbar.php'; ?>
<?php require_once __DIR__ . '/templates/global/sidebar.php'; ?>

<!-- ─── MASTHEAD ─── -->
<header class="masthead">
  <div class="container">
    <div class="masthead-inner">
      <div class="masthead-left">
        <span class="label">Est. 2003 · Samarinda</span>
        <span style="font-family:var(--alt-serif);font-size:12.5px;font-weight:300;color:#ffffff;margin-top:2px;">Kalimantan Timur, Indonesia</span>
      </div>
      <div class="masthead-center">
        <div class="museum-name" onclick="location.href='home.php'" style="cursor:pointer;">
          Museum <em>Kota</em><br>Samarinda
        </div>
        <div class="museum-sub">Arsip Sejarah &amp; Kebudayaan</div>
      </div>
      <div class="masthead-right">
        <div class="search-form">
          <input class="search-input" type="text" placeholder="Cari koleksi…">
          <button class="search-btn">⌕</button>
        </div>
        <span style="font-family:var(--alt-serif);font-size:12px;font-weight:300;color:#ffffff;">Jl. Bhayangkara No.1, Samarinda</span>
      </div>
    </div>
  </div>
</header>

<!-- ─── NAVBAR ─── -->
<nav class="navbar">
  <div class="container">
    <div class="navbar-inner">
      <button class="nav-item" onclick="location.href='home.php'">Beranda</button>
      <button class="nav-item" onclick="location.href='tentang.php'">Tentang Museum</button>
      <button class="nav-item" onclick="location.href='koleksi.php'">Koleksi</button>
      <button class="nav-item" onclick="location.href='event.php'">Event &amp; Kegiatan</button>
      <button class="nav-item" onclick="location.href='berita.php'">Berita</button>
      <button class="nav-item" onclick="location.href='peta.php'">Peta Lokasi</button>
      <button class="nav-item active">Peminjaman Ruang</button>
      <button class="nav-item" onclick="location.href='ulasan.php'">Ulasan</button>
    </div>
  </div>
</nav>

  <div class="ticker">
    <div class="ticker-inner">
      <div class="ticker-item"><span style="color:var(--sepia-lt)">✦</span> Pameran Baru: Warisan Dayak Kalimantan Timur</div>
      <div class="ticker-item"><span style="color:var(--sepia-lt)">✦</span> Event: Diskusi Sejarah Samarinda · 22 Maret 2025</div>
      <div class="ticker-item"><span style="color:var(--sepia-lt)">✦</span> Koleksi Baru: Naskah Kuno Abad ke-17</div>
      <div class="ticker-item"><span style="color:var(--sepia-lt)">✦</span> Ruang Seminar Tersedia untuk Peminjaman</div>
      <div class="ticker-item"><span style="color:var(--sepia-lt)">✦</span> Jam Operasional: Selasa–Minggu, 08:00–16:00 WIB</div>
      <div class="ticker-item"><span style="color:var(--sepia-lt)">✦</span> Pameran Baru: Warisan Dayak Kalimantan Timur</div>
      <div class="ticker-item"><span style="color:var(--sepia-lt)">✦</span> Event: Diskusi Sejarah Samarinda · 22 Maret 2025</div>
      <div class="ticker-item"><span style="color:var(--sepia-lt)">✦</span> Koleksi Baru: Naskah Kuno Abad ke-17</div>
      <div class="ticker-item"><span style="color:var(--sepia-lt)">✦</span> Ruang Seminar Tersedia untuk Peminjaman</div>
      <div class="ticker-item"><span style="color:var(--sepia-lt)">✦</span> Jam Operasional: Selasa–Minggu, 08:00–16:00 WIB</div>
    </div>
  </div>

<div id="page-peminjaman" class="page active">

  <!-- Banner -->
  <div class="page-banner">
    <div class="container">
      <div class="page-banner-inner">
        <div>
          <div class="page-banner-breadcrumb">Museum Kota Samarinda / Peminjaman Ruang</div>
          <h1 class="page-banner-title">Peminjaman <em>Ruang</em></h1>
          <p class="page-banner-desc">Selenggarakan acara Anda di museum bersejarah kota Samarinda. Tersedia ruang terbuka untuk kegiatan budaya, pendidikan, dan korporat.</p>
        </div>
        <div style="display:flex;flex-direction:column;gap:10px;align-items:flex-end;">
          <a href="#peminjaman-form" class="btn-primary">Ajukan Sekarang ↓</a>
          <a href="peta.php" class="btn-ghost">Lihat Lokasi</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Info Band -->
  <div class="info-band">
    <div class="container">
      <div class="info-band-inner">
        <div class="info-band-col">
          <div class="ib-label">Jam Operasional</div>
          <div class="ib-val">Senin – Jumat</div>
          <div class="ib-val large">08:00 – 16:00</div>
        </div>
        <div class="info-band-div"></div>
        <div class="info-band-col">
          <div class="ib-label">Kapasitas Maksimal</div>
          <div class="ib-val">Ruang Terbuka</div>
          <div class="ib-val large">250 Orang</div>
        </div>
        <div class="info-band-div"></div>
        <div class="info-band-col">
          <div class="ib-label">Konfirmasi Via</div>
          <div class="ib-val">WhatsApp Museum</div>
          <div class="ib-val large">0812-5533-4435</div>
        </div>
        <div class="info-band-div"></div>
        <div class="info-band-col">
          <div class="ib-label">Minimum Booking</div>
          <div class="ib-val">H-7 sebelum acara</div>
          <div class="ib-val large">7 Hari</div>
        </div>
      </div>
    </div>
  </div>

  <section class="section">
    <div class="container">

      <!-- Kalender -->
      <div class="section-header">
        <div>
          <div class="label" style="color:var(--sepia-lt);margin-bottom:8px;">Jadwal Ruang</div>
          <h2 class="section-title">Kalender <em>Ketersediaan</em></h2>
        </div>
      </div>

      <div class="calendar-wrap">
        <div class="calendar-head">
          <div class="calendar-title" id="cal-month-title">April 2026</div>
          <div class="calendar-controls">
            <button class="cal-btn" id="cal-prev">← Sebelumnya</button>
            <button class="cal-btn" id="cal-today-btn">Bulan Ini</button>
            <button class="cal-btn" id="cal-next">Berikutnya →</button>
          </div>
        </div>
        <div class="calendar-grid" id="calendar-grid"></div>
        <div class="cal-legend">
          <div class="cal-legend-item"><span class="cal-swatch available"></span>Tersedia</div>
          <div class="cal-legend-item"><span class="cal-swatch booked"></span>Sudah Dipesan</div>
          <div class="cal-legend-item"><span class="cal-swatch hold"></span>Hold / Tinjau</div>
          <div class="cal-legend-item"><span class="cal-swatch cancelled"></span>Dibatalkan</div>
        </div>
      </div>

      <!-- Form Peminjaman -->
      <div class="form-section" id="peminjaman-form">
        <div class="form-header">
          <div class="label" style="color:var(--sepia-lt);margin-bottom:8px;">Pengajuan Resmi</div>
          <div class="form-title">Formulir <em>Peminjaman Ruang</em></div>
        </div>

        <?php if (!$isLoggedIn): ?>
        <!-- Banner login — tampil jika belum login -->
        <div id="login-required-banner" style="
          background:rgba(192,96,96,0.08);
          border:1px solid rgba(192,96,96,0.3);
          border-radius:6px;
          padding:20px 24px;
          margin-bottom:28px;
          display:flex;
          align-items:center;
          gap:16px;
        ">
          <div style="font-size:22px;opacity:0.6;">⚠</div>
          <div>
            <div style="font-family:'DM Mono',monospace;font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:#c06060;margin-bottom:4px;">Login Diperlukan</div>
            <div style="font-family:'Spectral',serif;font-size:14px;color:var(--text-mid,#555);line-height:1.6;">
              Anda harus <strong><a href="login.php?redirect=peminjaman.php" style="color:var(--sepia,#8b6f4e);text-decoration:underline;">masuk</a></strong> terlebih dahulu untuk mengajukan peminjaman ruang.
              Belum punya akun? <a href="signup.php" style="color:var(--sepia,#8b6f4e);text-decoration:underline;">Daftar di sini</a>.
            </div>
          </div>
        </div>
        <?php endif; ?>

        <div class="form-body" id="form-body-wrap">
          <div class="form-group">
            <label class="form-label" for="f-nama">Nama Lengkap / Pemohon <span class="req">*</span></label>
            <input type="text" class="form-input" id="f-nama" placeholder="Nama pemohon perorangan atau perwakilan" autocomplete="name" maxlength="100" <?= !$isLoggedIn ? 'disabled' : '' ?>>
            <span class="field-error" id="e-nama">Nama tidak boleh kosong</span>
          </div>
          <div class="form-group">
            <label class="form-label" for="f-instansi">Instansi / Organisasi <span class="req">*</span></label>
            <input type="text" class="form-input" id="f-instansi" placeholder="Nama instansi, sekolah, atau organisasi" autocomplete="organization" maxlength="100" <?= !$isLoggedIn ? 'disabled' : '' ?>>
            <span class="field-error" id="e-instansi">Instansi tidak boleh kosong</span>
          </div>
          <div class="form-group">
            <label class="form-label" for="f-telp">Nomor Telepon / WhatsApp <span class="req">*</span></label>
            <input type="tel" class="form-input" id="f-telp" placeholder="Contoh: 0812-5533-4435" autocomplete="tel" maxlength="20" <?= !$isLoggedIn ? 'disabled' : '' ?>>
            <span class="field-error" id="e-telp">Format tidak valid — gunakan angka, +, atau tanda hubung (7–20 karakter)</span>
          </div>
          <div class="form-group">
            <label class="form-label" for="f-email">Alamat Email <span class="req">*</span></label>
            <input type="email" class="form-input" id="f-email" placeholder="email@domain.com" autocomplete="email" maxlength="100" <?= !$isLoggedIn ? 'disabled' : '' ?>>
            <span class="field-error" id="e-email">Format email tidak valid</span>
          </div>
          <div class="form-group">
            <label class="form-label" for="f-tanggal">Tanggal Pelaksanaan <span class="req">*</span></label>
            <input type="date" class="form-input" id="f-tanggal" <?= !$isLoggedIn ? 'disabled' : '' ?>>
            <span class="field-hint" style="font-size:11px;color:var(--text-light,#999);margin-top:4px;display:block;">Minimal H+7 dari hari ini</span>
            <span class="field-error" id="e-tanggal">Tanggal tidak boleh kosong</span>
          </div>
          <div class="form-group">
            <label class="form-label" for="f-durasi">Durasi <span class="req">*</span></label>
            <select class="form-select" id="f-durasi" <?= !$isLoggedIn ? 'disabled' : '' ?>>
              <option value="">— Pilih Durasi —</option>
              <option>½ Hari (Pagi: 08:00–12:00)</option>
              <option>½ Hari (Sore: 13:00–17:00)</option>
              <option>1 Hari Penuh (08:00–17:00)</option>
              <option>2–3 Hari</option>
              <option>1 Minggu</option>
            </select>
            <span class="field-error" id="e-durasi">Pilih durasi penggunaan</span>
          </div>
          <div class="form-group">
            <label class="form-label" for="f-jenis">Jenis Kegiatan <span class="req">*</span></label>
            <select class="form-select" id="f-jenis" <?= !$isLoggedIn ? 'disabled' : '' ?>>
              <option value="">— Pilih Jenis Kegiatan —</option>
              <option>Seminar / Konferensi</option>
              <option>Workshop / Pelatihan</option>
              <option>Pameran Seni / Budaya</option>
              <option>Acara Korporat</option>
              <option>Penelitian / Akademik</option>
              <option>Lainnya</option>
            </select>
            <span class="field-error" id="e-jenis">Pilih jenis kegiatan</span>
          </div>
          <div class="form-group">
            <label class="form-label" for="f-peserta">Perkiraan Jumlah Peserta <span class="req">*</span></label>
            <input type="number" class="form-input" id="f-peserta" placeholder="Jumlah orang" min="1" max="250" <?= !$isLoggedIn ? 'disabled' : '' ?>>
            <span class="field-hint" style="font-size:11px;color:var(--text-light,#999);margin-top:4px;display:block;">Maks. 250 orang (kapasitas Ruang Terbuka)</span>
            <span class="field-error" id="e-peserta">Masukkan jumlah peserta (1–250 orang)</span>
          </div>
          <!-- Ruang hanya satu pilihan -->
          <div class="form-group">
            <label class="form-label" for="f-ruang">Ruang yang Dipinjam</label>
            <input type="text" class="form-input" id="f-ruang" value="Ruang Terbuka" readonly style="background:var(--bg-muted,#f5f4f0);cursor:default;color:var(--text-mid,#555);">
          </div>
          <div class="form-group form-full">
            <label class="form-label" for="f-deskripsi">Deskripsi Kegiatan <span class="req">*</span></label>
            <textarea class="form-textarea" id="f-deskripsi" placeholder="Jelaskan tujuan, program, dan kebutuhan khusus kegiatan Anda…" <?= !$isLoggedIn ? 'disabled' : '' ?>></textarea>
            <span class="field-error" id="e-deskripsi">Deskripsi kegiatan wajib diisi</span>
          </div>
        </div>

        <div class="form-footer">
          <?php if ($isLoggedIn): ?>
            <button class="btn-primary" id="btn-kirim">Pratinjau &amp; Kirim Permohonan →</button>
          <?php else: ?>
            <a href="login.php?redirect=peminjaman.php%23peminjaman-form" class="btn-primary" style="display:inline-block;text-decoration:none;">Masuk untuk Mengajukan →</a>
          <?php endif; ?>
          <p class="form-note">Semua kolom bertanda <span style="color:#c06060;">*</span> wajib diisi. Permohonan akan dikonfirmasi via WhatsApp.</p>
        </div>
      </div>

    </div>
  </section>
</div>

<!-- ─── FOOTER ─── -->
<footer class="footer">
  <div class="container">
    <div class="footer-grid">
      <div>
        <div class="footer-name">Museum <em>Kota</em><br>Samarinda</div>
        <div class="footer-addr">Jl. Bhayangkara No.1<br>Samarinda 75121<br>Kalimantan Timur, Indonesia<br><br>WhatsApp: 0812-5533-4435<br><br>© 2025 Museum Kota Samarinda</div>
      </div>
      <div>
        <div class="footer-col-title">Navigasi</div>
        <div class="footer-links">
          <button class="footer-link" onclick="location.href='home.php'">Beranda</button>
          <button class="footer-link" onclick="location.href='tentang.php'">Tentang Museum</button>
          <button class="footer-link" onclick="location.href='koleksi.php'">Koleksi Digital</button>
          <button class="footer-link" onclick="location.href='event.php'">Event &amp; Kegiatan</button>
          <button class="footer-link" onclick="location.href='berita.php'">Berita</button>
        </div>
      </div>
      <div>
        <div class="footer-col-title">Layanan</div>
        <div class="footer-links">
          <button class="footer-link" onclick="location.href='peminjaman.php'">Peminjaman Ruang</button>
          <button class="footer-link" onclick="location.href='event.php'">Program Edukasi</button>
          <button class="footer-link" onclick="location.href='peta.php'">Peta Lokasi</button>
          <button class="footer-link" onclick="location.href='ulasan.php'">Tulis Ulasan</button>
        </div>
      </div>
      <div>
        <div class="footer-col-title">Akun</div>
        <div class="footer-links">
          <?php if ($isLoggedIn): ?>
            <span class="footer-link" style="cursor:default;opacity:0.6;">👤 <?= htmlspecialchars($user['nama']) ?></span>
            <button class="footer-link" onclick="location.href='proses/logout.php'">Keluar</button>
          <?php else: ?>
            <button class="footer-link" onclick="location.href='login.php'">Masuk</button>
            <button class="footer-link" onclick="location.href='signup.php'">Daftar</button>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <span class="footer-copy">Museum Kota Samarinda · Dinas Kebudayaan Kota Samarinda</span>
      <span class="footer-copy">Dirancang untuk menjaga ingatan kota</span>
    </div>
  </div>
</footer>

<!-- MODAL STEP 1 — PRATINJAU -->
<div class="modal-overlay" id="modal-step1" role="dialog" aria-modal="true">
  <div class="modal-invoice">
    <div class="modal-inv-head">
      <div>
        <div class="modal-inv-eyebrow">Museum Kota Samarinda · Peminjaman Ruang</div>
        <div class="modal-inv-title">Pratinjau <em>Permohonan</em></div>
        <div class="modal-inv-num" id="inv-nomor">REF / — / —</div>
      </div>
      <button class="modal-close-btn" id="modal-step1-close">✕</button>
    </div>
    <div class="modal-inv-strip">
      <span class="modal-inv-strip-label">Harap periksa kembali data sebelum mengirim</span>
      <span class="modal-inv-status">Menunggu Konfirmasi</span>
    </div>
    <div class="modal-inv-body">
      <div class="inv-section-title">Data Pemohon</div>
      <div class="inv-row"><span class="inv-key">Nama Pemohon</span><span class="inv-val" id="inv-nama">—</span></div>
      <div class="inv-row"><span class="inv-key">Instansi / Organisasi</span><span class="inv-val" id="inv-instansi">—</span></div>
      <div class="inv-row"><span class="inv-key">Nomor Telepon</span><span class="inv-val" id="inv-telp">—</span></div>
      <div class="inv-row"><span class="inv-key">Alamat Email</span><span class="inv-val" id="inv-email">—</span></div>
      <div class="inv-section-title">Detail Kegiatan</div>
      <div class="inv-row"><span class="inv-key">Tanggal Pelaksanaan</span><span class="inv-val" id="inv-tanggal">—</span></div>
      <div class="inv-row"><span class="inv-key">Durasi</span><span class="inv-val" id="inv-durasi">—</span></div>
      <div class="inv-row"><span class="inv-key">Jenis Kegiatan</span><span class="inv-val" id="inv-jenis">—</span></div>
      <div class="inv-row"><span class="inv-key">Ruang</span><span class="inv-val" id="inv-ruang">Ruang Terbuka</span></div>
      <div class="inv-row"><span class="inv-key">Jumlah Peserta</span><span class="inv-val" id="inv-peserta">—</span></div>
      <div class="inv-row"><span class="inv-key">Deskripsi</span><span class="inv-val" id="inv-deskripsi">—</span></div>
    </div>
    <div class="modal-inv-warning">
      <div class="inv-warn-icon">!</div>
      <div class="inv-warn-text">
        <strong>Perhatian Penting</strong>
        Setelah mengirim permohonan, Anda <strong style="font-family:var(--alt-serif);display:inline;font-weight:500;">wajib</strong> menghubungi pihak museum melalui WhatsApp untuk konfirmasi. Permohonan yang tidak dikonfirmasi dalam <strong style="font-family:var(--alt-serif);display:inline;font-weight:500;">1×24 jam</strong> tidak akan diproses.
      </div>
    </div>
    <div class="modal-inv-footer">
      <div class="modal-inv-footer-note">Data ini akan diteruskan ke tim museum.<br>Pastikan semua informasi sudah benar.</div>
      <div class="modal-inv-actions">
        <button class="btn-modal-cancel" id="btn-step1-cancel">← Kembali &amp; Edit</button>
        <button class="btn-modal-confirm" id="btn-step1-confirm">Konfirmasi &amp; Kirim</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL STEP 2 — SUKSES & WA -->
<div class="modal-overlay" id="modal-step2" role="dialog" aria-modal="true">
  <div class="modal-wa">
    <div class="modal-wa-head">
      <div class="modal-wa-icon">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none"><polyline points="20 6 9 17 4 12" stroke="rgba(244,247,255,0.9)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </div>
      <div class="modal-wa-title">Permohonan <em>Terkirim</em></div>
      <div class="modal-wa-sub">Langkah selanjutnya diperlukan</div>
    </div>
    <div class="modal-wa-body">
      <p class="modal-wa-msg">Permohonan Anda telah kami catat dengan nomor referensi <strong id="wa-nomor-ref">—</strong>. Segera hubungi museum via WhatsApp untuk konfirmasi.</p>
      <div class="modal-wa-ref">
        <div class="modal-wa-ref-label">Nomor Referensi Permohonan</div>
        <div class="modal-wa-ref-num" id="wa-ref-display">—</div>
      </div>
      <div class="modal-wa-steps">
        <div class="modal-wa-step"><div class="step-num">1</div><div class="step-text">Klik tombol WhatsApp di bawah — pesan sudah terisi otomatis dengan data permohonan Anda.</div></div>
        <div class="modal-wa-step"><div class="step-num">2</div><div class="step-text">Kirim pesan kepada staf museum dan tunggu konfirmasi ketersediaan ruang.</div></div>
        <div class="modal-wa-step"><div class="step-num">3</div><div class="step-text"><strong>Batas waktu:</strong> Konfirmasi WhatsApp wajib dilakukan dalam 1×24 jam. Lewat batas waktu, permohonan dianggap batal.</div></div>
      </div>
      <a class="btn-whatsapp" id="btn-wa-link" href="#" target="_blank" rel="noopener noreferrer">
        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
        Hubungi Museum via WhatsApp
      </a>
      <button class="btn-wa-done" id="btn-wa-done">Tutup &amp; kembali ke halaman</button>
    </div>
    <div class="modal-wa-footer">
      <div class="modal-wa-footer-note">
        Museum Kota Samarinda · Jl. Bhayangkara No.1 · Samarinda<br>
        WhatsApp: 0812-5533-4435 · Jam operasional: Senin–Jumat, 08:00–16:00 WITA
      </div>
    </div>
  </div>
</div>

<script src="assets/js/peminjaman.js"></script>
<script src="assets/js/beranda.js"></script>
<script src="assets/js/scroll-fade-in.js"></script>
</body>
</html>