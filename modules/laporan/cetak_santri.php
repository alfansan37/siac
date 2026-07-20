<?php
require_once __DIR__ . '/../../config/app.php';
requireAuth();
require_once __DIR__ . '/../../config/database.php';

$db = (new Database())->getConnection();

// Ambil data santri aktif
$stmt = $db->query("SELECT nis, nama, jenis_kelamin, tempat_lahir, tanggal_lahir, alamat, tahun_masuk FROM santri WHERE status = 'Aktif' ORDER BY nis ASC");
$dataSantri = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Data Santri</title>
    <link href="https://fonts.googleapis.com/css2?family=Times+New+Roman:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Reset & Base Print Styles */
        body {
            font-family: 'Times New Roman', Times, serif; /* Font standar dokumen resmi */
            color: #000;
            margin: 0 auto;
            max-width: 210mm; /* Lebar A4 */
            padding: 20mm; /* Margin kertas */
            background: #fff;
        }

        /* Tombol Print (Sembunyi saat dicetak) */
        .btn-print {
            display: block;
            width: 120px;
            margin: 0 auto 20px auto;
            padding: 10px;
            background-color: #3b6f58;
            color: #fff;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            font-family: Arial, sans-serif;
            font-weight: bold;
            cursor: pointer;
        }

        /* --- KOP SURAT --- */
        .kop-surat {
            display: flex;
            align-items: center;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 2px;
        }
        .kop-surat-inner {
            border-bottom: 1px solid #000; /* Garis ganda bawah kop */
            margin-bottom: 25px;
        }
        .kop-logo {
            width: 90px; /* Sesuaikan ukuran logo */
            height: auto;
            margin-right: 20px;
        }
        .kop-teks {
            flex: 1;
            text-align: center;
        }
        .kop-teks h1, .kop-teks h2, .kop-teks h3, .kop-teks p {
            margin: 0;
            line-height: 1.2;
        }
        .kop-teks h2 { font-size: 16pt; font-weight: bold; text-transform: uppercase; }
        .kop-teks h1 { font-size: 22pt; font-weight: bold; color: #000; text-transform: uppercase; margin: 3px 0; }
        .kop-teks p { font-size: 11pt; }

        /* --- JUDUL LAPORAN --- */
        .judul-laporan {
            text-align: center;
            margin-bottom: 20px;
        }
        .judul-laporan h3 {
            margin: 0;
            font-size: 14pt;
            text-decoration: underline;
        }

        /* --- TABEL DATA --- */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11pt;
            margin-bottom: 30px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th {
            padding: 8px;
            background-color: #e5e7eb;
            text-align: center;
            -webkit-print-color-adjust: exact;
        }
        td {
            padding: 6px 8px;
            vertical-align: top;
        }
        .text-center { text-align: center; }

        /* --- TANDA TANGAN --- */
        .ttd-container {
            float: right;
            width: 250px;
            text-align: center;
            font-size: 11pt;
        }
        .ttd-container .tanggal {
            margin-bottom: 15px;
        }
        .ttd-container .nama {
            margin-top: 70px;
            font-weight: bold;
            text-decoration: underline;
        }

        /* Aturan khusus saat diprint (Ctrl+P) */
        @media print {
            body { padding: 0; }
            .btn-print { display: none; }
            @page { margin: 20mm; }
        }
    </style>
</head>
<body>

    <button onclick="window.print()" class="btn-print">Cetak Laporan</button>

    <!-- KOP SURAT -->
    <div class="kop-surat-inner">
        <div class="kop-surat">
            <!-- LOGO: Ganti src dengan path logo Anda -->
            <img src="<?= BASE_URL ?>/assets/logo-small.png" alt="Logo Pondok" class="kop-logo" style="width:15%">
            
            <div class="kop-teks">
                <h1>الروضة التعليم الأسماء الحسنى</h1>
                <h1>PONDOK PESANTREN PUTRA-PUTRI</h1>
                <H1>"ASMA' CHUSNA"  </H1>
                <p>Jl. Raya Kranji No. 50, Kec. Kedungwuni, Kab. Pekalongan, Jawa Tengah 51173</p>
                <p>Email: ppasmachusna@gmail.com | Telp: +62 815 425 452 99</p>
            </div>
        </div>
    </div>

    <div class="judul-laporan">
        <h3>LAPORAN DATA SANTRI AKTIF</h3>
        <p>Tahun <?= date('Y') ?></p> <!-- Menampilkan tahun saat ini (2026) -->
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">NIS</th>
                <th width="25%">Nama Lengkap</th>
                <th width="10%">L/P</th>
                <th width="30%">TTL / Alamat Lengkap</th>
                <th width="15%">Tahun Masuk</th>
            </tr>
        </thead>
        <tbody>
            <?php if(count($dataSantri) > 0): ?>
                <?php $no = 1; foreach($dataSantri as $row): ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td class="text-center"><?= htmlspecialchars($row['nis']) ?></td>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td class="text-center"><?= $row['jenis_kelamin'] == 'Laki-laki' ? 'L' : 'P' ?></td>
                    <td>
                        <?php 
                            $ttl = htmlspecialchars($row['tempat_lahir'] . ', ' . $row['tanggal_lahir']);
                            $alamat = htmlspecialchars($row['alamat']);
                            echo $ttl != ', ' ? $ttl . '<br>' : '';
                            echo $alamat;
                        ?>
                    </td>
                    <td class="text-center"><?= htmlspecialchars($row['tahun_masuk']) ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data santri.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="ttd-container">
        <div class="tanggal">Kedungwuni, <?= date('d M Y') ?></div>
        <div>Pengurus Pesantren,</div>
        <div class="nama"><?= htmlspecialchars($_SESSION['user_nama']) ?></div>
        <div>Admin SIAS</div>
    </div>

    <script>
        // Opsional: Otomatis memicu jendela print saat halaman selesai dimuat
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>