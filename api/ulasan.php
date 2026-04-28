<?php
header('Content-Type: application/json');
require_once '../config/db.php';
require_once '../config/auth.php';

$db     = getDB();
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

// ── GET — ambil semua komentar ────────────────────────────────────────────────
if ($method === 'GET') {
    try {
        $stmt = $db->query("
            SELECT
                k.id,
                k.user_id,
                k.isi_komentar,
                k.tanggal,
                a.nama
            FROM komentar k
            JOIN akun a ON a.id = k.user_id
            ORDER BY k.tanggal DESC
        ");

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['komentar' => $rows]);
    } catch (Throwable $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit;
}

// ── POST — submit komentar baru ───────────────────────────────────────────────
if ($method === 'POST') {
    if (!isLoggedIn()) {
        http_response_code(401);
        echo json_encode(['error' => 'Anda harus login untuk mengirim komentar.']);
        exit;
    }

    $raw  = file_get_contents('php://input');
    $data = json_decode($raw, true);
    $isi  = trim($data['isi_komentar'] ?? '');

    if (strlen($isi) < 5) {
        http_response_code(422);
        echo json_encode(['error' => 'Komentar terlalu pendek.']);
        exit;
    }

    $userId = $_SESSION['user_id'] ?? null;

    if (!$userId) {
        http_response_code(401);
        echo json_encode(['error' => 'Sesi tidak valid.']);
        exit;
    }

    try {
        $stmt = $db->prepare("
            INSERT INTO komentar (user_id, isi_komentar)
            VALUES (:user_id, :isi)
        ");

        $stmt->execute([
            ':user_id' => $userId,
            ':isi'     => $isi,
        ]);

        $newId = $db->lastInsertId();

        $fetch = $db->prepare("
            SELECT k.id, k.isi_komentar, k.tanggal, a.nama
            FROM komentar k
            JOIN akun a ON a.id = k.user_id
            WHERE k.id = ?
        ");

        $fetch->execute([$newId]);
        $new = $fetch->fetch(PDO::FETCH_ASSOC);

        echo json_encode([
            'success'  => true,
            'komentar' => $new
        ]);
    } catch (Throwable $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit;
}

// ── DELETE — hapus komentar sendiri ───────────────────────────────────────────
if ($method === 'DELETE') {
    if (!isLoggedIn()) {
        http_response_code(401);
        echo json_encode(['error' => 'Anda harus login.']);
        exit;
    }

    $input  = json_decode(file_get_contents('php://input'), true);
    $id     = intval($input['id'] ?? 0);
    $userId = $_SESSION['user_id'] ?? null;

    if ($id <= 0) {
        http_response_code(400);
        echo json_encode(['error' => 'ID komentar tidak valid.']);
        exit;
    }

    try {
        $stmt = $db->prepare("
            DELETE FROM komentar
            WHERE id = :id AND user_id = :user_id
        ");

        $stmt->execute([
            ':id' => $id,
            ':user_id' => $userId
        ]);

        if ($stmt->rowCount() === 0) {
            http_response_code(403);
            echo json_encode(['error' => 'Tidak boleh hapus komentar orang lain']);
            exit;
        }

        echo json_encode(['success' => true]);
    } catch (Throwable $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }

    exit;
}

http_response_code(405);
echo json_encode(['error' => 'Method not allowed.']);