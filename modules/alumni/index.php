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
            <h3 class="fw-bold text-dark mb-0">Data Alumni</h3>
            <p class="text-muted mb-0">Kelola data lulusan Pondok Pesantren Asma' Chusna.</p>
        </div>
        <button class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#modalAlumni" id="btnTambah">
            <i class="bi bi-plus-lg me-1"></i> Tambah Alumni
        </button>
    </div>

    <div class="card card-custom p-4">
        <div class="table-responsive">
            <table id="tableAlumni" class="table table-hover w-100">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="20%">Nama Lengkap</th>
                        <th width="5%">L/P</th>
                        <th width="25%">Alamat</th>
                        <th width="15%">No. HP</th>
                        <th width="15%">Tahun Lulus</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Form Alumni -->
<div class="modal fade" id="modalAlumni" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalAlumniLabel">Form Alumni</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formAlumni">
                <div class="modal-body">
                    <input type="hidden" name="id_alumni" id="id_alumni">
                    <input type="hidden" name="id_santri" id="id_santri"> <!-- ID Relasi Hidden -->
                    <input type="hidden" name="action" id="formAction" value="store">
                    
                    <div class="row g-3">
                        <div class="col-12 mb-1"><h6 class="fw-bold border-bottom pb-2 text-success">A. Data Diri</h6></div>
                        
                        <div class="col-md-3">
                            <label class="form-label text-muted small fw-semibold">NIS (Opsional)</label>
                            <input type="text" class="form-control" name="nis" id="nis" placeholder="Kosongkan jika lupa">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama" id="nama" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-muted small fw-semibold">L/P <span class="text-danger">*</span></label>
                            <select class="form-select" name="jenis_kelamin" id="jenis_kelamin" required>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-semibold">Alamat Lengkap</label>
                            <textarea class="form-control" name="alamat" id="alamat" rows="2"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-semibold">No. HP / WA</label>
                            <input type="text" class="form-control" name="no_hp" id="no_hp">
                        </div>

                        <div class="col-12 mt-3 mb-1"><h6 class="fw-bold border-bottom pb-2 text-success">B. Data Kelulusan</h6></div>
                        
                        <div class="col-md-4">
                            <label class="form-label text-muted small fw-semibold">Tahun Lulus <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="tahun_lulus" id="tahun_lulus" value="<?= date('Y') ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small fw-semibold">Status Keterangan <span class="text-danger">*</span></label>
                            <select class="form-select" name="keterangan" id="keterangan" required>
                                <option value="Melanjutkan Pendidikan">Melanjutkan Pendidikan</option>
                                <option value="Bekerja">Bekerja</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small fw-semibold">Pekerjaan/Instansi</label>
                            <input type="text" class="form-control" name="pekerjaan" id="pekerjaan">
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label text-muted small fw-semibold">Catatan Tambahan (Opsional)</label>
                            <textarea class="form-control" name="catatan_tambahan" id="catatan_tambahan" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary-custom" id="btnSimpan">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../components/footer.php'; ?>

<script>
$(document).ready(function() {
    let table = $('#tableAlumni').DataTable({ ajax: 'data_alumni.php', processing: true });

    $('#btnTambah').click(function() {
        $('#formAlumni')[0].reset();
        $('#id_alumni, #id_santri').val('');
        $('#formAction').val('store');
        $('#modalAlumniLabel').text('Tambah Data Alumni Lama');
    });

    $('#tableAlumni tbody').on('click', '.btn-edit', function() {
        let id = $(this).data('id');
        fetch(`get_data.php?id=${id}`)
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    $('#id_alumni').val(data.data.id_alumni);
                    $('#id_santri').val(data.data.id_santri);
                    
                    // Data Diri
                    let nisField = data.data.nis;
                    if(nisField && nisField.startsWith('ALM-')) nisField = ''; // Sembunyikan NIS generate-an sistem
                    $('#nis').val(nisField);
                    
                    $('#nama').val(data.data.nama);
                    $('#jenis_kelamin').val(data.data.jenis_kelamin);
                    $('#alamat').val(data.data.alamat);
                    $('#no_hp').val(data.data.no_hp);
                    
                    // Data Alumni
                    $('#tahun_lulus').val(data.data.tahun_lulus);
                    $('#keterangan').val(data.data.keterangan);
                    $('#pekerjaan').val(data.data.pekerjaan);
                    $('#catatan_tambahan').val(data.data.catatan_tambahan);

                    $('#formAction').val('update');
                    $('#modalAlumniLabel').text('Edit Data Alumni');
                    $('#modalAlumni').modal('show');
                }
            });
    });

    $('#formAlumni').submit(function(e) {
        e.preventDefault();
        let action = $('#formAction').val();
        let endpoint = action === 'store' ? 'store.php' : 'update.php';
        
        fetch(endpoint, { method: 'POST', body: new FormData(this) })
        .then(res => res.json())
        .then(data => {
            if(data.status === 'success') {
                $('#modalAlumni').modal('hide');
                table.ajax.reload(null, false);
                Toast.fire({ icon: 'success', title: data.message });
            } else { Swal.fire('Gagal', data.message, 'error'); }
        });
    });

    $('#tableAlumni tbody').on('click', '.btn-delete', function() {
        let id_alumni = $(this).data('id');
        let id_santri = $(this).data('santri');
        
        Swal.fire({
            title: 'Hapus Data Alumni?',
            text: "Data akan dihapus permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                let formData = new FormData();
                formData.append('id_alumni', id_alumni);
                formData.append('id_santri', id_santri);
                
                fetch('delete.php', { method: 'POST', body: formData })
                .then(res => res.json())
                .then(data => {
                    if(data.status === 'success') {
                        table.ajax.reload(null, false);
                        Toast.fire({ icon: 'success', title: data.message });
                    }
                });
            }
        });
    });
});
</script>