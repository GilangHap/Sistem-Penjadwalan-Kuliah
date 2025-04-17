<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?=base_url('jadwal')?>">Jadwal</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Jadwal</li>
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
                <div class="card-header py-3 d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-edit me-2"></i>Form Edit Jadwal
                    </h6>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('jadwal/update/'.$jadwal->id_jadwal) ?>" method="post" id="jadwalForm" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Mata Kuliah</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="fas fa-book"></i>
                                    </span>
                                    <select class="form-select" name="id_matkul" id="id_matkul" required>
                                        <option value="">Pilih Mata Kuliah</option>
                                        <?php foreach($matkul_list as $matkul): ?>
                                        <option value="<?= $matkul->id_matkul ?>" data-sks="<?= $matkul->sks ?>" <?= ($jadwal->id_matkul == $matkul->id_matkul) ? 'selected' : '' ?>>
                                            <?= $matkul->nama_matkul ?> (<?= $matkul->sks ?> SKS)
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        Mata kuliah harus dipilih!
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Dosen</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="fas fa-user-tie"></i>
                                    </span>
                                    <select class="form-select" name="id_dosen" required>
                                        <option value="">Pilih Dosen</option>
                                        <?php foreach($dosen_list as $dosen): ?>
                                        <option value="<?= $dosen->id_dosen ?>" <?= ($jadwal->id_dosen == $dosen->id_dosen) ? 'selected' : '' ?>>
                                            <?= $dosen->nama_dosen ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        Dosen pengajar harus dipilih!
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Ruangan</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="fas fa-door-open"></i>
                                    </span>
                                    <select class="form-select" name="id_ruang" required>
                                        <option value="">Pilih Ruangan</option>
                                        <?php foreach($ruangan_list as $ruangan): ?>
                                        <option value="<?= $ruangan->id_ruang ?>" <?= ($jadwal->id_ruang == $ruangan->id_ruang) ? 'selected' : '' ?>>
                                            <?= $ruangan->kode_ruang ?> (Kapasitas: <?= $ruangan->kapasitas ?> orang)
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        Ruangan harus dipilih!
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Hari</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="fas fa-calendar-day"></i>
                                    </span>
                                    <select class="form-select" name="hari" required>
                                        <option value="">Pilih Hari</option>
                                        <option value="Senin" <?= ($jadwal->hari == 'Senin') ? 'selected' : '' ?>>Senin</option>
                                        <option value="Selasa" <?= ($jadwal->hari == 'Selasa') ? 'selected' : '' ?>>Selasa</option>
                                        <option value="Rabu" <?= ($jadwal->hari == 'Rabu') ? 'selected' : '' ?>>Rabu</option>
                                        <option value="Kamis" <?= ($jadwal->hari == 'Kamis') ? 'selected' : '' ?>>Kamis</option>
                                        <option value="Jumat" <?= ($jadwal->hari == 'Jumat') ? 'selected' : '' ?>>Jumat</option>
                                        <option value="Sabtu" <?= ($jadwal->hari == 'Sabtu') ? 'selected' : '' ?>>Sabtu</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Hari harus dipilih!
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">SKS Mulai</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="fas fa-hourglass-start"></i>
                                    </span>
                                    <select class="form-select" name="sks_ke" required>
                                        <option value="">Pilih SKS Mulai</option>
                                        <?php foreach($sks_options as $sks): ?>
                                        <option value="<?= $sks->urutan_sks ?>" <?= ($jadwal->sks_ke == $sks->urutan_sks) ? 'selected' : '' ?>>
                                            SKS <?= $sks->urutan_sks ?> (<?= substr($sks->jam_mulai, 0, 5) ?>)
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        Sesi mulai harus dipilih!
                                    </div>
                                </div>
                                <small class="text-muted">Jam sesi awal perkuliahan</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Jumlah SKS</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="fas fa-clock"></i>
                                    </span>
                                    <input type="number" class="form-control" name="jumlah_sks" id="jumlah_sks" min="1" max="4" value="<?= $jadwal->jumlah_sks ?>" required>
                                    <div class="invalid-feedback">
                                        Jumlah SKS harus diisi!
                                    </div>
                                </div>
                                <small class="text-muted">Jumlah SKS yang diambil</small>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Kelas</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="fas fa-users"></i>
                                    </span>
                                    <input type="text" class="form-control" name="kelas" placeholder="Contoh: A, B, C" value="<?= $jadwal->kelas ?>" required>
                                    <div class="invalid-feedback">
                                        Kelas harus diisi!
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Semester</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="fas fa-university"></i>
                                    </span>
                                    <select class="form-select" name="semester" required>
                                        <option value="">Pilih Semester</option>
                                        <option value="Ganjil" <?= ($jadwal->semester == 'Ganjil') ? 'selected' : '' ?>>Ganjil</option>
                                        <option value="Genap" <?= ($jadwal->semester == 'Genap') ? 'selected' : '' ?>>Genap</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Semester harus dipilih!
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tahun Ajaran</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="fas fa-calendar"></i>
                                    </span>
                                    <input type="text" class="form-control" name="tahun_ajaran" placeholder="2024/2025" value="<?= $jadwal->tahun_ajaran ?>" required>
                                    <div class="invalid-feedback">
                                        Tahun ajaran harus diisi!
                                    </div>
                                </div>
                                <small class="text-muted">Format: 2024/2025</small>
                            </div>
                        </div>
                        
                        <div class="mt-4 d-flex">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                            </button>
                            <a href="<?= base_url('jadwal') ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Mata kuliah SKS handler
    $('#id_matkul').change(function() {
        var sks = $(this).find(':selected').data('sks');
        $('#jumlah_sks').val(sks).attr('max', sks);
    });
    
    // Form validation
    (function() {
        'use strict';
        
        var forms = document.querySelectorAll('.needs-validation');
        
        Array.prototype.slice.call(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
    
    // Check for schedule conflicts
    $('#jadwalForm').submit(function(e) {
        if (!this.checkValidity()) {
            return;
        }
        
        e.preventDefault();
        
        var form = $(this);
        var url = form.attr('action');
        
        // Add the jadwal ID to exclude from conflict checks
        var formData = form.serialize() + '&current_id=<?= $jadwal->id_jadwal ?>';
        
        $.ajax({
            type: 'POST',
            url: '<?= base_url('jadwal/check_availability_edit') ?>',
            data: formData,
            dataType: 'json',
            beforeSend: function() {
                $('button[type="submit"]').prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memeriksa...'
                );
            },
            success: function(response) {
                if (response.available) {
                    form.unbind('submit').submit();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Jadwal Bentrok',
                        text: response.message || 'Jadwal yang Anda pilih bertabrakan dengan jadwal lain. Silakan pilih waktu yang berbeda.',
                        confirmButtonColor: '#3085d6'
                    });
                    $('button[type="submit"]').prop('disabled', false).html('<i class="fas fa-save me-1"></i> Simpan Perubahan');
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan',
                    text: 'Terjadi kesalahan saat memeriksa jadwal. Silakan coba lagi.',
                    confirmButtonColor: '#3085d6'
                });
                $('button[type="submit"]').prop('disabled', false).html('<i class="fas fa-save me-1"></i> Simpan Perubahan');
            }
        });
    });
});
</script>