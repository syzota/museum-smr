<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }

require_once '../config/db.php';
$db     = getDB();
$method = $_SERVER['REQUEST_METHOD'];
$id     = isset($_GET['id']) ? (int) $_GET['id'] : null;

try {
    switch ($method) {

        // ─── GET semua / GET satu ───
        case 'GET':
            if ($id) {
                // Ambil satu koleksi untuk isi form edit
                $stmt = $db->prepare("
                    SELECT k.id,
                           k.nomor,
                           k.nama_koleksi  AS nama,
                           kat.nama_kategori AS kategori,
                           k.era,
                           k.kondisi,
                           k.asal,
                           k.lokasi,
                           k.deskripsi,
                           (SELECT image_path FROM koleksi_images WHERE koleksi_id = k.id LIMIT 1) AS foto
                    FROM koleksi k
                    JOIN kategori kat ON k.kategori_id = kat.id
                    WHERE k.id = ?
                ");
                $stmt->execute([$id]);
                $row = $stmt->fetch();
                if (!$row) { http_response_code(404); echo json_encode(['error' => 'Tidak ditemukan']); exit; }
                echo json_encode($row);
            } else {
                // Ambil semua koleksi
                $stmt = $db->query("
                    SELECT k.id,
                           COALESCE(k.nomor, CONCAT('KOL-', LPAD(k.id, 4, '0'))) AS nomor,
                           k.nama_koleksi  AS nama,
                           kat.nama_kategori AS kategori,
                           COALESCE(k.era, '-') AS era,
                           COALESCE(k.kondisi, '-') AS kondisi,
                           k.asal,
                           k.lokasi,
                           k.deskripsi,
                           (SELECT image_path FROM koleksi_images WHERE koleksi_id = k.id LIMIT 1) AS foto
                    FROM koleksi k
                    JOIN kategori kat ON k.kategori_id = kat.id
                    ORDER BY k.id DESC
                ");
                echo json_encode($stmt->fetchAll());
            }
            break;

        // ─── POST tambah baru ───
        case 'POST':
                    // 1. Ambil data dari $_POST (Bukan json_decode lagi!)
                    $id           = isset($_POST['id']) ? (int)$_POST['id'] : null;
                    $nomor        = $_POST['nomor'] ?? null;
                    $nama         = $_POST['nama'] ?? '';
                    $kategoriNama = trim($_POST['kategori'] ?? '');
                    $era          = $_POST['era'] ?? null;
                    $kondisi      = $_POST['kondisi'] ?? null;
                    $asal         = $_POST['asal'] ?? null;
                    $lokasi       = $_POST['lokasi'] ?? null;
                    $deskripsi    = $_POST['deskripsi'] ?? null;

                    // 2. Cari kategori_id berdasarkan nama
                    $katStmt = $db->prepare("SELECT id FROM kategori WHERE LOWER(nama_kategori) = LOWER(?) LIMIT 1");
                    $katStmt->execute([$kategoriNama]);
                    $kategori_id = $katStmt->fetchColumn();

                    if (!$kategori_id) {
                        http_response_code(400);
                        echo json_encode(['error' => "Kategori '$kategoriNama' tidak ditemukan."]);
                        exit;
                    }

                    // 3. Logika DB (INSERT atau UPDATE)
                    if ($id) {
                        // UPDATE data koleksi
                        $stmt = $db->prepare("
                            UPDATE koleksi 
                            SET nomor = ?, nama_koleksi = ?, kategori_id = ?, era = ?, kondisi = ?, asal = ?, lokasi = ?, deskripsi = ?
                            WHERE id = ?
                        ");
                        $stmt->execute([$nomor, $nama, $kategori_id, $era, $kondisi, $asal, $lokasi, $deskripsi, $id]);
                        $targetKoleksiId = $id;
                    } else {
                        // INSERT data koleksi baru
                        $stmt = $db->prepare("
                            INSERT INTO koleksi (nomor, nama_koleksi, kategori_id, era, kondisi, asal, lokasi, deskripsi)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                        ");
                        $stmt->execute([$nomor, $nama, $kategori_id, $era, $kondisi, $asal, $lokasi, $deskripsi]);
                        $targetKoleksiId = $db->lastInsertId();
                    }

                    // 4. Handle Upload File Foto (Jika ada file yang diunggah)
                    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                        $uploadDir = '../uploads/koleksi/';
                        
                        // Buat folder jika belum ada
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0777, true);
                        }

                        $fileTmpPath = $_FILES['foto']['tmp_name'];
                        $fileName    = $_FILES['foto']['name'];
                        $fileExt     = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                        
                        // Beri nama unik agar tidak bentrok
                        $newFileName = time() . '_' . uniqid() . '.' . $fileExt;
                        $destPath    = $uploadDir . $newFileName;

                        if (move_uploaded_file($fileTmpPath, $destPath)) {
                            $dbPath = 'uploads/koleksi/' . $newFileName;

                            // Jika ini Update, hapus catatan foto lama dulu (opsional: hapus file fisiknya juga)
                            if ($id) {
                                $db->prepare("DELETE FROM koleksi_images WHERE koleksi_id = ?")->execute([$id]);
                            }

                            // Simpan path foto baru ke tabel koleksi_images
                            $imgStmt = $db->prepare("INSERT INTO koleksi_images (koleksi_id, image_path) VALUES (?, ?)");
                            $imgStmt->execute([$targetKoleksiId, $dbPath]);
                        }
                    }

                    echo json_encode(['success' => true, 'id' => $targetKoleksiId]);
                    break;

        // ─── PUT update ───
        case 'PUT':
            $data = json_decode(file_get_contents('php://input'), true);
            $editId = (int) ($data['id'] ?? 0);
            if (!$editId) { http_response_code(400); echo json_encode(['error' => 'ID diperlukan']); exit; }

            $kategoriNama = trim($data['kategori'] ?? ''); 
            $katStmt = $db->prepare("SELECT id FROM kategori WHERE nama_kategori = ? LIMIT 1");
            $katStmt->execute([$kategoriNama]);
            $katRow = $katStmt->fetch();
            $kategori_id = $katRow ? $katRow['id'] : null;

            if ($kategori_id === null) {
                http_response_code(400);
                echo json_encode(['error' => "Kategori '$kategoriNama' tidak ditemukan."]);
                exit;
            }

            $stmt = $db->prepare("
                UPDATE koleksi
                SET nomor       = :nomor,
                    nama_koleksi= :nama,
                    kategori_id = :kat_id,
                    era         = :era,
                    kondisi     = :kondisi,
                    asal        = :asal,
                    lokasi      = :lokasi,
                    deskripsi   = :desk
                WHERE id = :id
            ");
            $stmt->execute([
                ':nomor'   => $data['nomor']     ?? null,
                ':nama'    => $data['nama']       ?? '',
                ':kat_id'  => $kategori_id,
                ':era'     => $data['era']        ?? null,
                ':kondisi' => $data['kondisi']    ?? null,
                ':asal'    => $data['asal']       ?? null,
                ':lokasi'  => $data['lokasi']     ?? null,
                ':desk'    => $data['deskripsi']  ?? null,
                ':id'      => $editId,
            ]);

            // Update foto: hapus lama, insert baru
            if (isset($data['foto'])) {
                $db->prepare("DELETE FROM koleksi_images WHERE koleksi_id = ?")->execute([$editId]);
                if (!empty($data['foto'])) {
                    $db->prepare("INSERT INTO koleksi_images (koleksi_id, image_path) VALUES (?, ?)")->execute([$editId, $data['foto']]);
                }
            }

            echo json_encode(['success' => true]);
            break;

        // ─── DELETE ───
        case 'DELETE':
            $data   = json_decode(file_get_contents('php://input'), true);
            $delId  = (int) ($data['id'] ?? $id ?? 0);
            if (!$delId) { http_response_code(400); echo json_encode(['error' => 'ID diperlukan']); exit; }

            $db->prepare("DELETE FROM koleksi_images WHERE koleksi_id = ?")->execute([$delId]);
            $db->prepare("DELETE FROM koleksi WHERE id = ?")->execute([$delId]);
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