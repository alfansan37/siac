<?php
require_once __DIR__ . '/../../config/database.php';
$db = (new Database())->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db->beginTransaction();

        // GENERATE NIS: Jika form NIS kosong, buat angka 81 + 6 angka acak
        $nis = !empty($_POST['nis']) ? $_POST['nis'] : '81' . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
        
        $tahun_masuk = (int)$_POST['tahun_lulus'] - 3; // Estimasi masuk

        // Insert ke tabel Santri
        $stmtSantri = $db->prepare("INSERT INTO santri (nis, nama, jenis_kelamin, alamat, no_hp, tahun_masuk, status) VALUES (?, ?, ?, ?, ?, ?, 'Alumni')");
        $stmtSantri->execute([
            $nis, $_POST['nama'], $_POST['jenis_kelamin'], $_POST['alamat'], $_POST['no_hp'], $tahun_masuk
        ]);
        
        $id_santri_baru = $db->lastInsertId();

        // Insert ke tabel Alumni
        $stmtAlumni = $db->prepare("INSERT INTO alumni (id_santri, tahun_lulus, pekerjaan, keterangan, catatan_tambahan) VALUES (?, ?, ?, ?, ?)");
        $stmtAlumni->execute([
            $id_santri_baru, $_POST['tahun_lulus'], $_POST['pekerjaan'], $_POST['keterangan'], $_POST['catatan_tambahan']
        ]);

        $db->commit();
        echo json_encode(['status' => 'success', 'message' => 'Alumni lama berhasil ditambahkan ke database.']);
    } catch(PDOException $e) {
        $db->rollBack();
        echo json_encode(['status' => 'error', 'message' => 'Gagal memproses data. Jika mengisi NIS manual, pastikan tidak duplikat.']);
    }
}
?>