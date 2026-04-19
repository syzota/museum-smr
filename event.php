<?php 
require_once __DIR__ . '/config/auth.php';
require_once __DIR__ . '/config/db.php';

$pdo = getDB();

// ─── Helper Functions ───
function format_tanggal_event($tanggal) {
    if (!$tanggal) return ['dd'=>'--', 'mm'=>'---', 'yyyy'=>'----'];
    $ts = strtotime($tanggal);
    if (!$ts) return ['dd'=>'--', 'mm'=>'---', 'yyyy'=>'----'];
    $bulan = [1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'Mei',6=>'Jun',
              7=>'Jul',8=>'Agu',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des'];
    return [
        'dd' => date('d', $ts),
        'mm' => $bulan[(int)date('n', $ts)] ?? '---',
        'yyyy' => date('Y', $ts)
    ];
}

function potong_teks($text, $limit = 120) {
    $text = trim(strip_tags((string)$text));
    if (mb_strlen($text) <= $limit) return $text;
    return mb_substr($text, 0, $limit) . '...';
}

// ─── Query Data Event ───
$eventMendatang = [];
$eventSegera = [];
$kategoriStats = [];

try {
    // Event utama: ambil 10 event aktif terdekat
    $stmt = $pdo->prepare("
        SELECT id, nama_event, deskripsi, tanggal_mulai, jam, kategori, tempat, status 
        FROM event 
        WHERE status = 'Aktif' AND tanggal_mulai >= CURDATE()
        ORDER BY tanggal_mulai ASC, jam ASC 
        LIMIT 10
    ");
    $stmt->execute();
    $eventMendatang = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Event sidebar: ambil 3 event terdekat untuk "Segera Berlangsung"
    $stmt = $pdo->prepare("
        SELECT id, nama_event, tanggal_mulai, jam, tempat 
        FROM event 
        WHERE status = 'Aktif' AND tanggal_mulai >= CURDATE()
        ORDER BY tanggal_mulai ASC, jam ASC 
        LIMIT 3
    ");
    $stmt->execute();
    $eventSegera = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Stats kategori untuk sidebar
    $stmt = $pdo->query("
        SELECT kategori AS nama, COUNT(*) as total 
        FROM event 
        WHERE status = 'Aktif' 
        GROUP BY kategori
    ");
    $kategoriStats = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (Throwable $e) {
    // Fail silently or log error
    error_log("Event page error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Event & Kegiatan · Museum Kota Samarinda</title>
<link rel="icon" type="image/png" href="assets/logo.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=DM+Mono:wght@300;400&family=Spectral:ital,wght@0,200;0,300;0,400;1,200;1,300&display=swap" rel="stylesheet">

<link rel="stylesheet" href="assets/css/event.css">
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
      <button class="nav-item active" onclick="location.href='event.php'">Event & Kegiatan</button>
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
  </div>
</div>

<!-- ════════════════════════════════════════════
     PAGE: EVENT & KEGIATAN
════════════════════════════════════════════ -->
<div id="page-event" class="page active">
  <div class="page-banner">
    <div class="container">
      <div class="page-banner-inner">
        <div>
          <div class="page-banner-breadcrumb">Museum Kota Samarinda / Event &amp; Kegiatan</div>
          <h1 class="page-banner-title">Event &amp; <em>Kegiatan</em></h1>
          <p class="page-banner-desc">Program publik, pameran, workshop, dan diskusi yang terbuka untuk masyarakat umum.</p>
        </div>
        <button class="btn-primary" onclick="location.href='peminjaman.php'">Ajukan Kegiatan →</button>
      </div>
    </div>
  </div>

  <section class="section">
    <div class="container">
      <div class="section-header">
        <div class="koleksi-filter">
          <button class="filter-btn active">Semua</button>
          <button class="filter-btn">Tetap up-to-date!</button>
        </div>
      </div>

      <div class="event-full-grid">
        <div class="event-main">
          
          <?php if (empty($eventMendatang)): ?>
            <div style="padding:60px 28px;text-align:center;font-family:var(--alt-serif);color:var(--sepia);">
              Belum ada agenda event yang dijadwalkan.<br>
              <small style="font-family:var(--mono);font-size:10px;color:var(--sepia-lt);margin-top:8px;display:block;">
                Cek kembali nanti atau hubungi kami untuk info terbaru.
              </small>
            </div>
          <?php else: ?>
            
            <?php foreach ($eventMendatang as $ev): 
              $date = format_tanggal_event($ev['tanggal_mulai']);
              $badge = '';
              if ($ev['status'] === 'Penuh') {
                $badge = '<span class="efi-tag full">Kuota Penuh</span>';
              } elseif (in_array($ev['kategori'], ['Pameran', 'Diskusi', 'Edukasi', 'Peringatan'])) {
                $badge = '<span class="efi-tag">Terbuka Umum</span>';
              }
            ?>
            <div class="event-full-item">
              <div class="efi-date">
                <div class="efi-dd"><?= $date['dd'] ?></div>
                <div class="efi-mm"><?= $date['mm'] ?></div>
                <div class="efi-yr"><?= $date['yyyy'] ?></div>
              </div>
              <div class="efi-div"></div>
              <div class="efi-content">
                <div class="efi-cat"><?= htmlspecialchars($ev['kategori'] ?? 'Umum') ?></div>
                <div class="efi-title"><?= htmlspecialchars($ev['nama_event']) ?></div>
                <div class="efi-meta">
                  <?= htmlspecialchars($ev['tempat'] ?? '-') ?> 
                  <?php if (!empty($ev['jam'])): ?>· <?= htmlspecialchars($ev['jam']) ?> WIB<?php endif; ?>
                  <?php if ($ev['status'] !== 'Penuh'): ?>· Gratis<?php endif; ?>
                </div>
                <div class="efi-desc"><?= htmlspecialchars(potong_teks($ev['deskripsi'], 180)) ?></div>
                <?= $badge ?>
              </div>
            </div>
            <?php endforeach; ?>
            
          <?php endif; ?>
          
        </div>

        <!-- ─── SIDEBAR ─── -->
        <div class="event-sidebar">
          
          <!-- Segera Berlangsung -->
          <div>
            <div class="sidebar-title">Segera Berlangsung</div>
            <div style="height:12px;"></div>
            <div class="sidebar-mini">
              <?php if (empty($eventSegera)): ?>
                <div style="font-family:var(--alt-serif);font-size:12px;color:var(--sepia);padding:8px 0;">
                  Tidak ada event dalam 7 hari ke depan.
                </div>
              <?php else: ?>
                <?php foreach ($eventSegera as $ev): 
                  $date = format_tanggal_event($ev['tanggal_mulai']);
                ?>
                <div class="sidebar-mini-item">
                  <div class="smi-date-box">
                    <div class="smi-dd"><?= $date['dd'] ?></div>
                    <div class="smi-mm"><?= $date['mm'] ?></div>
                  </div>
                  <div>
                    <div class="smi-title"><?= htmlspecialchars($ev['nama_event']) ?></div>
                    <div class="smi-meta">
                      <?= !empty($ev['jam']) ? date('H:i', strtotime($ev['jam'])) : '-' ?> 
                      · <?= htmlspecialchars($ev['tempat'] ?? '-') ?>
                    </div>
                  </div>
                </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>
          
          <!-- Kategori Stats -->
          <div style="border-top:0.5px solid var(--cream-dk);padding-top:20px;">
            <div class="sidebar-title">Kategori</div>
            <div style="height:12px;"></div>
            <div style="display:flex;flex-direction:column;gap:8px;">
              <?php 
              $defaultKategori = [
                ['nama'=>'Pameran','total'=>0],
                ['nama'=>'Workshop','total'=>0],
                ['nama'=>'Diskusi & Seminar','total'=>0],
                ['nama'=>'Edukasi Sekolah','total'=>0]
              ];
              $allKategori = array_merge($defaultKategori, $kategoriStats);
              // Group by nama agar tidak duplikat
              $grouped = [];
              foreach ($allKategori as $k) {
                $key = $k['nama'];
                if (!isset($grouped[$key])) $grouped[$key] = 0;
                $grouped[$key] += (int)($k['total'] ?? 0);
              }
              foreach ($grouped as $nama => $total): 
              ?>
                <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:0.5px dashed var(--cream-dk);">
                  <span style="font-family:var(--alt-serif);font-size:13px;color:var(--ink);"><?= htmlspecialchars($nama) ?></span>
                  <span style="font-family:var(--mono);font-size:8.5px;color:var(--sepia-lt);"><?= (int)$total ?> event</span>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
          
          <!-- CTA Peminjaman -->
          <div style="border-top:0.5px solid var(--cream-dk);padding-top:20px;">
            <div class="sidebar-title">Selenggarakan Event</div>
            <p style="font-family:var(--alt-serif);font-size:12.5px;font-weight:300;line-height:1.65;color:var(--sepia);margin-top:8px;margin-bottom:16px;">
              Museum menyediakan ruang untuk penyelenggaraan kegiatan publik yang berkaitan dengan sejarah dan kebudayaan.
            </p>
            <button class="btn-primary" style="width:100%;text-align:center;" onclick="location.href='peminjaman.php'">Peminjaman Ruang →</button>
          </div>
          
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

<script src="assets/js/event.js"></script>
<script src="assets/js/scroll-fade-in.js"></script>
</body>
</html>