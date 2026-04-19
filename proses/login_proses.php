<?php
/**
 * login_proses.php — Proses autentikasi login
 * Museum Kota Samarinda
 */

require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../login.php');
    exit;
}

if (isLoggedIn()) {
    header('Location: ' . (isAdmin() ? '../admin/index.php' : '../home.php'));
    exit;
}

$email    = trim($_POST['email']    ?? '');
$password = trim($_POST['password'] ?? '');
$ingat    = isset($_POST['ingat_saya']);

$errors = [];
if (empty($email)) {
    $errors[] = 'Email wajib diisi.';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Format email tidak valid.';
}
if (empty($password)) {
    $errors[] = 'Kata sandi wajib diisi.';
}

if (!empty($errors)) {
    $_SESSION['flash_error'] = implode(' ', $errors);
    header('Location: ../login.php');
    exit;
}

try {
    $pdo  = getDB();
    $stmt = $pdo->prepare('SELECT id, nama, email, password, peran FROM akun WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    $passwordOk = ($user && password_verify($password, $user['password']));

    if (!$passwordOk) {
        $_SESSION['flash_error'] = 'Email atau kata sandi salah.';
        header('Location: ../login.php');
        exit;
    }

    regenerateSession();

    $_SESSION['user_id']    = $user['id'];
    $_SESSION['user_nama']  = $user['nama'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['user_role']  = $user['peran'];  // key: user_role (sesuai auth.php)

    if ($ingat) {
        session_set_cookie_params(['lifetime' => 60 * 60 * 24 * 30]);
        session_write_close();
        session_start();
    }

    $redirectTarget = $_SESSION['redirect_after_login'] ?? '';
    unset($_SESSION['redirect_after_login']);

    if ($user['peran'] === 'admin') {
        header('Location: ../admin/index.php');
    } elseif (!empty($redirectTarget)) {
        header('Location: ' . $redirectTarget);
    } else {
        header('Location: ../home.php');
    }
    exit;

} catch (Exception $e) {
    error_log('Login error: ' . $e->getMessage());
    $_SESSION['flash_error'] = 'Terjadi kesalahan sistem. Silakan coba lagi.';
    header('Location: ../login.php');
    exit;
}