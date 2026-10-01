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
                    <div class="card mb-3">
                        <div class="card-body">
                            <!-- form start -->
                            <form action="#" id="quickForm" method="post">
                                <input type="hidden" name="id" value="<?= $berandas['id'] ?>">

                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label">Judul Produk</label>
                                    <div class="col-sm-4 mb-2">
                                        <input type="text" class="form-control" name="judulProdukWarna" placeholder="Judul Warna" value="<?= $berandas['judulProdukWarna']; ?>" disabled>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="judulProduk" placeholder="Judul" value="<?= $berandas['judulProduk']; ?>" disabled>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="textProduk" class="col-sm-2 col-form-label">Text Produk</label>
                                    <div class="col-sm-10">
                                        <textarea id="summernote2" class="form-control summernote" id="textProduk" rows="3" name="textProduk"><?= $berandas['textProduk']; ?>
                                    </textarea>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label">Judul Blog</label>
                                    <div class="col-sm-4 mb-2">
                                        <input type="text" class="form-control" name="judulBlogWarna" placeholder="Judul Warna" value="<?= $berandas['judulBlogWarna']; ?>" disabled>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="judulBlog" placeholder="Judul" value="<?= $berandas['judulBlog']; ?>" disabled>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="textBlog" class="col-sm-2 col-form-label">Text Blog</label>
                                    <div class="col-sm-10">
                                        <textarea id="summernote3" class="form-control summernote" id="textBlog" rows="3" name="textBlog"><?= $berandas['textBlog']; ?>
                                    </textarea>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="card-footer"><a href="<?= base_url('/admin/beranda/edit/') . $berandas['id'] ?>" class="btn btn-primary">Edit</a></div>
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