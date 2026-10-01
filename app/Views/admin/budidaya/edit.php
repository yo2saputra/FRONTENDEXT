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

                        <!-- /.card-header -->
                        <?php $validation = \Config\Services::validation(); ?>

                        <!-- form start -->
                        <form action="/admin/budidaya/update/<?= $budidaya['id'] ?>" id="quickForm" method="post">
                            <?= csrf_field(); ?>
                            <div class="card-body">
                                <input type="hidden" name="id" value="<?= $budidaya['id'] ?>">
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label">Judul</label>
                                    <div class="col-sm-6 mb-2">
                                        <input type="text" class="form-control" name="judulBudidayaWarna" placeholder="Judul Warna" value="<?= set_value('judulBudidayaWarna') ? set_value('judulBudidayaWarna') : $budidaya['judulBudidayaWarna']; ?>">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="judulBudidaya" placeholder="Judul" value="<?= set_value('judulBudidaya') ? set_value('judulBudidaya') : $budidaya['judulBudidaya']; ?>">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="textBudidaya" class="col-sm-2 col-form-label">Text Budidaya</label>
                                    <div class="col-sm-10">
                                        <textarea id="summernote" class="form-control summernote" id="textBudidaya" rows="3" name="textBudidaya"><?= set_value('textBudidaya') ? set_value('textBudidaya') : $budidaya['textBudidaya']; ?>
                                    </textarea>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="isiBudidaya" class="col-sm-2 col-form-label">Isi Budidaya</label>
                                    <div class="col-sm-10">
                                        <textarea id="summernote" class="form-control summernote" id="isiBudidaya" rows="3" name="isiBudidaya"><?= set_value('isiBudidaya') ? set_value('isiBudidaya') : $budidaya['isiBudidaya']; ?>
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
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->

            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?= $this->endSection('content'); ?>