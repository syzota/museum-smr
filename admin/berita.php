<?php $activePage = 'berita'; ?>
<?php require_once __DIR__ . '/../templates/admin/header.php'; ?>
<?php require_once __DIR__ . '/../templates/admin/topbar.php'; ?>

<link rel="stylesheet" href="../assets/css/admin.css">

<div class="admin-layout">
  <?php require_once __DIR__ . '/../templates/admin/sidebar.php'; ?>

  <main class="main-content">
    <div id="sec-berita" class="section-card visible">
      <div class="section-head">
        <div class="section-title-group">
          <div class="section-label">03 — Kelola Konten</div>
          <div class="section-title">Berita & <em style="font-style:italic;">Informasi</em></div>
        </div>
        <div style="display:flex;gap:12px;align-items:center;">
          <div class="search-wrap">
            <span class="search-icon">⊕</span>
            <input type="text" class="search-input" placeholder="Cari berita..." oninput="filterTable('berita-table',this.value)">
          </div>
          <button class="btn btn-primary" onclick="openModal('modal-berita','create')">+ Tambah Berita</button>
        </div>
      </div>
      <div class="filter-bar">
        <button class="filter-tab active" onclick="filterKatBerita('',this)">Semua</button>
      </div>
      <table class="data-table" id="berita-table">
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>Judul Berita</th>
            <th>Kategori</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody id="berita-tbody"></tbody>
      </table>
    </div>
  </main>
</div>

<?php require_once __DIR__ . '/../templates/admin/modal-berita.php'; ?>
<?php require_once __DIR__ . '/../templates/admin/confirm-dialog.php'; ?>
<?php require_once __DIR__ . '/../templates/admin/toast.php'; ?>
<?php require_once __DIR__ . '/../templates/admin/footer.php'; ?>