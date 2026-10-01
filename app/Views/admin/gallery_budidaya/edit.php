<?= $this->extend('admin/admin_template'); ?>

<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Gallery Budidaya</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Gallery Budidaya</li>
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
                        <form action="/admin/gallerybudidaya/update/<?= $gallerybudidayas['id'] ?>" id="quickForm" method="post" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <div class="card-body">
                                <input type="hidden" name="id" value="<?= $gallerybudidayas['id'] ?>">
                                <input type="hidden" name="gambarGalleryBudidayaLama" value="<?= $gallerybudidayas['gambarGalleryBudidaya'] ?>">
                                <div class="mb-3 row">
                                    <label for="textGalleryBudidaya" class="col-sm-2 col-form-label">Isi</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control summernote" id="textGalleryBudidaya" rows="3" name="textGalleryBudidaya"><?= set_value('textGalleryBudidaya') ? set_value('textGalleryBudidaya') : $gallerybudidayas['textGalleryBudidaya'] ?>
                                    </textarea>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="" class="col-sm-2 col-form-label">Gambar</label>
                                    <div class="col-sm-10">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="customFile" name="gambarGalleryBudidaya">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="budidayaId" class="col-sm-2 col-form-label">Kategori Budidaya</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="budidayaId" id="budidayaId">
                                            <?php foreach ($budidayas as $budidaya) : ?>
                                                <option value="<?= $budidaya['id']; ?>" <?= ($gallerybudidayas['budidayaId'] == $budidaya['id'] ? 'selected' : '') ?>><?= $budidaya['judulBudidayaWarna']; ?> <?= $budidaya['judulBudidaya']; ?></option>
                                            <?php endforeach ?>

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