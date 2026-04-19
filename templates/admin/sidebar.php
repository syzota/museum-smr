<!-- SIDEBAR -->
<nav class="sidebar">
  <div class="sidebar-section">Utama</div>
  <a class="nav-item <?= $activePage==='dashboard'?'active':'' ?>" href="index.php">
    <span class="nav-icon">◈</span> Ringkasan
  </a>

  <div class="sidebar-section" style="margin-top:16px;">Konten</div>
  <a class="nav-item <?= $activePage==='koleksi'?'active':'' ?>" href="koleksi.php">
    <span class="nav-icon">◇</span> Koleksi Museum  
  </a>
  <a class="nav-item <?= $activePage==='kegiatan'?'active':'' ?>" href="event.php">
    <span class="nav-icon">◈</span> Kalender Kegiatan
  </a>
  <a class="nav-item <?= $activePage==='berita'?'active':'' ?>" href="berita.php">
    <span class="nav-icon">◉</span> Berita & Informasi
  </a>

  <div class="sidebar-section" style="margin-top:16px;">Layanan</div>
  <a class="nav-item <?= $activePage==='peminjaman'?'active':'' ?>" href="peminjaman.php">
    <span class="nav-icon">◎</span> Peminjaman Ruang
  </a>
</nav>
