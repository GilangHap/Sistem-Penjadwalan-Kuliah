<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dosen</li>
                </ol>
            </nav>
        </div>
    </div>

    <?php if($this->session->flashdata('success')): ?>
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?= $this->session->flashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if($this->session->flashdata('error')): ?>
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?= $this->session->flashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4 border-left-primary">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user-tie me-2"></i>Data Dosen
                    </h6>
                    <a href="<?= base_url('dosen/add') ?>" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Tambah Dosen
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover datatable" id="dosenTable">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="15%">Kode Dosen</th>
                                    <th width="45%">Nama Dosen</th>
                                    <th width="15%">Status</th>
                                    <th width="20%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach($dosen_list as $dosen): ?>
                                <tr>
                                    <td class="align-middle"><?= $no++ ?></td>
                                    <td class="align-middle"><?= $dosen->kode_dosen ?></td>
                                    <td class="align-middle"><?= $dosen->nama_dosen ?></td>
                                    <td class="align-middle">
                                        <span class="badge bg-<?= $dosen->status_aktif ? 'success' : 'danger' ?>">
                                            <?= $dosen->status_aktif ? 'Aktif' : 'Nonaktif' ?>
                                        </span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <div class="btn-group">
                                            <a href="<?= base_url('dosen/edit/'.$dosen->id_dosen) ?>" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="Edit Dosen">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm btn-delete" 
                                                    data-id="<?= $dosen->id_dosen ?>" 
                                                    data-name="<?= $dosen->nama_dosen ?>" 
                                                    data-bs-toggle="tooltip" title="Hapus Dosen">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Solusi untuk menghindari reinitialisation error
    if ($.fn.dataTable.isDataTable('#dosenTable')) {
        // Jika tabel sudah diinisialisasi, destroy instance yang ada
        $('#dosenTable').DataTable().destroy();
    }
    
    // Initialize DataTable with advanced features
    $('#dosenTable').DataTable({
        responsive: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Cari dosen...",
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            zeroRecords: "Tidak ada data dosen",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Tidak ada data yang ditampilkan",
            infoFiltered: "(difilter dari _MAX_ total data)",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "<i class='fas fa-chevron-right'></i>",
                previous: "<i class='fas fa-chevron-left'></i>"
            }
        },
        dom: '<"row"<"col-md-6"l><"col-md-6"f>>' +
             '<"row"<"col-md-12"rt>>' +
             '<"row"<"col-md-5"i><"col-md-7"p>>',
    });
    
    // Initialize tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();
    
    // Perbaikan fungsi delete confirmation dengan SweetAlert2
    $('.btn-delete').on('click', function() {
        var id = $(this).data('id');
        var name = $(this).data('name') || 'dosen ini';
        
        Swal.fire({
            title: 'Konfirmasi Hapus',
            html: "Apakah Anda yakin ingin menghapus <strong>" + name + "</strong>? <br>Data yang dihapus tidak dapat dikembalikan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Tampilkan loading state
                Swal.fire({
                    title: 'Menghapus...',
                    html: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Kirim request AJAX untuk delete
                $.ajax({
                    url: '<?= base_url('dosen/delete_ajax/') ?>' + id,
                    type: 'POST',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: response.message,
                                icon: 'success'
                            }).then(() => {
                                // Reload halaman setelah berhasil
                                location.reload();
                            });
                        } else {
                            // Jika ada jadwal terkait, tanyakan konfirmasi lagi
                            if (response.has_jadwal) {
                                Swal.fire({
                                    title: 'Peringatan!',
                                    html: response.message,
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#d33',
                                    cancelButtonColor: '#6c757d',
                                    confirmButtonText: 'Ya, Hapus Semua!',
                                    cancelButtonText: 'Batal'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Kirim request untuk force delete
                                        $.ajax({
                                            url: '<?= base_url('dosen/delete_confirm_ajax/') ?>' + id,
                                            type: 'POST',
                                            dataType: 'json',
                                            success: function(response) {
                                                Swal.fire({
                                                    title: response.success ? 'Berhasil!' : 'Gagal!',
                                                    text: response.message,
                                                    icon: response.success ? 'success' : 'error'
                                                }).then(() => {
                                                    if (response.success) location.reload();
                                                });
                                            },
                                            error: function() {
                                                Swal.fire({
                                                    title: 'Error!',
                                                    text: 'Terjadi kesalahan pada server',
                                                    icon: 'error'
                                                });
                                            }
                                        });
                                    }
                                });
                            } else {
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: response.message,
                                    icon: 'error'
                                });
                            }
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan pada server',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    });
    
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').alert('close');
    }, 5000);
});
</script>