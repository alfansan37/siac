<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$host = $_SERVER['HTTP_HOST'] ?? 'localhost';

// LOGIKA ANTI-LOOP
if ($host === 'localhost') {
    // Jika di laptop, pakai HTTP dan sertakan nama folder
    define('BASE_URL', 'http://localhost/si-admin-santri'); 
} else {
    // Jika di Vercel/Hosting, PAKSA pakai HTTPS tanpa mendeteksi lagi
    define('BASE_URL', 'https://' . $host); 
}

function requireAuth() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: " . BASE_URL . "/modules/auth/login.php");
        exit;
    }
}

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
