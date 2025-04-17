<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?=base_url('dosen')?>">Dosen</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Dosen</li>
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
                        <i class="fas fa-user-edit me-2"></i>Form Edit Dosen
                    </h6>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('dosen/update/'.$dosen->id_dosen) ?>" method="post" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Kode Dosen</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="fas fa-id-card"></i>
                                    </span>
                                    <input type="text" class="form-control" name="kode_dosen" value="<?= $dosen->kode_dosen ?>" placeholder="Masukkan kode dosen" required>
                                    <div class="invalid-feedback">
                                        Kode dosen harus diisi!
                                    </div>
                                </div>
                                <small class="text-muted">Contoh: D001, DSN-001</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="fas fa-toggle-on"></i>
                                    </span>
                                    <select class="form-select" name="status_aktif" required>
                                        <option value="1" <?= $dosen->status_aktif == 1 ? 'selected' : '' ?>>Aktif</option>
                                        <option value="0" <?= $dosen->status_aktif == 0 ? 'selected' : '' ?>>Tidak Aktif</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Status harus dipilih!
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Nama Dosen</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="fas fa-user-tie"></i>
                                    </span>
                                    <input type="text" class="form-control" name="nama_dosen" value="<?= $dosen->nama_dosen ?>" placeholder="Masukkan nama lengkap dosen" required>
                                    <div class="invalid-feedback">
                                        Nama dosen harus diisi!
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                        
                        <div class="mt-4 d-flex">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                            </button>
                            <a href="<?= base_url('dosen') ?>" class="btn btn-secondary">
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
});
</script>