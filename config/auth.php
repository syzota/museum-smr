<?php
/**
 * auth.php — Pusat manajemen sesi & otorisasi
 * Museum Kota Samarinda
 */

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'secure'   => false,
        'httponly' => true,
        'samesite' => 'Strict',
    ]);
    session_start();
}

function isLoggedIn(): bool {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

function isAdmin(): bool {
    return isLoggedIn() && ($_SESSION['user_role'] ?? '') === 'admin';
}

function isUser(): bool {
    return isLoggedIn() && ($_SESSION['user_role'] ?? '') === 'pengguna';
}

function currentUser(): ?array {
    if (!isLoggedIn()) return null;
    return [
        'id'    => $_SESSION['user_id'],
        'nama'  => $_SESSION['user_nama'],
        'email' => $_SESSION['user_email'],
        'role'  => $_SESSION['user_role'],
    ];
}

function requireLogin(string $redirectAfter = ''): void {
    if (!isLoggedIn()) {
        $target = $redirectAfter ?: $_SERVER['REQUEST_URI'];
        $_SESSION['redirect_after_login'] = $target;
        header('Location: /login.php?pesan=silakan_login');
        exit;
    }
}

function requireAdmin(): void {
    requireLogin();
    if (!isAdmin()) {
        header('Location: /index.php?pesan=akses_ditolak');
        exit;
    }
}

function destroySession(): void {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(), '', time() - 42000,
            $params['path'], $params['domain'],
            $params['secure'], $params['httponly']
        );
    }
    session_destroy();
}

function regenerateSession(): void {
    session_regenerate_id(true);
}