<?php
$user = currentUser();
?>
<div class="global-topbar">
  <div class="global-topbar-brand">
    <button class="global-menu-toggle" type="button" aria-label="Buka navigasi" data-sidebar-toggle>
      <span class="global-menu-toggle-lines"><span></span><span></span><span></span></span>
    </button>
    <div class="global-brand-title" onclick="location.href='index.html'" style="cursor:pointer;">
      Museum <em>Kota</em> Samarinda
    </div>
  </div>

  <div class="global-topbar-meta" style="display:flex;gap:8px;align-items:center;">
    <?php if ($user): ?>
      <?php if ($user['role'] === 'admin'): ?>
        <span style="font-family:'DM Mono',monospace;font-size:10px;letter-spacing:0.5px;color:var(--text-light);opacity:0.7;">
          Admin
        </span>
        <button class="nav-item" onclick="location.href='admin/index.php'" style="font-size:11px;padding:5px 10px;">
          Dashboard
        </button>
      <?php else: ?>
        <span style="font-family:'DM Mono',monospace;font-size:10px;letter-spacing:0.5px;color:var(--text-light);opacity:0.7;">
          <?= htmlspecialchars($user['nama']) ?>
        </span>
      <?php endif; ?>
      <button class="nav-item" onclick="location.href='proses/logout.php'" style="font-size:11px;padding:5px 10px;">
        Keluar
      </button>
    <?php else: ?>
      <button class="nav-item <?= (basename($_SERVER['PHP_SELF']) === 'login.php') ? 'active' : '' ?>"
              onclick="location.href='login.php'" style="font-size:11px;padding:5px 10px;">
        Masuk
      </button>
      <button class="nav-item <?= (basename($_SERVER['PHP_SELF']) === 'signup.php') ? 'active' : '' ?>"
              onclick="location.href='signup.php'" style="font-size:11px;padding:5px 10px;">
        Daftar
      </button>
    <?php endif; ?>
  </div>
</div>