<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('plugins/fontawesome-free/css/all.min.css') ?>">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= base_url('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') ?>">
  <!-- Ionicons -->
  <!-- <link rel="stylesheet" href="<?= base_url('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css') ?>"> -->
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" src="<?= base_url('plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') ?>">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?= base_url('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') ?>">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?= base_url('plugins/select2/css/select2.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?= base_url('plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>">
  <!-- JQVMap -->
  <!-- <link rel="stylesheet" href="<?= base_url('plugins/jqvmap/jqvmap.min.css') ?>"> -->
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('dist/css/adminlte.min.css') ?>">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?= base_url('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') ?>">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?= base_url('plugins/daterangepicker/daterangepicker.css') ?>">
  <!-- summernote -->
  <link rel="stylesheet" href="<?= base_url('plugins/summernote/summernote-bs4.min.css') ?>">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?= base_url('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') ?>">
  <!-- Custom style -->
  <link rel="stylesheet" href="<?= base_url('dist/css/custom.css') ?>">

  <style>
    textarea {
      font-size: 12px !important;
    }

    body {
      font-family: Arial !important;
    }

    div#active-menu {
      /* font-size: 0.850rem; */
      font-size: 0.2rem;
    }

    .nav-icn {
      font-size: 0.95rem;
      line-height: 1.5 !important;
    }

    @media (max-width:767px) {
      div#active-menu {
        font-size: 0.2rem;
      }
    }
  </style>

  <?= $this->renderSection('style'); ?>

</head>

<?php
//$this->load->helper('cookie');
$session = session();
$uri = service('uri');
?>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed text-xs">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img src="<?= base_url('dist/img/loading.gif'); ?>" alt="AdminLTELogo" height="278" width="300">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars nav-icn"></i></a>
        </li>
        <li class="nav-item d-nonex d-sm-inline-block">
          <a href="#" class="nav-link">
            <b id="active-menu" class="text-md"></b>
          </a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <!-- <li class="nav-item">
          <a class="nav-link" data-widget="navbar-search" href="#" role="button">
            <i class="fas fa-search"></i>
          </a>
          <div class="navbar-search-block">
            <form class="form-inline">
              <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                  <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                  <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </li> -->

        <!-- Notifications Dropdown Menu -->
        <!-- <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge">15</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">15 Notifications</span>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-envelope mr-2"></i> 4 new messages
              <span class="float-right text-muted text-sm">3 mins</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-users mr-2"></i> 8 friend requests
              <span class="float-right text-muted text-sm">12 hours</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-file mr-2"></i> 3 new reports
              <span class="float-right text-muted text-sm">2 days</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
          </div>
        </li> -->

        <!-- User Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-user nav-icn"></i>
            <!-- <span class="badge badge-warning navbar-badge">15</span> -->
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header"><b>PROFILE</b></span>
            <div class="dropdown-divider"></div>
            <span class="dropdown-item text-xs">
              <span>USERID</span>
              <span class="float-right text-xs"><?= $session->get('usr_id'); ?></span>
            </span>
            <span class="dropdown-item text-xs">
              <span>EMAIL</span>
              <span class="float-right text-xs"><?= $session->get('email'); ?></span>
            </span>
            <span class="dropdown-item text-xs">
              <span>ROLE</span>
              <span class="float-right text-xs"><?= $session->get('role_cd'); ?></span>
            </span>
            <span class="dropdown-item text-xs">
              <span>PSWD EXPIRED</span>
              <span class="float-right text-xs"><?= date('d/m/Y', strtotime($session->get('pwd_exp_dt'))) ?></span>
            </span>
            <div class="dropdown-divider"></div>
            <div class="dropdown-item text-xs">
              <a href="/auth/changepassword">
                <i class="fas fas fa-sync-alt"></i>
                Change Password</a>
              <!-- <a href="/auth/logout" class="float-right text-xs">
                <i class="fas fas fa-power-off "></i>
                Logout</a> -->
            </div>
          </div>
        </li>
        <li class="nav-item">
          <a href="/auth/logout" class="nav-link text-xs" role="button">
            <i class="fas fas fa-power-off nav-icn"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-widget="customSwitch1" data-controlsidebar-slide="true" href="#" role="button">
            <div class="form-group">
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="customSwitch1" style="display:none">
                <label class="custom-control-label" for="customSwitch1"></label>
              </div>
            </div>
          </a>
        </li>
        <!-- Control Sidebar Icon-->
        <?= $this->renderSection('controlsidebaricon'); ?>
        <!-- /Control Sidebar Icon-->
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-light-primary elevation-4">
      <!-- Brand Logo -->
      <a href="<?= base_url(); ?>" class="brand-link">
        <img src="<?= base_url('dist/img/logo.png'); ?>" alt="Delta Food Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?= $_ENV['APP_TITLE'] ?></span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="<?= base_url('dist/img/Default-Profile.png'); ?>" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block"><?= ucwords($session->get('username')) ?></a>
          </div>
        </div> -->

        <!-- SidebarSearch Form -->
        <!-- <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div> -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item <?= $uri->getSegment(1) == 'dashboard' && $uri->getSegment(1) != '' ? 'menu-open' : ''; ?>">
              <a href="<?= base_url('/dashboard'); ?>" class="nav-link <?= $uri->getSegment(1) == 'dashboard' && $uri->getSegment(1) != '' ? 'active-submenu' : ''; ?>">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p id="<?= $uri->getSegment(1) == 'dashboard' && $uri->getSegment(1) != '' ? 'active-menu' : ''; ?>">
                  DASHBOARD
                </p>
              </a>
            </li>

            <?php if (!empty($menu_header)) : ?>
              <?php foreach ($menu_header as $data_header) : ?>

                <?php
                $array = array();
                ?>
                <!-- make array filter menu-->
                <?php for ($i = 0; $i < count($menu); $i++) : ?>
                  <?php if ($data_header['header_nm'] == $menu[$i]['header_nm']) : ?>
                    <?php if (!empty($menu[$i]['reference'])) : ?>
                      <?php
                      $array[] = $menu[$i]['reference'];
                      ?>
                    <?php endif ?>
                  <?php endif ?>
                <?php endfor ?>

                <li class="nav-item <?= in_array($uri->getSegment(1), $array) ? 'menu-open' : ''; ?>">
                  <a href="#" class="nav-link">
                    <i class="nav-icon <?= $data_header['header_icon'] ?>"></i>
                    <p>
                      <?= $data_header['header_nm'] ?>
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <?php foreach ($menu as $data) : ?>
                      <?php if ($data_header['header_nm'] == $data['header_nm']) : ?>
                        <li class="nav-item" style="font-size: 0.85rem;">
                          <a href="<?= base_url('/') . $data['reference']; ?>" class="nav-link <?= $uri->getSegment(1) == $data['reference'] && $uri->getSegment(1) != '' ? 'active-submenu' : ''; ?>" style="color:<?= $uri->getSegment(1) == $data['reference'] && $uri->getSegment(1) != '' ? 'blue' : ''; ?>;">
                            <i class="nav-icon <?= $data['menu_icon'] ?>" style="font-size: 0.85rem;"></i>
                            <p id="<?= $uri->getSegment(1) == $data['reference'] && $uri->getSegment(1) != '' ? 'active-menu' : ''; ?>"><?= $data['menu_nm'] ?></p>
                          </a>
                        </li>
                      <?php endif ?>
                    <?php endforeach ?>
                  </ul>
                </li>

              <?php endforeach ?>
            <?php endif ?>



          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- content -->
    <?= $this->renderSection('content'); ?>
    <!-- /.content -->


    <footer class="main-footer">
      <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 3.2.0
      </div>
    </footer>

    <!-- Control Sidebar -->
    <?= $this->renderSection('control-sidebar'); ?>
    <!-- /.control-sidebar -->

  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="<?= base_url('plugins/jquery/jquery.min.js') ?>"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="<?= base_url('plugins/jquery-ui/jquery-ui.min.js') ?>"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="<?= base_url('plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
  <!-- Select2 -->
  <script src="<?= base_url('plugins/select2/js/select2.full.min.js') ?>"></script>
  <!-- ChartJS -->
  <script src="<?= base_url('plugins/chart.js/Chart.min.js') ?>"></script>
  <!-- Sparkline -->
  <script src="<?= base_url('plugins/sparklines/sparkline.js') ?>"></script>
  <!-- JQVMap -->
  <!-- <script src="<?= base_url('plugins/jqvmap/jquery.vmap.min.js') ?>"></script>
  <script src="<?= base_url('plugins/jqvmap/maps/jquery.vmap.usa.js') ?>"></script> -->
  <!-- jQuery Knob Chart -->
  <script src="<?= base_url('plugins/jquery-knob/jquery.knob.min.js') ?>"></script>
  <!-- daterangepicker -->
  <script src="<?= base_url('plugins/moment/moment.min.js') ?>"></script>
  <script src="<?= base_url('plugins/daterangepicker/daterangepicker.js') ?>"></script>
  <!-- bootstrap color picker -->
  <script src="<?= base_url('plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') ?>"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="<?= base_url('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') ?>"></script>
  <!-- Summernote -->
  <script src="<?= base_url('plugins/summernote/summernote-bs4.min.js') ?>"></script>
  <!-- DataTables  & Plugins -->
  <script src="<?= base_url('plugins/datatables/jquery.dataTables.min.js') ?>"></script>
  <script src="<?= base_url('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
  <script src="<?= base_url('plugins/datatables-responsive/js/dataTables.responsive.min.js') ?>"></script>
  <script src="<?= base_url('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') ?>"></script>
  <script src="<?= base_url('plugins/datatables-buttons/js/dataTables.buttons.min.js') ?>"></script>
  <script src="<?= base_url('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') ?>"></script>
  <script src="<?= base_url('plugins/jszip/jszip.min.js') ?>"></script>
  <script src="<?= base_url('plugins/pdfmake/pdfmake.min.js') ?>"></script>
  <script src="<?= base_url('plugins/pdfmake/vfs_fonts.js') ?>"></script>
  <script src="<?= base_url('plugins/datatables-buttons/js/buttons.html5.min.js') ?>"></script>
  <script src="<?= base_url('plugins/datatables-buttons/js/buttons.print.min.js') ?>"></script>
  <script src="<?= base_url('plugins/datatables-buttons/js/buttons.colVis.min.js') ?>"></script>
  <!-- overlayScrollbars -->
  <script src="<?= base_url('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') ?>"></script>
  <!-- SweetAlert2 -->
  <script src="<?= base_url('plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url('dist/js/adminlte.js') ?>"></script>
  <!-- AdminLTE for demo purposes -->
  <!-- <script src="<?= base_url('dist/js/demo.js') ?>"></script> -->
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <!-- <script src="<?= base_url('dist/js/pages/dashboard.js') ?>"></script> -->
  <!-- Jquery Cookie -->
  <!-- Jquery Cookie -->
  <script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.5/dist/js.cookie.min.js"></script>

  <script>
    $(function() {

      if (localStorage.darkmode && localStorage.darkmode != '') {
        $('#customSwitch1').attr('checked', 'checked');
        $('#theme').removeClass("fa-sun");
        $('#theme').addClass("fa-moon");
        $('.sidebar-mini').addClass("dark-mode");
        $('.main-header').addClass("navbar-dark");
        $('.main-sidebar').removeClass("sidebar-light-primary");
        $('.main-sidebar').addClass("sidebar-dark-primary");
        $('a.active-submenu').css({
          "color": "yellow"
        });
      } else {
        $('#customSwitch1').removeAttr('checked');
        $('#theme').removeClass("fa-moon");
        $('#theme').addClass("fa-sun");
        $('.sidebar-mini').removeClass("dark-mode");
        $('.main-header').removeClass("navbar-dark");
        $('.main-header').addClass("navbar-light");
        $('.main-sidebar').removeClass("sidebar-dark-primary");
        $('.main-sidebar').addClass("sidebar-light-primary");
        $('a.active-submenu').css({
          "color": "blue"
        });
      }

      $("#customSwitch1").change(function() {
        if (this.checked) {
          //Do stuff
          localStorage.darkmode = $('#customSwitch1').val();
          $('#theme').removeClass("fa-sun");
          $('#theme').addClass("fa-moon");
          $('.sidebar-mini').addClass("dark-mode");
          $('.main-header').addClass("navbar-dark");
          $('.main-sidebar').removeClass("sidebar-light-primary");
          $('.main-sidebar').addClass("sidebar-dark-primary");
          $('a.active-submenu').css({
            "color": "yellow"
          });
          //alert(Cookies.get('theme'));
        } else {
          localStorage.darkmode = '';
          $('#theme').removeClass("fa-moon");
          $('#theme').addClass("fa-sun");
          $('.sidebar-mini').removeClass("dark-mode");
          $('.main-header').removeClass("navbar-dark");
          $('.main-header').addClass("navbar-light");
          $('.main-sidebar').removeClass("sidebar-dark-primary");
          $('.main-sidebar').addClass("sidebar-light-primary");
          $('a.active-submenu').css({
            "color": "blue"
          });
        }

      });

    });
  </script>

  <!-- Page specific script -->
  <script>
    $(function() {

      //Initialize Select2 Elements
      $('.select2').select2()

      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      })
      // Summernote
      $('.summernote').summernote()

      // Summernote disable
      $('.summernote-disable').summernote('disable');
      $('#summernote1').summernote('disable');
      $('#summernote2').summernote('disable');
      $('#summernote3').summernote('disable');

      // CodeMirror
      // CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
      //   mode: "htmlmixed",
      //   theme: "monokai"
      // });
    })

    window.setTimeout(function() {
      $(".alert-close").fadeTo(500, 0).slideUp(500, function() {
        $(this).remove();
      });
    }, 5000);


    $('#gambarBlog').on('change', function() {
      //get the file name
      var fileName = $(this).val();
      //replace the "Choose a file" label
      $(this).next('.custom-file-label').html(fileName);
    });
  </script>

  <script>
    $(document).ready(function() {
      $("#show_hide_password a").on('click', function(event) {
        event.preventDefault();
        if ($('#show_hide_password input').attr("type") == "text") {
          $('#show_hide_password input').attr('type', 'password');
          $('#show_hide_password i').addClass("fa-eye-slash");
          $('#show_hide_password i').removeClass("fa-eye");
        } else if ($('#show_hide_password input').attr("type") == "password") {
          $('#show_hide_password input').attr('type', 'text');
          $('#show_hide_password i').removeClass("fa-eye-slash");
          $('#show_hide_password i').addClass("fa-eye");
        }
      });

      // setInterval(function() {
      //   cekSession();
      //   // alert('hudup');
      // }, 60000);

      // function cekSession() {
      //   $.ajax({
      //     method: "GET",
      //     url: "<?= site_url('mod/checkSession'); ?>",
      //     success: function(response) {
      //       if (response.session == 1) {
      //         window.location.reload(1);
      //       }
      //     }
      //   });
      // }

    });
  </script>

  <?= $this->renderSection('script'); ?>
  <!-- <div class="jqvmap-label" style="display: none;"></div> -->

</body>

</html>