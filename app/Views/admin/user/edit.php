<?= $this->extend('admin/admin_template'); ?>

<?= $this->section('content'); ?>

<?php $session = session() ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Testimoni</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Testimoni</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <?php if ($session->get('role') == 1) : ?>

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
                            <form action="/admin/user/update/<?= $users['id'] ?>" id="quickForm" method="post" enctype="multipart/form-data">
                                <?= csrf_field(); ?>
                                <div class="card-body">
                                    <input type="hidden" name="id" value="<?= $users['id'] ?>">
                                    <div class="mb-3 row">
                                        <label for="username" class="col-sm-2 col-form-label">User Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="username" name="username" value="<?= $users['username'] ?>">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="email" name="email" value="<?= set_value('email') ? set_value('email') : $users['email'] ?>">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="role" class="col-sm-2 col-form-label">Role</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="role" id="role">
                                                <option value="1" <?= ($users['role'] == '1' ? 'selected' : '') ?>>Admin</option>
                                                <option value="2" <?= ($users['role'] == '2' ? 'selected' : '') ?>>User</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="aktif" class="col-sm-2 col-form-label">Aktif</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="aktif" id="aktif">
                                                <option <?= ($users['aktif'] == 'no' ? 'selected' : '') ?>>No</option>
                                                <option <?= ($users['aktif'] == 'yes' ? 'selected' : '') ?>>Yes</option>
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
    <?php endif ?>
</div>
<!-- /.content-wrapper -->

<?= $this->endSection('content'); ?>