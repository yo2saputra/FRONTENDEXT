<?= $this->extend('clinic/clinic_template'); ?>

<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Distribusi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Distribusi</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="col-md-12 col-sm-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row no-gutters">
                            <div class="col-md-3 d-flex align-items-center card-img-block">
                                <img src="<?= base_url('assets/img/distribusi/') . $distribusies['gambarDistribusi']; ?>" class="card-img img-fluid" alt="<?= $distribusies['namaDistribusi']; ?>" style="background-color: #e9e9e9;">
                            </div>
                            <div class="col-md-9">
                                <div class="card-body">
                                    <h4 class="card-title mb-2"><?= $distribusies['namaDistribusi']; ?></h4>
                                    <p class="card-text"><?= $distribusies['keteranganDistribusi']; ?></p>
                                    <p class="card-text"><small class="text-muted">Last updated <?= date('d F, Y', strtotime($distribusies['updated_at'])); ?></small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="<?= base_url('/admin/distribusi/edit/') . $distribusies['id'] ?>" class="btn btn-primary">Edit</a>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?= $this->endSection('content'); ?>