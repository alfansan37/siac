<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/* =========================================
   DINAMISASI BASE URL
   ========================================= */
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';

// Cek apakah sedang berjalan di komputer lokal atau sudah online di Vercel
if ($host === 'localhost') {
    // Jika di lokal laptop, tambahkan nama folder proyek Anda
    define('BASE_URL', $protocol . '://' . $host . '/si-admin-santri'); 
} else {
    // Jika online di Vercel (atau hosting lain), langsung gunakan domain utama
    define('BASE_URL', $protocol . '://' . $host); 
}

/* =========================================
   HELPER FUNCTIONS
   ========================================= */
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
