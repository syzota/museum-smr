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

// ── POST — submit komentar baru (wajib login) ─────────────────────────────────
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
            ':isi'     => htmlspecialchars($isi, ENT_QUOTES, 'UTF-8'),
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

        echo json_encode(['success' => true, 'komentar' => $new]);
    } catch (Throwable $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit;
}

http_response_code(405);
echo json_encode(['error' => 'Method not allowed.']);