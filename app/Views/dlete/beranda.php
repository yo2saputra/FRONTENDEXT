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
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
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
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"></h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="quickForm">
                            <div class="card-body">
                                <div class="mb-3 row">
                                    <label for="textHero" class="col-sm-2 col-form-label">Text Hero</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control summernote" id="textHero" rows="3">
                                    </textarea>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="textProduk" class="col-sm-2 col-form-label">Text Produk</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control summernote" id="textProduk" rows="3">
                                    </textarea>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="textBlog" class="col-sm-2 col-form-label">Text Blog</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control summernote" id="textBlog" rows="3">
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
</div>
<!-- /.content-wrapper -->


<?= $this->endSection('content'); ?>