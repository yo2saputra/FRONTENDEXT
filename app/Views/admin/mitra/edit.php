<?= $this->extend('admin/admin_template'); ?>

<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Mitra</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Mitra</li>
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

                        <?php $validation = \Config\Services::validation(); ?>


                        <!-- form start -->
                        <form action="/admin/mitra/update/<?= $mitras['id'] ?>" id="quickForm" method="post" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <div class="card-body">
                                <input type="hidden" name="id" value="<?= $mitras['id'] ?>">
                                <input type="hidden" name="logoMitraLama" value="<?= $mitras['logoMitra'] ?>">
                                <div class="mb-3 row">
                                    <label for="namaMitra" class="col-sm-2 col-form-label">Nama</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="namaMitra" name="namaMitra" value="<?= set_value('namaMitra') ? set_value('namaMitra') : $mitras['namaMitra'] ?>">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="keteranganMitra" class="col-sm-2 col-form-label">Isi</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control summernote" id="keteranganMitra" rows="3" name="keteranganMitra"><?= set_value('keteranganMitra') ? set_value('keteranganMitra') : $mitras['keteranganMitra'] ?>
                                    </textarea>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="" class="col-sm-2 col-form-label">Gambar</label>
                                    <div class="col-sm-10">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="customFile" name="logoMitra">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="kategoriMitra" class="col-sm-2 col-form-label">Kategori</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="kategoriMitra" id="kategoriMitra">
                                            <option value="HORECA" <?= ($mitras['kategoriMitra'] == 'horeca' ? 'selected' : '') ?>>HORECA</option>
                                            <option value="MODERN" <?= ($mitras['kategoriMitra'] == 'modern' ? 'selected' : '') ?>>MODERN</option>
                                            <option value="TRADISIONAL" <?= ($mitras['kategoriMitra'] == 'tradisional' ? 'selected' : '') ?>>TRADISIONAL</option>
                                        </select>
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