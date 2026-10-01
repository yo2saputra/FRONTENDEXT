<?= $this->extend('admin/admin_template'); ?>

<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Blog</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Blog</li>
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
                <!-- <div class="col-md-12">
                    <div class="card mb-3" style="max-width: 540px;">
                        <img src="<?= base_url('assets/img/blog/') . $blogs['gambarBlog']; ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h4 class="card-title mb-2"><?= $blogs['judulBlog']; ?></h4>
                            <p class="card-text"><?= $blogs['isiBlog']; ?></p>
                            <p class="card-text"><small class="text-muted">Last updated <?= date('d F, Y', strtotime($blogs['updated_at'])); ?></small></p>
                        </div>
                        <div class="card-footer"><a href="<?= base_url('/admin/blog/edit/') . $blogs['slugBlog'] ?>" class="btn btn-primary">Edit</a></div>
                    </div>
                </div> -->
                <!--/.col (left) -->

                <div class="card" style="max-width: auto;">
                    <div class="card-body">
                        <div class="row no-gutters">
                            <div class="col-md-4 d-flex align-items-center card-img-block" style="background-color: #e9e9e9;">
                                <img src="<?= base_url('assets/img/blog/') . $blogs['gambarBlog']; ?>" class="card-img img-fluid" alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h4 class="card-title mb-2"><?= $blogs['judulBlog']; ?></h4>
                                    <p class="card-text"><?= $blogs['isiBlog']; ?></p>
                                    <p class="card-text"><small class="text-muted">Last updated <?= date('d F, Y', strtotime($blogs['updated_at'])); ?></small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="<?= base_url('/admin/blog/edit/') . $blogs['slugBlog'] ?>" class="btn btn-primary">Edit</a>
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