<?= $this->extend('admin/admin_template'); ?>

<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Beranda</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Beranda</li>
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


                        <div class="card-body">
                            <?php $validation = \Config\Services::validation(); ?>

                            <!-- form start -->
                            <form action="/admin/beranda/update/<?= $berandas['id'] ?>" id="quickForm" method="post" enctype="multipart/form-data">
                                <?= csrf_field(); ?>
                                <div class="card-body">
                                    <input type="hidden" name="id" value="<?= $berandas['id'] ?>">

                                    <div class="mb-3 row">
                                        <label class="col-sm-2 col-form-label">Judul Produk</label>
                                        <div class="col-sm-4 mb-2">
                                            <input type="text" class="form-control" name="judulProdukWarna" placeholder="Judul Warna" value="<?= set_value('judulProdukWarna') ? set_value('judulProdukWarna') : $berandas['judulProdukWarna']; ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="judulProduk" placeholder="Judul" value="<?= set_value('judulProduk') ? set_value('judulProduk') : $berandas['judulProduk']; ?>">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="textProduk" class="col-sm-2 col-form-label">Text Produk</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control summernote" id="textProduk" rows="3" name="textProduk"><?= set_value('textProduk') ? set_value('textProduk') : $berandas['textProduk'] ?>
                                            </textarea>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-2 col-form-label">Judul Blog</label>
                                        <div class="col-sm-4 mb-2">
                                            <input type="text" class="form-control" name="judulBlogWarna" placeholder="Judul Warna" value="<?= set_value('judulBlogWarna') ? set_value('judulBlogWarna') : $berandas['judulBlogWarna']; ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="judulBlog" placeholder="Judul" value="<?= set_value('judulBlog') ? set_value('judulBlog') : $berandas['judulBlog']; ?>">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="textBlog" class="col-sm-2 col-form-label">Text Blog</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control summernote" id="textBlog" rows="3" name="textBlog"><?= set_value('textBlog') ? set_value('textBlog') : $berandas['textBlog'] ?>
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