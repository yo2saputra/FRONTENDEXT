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
                    <div class="card mb-3">
                        <div class="card-body">
                            <!-- form start -->
                            <form action="#" method="post">
                                <input type="hidden" name="id" value="<?= $kontaks['id'] ?>">
                                <div class="mb-3 row">
                                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="email" name="email" value="<?= $kontaks['email']; ?>" disabled>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="textKontak" class="col-sm-2 col-form-label">Text Kontak</label>
                                    <div class="col-sm-10">
                                        <textarea id="summernote1" class="form-control summernote" id="textKontak" rows="3" name="textKontak"><?= $kontaks['textKontak']; ?>
                                    </textarea>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="map" class="col-sm-2 col-form-label">Map</label>
                                    <div class="col-sm-10">
                                        <textarea id="summernote2" class="form-control summernote" id="map" rows="3" name="map"><?= $kontaks['map']; ?>
                                    </textarea>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a href="<?= base_url('/admin/kontak/edit/') . $kontaks['id'] ?>" class="btn btn-primary">Edit</a>
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