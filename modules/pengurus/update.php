<?php
require_once __DIR__ . '/../../config/database.php';
$db = (new Database())->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // GABUNGKAN ALAMAT
        $jalan = trim($_POST['alamat_jalan']);
        $kecamatan = trim($_POST['alamat_kecamatan']);
        $kabupaten = trim($_POST['alamat_kabupaten']);

        $alamat_full = $jalan;
        if (!empty($kecamatan)) $alamat_full .= ', Kec. ' . $kecamatan;
        if (!empty($kabupaten)) $alamat_full .= ', Kab. ' . $kabupaten;

        $stmt = $db->prepare("UPDATE ustadz_pengurus SET nama=?, jenis_kelamin=?, pendidikan_terakhir=?, jabatan=?, tahun_mulai=?, no_hp=?, alamat=? WHERE id_ustadz=?");
        $stmt->execute([
            $_POST['nama'], 
            $_POST['jenis_kelamin'], 
            $_POST['pendidikan_terakhir'], 
            $_POST['jabatan'], 
            $_POST['tahun_mulai'],
            $_POST['no_hp'], 
            $alamat_full, 
            $_POST['id_ustadz']
        ]);
        echo json_encode(['status' => 'success', 'message' => 'Data Pengurus berhasil diperbarui']);
    } catch(PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Gagal mengupdate data']);
    }
}
?>