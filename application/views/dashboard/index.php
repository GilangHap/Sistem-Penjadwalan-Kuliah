<div class="container py-4">
    <!-- Welcome Message -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card bg-primary text-white shadow">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div>
                            <h4 class="fw-bold mb-1">Selamat Datang di Sistem Penjadwalan Kuliah</h4>
                            <p class="mb-0 opacity-75">Hari ini: <?= date('l, d F Y') ?></p>
                        </div>
                        <div class="ms-auto text-end">
                            <i class="fas fa-calendar-alt fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Dosen</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_dosen ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-tie fa-2x text-primary"></i>
                        </div>
                    </div>
                    <a href="<?= base_url('dosen') ?>" class="stretched-link small text-primary mt-2 d-inline-block">
                        Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Mata Kuliah</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_matkul ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-success"></i>
                        </div>
                    </div>
                    <a href="<?= base_url('matakuliah') ?>" class="stretched-link small text-success mt-2 d-inline-block">
                        Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Ruangan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_ruangan ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-door-open fa-2x text-info"></i>
                        </div>
                    </div>
                    <a href="<?= base_url('ruangan') ?>" class="stretched-link small text-info mt-2 d-inline-block">
                        Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Jadwal</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_jadwal ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-warning"></i>
                        </div>
                    </div>
                    <a href="<?= base_url('jadwal') ?>" class="stretched-link small text-warning mt-2 d-inline-block">
                        Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Links & Summary -->
    <div class="row mb-4">
        <div class="col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-line me-2"></i>Ikhtisar Jadwal
                    </h6>
                    <div class="dropdown ms-auto">
                        <button class="btn btn-sm btn-link" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="<?= base_url('jadwal') ?>">Lihat Semua Jadwal</a>
                            <a class="dropdown-item" href="<?= base_url('jadwal/calendar') ?>">Lihat Kalender</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="weeklyScheduleChart" style="height: 300px;"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-link me-2"></i>Akses Cepat
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="<?= base_url('jadwal/add') ?>" class="list-group-item list-group-item-action d-flex align-items-center">
                            <div class="bg-primary text-white rounded-3 p-2 me-3">
                                <i class="fas fa-plus"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Buat Jadwal Baru</h6>
                                <small class="text-muted">Tambahkan jadwal kuliah baru</small>
                            </div>
                        </a>
                        <a href="<?= base_url('dosen/add') ?>" class="list-group-item list-group-item-action d-flex align-items-center">
                            <div class="bg-success text-white rounded-3 p-2 me-3">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Tambah Dosen</h6>
                                <small class="text-muted">Daftarkan dosen baru</small>
                            </div>
                        </a>
                        <a href="<?= base_url('matakuliah/tambah') ?>" class="list-group-item list-group-item-action d-flex align-items-center">
                            <div class="bg-info text-white rounded-3 p-2 me-3">
                                <i class="fas fa-book-open"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Tambah Mata Kuliah</h6>
                                <small class="text-muted">Daftarkan mata kuliah baru</small>
                            </div>
                        </a>
                        <a href="<?= base_url('ruangan/tambah') ?>" class="list-group-item list-group-item-action d-flex align-items-center">
                            <div class="bg-warning text-white rounded-3 p-2 me-3">
                                <i class="fas fa-door-closed"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Tambah Ruangan</h6>
                                <small class="text-muted">Daftarkan ruangan baru</small>
                            </div>
                        </a>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Validations -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-exclamation-triangle me-2"></i>Validasi Jadwal Terbaru
                    </h6>
                    <span class="badge bg-danger ms-2"><?= count($recent_validations) ?></span>
                </div>
                <div class="card-body">
                    <?php if(empty($recent_validations)): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <h5>Tidak Ada Masalah Jadwal</h5>
                            <p class="text-muted">Semua jadwal telah divalidasi dan tidak ditemukan konflik.</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover datatable">
                                <thead class="table-light">
                                    <tr>
                                        <th>Jadwal</th>
                                        <th>Tipe Validasi</th>
                                        <th>Pesan Error</th>
                                        <th>Waktu</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($recent_validations as $validation): ?>
                                    <tr>
                                        <td><?= $validation->nama_matkul ?> - <?= $validation->kelas ?></td>
                                        <td>
                                            <span class="badge bg-<?= $validation->tipe_validasi == 'dosen' ? 'primary' : ($validation->tipe_validasi == 'ruang' ? 'success' : 'warning') ?>">
                                                <?= ucfirst($validation->tipe_validasi) ?>
                                            </span>
                                        </td>
                                        <td><?= $validation->pesan_error ?></td>
                                        <td><?= date('d/m/Y H:i', strtotime($validation->waktu_validasi)) ?></td>
                                        <td>
                                            <span class="badge bg-<?= $validation->status == 'terdeteksi' ? 'danger' : 'success' ?>">
                                                <?= ucfirst($validation->status) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('jadwal/edit/'.$validation->id_jadwal) ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit me-1"></i>Perbaiki
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.40.0/dist/apexcharts.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize DataTable
    $('.datatable').DataTable({
        responsive: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Cari...",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            paginate: {
                next: '<i class="fas fa-chevron-right"></i>',
                previous: '<i class="fas fa-chevron-left"></i>'
            }
        },
        dom: '<"row"<"col-md-6"l><"col-md-6"f>>' +
             '<"row"<"col-md-12"rt>>' +
             '<"row"<"col-md-5"i><"col-md-7"p>>',
    });
    
    // Schedule Distribution Chart
    var options = {
        series: [{
            name: 'Jadwal',
            data: [
                <?php 
                // Contoh data untuk chart, idealnya dari controller
                echo $monday_count ?? 5; ?>, 
                <?php echo $tuesday_count ?? 8; ?>, 
                <?php echo $wednesday_count ?? 12; ?>, 
                <?php echo $thursday_count ?? 7; ?>, 
                <?php echo $friday_count ?? 9; ?>, 
                <?php echo $saturday_count ?? 3; ?>
            ]
        }],
        chart: {
            height: 300,
            type: 'bar',
            toolbar: {
                show: false
            }
        },
        colors: ['#0d6efd'],
        plotOptions: {
            bar: {
                borderRadius: 4,
                dataLabels: {
                    position: 'top',
                },
            }
        },
        dataLabels: {
            enabled: true,
            formatter: function (val) {
                return val;
            },
            offsetY: -20,
            style: {
                fontSize: '12px',
                colors: ["#304758"]
            }
        },
        xaxis: {
            categories: ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"],
            position: 'bottom',
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            },
            tooltip: {
                enabled: false,
            }
        },
        yaxis: {
            title: {
                text: 'Jumlah Jadwal'
            },
        },
        title: {
            text: 'Distribusi Jadwal per Hari',
            align: 'center',
            floating: false,
            style: {
                fontSize: '14px',
                fontWeight: 'bold',
                fontFamily: 'Poppins, sans-serif',
            },
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return val + " jadwal"
                }
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#weeklyScheduleChart"), options);
    chart.render();
});

</script>