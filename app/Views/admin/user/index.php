<?= $this->extend('admin/admin_template'); ?>

<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>User</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">User</li>
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
                    <!-- <a href="<?= base_url('/admin/user/create') ?>" class="btn btn-success mb-3">+ Tambah</a> -->

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
                                        <th scope="col">User Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Aktif</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $n = 1;
                                    foreach ($users as $user) : ?>

                                        <tr>
                                            <th scope="row"><?= $n++; ?></td>
                                            <td><?= $user['username'] ?></th>
                                            <td><?= $user['email'] ?></td>
                                            <td><span class="right badge <?= $user['role'] == '1' ? 'badge-primary' : 'badge-warning' ?>"><?= ($user['role'] == '1' ? 'Admin' : 'User') ?></span></td>
                                            <td><span class="right badge <?= $user['aktif'] == 'yes' ? 'badge-success' : 'badge-danger' ?>"><?= $user['aktif'] ?></span></td>
                                            <td>
                                                <form action="/admin/user/reset_default/<?= $user['id']; ?>" method="post" class="d-inline"><?= csrf_field(); ?><input type="hidden" name="_method" value="PUT"><button type="submit" class="btn btn-warning" onclick="return confirm('Apakah anda yakin?')">Reset</button></form>
                                                <a href="<?= base_url('/admin/user/detail/') . $user['id'] ?>" class="btn btn-primary">Detail</a>
                                                <form action="/admin/user/<?= $user['id']; ?>" method="post" class="d-inline"><?= csrf_field(); ?><input type="hidden" name="_method" value="DELETE"><button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin?')">Delete</button></form>
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