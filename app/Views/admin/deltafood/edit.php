<?= $this->extend('admin/admin_template'); ?>

<?= $this->section('content'); ?>

<?php $session = session() ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Delta Food</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Delta Food</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <?php if ($session->get('role') == 1) : ?>

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
                            <form action="/admin/deltafood/update/<?= $deltafoods['id'] ?>" id="quickForm" method="post" enctype="multipart/form-data">
                                <?= csrf_field(); ?>
                                <div class="card-body">
                                    <input type="hidden" name="id" value="<?= $deltafoods['id'] ?>">
                                    <input type="hidden" name="gambarDeltafoodLama" value="<?= $deltafoods['gambarDeltafood'] ?>">
                                    <input type="hidden" name="gambarModulDeltafoodLama" value="<?= $deltafoods['gambarModulDeltafood'] ?>">

                                    <div class="mb-3 row">
                                        <label for="" class="col-sm-2 col-form-label">Gambar</label>
                                        <div class="col-sm-10">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="customFile" name="gambarDeltafood">
                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-2 col-form-label">Judul</label>
                                        <div class="col-sm-6 mb-2">
                                            <input type="text" class="form-control" name="judulDeltafood" placeholder="Judul" value="<?= set_value('judulDeltafood') ? set_value('judulDeltafood') : $deltafoods['judulDeltafood']; ?>">
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="judulDeltafoodWarna" placeholder="Judul Warna" value="<?= set_value('judulDeltafoodWarna') ? set_value('judulDeltafoodWarna') : $deltafoods['judulDeltafoodWarna']; ?>">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="textDeltafood" class="col-sm-2 col-form-label">Text</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control summernote" id="textDeltafood" rows="3" name="textDeltafood"><?= set_value('textDeltafood') ? set_value('textDeltafood') : $deltafoods['textDeltafood'] ?>
                                            </textarea>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="mb-3 row">
                                        <label for="" class="col-sm-2 col-form-label">Gambar Modul</label>
                                        <div class="col-sm-10">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="customFile" name="gambarModulDeltafood">
                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="linkVideoModulDeltafood" class="col-sm-2 col-form-label">Link Video Modul</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="linkVideoModulDeltafood" name="linkVideoModulDeltafood" value="<?= set_value('linkVideoModulDeltafood') ? set_value('linkVideoModulDeltafood') : $deltafoods['linkVideoModulDeltafood']; ?>">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-2 col-form-label">Judul Modul</label>
                                        <div class="col-sm-6 mb-2">
                                            <input type="text" class="form-control" name="judulModulDeltafood" placeholder="Judul" value="<?= set_value('judulModulDeltafood') ? set_value('judulModulDeltafood') : $deltafoods['judulModulDeltafood']; ?>">
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="judulModulDeltafoodWarna" placeholder="Judul Warna" value="<?= set_value('judulModulDeltafoodWarna') ? set_value('judulModulDeltafoodWarna') : $deltafoods['judulModulDeltafoodWarna']; ?>">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="textModulDeltafood" class="col-sm-2 col-form-label">Text Modul</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control summernote" id="textModulDeltafood" rows="3" name="textModulDeltafood"><?= set_value('textModulDeltafood') ? set_value('textModulDeltafood') : $deltafoods['textModulDeltafood'] ?>
                                            </textarea>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="mb-3 row">
                                        <label for="textFooterDeltafood" class="col-sm-2 col-form-label">Text Footer</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control summernote" id="textFooterDeltafood" rows="3" name="textFooterDeltafood"><?= set_value('textFooterDeltafood') ? set_value('textFooterDeltafood') : $deltafoods['textFooterDeltafood'] ?>
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

    <?php endif ?>
</div>
<!-- /.content-wrapper -->

<?= $this->endSection('content'); ?>