<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Proteksi halaman backend: tolak akses langsung jika belum login
if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
    header('Location: login.php?auth_required=1');
    exit;
}
?>