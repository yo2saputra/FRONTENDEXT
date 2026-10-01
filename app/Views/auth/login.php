<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?= base_url('assets/login/bootstrap.min.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/login/style.css') ?>" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet" />
    <!-- <link rel="stylesheet" href="<?= base_url('assets/login/login.css') ?>" /> -->
    <style>
        .login__eye {
            width: max-content;
            height: max-content;
            position: absolute;
            right: 0.75rem;
            top: 0;
            bottom: 0;
            margin: auto 0;
            font-size: 1.25rem;
            cursor: pointer;
        }
    </style>
    <title>Login</title>
</head>

<body>

    <!----------------------- Main Container -------------------------->

    <div class="container d-flex justify-content-center align-items-center min-vh-100">

        <!----------------------- Login Container -------------------------->

        <div class="row border rounded-4 p-3 bg-white shadow box-area">

            <!--------------------------- Left Box ----------------------------->

            <div class="left-background col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box">
                <div class="featured-image">
                    <img src="<?= base_url('assets/login/logo_medicelle_nobg_1.png') ?>" class="img-fluid" style="width: 320px;">
                </div>
                <!--
		   <p class="text-white fs-2" style="font-family: 'Courier New', Courier, monospace; font-weight: 600;">Be Verified</p>
           <small class="text-white fw-bold fs-6 text-wrap text-center" style="width: 15rem;font-family: 'Courier New', Courier, monospace;">Didukung oleh AFKES</small>
		   --->
            </div>
            <?php $validation = \Config\Services::validation(); ?>

            <!-------------------- ------ Right Box ---------------------------->
            <div class="col-md-6 right-box">
                <div class="row align-items-center">
                    <form class="" action="/auth/valid_login" method="post">
                        <?= csrf_field() ?>
                        <div class="header-text mb-4">
                            <h2>Halo,</h2>
                            <p>Selamat datang kembali</p>
                            <?php if (session()->getFlashdata('msg_success')) : ?>

                                <div class="alert alert-success" style="color:green;">
                                    <?= session()->getFlashdata('msg_success') ?>
                                </div>
                            <?php endif; ?>
                            <?php if (session()->getFlashdata('msg')) : ?>

                                <div class="alert alert-warning" style="color: red;">
                                    <?= session()->getFlashdata('msg') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control form-control-lg bg-light fs-6" placeholder="User Name" id="username" value="<?= set_value('username'); ?>" name="username" required>
                            <span class="error invalid-feedback">
                                <?= $error = $validation->getError('username'); ?>
                            </span>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control form-control-lg bg-light fs-6" placeholder="Password" id="password" name="password" required>
                            <i class="ri-eye-off-line login__eye" id="input-icon"></i>
                            <span class="error invalid-feedback">
                                <?= $error = $validation->getError('username'); ?>
                            </span>
                        </div>
                        <div class="input-group mb-3 d-flex justify-content-between">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="formCheck">
                                <label for="formCheck" class="form-check-label text-secondary"><small>Remember Me</small></label>
                            </div>
                            <!--<div class="forgot">
                        <small><a href="#">Lupa Password?</a></small>
                    </div> -->
                        </div>
                        <div class="input-group mb-3">
                            <button class="btn btn-lg w-100 fs-6" style="background:#D57160; color:white;">Login</button>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="<?= base_url('plugins/jquery/jquery.min.js') ?>"></script>
    <!--=============== MAIN JS ===============-->
    <script src="<?= base_url('assets/login/login.js') ?>"></script>

    <script>
        $(function() {
            if (localStorage.rememberme && localStorage.rememberme != '') {
                $('#formCheck').attr('checked', 'checked');
                $('#username').val(localStorage.usrname);
                $('#password').val(localStorage.pass);
            } else {
                $('#formCheck').removeAttr('checked');
                $('#username').val('');
                $('#password').val('');
            }

            $('#formCheck').change(function() {

                if (this.checked) {
                    localStorage.usrname = $('#username').val();
                    localStorage.pass = $('#password').val();
                    localStorage.rememberme = $('#formCheck').val();
                } else {
                    localStorage.usrname = '';
                    localStorage.pass = '';
                    localStorage.rememberme = '';
                }
            });
        });
    </script>

</body>

</html>