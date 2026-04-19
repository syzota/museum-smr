<?php $activePage = 'kegiatan'; ?>
<?php require_once __DIR__ . '/../templates/admin/header.php'; ?>
<?php require_once __DIR__ . '/../templates/admin/topbar.php'; ?>

<link rel="stylesheet" href="../assets/css/admin.css">

<div class="admin-layout">
  <?php require_once __DIR__ . '/../templates/admin/sidebar.php'; ?>

  <main class="main-content">
    <div id="sec-kegiatan" class="section-card visible">
      <div class="section-head">
        <div class="section-title-group">
          <div class="section-label">02 — Kelola Konten</div>
          <div class="section-title">Kalender <em style="font-style:italic;">Kegiatan</em></div>
        </div>
        <div style="display:flex;gap:12px;align-items:center;">
          <div class="search-wrap">
            <span class="search-icon">⊕</span>
            <input type="text" class="search-input" placeholder="Cari kegiatan..." oninput="filterTable('kegiatan-table',this.value)">
          </div>
          <button class="btn btn-primary" onclick="openModal('modal-kegiatan','create')">+ Tambah Kegiatan</button>
        </div>
      </div>
      <div class="filter-bar">
        <button class="filter-tab active" onclick="filterKatKeg('',this)">Semua</button>
        <button class="filter-tab" onclick="filterKatKeg('pameran',this)">Pameran</button>
        <button class="filter-tab" onclick="filterKatKeg('workshop',this)">Workshop</button>
        <button class="filter-tab" onclick="filterKatKeg('diskusi',this)">Diskusi</button>
        <button class="filter-tab" onclick="filterKatKeg('edukasi',this)">Edukasi</button>
      </div>
      <table class="data-table" id="kegiatan-table">
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>Nama Kegiatan</th>
            <th>Tempat</th>
            <th>Kategori</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody id="kegiatan-tbody"></tbody>
      </table>
    </div>
  </main>
</div>

<?php require_once __DIR__ . '/../templates/admin/modal-kegiatan.php'; ?>
<?php require_once __DIR__ . '/../templates/admin/confirm-dialog.php'; ?>
<?php require_once __DIR__ . '/../templates/admin/toast.php'; ?>
<?php require_once __DIR__ . '/../templates/admin/footer.php'; ?>

