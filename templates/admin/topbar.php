<?php
/**
 * templates/admin/topbar.php
 *
 * Topbar panel admin — otomatis menampilkan nama & email
 * dari session yang aktif.
 *
 * Wajib: auth.php sudah di-include di halaman yang memanggilnya.
 * requireAdmin() dipanggil di halaman masing-masing (bukan di sini)
 * supaya error message bisa disesuaikan per halaman.
 */

$adminUser = currentUser();
?>
<!-- TOPBAR -->
<div class="topbar">
  <div class="topbar-left">
    <button class="btn-menu" type="button" aria-label="Buka menu admin" id="admin-menu-toggle">
      <span class="btn-menu-lines"><span></span><span></span><span></span></span>
    </button>
    <div class="topbar-logo">
      Museum <em>Kota</em> Samarinda
    </div>
    <span class="topbar-badge">Dashboard Admin</span>
  </div>
  <div class="topbar-user">
    <span class="topbar-info">
      Admin ·
      <?= $adminUser ? htmlspecialchars($adminUser['email']) : 'administrator' ?>
    </span>
    <button class="btn-logout">Keluar →</button>
  </div>
</div>

<div class="sidebar-backdrop" id="admin-sidebar-backdrop"></div>