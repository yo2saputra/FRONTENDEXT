<?= $this->extend('admin/admin_template'); ?>

<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Iklan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Iklan</li>
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
                        <form action="/admin/iklan/update/<?= $iklans['id'] ?>" id="quickForm" method="post" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <div class="card-body">
                                <input type="hidden" name="id" value="<?= $iklans['id'] ?>">
                                <input type="hidden" name="gambarIklanLama" value="<?= $iklans['gambarIklan'] ?>">
                                <div class="mb-3 row">
                                    <label for="" class="col-sm-2 col-form-label">Gambar</label>
                                    <div class="col-sm-10">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="customFile" name="gambarIklan">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label">Judul</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="judulIklan" placeholder="Judul" value="<?= set_value('judulIklan') ? set_value('judulIklan') : $iklans['judulIklan']; ?>">
                                    </div>
                                    <div class="col-sm-4 mb-2">
                                        <input type="text" class="form-control" name="judulIklanWarna" placeholder="Judul Warna" value="<?= set_value('judulIklanWarna') ? set_value('judulIklanWarna') : $iklans['judulIklanWarna']; ?>">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="discIklan" class="col-sm-2 col-form-label">Disc</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="discIklan" name="discIklan" value="<?= set_value('discIklan') ? set_value('discIklan') : $iklans['discIklan'] ?>">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="statusIklan" class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="statusIklan" id="statusIklan">
                                            <option value="Draft" <?= ($iklans['statusIklan'] == 'Draft' ? 'selected' : '') ?>>Draft</option>
                                            <option value="Publish" <?= ($iklans['statusIklan'] == 'Publish' ? 'selected' : '') ?>>Publish</option>
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