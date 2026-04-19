<?php 
require_once __DIR__ . '/config/auth.php';
require_once __DIR__ . '/config/db.php';

$pdo = getDB();

function format_tanggal_berita($tanggal) {
    if (!$tanggal) return '-';
    $ts = strtotime($tanggal);
    if (!$ts) return '-';
    $bulan = [1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'Mei',6=>'Jun',
              7=>'Jul',8=>'Agu',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des'];
    return date('j', $ts) . ' ' . $bulan[(int)date('n', $ts)] . ' ' . date('Y', $ts);
}

function potong_teks($text, $limit = 150) {
    $text = trim(strip_tags((string)$text));
    if (mb_strlen($text) <= $limit) return $text;
    return mb_substr($text, 0, $limit) . '...';
}

// Query semua berita
$beritaList = [];
try {
    $stmt = $pdo->prepare("
        SELECT id, judul, ringkasan, isi, thumbnail, kategori, tanggal_publish 
        FROM berita 
        ORDER BY tanggal_publish DESC, id DESC
    ");
    $stmt->execute();
    $beritaList = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Debug: hitung data
    $total_berita = count($beritaList);
} catch (Throwable $e) {
    error_log("Berita error: " . $e->getMessage());
    $total_berita = 0;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Berita & Artikel · Museum Kota Samarinda</title>
<link rel="icon" type="image/png" href="assets/logo.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=DM+Mono:wght@300;400&family=Spectral:ital,wght@0,200;0,300;0,400;1,200;1,300&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/beranda.css">

<style>
/* ── Base ── */
body { background-color: var(--parchment, #faf6f1) !important; }
body::before, body::after { display: none !important; }
#page-berita { background: var(--parchment, #faf6f1); }
.page-banner { background: var(--parchment, #faf6f1); border-bottom: 0.5px solid var(--cream-dk, #c4b5a0); }
.section { background: var(--parchment, #faf6f1) !important; border: none !important; }

/* ── Search Dropdown ── */
.search-form { position: relative; }
.search-results-drop {
  position: absolute;
  top: calc(100% + 8px);
  right: 0;
  width: 320px;
  background: white;
  border: 0.5px solid var(--cream-dk, #c4b5a0);
  border-radius: 12px;
  box-shadow: 0 16px 48px rgba(26,74,64,0.18);
  z-index: 999;
  overflow: hidden;
  max-height: 360px;
  overflow-y: auto;
}
.search-drop-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px 16px;
  cursor: pointer;
  border-bottom: 0.5px solid var(--cream-dk, #c4b5a0);
  transition: background 0.15s;
}
.search-drop-item:last-child { border-bottom: none; }
.search-drop-item:hover { background: var(--parchment, #faf6f1); }
.search-drop-img {
  width: 44px;
  height: 44px;
  border-radius: 8px;
  object-fit: cover;
  background: var(--vellum, #e8e0d5);
  flex-shrink: 0;
}
.search-drop-img-placeholder {
  width: 44px;
  height: 44px;
  border-radius: 8px;
  background: var(--vellum, #e8e0d5);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 18px;
  flex-shrink: 0;
}
.search-drop-title {
  font-family: var(--serif, serif);
  font-size: 13px;
  font-weight: 500;
  color: var(--ink, #3a2e24);
  line-height: 1.3;
}
.search-drop-meta {
  font-family: var(--mono, monospace);
  font-size: 8px;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  color: var(--sepia-lt, #9a8d7e);
  margin-top: 2px;
}
.search-drop-empty {
  padding: 20px 16px;
  font-family: var(--mono, monospace);
  font-size: 9px;
  letter-spacing: 0.14em;
  text-transform: uppercase;
  color: var(--sepia-lt, #9a8d7e);
  text-align: center;
}

/* ── Filter Bar ── */
.vue-filter-bar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
  margin-bottom: 32px;
  flex-wrap: wrap;
}
.vue-filter-group {
  display: flex;
  align-items: center;
  gap: 0;
  border: 0.5px solid var(--cream-dk, #c4b5a0);
  background: var(--parchment, #faf6f1);
  border-radius: 10px;
  overflow: hidden;
}
.vue-filter-btn {
  font-family: var(--mono, monospace);
  font-size: 8.5px;
  letter-spacing: 0.14em;
  text-transform: uppercase;
  color: var(--sepia, #6b5d4f);
  padding: 9px 18px;
  cursor: pointer;
  background: none;
  border: none;
  border-right: 0.5px solid var(--cream-dk, #c4b5a0);
  transition: background 0.2s, color 0.2s;
  white-space: nowrap;
}
.vue-filter-btn:last-child { border-right: none; }
.vue-filter-btn.active,
.vue-filter-btn:hover {
  background: var(--ink, #3a2e24);
  color: var(--linen, #f4ede5);
}
.vue-sort-select {
  font-family: var(--mono, monospace);
  font-size: 9px;
  letter-spacing: 0.1em;
  color: var(--sepia, #6b5d4f);
  background: white;
  border: 0.5px solid var(--cream-dk, #c4b5a0);
  border-radius: 8px;
  padding: 8px 32px 8px 12px;
  cursor: pointer;
  appearance: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%237a6a4a'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: calc(100% - 10px) 50%;
  outline: none;
}
.vue-count {
  font-family: var(--mono, monospace);
  font-size: 8.5px;
  letter-spacing: 0.14em;
  text-transform: uppercase;
  color: var(--sepia-lt, #9a8d7e);
  white-space: nowrap;
}

/* ── Card Grid ── */
.vue-berita-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 16px;
}
.vue-berita-card {
  background: white;
  border-radius: 14px;
  border: 0.5px solid rgba(196,181,160,0.5);
  overflow: hidden;
  cursor: pointer;
  box-shadow: 0 4px 20px rgba(26,74,64,0.07);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  display: flex;
  flex-direction: column;
}
.vue-berita-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 16px 48px rgba(26,74,64,0.15);
}
.card-img-wrap {
  width: 100%;
  aspect-ratio: 16/9;
  overflow: hidden;
  position: relative;
  background: var(--vellum, #e8e0d5);
  flex-shrink: 0;
}
.card-img-wrap img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.5s ease;
}
.vue-berita-card:hover .card-img-wrap img { transform: scale(1.05); }
.card-img-placeholder {
  position: absolute;
  inset: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, var(--vellum, #e8e0d5), var(--parchment, #faf6f1));
  font-size: 36px;
  opacity: 0.4;
}
.card-badge {
  position: absolute;
  top: 10px;
  left: 10px;
  font-family: var(--mono, monospace);
  font-size: 7.5px;
  letter-spacing: 0.14em;
  text-transform: uppercase;
  color: white;
  background: rgba(26,74,64,0.82);
  backdrop-filter: blur(6px);
  padding: 3px 9px;
  border-radius: 99px;
  font-weight: 500;
}
.card-body {
  padding: 18px 18px 20px;
  display: flex;
  flex-direction: column;
  gap: 6px;
  flex: 1;
}
.card-cat {
  font-family: var(--mono, monospace);
  font-size: 8px;
  letter-spacing: 0.14em;
  color: var(--moss, #2d7a5e);
  text-transform: uppercase;
}
.card-title {
  font-family: var(--serif, serif);
  font-size: 16px;
  font-weight: 500;
  line-height: 1.25;
  color: var(--ink, #3a2e24);
}
.card-snippet {
  font-family: var(--alt-serif, serif);
  font-size: 12px;
  font-weight: 300;
  line-height: 1.6;
  color: var(--sepia, #6b5d4f);
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
.card-date {
  font-family: var(--mono, monospace);
  font-size: 8px;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  color: var(--sepia-lt, #9a8d7e);
  margin-top: auto;
  padding-top: 10px;
  border-top: 0.5px solid var(--vellum, #e8e0d5);
}

/* ── Loading & Empty ── */
.vue-loading {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 16px;
  padding: 80px 0;
  color: var(--sepia-lt, #9a8d7e);
}
.vue-spinner {
  width: 32px;
  height: 32px;
  border: 2px solid var(--cream-dk, #c4b5a0);
  border-top-color: var(--navy-mid, #256b5c);
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }
.vue-empty {
  text-align: center;
  padding: 80px 0;
  font-family: var(--mono, monospace);
  font-size: 9px;
  letter-spacing: 0.16em;
  text-transform: uppercase;
  color: var(--sepia-lt, #9a8d7e);
}

/* ── Load more ── */
.vue-load-more {
  display: flex;
  justify-content: center;
  margin-top: 40px;
}

/* ══════════════════════════════════════
   SLIDE PANEL (kanan)
══════════════════════════════════════ */
.panel-backdrop {
  position: fixed;
  inset: 0;
  background: rgba(20, 30, 24, 0.55);
  backdrop-filter: blur(4px);
  z-index: 500;
  opacity: 0;
  pointer-events: none;
  transition: opacity 0.35s ease;
}
.panel-backdrop.open {
  opacity: 1;
  pointer-events: auto;
}

.slide-panel {
  height: 100dvh;
  max-height: 100dvh;
  overflow: hidden;
  position: fixed;
  top: 0;
  right: 0;
  width: min(600px, 92vw);
  background: var(--linen, #f4ede5);
  z-index: 501;
  transform: translateX(100%);
  transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
  display: flex;
  flex-direction: column;
  box-shadow: -20px 0 60px rgba(26,74,64,0.18);
  border-left: 0.5px solid rgba(196,181,160,0.5);
}
.slide-panel.open {
  transform: translateX(0);
}

/* Panel header */
.panel-head {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 20px 28px;
  border-bottom: 0.5px solid var(--cream-dk, #c4b5a0);
  background: var(--parchment, #faf6f1);
  flex-shrink: 0;
  gap: 12px;
}
.panel-head-left {
  display: flex;
  flex-direction: column;
  gap: 3px;
  min-width: 0;
}
.panel-eyebrow {
  font-family: var(--mono, monospace);
  font-size: 8px;
  letter-spacing: 0.20em;
  text-transform: uppercase;
  color: var(--moss, #2d7a5e);
  font-weight: 500;
}
.panel-date {
  font-family: var(--mono, monospace);
  font-size: 9px;
  letter-spacing: 0.12em;
  color: var(--sepia-lt, #9a8d7e);
}
.panel-close {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  border: 0.5px solid var(--cream-dk, #c4b5a0);
  background: white;
  color: var(--sepia, #6b5d4f);
  font-size: 18px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background 0.2s, color 0.2s;
  line-height: 1;
  flex-shrink: 0;
}
.panel-close:hover {
  background: var(--ink, #3a2e24);
  color: var(--linen, #f4ede5);
  border-color: var(--ink, #3a2e24);
}

/* Panel scroll body */
.panel-body {
  flex: 1;
  overflow-y: auto;
  padding: 0;
}

/* Panel image */
.panel-img {
  width: 100%;
  aspect-ratio: 16/9;
  object-fit: cover;
  display: block;
}
.panel-img-placeholder {
  width: 100%;
  aspect-ratio: 16/9;
  background: linear-gradient(135deg, var(--vellum, #e8e0d5), var(--parchment, #faf6f1));
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 64px;
  opacity: 0.35;
}

/* Panel content */
.panel-content {
  padding: 28px 28px 40px;
  display: flex;
  flex-direction: column;
  gap: 24px;
}
.panel-title {
  font-family: var(--serif, serif);
  font-size: 26px;
  font-weight: 500;
  line-height: 1.2;
  color: var(--ink, #3a2e24);
}
.panel-meta-inline {
  display: flex;
  align-items: center;
  gap: 16px;
  flex-wrap: wrap;
}
.panel-meta-tag {
  font-family: var(--mono, monospace);
  font-size: 8px;
  letter-spacing: 0.14em;
  text-transform: uppercase;
  color: var(--linen, #f4ede5);
  background: var(--navy-mid, #256b5c);
  padding: 4px 10px;
  border-radius: 99px;
}
.panel-meta-date {
  font-family: var(--mono, monospace);
  font-size: 9px;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  color: var(--sepia-lt, #9a8d7e);
}
.panel-desc {
  font-family: var(--alt-serif, serif);
  font-size: 15px;
  font-weight: 300;
  line-height: 1.85;
  color: var(--sepia, #6b5d4f);
}

/* Panel footer */
.panel-foot {
  flex-shrink: 0;
  padding: 16px 28px;
  border-top: 0.5px solid var(--cream-dk, #c4b5a0);
  background: var(--parchment, #faf6f1);
  display: flex;
  gap: 12px;
}

/* ── Responsive ── */
@media (max-width: 980px) {
  .vue-berita-grid { grid-template-columns: repeat(2, 1fr); }
  .vue-filter-bar { flex-direction: column; align-items: flex-start; }
}
@media (max-width: 640px) {
  .vue-berita-grid { grid-template-columns: 1fr; }
  .slide-panel { width: 100vw; }
  .panel-title { font-size: 22px; }
}
</style>
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
      <div class="masthead-right" id="masthead-search-mount">
        <form class="search-form" id="global-search-form" action="berita.php" method="GET" style="position:relative;">
          <input class="search-input" type="text" id="global-search-input" name="q" placeholder="Cari berita…" autocomplete="off" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
          <button class="search-btn" id="global-search-btn" type="submit">⌕</button>
          <div class="search-results-drop" id="search-results-drop" style="display:none;"></div>
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
      <button class="nav-item" onclick="location.href='event.php'">Event & Kegiatan</button>
      <button class="nav-item active" onclick="location.href='berita.php'">Berita</button>
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
  </div>
</div>

<!-- ════════════════════════════════════════════
     PAGE: BERITA & ARTIKEL
════════════════════════════════════════════ -->
<div id="page-berita" class="page active">
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

  <section class="section" style="background:var(--parchment,#faf6f1);border:none;">
    <div class="container">
      <div id="app-berita">

        <!-- Filter Bar -->
        <div class="vue-filter-bar">
          <div class="vue-filter-group">
            <button v-for="cat in categories" :key="cat.value" class="vue-filter-btn" :class="{ active: activeFilter === cat.value }" @click="setFilter(cat.value)">{{ cat.label }}</button>
          </div>
          <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
            <span class="vue-count">{{ filtered.length }} artikel ditemukan</span>
            <select class="vue-sort-select" v-model="sortBy">
              <option value="tanggal_desc">Terbaru</option>
              <option value="tanggal_asc">Terlama</option>
              <option value="judul">Judul A–Z</option>
              <option value="kategori">Kategori</option>
            </select>
          </div>
        </div>

        <!-- Loading -->
        <div class="vue-loading" v-if="loading">
          <div class="vue-spinner"></div>
          <span style="font-family:var(--mono);font-size:9px;letter-spacing:0.16em;text-transform:uppercase;">Memuat berita…</span>
        </div>

        <!-- Empty -->
        <div class="vue-empty" v-else-if="!loading && filtered.length === 0">
          <div style="font-size:32px;margin-bottom:12px;opacity:0.3;">📰</div>
          Tidak ada berita yang ditemukan
        </div>

        <!-- Grid -->
        <div class="vue-berita-grid" v-else>
          <div v-for="item in paginated" :key="item.id" class="vue-berita-card" @click="openPanel(item)">
            <div class="card-img-wrap">
              <img v-if="item.thumbnail" :src="item.thumbnail" :alt="item.judul" loading="lazy" style="width:100%;height:100%;object-fit:cover;display:block;" @error="e => e.target.replaceWith(Object.assign(document.createElement('div'), {className:'card-img-placeholder', innerHTML:'<span style=\'font-size:32px;opacity:0.2;\'>📰</span>'}))">
              <div v-else class="card-img-placeholder"><span style="font-size:32px;opacity:0.2;">📰</span></div>
              <span class="card-badge" v-if="item.kategori">{{ item.kategori }}</span>
            </div>
            <div class="card-body">
              <div class="card-cat">{{ item.kategori || 'Berita' }}</div>
              <div class="card-title">{{ item.judul }}</div>
              <div class="card-snippet">{{ item.snippet }}</div>
              <div class="card-date">{{ item.tanggal }}</div>
            </div>
          </div>
        </div>

        <!-- Load More -->
        <div class="vue-load-more" v-if="!loading && pageSize < filtered.length">
          <button class="btn-ghost" style="padding:12px 40px;" @click="pageSize += 9">Muat Lebih Banyak ↓</button>
        </div>

      </div><!-- /app-berita -->
    </div>
  </section>
</div>

<!-- ══ SLIDE PANEL ══ -->
<div class="panel-backdrop" id="panelBackdrop"></div>
<aside class="slide-panel" id="slidePanel" aria-label="Detail Berita">
  <div class="panel-head" id="panelHead">
    <div class="panel-head-left">
      <span class="panel-eyebrow" id="panelCat"></span>
      <span class="panel-date" id="panelDate"></span>
    </div>
    <button class="panel-close" id="panelClose" aria-label="Tutup">×</button>
  </div>
  <div class="panel-body" id="panelBody">
    <div id="panelImgWrap" style="position:relative;width:100%;aspect-ratio:16/9;overflow:hidden;background:linear-gradient(135deg,var(--vellum,#e8e0d5),var(--parchment,#faf6f1));flex-shrink:0;"></div>
    <div class="panel-content">
      <div class="panel-title" id="panelTitle"></div>
      <div class="panel-meta-inline" id="panelMetaInline"></div>
      <div class="panel-desc" id="panelDesc"></div>
    </div>
  </div>
  <div class="panel-foot">
    <button class="btn-ghost" id="panelFootClose" style="flex:1;justify-content:center;">← Kembali ke Daftar</button>
  </div>
</aside>

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

<script src="assets/js/scroll-fade-in.js"></script>

<script>
// Embed data dari PHP sebelum Vue di-mount
window.BERITA_DATA = <?= json_encode($beritaList, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
console.log('BERITA_DATA embedded:', window.BERITA_DATA.length, 'items');
</script>

<script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
<script>
// Debug: Check if Vue loaded
console.log('Vue loaded:', typeof Vue !== 'undefined');
console.log('BERITA_DATA available before mount:', typeof window.BERITA_DATA !== 'undefined');
console.log('BERITA_DATA count:', window.BERITA_DATA ? window.BERITA_DATA.length : 0);

const { createApp, ref, computed, onMounted } = Vue;

createApp({
  setup() {
    const allBerita   = ref([]);
    const loading     = ref(true);
    const activeFilter= ref('semua');
    const sortBy      = ref('tanggal_desc');
    const pageSize    = ref(9);
    const searchQuery = ref('');

    const categories = computed(() => {
      const cats = [...new Set(allBerita.value.map(b => b.kategori).filter(Boolean))];
      return [{ value: 'semua', label: 'Semua' }, ...cats.map(c => ({ value: c.toLowerCase(), label: c }))];
    });

    const filtered = computed(() => {
      let list = allBerita.value;
      if (activeFilter.value !== 'semua') {
        list = list.filter(b => (b.kategori || '').toLowerCase() === activeFilter.value);
      }
      const q = searchQuery.value.trim().toLowerCase();
      if (q) {
        list = list.filter(b => (b.judul || '').toLowerCase().includes(q) || (b.snippet || '').toLowerCase().includes(q));
      }
      list = [...list].sort((a, b) => {
        if (sortBy.value === 'judul')    return (a.judul || '').localeCompare(b.judul || '');
        if (sortBy.value === 'kategori') return (a.kategori || '').localeCompare(b.kategori || '');
        if (sortBy.value === 'tanggal_asc')  return (a.tanggal_raw || '').localeCompare(b.tanggal_raw || '');
        return (b.tanggal_raw || '').localeCompare(a.tanggal_raw || '');
      });
      return list;
    });

    const paginated = computed(() => filtered.value.slice(0, pageSize.value));

    function setFilter(val) { activeFilter.value = val; pageSize.value = 9; }

    function openPanel(item) {
      renderPanel(item);
      document.getElementById('panelBackdrop').classList.add('open');
      document.getElementById('slidePanel').classList.add('open');
      document.body.style.overflow = 'hidden';
    }

    function closePanel() {
      document.getElementById('panelBackdrop').classList.remove('open');
      document.getElementById('slidePanel').classList.remove('open');
      document.body.style.overflow = '';
    }

    function renderPanel(item) {
      document.getElementById('panelCat').textContent = item.kategori || 'Berita';
      document.getElementById('panelDate').textContent = item.tanggal;

      const imgWrap = document.getElementById('panelImgWrap');
      if (item.thumbnail) {
        imgWrap.innerHTML = '';
        const img = document.createElement('img');
        img.src = item.thumbnail;
        img.alt = item.judul;
        img.style.cssText = 'position:absolute;inset:0;width:100%;height:100%;object-fit:cover;display:block;';
        img.onerror = () => { imgWrap.innerHTML = '<div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;"><span style="font-size:48px;opacity:0.18;">📰</span><span style="font-family:var(--mono,monospace);font-size:8px;letter-spacing:0.16em;text-transform:uppercase;color:var(--sepia-lt,#9a8d7e);">Gambar tidak tersedia</span></div>'; };
        imgWrap.appendChild(img);
      } else {
        imgWrap.innerHTML = '<div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;"><span style="font-size:48px;opacity:0.18;">📰</span><span style="font-family:var(--mono,monospace);font-size:8px;letter-spacing:0.16em;text-transform:uppercase;color:var(--sepia-lt,#9a8d7e);">Gambar tidak tersedia</span></div>';
      }

      document.getElementById('panelTitle').textContent = item.judul;
      document.getElementById('panelMetaInline').innerHTML = '<span class="panel-meta-tag">' + (item.kategori || 'Berita') + '</span><span class="panel-meta-date">' + item.tanggal + '</span>';
      
      const descEl = document.getElementById('panelDesc');
      const content = item.isi && item.isi.length > 200 ? item.isi : (item.snippet || '');
      descEl.textContent = content;

      const body = document.getElementById('panelBody');
      if (body) body.scrollTop = 0;
    }

    function onKey(e) { if (e.key === 'Escape') closePanel(); }

    function initData() {
      try {
        const data = window.BERITA_DATA || [];
        console.log('Loading berita data:', data.length, 'items');
        allBerita.value = data.map(b => ({
          ...b,
          tanggal: formatTanggalDisplay(b.tanggal_publish),
          tanggal_raw: b.tanggal_publish,
          snippet: b.ringkasan || potongTeks(b.isi, 150)
        }));
        console.log('Processed berita:', allBerita.value.length, 'items');
      } catch (err) { 
        console.error('Gagal parse data berita:', err); 
        allBerita.value = []; 
      }
      finally { loading.value = false; }
    }

    function formatTanggalDisplay(tanggal) {
      if (!tanggal) return '-';
      const bulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

      // Tangani format YYYY-MM-DD tanpa geser timezone
      const m = String(tanggal).match(/^(\d{4})-(\d{2})-(\d{2})$/);
      if (m) {
        const tahun = m[1];
        const bulanIdx = parseInt(m[2], 10) - 1;
        const hari = parseInt(m[3], 10);
        return hari + ' ' + bulan[bulanIdx] + ' ' + tahun;
      }

      const d = new Date(tanggal);
      if (Number.isNaN(d.getTime())) return '-';
      return d.getDate() + ' ' + bulan[d.getMonth()] + ' ' + d.getFullYear();
    }

    function potongTeks(text, limit) {
      if (!text) return '';
      text = text.replace(/<[^>]*>/g, '');
      return text.length <= limit ? text : text.substring(0, limit) + '...';
    }

    function setupMastheadSearch() {
      const input = document.getElementById('global-search-input');
      const drop  = document.getElementById('search-results-drop');
      const btn   = document.getElementById('global-search-btn');
      if (!input || !drop) return;

      let debounce;
      input.addEventListener('input', () => {
        clearTimeout(debounce);
        debounce = setTimeout(() => {
          const q = input.value.trim().toLowerCase();
          searchQuery.value = q;
          if (!q) { drop.style.display = 'none'; return; }

          const results = allBerita.value.filter(b => (b.judul || '').toLowerCase().includes(q) || (b.snippet || '').toLowerCase().includes(q)).slice(0, 6);

          if (results.length === 0) {
            drop.innerHTML = '<div class="search-drop-empty">Tidak ada hasil untuk "' + input.value + '"</div>';
          } else {
            drop.innerHTML = results.map(b => '<div class="search-drop-item" data-id="' + b.id + '">' + (b.thumbnail ? '<img class="search-drop-img" src="' + b.thumbnail + '" alt="' + b.judul + '">' : '<div class="search-drop-img-placeholder">📰</div>') + '<div><div class="search-drop-title">' + b.judul + '</div><div class="search-drop-meta">' + (b.kategori || '-') + ' · ' + b.tanggal + '</div></div></div>').join('');
            drop.querySelectorAll('.search-drop-item').forEach(el => {
              el.addEventListener('click', () => {
                const id = parseInt(el.dataset.id);
                const item = allBerita.value.find(b => b.id === id);
                if (item) openPanel(item);
                drop.style.display = 'none';
                input.value = '';
                searchQuery.value = '';
              });
            });
          }
          drop.style.display = 'block';
        }, 220);
      });

      input.addEventListener('keydown', e => { if (e.key === 'Enter') drop.style.display = 'none'; });
      document.addEventListener('click', e => { if (!input.contains(e.target) && !drop.contains(e.target)) drop.style.display = 'none'; });
      btn.addEventListener('click', () => { searchQuery.value = input.value.trim().toLowerCase(); drop.style.display = 'none'; });
    }

    onMounted(() => {
      console.log('Vue mounted, initializing...');
      initData();
      setupMastheadSearch();
      document.addEventListener('keydown', onKey);
      const btnClose = document.getElementById('panelClose');
      const btnFootClose = document.getElementById('panelFootClose');
      const backdrop = document.getElementById('panelBackdrop');
      if (btnClose) btnClose.addEventListener('click', closePanel);
      if (btnFootClose) btnFootClose.addEventListener('click', closePanel);
      if (backdrop) backdrop.addEventListener('click', closePanel);
    });

    return { allBerita, loading, activeFilter, sortBy, pageSize, searchQuery, categories, filtered, paginated, setFilter, openPanel, closePanel };
  }
}).mount('#app-berita');
</script>

<script>
(function () {
  const body = document.body;
  const sidebar = document.getElementById('global-sidebar');
  const openers = document.querySelectorAll('[data-sidebar-toggle]');
  const closers = document.querySelectorAll('[data-sidebar-close]');
  if (!sidebar || !openers.length) return;
  function open() { body.classList.add('sidebar-open'); sidebar.setAttribute('aria-hidden','false'); }
  function close() { body.classList.remove('sidebar-open'); sidebar.setAttribute('aria-hidden','true'); }
  function toggle() { body.classList.contains('sidebar-open') ? close() : open(); }
  openers.forEach(b => b.addEventListener('click', toggle));
  closers.forEach(b => b.addEventListener('click', close));
})();
</script>

</body>
</html>