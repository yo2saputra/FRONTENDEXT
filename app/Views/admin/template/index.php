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
                    <h1>Template</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Template</li>
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

                        <?php if (session()->getFlashdata('pesan')) : ?>
                            <div class="alert alert-success alert-close" role="alert">
                                <?= session()->getFlashdata('pesan') ?>
                            </div>
                        <?php endif ?>
                        <!-- jquery validation -->
                        <div class="card card-outline card-info">

                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Logo</th>
                                            <th scope="col">Logo Mobile</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $n = 1;
                                        foreach ($templates as $template) : ?>
                                            <tr>
                                                <th scope="row"><?= $n++; ?></td>
                                                <td><img src="<?= base_url('/assets/img/') . $template['logo'] ?>" alt="" style="height:100px;"></th>
                                                <td><img src="<?= base_url('/assets/img/') . $template['logoMobile'] ?>" alt="" style="height:100px;"></th>
                                                <td><a href="<?= base_url('/admin/template/detail/') . $template['id'] ?>" class="btn btn-primary">Detail</a></td>
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
    <?php endif ?>

</div>
<!-- /.content-wrapper -->

<?= $this->endSection('content'); ?>