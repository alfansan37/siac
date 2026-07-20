<?php
require_once __DIR__ . '/../../config/app.php';
requireAuth();

require_once __DIR__ . '/../../config/database.php';
$db = (new Database())->getConnection();

// 1. Mengambil Statistik
$stat_santri = $db->query("SELECT COUNT(id_santri) as total FROM santri WHERE status = 'Aktif'")->fetch()['total'];
$stat_alumni = $db->query("SELECT COUNT(id_alumni) as total FROM alumni")->fetch()['total'];
$stat_pengurus = $db->query("SELECT COUNT(id_ustadz) as total FROM ustadz_pengurus")->fetch()['total'];

// 2. Mengambil Data Santri Baru (Tahun Masuk = Tahun Ini)
$tahun_ini = date('Y');
$stmtSantriBaru = $db->prepare("SELECT nis, nama, jenis_kelamin, alamat, nama_wali FROM santri WHERE tahun_masuk = ? AND status = 'Aktif' ORDER BY id_santri DESC LIMIT 10");
$stmtSantriBaru->execute([$tahun_ini]);
$santriBaru = $stmtSantriBaru->fetchAll();

require_once __DIR__ . '/../../components/header.php';
require_once __DIR__ . '/../../components/sidebar.php';
require_once __DIR__ . '/../../components/topbar.php';
?>

<div class="container-fluid">
    
    <!-- Welcome Message -->
    <div class="card card-custom p-4 mb-4" style="background-color: #ecfdf5; border: 1px solid #a7f3d0;">
        <h5 class="fw-bold mb-2" style="color: var(--primary-color);">
            <i class="bi bi-stars me-2"></i>Selamat Datang, <?= htmlspecialchars($_SESSION['user_nama']) ?>!
        </h5>
        <p class="text-muted mb-0">Sistem ini dirancang untuk mengelola data administrasi pesantren secara terpusat. Anda memiliki akses untuk mengelola data santri baru, alih status pengurus, hingga kelulusan alumni.</p>
    </div>

    <!-- Statistik -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card card-custom p-4 border-0 border-start border-5 border-success h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted fw-semibold mb-1 small text-uppercase">Santri Aktif</p>
                        <h2 class="fw-bold text-dark mb-0"><?= number_format($stat_santri, 0, ',', '.') ?></h2>
                    </div>
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success"><i class="bi bi-people-fill fs-3"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-custom p-4 border-0 border-start border-5 border-primary h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted fw-semibold mb-1 small text-uppercase">Total Alumni</p>
                        <h2 class="fw-bold text-dark mb-0"><?= number_format($stat_alumni, 0, ',', '.') ?></h2>
                    </div>
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary"><i class="bi bi-mortarboard-fill fs-3"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-custom p-4 border-0 border-start border-5 border-warning h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted fw-semibold mb-1 small text-uppercase">Ustadz & Pengurus</p>
                        <h2 class="fw-bold text-dark mb-0"><?= number_format($stat_pengurus, 0, ',', '.') ?></h2>
                    </div>
                    <div class="bg-warning bg-opacity-10 p-3 rounded-circle text-warning"><i class="bi bi-person-badge-fill fs-3"></i></div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Tabel Data Santri Baru Lengkap -->
    <div class="card card-custom p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold mb-0 text-dark">
                <i class="bi bi-person-lines-fill text-success me-2"></i>Santri Baru Tahun Ini (<?= $tahun_ini ?>)
            </h6>
            <a href="<?= BASE_URL ?>/modules/santri/index.php" class="btn btn-sm btn-light border">Lihat Semua</a>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.9rem;">
                <thead class="table-light">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th width="15%">NIS</th>
                        <th width="20%">Nama Lengkap</th>
                        <th width="10%">L/P</th>
                        <th width="30%">Alamat</th>
                        <th width="20%">Nama Wali</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($santriBaru) > 0): ?>
                        <?php $no = 1; foreach($santriBaru as $sb): ?>
                        <tr>
                            <td class="text-center text-muted"><?= $no++ ?></td>
                            <td><span class="badge bg-secondary bg-opacity-10 text-secondary border"><?= htmlspecialchars($sb['nis']) ?></span></td>
                            <td class="fw-semibold text-dark"><?= htmlspecialchars($sb['nama']) ?></td>
                            <td>
                                <?php if($sb['jenis_kelamin'] == 'Laki-laki'): ?>
                                    <span class="text-primary"><i class="bi bi-gender-male"></i> L</span>
                                <?php else: ?>
                                    <span class="text-danger"><i class="bi bi-gender-female"></i> P</span>
                                <?php endif; ?>
                            </td>
                            <td><span class="text-muted text-truncate d-inline-block" style="max-width: 250px;"><?= htmlspecialchars($sb['alamat'] ?? '-') ?></span></td>
                            <td><?= htmlspecialchars($sb['nama_wali'] ?? '-') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-3 d-block mb-2 text-black-50"></i>
                                Belum ada data pendaftaran santri baru di tahun <?= $tahun_ini ?>.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../components/footer.php'; ?>