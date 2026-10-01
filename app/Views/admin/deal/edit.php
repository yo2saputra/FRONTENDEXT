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
                        <form action="/admin/deal/update/<?= $deals['id'] ?>" id="quickForm" method="post">
                            <?= csrf_field(); ?>
                            <div class="card-body">
                                <input type="hidden" name="id" value="<?= $deals['id'] ?>">
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label">Judul</label>
                                    <div class="col-sm-4 mb-2">
                                        <input type="text" class="form-control" name="judulDealWarna" placeholder="Judul Warna" value="<?= set_value('judulDealWarna') ? set_value('judulDealWarna') : $deals['judulDealWarna']; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="judulDeal" placeholder="Judul" value="<?= set_value('judulDeal') ? set_value('judulDeal') : $deals['judulDeal']; ?>">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="discDeal" class="col-sm-2 col-form-label">Disc</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="discDeal" name="discDeal" value="<?= set_value('discDeal') ? set_value('discDeal') : $deals['discDeal']; ?>">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="discDealDetail" class="col-sm-2 col-form-label">Disc Detail</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="discDealDetail" name="discDealDetail" value="<?= set_value('discDealDetail') ? set_value('discDealDetail') : $deals['discDealDetail']; ?>">
                                    </div>
                                </div>
                                <!-- <div class="mb-3 row">
                                    <label for="kode_item" class="col-sm-2 col-form-label">Item</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="kode_item" name="kode_item" value="<?= set_value('kode_item') ? set_value('kode_item') : $deals['kode_item']; ?>">
                                    </div>
                                </div> -->
                                <div class="mb-3 row">
                                    <label for="kode_item" class="col-sm-2 col-form-label">Item</label>
                                    <div class="col-sm-10">
                                        <select id="kode_item" name="kode_item" class="form-control select2" style="width: 100%;">
                                            <?php $arr = $filter_produk[0]['filter']; ?>
                                            <?php $filter = explode(',', $arr); ?>
                                            <?php foreach ($respon_produk as $produk) : ?>
                                                <?php if (in_array($produk['kode_item'], $filter)) : ?>
                                                    <option value="<?= $produk['kode_item'] ?>" <?= $deals['kode_item'] == $produk['kode_item'] ? 'selected' : ''; ?>><?= $produk['kode_item'] . " - " . $produk['nama_item']; ?></option>
                                                <?php endif ?>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="textDeal" class="col-sm-2 col-form-label">Text Deal</label>
                                    <div class="col-sm-10">
                                        <textarea id="summernote" class="form-control summernote" id="textDeal" rows="3" name="textDeal"><?= set_value('textDeal') ? set_value('textDeal') : $deals['textDeal']; ?>
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