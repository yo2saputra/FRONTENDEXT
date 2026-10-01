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

<?php
$session = session();
?>

<body class="hold-transition register-page">
    <div class="register-box">
        <div class="register-logo">
            <!-- <a href="../../index2.html"><b>Admin</b>LTE</a> -->
        </div>

        <div class="card">
            <div class="card-body register-card-body">
                <p class="login-box-msg">Change Password</p>
                <?php $validation = \Config\Services::validation(); ?>
                <form action="/auth/valid_changepassword" method="post">
                    <?= csrf_field() ?>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="User Name" name="username" value="<?= $session->get('usr_id'); ?>" disabled>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        <span class="error invalid-feedback">
                            <?= $error = $validation->getError('username'); ?>
                        </span>
                    </div>
                    <hr>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control <?= ($validation->getError('newpassword')) ? 'is-invalid' : '' ?>" placeholder="New Password" name="newpassword">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <span class="error invalid-feedback">
                            <?= $error = $validation->getError('newpassword'); ?>
                        </span>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control <?= ($validation->getError('confirmnewpassword')) ? 'is-invalid' : '' ?>" placeholder="Retype New Password" name="confirmnewpassword">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <span class="error invalid-feedback">
                            <?= $error = $validation->getError('confirmnewpassword'); ?>
                        </span>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <!-- <div class="icheck-primary">
                                <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                                <label for="agreeTerms">
                                    I agree to the <a href="#">terms</a>
                                </label>
                            </div> -->
                            <a href="/auth/login" class="text-center"><i class="fas fas fa-key"></i> Login</a>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Change</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>


            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->

    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
</body>

</html>