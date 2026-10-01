<?= $this->extend('admin/admin_template'); ?>

<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Testimoni</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Testimoni</li>
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
                        <div class="card-header">
                            <h3 class="card-title"></h3>
                        </div>
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
                        <form action="/admin/testimoni/save" id="quickForm" method="post" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <div class="card-body">
                                <div class="mb-3 row">
                                    <label for="namaBuyer" class="col-sm-2 col-form-label">Nama</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control <?= ($validation->getError('namaBuyer') ? 'is-invalid' : '') ?>" id="namaBuyer" name="namaBuyer" value="<?= set_value('namaBuyer'); ?>" id="namaBuyer" name="namaBuyer" value="<?= set_value('namaBuyer'); ?>" autofocus>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('namaBuyer'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="pekerjaanBuyer" class="col-sm-2 col-form-label">Pekerjaan</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control <?= ($validation->getError('pekerjaanBuyer') ? 'is-invalid' : '') ?>" id="pekerjaanBuyer" name="pekerjaanBuyer" value="<?= set_value('pekerjaanBuyer'); ?>" id="pekerjaanBuyer" name="pekerjaanBuyer" value="<?= set_value('pekerjaanBuyer'); ?>" autofocus>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('pekerjaanBuyer'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="isiTestimoni" class="col-sm-2 col-form-label">Isi</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control summernote <?= ($validation->getError('isiTestimoni') ? 'is-invalid' : '') ?>" id="isiTestimoni" rows="3" name="isiTestimoni"><?= set_value('isiTestimoni'); ?>
                                    </textarea>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('isiTestimoni'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="customFile" class="col-sm-2 col-form-label">Gambar</label>
                                    <div class="col-sm-10">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input <?= ($validation->getError('gambarBuyer') ? 'is-invalid' : '') ?>" id="customFile" name="gambarBuyer" />
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('gambarBuyer'); ?>
                                            </div>
                                        </div>
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