<?php
header('Content-Type: application/json');
require_once '../config/db.php';
$db = getDB();
$method = $_SERVER['REQUEST_METHOD'];
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

try {
    switch ($method) {
        case 'GET':
            if ($id) {
                // Mengambil data spesifik untuk EDIT
                $stmt = $db->prepare("SELECT id, nama_event AS nama, deskripsi, tanggal_mulai AS tanggal, jam, kategori, tempat, status FROM event WHERE id = ?");
                $stmt->execute([$id]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                echo json_encode($row ?: ['error' => 'Data tidak ditemukan']);
            } else {
                // Mengambil semua data untuk TABEL
                $stmt = $db->query("SELECT id, nama_event AS nama, tanggal_mulai AS tanggal, jam, kategori, tempat, status FROM event ORDER BY tanggal_mulai DESC");
                echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            }
            break;

        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            // tanggal_selesai diisi sama dengan tanggal_mulai karena input kita cuma satu
            $stmt = $db->prepare("INSERT INTO event (nama_event, deskripsi, tanggal_mulai, tanggal_selesai, jam, kategori, tempat, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'Aktif')");
            $stmt->execute([
                $data['nama'], 
                $data['deskripsi'] ?? '', 
                $data['tanggal'], 
                $data['tanggal'], // Untuk kolom tanggal_selesai
                $data['jam'], 
                $data['kategori'], 
                $data['tempat']
            ]);
            echo json_encode(['success' => true, 'id' => $db->lastInsertId()]);
            break;

        case 'PUT':
            $data = json_decode(file_get_contents('php://input'), true);
            $stmt = $db->prepare("UPDATE event SET nama_event=?, deskripsi=?, tanggal_mulai=?, tanggal_selesai=?, jam=?, kategori=?, tempat=? WHERE id=?");
            $stmt->execute([
                $data['nama'], 
                $data['deskripsi'], 
                $data['tanggal'], 
                $data['tanggal'], // Update tanggal_selesai juga
                $data['jam'], 
                $data['kategori'], 
                $data['tempat'], 
                $data['id']
            ]);
            echo json_encode(['success' => true]);
            break;

        case 'DELETE':
            $data = json_decode(file_get_contents('php://input'), true);
            $delId = $data['id'] ?? $id;
            $db->prepare("DELETE FROM event WHERE id = ?")->execute([$delId]);
            echo json_encode(['success' => true]);
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}