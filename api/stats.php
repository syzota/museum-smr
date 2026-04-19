<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once '../config/db.php';
$db = getDB();

try {
    echo json_encode([
        'koleksi'    => (int) $db->query("SELECT COUNT(*) FROM koleksi")->fetchColumn(),
        'kegiatan'   => (int) $db->query("SELECT COUNT(*) FROM event WHERE tanggal_selesai >= CURDATE() AND status = 'Aktif'")->fetchColumn(),
        'berita'     => (int) $db->query("SELECT COUNT(*) FROM berita WHERE tanggal_publish <= CURDATE()")->fetchColumn(),
        'peminjaman' => (int) $db->query("SELECT COUNT(*) FROM peminjaman_ruang WHERE status = 'pending'")->fetchColumn(),
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}