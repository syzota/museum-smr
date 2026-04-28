<?php
/**
 * signup.php — Halaman Daftar Akun
 * Museum Kota Samarinda
 */

require_once __DIR__ . '/config/auth.php';

// Jika sudah login, tidak perlu daftar
if (isLoggedIn()) {
    header('Location: home.php');
    exit;
}

// Ambil flash messages & nilai form yang disimpan session
$flashError   = $_SESSION['flash_error']   ?? '';
$flashSuccess = $_SESSION['flash_success'] ?? '';
$formNama     = $_SESSION['form_nama']      ?? '';
$formEmail    = $_SESSION['form_email']     ?? '';
$formPekerjaan= $_SESSION['form_pekerjaan'] ?? '';
unset(
    $_SESSION['flash_error'], $_SESSION['flash_success'],
    $_SESSION['form_nama'], $_SESSION['form_email'], $_SESSION['form_pekerjaan']
);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Daftar - Museum Kota Samarinda</title>
<link rel="icon" type="image/png" href="assets/logo.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=DM+Mono:wght@300;400&family=Spectral:ital,wght@0,200;0,300;0,400;1,200;1,300&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/auth.css">
<link rel="stylesheet" href="assets/css/beranda.css">

</head>
<body>

<?php require_once __DIR__ . '/templates/global/topbar.php'; ?>
<?php require_once __DIR__ . '/templates/global/sidebar.php'; ?>

<!-- MASTHEAD -->
<header class="masthead">
  <div class="container">
    <div class="masthead-inner">
      <div class="masthead-left">
        <span style="font-family:var(--mono);font-size:9px;letter-spacing:0.18em;text-transform:uppercase;color:rgba(255,255,255,0.7);">Est. 2003 · Samarinda</span>
        <span style="font-family:var(--alt-serif);font-size:12.5px;font-weight:300;color:rgba(244,237,229,0.75);margin-top:2px;">Kalimantan Timur, Indonesia</span>
      </div>

      <div class="masthead-center">
        <div class="museum-name" onclick="location.href='home.php'">Museum <em>Kota</em><br>Samarinda</div>
        <div class="museum-sub">Arsip Sejarah &amp; Kebudayaan</div>
      </div>

      <div class="masthead-right">
        <form class="search-form" action="koleksi.php" method="GET">
          <input
            class="search-input"
            type="text"
            name="q"
            placeholder="Cari koleksi…"
            value="<?= htmlspecialchars($_GET['q'] ?? '') ?>"
          >
          <button class="search-btn" type="submit">⌕</button>
        </form>

        <span style="font-family:var(--alt-serif);font-size:12px;font-weight:300;color:rgba(244,237,229,0.65);">Jl. Bhayangkara No.1, Samarinda</span>
      </div>
    </div>
  </div>
</header>

<!-- NAVBAR -->
<nav class="navbar">
  <div class="container">
    <div class="navbar-inner">
      <button class="nav-item" onclick="location.href='home.php'">Beranda</button>
      <button class="nav-item" onclick="location.href='tentang.php'">Tentang Museum</button>
      <button class="nav-item" onclick="location.href='koleksi.php'">Koleksi</button>
      <button class="nav-item" onclick="location.href='event.php'">Event & Kegiatan</button>
      <button class="nav-item" onclick="location.href='berita.php'">Berita</button>
      <button class="nav-item" onclick="location.href='peta.php'">Peta Lokasi</button>
      <button class="nav-item" onclick="location.href='peminjaman.php'">Peminjaman Ruang</button>
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

<!-- PAGE BANNER -->
<div class="page-banner">
  <div class="container">
    <div class="page-banner-inner">
      <div>
        <div class="page-banner-breadcrumb">Museum Kota Samarinda / Daftar</div>
        <h1 class="page-banner-title">Daftar <em>Akun</em></h1>
        <p class="page-banner-desc">Buat akun untuk mengakses fitur peminjaman ruang, ulasan, dan informasi kegiatan museum.</p>
      </div>
    </div>
  </div>
</div>

<!-- AUTH SECTION -->
<section class="section">
  <div class="container">
    <div class="auth-shell">
      <div class="auth-panel">
        <div class="panel-tag"><span></span>Portal Pengunjung</div>
        <div class="auth-title">Bergabung dengan komunitas museum.</div>
        <div class="auth-text">Daftarkan akun untuk mengajukan peminjaman ruang, memberikan ulasan, dan mendapatkan pembaruan kegiatan museum secara langsung.</div>
        <div class="auth-quote">"Setiap pengunjung adalah bagian dari cerita museum yang terus berkembang."</div>
      </div>

      <div class="auth-card">
        <div class="auth-meta">Daftar</div>
        <h2>Buat akun baru</h2>

        <!-- Flash Messages -->
        <?php if ($flashError): ?>
          <div class="auth-alert auth-alert--error">
            <?= htmlspecialchars($flashError) ?>
          </div>
        <?php endif; ?>
        <?php if ($flashSuccess): ?>
          <div class="auth-alert auth-alert--success">
            <?= htmlspecialchars($flashSuccess) ?>
          </div>
        <?php endif; ?>

        <!-- FORM DAFTAR — action ke proses/signup_proses.php via POST -->
        <form method="POST" action="proses/signup_proses.php" novalidate>

          <div class="form-group" style="margin-bottom: 18px;">
            <label class="form-label" for="nama" style="display: block; margin-bottom: 6px;">Nama Lengkap</label>
            <input type="text" id="nama" name="nama" class="form-input"
                  placeholder="Nama lengkap Anda"
                  value="<?= htmlspecialchars($formNama) ?>"
                  autocomplete="name" required>
          </div>

          <div class="form-group" style="margin-bottom: 18px;">
            <label class="form-label" for="email" style="display: block; margin-bottom: 6px;">Email</label>
            <input type="email" id="email" name="email" class="form-input"
                  placeholder="contoh@email.com"
                  value="<?= htmlspecialchars($formEmail) ?>"
                  autocomplete="email" required>
          </div>

          <div class="form-group" style="margin-bottom: 18px;">
            <label class="form-label" for="pekerjaan" style="display: block; margin-bottom: 6px;">Instansi / Pekerjaan <span style="opacity:.5;">(opsional)</span></label>
            <input type="text" id="pekerjaan" name="pekerjaan" class="form-input"
                  placeholder="Sekolah, komunitas, atau institusi"
                  value="<?= htmlspecialchars($formPekerjaan) ?>"
                  autocomplete="organization">
          </div>

          <div class="form-group" style="margin-bottom: 18px;">
            <label class="form-label" for="password" style="display: block; margin-bottom: 6px;">Kata Sandi</label>
            <input type="password" id="password" name="password" class="form-input"
                  placeholder="Minimal 8 karakter"
                  autocomplete="new-password" required>
          </div>

          <div class="form-group" style="margin-bottom: 20px;">
            <label class="form-label" for="password_konfirm" style="display: block; margin-bottom: 6px;">Konfirmasi Kata Sandi</label>
            <input type="password" id="password_konfirm" name="password_konfirm" class="form-input"
                  placeholder="Ulangi kata sandi"
                  autocomplete="new-password" required>
          </div>

          <div class="auth-row" style="margin-bottom: 25px;">
            <label class="auth-check" style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
              <input type="checkbox" name="setuju" required>
              <span>Saya menyetujui kebijakan penggunaan akun</span>
            </label>
          </div>

          <div class="auth-actions" style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 20px;">
            <button type="submit" class="btn-primary">Buat Akun →</button>
          </div>

        </form>

        <div class="auth-split">atau</div>
        <div class="auth-row">
          <span>Sudah terdaftar?</span>
          <a href="login.php">Masuk ke akun</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer class="footer">
  <div class="container">
    <div class="footer-grid">
      <div>
        <div class="footer-name">Museum <em>Kota</em><br>Samarinda</div>
        <div class="footer-addr">Jl. Bhayangkara No.1<br>Samarinda 75121<br>Kalimantan Timur, Indonesia<br><br>© 2025 Museum Kota Samarinda</div>
      </div>
      <div>
        <div class="footer-col-title">Navigasi</div>
        <div class="footer-links">
          <button class="footer-link" onclick="location.href='home.php'">Beranda</button>
          <button class="footer-link" onclick="location.href='tentang.php'">Tentang Museum</button>
          <button class="footer-link" onclick="location.href='koleksi.php'">Koleksi Digital</button>
          <button class="footer-link" onclick="location.href='event.php'">Event & Kegiatan</button>
        </div>
      </div>
      <div>
        <div class="footer-col-title">Layanan</div>
        <div class="footer-links">
          <button class="footer-link" onclick="location.href='peminjaman.php'">Peminjaman Ruang</button>
          <button class="footer-link" onclick="location.href='peta.php'">Peta Lokasi</button>
          <button class="footer-link" onclick="location.href='ulasan.php'">Tulis Ulasan</button>
        </div>
      </div>
      <div>
        <div class="footer-col-title">Informasi</div>
        <div class="footer-links">
          <button class="footer-link" onclick="location.href='tentang.php'">Tentang Kami</button>
          <button class="footer-link">Kontak</button>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <span class="footer-copy">Museum Kota Samarinda - Dinas Kebudayaan Kota Samarinda</span>
      <span class="footer-copy">Dirancang untuk menjaga ingatan kota</span>
    </div>
  </div>
</footer>

<script src="assets/js/signup.js"></script>
<script src="assets/js/scroll-fade-in.js"></script>
</body>
</html>