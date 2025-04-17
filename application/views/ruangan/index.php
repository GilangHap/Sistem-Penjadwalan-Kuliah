<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Ruangan</li>
                </ol>
            </nav>
        </div>
    </div>
    
    <?php if($this->session->flashdata('pesan')): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?= $this->session->flashdata('pesan') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4 border-left-primary">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-door-open me-2"></i>Daftar Ruangan
                    </h6>
                    <div>
                        <a href="<?=base_url('ruangan/tambah')?>" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> Tambah Ruangan
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover datatable" id="tabel_data">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%"> No </th>
                                    <th width="25%"> Kode Ruang </th>
                                    <th width="25%"> Kapasitas </th>
                                    <th width="20%"> Status </th>
                                    <th width="25%" class="text-center"> Aksi </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; foreach($list as $row) { ?>
                                    <tr>
                                        <td class="align-middle"><?=$no++?></td>
                                        <td class="align-middle"><?=$row->kode_ruang?></td>
                                        <td class="align-middle"><?=$row->kapasitas?> orang</td>
                                        <td class="align-middle">
                                            <?php if($row->status_aktif == 1): ?>
                                                <span class="badge bg-success">Aktif</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Tidak Aktif</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="btn-group" role="group">
                                                <a href="<?=base_url('ruangan/edit/'.$row->id_ruang)?>" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="Edit Ruangan">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm btn-delete" 
                                                        data-id="<?=$row->id_ruang?>" 
                                                        data-kode="<?=$row->kode_ruang?>" 
                                                        data-bs-toggle="tooltip" title="Hapus Ruangan">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
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
    // Initialize DataTable with advanced features
    $('#tabel_data').DataTable({
        responsive: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Cari ruangan...",
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            zeroRecords: "Tidak ada data ruangan",
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
    });
    
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
    
    // SweetAlert confirmation for delete with AJAX
    $('.btn-delete').on('click', function() {
        var id = $(this).data('id');
        var kode = $(this).data('kode') || 'ruangan ini';
        
        Swal.fire({
            title: 'Konfirmasi Hapus',
            html: "Apakah Anda yakin ingin menghapus <strong>" + kode + "</strong>?<br>Data yang dihapus tidak dapat dikembalikan.",
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
                    url: '<?= base_url('ruangan/delete_ajax/') ?>' + id,
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
                                            url: '<?= base_url('ruangan/delete_confirm_ajax/') ?>' + id,
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