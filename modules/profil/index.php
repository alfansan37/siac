<?php
require_once __DIR__ . '/../../config/app.php';
requireAuth();
require_once __DIR__ . '/../../config/database.php';

$db = (new Database())->getConnection();

// Ambil data user saat ini
$stmt = $db->prepare("SELECT nama, username FROM users WHERE id_user = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

require_once __DIR__ . '/../../components/header.php';
require_once __DIR__ . '/../../components/sidebar.php';
require_once __DIR__ . '/../../components/topbar.php';
?>

<div class="container-fluid">
    <div class="mb-4">
        <h3 class="fw-bold text-dark mb-0">Profil Akun</h3>
        <p class="text-muted mb-0">Kelola informasi pribadi dan keamanan akun Anda.</p>
    </div>

    <div class="row g-4">
        <!-- Form Update Informasi -->
        <div class="col-md-6">
            <div class="card card-custom p-4 h-100">
                <h5 class="fw-bold text-dark mb-4 border-bottom pb-2">Informasi Akun</h5>
                <form id="formInfo">
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-semibold">Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama" value="<?= htmlspecialchars($user['nama']) ?>" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-muted small fw-semibold">Username Login</label>
                        <input type="text" class="form-control" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary-custom w-100" id="btnInfo">
                        <i class="bi bi-save me-2"></i>Simpan Informasi
                    </button>
                </form>
            </div>
        </div>

        <!-- Form Update Password -->
        <div class="col-md-6">
            <div class="card card-custom p-4 h-100">
                <h5 class="fw-bold text-dark mb-4 border-bottom pb-2">Ubah Password</h5>
                <form id="formPassword">
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-semibold">Password Saat Ini</label>
                        <input type="password" class="form-control" name="password_lama" placeholder="Masukkan password lama" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-semibold">Password Baru</label>
                        <input type="password" class="form-control" name="password_baru" id="password_baru" placeholder="Minimal 6 karakter" required minlength="6">
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-muted small fw-semibold">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" name="konfirmasi_password" id="konfirmasi_password" placeholder="Ulangi password baru" required minlength="6">
                    </div>
                    <button type="submit" class="btn btn-warning w-100 fw-bold text-dark" id="btnPass">
                        <i class="bi bi-shield-lock me-2"></i>Update Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../components/footer.php'; ?>

<script>
$(document).ready(function() {
    // 1. Submit Form Informasi
    $('#formInfo').submit(function(e) {
        e.preventDefault();
        let btn = $('#btnInfo');
        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...');

        fetch('update_info.php', {
            method: 'POST',
            body: new FormData(this)
        })
        .then(res => res.json())
        .then(data => {
            btn.prop('disabled', false).html('<i class="bi bi-save me-2"></i>Simpan Informasi');
            if(data.status === 'success') {
                Toast.fire({ icon: 'success', title: data.message });
                // Refresh halaman untuk update nama di Topbar setelah 1.5 detik
                setTimeout(() => window.location.reload(), 1500); 
            } else {
                Swal.fire('Gagal', data.message, 'error');
            }
        });
    });

    // 2. Submit Form Password
    $('#formPassword').submit(function(e) {
        e.preventDefault();
        
        let passBaru = $('#password_baru').val();
        let passKonfirm = $('#konfirmasi_password').val();

        if (passBaru !== passKonfirm) {
            Swal.fire('Peringatan', 'Konfirmasi password baru tidak cocok!', 'warning');
            return;
        }

        let btn = $('#btnPass');
        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Memproses...');

        fetch('update_password.php', {
            method: 'POST',
            body: new FormData(this)
        })
        .then(res => res.json())
        .then(data => {
            btn.prop('disabled', false).html('<i class="bi bi-shield-lock me-2"></i>Update Password');
            if(data.status === 'success') {
                $('#formPassword')[0].reset(); // Kosongkan inputan
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    confirmButtonColor: '#3b6f58'
                });
            } else {
                Swal.fire('Gagal', data.message, 'error');
            }
        });
    });
});
</script>