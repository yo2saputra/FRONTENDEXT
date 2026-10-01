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
                    <?php if (session()->getFlashdata('pesan')) : ?>
                        <div class="alert alert-success alert-close" role="alert">
                            <?= session()->getFlashdata('pesan') ?>
                        </div>
                    <?php endif ?>
                    <!-- jquery validation -->
                    <div class="card card-outline card-info">

                        <div class="card-body">
                            <?php $arr = $produk_filter[0]['filter']; ?>
                            <form action="/admin/produk/update/1" id="quickForm" method="post" enctype="multipart/form-data">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <input type="hidden" name="filter" value='<?= $arr ?>' id="filter">
                                <?= csrf_field(); ?>
                                <table id="example2" class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Gambar</th>
                                            <th scope="col">Kode</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Satuan</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        // $arr = '"' . implode('", "', $filterku) . '"';
                                        // $arr = explode('","', trim($filterku, '"'));

                                        // dd($arr);
                                        $filter = explode(',', $arr);
                                        $n = 1;
                                        for ($a = 0; $a < count($produk); $a++) : ?>

                                            <tr>
                                                <th scope="row"><?= $n++; ?></td>
                                                <td><img src="<?= $produk[$a]['image_path']; ?>" alt="" style="height:100px;background-color: #e9e9e9;"></th>
                                                <td><?= $produk[$a]['kode_item']; ?></td>
                                                <td><?= $produk[$a]['nama_item']; ?></td>
                                                <td><?= $produk[$a]['satuan']; ?></td>
                                                <?php if (in_array($produk[$a]['kode_item'], $filter)) : ?>
                                                    <td><input type="checkbox" name="produk" value="<?= $produk[$a]['kode_item']; ?>" class="filter" checked></td>
                                                <?php else : ?>
                                                    <td><input type="checkbox" name="produk" value="<?= $produk[$a]['kode_item']; ?>" class="filter"></td>
                                                <?php endif; ?>
                                            </tr>

                                        <?php endfor ?>

                                    </tbody>
                                </table>

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