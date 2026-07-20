<?php
require_once __DIR__ . '/../../config/database.php';
$db = (new Database())->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_santri = $_POST['id_santri'] ?? null;
    if ($id_santri) {
        try {
            $db->beginTransaction();
            $stmtGet = $db->prepare("SELECT nama, jenis_kelamin, alamat, no_hp FROM santri WHERE id_santri = ?");
            $stmtGet->execute([$id_santri]);
            $s = $stmtGet->fetch();

            if ($s) {
                $tahun_sekarang = date('Y');
                $stmtInsert = $db->prepare("INSERT INTO ustadz_pengurus (id_santri, nama, jenis_kelamin, pendidikan_terakhir, jabatan, tahun_mulai, alamat, no_hp) VALUES (?, ?, ?, 'Pondok Pesantren', 'Pengurus Baru', ?, ?, ?)");
                $stmtInsert->execute([$id_santri, $s['nama'], $s['jenis_kelamin'], $tahun_sekarang, $s['alamat'], $s['no_hp']]);
                
                $stmtUpdate = $db->prepare("UPDATE santri SET status = 'Pengurus' WHERE id_santri = ?");
                $stmtUpdate->execute([$id_santri]);
                
                $db->commit();
                echo json_encode(['status' => 'success', 'message' => 'Santri berhasil diangkat menjadi Pengurus!']);
            }
        } catch(PDOException $e) {
            $db->rollBack();
            echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan sistem.']);
        }
    }
}
?>