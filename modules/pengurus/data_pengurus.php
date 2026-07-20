<?php
require_once __DIR__ . '/../../config/database.php';
$db = (new Database())->getConnection();

$stmt = $db->query("SELECT * FROM ustadz_pengurus ORDER BY id_ustadz DESC");
$data = $stmt->fetchAll();

$response = ["data" => []];
$no = 1;
foreach ($data as $row) {
    $namaTampil = $row['nama'];
    if (!empty($row['id_santri'])) {
        $namaTampil .= ' <span class="badge bg-success bg-opacity-10 text-success ms-1 border border-success" style="font-size: 0.65rem;">Santri</span>';
    }

    $jabatanTampil = '<span class="fw-semibold text-dark">'.$row['jabatan'].'</span>';
    if (!empty($row['pendidikan_terakhir'])) {
        $jabatanTampil .= '<br><small class="text-muted">'.$row['pendidikan_terakhir'].' (Mulai: '.$row['tahun_mulai'].')</small>';
    }

    $btnAksi = '
    <div class="d-flex gap-1">
        <button class="btn btn-sm btn-outline-primary btn-edit" data-id="'.$row['id_ustadz'].'"><i class="bi bi-pencil"></i></button>
        <button class="btn btn-sm btn-outline-danger btn-delete" data-id="'.$row['id_ustadz'].'" data-santri="'.$row['id_santri'].'"><i class="bi bi-trash"></i></button>
    </div>';

    $response["data"][] = [
        $no++,
        $namaTampil,
        $jabatanTampil,
        $row['jenis_kelamin'] == 'Laki-laki' ? 'L' : 'P',
        $row['no_hp'] ?? '-',
        htmlspecialchars($row['alamat'] ?? '-'),
        $btnAksi
    ];
}
echo json_encode($response);
?>