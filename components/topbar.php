<nav class="navbar navbar-expand navbar-light bg-white py-3 px-4 border-bottom">
        <div class="d-flex align-items-center">
            <h5 class="mb-0 fw-bold text-dark">Sistem Informasi Administrasi Santri</h5>
        </div>
        
        <ul class="navbar-nav ms-auto align-items-center">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; font-weight: 600;">
                        <?= strtoupper(substr($_SESSION['user_nama'] ?? 'A', 0, 1)) ?>
                    </div>
                    <span class="d-none d-md-inline fw-semibold text-dark"><?= $_SESSION['user_nama'] ?? 'Administrator' ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm rounded-3 mt-2">
                    <li><a class="dropdown-item py-2" href="<?= BASE_URL ?>/modules/profil/index.php"><i class="bi bi-person me-2"></i> Profil Saya</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item py-2 text-danger" href="javascript:void(0);" id="btn-logout">
                            <i class="bi bi-box-arrow-right me-2"></i> Keluar
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    <main class="p-4 flex-grow-1">