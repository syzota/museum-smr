<?php
/**
 * login.php — Halaman Masuk
 * Museum Kota Samarinda
 */

require_once __DIR__ . '/config/auth.php';

// Jika sudah login, langsung arahkan sesuai role
if (isLoggedIn()) {
    header('Location: ' . (isAdmin() ? 'admin/index.php' : 'home.php'));
    exit;
}

// Ambil pesan flash dari session (dari login_proses.php)
$flashError   = $_SESSION['flash_error']   ?? '';
$flashSuccess = $_SESSION['flash_success'] ?? '';
unset($_SESSION['flash_error'], $_SESSION['flash_success']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Masuk - Museum Kota Samarinda</title>
<link rel="icon" type="image/png" href="assets/logo.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=DM+Mono:wght@300;400&family=Spectral:ital,wght@0,200;0,300;0,400;1,200;1,300&display=swap" rel="stylesheet">

<link rel="stylesheet" href="assets/css/beranda.css">
<link rel="stylesheet" href="assets/css/auth.css">
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
        <div class="page-banner-breadcrumb">Museum Kota Samarinda / Masuk</div>
        <h1 class="page-banner-title">Masuk <em>Pengunjung</em></h1>
        <p class="page-banner-desc">Masuk sebagai pengguna untuk melihat status peminjaman, menyimpan riwayat kunjungan, dan mengelola data acara Anda.</p>
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
        <div class="auth-title">Satu akses untuk merapikan agenda kunjungan.</div>
        <div class="auth-text">Masuk untuk melihat status peminjaman ruang, riwayat pengajuan, dan informasi agenda museum yang Anda ikuti.</div>
        <div class="auth-quote">"Tertib data kunjungan membantu museum merawat cerita kota secara berkelanjutan."</div>
      </div>

      <div class="auth-card">
        <div class="auth-meta">Masuk</div>
        <h2>Selamat datang kembali</h2>

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

        <!-- FORM LOGIN — action ke proses/login_proses.php via POST -->
        <form method="POST" action="proses/login_proses.php" novalidate>

          <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <input type="email" id="email" name="email" class="form-input"
                   placeholder="contoh@email.com"
                   value="<?= htmlspecialchars($_SESSION['form_email'] ?? '') ?>"
                   autocomplete="email" required>
          </div>

          <div class="form-group">
            <label class="form-label" for="password">Kata Sandi</label>
            <input type="password" id="password" name="password" class="form-input"
                   placeholder="Masukkan kata sandi"
                   autocomplete="current-password" required>
          </div>

          <div class="auth-row">
            <label class="auth-check">
              <input type="checkbox" name="ingat_saya">
              Ingat saya di perangkat ini
            </label>
            <a href="#">Lupa sandi?</a>
          </div>

          <div class="auth-actions">
            <button type="submit" class="btn-primary">Masuk Sekarang →</button>
            <button type="button" class="btn-ghost" onclick="location.href='signup.php'">Buat Akun Baru</button>
          </div>

        </form>

        <?php unset($_SESSION['form_email']); ?>

        <div class="auth-split">atau</div>
        <div class="auth-row">
          <span>Belum terdaftar?</span>
          <a href="signup.php">Daftar akun pengguna</a>
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
        <div class="footer-col-title">Informasi</div>
        <div class="footer-links">
          <button class="footer-link" onclick="location.href='peta.php'">Jam & Tiket</button>
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

<script src="assets/js/login.js"></script>
<script src="assets/js/scroll-fade-in.js"></script>
</body>
</html>