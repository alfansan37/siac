<?php
session_start();
require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../config/database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = (new Database())->getConnection();
    
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'Username dan Password wajib diisi.']);
        exit;
    }

    try {
        $stmt = $db->prepare("SELECT id_user, nama, username, password, role FROM users WHERE username = :username LIMIT 1");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        $user = $stmt->fetch();

        // Verifikasi password (Bisa menggunakan password_verify jika seeder di-hash dengan bcrypt)
        // Jika seeder awal menggunakan teks biasa (admin123), ganti logika ini sementara
        if ($user && $password === $user['password']) {
            
            // Set Session
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['user_nama'] = $user['nama'];
            $_SESSION['user_role'] = $user['role'];
            
            echo json_encode([
                'status' => 'success', 
                'message' => 'Selamat datang, ' . $user['nama'],
                'redirect' => BASE_URL . '/modules/dashboard/index.php'
            ]);
        } else {
            // Jika Anda belum menggunakan bcrypt di database, dan passwordnya adalah string murni "admin123", 
            // gunakan: if($user && $password === $user['password']) untuk testing awal.
            echo json_encode(['status' => 'error', 'message' => 'Username atau Password salah!']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Kesalahan Database.']);
    }
}
?>