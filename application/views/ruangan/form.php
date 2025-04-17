<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?=base_url('ruangan')?>">Ruangan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Ruangan</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4 border-left-primary">
                <div class="card-header py-3 d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-door-open me-2"></i>Form Tambah Ruangan
                    </h6>
                </div>
                <div class="card-body">
                    <form method="post" action="<?=base_url('ruangan/create')?>" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Kode Ruang</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </span>
                                    <input type="text" class="form-control" id="kode_ruang" name="kode_ruang" 
                                           placeholder="Masukkan kode ruangan" required>
                                    <div class="invalid-feedback">
                                        Kode ruangan harus diisi!
                                    </div>
                                </div>
                                <small class="text-muted">Contoh: R101</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Kapasitas</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="fas fa-users"></i>
                                    </span>
                                    <input type="number" class="form-control" id="kapasitas" name="kapasitas" 
                                           placeholder="Masukkan kapasitas ruangan" min="1" required>
                                    <div class="invalid-feedback">
                                        Kapasitas ruangan harus diisi!
                                    </div>
                                </div>
                                <small class="text-muted">Jumlah maksimal mahasiswa</small>
                            </div>
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="fas fa-check-circle"></i>
                                    </span>
                                    <select class="form-select" id="status_aktif" name="status_aktif" required>
                                        <option value="1">Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Status harus dipilih!
                                    </div>
                                </div>
                                <small class="text-muted">Status ketersediaan ruangan</small>
                            </div>
                        </div>
                        
                        <div class="mt-4 d-flex">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fas fa-save me-1"></i> Simpan
                            </button>
                            <a href="<?=base_url('ruangan')?>" class="btn btn-secondary">
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