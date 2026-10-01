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
                    <a href="<?= base_url('/admin/resep/create') ?>" class="btn btn-success mb-3">+ Add</a>

                    <?php if (session()->getFlashdata('pesan')) : ?>
                        <div class="alert alert-success alert-close" role="alert">
                            <?= session()->getFlashdata('pesan') ?>
                        </div>
                    <?php endif ?>
                    <!-- jquery validation -->
                    <div class="card card-outline card-info">

                        <div class="card-body">
                            <table id="example2" class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Gambar</th>
                                        <th scope="col">Judul</th>
                                        <th scope="col">Status</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $n = 1;
                                    foreach ($reseps as $resep) : ?>

                                        <tr>
                                            <th scope="row"><?= $n++; ?></td>
                                            <td><img src="<?= base_url('/assets/img/resep/') . $resep['gambarResep'] ?>" alt="" style="height:100px;background-color: #e9e9e9;"></th>
                                            <td><?= $resep['judulResep'] ?></td>
                                            <td><span class="right badge <?= $resep['statusResep'] == 'Draft' ? 'badge-warning' : 'badge-success' ?>"><?= $resep['statusResep'] ?></span></td>
                                            <td><a href="<?= base_url('/admin/resep/detail/') . $resep['slugResep'] ?>" class="btn btn-primary">Detail</a>
                                                <form action="/admin/resep/<?= $resep['id']; ?>" method="post" class="d-inline"><?= csrf_field(); ?><input type="hidden" name="_method" value="DELETE"><button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin?')">Delete</button></form>
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