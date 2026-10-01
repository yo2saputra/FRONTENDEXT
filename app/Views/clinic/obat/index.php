<?= $this->extend('clinic/clinic_template'); ?>

<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Distribusi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Obat</li>
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
                    <a href="<?= base_url('/clinic/obat/create') ?>" class="btn btn-success mb-3">
                        <i class="fa fa-plus-circle"></i> Add
                    </a>

                    <?php if (session()->getFlashdata('pesan')) : ?>
                        <div class="alert alert-success alert-close" role="alert">
                            <?= session()->getFlashdata('pesan') ?>
                        </div>
                    <?php endif ?>

                    <!-- jquery validation -->
                    <div class="card card-outline card-info">
                        <div class="card-body">

                            <table id="example2" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Filed Name</th>
                                        <th>Filed Value</th>
                                        <th>Filed Description</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($a = 0; $a < count($produk); $a++) : ?>
                                        <tr>
                                            <td><?= $produk[$a]['fld_nm']; ?></td>
                                            <td><?= $produk[$a]['fld_valu']; ?></td>
                                            <td><?= $produk[$a]['fld_desc']; ?></td>
                                            <!-- <td><a href="<?= base_url('/tfieldvalue/detail/') . $produk[$a]['fld_nm']; ?>"> Select</a></td> -->
                                            <td><a href="<?= base_url('/clinic/obat/detail/') . $produk[$a]['fld_nm'] ?>/<?= $produk[$a]['fld_valu']; ?>" class="btn btn-primary">Detail</a>
                                                <form action="/clinic/obat/<?= $produk[$a]['fld_nm']; ?>/<?= $produk[$a]['fld_valu']; ?>" method="post" class="d-inline"><?= csrf_field(); ?><input type="hidden" name="_method" value="DELETE"><button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin?')">Delete</button></form>
                                            </td>
                                        </tr>
                                    <?php endfor ?>
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