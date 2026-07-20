<?php
require_once __DIR__ . '/../../config/database.php';
$db = (new Database())->getConnection();

// Mengambil data gabungan Alumni & Santri
$query = "SELECT a.id_alumni, a.id_santri, s.nama, s.jenis_kelamin, s.alamat, s.no_hp, a.tahun_lulus, a.keterangan 
          FROM alumni a 
          JOIN santri s ON a.id_santri = s.id_santri 
          ORDER BY a.tahun_lulus DESC, a.id_alumni DESC";
$stmt = $db->query($query);
$data = $stmt->fetchAll();

$response = ["data" => []];
$no = 1;
foreach ($data as $row) {
    $btnAksi = '
    <div class="d-flex gap-1">
        <button class="btn btn-sm btn-outline-primary btn-edit" data-id="'.$row['id_alumni'].'"><i class="bi bi-pencil"></i></button>
        <button class="btn btn-sm btn-outline-danger btn-delete" data-id="'.$row['id_alumni'].'" data-santri="'.$row['id_santri'].'"><i class="bi bi-trash"></i></button>
    </div>';

    // Harus pas 7 item sesuai kolom tabel HTML baru
    $response["data"][] = [
        $no++,
        '<span class="fw-bold">'.htmlspecialchars($row['nama']).'</span><br><small class="text-muted">'.$row['keterangan'].'</small>', // Menggabungkan Nama dan Keterangan
        $row['jenis_kelamin'] == 'Laki-laki' ? 'L' : 'P',
        htmlspecialchars($row['alamat'] ?? '-'),
        htmlspecialchars($row['no_hp'] ?? '-'),
        '<span class="badge bg-secondary">'.$row['tahun_lulus'].'</span>',
        $btnAksi
    ];
}
echo json_encode($response);
?>