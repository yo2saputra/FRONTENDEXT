<?= $this->extend('admin/admin_template'); ?>

<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Budidaya</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Budidaya</li>
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
                <div class="col-md-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <!-- form start -->
                            <form action="#" method="post">
                                <input type="hidden" name="id" value="<?= $budidaya['id'] ?>">
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label">Judul</label>
                                    <div class="col-sm-6 mb-2">
                                        <input type="text" class="form-control" name="judulBudidayaWarna" placeholder="Judul Warna" value="<?= $budidaya['judulBudidayaWarna']; ?>" disabled>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="judulBudidaya" placeholder="Judul" value="<?= $budidaya['judulBudidaya']; ?>" disabled>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="textBudidaya" class="col-sm-2 col-form-label">Text Budidaya</label>
                                    <div class="col-sm-10">
                                        <textarea id="summernote1" class="form-control summernote" id="textBudidaya" rows="3" name="textBudidaya"><?= $budidaya['textBudidaya']; ?>
                                    </textarea>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="isiBudidaya" class="col-sm-2 col-form-label">isi Budidaya</label>
                                    <div class="col-sm-10">
                                        <textarea id="summernote2" class="form-control summernote" id="isiBudidaya" rows="3" name="isiBudidaya"><?= $budidaya['isiBudidaya']; ?>
                                    </textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a href="<?= base_url('/admin/budidaya/edit/') . $budidaya['id'] ?>" class="btn btn-primary">Edit</a>
                        </div>
                    </div>
                </div>
                <!--/.col (left) -->
                <!-- right column -->
                <div class="col-md-6">

                </div>
                <!--/.col (right) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?= $this->endSection('content'); ?>