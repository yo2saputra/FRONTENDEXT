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

                        <div class="card card-outline card-info">
                            <div class="card-body">
                                <form action="#" id="quickForm" method="post" enctype="multipart/form-data">
                                    <?= csrf_field(); ?>

                                    <input type="hidden" name="id" value="<?= $deltafoods['id'] ?>">
                                    <input type="hidden" name="gambarDeltafoodLama" value="<?= $deltafoods['gambarDeltafood'] ?>">
                                    <input type="hidden" name="gambarModulDeltafoodLama" value="<?= $deltafoods['gambarModulDeltafood'] ?>">

                                    <!-- <div class="mb-3 row">
                                        <label for="" class="col-sm-2 col-form-label"></label>
                                        <div class="col-sm-10">
                                            <div class="mb-3 row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-sm-4">Gambar</label>
                                                        <div class="col-sm-8 text-center">
                                                            <img src="<?= base_url('/assets/img/') . $deltafoods['gambarDeltafood'] ?>" alt="" style="height:100px;" class="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-sm-4">Gambar Modul</label>
                                                        <div class="col-sm-8 text-center">
                                                            <img src="<?= base_url('/assets/img/') . $deltafoods['gambarModulDeltafood'] ?>" alt="" style="height:100px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->

                                    <div class="mb-3 row">
                                        <label class="col-sm-2">Gambar</label>
                                        <div class="col-sm-10">
                                            <img src="<?= base_url('/assets/img/') . $deltafoods['gambarDeltafood'] ?>" alt="" style="height:100px;" class="">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-2 col-form-label">Judul</label>
                                        <div class="col-sm-6 mb-2">
                                            <input type="text" class="form-control" name="judulDeltafood" placeholder="Judul" value="<?= set_value('judulDeltafood') ? set_value('judulDeltafood') : $deltafoods['judulDeltafood']; ?>" disabled>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="judulDeltafoodWarna" placeholder="Judul Warna" value="<?= set_value('judulDeltafoodWarna') ? set_value('judulDeltafoodWarna') : $deltafoods['judulDeltafoodWarna']; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="textDeltafood" class="col-sm-2 col-form-label">Text</label>
                                        <div class="col-sm-10">
                                            <textarea id="summernote1" class="form-control summernote" id="textDeltafood" rows="3" name="textDeltafood" disabled><?= set_value('textDeltafood') ? set_value('textDeltafood') : $deltafoods['textDeltafood'] ?>
                                            </textarea>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="mb-3 row">
                                        <label class="col-sm-2">Gambar Modul</label>
                                        <div class="col-sm-10">
                                            <img src="<?= base_url('/assets/img/') . $deltafoods['gambarModulDeltafood'] ?>" alt="" style="height:100px;">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="linkVideoModulDeltafood" class="col-sm-2 col-form-label">Link Video Modul</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="linkVideoModulDeltafood" name="linkVideoModulDeltafood" value="<?= set_value('linkVideoModulDeltafood') ? set_value('linkVideoModulDeltafood') : $deltafoods['linkVideoModulDeltafood']; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-2 col-form-label">Judul Modul</label>
                                        <div class="col-sm-6 mb-2">
                                            <input type="text" class="form-control" name="judulModulDeltafood" placeholder="Judul" value="<?= set_value('judulModulDeltafood') ? set_value('judulModulDeltafood') : $deltafoods['judulModulDeltafood']; ?>" disabled>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="judulModulDeltafoodWarna" placeholder="Judul Warna" value="<?= set_value('judulModulDeltafoodWarna') ? set_value('judulModulDeltafoodWarna') : $deltafoods['judulModulDeltafoodWarna']; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="textModulDeltafood" class="col-sm-2 col-form-label">Text Modul</label>
                                        <div class="col-sm-10">
                                            <textarea id="summernote2" class="form-control summernote" id="textModulDeltafood" rows="3" name="textModulDeltafood" disabled><?= set_value('textModulDeltafood') ? set_value('textModulDeltafood') : $deltafoods['textModulDeltafood'] ?>
                                            </textarea>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="mb-3 row">
                                        <label for="textFooterDeltafood" class="col-sm-2 col-form-label">Text Footer</label>
                                        <div class="col-sm-10">
                                            <textarea id="summernote3" class="form-control summernote" id="textFooterDeltafood" rows="3" name="textFooterDeltafood" disabled><?= set_value('textFooterDeltafood') ? set_value('textFooterDeltafood') : $deltafoods['textFooterDeltafood'] ?>
                                        </textarea>
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <a href="<?= base_url('/admin/deltafood/edit/') . $deltafoods['id'] ?>" class="btn btn-primary">Edit</a>
                            </div>
                        </div>
                        <!--/.col (left) -->
                        <!-- right column -->
                        <div class="col-md-6">

                        </div>
                        <!--/.col (right) -->
                    </div>
                    <!-- /.card -->

                </div>
            </div>
            <!-- /.row -->
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->

    <?php endif ?>

</div>
<!-- /.content-wrapper -->

<?= $this->endSection('content'); ?>