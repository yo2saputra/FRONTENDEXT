<?= $this->extend('admin/admin_template'); ?>

<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Produk</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Produk</li>
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

                        <!-- /.card-header -->
                        <?php $validation = \Config\Services::validation(); ?>

                        <!-- form start -->
                        <form action="/admin/produk/update/<?= $produk['id'] ?>" id="quickForm" method="post" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <div class="card-body">
                                <input type="hidden" name="id" value="<?= $produk['id'] ?>">
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label">Judul</label>
                                    <div class="col-sm-6 mb-2">
                                        <input type="text" class="form-control" name="judulDetailProdukWarna" placeholder="Judul Warna" value="<?= set_value('judulDetailProdukWarna') ? set_value('judulDetailProdukWarna') : $produk['judulDetailProdukWarna']; ?>">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="judulDetailProduk" placeholder="Judul" value="<?= set_value('judulDetailProduk') ? set_value('judulDetailProduk') : $produk['judulDetailProduk']; ?>">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="textDetailProdukTerkait" class="col-sm-2 col-form-label">Text Detail Produk</label>
                                    <div class="col-sm-10">
                                        <textarea id="summernote" class="form-control summernote" id="textDetailProdukTerkait" rows="3" name="textDetailProdukTerkait"><?= set_value('textDetailProdukTerkait') ? set_value('textDetailProdukTerkait') : $produk['textDetailProdukTerkait']; ?>
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

            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?= $this->endSection('content'); ?>