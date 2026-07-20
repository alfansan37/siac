<?php
require_once __DIR__ . '/../../config/database.php';
$db = (new Database())->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_ustadz = $_POST['id_ustadz'] ?? null;
    $id_santri = $_POST['id_santri'] ?? null; // Cek apakah ID Santri dikirim (berarti pengurus ini adalah santri)

    if ($id_ustadz) {
        try {
            $db->beginTransaction();

            // 1. Hapus dari tabel ustadz_pengurus
            $stmt = $db->prepare("DELETE FROM ustadz_pengurus WHERE id_ustadz = ?");
            $stmt->execute([$id_ustadz]);
            
            // 2. Jika dia adalah santri, kembalikan statusnya
            if ($id_santri && $id_santri !== 'null' && $id_santri !== '') {
                $stmtSantri = $db->prepare("UPDATE santri SET status = 'Aktif' WHERE id_santri = ?");
                $stmtSantri->execute([$id_santri]);
            }

            $db->commit();
            echo json_encode(['status' => 'success', 'message' => 'Data pengurus dihapus.']);
        } catch(PDOException $e) {
            $db->rollBack();
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus data.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ID tidak valid.']);
    }
}
?>