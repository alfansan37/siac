<?php
require_once __DIR__ . '/../../config/app.php';
requireAuth();
require_once __DIR__ . '/../../components/header.php';
require_once __DIR__ . '/../../components/sidebar.php';
require_once __DIR__ . '/../../components/topbar.php';
?>

<div class="container-fluid">
    <div class="mb-4">
        <h3 class="fw-bold text-dark mb-0">Laporan & Cetak</h3>
        <p class="text-muted mb-0">Cetak dokumen administrasi dan rekapitulasi data pesantren.</p>
    </div>

    <div class="row g-4">
        <!-- Laporan Santri Aktif -->
        <div class="col-md-4">
            <div class="card card-custom p-4 text-center h-100 transition-hover">
                <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                    <i class="bi bi-people-fill fs-3"></i>
                </div>
                <h5 class="fw-bold text-dark">Data Santri Aktif</h5>
                <p class="text-muted small mb-4">Cetak daftar seluruh santri yang berstatus aktif saat ini beserta detailnya.</p>
                <a href="cetak_santri.php" target="_blank" class="btn btn-outline-success mt-auto">
                    <i class="bi bi-printer me-2"></i>Tampilkan Laporan
                </a>
            </div>
        </div>

        <!-- Laporan Alumni -->
        <div class="col-md-4">
            <div class="card card-custom p-4 text-center h-100 transition-hover">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                    <i class="bi bi-mortarboard-fill fs-3"></i>
                </div>
                <h5 class="fw-bold text-dark">Data Alumni</h5>
                <p class="text-muted small mb-4">Cetak rekapitulasi data lulusan pesantren dan riwayat pekerjaannya.</p>
                <a href="cetak_alumni.php" target="_blank" class="btn btn-outline-primary mt-auto">
                    <i class="bi bi-printer me-2"></i>Tampilkan Laporan
                </a>
                <!-- <small class="text-muted mt-2">(Tahap Pengembangan)</small> -->
            </div>
        </div>

        <!-- Laporan Pengurus -->
        <div class="col-md-4">
            <div class="card card-custom p-4 text-center h-100 transition-hover">
                <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                    <i class="bi bi-person-badge-fill fs-3"></i>
                </div>
                <h5 class="fw-bold text-dark">Data Ustadz/Pengurus</h5>
                <p class="text-muted small mb-4">Cetak daftar tenaga pendidik dan pengurus keamanan pesantren.</p>
                <a href="cetak_pengurus.php" target="_blank" class="btn btn-outline-warning mt-auto">
                    <i class="bi bi-printer me-2"></i>Tampilkan Laporan
                </a>
                <!-- <small class="text-muted mt-2">(Tahap Pengembangan)</small> -->
            </div>
        </div>

        <!-- Cetak Buku Induk (Semua) -->
        <div class="col-md-12 mt-4">
            <div class="card card-custom p-4 d-flex flex-row align-items-center justify-content-between transition-hover" style="background-color: #f1f5f9; border: 2px dashed #cbd5e1;">
                <div class="d-flex align-items-center gap-4">
                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="bi bi-journals fs-3"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-1">Cetak Buku Induk Administrasi (Semua Laporan)</h5>
                        <p class="text-muted small mb-0">Fitur ini akan merangkum Data Santri, Data Pengurus, dan Data Alumni ke dalam satu dokumen utuh.</p>
                    </div>
                </div>
                <a href="cetak_semua.php" target="_blank" class="btn btn-success fw-bold px-4 py-2">
                    <i class="bi bi-printer-fill me-2"></i>Tampilkan Laporan
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.transition-hover { transition: transform 0.2s ease, box-shadow 0.2s ease; }
.transition-hover:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
</style>

<?php require_once __DIR__ . '/../../components/footer.php'; ?>