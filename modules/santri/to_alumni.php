<?php
require_once __DIR__ . '/../../config/database.php';
$db = (new Database())->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Gunakan Transaction agar konsisten
        $db->beginTransaction();
        
        // 1. Insert ke tabel Alumni
        $stmtAlumni = $db->prepare("INSERT INTO alumni (id_santri, tahun_lulus, pekerjaan, keterangan) VALUES (?, ?, ?, ?)");
        $stmtAlumni->execute([
            $_POST['id_santri_lulus'],
            $_POST['tahun_lulus'],
            $_POST['pekerjaan'],
            $_POST['keterangan']
        ]);
        
        // 2. Ubah status di tabel Santri menjadi 'Alumni'
        $stmtSantri = $db->prepare("UPDATE santri SET status = 'Alumni' WHERE id_santri = ?");
        $stmtSantri->execute([$_POST['id_santri_lulus']]);
        
        $db->commit();
        echo json_encode(['status' => 'success', 'message' => 'Santri resmi diluluskan dan dipindah ke Data Alumni.']);
        
    } catch(PDOException $e) {
        $db->rollBack();
        echo json_encode(['status' => 'error', 'message' => 'Gagal memproses data: ' . $e->getMessage()]);
    }
}
?>