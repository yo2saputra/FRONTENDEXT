<?= $this->extend('admin/admin_template'); ?>

<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Resep</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Resep</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="card" style="max-width: auto;">
                    <div class="card-body">
                        <div class="row no-gutters">
                            <div class="col-md-4 d-flex align-items-center card-img-block" style="background-color: #e9e9e9;">
                                <img src="<?= base_url('assets/img/resep/') . $reseps['gambarResep']; ?>" class="card-img img-fluid" alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h4 class="card-title mb-2"><?= $reseps['judulResep']; ?></h4>
                                    <p class="card-text"><?= $reseps['isiResep']; ?></p>
                                    <p class="card-text"><small class="text-muted"><span class="time"><i class="fas fa-clock"></i> <?= ucwords($reseps['prosesResep']); ?> Menit</span></small></p>
                                    <p class="card-text">Last updated <?= date('d F, Y', strtotime($reseps['updated_at'])); ?></small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="<?= base_url('/admin/resep/edit/') . $reseps['slugResep'] ?>" class="btn btn-primary">Edit</a>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?= $this->endSection('content'); ?>