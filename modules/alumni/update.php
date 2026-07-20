<?php
require_once __DIR__ . '/../../config/database.php';
$db = (new Database())->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db->beginTransaction();

        // GENERATE NIS sama seperti di store
        $nis = !empty($_POST['nis']) ? $_POST['nis'] : '81' . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
        
        $stmtSantri = $db->prepare("UPDATE santri SET nis=?, nama=?, jenis_kelamin=?, alamat=?, no_hp=? WHERE id_santri=?");
        $stmtSantri->execute([
            $nis, $_POST['nama'], $_POST['jenis_kelamin'], $_POST['alamat'], $_POST['no_hp'], $_POST['id_santri']
        ]);

        $stmtAlumni = $db->prepare("UPDATE alumni SET tahun_lulus=?, pekerjaan=?, keterangan=?, catatan_tambahan=? WHERE id_alumni=?");
        $stmtAlumni->execute([
            $_POST['tahun_lulus'], $_POST['pekerjaan'], $_POST['keterangan'], $_POST['catatan_tambahan'], $_POST['id_alumni']
        ]);

        $db->commit();
        echo json_encode(['status' => 'success', 'message' => 'Data Alumni berhasil diperbarui']);
    } catch(PDOException $e) {
        $db->rollBack();
        echo json_encode(['status' => 'error', 'message' => 'Gagal mengupdate data. NIS mungkin duplikat.']);
    }
}
?>