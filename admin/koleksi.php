<?php $activePage = 'koleksi'; ?>
<?php require_once __DIR__ . '/../templates/admin/header.php'; ?>
<?php require_once __DIR__ . '/../templates/admin/topbar.php'; ?>

<link rel="stylesheet" href="../assets/css/admin.css">

<div class="admin-layout">
  <?php require_once __DIR__ . '/../templates/admin/sidebar.php'; ?>

  <main class="main-content">
    <div id="sec-koleksi" class="section-card visible">
      <div class="section-head">
        <div class="section-title-group">
          <div class="section-label">01 — Kelola Konten</div>
          <div class="section-title">Koleksi <em style="font-style:italic;">Museum</em></div>
        </div>
        <div style="display:flex;gap:12px;align-items:center;">
          <div class="search-wrap">
            <span class="search-icon">⊕</span>
            <input type="text" class="search-input" placeholder="Cari koleksi..." oninput="filterTable('koleksi-table',this.value)">
          </div>
          <button class="btn btn-primary" onclick="openModal('modal-koleksi','create')">+ Tambah Koleksi</button>
        </div>
      </div>
      <div class="filter-bar">
        <button class="filter-tab active" onclick="filterKat('',this)">Semua</button>
        <button class="filter-tab" onclick="filterKat('mangkok', this)">Mangkok</button>
        <button class="filter-tab" onclick="filterKat('guci', this)">Guci</button>
        <button class="filter-tab" onclick="filterKat('alat musik', this)">Alat Musik</button>
        <button class="filter-tab" onclick="filterKat('etnografika',this)">Etnografika</button>
        <button class="filter-tab" onclick="filterKat('keramnologi',this)">Keramnologi</button>
        <button class="filter-tab" onclick="filterKat('mandau',this)">Mandau</button>
        
        <button class="filter-tab" onclick="filterKat('kerajinan tangan',this)">Kerajinan Tangan</button>
        <button class="filter-tab" onclick="filterKat('bluko',this)">Bluko</button>
        <button class="filter-tab" onclick="filterKat('obat tradisional',this)">Obat Tradisional</button>
        <button class="filter-tab" onclick="filterKat('sarung',this)">Sarung</button>
      </div>
      <table class="data-table" id="koleksi-table">
        <thead>
          <tr>
            <th>No. Koleksi</th>
            <th>Nama Koleksi</th>
            <th>Kategori</th>
            <th>Era</th>
            <th>Kondisi</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody id="koleksi-tbody"></tbody>
      </table>
    </div>
  </main>
</div>

<?php require_once __DIR__ . '/../templates/admin/modal-koleksi.php'; ?>
<?php require_once __DIR__ . '/../templates/admin/confirm-dialog.php'; ?>
<?php require_once __DIR__ . '/../templates/admin/toast.php'; ?>
<?php require_once __DIR__ . '/../templates/admin/footer.php'; ?>

