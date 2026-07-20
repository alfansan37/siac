<?php
require_once __DIR__ . '/../../config/database.php';
$db = (new Database())->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi input ID
    $id_santri =$_POST['id_santri'] ?? null;

    if ($id_santri) {
        try {
            $stmt =$db->prepare("DELETE FROM santri WHERE id_santri = ?");
            $stmt->execute([$id_santri]);
            
            echo json_encode(['status' => 'success', 'message' => 'Data santri berhasil dihapus selamanya.']);
        } catch(PDOException $e) {
            // Error handling jika gagal (misal karena constraint Foreign Key)
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus! Data ini mungkin terhubung dengan data Alumni atau Pengurus.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ID Santri tidak ditemukan.']);
    }
}
?>