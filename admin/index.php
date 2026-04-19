<?php $activePage = 'dashboard'; ?>
<?php require_once __DIR__ . '/../templates/admin/header.php'; ?>
<?php require_once __DIR__ . '/../templates/admin/topbar.php'; ?>

<link rel="stylesheet" href="../assets/css/admin.css">

<div class="admin-layout">
  <?php require_once __DIR__ . '/../templates/admin/sidebar.php'; ?>

  <main class="main-content">
    <div id="sec-dashboard" class="section-card visible">
      <div class="section-head">
        <div class="section-title-group">
          <div class="section-label">Ringkasan</div>
          <div class="section-title"><strong>Dashboard Admin</strong></div>
        </div>
        <div style="font-family:'DM Mono',monospace;font-size:8px;letter-spacing:1.08px;text-transform:uppercase;color:var(--text-light);" id="current-date"></div>
      </div>
      <div style="padding:28px;">
        <div class="stats-row">
          <div class="stat-card">
            <div class="stat-num" id="stat-koleksi">—</div>
            <div class="stat-label"><strong>Total Koleksi</strong></div>
          </div>
          <div class="stat-card">
            <div class="stat-num" id="stat-kegiatan">—</div>
            <div class="stat-label"><strong>Kegiatan Aktif</strong></div>
          </div>
          <div class="stat-card">
            <div class="stat-num" id="stat-berita">—</div>
            <div class="stat-label"><strong>Berita Tayang</strong></div>
          </div>
          <div class="stat-card" style="border-right:none;">
            <div class="stat-num" id="stat-peminjaman">—</div>
            <div class="stat-label"><strong>Permohonan Pending</strong></div>
          </div>
        </div>

        <div style="font-family:'Spectral',serif;font-size:15px;font-weight:300;color:var(--text-mid);line-height:1.7;border-top:0.667px solid var(--border-tan);padding-top:24px;">
          Selamat datang di panel administrasi <em><strong>Museum Kota Samarinda</strong></em>. 
          Gunakan <strong>navigasi di kiri</strong> untuk mengelola 
          <strong>konten dan layanan museum</strong>. 
          Semua perubahan akan <strong>langsung tercermin di halaman publik</strong>
        </div>

        <div style="margin-top:40px;">
          <div class="section-head" style="margin-bottom:20px;">
            <div class="section-title-group">
              <div class="section-label">Statistik</div>
              <div class="section-title"><strong>Grafik Ringkasan</strong></div>
            </div>
          </div>
          <div class="chart-box">
          <canvas id="statsChart"></canvas>
        </div>
        </div>
      </div>
    </div>
  </main>
</div>

<?php require_once __DIR__ . '/../templates/admin/toast.php'; ?>
<?php require_once __DIR__ . '/../templates/admin/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="../assets/js/admin-museum-samarinda.js"></script>