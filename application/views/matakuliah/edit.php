<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?=base_url('matakuliah')?>">Mata Kuliah</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Mata Kuliah</li>
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
                        <i class="fas fa-edit me-2"></i>Form Edit Mata Kuliah
                    </h6>
                </div>
                <div class="card-body">
                    <form method="post" action="<?=base_url('matakuliah/update/'.$matakuliah->id_matkul)?>" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Kode Mata Kuliah</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="fas fa-hashtag"></i>
                                    </span>
                                    <input type="text" class="form-control" id="kode_matkul" name="kode_matkul" 
                                           value="<?=$matakuliah->kode_matkul?>" placeholder="Masukkan kode mata kuliah" required>
                                    <div class="invalid-feedback">
                                        Kode mata kuliah harus diisi!
                                    </div>
                                </div>
                                <small class="text-muted">Contoh: MK001</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">SKS</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="fas fa-clock"></i>
                                    </span>
                                    <input type="number" class="form-control" id="sks" name="sks" 
                                           value="<?=$matakuliah->sks?>" placeholder="Masukkan jumlah SKS" min="1" max="6" required>
                                    <div class="invalid-feedback">
                                        Jumlah SKS harus diisi!
                                    </div>
                                </div>
                                <small class="text-muted">Kisaran 1-6 SKS</small>
                            </div>
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Nama Mata Kuliah</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="fas fa-bookmark"></i>
                                    </span>
                                    <input type="text" class="form-control" id="nama_matkul" name="nama_matkul" 
                                           value="<?=$matakuliah->nama_matkul?>" placeholder="Masukkan nama mata kuliah" required>
                                    <div class="invalid-feedback">
                                        Nama mata kuliah harus diisi!
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4 d-flex">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                            </button>
                            <a href="<?=base_url('matakuliah')?>" class="btn btn-secondary">
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