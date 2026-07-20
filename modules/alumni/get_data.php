<?php
require_once __DIR__ . '/../../config/database.php';
$db = (new Database())->getConnection();

if (isset($_GET['id'])) {
    // Tarik data gabungan dari tabel alumni dan santri
    $stmt = $db->prepare("SELECT a.*, s.nis, s.nama, s.jenis_kelamin, s.alamat, s.no_hp 
                          FROM alumni a 
                          JOIN santri s ON a.id_santri = s.id_santri 
                          WHERE a.id_alumni = ?");
    $stmt->execute([$_GET['id']]);
    $data = $stmt->fetch();
    
    if ($data) {
        echo json_encode(['status' => 'success', 'data' => $data]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan']);
    }
}
?>