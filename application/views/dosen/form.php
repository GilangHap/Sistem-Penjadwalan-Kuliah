<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?=base_url('dosen')?>">Dosen</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Dosen</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4 border-left-primary">
                <div class="card-header py-3 d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user-tie me-2"></i>Form Tambah Dosen
                    </h6>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('dosen/save') ?>" method="post" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Kode Dosen</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="fas fa-id-card"></i>
                                    </span>
                                    <input type="text" class="form-control" name="kode_dosen" placeholder="Masukkan kode dosen" required>
                                    <div class="invalid-feedback">
                                        Kode dosen harus diisi!
                                    </div>
                                </div>
                                <small class="text-muted">Contoh: DS001</small>
                            </div>
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Nama Dosen</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text" class="form-control" name="nama_dosen" placeholder="Masukkan nama lengkap dosen" required>
                                    <div class="invalid-feedback">
                                        Nama dosen harus diisi!
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <div class="input-group">
                                    <div class="form-check form-switch ms-2 mt-2">
                                        <input type="checkbox" class="form-check-input" name="status_aktif" id="status_aktif" checked>
                                        <label class="form-check-label" for="status_aktif">Aktif</label>
                                    </div>
                                </div>
                                <small class="text-muted">Status keaktifan dosen</small>
                            </div>
                        </div>
                        
                        <div class="mt-4 d-flex">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fas fa-save me-1"></i> Simpan
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
// Form validation script
(function() {
    'use strict';
    
    // Fetch all forms to which we want to apply validation
    var forms = document.querySelectorAll('.needs-validation');
    
    // Loop over each form and prevent submission if validation fails
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
</script>