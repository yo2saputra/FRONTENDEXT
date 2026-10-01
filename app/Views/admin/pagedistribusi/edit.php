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
                    <!-- jquery validation -->
                    <div class="card card-outline card-info">

                        <!-- error -->
                        <?php if (session()->has('errors')) : ?>
                            <div class="alert alert-warning alert-dismissible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <ul>
                                    <?php foreach (session('errors') as $error) : ?>
                                        <li><?= esc($error) ?></li>
                                    <?php endforeach ?>
                                </ul>
                            </div>
                        <?php endif ?>
                        <!-- end error -->


                        <div class="card-body">
                            <?php $validation = \Config\Services::validation(); ?>

                            <!-- form start -->
                            <form action="/admin/pagedistribusi/update/<?= $pagedistribusies['id'] ?>" id="quickForm" method="post" enctype="multipart/form-data">
                                <?= csrf_field(); ?>
                                <div class="card-body">
                                    <input type="hidden" name="id" value="<?= $pagedistribusies['id'] ?>">
                                    <div class="mb-3 row">
                                        <label class="col-sm-2 col-form-label">Judul Distribusi</label>
                                        <div class="col-sm-4 mb-2">
                                            <input type="text" class="form-control" name="judulDistribusiWarna" placeholder="Judul Warna" value="<?= set_value('judulDistribusiWarna') ? set_value('judulDistribusiWarna') : $pagedistribusies['judulDistribusiWarna']; ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="judulDistribusi" placeholder="Judul" value="<?= set_value('judulDistribusi') ? set_value('judulDistribusi') : $pagedistribusies['judulDistribusi']; ?>">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="textDistribusi" class="col-sm-2 col-form-label">Text Distribusi</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control summernote" id="textDistribusi" rows="3" name="textDistribusi"><?= set_value('textDistribusi') ? set_value('textDistribusi') : $pagedistribusies['textDistribusi'] ?>
                                            </textarea>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-2 col-form-label">Judul Cabang</label>
                                        <div class="col-sm-4 mb-2">
                                            <input type="text" class="form-control" name="judulCabangWarna" placeholder="Judul Warna" value="<?= set_value('judulCabangWarna') ? set_value('judulCabangWarna') : $pagedistribusies['judulCabangWarna']; ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="judulCabang" placeholder="Judul" value="<?= set_value('judulCabang') ? set_value('judulCabang') : $pagedistribusies['judulCabang']; ?>">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="textCabang" class="col-sm-2 col-form-label">Text Cabang</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control summernote" id="textCabang" rows="3" name="textCabang"><?= set_value('textCabang') ? set_value('textCabang') : $pagedistribusies['textCabang'] ?>
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>

                        </div>
                    </div>
                    <!-- /.card -->
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