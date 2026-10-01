<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!--=============== REMIXICONS ===============-->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet" />

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="<?= base_url('assets/login/login.css') ?>" />

    <title>Login</title>
</head>

<body>
    <div class="container">
        <div class="login">
            <div class="login__content">
                <img class="login__img" src="<?= base_url('assets/login/medical-10.jpg'); ?>" alt="Login image" />
                <?php $validation = \Config\Services::validation(); ?>
                <form class="login__form" action="/auth/valid_login" method="post">
                    <?= csrf_field() ?>
                    <div>
                        <h1 class="login__title">
                            <span>Welcome</span> Back
                        </h1>

                        <p class="login__description">
                            Welcome! Please login to continue.
                        </p>
                        <?php if (session()->getFlashdata('msg_success')) : ?>
                            <br>
                            <div class="alert alert-success" style="color:green;">
                                <?= session()->getFlashdata('msg_success') ?>
                            </div>
                        <?php endif; ?>
                        <?php if (session()->getFlashdata('msg')) : ?>
                            <br>
                            <div class="alert alert-warning" style="color: red;">
                                <?= session()->getFlashdata('msg') ?>
                            </div>
                        <?php endif; ?>

                    </div>

                    <div>
                        <div class="login__inputs">
                            <div>
                                <label for="username" class="login__label">Username</label>
                                <input class="login__input" type="username" id="username" value="<?= set_value('username'); ?>" name="username" placeholder="Enter your username" required />
                                <span class="error invalid-feedback">
                                    <?= $error = $validation->getError('username'); ?>
                                </span>
                            </div>

                            <div>
                                <label for="password" class="login__label">Password</label>
                                <div class="login__box">
                                    <input class="login__input" type="password" id="password" name="password" placeholder="Enter your password" required />
                                    <i class="ri-eye-off-line login__eye" id="input-icon"></i>
                                    <span class="error invalid-feedback">
                                        <?= $error = $validation->getError('username'); ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="login__check">
                            <label class="login__check-label" for="check">
                                <input class="login__check-input" type="checkbox" id="check" />
                                <i class="ri-check-line login__check-icon"></i>
                                Remember me
                            </label>
                        </div>
                    </div>

                    <div>
                        <div class="login__buttons">
                            <button class="login__button">Log In</button>
                            <button class="login__button login__button-ghost">Change</button>
                        </div>

                        <a class="login__forgot" href="#">Forgot Password?</a>
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
                $('#check').attr('checked', 'checked');
                $('#username').val(localStorage.usrname);
                $('#password').val(localStorage.pass);
            } else {
                $('#check').removeAttr('checked');
                $('#username').val('');
                $('#password').val('');
            }

            $('#check').change(function() {

                if (this.checked) {
                    localStorage.usrname = $('#username').val();
                    localStorage.pass = $('#password').val();
                    localStorage.rememberme = $('#check').val();
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