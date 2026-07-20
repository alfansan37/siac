<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Ubah sesuai direktori project Anda di htdocs / web server
define('BASE_URL', 'http://localhost/si-admin-santri');

// Helper untuk proteksi halaman admin
function requireAuth() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: " . BASE_URL . "/modules/auth/login.php");
        exit;
    }
}

// Helper untuk return response JSON standar
function jsonResponse($status, $message, $data = []) {
    header('Content-Type: application/json');
    echo json_encode([
        'status' => $status,
        'message' => $message,
        'data' => $data
    ]);
    exit;
}
?>