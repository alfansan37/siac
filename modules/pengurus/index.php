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
            <h3 class="fw-bold text-dark mb-0">Data Ustadz & Pengurus</h3>
            <p class="text-muted mb-0">Kelola data tenaga pendidik dan pengurus pesantren.</p>
        </div>
        <button class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#modalPengurus" id="btnTambah">
            <i class="bi bi-plus-lg me-1"></i> Tambah Pengurus
        </button>
    </div>

    <div class="card card-custom p-4">
        <div class="table-responsive">
            <table id="tablePengurus" class="table table-hover w-100">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="25%">Nama Lengkap</th>
                        <th width="20%">Jabatan & Pendidikan</th>
                        <th width="5%">L/P</th>
                        <th width="15%">No. HP</th>
                        <th width="20%">Alamat Lengkap</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Form Pengurus -->
<div class="modal fade" id="modalPengurus" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalPengurusLabel">Form Pengurus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formPengurus">
                <div class="modal-body">
                    <input type="hidden" name="id_ustadz" id="id_ustadz">
                    <input type="hidden" name="action" id="formAction" value="store">
                    
                    <div class="row g-3">
                        <div class="col-12 mb-1"><h6 class="fw-bold border-bottom pb-2 text-primary">A. Data Diri & Akademik</h6></div>
                        
                        <div class="col-md-8">
                            <label class="form-label text-muted small fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama" id="nama" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small fw-semibold">L/P <span class="text-danger">*</span></label>
                            <select class="form-select" name="jenis_kelamin" id="jenis_kelamin" required>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label text-muted small fw-semibold">Pendidikan Terakhir</label>
                            <select class="form-select" name="pendidikan_terakhir" id="pendidikan_terakhir">
                                <option value="">-- Pilih --</option>
                                <option value="SMA/Sederajat">SMA/Sederajat</option>
                                <option value="Pondok Pesantren">Pondok Pesantren</option>
                                <option value="S1">S1 (Sarjana)</option>
                                <option value="S2">S2 (Magister)</option>
                                <option value="S3">S3 (Doktor)</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small fw-semibold">Jabatan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="jabatan" id="jabatan" placeholder="Cth: Ustadz" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small fw-semibold">Tahun Mulai Tugas</label>
                            <input type="number" class="form-control" name="tahun_mulai" id="tahun_mulai" value="<?= date('Y') ?>">
                        </div>

                        <div class="col-12 mt-3 mb-1"><h6 class="fw-bold border-bottom pb-2 text-primary">B. Informasi Kontak</h6></div>

                        <div class="col-md-12">
                            <label class="form-label text-muted small fw-semibold">No. HP (Aktif)</label>
                            <input type="text" class="form-control" name="no_hp" id="no_hp" placeholder="08...">
                        </div>
                        
                        <div class="col-md-12">
                            <label class="form-label text-muted small fw-semibold">Jalan / Dusun / Desa <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="alamat_jalan" id="alamat_jalan" placeholder="Contoh: Jl. Raya Kranji No. 12 / Ds. Kranji" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-semibold">Kecamatan</label>
                            <input type="text" class="form-control" name="alamat_kecamatan" id="alamat_kecamatan" placeholder="Contoh: Paciran">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-semibold">Kabupaten / Kota</label>
                            <input type="text" class="form-control" name="alamat_kabupaten" id="alamat_kabupaten" placeholder="Contoh: Lamongan">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary-custom">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../components/footer.php'; ?>

<script>
$(document).ready(function() {
    let table = $('#tablePengurus').DataTable({ ajax: 'data_pengurus.php', processing: true });

    $('#btnTambah').click(function() {
        $('#formPengurus')[0].reset();
        $('#id_ustadz').val('');
        $('#formAction').val('store');
        $('#modalPengurusLabel').text('Tambah Ustadz/Pengurus');
    });

    $('#tablePengurus tbody').on('click', '.btn-edit', function() {
        let id = $(this).data('id');
        fetch(`get_data.php?id=${id}`)
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    $('#id_ustadz').val(data.data.id_ustadz);
                    $('#nama').val(data.data.nama);
                    $('#jenis_kelamin').val(data.data.jenis_kelamin);
                    $('#pendidikan_terakhir').val(data.data.pendidikan_terakhir);
                    $('#jabatan').val(data.data.jabatan);
                    $('#tahun_mulai').val(data.data.tahun_mulai);
                    $('#no_hp').val(data.data.no_hp);

                    // LOGIKA PECAH ALAMAT DARI DATABASE
                    let alamatFull = data.data.alamat || '';
                    if (alamatFull.includes(', Kec. ')) {
                        let parts = alamatFull.split(', Kec. ');
                        $('#alamat_jalan').val(parts[0]);
                        
                        if (parts[1].includes(', Kab. ')) {
                            let subParts = parts[1].split(', Kab. ');
                            $('#alamat_kecamatan').val(subParts[0]);
                            $('#alamat_kabupaten').val(subParts[1]);
                        } else {
                            $('#alamat_kecamatan').val(parts[1]);
                            $('#alamat_kabupaten').val('');
                        }
                    } else {
                        // Jika format lama yang belum ada Kec/Kab
                        $('#alamat_jalan').val(alamatFull);
                        $('#alamat_kecamatan').val('');
                        $('#alamat_kabupaten').val('');
                    }

                    $('#formAction').val('update');
                    $('#modalPengurusLabel').text('Edit Data Pengurus');
                    $('#modalPengurus').modal('show');
                }
            });
    });

    $('#formPengurus').submit(function(e) {
        e.preventDefault();
        let action = $('#formAction').val();
        let endpoint = action === 'store' ? 'store.php' : 'update.php';
        
        fetch(endpoint, { method: 'POST', body: new FormData(this) })
        .then(res => res.json())
        .then(data => {
            if(data.status === 'success') {
                $('#modalPengurus').modal('hide');
                table.ajax.reload(null, false);
                Toast.fire({ icon: 'success', title: data.message });
            } else {
                Swal.fire('Gagal', data.message, 'error');
            }
        });
    });

    $('#tablePengurus tbody').on('click', '.btn-delete', function() {
        let id_ustadz = $(this).data('id');
        let id_santri = $(this).data('santri'); 
        
        Swal.fire({
            title: 'Hapus Pengurus?', text: "Data akan dihapus dari sistem.", icon: 'warning',
            showCancelButton: true, confirmButtonColor: '#ef4444', cancelButtonColor: '#6c757d', confirmButtonText: 'Ya, Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                let formData = new FormData();
                formData.append('id_ustadz', id_ustadz);
                if (id_santri) formData.append('id_santri', id_santri);
                
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