<?php

require_once __DIR__ . '/config/auth.php';
require_once __DIR__ . '/config/db.php';

$pdo = getDB();

$totalKoleksi    = 0;
$totalEventAktif = 0;
$koleksiTertua   = '—';
$koleksiPilihan  = null;
$koleksiUnggulan = [];
$eventTerbaru    = [];
$beritaTerbaru   = [];
$ulasanTerbaru   = [];

function potong_teks($text, $limit = 120) {
    $text = trim(strip_tags((string)$text));
    if (mb_strlen($text) <= $limit) return $text;
    return mb_substr($text, 0, $limit) . '...';
}

function format_tanggal_indo($tanggal) {
    if (!$tanggal) return '-';
    $ts = strtotime($tanggal);
    if (!$ts) return '-';
    $bulan = [1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'Mei',6=>'Jun',
              7=>'Jul',8=>'Agu',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des'];
    return date('j', $ts) . ' ' . $bulan[(int)date('n', $ts)] . ' ' . date('Y', $ts);
}

function format_bulan_pendek($tanggal) {
    if (!$tanggal) return '-';
    $ts = strtotime($tanggal);
    if (!$ts) return '-';
    $bulan = [1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'Mei',6=>'Jun',
              7=>'Jul',8=>'Agu',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des'];
    return $bulan[(int)date('n', $ts)];
}

try {
    $stmt = $pdo->query("SELECT COUNT(*) AS total FROM koleksi");
    $totalKoleksi = (int)($stmt->fetch()['total'] ?? 0);

    $stmt = $pdo->query("SELECT COUNT(*) AS total FROM event WHERE status = 'Aktif'");
    $totalEventAktif = (int)($stmt->fetch()['total'] ?? 0);

    $stmt = $pdo->query("SELECT era FROM koleksi WHERE era IS NOT NULL AND era <> '' ORDER BY id ASC LIMIT 1");
    $row = $stmt->fetch();
    if ($row && !empty($row['era'])) $koleksiTertua = $row['era'];

    $stmt = $pdo->query("
        SELECT k.id,
               COALESCE(NULLIF(k.nomor,''), CONCAT('KOL · ', LPAD(k.id,4,'0'))) AS nomor_tampil,
               k.nama_koleksi, k.era, k.deskripsi, k.lokasi,
               kat.nama_kategori, ki.image_path
        FROM koleksi k
        LEFT JOIN kategori kat ON kat.id = k.kategori_id
        LEFT JOIN (SELECT koleksi_id, MIN(id) AS min_id FROM koleksi_images GROUP BY koleksi_id) pick ON pick.koleksi_id = k.id
        LEFT JOIN koleksi_images ki ON ki.id = pick.min_id
        ORDER BY k.id DESC LIMIT 1
    ");
    $koleksiPilihan = $stmt->fetch();

    $stmt = $pdo->query("
        SELECT k.id,
               COALESCE(NULLIF(k.nomor,''), CONCAT('KOL · ', LPAD(k.id,4,'0'))) AS nomor_tampil,
               k.nama_koleksi, k.era, k.deskripsi,
               kat.nama_kategori, ki.image_path
        FROM koleksi k
        LEFT JOIN kategori kat ON kat.id = k.kategori_id
        LEFT JOIN (SELECT koleksi_id, MIN(id) AS min_id FROM koleksi_images GROUP BY koleksi_id) pick ON pick.koleksi_id = k.id
        LEFT JOIN koleksi_images ki ON ki.id = pick.min_id
        ORDER BY k.id DESC LIMIT 8
    ");
    $koleksiUnggulan = $stmt->fetchAll();

    $stmt = $pdo->query("SELECT id, nama_event, deskripsi, tanggal_mulai, jam, tempat, kategori, status
                         FROM event WHERE status = 'Aktif'
                         ORDER BY tanggal_mulai ASC, jam ASC LIMIT 4");
    $eventTerbaru = $stmt->fetchAll();

    $stmt = $pdo->query("SELECT id, judul, ringkasan, kategori, tanggal_publish, thumbnail
                         FROM berita ORDER BY tanggal_publish DESC, id DESC LIMIT 3");
    $beritaTerbaru = $stmt->fetchAll();

    $stmt = $pdo->query("
        SELECT k.id, k.isi_komentar, k.tanggal, a.nama
        FROM komentar k
        INNER JOIN akun a ON a.id = k.user_id
        ORDER BY k.tanggal DESC, k.id DESC LIMIT 3
    ");
    $ulasanTerbaru = $stmt->fetchAll();

} catch (Throwable $e) {
    // silently fail
}
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
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=DM+Mono:wght@300;400;500&family=Spectral:ital,wght@0,200;0,300;0,400;1,200;1,300&display=swap" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
<script src="assets/js/beranda.js?v=100" defer></script>
<script src="assets/js/scroll-fade-in.js?v=100" defer></script>

<style>
/* ─── Reset & Base ─── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
  --linen:       #f4ede5;
  --parchment:   #faf6f1;
  --vellum:      #e8e0d5;
  --ink:         #3a2e24;
  --ink-2:       #5a4a3a;
  --sepia:       #6b5d4f;
  --sepia-lt:    #9a8d7e;
  --moss:        #2d7a5e;
  --rust:        #8b4513;
  --cream-dk:    #c4b5a0;
  --navy-deep:   #1a4a40;
  --navy-mid:    #256b5c;
  --navy-soft:   #5a9a8a;
  --pattern-url: url("assets/3.webp");
  --foto-museum: url("assets/museum.webp");
  --serif:       'Cormorant Garamond', Georgia, serif;
  --alt-serif:   'Spectral', Georgia, serif;
  --mono:        'DM Mono', 'Courier New', monospace;
  --page-max:    1280px;
  --radius:      14px;
  --radius-sm:   8px;
}

html { scroll-behavior: smooth; }
body { background-color:var(--linen); color:var(--ink); font-family:var(--serif); font-size:16px; line-height:1.7; overflow-x:hidden; }
body::before { content:''; position:fixed; inset:0; background:linear-gradient(rgba(244,237,229,0.88),rgba(244,237,229,0.88)), var(--pattern-url) center top/720px auto repeat; pointer-events:none; z-index:0; opacity:0.18; }
body::after  { content:''; position:fixed; inset:0; background:radial-gradient(circle at top,rgba(255,255,255,0.7),transparent 38%), linear-gradient(180deg,rgba(26,74,64,0.05),transparent 18%,rgba(26,74,64,0.08) 66%,transparent 100%); pointer-events:none; z-index:0; }
* { position:relative; z-index:1; }

.container { max-width:var(--page-max); margin:0 auto; padding:0 40px; }

/* ─── TOPBAR ─── */
.topbar { border-bottom:0.5px solid rgba(196,181,160,0.3); background:linear-gradient(rgba(62,37,8,0.94),rgba(62,37,8,0.94)),var(--pattern-url) center/540px auto repeat; backdrop-filter:blur(8px); position:sticky; top:0; z-index:200; }
.topbar-inner { display:flex; align-items:center; justify-content:space-between; height:42px; gap:24px; }
.topbar-left,.topbar-right { display:flex; align-items:center; gap:20px; }
.topbar-item { font-family:var(--mono); font-size:9px; letter-spacing:0.14em; text-transform:uppercase; color:var(--sepia); transition:color 0.2s; cursor:pointer; background:none; border:none; }
.topbar-item:hover { color:var(--linen); }
.topbar-sep { width:1px; height:14px; background:var(--cream-dk); opacity:0.4; }

/* ─── MASTHEAD ─── */
.masthead { border-bottom:0.5px solid rgba(255,255,255,0.15); padding:32px 0 28px; background:linear-gradient(rgba(62,37,8,0.94),rgba(26,74,64,0.94)),var(--pattern-url) center/620px auto repeat; color:var(--linen); }
.masthead-inner { display:grid; grid-template-columns:1fr auto 1fr; align-items:center; gap:32px; }
.masthead-left { display:flex; flex-direction:column; gap:4px; }
.masthead-right { display:flex; flex-direction:column; align-items:flex-end; gap:8px; }
.masthead-center { text-align:center; }
.museum-name { font-family:var(--serif); font-size:clamp(28px,4vw,52px); font-weight:500; letter-spacing:0.02em; line-height:1; color:var(--linen); cursor:pointer; }
.museum-name em { font-style:italic; font-weight:400; }
.museum-sub { font-family:var(--mono); font-size:9px; letter-spacing:0.22em; text-transform:uppercase; color:rgba(244,237,229,0.72); margin-top:8px; display:flex; align-items:center; justify-content:center; gap:12px; }
.museum-sub::before,.museum-sub::after { content:''; display:block; width:40px; height:0.5px; background:rgba(244,237,229,0.32); }
.search-form { display:flex; align-items:center; border:0.5px solid rgba(255,255,255,0.3); background:rgba(255,255,255,0.08); overflow:hidden; width:200px; border-radius:var(--radius-sm); transition:width 0.3s, border-color 0.2s; }
.search-form:focus-within { border-color:rgba(255,255,255,0.7); background:rgba(255,255,255,0.12); width:240px; }
.search-input { background:transparent; border:none; outline:none; font-family:var(--mono); font-size:9px; letter-spacing:0.12em; color:var(--linen); padding:7px 12px; width:100%; }
.search-input::placeholder { color:rgba(244,237,229,0.62); }
.search-btn { background:transparent; border:none; border-left:0.5px solid rgba(255,255,255,0.22); padding:7px 10px; cursor:pointer; color:var(--linen); font-size:12px; }

/* ─── NAVBAR ─── */
.navbar { border-bottom:0.5px solid rgba(255,255,255,0.15); background:linear-gradient(rgba(62,37,8,0.94),rgba(62,37,8,0.94)),var(--pattern-url) center/540px auto repeat; backdrop-filter:blur(10px); }
.navbar-inner { display:flex; align-items:center; justify-content:center; height:46px; }
.nav-item { font-family:var(--mono); font-size:9.5px; letter-spacing:0.16em; text-transform:uppercase; color:rgba(244,237,229,0.76); padding:0 18px; height:100%; display:flex; align-items:center; border-right:0.5px solid rgba(255,255,255,0.12); transition:background 0.2s, color 0.2s; cursor:pointer; background:none; border-top:none; border-bottom:none; border-left:none; font-weight:500; }
.nav-item:first-child { border-left:0.5px solid rgba(255,255,255,0.12); }
.nav-item:hover { background:rgba(255,255,255,0.1); color:var(--linen); }
.nav-item.active { background:rgba(255,255,255,0.14); color:var(--linen); }

/* ─── PAGE ─── */
.page { display:none; animation:pageIn 0.4s ease both; }
.page.active { display:block; }
@keyframes pageIn { from{opacity:0;transform:translateY(12px)} to{opacity:1;transform:translateY(0)} }

/* ─── SECTION ─── */
.section { padding:72px 0; border-bottom:0.5px solid rgba(196,181,160,0.6); }
.section-header { display:grid; grid-template-columns:1fr auto; align-items:end; margin-bottom:40px; padding-bottom:20px; border-bottom:0.5px solid rgba(196,181,160,0.6); gap:24px; }
.section-title { font-family:var(--serif); font-size:clamp(24px,3vw,40px); font-weight:500; line-height:1.1; color:var(--ink); font-style:bold; }
.section-title em { font-style:italic; font-weight:400; color:var(--navy-mid); }

/* ─── BUTTONS ─── */
.btn-primary { font-family:var(--mono); font-size:9px; letter-spacing:0.16em; text-transform:uppercase; color:var(--linen); background:var(--navy-deep); border:0.5px solid var(--navy-deep); padding:13px 28px; transition:background 0.2s, transform 0.15s; cursor:pointer; display:inline-flex; align-items:center; gap:8px; border-radius:var(--radius-sm); font-weight:500; }
.btn-primary:hover { background:var(--navy-mid); transform:translateY(-1px); }
.btn-ghost { font-family:var(--mono); font-size:9px; letter-spacing:0.16em; text-transform:uppercase; color:var(--sepia); background:rgba(255,255,255,0.75); border:0.5px solid var(--cream-dk); padding:13px 28px; transition:border-color 0.2s, color 0.2s, background 0.2s, transform 0.15s; cursor:pointer; display:inline-flex; align-items:center; border-radius:var(--radius-sm); font-weight:500; }
.btn-ghost:hover { border-color:var(--navy-mid); color:var(--navy-deep); background:#fff; transform:translateY(-1px); }

/* ─── TICKER ─── */
.ticker { overflow:hidden; background:rgba(26,74,64,0.96); height:38px; display:flex; align-items:center; }
.ticker-inner { display:flex; white-space:nowrap; animation:ticker 38s linear infinite; }
.ticker-item { display:inline-flex; align-items:center; gap:16px; padding:0 32px; font-family:var(--mono); font-size:9px; letter-spacing:0.14em; text-transform:uppercase; color:rgba(244,237,229,0.78); border-right:0.5px solid rgba(255,255,255,0.12); font-weight:400; }
@keyframes ticker { 0%{transform:translateX(0)} 100%{transform:translateX(-50%)} }

/* ─── HERO VIDEO ─── */
.hero-video-section { position:relative; width:100%; min-height:92vh; display:flex; flex-direction:column; justify-content:flex-end; overflow:hidden; }
.hero-video-bg { position:absolute; inset:0; z-index:0; pointer-events:none; overflow:hidden; }
.hero-video-bg iframe { position:absolute; top:50%; left:50%; width:177.78vh; height:100%; min-width:100%; min-height:56.25vw; transform:translate(-50%,-50%); pointer-events:none; }
.hero-video-scrim { position:absolute; inset:0; z-index:1; background:linear-gradient(180deg,rgba(26,46,36,0.55) 0%,rgba(26,74,64,0.40) 40%,rgba(20,30,24,0.78) 80%,rgba(15,20,18,0.92) 100%); }
.hero-video-scrim::after { content:''; position:absolute; inset:0;}
.hero-video-content { position:relative; z-index:2; display:grid; grid-template-columns:1fr 360px; gap:32px; align-items:end; padding:0 clamp(24px,5vw,80px) 64px; max-width:calc(var(--page-max) + 80px); margin:0 auto; width:100%; }
.hero-text-block { display:flex; flex-direction:column; gap:20px; }
.hero-tag { display:inline-flex; align-items:center; gap:8px; font-family:var(--mono); font-size:9px; letter-spacing:0.18em; text-transform:uppercase; color:rgba(244,237,229,0.85); border:0.5px solid rgba(196,181,160,0.35); padding:6px 14px; width:fit-content; background:rgba(244,237,229,0.08); backdrop-filter:blur(8px); border-radius:var(--radius-sm); font-weight:500; }
.dot-live { width:5px; height:5px; border-radius:50%; background:#4ade80; animation:pulse 2.5s ease-in-out infinite; flex-shrink:0; }
@keyframes pulse { 0%,100%{opacity:1;box-shadow:0 0 0 0 rgba(74,222,128,0.4)} 50%{opacity:0.6;box-shadow:0 0 0 5px rgba(74,222,128,0)} }
.hero-headline { font-family:var(--serif); font-size:clamp(52px,7.5vw,96px); font-weight:600; line-height:0.95; letter-spacing:-0.025em; color:var(--linen); text-shadow:0 2px 24px rgba(0,0,0,0.4); }
.hero-headline em { font-style:italic; font-weight:400; color:rgba(255, 255, 255, 0.9); }
.hero-deck { font-family:var(--alt-serif); font-size:16px; font-weight:300; line-height:1.75; color:rgba(244,237,229,0.78); max-width:480px; }
.hero-actions { display:flex; align-items:center; gap:16px; flex-wrap:wrap; margin-top:8px; }
.hero-actions .btn-primary { background:rgba(244,237,229,0.95); color:var(--ink); border-color:rgba(244,237,229,0.95); }
.hero-actions .btn-primary:hover { background:#fff; }
.hero-actions .btn-ghost { background:rgba(255,255,255,0.10); border-color:rgba(196,181,160,0.40); color:rgba(244,237,229,0.85); backdrop-filter:blur(8px); }
.hero-actions .btn-ghost:hover { background:rgba(255,255,255,0.18); color:#fff; }
.hero-stats { display:flex; gap:32px; padding-top:28px; border-top:0.5px solid rgba(196,181,160,0.22); margin-top:8px; }
.stat { display:flex; flex-direction:column; gap:4px; }
.stat-num { font-family:var(--serif); font-size:36px; font-weight:600; color:var(--linen); line-height:1; text-shadow:0 2px 12px rgba(0,0,0,0.3); }
.stat-label { font-family:var(--mono); font-size:9px; letter-spacing:0.16em; text-transform:uppercase; color:rgba(244,237,229,0.55); font-weight:500; }

/* ─── HERO GLASS CARD ─── */
.hero-glass-card { background:rgba(250,246,241,0.10); border:0.5px solid rgba(196,181,160,0.28); backdrop-filter:blur(18px) saturate(1.4); -webkit-backdrop-filter:blur(18px) saturate(1.4); border-radius:var(--radius); padding:28px; display:flex; flex-direction:column; gap:20px; box-shadow:0 12px 48px rgba(0,0,0,0.35),inset 0 0.5px 0 rgba(255,255,255,0.12); cursor:pointer; }
.glass-card-label { font-family:var(--mono); font-size:8.5px; letter-spacing:0.20em; text-transform:uppercase; color:rgba(196,181,160,0.65); font-weight:500; }
.glass-koleksi-img { width:100%; aspect-ratio:4/3; border-radius:var(--radius-sm); overflow:hidden; background:rgba(255,255,255,0.06); border:0.5px solid rgba(196,181,160,0.18); position:relative; }
.glass-koleksi-img img { width:100%; height:100%; object-fit:cover; opacity:0.85; }
.glass-koleksi-img .img-placeholder { position:absolute; inset:0; display:flex; align-items:center; justify-content:center; background:linear-gradient(135deg,rgba(45,122,94,0.20),rgba(26,74,64,0.35)); }
.glass-koleksi-img .img-placeholder span { font-family:var(--mono); font-size:8px; letter-spacing:0.14em; text-transform:uppercase; color:rgba(196,181,160,0.5); }
.glass-card-cat { font-family:var(--mono); font-size:8px; letter-spacing:0.18em; text-transform:uppercase; color:var(--navy-soft); font-weight:500; }
.glass-card-title { font-family:var(--serif); font-size:19px; font-weight:500; line-height:1.25; color:rgba(244,237,229,0.95); margin-top:2px; }
.glass-card-body { font-family:var(--alt-serif); font-size:12.5px; font-weight:300; line-height:1.65; color:rgba(196,181,160,0.75); }
.glass-info-strip { display:flex; flex-direction:column; gap:9px; border-top:0.5px solid rgba(196,181,160,0.18); padding-top:16px; }
.glass-info-row { display:flex; align-items:baseline; gap:10px; }
.glass-info-key { font-family:var(--mono); font-size:8.5px; letter-spacing:0.14em; text-transform:uppercase; color:rgba(196,181,160,0.45); min-width:82px; font-weight:500; }
.glass-info-val { font-family:var(--alt-serif); font-size:12.5px; font-weight:300; color:rgba(244,237,229,0.82); }
.glass-card-link { font-family:var(--mono); font-size:8.5px; letter-spacing:0.16em; text-transform:uppercase; color:var(--navy-soft); display:flex; align-items:center; justify-content:center; gap:6px; cursor:pointer; background:none; border:0.5px solid rgba(90,154,138,0.28); padding:10px 14px; border-radius:var(--radius-sm); transition:background 0.2s, color 0.2s; width:100%; font-weight:500; }
.glass-card-link:hover { background:rgba(90,154,138,0.14); color:rgba(244,237,229,0.9); }
.glass-card-link::after { content:'→'; }

/* ─── KOLEKSI SWIPER ─── */
.koleksi-swiper-section { padding:80px 0 72px; background:var(--parchment); border-bottom:0.5px solid rgba(196,181,160,0.6); }
.koleksi-swiper-header { display:flex; align-items:flex-end; justify-content:space-between; gap:24px; margin-bottom:40px; padding:0 clamp(24px,5vw,80px); max-width:calc(var(--page-max) + 80px); margin-left:auto; margin-right:auto; }
.koleksi-swiper-header-left { display:flex; flex-direction:column; gap:6px; }
.koleksi-swiper-eyebrow { font-family:var(--mono); font-size:8.5px; letter-spacing:0.22em; text-transform:uppercase; color:var(--moss); font-weight:500; }
.koleksi-swiper-title { font-family:var(--serif); font-style:bold;font-size:clamp(26px,3.5vw,44px); font-weight:600; line-height:1.05; color:var(--ink); }
.koleksi-swiper-title em { font-style:italic; font-weight:400; color:var(--navy-mid); }
.koleksi-swiper-nav { display:flex; align-items:center; gap:8px; }
.swiper-btn { width:40px; height:40px; border-radius:50%; border:0.5px solid var(--cream-dk); background:white; display:flex; align-items:center; justify-content:center; cursor:pointer; transition:background 0.2s, transform 0.15s; color:var(--sepia); font-size:14px; }
.swiper-btn:hover { background:var(--navy-deep); border-color:var(--navy-deep); color:white; transform:scale(1.05); }
.swiper-btn:disabled { opacity:0.35; cursor:not-allowed; transform:none; }
.koleksi-swiper-wrap { position:relative; overflow:hidden; padding:8px clamp(24px,5vw,80px) 16px; cursor:grab; }
.koleksi-swiper-wrap:active { cursor:grabbing; }
.koleksi-swiper-track { display:flex; gap:20px; transition:transform 0.5s cubic-bezier(0.25,0.46,0.45,0.94); will-change:transform; user-select:none; }
.k-slide { flex:0 0 calc(25% - 15px); min-width:260px; background:white; border-radius:var(--radius); border:0.5px solid rgba(196,181,160,0.5); overflow:hidden; box-shadow:0 4px 20px rgba(26,74,64,0.07); cursor:pointer; transition:transform 0.3s, box-shadow 0.3s; display:flex; flex-direction:column; }
.k-slide:hover { transform:translateY(-6px); box-shadow:0 16px 48px rgba(26,74,64,0.16); }
.k-slide-img { width:100%; aspect-ratio:4/3; overflow:hidden; position:relative; background:var(--vellum); flex-shrink:0; }
.k-slide-img img { width:100%; height:100%; object-fit:cover; transition:transform 0.5s; }
.k-slide:hover .k-slide-img img { transform:scale(1.04); }
.k-slide-img-placeholder { position:absolute; inset:0; display:flex; align-items:center; justify-content:center; background:linear-gradient(135deg,var(--vellum),var(--parchment)); }
.k-slide-img-placeholder::before { content:attr(data-num); font-family:var(--mono); font-size:8px; letter-spacing:0.16em; color:var(--cream-dk); text-transform:uppercase; }
.k-slide-badge { position:absolute; top:12px; left:12px; font-family:var(--mono); font-size:7.5px; letter-spacing:0.14em; text-transform:uppercase; color:white; background:rgba(26,74,64,0.82); backdrop-filter:blur(6px); padding:4px 10px; border-radius:99px; font-weight:500; }
.k-slide-body { padding:20px 20px 22px; display:flex; flex-direction:column; gap:8px; flex:1; }
.k-slide-cat { font-family:var(--mono); font-size:8px; letter-spacing:0.18em; text-transform:uppercase; color:var(--moss); font-weight:500; }
.k-slide-title { font-family:var(--serif); font-size:18px; font-weight:600; line-height:1.25; color:var(--ink); }
.k-slide-era { font-family:var(--mono); font-size:8px; letter-spacing:0.13em; text-transform:uppercase; color:var(--sepia-lt); margin-top:auto; padding-top:10px; border-top:0.5px solid var(--vellum); }
.k-slide-desc { font-family:var(--alt-serif); font-size:12.5px; font-weight:300; color:var(--sepia); line-height:1.6; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
.koleksi-swiper-dots { display:flex; justify-content:center; gap:6px; margin-top:24px; }
.swiper-dot { width:6px; height:6px; border-radius:99px; background:var(--cream-dk); border:none; cursor:pointer; padding:0; transition:background 0.2s, width 0.25s; }
.swiper-dot.active { background:var(--navy-deep); width:20px; }

/* ─── TWIN SECTION ─── */
.twin-section { display:grid; grid-template-columns:1fr 0.5px 1fr; margin:48px auto; max-width:calc(var(--page-max) - 80px); background:rgba(255,255,255,0.95); box-shadow:0 8px 40px rgba(26,74,64,0.09); border-radius:var(--radius); overflow:hidden; border:0.5px solid rgba(196,181,160,0.4); }
.twin-col { padding:52px 48px 52px 0; }
.twin-col:last-child { padding:52px 0 52px 48px; }
.twin-div { background:rgba(196,181,160,0.6); }
.event-list,.berita-list { display:flex; flex-direction:column; }
.event-item { display:grid; grid-template-columns:56px 1fr; gap:20px; padding:18px 0; border-bottom:0.5px solid rgba(196,181,160,0.6); cursor:pointer; border-radius:var(--radius-sm); transition:background 0.2s, padding 0.2s; }
.event-item:hover { background:rgba(196,181,160,0.08); padding-left:8px; padding-right:8px; }
.event-item:last-child { border-bottom:none; }
.event-date { display:flex; flex-direction:column; align-items:center; }
.event-dd { font-family:var(--serif); font-size:30px; font-weight:600; color:var(--ink); line-height:1; }
.event-mm { font-family:var(--mono); font-size:8.5px; letter-spacing:0.14em; text-transform:uppercase; color:var(--sepia-lt); font-weight:500; }
.event-title { font-family:var(--serif); font-size:16px; font-weight:600; color:var(--ink); line-height:1.3; }
.event-meta { font-family:var(--mono); font-size:8.5px; letter-spacing:0.12em; text-transform:uppercase; color:var(--sepia-lt); margin-top:4px; }
.berita-item { display:flex; flex-direction:column; gap:6px; padding:16px 0; border-bottom:0.5px solid rgba(196,181,160,0.6); cursor:pointer; border-radius:var(--radius-sm); transition:background 0.2s, padding 0.2s; }
.berita-item:hover { background:rgba(196,181,160,0.08); padding-left:8px; padding-right:8px; }
.berita-item:last-child { border-bottom:none; }
.berita-cat { font-family:var(--mono); font-size:8px; letter-spacing:0.18em; text-transform:uppercase; color:var(--moss); font-weight:500; }
.berita-title { font-family:var(--serif); font-size:17px; font-weight:600; line-height:1.3; color:var(--ink); }
.berita-snippet { font-family:var(--alt-serif); font-size:12.5px; font-weight:300; line-height:1.6; color:var(--sepia); }
.berita-date { font-family:var(--mono); font-size:8.5px; letter-spacing:0.12em; text-transform:uppercase; color:var(--sepia-lt); }

/* ─── INFO BAND ─── */
.info-band { background:linear-gradient(rgba(74,63,26,0.95),rgba(26,74,64,0.95)),var(--pattern-url) center/520px auto repeat; }
.info-band-inner { display:grid; grid-template-columns:1fr 1px 1fr 1px 1fr 1px 1fr; padding:0 40px; }
.info-band-col { padding:40px 36px; display:flex; flex-direction:column; gap:8px; }
.info-band-div { background:rgba(255,255,255,0.1); }
.ib-label { font-family:var(--mono); font-size:8.5px; letter-spacing:0.16em; text-transform:uppercase; color:rgba(244,237,229,0.45); font-weight:500; }
.ib-val { font-family:var(--serif); font-size:16px; font-weight:500; color:var(--linen); line-height:1.35; }
.ib-val.large { font-size:24px; }

/* ─── ULASAN ─── */
.ulasan-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-top:40px; }
.ulasan-card { background:white; padding:28px; display:flex; flex-direction:column; gap:14px; border-radius:var(--radius); border:0.5px solid rgba(196,181,160,0.4); box-shadow:0 2px 16px rgba(26,74,64,0.06); transition:transform 0.2s, box-shadow 0.2s; }
.ulasan-card:hover { transform:translateY(-3px); box-shadow:0 8px 32px rgba(26,74,64,0.12); }
.ulasan-stars { display:flex; gap:4px; }
.star { width:11px; height:11px; background:var(--sepia); clip-path:polygon(50% 0%,61% 35%,98% 35%,68% 57%,79% 91%,50% 70%,21% 91%,32% 57%,2% 35%,39% 35%); }
.ulasan-text { font-family:var(--alt-serif); font-size:14px; font-weight:300; font-style:italic; line-height:1.75; color:var(--ink-2); }
.ulasan-meta { margin-top:auto; display:flex; justify-content:space-between; align-items:baseline; }
.ulasan-name { font-family:var(--serif); font-size:14px; font-weight:600; color:var(--ink); }
.ulasan-date { font-family:var(--mono); font-size:8.5px; letter-spacing:0.12em; text-transform:uppercase; color:var(--sepia-lt); }

/* ─── FOOTER ─── */
.footer { background:linear-gradient(rgba(70,29,7,0.97),rgba(26,74,64,0.97)),var(--pattern-url) center/620px auto repeat; border-top:0.5px solid rgba(255,255,255,0.12); padding:56px 0 32px; }
.footer-grid { display:grid; grid-template-columns:2fr 1fr 1fr 1fr; gap:48px; padding-bottom:40px; border-bottom:0.5px solid rgba(255,255,255,0.12); }
.footer-name { font-family:var(--serif); font-size:24px; font-weight:500; color:var(--linen); line-height:1.1; margin-bottom:10px; }
.footer-name em { font-style:italic; font-weight:400; }
.footer-addr { font-family:var(--alt-serif); font-size:13px; font-weight:300; line-height:1.75; color:rgba(244,237,229,0.65); }
.footer-col-title { font-family:var(--mono); font-size:9px; letter-spacing:0.18em; text-transform:uppercase; color:var(--linen); margin-bottom:14px; font-weight:500; }
.footer-links { display:flex; flex-direction:column; gap:8px; align-items:flex-start; }
.footer-link { font-family:var(--alt-serif); font-size:13px; font-weight:300; color:rgba(244,237,229,0.65); transition:color 0.2s; cursor:pointer; background:none; border:none; text-align:left; }
.footer-link:hover { color:#fff; }
.footer-bottom { display:flex; justify-content:space-between; align-items:center; padding-top:24px; }
.footer-copy { font-family:var(--mono); font-size:9px; letter-spacing:0.12em; text-transform:uppercase; color:rgba(244,237,229,0.45); }

/* ─── GLOBAL TOPBAR & SIDEBAR ─── */
.global-topbar { display:flex; }
.global-sidebar { display:flex; }
.global-sidebar-backdrop { display:block; }
.global-topbar { position:sticky; top:0; z-index:320; height:56px; align-items:center; justify-content:space-between; gap:16px; padding:0 24px; background:linear-gradient(rgba(62,37,8,0.94),rgba(62,37,8,0.94)),var(--pattern-url) center/520px auto repeat; border-bottom:0.5px solid rgba(255,255,255,0.15); box-shadow:0 10px 24px rgba(26,74,64,0.12); }
.global-topbar-brand { display:flex; align-items:center; gap:14px; }
.global-menu-toggle { width:34px; height:34px; border:0.5px solid rgba(255,255,255,0.28); background:rgba(255,255,255,0.06); color:var(--linen); display:flex; align-items:center; justify-content:center; cursor:pointer; border-radius:var(--radius-sm); }
.global-menu-toggle-lines { width:14px; height:10px; display:grid; align-content:space-between; }
.global-menu-toggle-lines span { display:block; height:1px; background:currentColor; }
.global-brand-title { font-family:var(--serif); font-size:18px; font-weight:500; color:var(--linen); white-space:nowrap; }
.global-brand-title em { color:rgba(244,237,229,0.65); font-weight:400; }
.global-topbar-meta { font-family:var(--mono); font-size:8px; letter-spacing:0.22em; text-transform:uppercase; color:rgba(244,237,229,0.48); white-space:nowrap; }
.global-sidebar-backdrop { position:fixed; top:56px; right:0; bottom:0; left:0; background:rgba(26,74,64,0.24); backdrop-filter:blur(4px); opacity:0; pointer-events:none; transition:opacity 0.25s; z-index:329; }
.global-sidebar { position:fixed; top:0; left:0; bottom:0; width:min(320px,88vw); flex-direction:column; background:linear-gradient(180deg,rgba(255,255,255,0.98),rgba(244,237,229,0.98)); border-right:0.5px solid rgba(196,181,160,0.95); box-shadow:14px 0 36px rgba(26,74,64,0.12); transform:translateX(-100%); transition:transform 0.28s; z-index:330; }
body.sidebar-open .global-sidebar-backdrop { opacity:1; pointer-events:auto; }
body.sidebar-open .global-sidebar { transform:translateX(0); }
.global-sidebar-head { padding:24px 24px 18px; border-bottom:0.5px solid rgba(196,181,160,0.8); }
.global-sidebar-row { display:flex; align-items:flex-start; justify-content:space-between; gap:14px; }
.global-sidebar-avatar { width:46px; height:46px; border:0.5px solid var(--cream-dk); display:flex; align-items:center; justify-content:center; font-family:var(--serif); font-size:22px; color:var(--navy-deep); background:#fff; border-radius:50%; }
.global-sidebar-close { width:34px; height:34px; border:0.5px solid var(--cream-dk); background:#fff; color:var(--navy-deep); cursor:pointer; border-radius:var(--radius-sm); }
.global-sidebar-title { font-family:var(--serif); font-size:28px; font-weight:600; color:var(--navy-deep); margin-top:16px; }
.global-sidebar-subtitle { font-family:var(--mono); font-size:8px; letter-spacing:0.22em; text-transform:uppercase; color:var(--sepia-lt); margin-top:6px; }
.global-sidebar-section { padding:16px 24px 10px; font-family:var(--mono); font-size:8px; letter-spacing:0.2em; text-transform:uppercase; color:var(--sepia-lt); font-weight:500; }
.global-sidebar-nav { display:flex; flex-direction:column; gap:4px; padding-bottom:12px; }
.global-sidebar-link { display:flex; align-items:center; gap:12px; padding:11px 24px 11px 28px; border-left:4px solid transparent; font-family:var(--mono); font-size:10px; letter-spacing:0.16em; text-transform:uppercase; color:var(--sepia); text-decoration:none; transition:background 0.2s, color 0.2s, border-color 0.2s; font-weight:500; }
.global-sidebar-link:hover { background:rgba(45,122,94,0.08); color:var(--navy-deep); }
.global-sidebar-link.active { background:rgba(45,122,94,0.12); border-left-color:var(--navy-mid); color:var(--navy-deep); }
.global-sidebar-icon { width:16px; text-align:center; font-size:11px; color:var(--navy-soft); }
.global-sidebar-badge { margin-left:auto; min-width:18px; padding:2px 5px; border-radius:999px; background:rgba(45,122,94,0.12); font-family:var(--mono); font-size:8px; color:var(--navy-deep); text-align:center; }
.global-sidebar-actions { margin-top:auto; padding:18px 24px 24px; border-top:0.5px solid rgba(196,181,160,0.8); display:flex; flex-direction:column; gap:12px; }
.global-sidebar-btn { width:100%; font-family:var(--mono); font-size:9px; letter-spacing:0.18em; text-transform:uppercase; padding:14px 16px; cursor:pointer; transition:background 0.2s, color 0.2s; border-radius:var(--radius-sm); font-weight:500; }
.global-sidebar-btn.primary { background:var(--navy-deep); color:var(--linen); border:0.5px solid var(--navy-deep); }
.global-sidebar-btn.primary:hover { background:var(--navy-mid); }
.global-sidebar-btn.ghost { background:transparent; color:var(--sepia); border:0.5px solid var(--cream-dk); }
.global-sidebar-btn.ghost:hover { background:#fff; color:var(--navy-deep); }

/* ─── RESPONSIVE ─── */
@media (max-width:980px) {
  .container { padding:0 24px; }
  .masthead,.navbar { display:none !important; }
  .hero-video-content { grid-template-columns:1fr; padding-bottom:48px; }
  .hero-glass-card { display:none; }
  .hero-headline { font-size:clamp(44px,10vw,72px); }
  .masthead-inner,.section-header,.footer-grid,.info-band-inner,.ulasan-grid { grid-template-columns:1fr; }
  .info-band-div { display:none; }
  .info-band-col { padding:28px 24px; }
  .twin-section { grid-template-columns:1fr; max-width:calc(100% - 48px); }
  .twin-div { display:none; }
  .twin-col,.twin-col:last-child { padding:32px 24px; }
  .koleksi-swiper-header { padding:0 24px; }
  .koleksi-swiper-wrap { padding:8px 24px 16px; }
  .k-slide { flex:0 0 calc(50% - 10px); }
}
@media (max-width:640px) {
  .hero-headline { font-size:clamp(40px,11vw,60px); }
  .hero-actions { flex-direction:column; align-items:stretch; }
  .hero-stats { gap:20px; }
  .ulasan-grid { grid-template-columns:1fr; gap:12px; }
  .k-slide { flex:0 0 100%; }
  .footer-bottom { flex-direction:column; align-items:flex-start; gap:12px; }
  .global-topbar { padding:0 16px; }
  .global-topbar-meta { display:none; }
}

.twin-bg {
  position: relative;
  overflow: hidden;
  z-index: 1;
}

.twin-bg::before {
  content: '';
  position: absolute;
  inset: 0;

  background: var(--foto-museum) center / cover no-repeat;

  filter: blur(14px);
  transform: scale(1.1);

  z-index: 0;
}

.twin-bg::after {
  content: '';
  position: absolute;
  inset: 0;

  background:
    linear-gradient(rgba(244,237,229,0.92), rgba(244,237,229,0.92)),
    radial-gradient(circle at top, rgba(255,255,255,0.4), transparent 50%);

  z-index: 1;
}

.twin-bg > * {
  position: relative;
  z-index: 2;
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
      <button class="nav-item active"  onclick="location.href='home.php'">Beranda</button>
      <button class="nav-item"         onclick="location.href='tentang.php'">Tentang Museum</button>
      <button class="nav-item"         onclick="location.href='koleksi.php'">Koleksi</button>
      <button class="nav-item"         onclick="location.href='event.php'">Event &amp; Kegiatan</button>
      <button class="nav-item"         onclick="location.href='berita.php'">Berita</button>
      <button class="nav-item"         onclick="location.href='peta.php'">Peta Lokasi</button>
      <button class="nav-item"         onclick="location.href='peminjaman.php'">Peminjaman Ruang</button>
      <button class="nav-item"         onclick="location.href='ulasan.php'">Ulasan</button>
    </div>
  </div>
</nav>

<div id="page-beranda" class="page active">

  <!-- TICKER -->
  <div class="ticker">
    <div class="ticker-inner">
      <div class="ticker-item"><span style="color:var(--navy-soft)">✦</span> Pameran Baru: Warisan Dayak Kalimantan Timur</div>
      <div class="ticker-item"><span style="color:var(--navy-soft)">✦</span> Event: Diskusi Sejarah Samarinda · 22 Maret 2025</div>
      <div class="ticker-item"><span style="color:var(--navy-soft)">✦</span> Koleksi Baru: Naskah Kuno Abad ke-17</div>
      <div class="ticker-item"><span style="color:var(--navy-soft)">✦</span> Ruang Seminar Tersedia untuk Peminjaman</div>
      <div class="ticker-item"><span style="color:var(--navy-soft)">✦</span> Jam Operasional: Selasa–Minggu, 08:00–16:00 WIB</div>
      <div class="ticker-item"><span style="color:var(--navy-soft)">✦</span> Pameran Baru: Warisan Dayak Kalimantan Timur</div>
      <div class="ticker-item"><span style="color:var(--navy-soft)">✦</span> Event: Diskusi Sejarah Samarinda · 22 Maret 2025</div>
      <div class="ticker-item"><span style="color:var(--navy-soft)">✦</span> Koleksi Baru: Naskah Kuno Abad ke-17</div>
      <div class="ticker-item"><span style="color:var(--navy-soft)">✦</span> Ruang Seminar Tersedia untuk Peminjaman</div>
      <div class="ticker-item"><span style="color:var(--navy-soft)">✦</span> Jam Operasional: Selasa–Minggu, 08:00–16:00 WIB</div>
    </div>
  </div>

  <!-- HERO VIDEO -->
  <section class="hero-video-section">
    <div class="hero-video-bg">
      <iframe
        src="https://www.youtube.com/embed/ULqPa3qIOAk?autoplay=1&mute=1&loop=1&playlist=ULqPa3qIOAk&controls=0&showinfo=0&rel=0&disablekb=1&playsinline=1&enablejsapi=1&start=5"
        title="Museum Kota Samarinda" frameborder="0"
        allow="autoplay; encrypted-media" allowfullscreen>
      </iframe>
    </div>
    <div class="hero-video-scrim"></div>
    <div class="hero-video-content">

      <div class="hero-text-block">
        <div class="hero-tag"><div class="dot-live"></div> Buka Hari Ini · 08:00–16:00 WIB</div>
        <h1 class="hero-headline">Menjaga<br><em>Ingatan</em><br>Kota</h1>
        <p class="hero-deck">Lebih dari seribu artefak, naskah, dan dokumentasi sejarah kota Samarinda tersimpan dan terbuka untuk publik. Temukan cerita yang membentuk kota ini.</p>
        <div class="hero-actions">
          <button class="btn-primary" onclick="location.href='koleksi.php'">Jelajahi Koleksi</button>
          <button class="btn-ghost"   onclick="location.href='peta.php'">Rencana Kunjungan</button>
        </div>
        <div class="hero-stats">
          <div class="stat"><div class="stat-num"><?= number_format($totalKoleksi,0,',','.') ?>+</div><div class="stat-label">Artefak</div></div>
          <div class="stat"><div class="stat-num"><?= number_format($totalEventAktif,0,',','.') ?></div><div class="stat-label">Event Aktif</div></div>
          <div class="stat"><div class="stat-num"><?= htmlspecialchars($koleksiTertua) ?></div><div class="stat-label">Koleksi Tertua</div></div>
        </div>
      </div>

      <div class="hero-glass-card" onclick="location.href='koleksi.php?id=<?= (int)($koleksiPilihan['id'] ?? 0) ?>'">
        <div class="glass-card-label">Koleksi Pilihan</div>
        <div class="glass-koleksi-img">
          <?php if (!empty($koleksiPilihan['image_path'])): ?>
            <img src="<?= htmlspecialchars($koleksiPilihan['image_path']) ?>" alt="<?= htmlspecialchars($koleksiPilihan['nama_koleksi'] ?? '') ?>">
          <?php else: ?>
            <div class="img-placeholder"><span>[Foto Koleksi]</span></div>
          <?php endif; ?>
        </div>
        <div class="glass-card-cat"><?= htmlspecialchars(($koleksiPilihan['nama_kategori'] ?? 'Koleksi') . (!empty($koleksiPilihan['lokasi']) ? ' · ' . $koleksiPilihan['lokasi'] : '')) ?></div>
        <div class="glass-card-title">
          <?= htmlspecialchars($koleksiPilihan['nama_koleksi'] ?? 'Belum ada koleksi') ?>
          <?php if (!empty($koleksiPilihan['era'])): ?>
            <span style="font-family:var(--mono);font-size:11px;opacity:0.55;"> — <?= htmlspecialchars($koleksiPilihan['era']) ?></span>
          <?php endif; ?>
        </div>
        <div class="glass-card-body"><?= htmlspecialchars(potong_teks($koleksiPilihan['deskripsi'] ?? 'Data koleksi belum tersedia.', 130)) ?></div>
        <div class="glass-info-strip">
          <div class="glass-info-row"><span class="glass-info-key">Senin</span><span class="glass-info-val">Tutup</span></div>
          <div class="glass-info-row"><span class="glass-info-key">Sel – Jum</span><span class="glass-info-val">08:00 – 16:00 WIB</span></div>
          <div class="glass-info-row"><span class="glass-info-key">Sab – Min</span><span class="glass-info-val">08:00 – 15:00 WIB</span></div>
          <div class="glass-info-row"><span class="glass-info-key">Tiket</span><span class="glass-info-val" style="color:rgba(90,200,140,0.9);">Gratis</span></div>
        </div>
        <button class="glass-card-link">Lihat Detail Koleksi</button>
      </div>

    </div>
  </section>

  <!-- KOLEKSI SWIPER -->
  <section class="koleksi-swiper-section">
    <div class="koleksi-swiper-header">
      <div class="koleksi-swiper-header-left">
        <span class="koleksi-swiper-eyebrow">Katalog Digital</span>
        <h2 class="koleksi-swiper-title">Koleksi <em>Unggulan</em></h2>
      </div>
      <div style="display:flex;align-items:center;gap:20px;">
        <span style="font-family:var(--mono);font-size:8.5px;letter-spacing:0.14em;text-transform:uppercase;color:var(--sepia-lt);font-weight:500;"><?= number_format($totalKoleksi,0,',','.') ?> Artefak Terdokumentasi</span>
        <button class="btn-ghost" style="padding:9px 20px;" onclick="location.href='koleksi.php'">Lihat Semua →</button>
        <div class="koleksi-swiper-nav">
          <button class="swiper-btn" id="koleksi-prev">&#8592;</button>
          <button class="swiper-btn" id="koleksi-next">&#8594;</button>
        </div>
      </div>
    </div>

    <div class="koleksi-swiper-wrap" id="koleksiSwiperWrap">
      <div class="koleksi-swiper-track" id="koleksiSwiperTrack">
        <?php foreach ($koleksiUnggulan as $item): ?>
          <div class="k-slide" onclick="location.href='koleksi.php?id=<?= (int)$item['id'] ?>'">
            <div class="k-slide-img">
              <?php if (!empty($item['image_path'])): ?>
                <img src="<?= htmlspecialchars($item['image_path']) ?>" alt="<?= htmlspecialchars($item['nama_koleksi']) ?>" loading="lazy">
              <?php else: ?>
                <div class="k-slide-img-placeholder" data-num="<?= htmlspecialchars($item['nomor_tampil']) ?>"></div>
              <?php endif; ?>
              <?php if (!empty($item['nama_kategori'])): ?>
                <span class="k-slide-badge"><?= htmlspecialchars($item['nama_kategori']) ?></span>
              <?php endif; ?>
            </div>
            <div class="k-slide-body">
              <span class="k-slide-cat"><?= htmlspecialchars($item['nomor_tampil']) ?></span>
              <div class="k-slide-title"><?= htmlspecialchars($item['nama_koleksi']) ?></div>
              <?php if (!empty($item['deskripsi'])): ?>
                <div class="k-slide-desc"><?= htmlspecialchars(potong_teks($item['deskripsi'], 100)) ?></div>
              <?php endif; ?>
              <div class="k-slide-era"><?= htmlspecialchars(($item['era'] ?: '—') . ' · ' . ($item['nama_kategori'] ?: 'Koleksi')) ?></div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="koleksi-swiper-dots" id="koleksiDots"></div>
  </section>

  <!-- EVENT & BERITA -->
  <section style="padding:0 40px;max-width:var(--page-max);margin:0 auto;box-sizing:content-box;">
    <div class="twin-section">
      <div class="twin-col" style="padding-left:40px;">
        <div style="font-family:var(--mono);font-size:8.5px;letter-spacing:0.20em;text-transform:uppercase;color:var(--moss);font-weight:500;margin-bottom:8px;">Agenda</div>
        <h2 class="section-title" style="margin-bottom:28px;">Kegiatan &amp; <em>Event</em></h2>
        <div class="event-list">
          <?php foreach ($eventTerbaru as $ev): ?>
            <div class="event-item" onclick="location.href='event.php?id=<?= (int)$ev['id'] ?>'">
              <div class="event-date">
                <div class="event-dd"><?= date('d', strtotime($ev['tanggal_mulai'])) ?></div>
                <div class="event-mm"><?= format_bulan_pendek($ev['tanggal_mulai']) ?></div>
              </div>
              <div>
                <div class="event-title"><?= htmlspecialchars($ev['nama_event']) ?></div>
                <div class="event-meta">
                  <?= htmlspecialchars($ev['tempat'] ?: 'Lokasi belum diisi') ?>
                  <?php if (!empty($ev['jam'])): ?> · <?= date('H:i', strtotime($ev['jam'])) ?> WIB<?php endif; ?>
                  <?php if (!empty($ev['kategori'])): ?> · <?= htmlspecialchars($ev['kategori']) ?><?php endif; ?>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
        <div style="margin-top:24px;"><button class="btn-ghost" style="padding:9px 20px;" onclick="location.href='event.php'">Lihat Semua Event →</button></div>
      </div>
      <div class="twin-div"></div>
      <div class="twin-col" style="padding-right:40px;">
        <div style="font-family:var(--mono);font-size:8.5px;letter-spacing:0.20em;text-transform:uppercase;color:var(--moss);font-weight:500;margin-bottom:8px;">Publikasi</div>
        <h2 class="section-title" style="margin-bottom:28px;">Berita &amp; <em>Artikel</em></h2>
        <div class="berita-list">
          <?php foreach ($beritaTerbaru as $br): ?>
            <div class="berita-item" onclick="location.href='berita.php?id=<?= (int)$br['id'] ?>'">
              <div class="berita-cat"><?= htmlspecialchars($br['kategori'] ?: 'Berita') ?></div>
              <div class="berita-title"><?= htmlspecialchars($br['judul']) ?></div>
              <div class="berita-snippet"><?= htmlspecialchars(potong_teks($br['ringkasan'] ?: $br['judul'], 150)) ?></div>
              <div class="berita-date"><?= htmlspecialchars(format_tanggal_indo($br['tanggal_publish'])) ?></div>
            </div>
          <?php endforeach; ?>
        </div>
        <div style="margin-top:24px;"><button class="btn-ghost" style="padding:9px 20px;" onclick="location.href='berita.php'">Lihat Semua Berita →</button></div>
      </div>
    </div>
  </section>

  <!-- INFO BAND -->
  <div class="info-band" style="margin-top:48px;">
    <div class="info-band-inner">
      <div class="info-band-col"><div class="ib-label">Alamat</div><div class="ib-val">Jl. Bhayangkara No.1<br>Samarinda, Kalimantan Timur</div></div>
      <div class="info-band-div"></div>
      <div class="info-band-col"><div class="ib-label">Jam Buka</div><div class="ib-val">Sel – Jum · 08:00–16:00<br>Sab – Min · 08:00–15:00</div></div>
      <div class="info-band-div"></div>
      <div class="info-band-col"><div class="ib-label">Kontak</div><div class="ib-val">(0541) 123-4567<br>info@museumkotasamarinda.id</div></div>
      <div class="info-band-div"></div>
      <div class="info-band-col">
        <div class="ib-label">Tiket Masuk</div>
        <div class="ib-val large" style="font-style:italic;color:#a8e6c8;">Gratis</div>
        <div class="ib-val" style="font-size:12px;opacity:0.45;margin-top:2px;">untuk semua pengunjung</div>
      </div>
    </div>
  </div>

  <!-- ULASAN -->
  <section class="section">
    <div class="container">
      <div class="section-header">
        <div>
          <div style="font-family:var(--mono);font-size:8.5px;letter-spacing:0.20em;text-transform:uppercase;color:var(--moss);font-weight:500;margin-bottom:8px;">Suara Pengunjung</div>
          <h2 class="section-title">Ulasan &amp; <em>Kesan</em></h2>
        </div>
        <button class="btn-ghost" style="padding:9px 20px;" onclick="location.href='ulasan.php'">Tulis Ulasan →</button>
      </div>
      <div class="ulasan-grid">
        <?php if (!empty($ulasanTerbaru)): ?>
          <?php foreach ($ulasanTerbaru as $ul): ?>
            <div class="ulasan-card">
              <div class="ulasan-stars">
                <div class="star"></div><div class="star"></div><div class="star"></div>
                <div class="star"></div><div class="star"></div>
              </div>
              <div class="ulasan-text">"<?= htmlspecialchars(potong_teks($ul['isi_komentar'] ?? '', 180)) ?>"</div>
              <div class="ulasan-meta">
                <span class="ulasan-name"><?= htmlspecialchars($ul['nama'] ?? 'Pengunjung') ?></span>
                <span class="ulasan-date"><?= htmlspecialchars(format_tanggal_indo($ul['tanggal'] ?? '')) ?></span>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="ulasan-card">
            <div class="ulasan-stars">
              <div class="star"></div><div class="star"></div><div class="star"></div>
              <div class="star"></div><div class="star"></div>
            </div>
            <div class="ulasan-text">"Belum ada ulasan terbaru dari pengunjung."</div>
            <div class="ulasan-meta">
              <span class="ulasan-name">Museum Kota Samarinda</span>
              <span class="ulasan-date">Hari ini</span>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>

</div><!-- /page-beranda -->

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
          <button class="footer-link" onclick="location.href='login.php'">Masuk</button>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <span class="footer-copy">Museum Kota Samarinda · Dinas Kebudayaan Kota Samarinda</span>
      <span class="footer-copy">Dirancang untuk menjaga ingatan kota</span>
    </div>
  </div>
</footer>

<!-- ─── SWIPER JS ─── -->
<script>
(function () {
  const wrap    = document.getElementById('koleksiSwiperWrap');
  const track   = document.getElementById('koleksiSwiperTrack');
  const dotsC   = document.getElementById('koleksiDots');
  const btnPrev = document.getElementById('koleksi-prev');
  const btnNext = document.getElementById('koleksi-next');
  if (!track || !wrap) return;

  const slides = Array.from(track.querySelectorAll('.k-slide'));
  const GAP    = 20;
  let current  = 0, startX = 0, isDragging = false, dragDelta = 0;

  slides.forEach((_, i) => {
    const d = document.createElement('button');
    d.className = 'swiper-dot' + (i === 0 ? ' active' : '');
    d.addEventListener('click', () => goTo(i));
    dotsC.appendChild(d);
  });

  function getVisible() {
    const w = wrap.clientWidth - 2 * parseFloat(getComputedStyle(wrap).paddingLeft || 80);
    return Math.max(1, Math.floor((w + GAP) / ((slides[0]?.offsetWidth || 280) + GAP)));
  }
  function maxIndex() { return Math.max(0, slides.length - getVisible()); }

  function goTo(idx) {
    current = Math.max(0, Math.min(idx, maxIndex()));
    track.style.transform = `translateX(-${current * ((slides[0]?.offsetWidth || 280) + GAP)}px)`;
    dotsC.querySelectorAll('.swiper-dot').forEach((d, i) => d.classList.toggle('active', i === current));
    btnPrev.disabled = current === 0;
    btnNext.disabled = current >= maxIndex();
  }

  btnPrev.addEventListener('click', () => goTo(current - 1));
  btnNext.addEventListener('click', () => goTo(current + 1));

  wrap.addEventListener('mousedown', e => { isDragging = true; startX = e.clientX; track.style.transition = 'none'; });
  window.addEventListener('mousemove', e => {
    if (!isDragging) return;
    dragDelta = e.clientX - startX;
    track.style.transform = `translateX(-${current * ((slides[0]?.offsetWidth || 280) + GAP) - dragDelta}px)`;
  });
  window.addEventListener('mouseup', () => {
    if (!isDragging) return;
    isDragging = false; track.style.transition = '';
    goTo(dragDelta < -60 ? current + 1 : dragDelta > 60 ? current - 1 : current);
    dragDelta = 0;
  });
  wrap.addEventListener('touchstart', e => { startX = e.touches[0].clientX; track.style.transition = 'none'; }, {passive:true});
  wrap.addEventListener('touchmove', e => {
    dragDelta = e.touches[0].clientX - startX;
    track.style.transform = `translateX(-${current * ((slides[0]?.offsetWidth || 280) + GAP) - dragDelta}px)`;
  }, {passive:true});
  wrap.addEventListener('touchend', () => {
    track.style.transition = '';
    goTo(dragDelta < -60 ? current + 1 : dragDelta > 60 ? current - 1 : current);
    dragDelta = 0;
  });

  goTo(0);
  window.addEventListener('resize', () => goTo(Math.min(current, maxIndex())));
})();
</script>

</body>
</html>