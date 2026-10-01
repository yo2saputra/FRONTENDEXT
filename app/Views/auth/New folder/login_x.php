<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title; ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <!-- <a href="../../index2.html"><b>AFKES</b></a> -->
            <img src="<?= base_url('dist/img/logo.png'); ?>" alt="Delta Food Logo" class="brand-image img-circle elevation-3" style="opacity: 0.8;">
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>
                <?php if (session()->getFlashdata('msg_success')) : ?>
                    <div class="alert alert-success">
                        <?= session()->getFlashdata('msg_success') ?>
                    </div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('msg')) : ?>
                    <div class="alert alert-warning">
                        <?= session()->getFlashdata('msg') ?>
                    </div>
                <?php endif; ?>
                <?php $validation = \Config\Services::validation(); ?>
                <form action="/auth/valid_login" method="post">
                    <?= csrf_field() ?>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control <?= ($validation->getError('username')) ? 'is-invalid' : '' ?>" placeholder="Username" value="<?= set_value('username'); ?>" name="username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        <span class="error invalid-feedback">
                            <?= $error = $validation->getError('username'); ?>
                        </span>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control <?= ($validation->getError('password')) ? 'is-invalid' : '' ?>" placeholder="Password" value="" placeholder="Password" name="password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <span class="error invalid-feedback">
                            <?= $error = $validation->getError('password'); ?>
                        </span>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <div class="input-group" id="show_hide_password">
                            <input class="form-control" type="password">
                            <div class="input-group-addon">
                                <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <!-- <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div> -->
                            <a href="/auth/changepassword" class="text-center"><i class="fas fas fa-sync-alt"></i> Change Password</a>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <!-- <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p> -->
                <p class="mb-0">

                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- jQuery Validation-->
    <script src="../../plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="../../plugins/jquery-validation/additional-methods.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
</body>

</html>