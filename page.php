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

<link rel="stylesheet" href="assets/css/page.css">

</head>
<body>

<?php require_once __DIR__ . '/templates/global/topbar.php'; ?>
<?php require_once __DIR__ . '/templates/global/sidebar.php'; ?>

<!-- ─── TOPBAR ─── -->
<div class="topbar">
  <div class="container">
    <div class="topbar-inner">
      <div class="topbar-left">
        <span class="topbar-item">Koleksi: 1.247 Artefak</span>
        <div class="topbar-sep"></div>
        <span class="topbar-item">Buka Hari Ini · 08:00–16:00</span>
      </div>
      <div class="topbar-right">
        <span class="topbar-item">Bahasa Indonesia</span>
        <div class="topbar-sep"></div>
        <span class="topbar-item">English</span>
        <div class="topbar-sep"></div>
        <span class="topbar-item" style="color:var(--rust)">Admin ↗</span>
      </div>
    </div>
  </div>
</div>

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
      <button class="nav-item active" data-page="beranda" onclick="showPage('beranda')">Beranda</button>
      <button class="nav-item" data-page="tentang" onclick="showPage('tentang')">Tentang Museum</button>
      <button class="nav-item" data-page="koleksi" onclick="showPage('koleksi')">Koleksi</button>
      <button class="nav-item" data-page="event" onclick="showPage('event')">Event &amp; Kegiatan</button>
      <button class="nav-item" data-page="berita" onclick="showPage('berita')">Berita</button>
      <button class="nav-item" data-page="peta" onclick="showPage('peta')">Peta Lokasi</button>
      <button class="nav-item" data-page="peminjaman" onclick="showPage('peminjaman')">Peminjaman Ruang</button>
      <button class="nav-item" data-page="ulasan" onclick="showPage('ulasan')">Ulasan</button>
      <div style="margin-left:auto;display:flex;gap:8px;">
        <button class="nav-item" onclick="location.href='login.php'">Masuk</button>
        <button class="nav-item" onclick="location.href='signup.php'">Daftar</button>
      </div>
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
<div id="page-beranda" class="page active">

  <!-- TICKER -->
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

  <!-- HERO -->
  <section class="hero">
    <div class="hero-main">
      <div>
        <div class="hero-tag"><div class="dot-live"></div> Sedang Berlangsung</div>
        <h1 class="hero-headline">Menjaga<br><em>Ingatan</em><br>Kota</h1>
        <p class="hero-deck">Lebih dari seribu artefak, naskah, dan dokumentasi sejarah kota Samarinda tersimpan dan terbuka untuk publik. Temukan cerita yang membentuk kota ini.</p>
        <div class="hero-actions">
          <button class="btn-primary" onclick="showPage('koleksi')">Jelajahi Koleksi</button>
          <button class="btn-ghost" onclick="showPage('peta')">Rencana Kunjungan</button>
        </div>
      </div>
      <div class="hero-stats">
        <div class="stat"><div class="stat-num">1.247</div><div class="stat-label">Artefak</div></div>
        <div class="stat"><div class="stat-num">12</div><div class="stat-label">Ruang Pameran</div></div>
        <div class="stat"><div class="stat-num">1903</div><div class="stat-label">Koleksi Tertua</div></div>
      </div>
    </div>
    <div class="hero-divider"></div>
    <div class="hero-side">
      <div>
        <div class="label">Koleksi Pilihan</div>
        <div style="height:12px;"></div>
        <div class="hero-featured-card" onclick="showPage('koleksi')">
          <div class="card-cat">Etnografi · Ruang III</div>
          <div class="card-title">Mandau Dayak Benuaq — Abad ke-18</div>
          <div class="card-body">Senjata upacara dari komunitas Dayak Benuaq, dihiasi ukiran flora dan simbol kepercayaan leluhur. Salah satu koleksi paling langka di museum ini.</div>
          <button class="card-link">Lihat Detail</button>
        </div>
      </div>
      <div class="hero-info-strip">
        <div class="info-row"><span class="info-key">Senin</span><span class="info-val">Tutup</span></div>
        <div class="info-row"><span class="info-key">Selasa–Jumat</span><span class="info-val">08:00 – 16:00 WIB</span></div>
        <div class="info-row"><span class="info-key">Sabtu–Minggu</span><span class="info-val">08:00 – 15:00 WIB</span></div>
        <div class="info-row"><span class="info-key">Tiket Masuk</span><span class="info-val">Gratis</span></div>
      </div>
    </div>
  </section>

  <!-- KOLEKSI UNGGULAN -->
  <section class="section" style="padding:64px 0;">
    <div class="container">
      <div class="section-header">
        <div>
          <div class="label" style="margin-bottom:8px;">Katalog Digital</div>
          <h2 class="section-title">Koleksi <em>Unggulan</em></h2>
        </div>
        <div style="display:flex;align-items:center;gap:16px;">
          <span style="font-family:var(--mono);font-size:9px;letter-spacing:0.14em;text-transform:uppercase;color:var(--sepia-lt);">1.247 Artefak Terdokumentasi</span>
          <button class="btn-ghost" style="padding:8px 20px;" onclick="showPage('koleksi')">Lihat Semua →</button>
        </div>
      </div>
      <div class="koleksi-grid">
        <div class="koleksi-card wide" onclick="showPage('koleksi')">
          <div class="k-num">KOL · 0142</div>
          <div class="k-img-placeholder" data-label="[Foto Koleksi]" style="min-height:140px;"><div class="inner-pattern"></div><svg width="80" height="80" viewBox="0 0 80 80" style="opacity:0.15;position:absolute;"><circle cx="40" cy="40" r="32" fill="none" stroke="#7a6a4a" stroke-width="0.5"/><circle cx="40" cy="40" r="22" fill="none" stroke="#7a6a4a" stroke-width="0.5"/><circle cx="40" cy="40" r="12" fill="none" stroke="#7a6a4a" stroke-width="0.5"/><line x1="8" y1="40" x2="72" y2="40" stroke="#7a6a4a" stroke-width="0.5"/><line x1="40" y1="8" x2="40" y2="72" stroke="#7a6a4a" stroke-width="0.5"/></svg></div>
          <div class="k-title">Meriam Peninggalan Kesultanan Kutai</div>
          <div class="k-era">Abad ke-19 · Senjata Militer</div>
        </div>
        <div class="koleksi-card mid" onclick="showPage('koleksi')">
          <div class="k-num">KOL · 0217</div>
          <div class="k-img-placeholder" data-label="[Foto Koleksi]" style="min-height:100px;"><div class="inner-pattern"></div></div>
          <div class="k-title">Naskah Kuno Kulit Kayu</div>
          <div class="k-era">Abad ke-17 · Tulisan &amp; Naskah</div>
        </div>
        <div class="koleksi-card small" onclick="showPage('koleksi')">
          <div class="k-num">KOL · 0308</div>
          <div class="k-img-placeholder" data-label="[Foto]" style="min-height:80px;"><div class="inner-pattern"></div></div>
          <div class="k-title">Kendi Tembikar</div>
          <div class="k-era">Abad ke-16 · Keramik</div>
        </div>
        <div class="koleksi-card small" onclick="showPage('koleksi')">
          <div class="k-num">KOL · 0421</div>
          <div class="k-img-placeholder" data-label="[Foto]" style="min-height:80px;"><div class="inner-pattern"></div></div>
          <div class="k-title">Pakaian Adat Kutai</div>
          <div class="k-era">Awal Abad ke-20 · Tekstil</div>
        </div>
        <div class="koleksi-card mid" onclick="showPage('koleksi')">
          <div class="k-num">KOL · 0533</div>
          <div class="k-img-placeholder" data-label="[Foto Koleksi]" style="min-height:100px;"><div class="inner-pattern"></div></div>
          <div class="k-title">Mandau Dayak Benuaq</div>
          <div class="k-era">Abad ke-18 · Etnografi</div>
        </div>
        <div class="koleksi-card wide" onclick="showPage('koleksi')">
          <div class="k-num">KOL · 0611</div>
          <div class="k-img-placeholder" data-label="[Foto Koleksi]" style="min-height:100px;"><div class="inner-pattern"></div></div>
          <div class="k-title">Peta Historis Samarinda 1920</div>
          <div class="k-era">1920 · Kartografi &amp; Dokumen</div>
        </div>
      </div>
    </div>
  </section>

  <!-- EVENT & BERITA -->
  <section class="twin-section">
    <div class="twin-col" style="padding-left:40px;">
      <div class="label" style="margin-bottom:8px;">Agenda</div>
      <h2 class="section-title" style="margin-bottom:28px;">Kegiatan &amp; <em>Event</em></h2>
      <div class="event-list">
        <div class="event-item" onclick="showPage('event')">
          <div class="event-date"><div class="event-dd">22</div><div class="event-mm">Mar</div></div>
          <div><div class="event-title">Diskusi Publik: Sejarah Awal Kota Samarinda</div><div class="event-meta">Aula Utama · 09:00 WIB · Gratis</div></div>
        </div>
        <div class="event-item" onclick="showPage('event')">
          <div class="event-date"><div class="event-dd">01</div><div class="event-mm">Apr</div></div>
          <div><div class="event-title">Workshop Batik Khas Kalimantan untuk Pelajar</div><div class="event-meta">Ruang Edukasi · 10:00 WIB · Terbatas 30 Peserta</div></div>
        </div>
        <div class="event-item" onclick="showPage('event')">
          <div class="event-date"><div class="event-dd">15</div><div class="event-mm">Apr</div></div>
          <div><div class="event-title">Pembukaan Pameran: Warisan Dayak Kaltim</div><div class="event-meta">Ruang Pameran Temporer · 14:00 WIB</div></div>
        </div>
        <div class="event-item" onclick="showPage('event')">
          <div class="event-date"><div class="event-dd">20</div><div class="event-mm">Apr</div></div>
          <div><div class="event-title">Kunjungan Edukasi Sekolah Dasar Se-Kota</div><div class="event-meta">Seluruh Ruang Museum · 08:00 WIB</div></div>
        </div>
      </div>
      <div style="margin-top:24px;"><button class="btn-ghost" style="padding:9px 20px;" onclick="showPage('event')">Lihat Semua Event →</button></div>
    </div>
    <div class="twin-div"></div>
    <div class="twin-col" style="padding-right:40px;">
      <div class="label" style="margin-bottom:8px;">Publikasi</div>
      <h2 class="section-title" style="margin-bottom:28px;">Berita &amp; <em>Artikel</em></h2>
      <div class="berita-list">
        <div class="berita-item" onclick="showPage('berita')">
          <div class="berita-cat">Koleksi Baru</div>
          <div class="berita-title">Naskah Lontar Abad ke-17 Resmi Masuk Katalog Museum</div>
          <div class="berita-snippet">Setelah proses restorasi selama enam bulan, naskah bersejarah ini kini dapat diakses oleh publik secara digital melalui katalog online museum.</div>
          <div class="berita-date">14 Maret 2025</div>
        </div>
        <div class="berita-item" onclick="showPage('berita')">
          <div class="berita-cat">Kerjasama</div>
          <div class="berita-title">Museum Tanda Tangani MoU dengan Universitas Mulawarman</div>
          <div class="berita-snippet">Perjanjian ini membuka akses penelitian bagi mahasiswa dan dosen untuk mempelajari koleksi artefak secara langsung.</div>
          <div class="berita-date">8 Maret 2025</div>
        </div>
        <div class="berita-item" onclick="showPage('berita')">
          <div class="berita-cat">Fasilitas</div>
          <div class="berita-title">Renovasi Ruang Pameran IV Selesai Lebih Awal</div>
          <div class="berita-snippet">Ruang pameran yang diperbarui kini hadir dengan pencahayaan museum-grade dan sistem sirkulasi udara yang lebih baik.</div>
          <div class="berita-date">1 Maret 2025</div>
        </div>
      </div>
      <div style="margin-top:24px;"><button class="btn-ghost" style="padding:9px 20px;" onclick="showPage('berita')">Lihat Semua Berita →</button></div>
    </div>
  </section>

  <!-- INFO BAND -->
  <div class="info-band">
    <div class="container" style="display:contents;">
      <div class="info-band-inner">
        <div class="info-band-col"><div class="ib-label">Alamat</div><div class="ib-val">Jl. Bhayangkara No.1<br>Samarinda, Kalimantan Timur</div></div>
        <div class="info-band-div"></div>
        <div class="info-band-col"><div class="ib-label">Jam Buka</div><div class="ib-val">Sel – Jum · 08:00–16:00<br>Sab – Min · 08:00–15:00</div></div>
        <div class="info-band-div"></div>
        <div class="info-band-col"><div class="ib-label">Kontak</div><div class="ib-val">(0541) 123-4567<br>info@museumkotasamarinda.id</div></div>
        <div class="info-band-div"></div>
        <div class="info-band-col"><div class="ib-label">Tiket Masuk</div><div class="ib-val large" style="font-style:italic;">Gratis</div><div class="ib-val" style="font-size:12px;opacity:0.5;margin-top:2px;">untuk semua pengunjung</div></div>
      </div>
    </div>
  </div>

  <!-- ULASAN MINI -->
  <section class="section">
    <div class="container">
      <div class="section-header">
        <div><div class="label" style="margin-bottom:8px;">Suara Pengunjung</div><h2 class="section-title">Ulasan &amp; <em>Kesan</em></h2></div>
        <button class="btn-ghost" style="padding:8px 20px;" onclick="showPage('ulasan')">Tulis Ulasan →</button>
      </div>
      <div class="ulasan-grid">
        <div class="ulasan-card">
          <div class="ulasan-stars"><div class="star"></div><div class="star"></div><div class="star"></div><div class="star"></div><div class="star"></div></div>
          <div class="ulasan-text">"Sangat informatif dan terorganisir dengan baik. Koleksi mandau dan naskah kuno benar-benar membuat saya kagum dengan kekayaan sejarah Kalimantan."</div>
          <div class="ulasan-meta"><span class="ulasan-name">Rina Kusumawati</span><span class="ulasan-date">12 Mar 2025</span></div>
        </div>
        <div class="ulasan-card" style="background:var(--parchment);">
          <div class="ulasan-stars"><div class="star"></div><div class="star"></div><div class="star"></div><div class="star"></div><div class="star empty"></div></div>
          <div class="ulasan-text">"Tempatnya bersih dan staf sangat ramah dalam menjelaskan setiap koleksi. Cocok untuk kunjungan keluarga dan edukasi anak-anak tentang sejarah lokal."</div>
          <div class="ulasan-meta"><span class="ulasan-name">Budi Santoso</span><span class="ulasan-date">5 Mar 2025</span></div>
        </div>
        <div class="ulasan-card">
          <div class="ulasan-stars"><div class="star"></div><div class="star"></div><div class="star"></div><div class="star"></div><div class="star"></div></div>
          <div class="ulasan-text">"Pameran Warisan Dayak sungguh luar biasa. Saya tidak menyangka museum kota bisa seprofesional ini. Wajib dikunjungi saat ke Samarinda."</div>
          <div class="ulasan-meta"><span class="ulasan-name">Ahmad Fauzi</span><span class="ulasan-date">28 Feb 2025</span></div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- ════════════════════════════════════════════
     PAGE: TENTANG MUSEUM
════════════════════════════════════════════ -->
<div id="page-tentang" class="page">
  <!-- BANNER -->
  <div class="page-banner">
    <div class="container">
      <div class="page-banner-inner">
        <div>
          <div class="page-banner-breadcrumb">Museum Kota Samarinda / Tentang Museum</div>
          <h1 class="page-banner-title">Tentang <em>Museum</em></h1>
          <p class="page-banner-desc">Mengenal sejarah, visi, dan dedikasi kami dalam menjaga warisan budaya kota Samarinda untuk generasi mendatang.</p>
        </div>
        <div style="text-align:right;">
          <div style="font-family:var(--mono);font-size:9px;letter-spacing:0.14em;text-transform:uppercase;color:var(--sepia-lt);margin-bottom:6px;">Berdiri Sejak</div>
          <div style="font-family:var(--serif);font-size:56px;font-weight:300;color:var(--ink);line-height:1;">2003</div>
        </div>
      </div>
    </div>
  </div>

  <!-- STATS BAND -->
  <div class="about-stats-band">
    <div class="container" style="display:contents;">
      <div class="about-stats-inner" style="padding:0 40px;">
        <div class="about-stat-col"><div class="about-stat-num">1.247</div><div class="about-stat-label">Artefak Terdokumentasi</div></div>
        <div class="about-stat-col"><div class="about-stat-num">22</div><div class="about-stat-label">Tahun Beroperasi</div></div>
        <div class="about-stat-col"><div class="about-stat-num">12</div><div class="about-stat-label">Ruang Pameran</div></div>
        <div class="about-stat-col"><div class="about-stat-num">48k</div><div class="about-stat-label">Pengunjung Pertahun</div></div>
      </div>
    </div>
  </div>

  <!-- SEJARAH & VISI -->
  <section class="section">
    <div class="container">
      <div class="section-header">
        <div><div class="label" style="margin-bottom:8px;">Profil Institusi</div><h2 class="section-title">Sejarah &amp; <em>Visi</em></h2></div>
      </div>
      <div class="about-grid">
        <div class="about-col">
          <div class="about-body">
            <p>Museum Kota Samarinda didirikan pada tahun <strong>2003</strong> atas prakarsa Pemerintah Kota Samarinda bersama Dinas Kebudayaan Kalimantan Timur, sebagai upaya pelestarian dan dokumentasi kekayaan sejarah serta budaya kota yang telah berusia lebih dari tiga abad.</p>
            <p>Berlokasi di <strong>Jalan Bhayangkara No. 1</strong>, museum ini menempati bangunan heritage yang sebelumnya merupakan kantor pemerintahan era kolonial. Bangunan ini sendiri merupakan salah satu artefak arsitektur tertua yang masih berdiri di pusat kota Samarinda.</p>
            <p>Sejak pembukaannya, museum telah mengumpulkan lebih dari seribu artefak yang mencakup berbagai kategori: dari senjata tradisional suku Dayak, naskah kuno, pakaian adat Kesultanan Kutai, hingga dokumentasi fotografis era kolonial dan masa kemerdekaan.</p>
            <p>Pada tahun <strong>2018</strong>, museum menjalani renovasi besar yang menghadirkan sistem pencahayaan museum-grade, katalog digital interaktif, dan ruang edukasi modern — tanpa mengorbankan karakter bangunan aslinya.</p>
          </div>
        </div>
        <div class="about-div"></div>
        <div class="about-col">
          <div style="font-family:var(--mono);font-size:9px;letter-spacing:0.14em;text-transform:uppercase;color:var(--sepia-lt);margin-bottom:20px;">Visi &amp; Misi</div>
          <div style="font-family:var(--serif);font-size:22px;font-weight:300;font-style:italic;color:var(--ink);line-height:1.4;margin-bottom:24px;padding-left:20px;border-left:2px solid var(--sepia-lt);">"Menjadi pusat referensi sejarah dan kebudayaan Kalimantan Timur yang terpercaya, inklusif, dan berkelanjutan."</div>
          <div class="about-body">
            <p><strong>Pelestarian:</strong> Mengumpulkan, merawat, dan mendokumentasikan artefak sejarah dan budaya secara sistematis sesuai standar museum nasional.</p>
            <p><strong>Edukasi:</strong> Menyediakan program pembelajaran yang relevan bagi pelajar, mahasiswa, peneliti, dan masyarakat umum tentang sejarah lokal Kalimantan Timur.</p>
            <p><strong>Aksesibilitas:</strong> Membuka pintu museum untuk semua kalangan secara gratis, dan mengembangkan katalog digital agar koleksi dapat diakses dari mana saja.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- TIMELINE -->
  <section class="section">
    <div class="container">
      <div class="section-header">
        <div><div class="label" style="margin-bottom:8px;">Kronologi</div><h2 class="section-title">Linimasa <em>Perkembangan</em></h2></div>
      </div>
      <div class="timeline">
        <div class="timeline-item">
          <div class="tl-year">2003</div>
          <div class="tl-line"></div>
          <div class="tl-content"><div class="tl-title">Pendirian Museum</div><div class="tl-body">Museum Kota Samarinda resmi dibuka oleh Walikota Samarinda pada tanggal 17 Agustus 2003. Koleksi awal terdiri dari 287 artefak yang disumbangkan oleh warga dan instansi pemerintah.</div></div>
        </div>
        <div class="timeline-item">
          <div class="tl-year">2007</div>
          <div class="tl-line"></div>
          <div class="tl-content"><div class="tl-title">Perluasan Koleksi Etnografi</div><div class="tl-body">Kerja sama dengan Lembaga Adat Dayak menghadirkan lebih dari 180 artefak baru, termasuk koleksi mandau, pakaian upacara, dan alat musik tradisional.</div></div>
        </div>
        <div class="timeline-item">
          <div class="tl-year">2012</div>
          <div class="tl-line"></div>
          <div class="tl-content"><div class="tl-title">Program Edukasi Pertama</div><div class="tl-body">Peluncuran program kunjungan sekolah terstruktur yang kini menjadi salah satu program flagship museum, menjangkau lebih dari 15.000 pelajar per tahun.</div></div>
        </div>
        <div class="timeline-item">
          <div class="tl-year">2018</div>
          <div class="tl-line"></div>
          <div class="tl-content"><div class="tl-title">Renovasi &amp; Modernisasi</div><div class="tl-body">Renovasi besar senilai Rp 12,5 miliar menghadirkan pencahayaan museum-grade, sistem HVAC modern, ruang edukasi interaktif, dan tampilan baru yang tetap menghormati karakter bangunan heritage.</div></div>
        </div>
        <div class="timeline-item">
          <div class="tl-year">2021</div>
          <div class="tl-line"></div>
          <div class="tl-content"><div class="tl-title">Katalog Digital Diluncurkan</div><div class="tl-body">Peluncuran katalog digital yang memungkinkan publik mengakses dokumentasi koleksi secara online. Lebih dari 900 artefak telah terdigitalisasi dengan foto resolusi tinggi dan metadata lengkap.</div></div>
        </div>
        <div class="timeline-item">
          <div class="tl-year">2024</div>
          <div class="tl-line"></div>
          <div class="tl-content"><div class="tl-title">MoU dengan Universitas Mulawarman</div><div class="tl-body">Penandatanganan MoU membuka akses penelitian kolaboratif dengan Universitas Mulawarman, memperkuat peran museum sebagai pusat riset sejarah dan budaya Kalimantan Timur.</div></div>
        </div>
      </div>
    </div>
  </section>

  <!-- TIM -->
  <section class="section">
    <div class="container">
      <div class="section-header">
        <div><div class="label" style="margin-bottom:8px;">Sumber Daya Manusia</div><h2 class="section-title">Tim <em>Kami</em></h2></div>
      </div>
      <div class="team-grid">
        <div class="team-card">
          <div class="team-avatar">H</div>
          <div class="team-name">Hj. Rahmawati, S.Pd., M.Hum.</div>
          <div class="team-role">Kepala Museum</div>
          <div class="team-bio">Berpengalaman 18 tahun di bidang pengelolaan museum dan pelestarian warisan budaya. Lulusan Magister Humaniora Universitas Gadjah Mada.</div>
        </div>
        <div class="team-card" style="background:var(--parchment);">
          <div class="team-avatar" style="background:var(--linen);">A</div>
          <div class="team-name">Ahmad Syaiful, S.Sos.</div>
          <div class="team-role">Kurator Senior</div>
          <div class="team-bio">Spesialis artefak Dayak dan Kesultanan Kutai. Telah menerbitkan 3 buku tentang kebudayaan Kalimantan Timur dan menjadi pembicara di berbagai seminar nasional.</div>
        </div>
        <div class="team-card">
          <div class="team-avatar">D</div>
          <div class="team-name">Dewi Kartika, S.Si.</div>
          <div class="team-role">Konservator</div>
          <div class="team-bio">Bertanggung jawab atas perawatan dan restorasi artefak. Tersertifikasi dari Balai Konservasi Cagar Budaya Nasional dengan keahlian khusus pada naskah kuno dan tekstil.</div>
        </div>
        <div class="team-card">
          <div class="team-avatar">R</div>
          <div class="team-name">Rizky Pratama, S.Kom.</div>
          <div class="team-role">Pengelola Katalog Digital</div>
          <div class="team-bio">Memimpin digitalisasi koleksi dan pengembangan katalog digital museum. Mengintegrasikan teknologi fotografi 3D untuk dokumentasi artefak berdimensi.</div>
        </div>
        <div class="team-card" style="background:var(--parchment);">
          <div class="team-avatar" style="background:var(--linen);">S</div>
          <div class="team-name">Sari Indah, A.Md.</div>
          <div class="team-role">Koordinator Edukasi</div>
          <div class="team-bio">Merancang dan mengelola program edukasi museum untuk pelajar SD hingga SMA, serta program pelatihan pemandu museum.</div>
        </div>
        <div class="team-card">
          <div class="team-avatar">M</div>
          <div class="team-name">M. Fakhri Hidayat</div>
          <div class="team-role">Pemandu Museum Senior</div>
          <div class="team-bio">Pemandu berpengalaman dengan pengetahuan mendalam tentang sejarah lokal Samarinda. Fasih dalam Bahasa Indonesia, Inggris, dan Bahasa Kutai.</div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- ════════════════════════════════════════════
     PAGE: KOLEKSI
════════════════════════════════════════════ -->
<div id="page-koleksi" class="page">
  <div class="page-banner">
    <div class="container">
      <div class="page-banner-inner">
        <div>
          <div class="page-banner-breadcrumb">Museum Kota Samarinda / Koleksi</div>
          <h1 class="page-banner-title">Katalog <em>Koleksi</em></h1>
          <p class="page-banner-desc">Jelajahi 1.247 artefak bersejarah yang tersimpan dan terdokumentasi secara digital untuk akses publik.</p>
        </div>
        <div style="text-align:right;">
          <div style="font-family:var(--mono);font-size:9px;letter-spacing:0.14em;text-transform:uppercase;color:var(--sepia-lt);margin-bottom:6px;">Total Koleksi</div>
          <div style="font-family:var(--serif);font-size:56px;font-weight:300;color:var(--ink);line-height:1;">1.247</div>
        </div>
      </div>
    </div>
  </div>

  <section class="section">
    <div class="container">
      <!-- Filter -->
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:32px;">
        <div class="koleksi-filter">
          <button class="filter-btn active" onclick="setFilter(this,'semua')">Semua</button>
          <button class="filter-btn" onclick="setFilter(this,'etnografi')">Etnografi</button>
          <button class="filter-btn" onclick="setFilter(this,'naskah')">Naskah &amp; Tulisan</button>
          <button class="filter-btn" onclick="setFilter(this,'keramik')">Keramik</button>
          <button class="filter-btn" onclick="setFilter(this,'tekstil')">Tekstil</button>
          <button class="filter-btn" onclick="setFilter(this,'militer')">Militer</button>
          <button class="filter-btn" onclick="setFilter(this,'kartografi')">Kartografi</button>
        </div>
        <div style="display:flex;align-items:center;gap:12px;">
          <span style="font-family:var(--mono);font-size:9px;letter-spacing:0.12em;text-transform:uppercase;color:var(--sepia-lt);">Urut berdasarkan:</span>
          <select class="form-select" style="width:160px;padding:7px 36px 7px 12px;font-size:12px;">
            <option>Nomor Koleksi</option>
            <option>Nama A–Z</option>
            <option>Era (Tertua)</option>
            <option>Era (Terbaru)</option>
          </select>
        </div>
      </div>

      <!-- Grid Koleksi -->
      <div class="koleksi-full-grid">
        <div class="koleksi-full-card"><div class="kf-img"><div class="inner-pattern"></div><svg width="60" height="60" viewBox="0 0 60 60"><circle cx="30" cy="30" r="24" fill="none" stroke="#7a6a4a" stroke-width="0.5"/><line x1="6" y1="30" x2="54" y2="30" stroke="#7a6a4a" stroke-width="0.5"/><line x1="30" y1="6" x2="30" y2="54" stroke="#7a6a4a" stroke-width="0.5"/></svg></div><div class="kf-num">KOL · 0142</div><div class="kf-cat">Militer</div><div class="kf-title">Meriam Peninggalan Kesultanan Kutai</div><div class="kf-era">Abad ke-19</div><div class="kf-desc">Meriam perunggu berukir yang digunakan pada masa Kesultanan Kutai Kartanegara. Ditemukan di tepi Sungai Mahakam pada 1987.</div></div>
        <div class="koleksi-full-card" style="background:var(--parchment);"><div class="kf-img" style="background:var(--vellum);"><div class="inner-pattern"></div><svg width="60" height="60" viewBox="0 0 60 60"><rect x="15" y="10" width="30" height="40" fill="none" stroke="#7a6a4a" stroke-width="0.5"/><line x1="20" y1="20" x2="40" y2="20" stroke="#7a6a4a" stroke-width="0.5"/><line x1="20" y1="26" x2="40" y2="26" stroke="#7a6a4a" stroke-width="0.5"/><line x1="20" y1="32" x2="35" y2="32" stroke="#7a6a4a" stroke-width="0.5"/></svg></div><div class="kf-num">KOL · 0217</div><div class="kf-cat">Naskah &amp; Tulisan</div><div class="kf-title">Naskah Kuno Kulit Kayu</div><div class="kf-era">Abad ke-17</div><div class="kf-desc">Naskah ditulis dengan tinta alami di atas kulit kayu sempu. Memuat catatan silsilah dan hukum adat komunitas Kutai kuno.</div></div>
        <div class="koleksi-full-card"><div class="kf-img"><div class="inner-pattern"></div><svg width="60" height="60" viewBox="0 0 60 60"><ellipse cx="30" cy="36" rx="14" ry="18" fill="none" stroke="#7a6a4a" stroke-width="0.5"/><ellipse cx="30" cy="18" rx="6" ry="8" fill="none" stroke="#7a6a4a" stroke-width="0.5"/></svg></div><div class="kf-num">KOL · 0308</div><div class="kf-cat">Keramik</div><div class="kf-title">Kendi Tembikar Kutai</div><div class="kf-era">Abad ke-16</div><div class="kf-desc">Kendi tanah liat bermotif geometris yang digunakan dalam upacara adat. Ditemukan dalam kondisi hampir utuh di situs ekskavasi Kutai Lama.</div></div>
        <div class="koleksi-full-card"><div class="kf-img"><div class="inner-pattern"></div><svg width="60" height="60" viewBox="0 0 60 60"><path d="M20 10 L40 10 L42 50 L18 50 Z" fill="none" stroke="#7a6a4a" stroke-width="0.5"/><path d="M25 10 L35 10 L37 30 L23 30 Z" fill="none" stroke="#7a6a4a" stroke-width="0.3"/></svg></div><div class="kf-num">KOL · 0421</div><div class="kf-cat">Tekstil</div><div class="kf-title">Pakaian Adat Kutai</div><div class="kf-era">Awal Abad ke-20</div><div class="kf-desc">Pakaian upacara kerajaan dari Kesultanan Kutai, dibuat dari kain sutra dengan sulaman benang emas bermotif naga dan burung enggang.</div></div>
        <div class="koleksi-full-card" style="background:var(--parchment);"><div class="kf-img" style="background:var(--vellum);"><div class="inner-pattern"></div><svg width="60" height="60" viewBox="0 0 60 60"><path d="M30 5 L55 30 L30 55 L5 30 Z" fill="none" stroke="#7a6a4a" stroke-width="0.5"/><path d="M30 15 L45 30 L30 45 L15 30 Z" fill="none" stroke="#7a6a4a" stroke-width="0.3"/></svg></div><div class="kf-num">KOL · 0533</div><div class="kf-cat">Etnografi</div><div class="kf-title">Mandau Dayak Benuaq</div><div class="kf-era">Abad ke-18</div><div class="kf-desc">Senjata ritual komunitas Dayak Benuaq dengan bilah besi tempa dan sarung ukiran rotan. Simbol status dan perlindungan spiritual.</div></div>
        <div class="koleksi-full-card"><div class="kf-img"><div class="inner-pattern"></div><svg width="60" height="60" viewBox="0 0 60 60"><rect x="8" y="12" width="44" height="36" fill="none" stroke="#7a6a4a" stroke-width="0.5"/><line x1="20" y1="12" x2="20" y2="48" stroke="#7a6a4a" stroke-width="0.3"/><line x1="32" y1="12" x2="32" y2="48" stroke="#7a6a4a" stroke-width="0.3"/><line x1="8" y1="24" x2="52" y2="24" stroke="#7a6a4a" stroke-width="0.3"/></svg></div><div class="kf-num">KOL · 0611</div><div class="kf-cat">Kartografi</div><div class="kf-title">Peta Historis Samarinda 1920</div><div class="kf-era">1920</div><div class="kf-desc">Peta cetak litografi berwarna dari tahun 1920 yang menampilkan tata kota Samarinda pada masa Hindia Belanda. Koleksi sangat langka.</div></div>
        <div class="koleksi-full-card"><div class="kf-img"><div class="inner-pattern"></div><svg width="60" height="60" viewBox="0 0 60 60"><circle cx="30" cy="30" r="20" fill="none" stroke="#7a6a4a" stroke-width="0.5"/><circle cx="30" cy="30" r="10" fill="none" stroke="#7a6a4a" stroke-width="0.3"/><circle cx="30" cy="30" r="3" fill="#7a6a4a" opacity="0.3"/></svg></div><div class="kf-num">KOL · 0712</div><div class="kf-cat">Etnografi</div><div class="kf-title">Tameng Perang Dayak</div><div class="kf-era">Abad ke-18</div><div class="kf-desc">Tameng bundar berbahan kulit kerbau dengan motif ukiran wajah roh pelindung. Digunakan dalam upacara perang adat dan ritual pengusir roh jahat.</div></div>
        <div class="koleksi-full-card" style="background:var(--parchment);"><div class="kf-img" style="background:var(--vellum);"><div class="inner-pattern"></div><svg width="60" height="60" viewBox="0 0 60 60"><path d="M10 50 Q30 10 50 50" fill="none" stroke="#7a6a4a" stroke-width="0.5"/><path d="M15 45 Q30 20 45 45" fill="none" stroke="#7a6a4a" stroke-width="0.3"/></svg></div><div class="kf-num">KOL · 0834</div><div class="kf-cat">Naskah &amp; Tulisan</div><div class="kf-title">Lontar Aksara Lontara</div><div class="kf-era">Abad ke-17</div><div class="kf-desc">Naskah lontar ditulis dalam aksara Lontara Bugis memuat syair epik tentang pelayaran dan perdagangan di Nusantara.</div></div>
      </div>

      <!-- Koleksi Featured -->
      <div class="koleksi-detail-strip">
        <div class="kd-main">
          <div>
            <div class="kd-label">Koleksi Unggulan Bulan Ini</div>
            <div class="kd-title">Mandau Dayak Benuaq<br><em>— Abad ke-18</em></div>
          </div>
          <div class="kd-body">
            Mandau ini merupakan salah satu koleksi paling berharga di Museum Kota Samarinda. Dibuat oleh pandai besi Dayak Benuaq pada pertengahan abad ke-18, bilahnya ditempa dari besi meteorit — material langka yang dipercaya memberi kekuatan spiritual pada senjata.
            <br><br>
            Sarung mandau diukir secara rumit dengan motif <em>kalung</em> (ulat bulu) yang melambangkan transformasi dan keberanian. Gagang terbuat dari tanduk rusa dengan jalinan rambut manusia dan bulu burung enggang.
          </div>
          <button class="btn-ghost" style="margin-top:8px;">Unduh Lembar Data Koleksi ↓</button>
        </div>
        <div class="kd-side">
          <div class="kd-label">Data Koleksi</div>
          <div class="kd-meta-row"><span class="kd-meta-key">No. Koleksi</span><span class="kd-meta-val">KOL · 0533</span></div>
          <div class="kd-meta-row"><span class="kd-meta-key">Kategori</span><span class="kd-meta-val">Etnografi</span></div>
          <div class="kd-meta-row"><span class="kd-meta-key">Era</span><span class="kd-meta-val">Abad ke-18 (c. 1740–1780)</span></div>
          <div class="kd-meta-row"><span class="kd-meta-key">Asal</span><span class="kd-meta-val">Komunitas Dayak Benuaq, Kutai Barat</span></div>
          <div class="kd-meta-row"><span class="kd-meta-key">Material</span><span class="kd-meta-val">Besi meteorit, tanduk rusa, rotan</span></div>
          <div class="kd-meta-row"><span class="kd-meta-key">Dimensi</span><span class="kd-meta-val">P: 68 cm · L: 5 cm</span></div>
          <div class="kd-meta-row"><span class="kd-meta-key">Kondisi</span><span class="kd-meta-val">Baik (85% utuh)</span></div>
          <div class="kd-meta-row"><span class="kd-meta-key">Lokasi</span><span class="kd-meta-val">Ruang III · Vitrin 7</span></div>
        </div>
      </div>

      <div style="display:flex;justify-content:center;margin-top:40px;">
        <button class="btn-ghost" style="padding:12px 40px;">Muat Lebih Banyak Koleksi ↓</button>
      </div>
    </div>
  </section>
</div>

<!-- ════════════════════════════════════════════
     PAGE: EVENT & KEGIATAN
════════════════════════════════════════════ -->
<div id="page-event" class="page">
  <div class="page-banner">
    <div class="container">
      <div class="page-banner-inner">
        <div>
          <div class="page-banner-breadcrumb">Museum Kota Samarinda / Event &amp; Kegiatan</div>
          <h1 class="page-banner-title">Event &amp; <em>Kegiatan</em></h1>
          <p class="page-banner-desc">Program publik, pameran, workshop, dan diskusi yang terbuka untuk masyarakat umum.</p>
        </div>
        <button class="btn-primary" onclick="showPage('peminjaman')">Ajukan Kegiatan →</button>
      </div>
    </div>
  </div>

  <section class="section">
    <div class="container">
      <div class="section-header">
        <div><div class="label" style="margin-bottom:8px;">April – Juni 2025</div><h2 class="section-title">Agenda <em>Mendatang</em></h2></div>
        <div class="koleksi-filter">
          <button class="filter-btn active">Semua</button>
          <button class="filter-btn">Pameran</button>
          <button class="filter-btn">Workshop</button>
          <button class="filter-btn">Diskusi</button>
          <button class="filter-btn">Edukasi</button>
        </div>
      </div>

      <div class="event-full-grid">
        <div class="event-main">
          <div class="event-full-item">
            <div class="efi-date"><div class="efi-dd">22</div><div class="efi-mm">Mar</div><div class="efi-yr">2025</div></div>
            <div class="efi-div"></div>
            <div class="efi-content"><div class="efi-cat">Diskusi Publik</div><div class="efi-title">Sejarah Awal Kota Samarinda: Dari Kampung Tenun ke Ibukota Provinsi</div><div class="efi-meta">Aula Utama · 09:00 – 12:00 WIB · Gratis</div><div class="efi-desc">Diskusi bersama sejarawan lokal dan akademisi tentang transformasi Samarinda dari pemukiman tenun Bugis di abad ke-17 hingga menjadi ibukota Kalimantan Timur.</div><span class="efi-tag">Terbuka Umum</span></div>
          </div>
          <div class="event-full-item">
            <div class="efi-date"><div class="efi-dd">01</div><div class="efi-mm">Apr</div><div class="efi-yr">2025</div></div>
            <div class="efi-div"></div>
            <div class="efi-content"><div class="efi-cat">Workshop</div><div class="efi-title">Batik Khas Kalimantan: Motif Naga dan Enggang untuk Pelajar</div><div class="efi-meta">Ruang Edukasi · 10:00 – 13:00 WIB · Gratis, Daftar Wajib</div><div class="efi-desc">Workshop hands-on membatik dengan motif khas Kalimantan Timur untuk pelajar SMP–SMA. Bahan dan alat disediakan. Kuota terbatas 30 peserta.</div><span class="efi-tag full">Kuota Penuh</span></div>
          </div>
          <div class="event-full-item">
            <div class="efi-date"><div class="efi-dd">15</div><div class="efi-mm">Apr</div><div class="efi-yr">2025</div></div>
            <div class="efi-div"></div>
            <div class="efi-content"><div class="efi-cat">Pameran</div><div class="efi-title">Pembukaan Pameran Temporer: Warisan Dayak Kalimantan Timur</div><div class="efi-meta">Ruang Pameran Temporer · 14:00 WIB · Gratis</div><div class="efi-desc">Pameran menampilkan lebih dari 80 artefak Dayak dari berbagai suku yang tinggal di Kalimantan Timur: Benuaq, Tunjung, Modang, dan Kenyah. Dipinjamkan dari koleksi Balai Pelestarian Kebudayaan Kalimantan Timur.</div><span class="efi-tag">Terbuka Umum</span></div>
          </div>
          <div class="event-full-item">
            <div class="efi-date"><div class="efi-dd">20</div><div class="efi-mm">Apr</div><div class="efi-yr">2025</div></div>
            <div class="efi-div"></div>
            <div class="efi-content"><div class="efi-cat">Edukasi</div><div class="efi-title">Kunjungan Edukasi Sekolah Dasar Se-Kota Samarinda</div><div class="efi-meta">Seluruh Ruang Museum · 08:00 – 15:00 WIB</div><div class="efi-desc">Hari khusus kunjungan terstruktur bagi siswa SD se-Kota Samarinda. Program termasuk tur terpandu, workshop mini, dan kuis berhadiah. Koordinasi melalui Dinas Pendidikan Kota Samarinda.</div></div>
          </div>
          <div class="event-full-item">
            <div class="efi-date"><div class="efi-dd">05</div><div class="efi-mm">Mei</div><div class="efi-yr">2025</div></div>
            <div class="efi-div"></div>
            <div class="efi-content"><div class="efi-cat">Diskusi</div><div class="efi-title">Konservasi Digital: Menjaga Naskah Kuno di Era Digital</div><div class="efi-meta">Aula Utama · 13:00 – 16:00 WIB · Gratis</div><div class="efi-desc">Seminar bersama Pusat Dokumentasi Arsip Nasional tentang teknologi digitalisasi naskah kuno dan tantangan pelestarian warisan tertulis.</div><span class="efi-tag">Terbuka Umum</span></div>
          </div>
          <div class="event-full-item">
            <div class="efi-date"><div class="efi-dd">17</div><div class="efi-mm">Mei</div><div class="efi-yr">2025</div></div>
            <div class="efi-div"></div>
            <div class="efi-content"><div class="efi-cat">Peringatan</div><div class="efi-title">Hari Museum Internasional — Program Seharian Gratis</div><div class="efi-meta">Seluruh Museum · 08:00 – 20:00 WIB · Gratis + Malam Museum</div><div class="efi-desc">Perayaan Hari Museum Internasional dengan program spesial: tur malam museum, penampilan seni budaya, peluncuran fitur baru katalog digital, dan kuliner lokal.</div><span class="efi-tag">Spesial</span></div>
          </div>
        </div>

        <div class="event-sidebar">
          <div>
            <div class="sidebar-title">Segera Berlangsung</div>
            <div style="height:12px;"></div>
            <div class="sidebar-mini">
              <div class="sidebar-mini-item">
                <div class="smi-date-box"><div class="smi-dd">22</div><div class="smi-mm">Mar</div></div>
                <div><div class="smi-title">Diskusi: Sejarah Awal Samarinda</div><div class="smi-meta">09:00 · Aula Utama</div></div>
              </div>
              <div class="sidebar-mini-item">
                <div class="smi-date-box"><div class="smi-dd">01</div><div class="smi-mm">Apr</div></div>
                <div><div class="smi-title">Workshop Batik Kalimantan</div><div class="smi-meta">10:00 · Ruang Edukasi</div></div>
              </div>
              <div class="sidebar-mini-item">
                <div class="smi-date-box"><div class="smi-dd">15</div><div class="smi-mm">Apr</div></div>
                <div><div class="smi-title">Pembukaan Pameran Dayak</div><div class="smi-meta">14:00 · R. Temporer</div></div>
              </div>
            </div>
          </div>
          <div style="border-top:0.5px solid var(--cream-dk);padding-top:20px;">
            <div class="sidebar-title">Kategori</div>
            <div style="height:12px;"></div>
            <div style="display:flex;flex-direction:column;gap:8px;">
              <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:0.5px dashed var(--cream-dk);"><span style="font-family:var(--alt-serif);font-size:13px;color:var(--ink);">Pameran</span><span style="font-family:var(--mono);font-size:8.5px;color:var(--sepia-lt);">4 event</span></div>
              <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:0.5px dashed var(--cream-dk);"><span style="font-family:var(--alt-serif);font-size:13px;color:var(--ink);">Workshop</span><span style="font-family:var(--mono);font-size:8.5px;color:var(--sepia-lt);">3 event</span></div>
              <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:0.5px dashed var(--cream-dk);"><span style="font-family:var(--alt-serif);font-size:13px;color:var(--ink);">Diskusi &amp; Seminar</span><span style="font-family:var(--mono);font-size:8.5px;color:var(--sepia-lt);">6 event</span></div>
              <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;"><span style="font-family:var(--alt-serif);font-size:13px;color:var(--ink);">Edukasi Sekolah</span><span style="font-family:var(--mono);font-size:8.5px;color:var(--sepia-lt);">8 event</span></div>
            </div>
          </div>
          <div style="border-top:0.5px solid var(--cream-dk);padding-top:20px;">
            <div class="sidebar-title">Selenggarakan Event</div>
            <p style="font-family:var(--alt-serif);font-size:12.5px;font-weight:300;line-height:1.65;color:#ffffff;margin-top:8px;margin-bottom:16px;">Museum menyediakan ruang untuk penyelenggaraan kegiatan publik yang berkaitan dengan sejarah dan kebudayaan.</p>
            <button class="btn-primary" style="width:100%;text-align:center;" onclick="showPage('peminjaman')">Peminjaman Ruang →</button>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- ════════════════════════════════════════════
     PAGE: BERITA
════════════════════════════════════════════ -->
<div id="page-berita" class="page">
  <div class="page-banner">
    <div class="container">
      <div class="page-banner-inner">
        <div>
          <div class="page-banner-breadcrumb">Museum Kota Samarinda / Berita</div>
          <h1 class="page-banner-title">Berita &amp; <em>Artikel</em></h1>
          <p class="page-banner-desc">Informasi terbaru, pengumuman resmi, dan artikel tentang koleksi, kegiatan, dan perkembangan museum.</p>
        </div>
      </div>
    </div>
  </div>

  <section class="section">
    <div class="container">
      <div class="section-header">
        <div><div class="label" style="margin-bottom:8px;">Publikasi Terbaru</div><h2 class="section-title">Semua <em>Berita</em></h2></div>
        <div class="koleksi-filter">
          <button class="filter-btn active">Semua</button>
          <button class="filter-btn">Koleksi Baru</button>
          <button class="filter-btn">Kerjasama</button>
          <button class="filter-btn">Fasilitas</button>
          <button class="filter-btn">Event</button>
        </div>
      </div>

      <!-- Featured Article -->
      <div class="berita-full-grid" style="margin-bottom:1px;">
        <div class="berita-featured">
          <div>
            <div class="bf-badge">Berita Utama</div>
            <div class="bf-title">Naskah Lontar Abad ke-17 Resmi Masuk Katalog Museum Setelah Restorasi Enam Bulan</div>
            <div class="bf-body">Proses restorasi panjang yang melibatkan tim konservator dari Balai Pelestarian Cagar Budaya berhasil memulihkan naskah lontar langka ini. Kini tersedia secara digital untuk peneliti dan publik.</div>
            <div style="margin-top:24px;display:flex;align-items:center;gap:20px;">
              <span style="font-family:var(--mono);font-size:8.5px;letter-spacing:0.12em;text-transform:uppercase;color:var(--sepia-lt);">14 Maret 2025</span>
              <button class="card-link">Baca Selengkapnya</button>
            </div>
          </div>
          <div class="bf-img"><div class="inner-pattern"></div><svg width="100" height="100" viewBox="0 0 100 100" style="opacity:0.1;"><rect x="20" y="15" width="60" height="70" fill="none" stroke="#7a6a4a" stroke-width="1"/><line x1="30" y1="30" x2="70" y2="30" stroke="#7a6a4a" stroke-width="0.8"/><line x1="30" y1="40" x2="70" y2="40" stroke="#7a6a4a" stroke-width="0.8"/><line x1="30" y1="50" x2="65" y2="50" stroke="#7a6a4a" stroke-width="0.8"/><line x1="30" y1="60" x2="70" y2="60" stroke="#7a6a4a" stroke-width="0.8"/></svg></div>
        </div>
      </div>

      <div class="berita-list-full" style="border:0.5px solid var(--cream-dk);background:var(--cream-dk);">
        <div class="berita-full-item">
          <div class="bfi-img"><div class="inner-pattern"></div></div>
          <div class="bfi-content"><div class="bfi-cat">Kerjasama</div><div class="bfi-title">Museum Tanda Tangani MoU dengan Universitas Mulawarman untuk Penelitian Kolaboratif</div><div class="bfi-snippet">Perjanjian kerja sama ini membuka akses penelitian bagi mahasiswa dan dosen untuk mempelajari koleksi artefak secara langsung. Program residensi peneliti juga direncanakan mulai semester ganjil 2025.</div><div class="bfi-date">8 Maret 2025</div></div>
        </div>
        <div class="berita-full-item">
          <div class="bfi-img"><div class="inner-pattern"></div></div>
          <div class="bfi-content"><div class="bfi-cat">Fasilitas</div><div class="bfi-title">Renovasi Ruang Pameran IV Selesai: Pencahayaan Museum-Grade dan Sistem Sirkulasi Baru</div><div class="bfi-snippet">Ruang pameran yang diperbarui menghadirkan pengalaman melihat koleksi yang lebih baik dengan pencahayaan LED tanpa UV dan sistem HVAC yang menjaga kelembapan optimal.</div><div class="bfi-date">1 Maret 2025</div></div>
        </div>
        <div class="berita-full-item">
          <div class="bfi-img"><div class="inner-pattern"></div></div>
          <div class="bfi-content"><div class="bfi-cat">Koleksi Baru</div><div class="bfi-title">Mandau Langka Berusia 250 Tahun Diserahkan oleh Lembaga Adat Dayak Benuaq</div><div class="bfi-snippet">Lembaga Adat Dayak Benuaq Kutai Barat menyerahkan mandau upacara berusia lebih dari dua abad kepada museum sebagai bentuk kepercayaan pelestarian warisan budaya.</div><div class="bfi-date">22 Februari 2025</div></div>
        </div>
        <div class="berita-full-item">
          <div class="bfi-img"><div class="inner-pattern"></div></div>
          <div class="bfi-content"><div class="bfi-cat">Event</div><div class="bfi-title">Workshop Batik Kalimantan Pertama Berhasil Diselenggarakan: 30 Pelajar Berpartisipasi</div><div class="bfi-snippet">Workshop perdana membatik dengan motif khas Kalimantan Timur disambut antusias. Peserta belajar motif naga dan burung enggang dari pengrajin batik lokal berpengalaman.</div><div class="bfi-date">15 Februari 2025</div></div>
        </div>
        <div class="berita-full-item">
          <div class="bfi-img"><div class="inner-pattern"></div></div>
          <div class="bfi-content"><div class="bfi-cat">Penghargaan</div><div class="bfi-title">Museum Kota Samarinda Raih Penghargaan Museum Terbaik Kalimantan 2024 dari Kemendikbud</div><div class="bfi-snippet">Penghargaan ini diberikan atas inovasi program edukasi dan keberhasilan digitalisasi koleksi yang menjadi model bagi museum daerah lain di Indonesia Timur.</div><div class="bfi-date">3 Januari 2025</div></div>
        </div>
      </div>

      <div style="display:flex;justify-content:center;margin-top:40px;">
        <button class="btn-ghost" style="padding:12px 40px;">Muat Lebih Banyak Berita ↓</button>
      </div>
    </div>
  </section>
</div>

<!-- ════════════════════════════════════════════
     PAGE: PETA LOKASI
════════════════════════════════════════════ -->
<div id="page-peta" class="page">
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
        <!-- SVG Map -->
        <div class="peta-map">
          <svg viewBox="0 0 600 480" xmlns="http://www.w3.org/2000/svg" style="width:100%;height:100%;min-height:480px;">
            <!-- Background -->
            <rect width="600" height="480" fill="#ede3d0"/>
            <!-- Dot pattern -->
            <defs>
              <pattern id="dots" width="20" height="20" patternUnits="userSpaceOnUse">
                <circle cx="2" cy="2" r="0.8" fill="rgba(90,72,42,0.12)"/>
              </pattern>
            </defs>
            <rect width="600" height="480" fill="url(#dots)"/>
            
            <!-- Sungai Mahakam (bottom) -->
            <path d="M0 420 Q150 400 300 415 Q450 430 600 410 L600 480 L0 480 Z" fill="rgba(90,120,160,0.18)" stroke="rgba(90,120,160,0.35)" stroke-width="0.5"/>
            <text x="300" y="450" text-anchor="middle" class="map-label" fill="rgba(90,120,160,0.7)" font-family="'DM Mono','Courier New',monospace" font-size="9" letter-spacing="2">SUNGAI MAHAKAM</text>

            <!-- Roads -->
            <!-- Jl Bhayangkara (main - vertical) -->
            <rect x="200" y="0" width="28" height="480" fill="#ddd0b8" opacity="0.9"/>
            <text x="214" y="100" text-anchor="middle" class="map-label-main" font-family="'DM Mono','Courier New',monospace" font-size="8" letter-spacing="1.5" fill="#5a4830" transform="rotate(-90,214,100)">JL. BHAYANGKARA</text>

            <!-- Horizontal roads -->
            <rect x="0" y="180" width="600" height="22" fill="#ddd0b8" opacity="0.7"/>
            <text x="520" y="194" class="map-label" font-family="'DM Mono','Courier New',monospace" font-size="7.5" letter-spacing="1.2" fill="#7a6a4a">JL. AWANG LONG</text>

            <rect x="0" y="290" width="600" height="18" fill="#ddd0b8" opacity="0.6"/>
            <text x="30" y="302" class="map-label" font-family="'DM Mono','Courier New',monospace" font-size="7.5" letter-spacing="1.2" fill="#7a6a4a">JL. S. PARMAN</text>

            <!-- Secondary roads -->
            <rect x="320" y="0" width="16" height="300" fill="#e5dac8" opacity="0.7"/>
            <rect x="100" y="0" width="14" height="420" fill="#e5dac8" opacity="0.6"/>
            <rect x="0" y="100" width="600" height="14" fill="#e5dac8" opacity="0.5"/>
            <rect x="0" y="350" width="600" height="12" fill="#e5dac8" opacity="0.5"/>

            <!-- City blocks -->
            <!-- Block NW -->
            <rect x="20" y="20" width="70" height="70" rx="2" fill="#e0d4bc" stroke="#c8b99a" stroke-width="0.5"/>
            <rect x="20" y="115" width="70" height="56" rx="2" fill="#e0d4bc" stroke="#c8b99a" stroke-width="0.5"/>
            <!-- Block NE of Bhayangkara -->
            <rect x="238" y="20" width="72" height="70" rx="2" fill="#e0d4bc" stroke="#c8b99a" stroke-width="0.5"/>
            <rect x="238" y="115" width="72" height="56" rx="2" fill="#e0d4bc" stroke="#c8b99a" stroke-width="0.5"/>
            <rect x="345" y="20" width="60" height="70" rx="2" fill="#e0d4bc" stroke="#c8b99a" stroke-width="0.5"/>
            <rect x="345" y="115" width="60" height="56" rx="2" fill="#e0d4bc" stroke="#c8b99a" stroke-width="0.5"/>
            <rect x="420" y="20" width="80" height="70" rx="2" fill="#e0d4bc" stroke="#c8b99a" stroke-width="0.5"/>
            <rect x="420" y="115" width="80" height="56" rx="2" fill="#e0d4bc" stroke="#c8b99a" stroke-width="0.5"/>
            <rect x="510" y="20" width="75" height="150" rx="2" fill="#e0d4bc" stroke="#c8b99a" stroke-width="0.5"/>

            <!-- South blocks -->
            <rect x="20" y="210" width="70" height="70" rx="2" fill="#e0d4bc" stroke="#c8b99a" stroke-width="0.5"/>
            <rect x="20" y="310" width="70" height="32" rx="2" fill="#e0d4bc" stroke="#c8b99a" stroke-width="0.5"/>
            <rect x="238" y="210" width="72" height="70" rx="2" fill="#e0d4bc" stroke="#c8b99a" stroke-width="0.5"/>
            <rect x="238" y="310" width="72" height="32" rx="2" fill="#e0d4bc" stroke="#c8b99a" stroke-width="0.5"/>
            <rect x="345" y="210" width="60" height="70" rx="2" fill="#e0d4bc" stroke="#c8b99a" stroke-width="0.5"/>
            <rect x="420" y="210" width="80" height="70" rx="2" fill="#e0d4bc" stroke="#c8b99a" stroke-width="0.5"/>
            <rect x="510" y="210" width="75" height="70" rx="2" fill="#e0d4bc" stroke="#c8b99a" stroke-width="0.5"/>
            <rect x="120" y="210" width="70" height="70" rx="2" fill="#e0d4bc" stroke="#c8b99a" stroke-width="0.5"/>

            <!-- Park / Taman -->
            <rect x="120" y="20" width="70" height="150" rx="3" fill="rgba(61,82,64,0.12)" stroke="rgba(61,82,64,0.3)" stroke-width="0.8"/>
            <text x="155" y="90" text-anchor="middle" class="map-label" font-family="'DM Mono','Courier New',monospace" font-size="7" letter-spacing="1" fill="rgba(61,82,64,0.7)">TAMAN</text>

            <!-- MUSEUM BUILDING (highlighted) -->
            <rect x="203" y="183" width="140" height="100" fill="#1e1a14" rx="2"/>
            <rect x="207" y="187" width="132" height="92" fill="#2e2820" rx="1"/>
            <!-- Museum internal details -->
            <rect x="215" y="195" width="50" height="36" fill="rgba(244,237,224,0.08)" stroke="rgba(244,237,224,0.15)" stroke-width="0.5"/>
            <rect x="275" y="195" width="56" height="36" fill="rgba(244,237,224,0.08)" stroke="rgba(244,237,224,0.15)" stroke-width="0.5"/>
            <rect x="215" y="237" width="116" height="36" fill="rgba(244,237,224,0.05)" stroke="rgba(244,237,224,0.1)" stroke-width="0.5"/>
            <text x="273" y="280" text-anchor="middle" font-family="'DM Mono','Courier New',monospace" font-size="7.5" letter-spacing="1.5" fill="rgba(244,237,224,0.6)">MUSEUM</text>

            <!-- Pin marker -->
            <circle cx="273" cy="190" r="12" fill="#7a3e28" opacity="0.9"/>
            <circle cx="273" cy="190" r="5" fill="white" opacity="0.9"/>
            <circle cx="273" cy="185" r="12" fill="#7a3e28"/>
            <circle cx="273" cy="185" r="5" fill="white"/>
            <path d="M273 197 L269 210 L273 206 L277 210 Z" fill="#7a3e28"/>

            <!-- Label museum -->
            <rect x="290" y="165" width="130" height="30" rx="2" fill="white" opacity="0.9"/>
            <text x="298" y="178" font-family="'Cormorant Garamond',Georgia,serif" font-size="11" fill="#1e1a14">Museum Kota Samarinda</text>
            <text x="298" y="190" font-family="'DM Mono','Courier New',monospace" font-size="7.5" letter-spacing="1" fill="#7a6a4a">JL. BHAYANGKARA NO. 1</text>
            <line x1="290" y1="180" x2="285" y2="185" stroke="#7a3e28" stroke-width="1"/>

            <!-- Compass -->
            <g transform="translate(555,435)">
              <circle r="22" fill="rgba(244,237,224,0.85)" stroke="#c8b99a" stroke-width="0.5"/>
              <path d="M0 -16 L4 0 L0 4 L-4 0 Z" fill="#7a3e28"/>
              <path d="M0 16 L4 0 L0 -4 L-4 0 Z" fill="#c8b99a"/>
              <text y="-18" text-anchor="middle" font-family="'DM Mono','Courier New',monospace" font-size="8" fill="#1e1a14">U</text>
            </g>

            <!-- Scale -->
            <line x1="30" y1="460" x2="130" y2="460" stroke="#7a6a4a" stroke-width="1"/>
            <line x1="30" y1="456" x2="30" y2="464" stroke="#7a6a4a" stroke-width="1"/>
            <line x1="130" y1="456" x2="130" y2="464" stroke="#7a6a4a" stroke-width="1"/>
            <text x="80" y="455" text-anchor="middle" font-family="'DM Mono','Courier New',monospace" font-size="7" fill="#7a6a4a">200 m</text>
          </svg>
        </div>

        <!-- Info Sidebar -->
        <div class="peta-sidebar">
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
              <div><div class="ps-info-key">Parkir</div><div class="ps-info-val">Tersedia di halaman museum (gratis)</div></div>
            </div>
            <div class="ps-info-row">
              <div class="ps-icon">♿</div>
              <div><div class="ps-info-key">Aksesibilitas</div><div class="ps-info-val">Ramah kursi roda · Ramp tersedia di semua pintu masuk</div></div>
            </div>
          </div>
          <div class="ps-footer">
            <button class="btn-primary" style="width:100%;text-align:center;">Buka di Google Maps ↗</button>
            <button class="btn-ghost" style="width:100%;text-align:center;">Unduh Peta Museum (PDF)</button>
          </div>
        </div>
      </div>

      <!-- Transport -->
      <div style="margin-top:48px;">
        <div class="section-header">
          <div><div class="label" style="margin-bottom:8px;">Cara Menuju Museum</div><h2 class="section-title">Transportasi &amp; <em>Akses</em></h2></div>
        </div>
        <div class="transport-grid">
          <div class="transport-card">
            <div class="tc-icon">🚗</div>
            <div class="tc-title">Kendaraan Pribadi</div>
            <div class="tc-body">Museum terletak di Jl. Bhayangkara, akses mudah dari Jembatan Mahakam (±5 menit). Tersedia parkir gratis di halaman museum untuk mobil dan motor.</div>
          </div>
          <div class="transport-card" style="background:var(--parchment);">
            <div class="tc-icon">🚌</div>
            <div class="tc-title">Angkutan Umum</div>
            <div class="tc-body">Angkot trayek C lewat Jl. Bhayangkara berhenti tepat di depan museum. Dari Terminal Samarinda Seberang, naik angkot trayek A–C (±20 menit, Rp 5.000).</div>
          </div>
          <div class="transport-card">
            <div class="tc-icon">🛺</div>
            <div class="tc-title">Ojek &amp; Taksi Online</div>
            <div class="tc-body">Museum dapat dijangkau dengan Grab, Gojek, dan ojek konvensional. Titik penjemputan: "Museum Kota Samarinda, Jl. Bhayangkara". Estimasi dari pusat kota: 5–10 menit.</div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- ════════════════════════════════════════════
     PAGE: PEMINJAMAN RUANG
════════════════════════════════════════════ -->
<div id="page-peminjaman" class="page">
  <div class="page-banner">
    <div class="container">
      <div class="page-banner-inner">
        <div>
          <div class="page-banner-breadcrumb">Museum Kota Samarinda / Peminjaman Ruang</div>
          <h1 class="page-banner-title">Peminjaman <em>Ruang</em></h1>
          <p class="page-banner-desc">Selenggarakan acara Anda di museum bersejarah kota Samarinda. Tersedia berbagai pilihan ruang untuk kegiatan budaya, pendidikan, dan korporat.</p>
        </div>
      </div>
    </div>
  </div>

  <section class="section">
    <div class="container">
      <div class="section-header">
        <div><div class="label" style="margin-bottom:8px;">Fasilitas</div><h2 class="section-title">Pilihan <em>Ruang</em></h2></div>
      </div>

      <div class="ruang-grid">
        <div class="ruang-card">
          <div class="ruang-img"><div class="inner-pattern"></div><svg width="80" height="80" viewBox="0 0 80 80" style="opacity:0.12;"><rect x="10" y="20" width="60" height="42" fill="none" stroke="#7a6a4a" stroke-width="1"/><rect x="15" y="25" width="50" height="12" fill="#7a6a4a" opacity="0.2"/><line x1="40" y1="25" x2="40" y2="62" stroke="#7a6a4a" stroke-width="0.5"/></svg></div>
          <div class="ruang-body">
            <div class="ruang-name">Aula Utama</div>
            <div class="ruang-cap">Kapasitas: 150 Orang · 320 m²</div>
            <div class="ruang-desc">Ruang multifungsi megah dengan langit-langit tinggi 6 meter dan arsitektur heritage. Ideal untuk konferensi, seminar besar, pertunjukan seni, dan resepsi.</div>
            <div class="ruang-features">
              <span class="ruang-feat">Proyektor HD</span><span class="ruang-feat">Sound System</span><span class="ruang-feat">AC Sentral</span><span class="ruang-feat">WiFi</span><span class="ruang-feat">Panggung</span>
            </div>
            <div class="ruang-price">Rp 3.500.000 <span>/ hari (non-profit: Rp 1.500.000)</span></div>
          </div>
        </div>

        <div class="ruang-card" style="">
          <div class="ruang-img" style="background:var(--vellum);"><div class="inner-pattern"></div><svg width="80" height="80" viewBox="0 0 80 80" style="opacity:0.12;"><rect x="15" y="20" width="50" height="40" fill="none" stroke="#7a6a4a" stroke-width="1"/><rect x="25" y="27" width="30" height="18" fill="#7a6a4a" opacity="0.15"/></svg></div>
          <div class="ruang-body">
            <div class="ruang-name">Ruang Seminar</div>
            <div class="ruang-cap">Kapasitas: 60 Orang · 120 m²</div>
            <div class="ruang-desc">Ruang seminar profesional dengan pencahayaan alami dan sistem akustik optimal. Tersedia layout kelas, teater, dan U-shape sesuai kebutuhan acara.</div>
            <div class="ruang-features">
              <span class="ruang-feat">Proyektor</span><span class="ruang-feat">Whiteboard</span><span class="ruang-feat">Mikrofon</span><span class="ruang-feat">WiFi</span>
            </div>
            <div class="ruang-price">Rp 1.800.000 <span>/ hari (non-profit: Rp 800.000)</span></div>
          </div>
        </div>

        <div class="ruang-card">
          <div class="ruang-img"><div class="inner-pattern"></div><svg width="80" height="80" viewBox="0 0 80 80" style="opacity:0.12;"><circle cx="40" cy="40" r="22" fill="none" stroke="#7a6a4a" stroke-width="1"/><circle cx="40" cy="40" r="10" fill="#7a6a4a" opacity="0.15"/></svg></div>
          <div class="ruang-body">
            <div class="ruang-name">Ruang Edukasi</div>
            <div class="ruang-cap">Kapasitas: 35 Orang · 80 m²</div>
            <div class="ruang-desc">Dirancang untuk kegiatan workshop, pelatihan, dan kelas interaktif. Dilengkapi meja kerja fleksibel dan wastafel untuk kegiatan hands-on.</div>
            <div class="ruang-features">
              <span class="ruang-feat">Meja Workshop</span><span class="ruang-feat">Wastafel</span><span class="ruang-feat">Lemari Bahan</span><span class="ruang-feat">Proyektor</span>
            </div>
            <div class="ruang-price">Rp 1.200.000 <span>/ hari (non-profit: Rp 500.000)</span></div>
          </div>
        </div>

        <div class="ruang-card" style="">
          <div class="ruang-img" style="background:var(--vellum);"><div class="inner-pattern"></div><svg width="80" height="80" viewBox="0 0 80 80" style="opacity:0.12;"><rect x="20" y="15" width="40" height="50" fill="none" stroke="#7a6a4a" stroke-width="1"/><rect x="25" y="20" width="12" height="18" fill="#7a6a4a" opacity="0.15"/><rect x="43" y="20" width="12" height="18" fill="#7a6a4a" opacity="0.15"/></svg></div>
          <div class="ruang-body">
            <div class="ruang-name">Ruang Diskusi</div>
            <div class="ruang-cap">Kapasitas: 20 Orang · 48 m²</div>
            <div class="ruang-desc">Ruang pertemuan intim dengan meja oval dan kursi eksekutif. Ideal untuk rapat kecil, diskusi kelompok terfokus, dan sesi wawancara penelitian.</div>
            <div class="ruang-features">
              <span class="ruang-feat">Smart TV</span><span class="ruang-feat">Konferensi Video</span><span class="ruang-feat">WiFi</span>
            </div>
            <div class="ruang-price">Rp 700.000 <span>/ hari (non-profit: Rp 300.000)</span></div>
          </div>
        </div>

        <div class="ruang-card">
          <div class="ruang-img"><div class="inner-pattern"></div><svg width="80" height="80" viewBox="0 0 80 80" style="opacity:0.12;"><rect x="10" y="10" width="60" height="60" fill="none" stroke="#7a6a4a" stroke-width="1"/><path d="M10 40 L40 15 L70 40" fill="none" stroke="#7a6a4a" stroke-width="0.8"/></svg></div>
          <div class="ruang-body">
            <div class="ruang-name">Ruang Pameran Temporer</div>
            <div class="ruang-cap">Area: 200 m² · Modular</div>
            <div class="ruang-desc">Ruang pameran profesional dengan sistem pencahayaan museum-grade, panel display modular, dan kontrol iklim untuk keamanan karya seni dan artefak.</div>
            <div class="ruang-features">
              <span class="ruang-feat">Pencahayaan Museum</span><span class="ruang-feat">Panel Modular</span><span class="ruang-feat">Kontrol Iklim</span><span class="ruang-feat">Keamanan 24 jam</span>
            </div>
            <div class="ruang-price">Rp 5.000.000 <span>/ minggu</span></div>
          </div>
        </div>

        <div class="ruang-card" style="">
          <div class="ruang-img" style="background:var(--vellum);"><div class="inner-pattern"></div><svg width="80" height="80" viewBox="0 0 80 80" style="opacity:0.12;"><path d="M10 60 Q40 10 70 60" fill="none" stroke="#7a6a4a" stroke-width="1"/><path d="M20 60 Q40 25 60 60" fill="#7a6a4a" opacity="0.08"/></svg></div>
          <div class="ruang-body">
            <div class="ruang-name">Teras Heritage</div>
            <div class="ruang-cap">Kapasitas: 80 Orang · Outdoor</div>
            <div class="ruang-desc">Teras outdoor di bangunan heritage dengan pemandangan taman. Sempurna untuk acara evening, peluncuran produk, dan resepsi dengan nuansa bersejarah yang unik.</div>
            <div class="ruang-features">
              <span class="ruang-feat">Tenda Tersedia</span><span class="ruang-feat">Lampu Taman</span><span class="ruang-feat">Catering Ready</span>
            </div>
            <div class="ruang-price">Rp 2.000.000 <span>/ hari</span></div>
          </div>
        </div>
      </div>

      <!-- Jadwal Ketersediaan -->
      <div style="margin-top:48px;">
        <div class="section-header">
          <div><div class="label" style="margin-bottom:8px;">April 2025</div><h2 class="section-title">Jadwal <em>Ketersediaan</em></h2></div>
        </div>
        <div class="schedule-grid">
          <div class="sch-header"></div>
          <div class="sch-header">Sen 7</div>
          <div class="sch-header">Sel 8</div>
          <div class="sch-header">Rab 9</div>
          <div class="sch-header">Kam 10</div>
          <div class="sch-header">Jum 11</div>
          <div class="sch-header">Sab 12</div>
          <div class="sch-header">Min 13</div>

          <div class="sch-time">Aula Utama</div>
          <div class="sch-cell" style="background:rgba(61,82,64,0.07);"></div>
          <div class="sch-cell booked"><span class="sch-cell-booked" style="font-family:var(--mono);font-size:7px;color:var(--rust);">Seminar Unmul</span></div>
          <div class="sch-cell booked"><span class="sch-cell-booked" style="font-family:var(--mono);font-size:7px;color:var(--rust);">Seminar Unmul</span></div>
          <div class="sch-cell" style="background:rgba(61,82,64,0.07);"></div>
          <div class="sch-cell" style="background:rgba(61,82,64,0.07);"></div>
          <div class="sch-cell" style="background:rgba(61,82,64,0.07);"></div>
          <div class="sch-cell" style="background:rgba(61,82,64,0.07);"></div>

          <div class="sch-time">R. Seminar</div>
          <div class="sch-cell" style="background:rgba(61,82,64,0.07);"></div>
          <div class="sch-cell" style="background:rgba(61,82,64,0.07);"></div>
          <div class="sch-cell" style="background:rgba(61,82,64,0.07);"></div>
          <div class="sch-cell booked"><span class="sch-cell-booked" style="font-family:var(--mono);font-size:7px;color:var(--rust);">Workshop BPK</span></div>
          <div class="sch-cell" style="background:rgba(61,82,64,0.07);"></div>
          <div class="sch-cell" style="background:rgba(61,82,64,0.07);"></div>
          <div class="sch-cell" style="background:rgba(61,82,64,0.07);"></div>

          <div class="sch-time">R. Edukasi</div>
          <div class="sch-cell" style="background:rgba(61,82,64,0.07);"></div>
          <div class="sch-cell" style="background:rgba(61,82,64,0.07);"></div>
          <div class="sch-cell" style="background:rgba(61,82,64,0.07);"></div>
          <div class="sch-cell" style="background:rgba(61,82,64,0.07);"></div>
          <div class="sch-cell booked"><span class="sch-cell-booked" style="font-family:var(--mono);font-size:7px;color:var(--rust);">Workshop SD N 5</span></div>
          <div class="sch-cell" style="background:rgba(61,82,64,0.07);"></div>
          <div class="sch-cell" style="background:rgba(61,82,64,0.07);"></div>

          <div class="sch-time">Teras Heritage</div>
          <div class="sch-cell" style="background:rgba(61,82,64,0.07);"></div>
          <div class="sch-cell" style="background:rgba(61,82,64,0.07);"></div>
          <div class="sch-cell" style="background:rgba(61,82,64,0.07);"></div>
          <div class="sch-cell" style="background:rgba(61,82,64,0.07);"></div>
          <div class="sch-cell" style="background:rgba(61,82,64,0.07);"></div>
          <div class="sch-cell booked"><span class="sch-cell-booked" style="font-family:var(--mono);font-size:7px;color:var(--rust);">Gathering Korp. B</span></div>
          <div class="sch-cell" style="background:rgba(61,82,64,0.07);"></div>
        </div>
        <div style="display:flex;align-items:center;gap:20px;margin-top:12px;">
          <div style="display:flex;align-items:center;gap:8px;"><div style="width:16px;height:10px;background:rgba(61,82,64,0.12);border:0.5px solid rgba(61,82,64,0.3);"></div><span style="font-family:var(--mono);font-size:8px;letter-spacing:0.12em;text-transform:uppercase;color:#ffffff;">Tersedia</span></div>
          <div style="display:flex;align-items:center;gap:8px;"><div style="width:16px;height:10px;background:rgba(122,62,40,0.12);border:0.5px solid rgba(122,62,40,0.3);"></div><span style="font-family:var(--mono);font-size:8px;letter-spacing:0.12em;text-transform:uppercase;color:#ffffff;">Sudah Dipesan</span></div>
        </div>
      </div>

      <!-- Form Peminjaman -->
      <div class="form-section">
        <div class="form-header">
          <div class="label" style="margin-bottom:8px;">Pengajuan Resmi</div>
          <div class="form-title">Formulir <em>Peminjaman Ruang</em></div>
        </div>
        <div class="form-body">
          <div class="form-group">
            <label class="form-label">Nama Lengkap / Organisasi</label>
            <input type="text" class="form-input" placeholder="Nama pemohon atau institusi">
          </div>
          <div class="form-group">
            <label class="form-label">Nomor Telepon</label>
            <input type="tel" class="form-input" placeholder="08xx-xxxx-xxxx">
          </div>
          <div class="form-group">
            <label class="form-label">Alamat Email</label>
            <input type="email" class="form-input" placeholder="email@domain.com">
          </div>
          <div class="form-group">
            <label class="form-label">Pilih Ruang</label>
            <select class="form-select">
              <option value="">-- Pilih Ruang --</option>
              <option>Ruang Pameran Temporer</option>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Tanggal Pelaksanaan</label>
            <input type="date" class="form-input">
          </div>
          <div class="form-group">
            <label class="form-label">Durasi</label>
            <select class="form-select">
              <option>½ Hari (Pagi: 08:00–12:00)</option>
              <option>½ Hari (Sore: 13:00–17:00)</option>
              <option>1 Hari Penuh (08:00–17:00)</option>
              <option>2–3 Hari</option>
              <option>1 Minggu</option>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Jenis Kegiatan</label>
            <select class="form-select">
              <option>Seminar / Konferensi</option>
              <option>Workshop / Pelatihan</option>
              <option>Pameran Seni / Budaya</option>
              <option>Acara Korporat</option>
              <option>Penelitian / Akademik</option>
              <option>Lainnya</option>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Perkiraan Jumlah Peserta</label>
            <input type="number" class="form-input" placeholder="Jumlah orang">
          </div>
          <div class="form-group form-full">
            <label class="form-label">Deskripsi Kegiatan</label>
            <textarea class="form-textarea" placeholder="Jelaskan tujuan, program, dan kebutuhan khusus kegiatan Anda..."></textarea>
          </div>
        </div>
        <div class="form-footer">
          <button class="btn-primary">Kirim Permohonan →</button>
          <p class="form-note">Permohonan akan diproses dalam 2–3 hari kerja. Konfirmasi dikirim via email.</p>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- ════════════════════════════════════════════
     PAGE: ULASAN
════════════════════════════════════════════ -->
<div id="page-ulasan" class="page">
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
      <!-- Summary -->
      <div class="ulasan-summary">
        <div class="us-score">
          <div class="us-num">4.7</div>
          <div class="us-stars">
            <div class="us-star"></div><div class="us-star"></div><div class="us-star"></div><div class="us-star"></div><div class="us-star" style="background:rgba(168,149,110,0.4);"></div>
          </div>
          <div class="us-count">dari 284 ulasan</div>
        </div>
        <div class="us-bars">
          <div style="font-family:var(--mono);font-size:9px;letter-spacing:0.14em;text-transform:uppercase;color:#ffffff;margin-bottom:8px;">Distribusi Rating</div>
          <div class="bar-row">
            <div class="bar-label">5 Bintang</div>
            <div class="bar-track"><div class="bar-fill" style="width:68%;"></div></div>
            <div class="bar-count" style="font-family:var(--mono);font-size:8.5px;color:var(--sepia-lt);">193</div>
          </div>
          <div class="bar-row">
            <div class="bar-label">4 Bintang</div>
            <div class="bar-track"><div class="bar-fill" style="width:22%;"></div></div>
            <div class="bar-count" style="font-family:var(--mono);font-size:8.5px;color:var(--sepia-lt);">62</div>
          </div>
          <div class="bar-row">
            <div class="bar-label">3 Bintang</div>
            <div class="bar-track"><div class="bar-fill" style="width:7%;"></div></div>
            <div class="bar-count" style="font-family:var(--mono);font-size:8.5px;color:var(--sepia-lt);">20</div>
          </div>
          <div class="bar-row">
            <div class="bar-label">2 Bintang</div>
            <div class="bar-track"><div class="bar-fill" style="width:2%;"></div></div>
            <div class="bar-count" style="font-family:var(--mono);font-size:8.5px;color:var(--sepia-lt);">5</div>
          </div>
          <div class="bar-row">
            <div class="bar-label">1 Bintang</div>
            <div class="bar-track"><div class="bar-fill" style="width:1%;"></div></div>
            <div class="bar-count" style="font-family:var(--mono);font-size:8.5px;color:var(--sepia-lt);">4</div>
          </div>
        </div>
      </div>

      <div class="section-header" style="margin-top:48px;">
        <div><div class="label" style="margin-bottom:8px;">284 Ulasan</div><h2 class="section-title">Ulasan <em>Pengunjung</em></h2></div>
        <div class="koleksi-filter">
          <button class="filter-btn active">Terbaru</button>
          <button class="filter-btn">5 ★</button>
          <button class="filter-btn">4 ★</button>
          <button class="filter-btn">Kritis</button>
        </div>
      </div>

      <div class="ulasan-full-grid">
        <div class="ulasan-full-card">
          <div class="ulasan-stars"><div class="star"></div><div class="star"></div><div class="star"></div><div class="star"></div><div class="star"></div></div>
          <div class="ulasan-text">"Sangat informatif dan terorganisir dengan baik. Koleksi mandau dan naskah kuno benar-benar membuat saya kagum dengan kekayaan sejarah Kalimantan. Pemandunya juga sangat berpengetahuan dan sabar menjawab pertanyaan."</div>
          <div class="ulasan-meta"><span class="ulasan-name">Rina Kusumawati</span><span class="ulasan-date">12 Mar 2025</span></div>
        </div>
        <div class="ulasan-full-card" style="background:var(--parchment);">
          <div class="ulasan-stars"><div class="star"></div><div class="star"></div><div class="star"></div><div class="star"></div><div class="star empty"></div></div>
          <div class="ulasan-text">"Tempatnya bersih dan staf sangat ramah dalam menjelaskan setiap koleksi. Cocok untuk kunjungan keluarga dan edukasi anak-anak tentang sejarah lokal. Fasilitas parkir perlu diperluas karena cukup penuh saat weekend."</div>
          <div class="ulasan-meta"><span class="ulasan-name">Budi Santoso</span><span class="ulasan-date">5 Mar 2025</span></div>
        </div>
        <div class="ulasan-full-card">
          <div class="ulasan-stars"><div class="star"></div><div class="star"></div><div class="star"></div><div class="star"></div><div class="star"></div></div>
          <div class="ulasan-text">"Pameran Warisan Dayak sungguh luar biasa. Saya tidak menyangka museum kota bisa seprofesional ini. Label deskripsi koleksi sangat informatif dan disajikan dalam dua bahasa. Wajib dikunjungi saat ke Samarinda!"</div>
          <div class="ulasan-meta"><span class="ulasan-name">Ahmad Fauzi</span><span class="ulasan-date">28 Feb 2025</span></div>
        </div>
        <div class="ulasan-full-card" style="background:var(--parchment);">
          <div class="ulasan-stars"><div class="star"></div><div class="star"></div><div class="star"></div><div class="star"></div><div class="star"></div></div>
          <div class="ulasan-text">"Sebagai peneliti sejarah Kalimantan, koleksi naskah kuno di sini sangat berharga. Akses untuk peneliti juga sangat difasilitasi dengan baik. Terima kasih atas kerjasama dengan Universitas Mulawarman."</div>
          <div class="ulasan-meta"><span class="ulasan-name">Dr. Nanda Surya, M.Hum.</span><span class="ulasan-date">20 Feb 2025</span></div>
        </div>
        <div class="ulasan-full-card">
          <div class="ulasan-stars"><div class="star"></div><div class="star"></div><div class="star"></div><div class="star empty"></div><div class="star empty"></div></div>
          <div class="ulasan-text">"Koleksinya bagus tapi informasi digital masih kurang interaktif. Berharap ada QR code di setiap koleksi yang langsung link ke info lebih lengkap. Ruang ber-AC dan bersih, tapi jam tutup agak terlalu cepat (15:00 Sabtu)."</div>
          <div class="ulasan-meta"><span class="ulasan-name">Yusuf Prasetya</span><span class="ulasan-date">15 Feb 2025</span></div>
        </div>
        <div class="ulasan-full-card" style="background:var(--parchment);">
          <div class="ulasan-stars"><div class="star"></div><div class="star"></div><div class="star"></div><div class="star"></div><div class="star"></div></div>
          <div class="ulasan-text">"Membawa rombongan 40 siswa SMA dan semuanya sangat terkesan. Program edukasi terpandu yang disediakan sangat sesuai dengan kurikulum sejarah. Salah satu kunjungan lapangan terbaik yang pernah kami lakukan."</div>
          <div class="ulasan-meta"><span class="ulasan-name">Ibu Santi, Guru SMA 3 Samarinda</span><span class="ulasan-date">10 Feb 2025</span></div>
        </div>
      </div>

      <div style="display:flex;justify-content:center;margin-top:40px;">
        <button class="btn-ghost" style="padding:12px 40px;">Muat Lebih Banyak Ulasan ↓</button>
      </div>

      <!-- Form Tulis Ulasan -->
      <div class="form-ulasan">
        <div class="fu-header">
          <div class="label" style="margin-bottom:8px;">Bagikan Pengalaman Anda</div>
          <div class="fu-title">Tulis <em>Ulasan</em></div>
        </div>
        <div class="fu-body">
          <div class="form-group">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" class="form-input" placeholder="Nama Anda">
          </div>
          <div class="form-group">
            <label class="form-label">Email (tidak dipublikasikan)</label>
            <input type="email" class="form-input" placeholder="email@domain.com">
          </div>
          <div class="form-group">
            <label class="form-label">Tanggal Kunjungan</label>
            <input type="date" class="form-input">
          </div>
          <div class="form-group">
            <label class="form-label">Rating Keseluruhan</label>
            <div class="star-select">
              <button class="star-btn selected" onclick="setRating(1)"></button>
              <button class="star-btn selected" onclick="setRating(2)"></button>
              <button class="star-btn selected" onclick="setRating(3)"></button>
              <button class="star-btn selected" onclick="setRating(4)"></button>
              <button class="star-btn" onclick="setRating(5)"></button>
              <span style="font-family:var(--mono);font-size:9px;letter-spacing:0.12em;color:var(--sepia-lt);margin-left:8px;">4 / 5</span>
            </div>
          </div>
          <div class="form-group fu-full">
            <label class="form-label">Ulasan Anda</label>
            <textarea class="form-textarea" style="min-height:120px;" placeholder="Bagikan pengalaman kunjungan Anda ke Museum Kota Samarinda..."></textarea>
          </div>
          <div class="form-group">
            <label class="form-label">Aspek yang Paling Disukai</label>
            <select class="form-select">
              <option>Koleksi Museum</option>
              <option>Pelayanan Staf</option>
              <option>Kebersihan &amp; Fasilitas</option>
              <option>Program Edukasi</option>
              <option>Lokasi &amp; Aksesibilitas</option>
            </select>
          </div>
        </div>
        <div class="fu-footer">
          <button class="btn-primary">Kirim Ulasan →</button>
          <p class="form-note">Ulasan akan ditinjau dalam 1–2 hari sebelum dipublikasikan.</p>
        </div>
      </div>
    </div>
  </section>
</div>

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
          <button class="footer-link" onclick="showPage('beranda')">Beranda</button>
          <button class="footer-link" onclick="showPage('tentang')">Tentang Museum</button>
          <button class="footer-link" onclick="showPage('koleksi')">Koleksi Digital</button>
          <button class="footer-link" onclick="showPage('event')">Event &amp; Kegiatan</button>
          <button class="footer-link" onclick="showPage('berita')">Berita</button>
        </div>
      </div>
      <div>
        <div class="footer-col-title">Layanan</div>
        <div class="footer-links">
          <button class="footer-link" onclick="showPage('peminjaman')">Peminjaman Ruang</button>
          <button class="footer-link" onclick="showPage('event')">Program Edukasi</button>
          <button class="footer-link" onclick="showPage('peta')">Peta Lokasi</button>
          <button class="footer-link" onclick="showPage('ulasan')">Tulis Ulasan</button>
        </div>
      </div>
      <div>
        <div class="footer-col-title">Informasi</div>
        <div class="footer-links">
          <button class="footer-link" onclick="showPage('peta')">Jam &amp; Tiket</button>
          <button class="footer-link" onclick="showPage('tentang')">Tentang Kami</button>
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

<script src="assets/js/page.js"></script>
<script src="assets/js/scroll-fade-in.js"></script>
</body>
</html>


