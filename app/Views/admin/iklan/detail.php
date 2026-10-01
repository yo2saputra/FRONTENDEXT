<?= $this->extend('admin/admin_template'); ?>

<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Iklan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Iklan</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <!-- left column -->
                <!-- <div class="col-md-12 col-sm-6 mb-3">
                    <div class="card mb-3" style="max-width: 540px;">
                        <img src="<?= base_url('assets/img/iklan/') . $iklans['gambarIklan']; ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><?= $iklans['judulIklan']; ?></h5>
                            <p class="card-text"><?= $iklans['textIklan']; ?></p>
                            <p class="card-text"><small class="text-muted">Last updated <?= date('d F, Y', strtotime($iklans['updated_at'])); ?></small></p>
                        </div>
                        <div class="card-footer"><a href="<?= base_url('/admin/iklan/edit/') . $iklans['id'] ?>" class="btn btn-primary">Edit</a></div>
                    </div>
                </div> -->
                <!--/.col (left) -->

                <div class="card" style="max-width: auto;">
                    <div class="card-body">
                        <div class="row no-gutters">
                            <div class="col-md-4 d-flex align-items-center card-img-block" style="background-color: #e9e9e9;">
                                <img src="<?= base_url('assets/img/iklan/') . $iklans['gambarIklan']; ?>" class="card-img img-fluid" alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h4 class="card-title mb-2"><?= $iklans['judulIklan']; ?></h4>
                                    <p class="card-text">
                                    <h3><?= $iklans['judulIklan']; ?> <span class="orange-text"><?= $iklans['judulIklanWarna']; ?></span></h3>
                                    <div class="sale-percent"><span>Sale! <br> Upto</span><?= $iklans['discIklan']; ?>% <span>off</span></div>
                                    <p><?= $iklans['textIklan']; ?></p>
                                    <p class="card-text"><small class="text-muted">Last updated <?= date('d F, Y', strtotime($iklans['updated_at'])); ?></small></p>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="<?= base_url('/admin/iklan/edit/') . $iklans['id'] ?>" class="btn btn-primary">Edit</a>
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