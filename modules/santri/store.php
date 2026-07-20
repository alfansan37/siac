<?php
require_once __DIR__ . '/../../config/database.php';
$db = (new Database())->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Siapkan Query dengan 10 kolom sesuai inputan modal
        $stmt = $db->prepare("INSERT INTO santri (nis, nama, jenis_kelamin, tempat_lahir, tanggal_lahir, alamat, tahun_masuk, no_hp, nama_wali, alamat_wali) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        // Atasi error format tanggal '0000-00-00' jika user tidak mengisi tanggal lahir
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
            $_POST['alamat_wali']
        ]);
        
        echo json_encode(['status' => 'success', 'message' => 'Santri berhasil ditambahkan']);
    } catch(PDOException $e) {
        // Biasanya error di sini terjadi jika NIS sudah ada di database (karena kolom NIS bersifat UNIQUE)
        echo json_encode(['status' => 'error', 'message' => 'Gagal! Pastikan NIS belum digunakan oleh santri lain.']);
    }
}
?>