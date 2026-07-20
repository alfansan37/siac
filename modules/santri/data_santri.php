<?php
require_once __DIR__ . '/../../config/database.php';
$db = (new Database())->getConnection();

$stmt = $db->query("SELECT * FROM santri WHERE status = 'Aktif' ORDER BY id_santri DESC");
$data = $stmt->fetchAll();

$response = ["data" => []];
$no = 1;
foreach ($data as $row) {
    // Tombol Aksi (Edit, Hapus, Dropdown Luluskan)
    $btnAksi = '
    <div class="d-flex gap-1">
        <button class="btn btn-sm btn-outline-primary btn-edit" data-id="'.$row['id_santri'].'"><i class="bi bi-pencil"></i></button>
        <button class="btn btn-sm btn-outline-danger btn-delete" data-id="'.$row['id_santri'].'"><i class="bi bi-trash"></i></button>
        <div class="dropdown">
            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                <li><a class="dropdown-item btn-jadikan-pengurus" href="javascript:void(0)" data-id="'.$row['id_santri'].'"><i class="bi bi-person-badge me-2"></i>Jadikan Pengurus</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-warning btn-luluskan" href="javascript:void(0)" data-id="'.$row['id_santri'].'" data-nama="'.$row['nama'].'"><i class="bi bi-mortarboard me-2"></i>Keluarkan / Luluskan</a></li>
            </ul>
        </div>
    </div>';

    $response["data"][] = [
        $no++,
        $row['nis'],
        $row['nama'],
        $row['jenis_kelamin'],
        $row['tahun_masuk'],
        $btnAksi
    ];
}
echo json_encode($response);
?>