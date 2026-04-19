<?php
require_once __DIR__ . '/config/auth.php';
$isLoggedIn = isLoggedIn();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ulasan — Museum Kota Samarinda</title>
<link rel="icon" type="image/png" href="assets/logo.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=DM+Mono:wght@300;400&family=Spectral:ital,wght@0,200;0,300;0,400;1,200;1,300&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/ulasan.css">
<link rel="stylesheet" href="assets/css/beranda.css">
</head>
<body>

<?php require_once __DIR__ . '/templates/global/topbar.php'; ?>
<?php require_once __DIR__ . '/templates/global/sidebar.php'; ?>

<!-- ─── MASTHEAD ─── -->
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
          <input class="search-input" type="text" name="q" placeholder="Cari koleksi…" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
          <button class="search-btn" type="submit">⌕</button>
        </form>
        <span style="font-family:var(--alt-serif);font-size:12px;font-weight:300;color:rgba(244,237,229,0.65);">Jl. Bhayangkara No.1, Samarinda</span>
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
      <button class="nav-item" onclick="location.href='peminjaman.php'">Peminjaman Ruang</button>
      <button class="nav-item active">Ulasan</button>
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

<!-- ════════════════════════ PAGE: ULASAN ════════════════════════ -->
<div id="page-ulasan" class="page active">

  <div class="page-banner">
    <div class="container">
      <div class="page-banner-inner">
        <div>
          <div class="page-banner-breadcrumb">Museum Kota Samarinda / Ulasan</div>
          <h1 class="page-banner-title">Ulasan &amp; <em>Kesan</em></h1>
          <p class="page-banner-desc">Apa kata pengunjung tentang Museum Kota Samarinda? Baca ulasan nyata dan bagikan pengalaman kunjungan Anda.</p>
        </div>
      </div>
    </div>
  </div>

  <section class="section">
    <div class="container">

      <!-- Header -->
      <div class="section-header" style="margin-top:8px;margin-bottom:32px;">
        <div>
          <h2 class="section-title">Ulasan <em>Pengunjung</em></h2>
        </div>
      </div>

      <!-- Grid komentar — diisi JS -->
      <div class="ulasan-full-grid" id="ulasan-grid">
        <div style="grid-column:1/-1;padding:48px;text-align:center;font-family:var(--alt-serif);color:var(--sepia);">
          Memuat ulasan…
        </div>
      </div>

      <!-- Form -->
      <div class="form-ulasan" style="margin-top:48px;">
        <div class="fu-header">
          <div class="label" style="margin-bottom:8px;">Bagikan Pengalaman Anda</div>
          <div class="fu-title">Tulis <em>Komentar</em></div>
        </div>

        <?php if (!$isLoggedIn): ?>
          <!-- Belum login -->
          <div style="padding:40px;text-align:center;display:flex;flex-direction:column;align-items:center;gap:16px;">
            <div style="font-size:24px;color:var(--sepia-lt);">✦</div>
            <p style="font-family:var(--alt-serif);font-size:15px;color:var(--sepia);line-height:1.7;">
              Anda perlu <strong>masuk</strong> terlebih dahulu untuk mengirim komentar.
            </p>
            <div style="display:flex;gap:12px;flex-wrap:wrap;justify-content:center;margin-top:8px;">
              <a href="login.php" class="btn-primary" style="text-decoration:none;">Masuk →</a>
              <a href="signup.php" class="btn-secondary" style="text-decoration:none;">Daftar Akun</a>
            </div>
          </div>

        <?php else: ?>
          <!-- Sudah login: textarea saja -->
          <div class="fu-body" style="grid-template-columns:1fr;">
            <div class="form-group fu-full">
              <label class="form-label">Komentar Anda</label>
              <textarea
                class="form-textarea"
                id="field-komentar"
                style="min-height:120px;"
                placeholder="Bagikan pengalaman kunjungan Anda ke Museum Kota Samarinda…"
              ></textarea>
            </div>
          </div>
          <div class="fu-footer">
            <button class="btn-primary" id="btn-submit" onclick="submitKomentar()">Kirim →</button>
            <p class="form-note" id="form-status"></p>
          </div>
        <?php endif; ?>

      </div><!-- /form-ulasan -->

    </div>
  </section>
</div>

<!-- ─── FOOTER ─── -->
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
        <div class="footer-col-title">Informasi</div>
        <div class="footer-links">
          <button class="footer-link" onclick="location.href='peta.php'">Jam &amp; Tiket</button>
          <button class="footer-link" onclick="location.href='tentang.php'">Tentang Kami</button>
          <button class="footer-link">Kontak</button>
          <?php if ($isLoggedIn): ?>
            <button class="footer-link" onclick="location.href='logout.php'">Keluar</button>
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

<script src="assets/js/ulasan.js"></script>
<script src="assets/js/scroll-fade-in.js"></script>
</body>
</html>