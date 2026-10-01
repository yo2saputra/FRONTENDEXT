<?= $this->extend('admin/admin_template'); ?>

<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Deal</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Deal</li>
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
                                <input type="hidden" name="id" value="<?= $deals['id'] ?>">
                                <div class="mb-3 row">
                                    <label for="judulDeal" class="col-sm-2 col-form-label">Judul</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="judulDeal" name="judulDeal" value="<?= $deals['judulDeal']; ?>" disabled>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="judulDealWarna" class="col-sm-2 col-form-label">Judul Warna</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="judulDealWarna" name="judulDealWarna" value="<?= $deals['judulDealWarna']; ?>" disabled>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="discDeal" class="col-sm-2 col-form-label">Disc</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="discDeal" name="discDeal" value="<?= $deals['discDeal']; ?>" disabled>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="discDealDetail" class="col-sm-2 col-form-label">Disc Detail</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="discDealDetail" name="discDealDetail" value="<?= $deals['discDealDetail']; ?>" disabled>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="kode_item" class="col-sm-2 col-form-label">Item</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="kode_item" name="kode_item" value="<?= $deals['kode_item']; ?>" disabled>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="textDeal" class="col-sm-2 col-form-label">Text Deal</label>
                                    <div class="col-sm-10">
                                        <textarea id="summernote1" class="form-control summernote" id="textDeal" rows="3" name="textDeal"><?= $deals['textDeal']; ?>
                                    </textarea>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="statusDeal" class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="statusDeal" id="statusDeal">
                                            <option value="Draft" <?= ($deals['statusDeal'] == 'Draft' ? 'selected' : '') ?>>Draft</option>
                                            <option value="Publish" <?= ($deals['statusDeal'] == 'Publish' ? 'selected' : '') ?>>Publish</option>
                                        </select>
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