</main>
    <footer class="bg-white border-top py-3 px-4 text-center text-muted" style="font-size: 0.85rem;">
        &copy; <?= date('Y') ?> Pondok Pesantren Asma' Chusna Kranji. All rights reserved.
    </footer>
 <!-- -- End page-content-wrapper --  -->
 <!-- -- End wrapper -- </div> -->

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Konfigurasi SweetAlert2 Toast Modern ala Tailwind
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    // Handle Logout Konfirmasi dengan SweetAlert2
    document.getElementById('btn-logout')?.addEventListener('click', function() {
        Swal.fire({
            title: 'Konfirmasi Keluar',
            text: "Apakah Anda yakin ingin keluar dari sistem?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3b6f58',
            cancelButtonColor: '#ef4444',
            confirmButtonText: 'Ya, Keluar!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-4'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?= BASE_URL ?>/modules/auth/logout.php';
            }
        });
    });

    // Inisiasi DataTables Global Default
    $.extend(true, $.fn.dataTable.defaults, {
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json",
            search: "_INPUT_",
            searchPlaceholder: "Cari data dengan cepat..."
        },
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Semua"]]
    });
</script>
</body>
</html>