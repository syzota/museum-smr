<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }

require_once '../config/db.php';
$db     = getDB();
$method = $_SERVER['REQUEST_METHOD'];
if ($method === 'POST' && isset($_POST['_method'])) {
    $method = strtoupper($_POST['_method']);
}
$id     = isset($_GET['id']) ? (int) $_GET['id'] : null;

try {
    switch ($method) {

        case 'GET':
            if ($id) {
                $stmt = $db->prepare("
                    SELECT id,
                           judul,
                           ringkasan AS snippet,
                           isi,
                           thumbnail  AS foto,
                           kategori,
                           tanggal_publish AS tanggal
                    FROM berita
                    WHERE id = ?
                ");
                $stmt->execute([$id]);
                $row = $stmt->fetch();
                if (!$row) { http_response_code(404); echo json_encode(['error' => 'Tidak ditemukan']); exit; }
                echo json_encode($row);
            } else {
                $stmt = $db->query("
                    SELECT id,
                           judul,
                           COALESCE(ringkasan, '') AS snippet,
                           isi,
                           COALESCE(thumbnail, '')  AS foto,
                           COALESCE(kategori, '-')  AS kategori,
                           tanggal_publish           AS tanggal
                    FROM berita
                    ORDER BY tanggal_publish DESC
                ");
                echo json_encode($stmt->fetchAll());
            }
            break;

        case 'POST':
            $judul    = $_POST['judul'] ?? '';
            $snippet  = $_POST['snippet'] ?? null;
            $isi      = $_POST['isi'] ?? '';
            $kategori = $_POST['kategori'] ?? null;
            $tanggal  = $_POST['tanggal'] ?? null;

            if (!$tanggal) {
                http_response_code(422);
                echo json_encode(['error' => 'Tanggal publish wajib diisi']);
                exit;
            }

            $foto = null;

            // contoh sederhana: kalau upload file dipakai
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                $namaFile = uniqid('berita_', true) . '.' . strtolower($ext);
                $tujuan = dirname(__DIR__) . '/uploads/berita/' . $namaFile;

                if (!is_dir(dirname(__DIR__) . '/uploads/berita')) {
                    mkdir(dirname(__DIR__) . '/uploads/berita', 0777, true);
                }

                if (!move_uploaded_file($_FILES['foto']['tmp_name'], $tujuan)) {
                    http_response_code(500);
                    echo json_encode(['error' => 'Gagal upload thumbnail']);
                    exit;
                }

                $foto = 'uploads/berita/' . $namaFile;
            }

            $stmt = $db->prepare("
                INSERT INTO berita (judul, ringkasan, isi, thumbnail, kategori, tanggal_publish)
                VALUES (:judul, :snippet, :isi, :foto, :kat, :tgl)
            ");
            $stmt->execute([
                ':judul'   => $judul,
                ':snippet' => $snippet,
                ':isi'     => $isi,
                ':foto'    => $foto,
                ':kat'     => $kategori,
                ':tgl'     => $tanggal,
            ]);

            http_response_code(201);
            echo json_encode(['id' => $db->lastInsertId(), 'success' => true]);
            break;

        case 'PUT':
            $editId   = (int) ($_POST['id'] ?? 0);
            $judul    = $_POST['judul'] ?? '';
            $snippet  = $_POST['snippet'] ?? null;
            $isi      = $_POST['isi'] ?? '';
            $kategori = $_POST['kategori'] ?? null;
            $tanggal  = $_POST['tanggal'] ?? null;

            if (!$editId) {
                http_response_code(400);
                echo json_encode(['error' => 'ID diperlukan']);
                exit;
            }

            if (!$tanggal) {
                http_response_code(422);
                echo json_encode(['error' => 'Tanggal publish wajib diisi']);
                exit;
            }

            // ambil foto lama
            $stmtOld = $db->prepare("SELECT thumbnail FROM berita WHERE id = ?");
            $stmtOld->execute([$editId]);
            $old = $stmtOld->fetch();
            $foto = $old['thumbnail'] ?? null;

            // kalau ada file baru, upload dan replace
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                $namaFile = uniqid('berita_', true) . '.' . strtolower($ext);
                $tujuan = dirname(__DIR__) . '/uploads/berita/' . $namaFile;

                if (!is_dir(dirname(__DIR__) . '/uploads/berita')) {
                    mkdir(dirname(__DIR__) . '/uploads/berita', 0777, true);
                }

                if (!move_uploaded_file($_FILES['foto']['tmp_name'], $tujuan)) {
                    http_response_code(500);
                    echo json_encode(['error' => 'Gagal upload thumbnail']);
                    exit;
                }

                $foto = 'uploads/berita/' . $namaFile;
            }

            $stmt = $db->prepare("
                UPDATE berita
                SET judul = :judul,
                    ringkasan = :snippet,
                    isi = :isi,
                    thumbnail = :foto,
                    kategori = :kat,
                    tanggal_publish = :tgl
                WHERE id = :id
            ");
            $stmt->execute([
                ':judul'   => $judul,
                ':snippet' => $snippet,
                ':isi'     => $isi,
                ':foto'    => $foto,
                ':kat'     => $kategori,
                ':tgl'     => $tanggal,
                ':id'      => $editId,
            ]);

            echo json_encode(['success' => true]);
            break;

        case 'DELETE':
            $data  = json_decode(file_get_contents('php://input'), true);
            $delId = (int) ($data['id'] ?? $id ?? 0);
            if (!$delId) { http_response_code(400); echo json_encode(['error' => 'ID diperlukan']); exit; }
            $db->prepare("DELETE FROM berita WHERE id = ?")->execute([$delId]);
            echo json_encode(['success' => true]);
            break;

        default:
            http_response_code(405);
            echo json_encode(['error' => 'Method tidak diizinkan']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}