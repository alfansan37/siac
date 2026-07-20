<?php
require_once __DIR__ . '/../../config/database.php';
$db = (new Database())->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_alumni = $_POST['id_alumni'] ?? null;
    $id_santri = $_POST['id_santri'] ?? null;

    if ($id_alumni && $id_santri) {
        try {
            $db->beginTransaction();

            // 1. Hapus data di tabel alumni
            $stmt = $db->prepare("DELETE FROM alumni WHERE id_alumni = ?");
            $stmt->execute([$id_alumni]);
            
            // 2. Kembalikan status santri ke 'Aktif'
            $stmtSantri = $db->prepare("UPDATE santri SET status = 'Aktif' WHERE id_santri = ?");
            $stmtSantri->execute([$id_santri]);

            $db->commit();
            echo json_encode(['status' => 'success', 'message' => 'Data dihapus dan Santri kembali Aktif.']);
        } catch(PDOException $e) {
            $db->rollBack();
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus data.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ID tidak valid.']);
    }
}
?>