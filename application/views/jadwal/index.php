<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Jadwal Kuliah</li>
                </ol>
            </nav>
        </div>
    </div>

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
                        <i class="fas fa-calendar-alt me-2"></i>Data Jadwal
                    </h6>
                    <div>
                        <a href="<?= base_url('jadwal/calendar') ?>" class="btn btn-info">
                            <i class="fas fa-calendar-alt me-1"></i> Lihat Kalender
                        </a>
                        <a href="<?= base_url('jadwal/add') ?>" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> Tambah Jadwal
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover datatable" id="jadwalTable">
                            <thead class="table-light">
                                <tr>
                                    <th width="3%">No</th>
                                    <th width="15%">Mata Kuliah</th>
                                    <th width="15%">Dosen</th>
                                    <th width="8%">Ruangan</th>
                                    <th width="8%">Hari</th>
                                    <th width="10%">Waktu</th>
                                    <th width="7%">Kelas</th>
                                    <th width="8%">Semester</th>
                                    <th width="10%">Tahun Ajaran</th>
                                    <th width="16%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach($jadwal_list as $jadwal): ?>
                                <tr>
                                    <td class="align-middle"><?= $no++ ?></td>
                                    <td class="align-middle"><?= $jadwal->nama_matkul ?></td>
                                    <td class="align-middle"><?= $jadwal->nama_dosen ?></td>
                                    <td class="align-middle"><?= $jadwal->kode_ruang ?></td>
                                    <td class="align-middle"><?= $jadwal->hari ?></td>
                                    <td class="align-middle"><?= substr($jadwal->jam_mulai, 0, 5) ?> - <?= substr($jadwal->jam_selesai, 0, 5) ?></td>
                                    <td class="align-middle text-center"><?= $jadwal->kelas ?></td>
                                    <td class="align-middle"><?= $jadwal->semester ?></td>
                                    <td class="align-middle"><?= $jadwal->tahun_ajaran ?></td>
                                    <td class="align-middle text-center">
                                        <div class="btn-group">
                                            <a href="<?= base_url('jadwal/edit/'.$jadwal->id_jadwal) ?>" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="Edit Jadwal">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="<?= $jadwal->id_jadwal ?>" data-bs-toggle="tooltip" title="Hapus Jadwal">
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
    if ($.fn.dataTable.isDataTable('#jadwalTable')) {
        $('#jadwalTable').DataTable().destroy();
    }
    
    // Initialize DataTable with advanced features
    $('#jadwalTable').DataTable({
        responsive: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Cari jadwal...",
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            zeroRecords: "Tidak ada data jadwal",
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
    
    // Delete confirmation with SweetAlert2
    $('.btn-delete').on('click', function() {
        var id = $(this).data('id');
        
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: "Apakah Anda yakin ingin menghapus jadwal ini? Data yang dihapus tidak dapat dikembalikan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?= base_url('jadwal/delete/') ?>' + id;
            }
        });
    });
    
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').alert('close');
    }, 5000);
});
</script>