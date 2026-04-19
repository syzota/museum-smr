<?php
/**
 * signup_proses.php — Proses registrasi akun pengguna baru
 * Museum Kota Samarinda
 */

require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../signup.php');
    exit;
}

// Jika sudah login, tidak perlu daftar lagi
if (isLoggedIn()) {
    header('Location: ../home.php');
    exit;
}

// ─── Ambil Input ─────────────────────────────────────────────────────────────

$nama      = trim($_POST['nama']      ?? '');
$email     = trim($_POST['email']     ?? '');
$pekerjaan = trim($_POST['pekerjaan'] ?? '');
$password  = $_POST['password']       ?? '';
$konfirm   = $_POST['password_konfirm'] ?? '';
$setuju    = isset($_POST['setuju']);

// ─── Validasi ────────────────────────────────────────────────────────────────

$errors = [];

if (empty($nama) || strlen($nama) < 3) {
    $errors[] = 'Nama lengkap minimal 3 karakter.';
}
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Format email tidak valid.';
}
if (strlen($password) < 8) {
    $errors[] = 'Kata sandi minimal 8 karakter.';
}
if ($password !== $konfirm) {
    $errors[] = 'Konfirmasi kata sandi tidak cocok.';
}
if (!$setuju) {
    $errors[] = 'Anda harus menyetujui kebijakan penggunaan akun.';
}

if (!empty($errors)) {
    $_SESSION['flash_error']    = implode(' ', $errors);
    $_SESSION['form_nama']      = $nama;
    $_SESSION['form_email']     = $email;
    $_SESSION['form_pekerjaan'] = $pekerjaan;
    header('Location: ../signup.php');
    exit;
}

// ─── Cek Email Sudah Terdaftar ───────────────────────────────────────────────

try {
    $pdo  = getDB();
    $stmt = $pdo->prepare('SELECT id FROM akun WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);

    if ($stmt->fetch()) {
        $_SESSION['flash_error'] = 'Email sudah terdaftar. Silakan gunakan email lain atau masuk.';
        header('Location: ../signup.php');
        exit;
    }

    // ─── Simpan Akun Baru ─────────────────────────────────────────────────────

    /*
     * Hash password sebelum disimpan — WAJIB untuk keamanan.
     * password_hash() menggunakan bcrypt secara default.
     */
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare(
        'INSERT INTO akun (nama, email, password, pekerjaan, peran) VALUES (?, ?, ?, ?, ?)'
    );
    $stmt->execute([$nama, $email, $hashedPassword, $pekerjaan ?: null, 'pengguna']);

    $newUserId = (int) $pdo->lastInsertId();

    // ─── Auto-login Setelah Daftar ────────────────────────────────────────────

    regenerateSession();

    $_SESSION['user_id']    = $newUserId;
    $_SESSION['user_nama']  = $nama;
    $_SESSION['user_email'] = $email;
    $_SESSION['user_role']  = 'pengguna';

    $_SESSION['flash_success'] = 'Akun berhasil dibuat. Selamat datang, ' . htmlspecialchars($nama) . '!';
    header('Location: ../index.php');
    exit;

} catch (Exception $e) {
    error_log('Signup error: ' . $e->getMessage());
    $_SESSION['flash_error'] = 'Terjadi kesalahan sistem. Silakan coba lagi.';
    header('Location: ../signup.php');
    exit;
}