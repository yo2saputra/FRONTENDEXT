<?= $this->extend('admin/admin_template'); ?>

<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Kontak</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Kontak</li>
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
                        <form action="/admin/kontak/update/<?= $kontaks['id'] ?>" id="quickForm" method="post">
                            <?= csrf_field(); ?>
                            <div class="card-body">
                                <input type="hidden" name="id" value="<?= $kontaks['id'] ?>">
                                <div class="mb-3 row">
                                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="email" name="email" value="<?= set_value('email') ? set_value('email') : $kontaks['email'] ?>">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="textKontak" class="col-sm-2 col-form-label">Text Kontak</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control summernote" id="textKontak" rows="3" name="textKontak"><?= set_value('textKontak') ? set_value('textKontak') : $kontaks['textKontak'] ?>
                                    </textarea>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="map" class="col-sm-2 col-form-label">Map</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control summernote" id="map" rows="3" name="map"><?= set_value('map') ? set_value('map') : $kontaks['map'] ?>
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