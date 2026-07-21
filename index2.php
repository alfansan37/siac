<?php
// Panggil konfigurasi utama
require_once __DIR__ . '/config/app.php';

// Cek apakah admin sudah login atau belum
if (isset($_SESSION['user_id'])) {
    // Jika sudah login, langsung arahkan ke Dashboard
    header("Location: " . BASE_URL . "/modules/dashboard/index.php");
    exit;
} else {
    // Jika belum login, arahkan ke halaman Login
    header("Location: " . BASE_URL . "/modules/auth/login.php");
    exit;
}
?>
