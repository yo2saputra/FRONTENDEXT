<?= $this->extend('admin/admin_template'); ?>

<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Blog</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Blog</li>
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
                        <form action="/admin/blog/update/<?= $blogs['id'] ?>" id="quickForm" method="post" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <div class="card-body">
                                <input type="hidden" name="slugBlog" value="<?= $blogs['slugBlog'] ?>">
                                <input type="hidden" name="gambarBlogLama" value="<?= $blogs['gambarBlog'] ?>">
                                <div class="mb-3 row">
                                    <label for="judulBlog" class="col-sm-2 col-form-label">Judul</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="judulBlog" name="judulBlog" value="<?= set_value('judulBlog') ? set_value('judulBlog') : $blogs['judulBlog'] ?>">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="isiBlog" class="col-sm-2 col-form-label">Isi</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control summernote" id="isiBlog" rows="3" name="isiBlog"><?= set_value('isiBlog') ? set_value('isiBlog') : $blogs['isiBlog'] ?>
                                    </textarea>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="" class="col-sm-2 col-form-label">Gambar</label>
                                    <div class="col-sm-10">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="customFile" name="gambarBlog">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="statusBlog" class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="statusBlog" id="statusBlog">
                                            <option value="Draft" <?= ($blogs['statusBlog'] == 'Draft' ? 'selected' : '') ?>>Draft</option>
                                            <option value="Publish" <?= ($blogs['statusBlog'] == 'Publish' ? 'selected' : '') ?>>Publish</option>
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

            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?= $this->endSection('content'); ?>