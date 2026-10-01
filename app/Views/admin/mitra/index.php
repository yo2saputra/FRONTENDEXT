<?= $this->extend('admin/admin_template'); ?>

<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Mitra</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Mitra</li>
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
                    <a href="<?= base_url('/admin/mitra/create') ?>" class="btn btn-success mb-3">+ Add</a>

                    <?php if (session()->getFlashdata('pesan')) : ?>
                        <div class="alert alert-success alert-close" role="alert">
                            <?= session()->getFlashdata('pesan') ?>
                        </div>
                    <?php endif ?>
                    <!-- jquery validation -->
                    <div class="card card-outline card-info">
                        <div class="card-body">
                            <!-- /.card-header -->
                            <table id="example2" class="table table-stripe">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Logo</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $n = 1;
                                    foreach ($mitras as $mitra) : ?>

                                        <tr>
                                            <th scope="row"><?= $n++; ?></td>
                                            <td><img src="<?= base_url('/assets/img/mitra/') . $mitra['logoMitra'] ?>" alt="" style="height:100px;background-color: #e9e9e9;"></th>
                                            <td><?= $mitra['namaMitra'] ?></td>
                                            <td><a href="<?= base_url('/admin/mitra/detail/') . $mitra['id'] ?>" class="btn btn-primary">Detail</a>
                                                <form action="/admin/mitra/<?= $mitra['id']; ?>" method="post" class="d-inline"><?= csrf_field(); ?><input type="hidden" name="_method" value="DELETE"><button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin?')">Delete</button></form>
                                            </td>
                                        </tr>

                                    <?php endforeach ?>
                                </tbody>
                            </table>
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