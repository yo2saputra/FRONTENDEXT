<?= $this->extend('admin/admin_template'); ?>

<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Page Distribusi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Page Distribusi</li>
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
                            <form action="#" id="quickForm" method="post">
                                <input type="hidden" name="id" value="<?= $pagedistribusies['id'] ?>">

                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label">Judul Distribusi</label>
                                    <div class="col-sm-4 mb-2">
                                        <input type="text" class="form-control" name="judulDistribusiWarna" placeholder="Judul Warna" value="<?= $pagedistribusies['judulDistribusiWarna']; ?>" disabled>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="judulDistribusi" placeholder="Judul" value="<?= $pagedistribusies['judulDistribusi']; ?>" disabled>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="textDistribusi" class="col-sm-2 col-form-label">Text Distribusi</label>
                                    <div class="col-sm-10">
                                        <textarea id="summernote2" class="form-control summernote" id="textDistribusi" rows="3" name="textDistribusi"><?= $pagedistribusies['textDistribusi']; ?>
                                    </textarea>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label">Judul Cabang</label>
                                    <div class="col-sm-4 mb-2">
                                        <input type="text" class="form-control" name="judulCabangWarna" placeholder="Judul Warna" value="<?= $pagedistribusies['judulCabangWarna']; ?>" disabled>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="judulCabang" placeholder="Judul" value="<?= $pagedistribusies['judulCabang']; ?>" disabled>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="textCabang" class="col-sm-2 col-form-label">Text Cabang</label>
                                    <div class="col-sm-10">
                                        <textarea id="summernote3" class="form-control summernote" id="textCabang" rows="3" name="textCabang"><?= $pagedistribusies['textCabang']; ?>
                                    </textarea>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="card-footer"><a href="<?= base_url('/admin/pagedistribusi/edit/') . $pagedistribusies['id'] ?>" class="btn btn-primary">Edit</a></div>
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