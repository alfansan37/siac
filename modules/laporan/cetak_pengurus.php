<?php
require_once __DIR__ . '/../../config/app.php';
requireAuth();
require_once __DIR__ . '/../../config/database.php';

$db = (new Database())->getConnection();

// Mengambil data ustadz & pengurus dengan LEFT JOIN ke tabel santri untuk mendapatkan jenis kelamin
$query = "SELECT p.nama, p.jabatan, p.alamat, p.no_hp, s.jenis_kelamin 
          FROM ustadz_pengurus p 
          LEFT JOIN santri s ON p.id_santri = s.id_santri 
          ORDER BY p.jabatan ASC, p.nama ASC";
$stmt = $db->query($query);
$dataPengurus = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Data Ustadz & Pengurus</title>
    <link href="https://fonts.googleapis.com/css2?family=Times+New+Roman:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Times New Roman', Times, serif; color: #000; margin: 0 auto; max-width: 210mm; padding: 20mm; background: #fff; }
        .btn-print { display: block; width: 120px; margin: 0 auto 20px auto; padding: 10px; background-color: #3b6f58; color: #fff; text-align: center; text-decoration: none; border-radius: 5px; font-family: Arial, sans-serif; font-weight: bold; cursor: pointer; }
        .kop-surat { display: flex; align-items: center; border-bottom: 3px solid #000; padding-bottom: 10px; margin-bottom: 2px; }
        .kop-surat-inner { border-bottom: 1px solid #000; margin-bottom: 25px; }
        .kop-logo { width: 90px; height: auto; margin-right: 20px; }
        .kop-teks { flex: 1; text-align: center; }
        .kop-teks h1, .kop-teks h2, .kop-teks h3, .kop-teks p { margin: 0; line-height: 1.2; }
        .kop-teks h2 { font-size: 16pt; font-weight: bold; text-transform: uppercase; }
        .kop-teks h1 { font-size: 22pt; font-weight: bold; color: #000; text-transform: uppercase; margin: 3px 0; }
        .kop-teks p { font-size: 11pt; }
        .judul-laporan { text-align: center; margin-bottom: 20px; }
        .judul-laporan h3 { margin: 0; font-size: 14pt; text-decoration: underline; }
        table { width: 100%; border-collapse: collapse; font-size: 11pt; margin-bottom: 30px; }
        table, th, td { border: 1px solid #000; }
        th { padding: 8px; background-color: #e5e7eb; text-align: center; -webkit-print-color-adjust: exact; }
        td { padding: 6px 8px; vertical-align: top; }
        .text-center { text-align: center; }
        .ttd-container { float: right; width: 250px; text-align: center; font-size: 11pt; }
        .ttd-container .tanggal { margin-bottom: 15px; }
        .ttd-container .nama { margin-top: 70px; font-weight: bold; text-decoration: underline; }
        @media print { body { padding: 0; } .btn-print { display: none; } @page { margin: 20mm; } }
    </style>
</head>
<body>
    <button onclick="window.print()" class="btn-print">Cetak Laporan</button>

    <div class="kop-surat-inner">
        <div class="kop-surat">
            <img src="<?= BASE_URL ?>/assets/logo-small.png" alt="Logo Pondok" class="kop-logo">
            <div class="kop-teks">
                <h2>YAYASAN PENDIDIKAN DAN SOSIAL</h2>
                <h1>PONDOK PESANTREN ASMA' CHUSNA</h1>
                <p>Jl. Raya Kranji No. 12, Kec. Paciran, Kab. Lamongan, Jawa Timur 62264</p>
                <p>Email: info@asmachusna.com | Telp: (0322) 123456</p>
            </div>
        </div>
    </div>

    <div class="judul-laporan">
        <h3>LAPORAN DATA USTADZ & PENGURUS</h3>
        <p>Tahun <?= date('Y') ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Nama Lengkap</th>
                <th width="20%">Jabatan</th>
                <th width="5%">L/P</th>
                <th width="35%">Alamat</th>
                <th width="15%">No. HP</th>
            </tr>
        </thead>
        <tbody>
            <?php if(count($dataPengurus) > 0): ?>
                <?php $no = 1; foreach($dataPengurus as $row): ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td class="fw-bold"><?= htmlspecialchars($row['nama']) ?></td>
                    <td><?= htmlspecialchars($row['jabatan']) ?></td>
                    <td class="text-center">
                        <?php 
                            if ($row['jenis_kelamin'] == 'Laki-laki') echo 'L';
                            elseif ($row['jenis_kelamin'] == 'Perempuan') echo 'P';
                            else echo '-'; // Jika pengurus ditambahkan manual
                        ?>
                    </td>
                    <td><?= htmlspecialchars($row['alamat'] ?? '-') ?></td>
                    <td class="text-center"><?= htmlspecialchars($row['no_hp'] ?? '-') ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6" class="text-center">Belum ada data ustadz / pengurus.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="ttd-container">
        <div class="tanggal">Kranji, <?= date('d M Y') ?></div>
        <div>Pengurus Pesantren,</div>
        <div class="nama"><?= htmlspecialchars($_SESSION['user_nama']) ?></div>
        <div>Admin SIAS</div>
    </div>
</body>
</html>