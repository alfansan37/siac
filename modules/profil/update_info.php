<?php
require_once __DIR__ . '/../../config/app.php';
requireAuth();
require_once __DIR__ . '/../../config/database.php';

$db = (new Database())->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $username = trim($_POST['username']);
    $id_user = $_SESSION['user_id'];

    if(empty($nama) || empty($username)) {
        echo json_encode(['status' => 'error', 'message' => 'Nama dan Username tidak boleh kosong.']);
        exit;
    }

    try {
        // Cek apakah username sudah dipakai orang lain
        $stmtCek = $db->prepare("SELECT id_user FROM users WHERE username = ? AND id_user != ?");
        $stmtCek->execute([$username, $id_user]);
        if($stmtCek->rowCount() > 0) {
            echo json_encode(['status' => 'error', 'message' => 'Username sudah digunakan oleh akun lain!']);
            exit;
        }

        // Update database
        $stmtUpdate = $db->prepare("UPDATE users SET nama = ?, username = ? WHERE id_user = ?");
        $stmtUpdate->execute([$nama, $username, $id_user]);

        // Update session agar Topbar berubah
        $_SESSION['user_nama'] = $nama;

        echo json_encode(['status' => 'success', 'message' => 'Informasi akun berhasil diperbarui.']);
    } catch(PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan sistem.']);
    }
}
?>