<?php
require_once __DIR__ . '/../../config/app.php';
requireAuth();
require_once __DIR__ . '/../../config/database.php';

$db = (new Database())->getConnection();

// 1. Data Santri
$dtSantri = $db->query("SELECT nis, nama, jenis_kelamin, tempat_lahir, tanggal_lahir, alamat, tahun_masuk FROM santri WHERE status = 'Aktif' ORDER BY nis ASC")->fetchAll();

// 2. Data Pengurus (Kini langsung pakai jenis_kelamin dari tabel ustadz_pengurus)
$dtPengurus = $db->query("SELECT nama, jenis_kelamin, jabatan, alamat, no_hp FROM ustadz_pengurus ORDER BY jabatan ASC, nama ASC")->fetchAll();

// 3. Data Alumni
$dtAlumni = $db->query("SELECT s.nama, s.jenis_kelamin, s.alamat, s.no_hp, a.tahun_lulus FROM alumni a JOIN santri s ON a.id_santri = s.id_santri ORDER BY a.tahun_lulus DESC, s.nama ASC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buku Induk Administrasi - Cetak Semua</title>
    <link href="https://fonts.googleapis.com/css2?family=Times+New+Roman:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Times New Roman', Times, serif; color: #000; margin: 0 auto; max-width: 210mm; padding: 20mm; background: #fff; }
        .btn-print { display: block; width: 120px; margin: 0 auto 20px auto; padding: 10px; background-color: #3b6f58; color: #fff; text-align: center; text-decoration: none; border-radius: 5px; font-weight: bold; cursor: pointer; }
        .kop-surat { display: flex; align-items: center; border-bottom: 3px solid #000; padding-bottom: 10px; margin-bottom: 2px; }
        .kop-surat-inner { border-bottom: 1px solid #000; margin-bottom: 25px; }
        .kop-logo { width: 90px; height: auto; margin-right: 20px; }
        .kop-teks { flex: 1; text-align: center; }
        .kop-teks h1, .kop-teks h2, .kop-teks p { margin: 0; line-height: 1.2; }
        .kop-teks h2 { font-size: 16pt; font-weight: bold; }
        .kop-teks h1 { font-size: 22pt; font-weight: bold; }
        .section-title { margin: 30px 0 10px 0; font-size: 14pt; font-weight: bold; text-decoration: underline; background: #f3f4f6; padding: 5px; }
        table { width: 100%; border-collapse: collapse; font-size: 11pt; margin-bottom: 20px; }
        table, th, td { border: 1px solid #000; }
        th { padding: 8px; background-color: #e5e7eb; text-align: center; }
        td { padding: 6px 8px; vertical-align: top; }
        .text-center { text-align: center; }
        
        /* CSS untuk memisahkan halaman saat dicetak (Page Break) */
        .page-break { page-break-before: always; }
        
        @media print { 
            body { padding: 0; } 
            .btn-print { display: none; } 
            @page { margin: 15mm; } 
        }
    </style>
</head>
<body>
    <button onclick="window.print()" class="btn-print">Cetak Laporan</button>

    <!-- KOP SURAT (Hanya muncul di halaman pertama) -->
    <div class="kop-surat-inner">
        <div class="kop-surat">
            <img src="<?= BASE_URL ?>/assets/logo-small.png" alt="Logo Pondok" class="kop-logo">
            <div class="kop-teks">
                <h2>YAYASAN PENDIDIKAN DAN SOSIAL</h2>
                <h1>PONDOK PESANTREN ASMA' CHUSNA</h1>
                <p>Jl. Raya Kranji No. 12, Kec. Paciran, Kab. Lamongan, Jawa Timur 62264</p>
            </div>
        </div>
    </div>

    <!-- BAGIAN 1: SANTRI AKTIF -->
    <div class="section-title">BAGIAN A: DATA SANTRI AKTIF</div>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th><th width="15%">NIS</th><th width="30%">Nama Lengkap</th>
                <th width="5%">L/P</th><th width="30%">Alamat</th><th width="15%">Masuk</th>
            </tr>
        </thead>
        <tbody>
            <?php $n=1; foreach($dtSantri as $r): ?>
            <tr>
                <td class="text-center"><?= $n++ ?></td><td class="text-center"><?= $r['nis'] ?></td>
                <td><?= $r['nama'] ?></td><td class="text-center"><?= $r['jenis_kelamin']=='Laki-laki'?'L':'P' ?></td>
                <td><?= $r['alamat'] ?></td><td class="text-center"><?= $r['tahun_masuk'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- PAGE BREAK -->
    <div class="page-break"></div>

    <!-- BAGIAN 2: PENGURUS -->
    <div class="section-title" style="margin-top: 0;">BAGIAN B: DATA USTADZ & PENGURUS</div>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th><th width="25%">Nama Lengkap</th><th width="20%">Jabatan</th>
                <th width="5%">L/P</th><th width="30%">Alamat</th><th width="15%">No. HP</th>
            </tr>
        </thead>
        <tbody>
            <?php $n=1; foreach($dtPengurus as $r): ?>
            <tr>
                <td class="text-center"><?= $n++ ?></td><td class="fw-bold"><?= $r['nama'] ?></td>
                <td><?= $r['jabatan'] ?></td><td class="text-center"><?= $r['jenis_kelamin']=='Laki-laki'?'L':'P' ?></td>
                <td><?= $r['alamat'] ?></td><td class="text-center"><?= $r['no_hp'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- PAGE BREAK -->
    <div class="page-break"></div>

    <!-- BAGIAN 3: ALUMNI -->
    <div class="section-title" style="margin-top: 0;">BAGIAN C: DATA ALUMNI</div>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th><th width="30%">Nama Lengkap</th><th width="5%">L/P</th>
                <th width="35%">Alamat</th><th width="15%">No. HP</th><th width="10%">Lulus</th>
            </tr>
        </thead>
        <tbody>
            <?php $n=1; foreach($dtAlumni as $r): ?>
            <tr>
                <td class="text-center"><?= $n++ ?></td><td><?= $r['nama'] ?></td>
                <td class="text-center"><?= $r['jenis_kelamin']=='Laki-laki'?'L':'P' ?></td>
                <td><?= $r['alamat'] ?></td><td class="text-center"><?= $r['no_hp'] ?></td>
                <td class="text-center fw-bold"><?= $r['tahun_lulus'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div style="float: right; text-align: center; margin-top: 50px;">
        <div>Kranji, <?= date('d M Y') ?></div><br><br><br>
        <div style="font-weight: bold; text-decoration: underline;"><?= htmlspecialchars($_SESSION['user_nama']) ?></div>
        <div>Admin SIAS</div>
    </div>
</body>
</html>