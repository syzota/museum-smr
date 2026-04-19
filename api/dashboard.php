<?php
header('Content-Type: application/json');
require_once '../config/db.php';

echo json_encode([
    'koleksi'     => $pdo->query("SELECT COUNT(*) FROM koleksi")->fetchColumn(),
    'kegiatan'    => $pdo->query("SELECT COUNT(*) FROM event WHERE tanggal_selesai >= CURDATE()")->fetchColumn(),
    'berita'      => $pdo->query("SELECT COUNT(*) FROM berita WHERE tanggal_publish <= CURDATE()")->fetchColumn(),
    'peminjaman'  => $pdo->query("SELECT COUNT(*) FROM peminjaman_ruang WHERE status='pending'")->fetchColumn(),
]);