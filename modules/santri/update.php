<?php
require_once __DIR__ . '/../../config/database.php';
$db = (new Database())->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Siapkan Query Update
        $stmt = $db->prepare("UPDATE santri SET nis=?, nama=?, jenis_kelamin=?, tempat_lahir=?, tanggal_lahir=?, alamat=?, tahun_masuk=?, no_hp=?, nama_wali=?, alamat_wali=? WHERE id_santri=?");
        
        // Atasi error format tanggal '0000-00-00' jika user mengosongkan kembali tanggal lahir
        $tanggal_lahir = !empty($_POST['tanggal_lahir']) ? $_POST['tanggal_lahir'] : null;

        $stmt->execute([
            $_POST['nis'], 
            $_POST['nama'], 
            $_POST['jenis_kelamin'], 
            $_POST['tempat_lahir'], 
            $tanggal_lahir, 
            $_POST['alamat'], 
            $_POST['tahun_masuk'], 
            $_POST['no_hp'], 
            $_POST['nama_wali'], 
            $_POST['alamat_wali'], 
            $_POST['id_santri'] // ID berada di paling akhir sesuai urutan query
        ]);
        
        echo json_encode(['status' => 'success', 'message' => 'Data santri berhasil diperbarui']);
    } catch(PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Gagal mengupdate data! Pastikan NIS tidak duplikat.']);
    }
}
?>