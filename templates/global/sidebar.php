<?php
$user         = currentUser();
$currentPage  = basename($_SERVER['PHP_SELF']);

$inisial = 'O';
if ($user) {
    $parts   = explode(' ', $user['nama']);
    $inisial = strtoupper(mb_substr($parts[0], 0, 1));
    if (count($parts) > 1) {
        $inisial .= strtoupper(mb_substr(end($parts), 0, 1));
    }
}

$navItems = [
    ['href' => 'index.html',       'icon' => '⌂',  'label' => 'Rumah'],
    ['href' => 'tentang.php',     'icon' => '○',  'label' => 'Tentang Museum'],
    ['href' => 'koleksi.php',     'icon' => '◇',  'label' => 'Koleksi'],
    ['href' => 'event.php',       'icon' => '◌',  'label' => 'Kegiatan', 'badge' => '3'],
    ['href' => 'berita.php',      'icon' => '◉',  'label' => 'Berita'],
    ['href' => 'peminjaman.php',  'icon' => '▣',  'label' => 'Pinjam Ruangan'],
    ['href' => 'peta.php',        'icon' => '■',  'label' => 'Kunjungi'],
    ['href' => 'ulasan.php',      'icon' => '◔',  'label' => 'Ulasan'],
];
?>
<div class="global-sidebar-backdrop" data-sidebar-close></div>
<aside class="global-sidebar" id="global-sidebar" aria-hidden="true">

  <div class="global-sidebar-head">
    <div class="global-sidebar-row">
      <div class="global-sidebar-avatar"><?= htmlspecialchars($inisial) ?></div>
      <button class="global-sidebar-close" type="button" aria-label="Tutup navigasi" data-sidebar-close>×</button>
    </div>

    <?php if ($user): ?>
      <div class="global-sidebar-title"><?= htmlspecialchars($user['nama']) ?></div>
      <div class="global-sidebar-subtitle"><?= htmlspecialchars($user['email']) ?></div>
      <?php if ($user['role'] === 'admin'): ?>
        <div style="font-family:'DM Mono',monospace;font-size:9px;letter-spacing:1px;text-transform:uppercase;
                    color:var(--rust,#b5451b);margin-top:4px;">
          ◈ Administrator
        </div>
      <?php endif; ?>
    <?php else: ?>
      <div class="global-sidebar-title">Selamat Datang</div>
      <div class="global-sidebar-subtitle">Masuk untuk akses penuh</div>
    <?php endif; ?>
  </div>

  <div class="global-sidebar-section">Navigasi</div>
  <nav class="global-sidebar-nav">
    <?php foreach ($navItems as $item): ?>
      <a class="global-sidebar-link <?= $currentPage === $item['href'] ? 'active' : '' ?>"
         href="<?= $item['href'] ?>"
         data-nav-key="<?= $item['href'] ?>">
        <span class="global-sidebar-icon"><?= $item['icon'] ?></span>
        <span><?= htmlspecialchars($item['label']) ?></span>
        <?php if (!empty($item['badge'])): ?>
          <span class="global-sidebar-badge"><?= htmlspecialchars($item['badge']) ?></span>
        <?php endif; ?>
      </a>
    <?php endforeach; ?>
  </nav>

  <div class="global-sidebar-actions">
    <?php if ($user): ?>
      <?php if ($user['role'] === 'admin'): ?>
        <button class="global-sidebar-btn primary" type="button"
                onclick="location.href='admin/index.php'">
          Dashboard Admin →
        </button>
      <?php endif; ?>
      <button class="global-sidebar-btn ghost" type="button"
              onclick="location.href='proses/logout.php'">
        Keluar
      </button>
    <?php else: ?>
      <button class="global-sidebar-btn primary" type="button"
              onclick="location.href='signup.php'">
        Daftar Akun
      </button>
      <button class="global-sidebar-btn ghost" type="button"
              onclick="location.href='login.php'">
        Masuk
      </button>
    <?php endif; ?>
  </div>

</aside>