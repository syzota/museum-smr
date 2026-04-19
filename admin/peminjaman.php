<?php 
$activePage = 'peminjaman'; 

require_once __DIR__ . '/../templates/admin/header.php'; 
require_once __DIR__ . '/../templates/admin/topbar.php'; 
?>

<link rel="stylesheet" href="../assets/css/admin.css">

<div class="admin-layout">
    <?php require_once __DIR__ . '/../templates/admin/sidebar.php'; ?>

    <main class="main-content">
        <div id="sec-peminjaman" class="section-card visible">
            <div class="section-head">
                <div class="section-title-group">
                    <div class="section-label">04 — Layanan</div>
                    <div class="section-title">Permohonan <em style="font-style:italic;">Peminjaman</em></div>
                </div>
                
                <div style="display:flex; gap:8px; align-items:center;">
                    <button class="filter-tab active" onclick="filterPeminj('semua', this)">Semua</button>
                    <button class="filter-tab" onclick="filterPeminj('pending', this)">Pending</button>
                    <button class="filter-tab" onclick="filterPeminj('disetujui', this)">Disetujui</button>
                    <button class="filter-tab" onclick="filterPeminj('ditolak', this)">Ditolak</button>
                </div>
            </div>

            <div class="peminjaman-grid" id="peminjaman-grid"></div>
        </div>
    </main>
</div>

<?php 
require_once __DIR__ . '/../templates/admin/confirm-dialog.php'; 
require_once __DIR__ . '/../templates/admin/toast.php'; 
require_once __DIR__ . '/../templates/admin/footer.php'; 
?>