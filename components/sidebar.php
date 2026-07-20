<?php $current_page = basename($_SERVER['PHP_SELF']); ?>
<div id="sidebar">
    <div class="sidebar-brand">
        <img src="<?= BASE_URL ?>/assets/logo-small.png" alt="logo" width="50" height="50">
        <!-- <i class="bi bi-box-seam-fill fs-4 text-success"></i> -->
        <span>PP. Asma' Chusna</span>
    </div>
    <div class="mt-3">
        <a href="<?= BASE_URL ?>/modules/dashboard/index.php" class="sidebar-link <?= ($current_page == 'index.php' && strpos($_SERVER['REQUEST_URI'], 'dashboard') !== false) ? 'active' : '' ?>">
            <i class="bi bi-grid-1x2-fill"></i> Dashboard
        </a>
        <div class="px-3 mt-4 mb-2 text-uppercase text-muted" style="font-size: 0.7rem; font-weight: 700;">Manajemen Data</div>
        <a href="<?= BASE_URL ?>/modules/santri/index.php" class="sidebar-link <?= (strpos($_SERVER['REQUEST_URI'], 'santri') !== false) ? '' : '' ?>">
            <i class="bi bi-people-fill"></i> Data Santri Aktif
        </a>
        <a href="<?= BASE_URL ?>/modules/alumni/index.php" class="sidebar-link <?= (strpos($_SERVER['REQUEST_URI'], 'alumni') !== false) ? 'active' : '' ?>">
            <i class="bi bi-mortarboard-fill"></i> Data Alumni
        </a>
        <a href="<?= BASE_URL ?>/modules/pengurus/index.php" class="sidebar-link <?= (strpos($_SERVER['REQUEST_URI'], 'pengurus') !== false) ? 'active' : '' ?>">
            <i class="bi bi-person-badge-fill"></i> Ustadz & Pengurus
        </a>
        <div class="px-3 mt-4 mb-2 text-uppercase text-muted" style="font-size: 0.7rem; font-weight: 700;">Administrasi</div>
        <a href="<?= BASE_URL ?>/modules/laporan/index.php" class="sidebar-link <?= (strpos($_SERVER['REQUEST_URI'], 'laporan') !== false) ? 'active' : '' ?>">
            <i class="bi bi-printer-fill"></i> Laporan & Cetak
        </a>
    </div>
</div>
<div id="page-content-wrapper" class="w-100 d-flex flex-column" style="min-height: 100vh; overflow-x: hidden;">