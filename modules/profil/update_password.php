<?php
require_once __DIR__ . '/../../config/app.php';
requireAuth();
require_once __DIR__ . '/../../config/database.php';

$db = (new Database())->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $passLama = $_POST['password_lama'];
    $passBaru = $_POST['password_baru'];
    $id_user = $_SESSION['user_id'];

    try {
        // 1. Ambil password lama dari database
        $stmt = $db->prepare("SELECT password FROM users WHERE id_user = ?");
        $stmt->execute([$id_user]);
        $user = $stmt->fetch();

        // 2. Verifikasi Password Lama
        // Cek menggunakan password_verify (untuk hash) ATAU fallback jika masih plain-text 'admin123'
        if (password_verify($passLama, $user['password']) || $passLama === $user['password']) {
            
            // 3. Hash password baru
            $hashedPassword = password_hash($passBaru, PASSWORD_DEFAULT);

            // 4. Simpan ke database
            $stmtUpdate = $db->prepare("UPDATE users SET password = ? WHERE id_user = ?");
            $stmtUpdate->execute([$hashedPassword, $id_user]);

            echo json_encode(['status' => 'success', 'message' => 'Password berhasil diubah. Gunakan password baru saat login berikutnya.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Password lama yang Anda masukkan salah!']);
        }
    } catch(PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan sistem.']);
    }
}
?>