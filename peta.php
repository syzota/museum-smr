<?php require_once __DIR__ . '/config/auth.php'; ?>

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

<link rel="stylesheet" href="assets/css/peta.css">
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

<!-- ─── NAVBAR ─── -->
<nav class="navbar">
  <div class="container">
    <div class="navbar-inner">
      <button class="nav-item" data-page="beranda" onclick="location.href='home.php'">Beranda</button>
      <button class="nav-item" data-page="tentang" onclick="location.href='tentang.php'">Tentang Museum</button>
      <button class="nav-item" data-page="koleksi" onclick="location.href='koleksi.php'">Koleksi</button>
      <button class="nav-item" data-page="event" onclick="location.href='event.php'">Event & Kegiatan</button>
      <button class="nav-item" data-page="berita" onclick="location.href='berita.php'">Berita</button>
      <button class="nav-item active" data-page="peta" onclick="location.href='peta.php'">Peta Lokasi</button>
      <button class="nav-item" data-page="peminjaman" onclick="location.href='peminjaman.php'">Peminjaman Ruang</button>
      <button class="nav-item" data-page="ulasan" onclick="location.href='ulasan.php'">Ulasan</button>
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

<!-- ════════════════════════════════════════════
     PAGE: BERANDA (LANDING)
════════════════════════════════════════════ -->
<div id="page-peta" class="page active">
  <div class="page-banner">
    <div class="container">
      <div class="page-banner-inner">
        <div>
          <div class="page-banner-breadcrumb">Museum Kota Samarinda / Peta Lokasi</div>
          <h1 class="page-banner-title">Peta &amp; <em>Lokasi</em></h1>
          <p class="page-banner-desc">Temukan kami di jantung kota Samarinda, mudah dijangkau dengan berbagai moda transportasi.</p>
        </div>
      </div>
    </div>
  </div>

  <section class="section">
    <div class="container">
      <div class="peta-layout">
        <div class="peta-map scroll-fade-in">
            <iframe 
                class="peta-map-iframe" 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.6688611136174!2d117.14190601115189!3d-0.4959338994971165!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2df67f0c243ed1c3%3A0xb3402b646d06267a!2sMuseum%20Kota%20Samarinda!5e0!3m2!1sen!2sus!4v1776625247424!5m2!1sen!2sus" 
                width="100%" 
                height="500" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>

        <div class="peta-sidebar scroll-fade-in delay-1">
          <div class="ps-header">
            <div class="label" style="margin-bottom:8px;">Lokasi Museum</div>
            <div class="ps-title">Museum <em>Kota</em><br>Samarinda</div>
            <div class="ps-addr">Jl. Bhayangkara No. 1<br>Samarinda Kota, Samarinda<br>Kalimantan Timur 75121</div>
          </div>
          <div class="ps-body">
            <div class="ps-info-row">
              <div class="ps-icon">🕐</div>
              <div><div class="ps-info-key">Jam Operasional</div><div class="ps-info-val">Sel – Jum: 08:00–16:00<br>Sab – Min: 08:00–15:00<br>Senin: Tutup</div></div>
            </div>
            <div class="ps-info-row">
              <div class="ps-icon">📞</div>
              <div><div class="ps-info-key">Telepon</div><div class="ps-info-val">(0541) 123-4567</div></div>
            </div>
            <div class="ps-info-row">
              <div class="ps-icon">✉</div>
              <div><div class="ps-info-key">Email</div><div class="ps-info-val">info@museumkota<br>samarinda.id</div></div>
            </div>
            <div class="ps-info-row">
              <div class="ps-icon">🅿</div>
              <div><div class="ps-info-key">Parkir</div><div class="ps-info-val">Tersedia di halaman museum!</div></div>
            </div>
          </div>
          <div class="ps-footer">
            <a href="https://maps.app.goo.gl/Lw3Q694WkeGYbgzdA" target="_blank" class="btn-primary" style="width:100%;text-align:center;display:block;text-decoration:none;">Buka di Google Maps ↗</a>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- ════════════════════════════════════════════
     PAGE: PEMINJAMAN RUANG
════════════════════════════════════════════ -->
<!-- ─── FOOTER (shared) ─── -->
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
          <button class="footer-link" onclick="location.href='login.php'">Masuk</button>
          <button class="footer-link" onclick="location.href='signup.php'">Daftar</button>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <span class="footer-copy">Museum Kota Samarinda · Dinas Kebudayaan Kota Samarinda</span>
      <span class="footer-copy">Dirancang untuk menjaga ingatan kota</span>
    </div>
  </div>
</footer>

<script src="assets/js/peta.js"></script>
<script src="assets/js/scroll-fade-in.js"></script>
</body>
</html>



