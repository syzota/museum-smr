<?php
/**
 * templates/admin/header.php
 *
 * Header HTML untuk panel admin.
 * Melindungi SEMUA halaman admin — wajib di-include pertama
 * sebelum konten apapun.
 */

// Dua level atas (dari /admin/) menuju root
require_once __DIR__ . '/../../config/auth.php';

// Proteksi: hanya admin yang boleh masuk
requireAdmin();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin — Museum Kota Samarinda</title>
<link rel="icon" type="image/png" href="../assets/logo.png">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=DM+Mono:wght@400;500&family=Spectral:ital,wght@0,300;0,400;1,300&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/admin.css">
<link rel="stylesheet" href="../assets/css/scroll-fade-in.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  if (localStorage.getItem('adminSidebar') === 'open') {
    document.documentElement.classList.add('sidebar-preopen');
  }
</script>
<style>
  html.sidebar-preopen .sidebar { transform: translateX(0) !important; }
  html.sidebar-preopen .main-content { margin-left: 220px !important; }
</style>
</head>
<body data-page="<?= htmlspecialchars($activePage ?? 'dashboard') ?>">