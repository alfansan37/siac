<?php
require_once __DIR__ . '/../../config/app.php';
requireAuth();
require_once __DIR__ . '/../../components/header.php';
require_once __DIR__ . '/../../components/sidebar.php';
require_once __DIR__ . '/../../components/topbar.php';
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0">Data Santri Aktif</h3>
            <p class="text-muted mb-0">Kelola data santri yang masih aktif di pesantren.</p>
        </div>
        <button class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#modalSantri" id="btnTambah">
            <i class="bi bi-plus-lg me-1"></i> Tambah Santri
        </button>
    </div>

    <div class="card card-custom p-4">
        <div class="table-responsive">
            <table id="tableSantri" class="table table-hover w-100">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">NIS</th>
                        <th>Nama Lengkap</th>
                        <th width="10%">L/P</th>
                        <th width="15%">Tahun Masuk</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Form Santri (Untuk Tambah & Edit) -->
<div class="modal fade" id="modalSantri" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalSantriLabel">Form Santri</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formSantri">
                <div class="modal-body">
                    <input type="hidden" name="id_santri" id="id_santri">
                    <input type="hidden" name="action" id="formAction" value="store">
                    
                    <div class="row g-3">
                        <!-- Data Diri Santri -->
                        <div class="col-12 mb-1"><h6 class="fw-bold border-bottom pb-2 text-success">A. Data Diri Santri</h6></div>
                        
                        <div class="col-md-3">
                            <label class="form-label text-muted small fw-semibold">NIS <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nis" id="nis" required>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label text-muted small fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama" id="nama" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small fw-semibold">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select class="form-select" name="jenis_kelamin" id="jenis_kelamin" required>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label text-muted small fw-semibold">Tempat Lahir</label>
                            <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" placeholder="Contoh: Lamongan">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small fw-semibold">Tanggal Lahir</label>
                            <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small fw-semibold">Tahun Masuk <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="tahun_masuk" id="tahun_masuk" value="<?= date('Y') ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-semibold">No. HP / WA (Santri/Wali Santri)</label>
                            <input type="text" class="form-control" name="no_hp" id="no_hp" placeholder="08...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-semibold">Alamat Lengkap Santri</label>
                            <textarea class="form-control" name="alamat" id="alamat" rows="2" placeholder="Desa, RT/RW, Kecamatan..."></textarea>
                        </div>

                        <!-- Data Wali -->
                        <div class="col-12 mt-4 mb-1"><h6 class="fw-bold border-bottom pb-2 text-success">B. Data Wali Santri</h6></div>
                        
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-semibold">Nama Wali (Orang Tua / Saudara)</label>
                            <input type="text" class="form-control" name="nama_wali" id="nama_wali">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-semibold">Alamat Wali</label>
                            <textarea class="form-control" name="alamat_wali" id="alamat_wali" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary-custom" id="btnSimpanSantri">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Form Alumni (Untuk Alur Kelulusan) -->
<div class="modal fade" id="modalAlumni" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning bg-opacity-10">
                <h5 class="modal-title fw-bold text-dark">Proses Kelulusan Santri</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formAlumni">
                <div class="modal-body">
                    <input type="hidden" name="id_santri_lulus" id="id_santri_lulus">
                    
                    <div class="mb-3">
                        <!-- <label class="form-label text-muted small fw-semibold">Nama Santri</label> -->
                        <input type="hidden" class="form-control bg-light" id="nama_santri_lulus" readonly>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label text-muted small fw-semibold">Tahun Lulus</label>
                            <input type="number" class="form-control" name="tahun_lulus" value="<?= date('Y') ?>" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted small fw-semibold">Keterangan</label>
                            <select class="form-select" name="keterangan" required>
                                <option value="Melanjutkan Pendidikan">Melanjutkan Pendidikan</option>
                                <option value="Bekerja">Bekerja</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-semibold">Pekerjaan/Instansi (Opsional)</label>
                        <input type="text" class="form-control" name="pekerjaan" placeholder="Contoh: Universitas Al-Azhar / Wirausaha">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning text-dark fw-bold">Proses Status Alumni</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../components/footer.php'; ?>

<script>
$(document).ready(function() {
    // 1. Inisialisasi DataTables
    let table = $('#tableSantri').DataTable({
        ajax: 'data_santri.php',
        processing: true
    });

    // 2. Handler Tombol Tambah
    $('#btnTambah').click(function() {
        $('#formSantri')[0].reset();
        $('#id_santri').val('');
        $('#formAction').val('store');
        $('#modalSantriLabel').text('Tambah Santri Baru');
    });

    // 3. Handler Tombol Edit (Tarik semua data ke form)
    $('#tableSantri tbody').on('click', '.btn-edit', function() {
        let id = $(this).data('id');
        fetch(`get_data.php?id=${id}`)
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    // Isi form Data Diri
                    $('#id_santri').val(data.data.id_santri);
                    $('#nis').val(data.data.nis);
                    $('#nama').val(data.data.nama);
                    $('#jenis_kelamin').val(data.data.jenis_kelamin);
                    $('#tempat_lahir').val(data.data.tempat_lahir);
                    $('#tanggal_lahir').val(data.data.tanggal_lahir);
                    $('#tahun_masuk').val(data.data.tahun_masuk);
                    $('#no_hp').val(data.data.no_hp);
                    $('#alamat').val(data.data.alamat);
                    
                    // Isi form Data Wali
                    $('#nama_wali').val(data.data.nama_wali);
                    $('#alamat_wali').val(data.data.alamat_wali);
                    
                    $('#formAction').val('update');
                    $('#modalSantriLabel').text('Edit Data Santri');
                    $('#modalSantri').modal('show');
                }
            });
    });

    // 4. Submit Form Santri (Tambah/Edit)
    $('#formSantri').submit(function(e) {
        e.preventDefault();
        let action = $('#formAction').val();
        let endpoint = action === 'store' ? 'store.php' : 'update.php';
        
        fetch(endpoint, {
            method: 'POST',
            body: new FormData(this)
        })
        .then(res => res.json())
        .then(data => {
            if(data.status === 'success') {
                $('#modalSantri').modal('hide');
                table.ajax.reload(null, false);
                Toast.fire({ icon: 'success', title: data.message });
            } else {
                Swal.fire('Gagal', data.message, 'error');
            }
        });
    });

    // 5. Handler Hapus
    $('#tableSantri tbody').on('click', '.btn-delete', function() {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Yakin hapus data?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                let formData = new FormData();
                formData.append('id_santri', id);
                
                fetch('delete.php', { method: 'POST', body: formData })
                .then(res => res.json())
                .then(data => {
                    if(data.status === 'success') {
                        table.ajax.reload(null, false);
                        Toast.fire({ icon: 'success', title: data.message });
                    } else {
                        Swal.fire('Gagal', data.message, 'error');
                    }
                });
            }
        });
    });

    // 6. Handler Luluskan
    $('#tableSantri tbody').on('click', '.btn-luluskan', function() {
        let id = $(this).data('id');
        let nama = $(this).data('nama');

        Swal.fire({
            title: 'Proses Kelulusan',
            text: `Yakin ingin mengeluarkan/meluluskan santri bernama ${nama}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#f59e0b',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Lanjutkan'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#id_santri_lulus').val(id);
                $('#nama_santri_lulus').val(nama);
                $('#formAlumni')[0].reset();
                $('#modalAlumni').modal('show');
            }
        });
    });

    // 7. Submit Form Alumni
    $('#formAlumni').submit(function(e) {
        e.preventDefault();
        fetch('to_alumni.php', {
            method: 'POST',
            body: new FormData(this)
        })
        .then(res => res.json())
        .then(data => {
            if(data.status === 'success') {
                $('#modalAlumni').modal('hide');
                table.ajax.reload(null, false);
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

    // 8. Handler Jadikan Pengurus
    $('#tableSantri tbody').on('click', '.btn-jadikan-pengurus', function() {
        let id = $(this).data('id');

        Swal.fire({
            title: 'Jadikan Pengurus?',
            text: "Santri ini akan dipindahkan ke Data Ustadz & Pengurus dengan jabatan default 'Pengurus Baru'.",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3b6f58',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Jadikan Pengurus'
        }).then((result) => {
            if (result.isConfirmed) {
                let formData = new FormData();
                formData.append('id_santri', id);
                
                fetch('jadikan_pengurus.php', { method: 'POST', body: formData })
                .then(res => res.json())
                .then(data => {
                    if(data.status === 'success') {
                        table.ajax.reload(null, false);
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
            }
        });
    });
});
</script>