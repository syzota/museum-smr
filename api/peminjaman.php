<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }

require_once '../config/db.php';
require_once '../config/auth.php';
$db     = getDB();
$method = $_SERVER['REQUEST_METHOD'];

try {
    switch ($method) {

        case 'POST':
            // Harus login
            if (!isLoggedIn()) {
                http_response_code(401);
                echo json_encode(['error' => 'Anda harus login untuk mengajukan peminjaman', 'require_login' => true]);
                exit;
            }

            $data = json_decode(file_get_contents('php://input'), true);

            $user_id     = (int) $_SESSION['user_id'];
            $nama        = trim($data['nama_peminjam'] ?? '');
            $instansi    = trim($data['instansi'] ?? '');
            $email       = trim($data['email'] ?? '');
            $no_hp       = trim($data['no_hp'] ?? '');
            $kegiatan    = trim($data['nama_kegiatan'] ?? '');
            $tgl_mulai   = $data['tanggal_mulai'] ?? '';
            $tgl_selesai = $data['tanggal_selesai'] ?? '';
            $peserta     = (int) ($data['jumlah_peserta'] ?? 0);
            $deskripsi   = trim($data['deskripsi_kegiatan'] ?? '');

            $errors = [];
            if (!$nama || mb_strlen($nama) > 100)            $errors[] = 'Nama peminjam tidak valid (maks 100 karakter)';
            if (!$instansi || mb_strlen($instansi) > 100)    $errors[] = 'Instansi tidak valid (maks 100 karakter)';
            if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 100) $errors[] = 'Email tidak valid';
            if (!$no_hp || !preg_match('/^[0-9+\-\s]{7,20}$/', $no_hp)) $errors[] = 'Nomor HP tidak valid (7–20 karakter angka, +, atau tanda hubung)';
            if (!$kegiatan || mb_strlen($kegiatan) > 150)    $errors[] = 'Nama kegiatan tidak valid (maks 150 karakter)';
            if (!$tgl_mulai || !strtotime($tgl_mulai))       $errors[] = 'Tanggal mulai tidak valid';
            if (!$tgl_selesai || !strtotime($tgl_selesai))   $errors[] = 'Tanggal selesai tidak valid';
            if (!empty($tgl_mulai) && !empty($tgl_selesai) && strtotime($tgl_selesai) <= strtotime($tgl_mulai))
                                                              $errors[] = 'Tanggal selesai harus setelah tanggal mulai';
            // H+7 check
            $minBooking = strtotime('+7 days', strtotime(date('Y-m-d')));
            if (!empty($tgl_mulai) && strtotime(date('Y-m-d', strtotime($tgl_mulai))) < $minBooking)
                                                              $errors[] = 'Tanggal pelaksanaan minimal H+7 dari hari ini';
            if ($peserta < 1 || $peserta > 250)              $errors[] = 'Jumlah peserta harus antara 1–250';
            if (!$deskripsi)                                  $errors[] = 'Deskripsi kegiatan tidak boleh kosong';

            if (!empty($errors)) {
                http_response_code(422);
                echo json_encode(['error' => implode('. ', $errors)]);
                exit;
            }

            $stmt = $db->prepare("
                INSERT INTO peminjaman_ruang
                    (user_id, nama_peminjam, instansi, email, no_hp, nama_kegiatan,
                     tanggal_mulai, tanggal_selesai, jumlah_peserta, deskripsi_kegiatan, status)
                VALUES
                    (:user_id, :nama, :instansi, :email, :no_hp, :kegiatan,
                     :tgl_mulai, :tgl_selesai, :peserta, :deskripsi, 'pending')
            ");
            $stmt->execute([
                ':user_id'     => $user_id,
                ':nama'        => $nama,
                ':instansi'    => $instansi,
                ':email'       => $email,
                ':no_hp'       => $no_hp,
                ':kegiatan'    => $kegiatan,
                ':tgl_mulai'   => $tgl_mulai,
                ':tgl_selesai' => $tgl_selesai,
                ':peserta'     => $peserta,
                ':deskripsi'   => $deskripsi,
            ]);
            http_response_code(201);
            echo json_encode(['success' => true, 'id' => $db->lastInsertId()]);
            break;

        case 'GET':
            if (isset($_GET['calendar'])) {
                $calendarEvents = [];

                $stmtEvent = $db->query("
                    SELECT id, nama_event, tanggal_mulai, tanggal_selesai, status
                    FROM event
                    ORDER BY tanggal_mulai ASC, id ASC
                ");
                foreach ($stmtEvent->fetchAll(PDO::FETCH_ASSOC) as $ev) {
                    $status = $ev['status'] ?? 'Aktif';
                    $type   = 'booked';
                    if ($status === 'Dibatalkan') {
                        $type = 'cancelled';
                    }

                    $calendarEvents[] = [
                        'source'     => 'event',
                        'source_id'  => (int) $ev['id'],
                        'label'      => $ev['nama_event'],
                        'type'       => $type,
                        'start_date' => date('Y-m-d', strtotime($ev['tanggal_mulai'])),
                        'end_date'   => date('Y-m-d', strtotime($ev['tanggal_selesai'])),
                        'status'     => $status,
                    ];
                }

                $stmtBooking = $db->query("
                    SELECT id, nama_kegiatan, tanggal_mulai, tanggal_selesai, status
                    FROM peminjaman_ruang
                    ORDER BY tanggal_mulai ASC, id ASC
                ");
                foreach ($stmtBooking->fetchAll(PDO::FETCH_ASSOC) as $bk) {
                    $status = $bk['status'] ?? 'pending';
                    $type   = 'hold';
                    if ($status === 'disetujui') $type = 'booked';
                    if ($status === 'ditolak')   $type = 'cancelled';

                    $calendarEvents[] = [
                        'source'     => 'peminjaman',
                        'source_id'  => (int) $bk['id'],
                        'label'      => $bk['nama_kegiatan'],
                        'type'       => $type,
                        'start_date' => date('Y-m-d', strtotime($bk['tanggal_mulai'])),
                        'end_date'   => date('Y-m-d', strtotime($bk['tanggal_selesai'])),
                        'status'     => $status,
                    ];
                }

                echo json_encode(['events' => $calendarEvents]);
                break;
            }

            $status = $_GET['status'] ?? null;
            $allowedStatus = ['pending', 'disetujui', 'ditolak'];

            if ($status && in_array($status, $allowedStatus, true)) {
                $stmt = $db->prepare("
                    SELECT pr.id,
                           pr.nama_peminjam  AS nama,
                           pr.instansi       AS organisasi,
                           pr.email,
                           pr.no_hp          AS kontak,
                           pr.nama_kegiatan  AS kegiatan,
                           DATE(pr.tanggal_mulai) AS tanggal,
                           CONCAT(
                               TIME_FORMAT(pr.tanggal_mulai,'%H:%i'),
                               ' – ',
                               TIME_FORMAT(pr.tanggal_selesai,'%H:%i')
                           ) AS durasi,
                           COALESCE(pr.jumlah_peserta, 0) AS peserta,
                           pr.deskripsi_kegiatan AS deskripsi,
                           pr.status,
                           'Ruang Terbuka' AS ruang
                    FROM peminjaman_ruang pr
                    WHERE pr.status = ?
                    ORDER BY pr.created_at DESC
                ");
                $stmt->execute([$status]);
            } else {
                $stmt = $db->query("
                    SELECT pr.id,
                           pr.nama_peminjam  AS nama,
                           pr.instansi       AS organisasi,
                           pr.email,
                           pr.no_hp          AS kontak,
                           pr.nama_kegiatan  AS kegiatan,
                           DATE(pr.tanggal_mulai) AS tanggal,
                           CONCAT(
                               TIME_FORMAT(pr.tanggal_mulai,'%H:%i'),
                               ' – ',
                               TIME_FORMAT(pr.tanggal_selesai,'%H:%i')
                           ) AS durasi,
                           COALESCE(pr.jumlah_peserta, 0) AS peserta,
                           pr.deskripsi_kegiatan AS deskripsi,
                           pr.status,
                           'Ruang Terbuka' AS ruang
                    FROM peminjaman_ruang pr
                    ORDER BY pr.created_at DESC
                ");
            }
            echo json_encode($stmt->fetchAll());
            break;

        case 'PUT':
            // Hanya update status (setujui / tolak / reset)
            $data   = json_decode(file_get_contents('php://input'), true);
            $editId = (int) ($data['id'] ?? 0);
            $status = $data['status'] ?? '';
            $allowed = ['pending', 'disetujui', 'ditolak'];

            if (!$editId) { http_response_code(400); echo json_encode(['error' => 'ID diperlukan']); exit; }
            if (!in_array($status, $allowed)) { http_response_code(400); echo json_encode(['error' => 'Status tidak valid']); exit; }

            $stmt = $db->prepare("UPDATE peminjaman_ruang SET status = ? WHERE id = ?");
            $stmt->execute([$status, $editId]);
            echo json_encode(['success' => true]);
            break;

        case 'DELETE':
            $data  = json_decode(file_get_contents('php://input'), true);
            $delId = (int) ($data['id'] ?? 0);
            if (!$delId) { http_response_code(400); echo json_encode(['error' => 'ID diperlukan']); exit; }
            $db->prepare("DELETE FROM peminjaman_ruang WHERE id = ?")->execute([$delId]);
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