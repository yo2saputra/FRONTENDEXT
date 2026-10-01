<?= $this->extend('admin/admin_template'); ?>

<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Resep</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Resep</li>
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
                        <form action="/admin/resep/save" id="quickForm" method="post" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <div class="card-body">


                                <div class="mb-3 row">
                                    <label for="judulResep" class="col-sm-2 col-form-label">Judul</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control <?= ($validation->getError('judulResep') ? 'is-invalid' : '') ?>" id="judulResep" name="judulResep" value="<?= set_value('judulResep'); ?>" autofocus>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="isiResep" class="col-sm-2 col-form-label">Isi</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control summernote <?= ($validation->getError('isiResep') ? 'is-invalid' : '') ?>" id="isiResep" rows="3" name="isiResep"><?= set_value('isiResep'); ?>
                                    </textarea>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="prosesResep" class="col-sm-2 col-form-label">Waktu Pembuatan</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control <?= ($validation->getError('prosesResep') ? 'is-invalid' : '') ?>" id="prosesResep" name="prosesResep" value="<?= set_value('prosesResep'); ?>">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="customFile" class="col-sm-2 col-form-label">Gambar</label>
                                    <div class="col-sm-10">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input <?= ($validation->getError('gambarResep') ? 'is-invalid' : '') ?>" id="customFile" name="gambarResep" />
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <?php $arr = $produk_filter[0]['filter']; ?>
                                <?php $filter = explode(',', $arr); ?>
                                <?php
                                //grouping kategori
                                foreach ($produk as $prod) : ?>
                                    <?php if (in_array($prod['kode_item'], $filter)) : ?>
                                        <?php $kategori[] = $prod['kategori']; ?>
                                    <?php endif ?>
                                <?php endforeach ?>
                                <div class="mb-3 row">
                                    <label for="kategoriResep" class="col-sm-2 col-form-label">Kategori</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="kategoriResep" id="kategoriResep">
                                            <?php
                                            $kategories = array_unique($kategori, SORT_REGULAR);
                                            foreach ($kategories as $kategori) : ?>
                                                <option value="<?= $kategori ?>"><?= strtoupper($kategori) ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="statusResep" class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="statusResep" id="statusResep">
                                            <option value="Draft">Draft</option>
                                            <option value="Publish">Publish</option>
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