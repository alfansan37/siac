<?php
session_start();
require_once __DIR__ . '/../../config/app.php';

// Hapus semua sesi
session_unset();
session_destroy();

// Redirect ke halaman login
header("Location: " . BASE_URL . "/modules/auth/login.php");
exit;
?>