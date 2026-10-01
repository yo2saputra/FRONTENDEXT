<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="dark-mode" content="false">
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
  <!-- <link rel="stylesheet" href="<?= base_url('plugins/summernote/summernote-bs4.min.css') ?>"> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.css" integrity="sha512-ngQ4IGzHQ3s/Hh8kMyG4FC74wzitukRMIcTOoKT3EyzFZCILOPF0twiXOQn75eDINUfKBYmzYn2AA8DkAk8veQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?= base_url('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') ?>">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?= base_url('plugins/toastr/toastr.min.css') ?>">
  <!-- Custom style -->
  <link rel="stylesheet" href="<?= base_url('dist/css/custom.css') ?>">

  <style>
    /* textarea {
      font-size: 12px !important;
    } */

    /* Reset width dasar */
    .main-sidebar {
      width: 400px !important;
      transition: transform 0.3s ease-in-out !important;
    }

    /* Brand link/logo */
    .brand-link {
      width: 400px !important;
    }

    /* Untuk state NORMAL (sidebar terbuka) */
    .content-wrapper,
    .main-footer,
    .main-header {
      transition: margin-left 0.3s ease-in-out !important;
      margin-left: 400px !important;
    }

    /* Untuk state COLLAPSED (sidebar tertutup) */
    .sidebar-collapse .main-sidebar {
      transform: translateX(-400px) !important;
      width: 400px !important;
    }

    .sidebar-collapse .content-wrapper,
    .sidebar-collapse .main-footer,
    .sidebar-collapse .main-header {
      margin-left: 0 !important;
    }

    /* Navbar brand positioning */
    .main-header .navbar-brand {
      margin-left: 400px;
    }

    .sidebar-collapse .main-header .navbar-brand {
      margin-left: 0;
    }

    /* Untuk versi mobile/tablet */
    @media (max-width: 991.98px) {

      /* Reset untuk mobile */
      .content-wrapper,
      .main-footer,
      .main-header {
        margin-left: 0 !important;
      }

      /* Sidebar hidden di mobile */
      .main-sidebar {
        transform: translateX(-400px) !important;
        width: 400px !important;
      }

      /* Ketika sidebar open di mobile */
      .sidebar-open .main-sidebar {
        transform: translateX(0) !important;
      }

      .sidebar-open .content-wrapper,
      .sidebar-open .main-footer {
        transform: translateX(400px) !important;
      }

      /* Navbar brand mobile */
      .main-header .navbar-brand {
        margin-left: 0 !important;
      }
    }

    /* Optional: Adjust menu items untuk lebar baru */
    .nav-sidebar .nav-link {
      padding: 0.75rem 1.5rem;
    }

    .nav-sidebar .nav-link p {
      white-space: normal;
      line-height: 1.4;
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

    @media (min-width: 576px) {
      .modal-xxl {
        max-width: 96vw;
        /* atau 1200px, 1400px sesuai kebutuhan */
      }
    }

    /* .modal-fullscreen {
      width: 100vw;
      max-width: 100vw;
      height: 100vh;
      margin: 0;
      padding: 0;
    }

    .modal-fullscreen .modal-content {
      height: 100vh;
      border-radius: 0;
    } */

    .modal-fullscreen {
      width: 99vw;
      max-width: 100vw;
      height: 100vh;
      margin: 0;
      padding: 0;
    }

    .modal-fullscreen .modal-content {
      height: 100vh;
      border-radius: 0;
      display: flex;
      flex-direction: column;
    }

    .modal-scroll {
      flex: 1;
      overflow-y: auto;
      padding: 1rem;
    }


    /** start loading overlay */
    .spinner {
      height: 60px;
      width: 60px;
      margin: auto;
      display: flex;
      position: absolute;
      -webkit-animation: rotation .6s infinite linear;
      -moz-animation: rotation .6s infinite linear;
      -o-animation: rotation .6s infinite linear;
      animation: rotation .6s infinite linear;
      border-left: 6px solid rgba(0, 174, 239, .15);
      border-right: 6px solid rgba(0, 174, 239, .15);
      border-bottom: 6px solid rgba(0, 174, 239, .15);
      border-top: 6px solid rgba(0, 174, 239, .8);
      border-radius: 100%;
    }

    @-webkit-keyframes rotation {
      from {
        -webkit-transform: rotate(0deg);
      }

      to {
        -webkit-transform: rotate(359deg);
      }
    }

    @-moz-keyframes rotation {
      from {
        -moz-transform: rotate(0deg);
      }

      to {
        -moz-transform: rotate(359deg);
      }
    }

    @-o-keyframes rotation {
      from {
        -o-transform: rotate(0deg);
      }

      to {
        -o-transform: rotate(359deg);
      }
    }

    @keyframes rotation {
      from {
        transform: rotate(0deg);
      }

      to {
        transform: rotate(359deg);
      }
    }

    #overlay {
      position: absolute;
      display: none;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 2;
      cursor: pointer;
    }

    /** end loading overlay */


    /* Custom loading overlay */
    /* .dataTables_processing {
      position: absolute;
      top: 50%;
      left: 50%;
      padding: 10px 20px;
      background-color: rgba(255, 255, 255, 0.95);
      border: 1px solid #ccc;
      border-radius: 5px;
      transform: translate(-50%, -50%);
      z-index: 9999;
      font-weight: bold;
      color: #333;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    } */

    /* Spinner animation */
    /* .dataTables_processing::after {
      content: '';
      display: inline-block;
      margin-left: 10px;
      width: 16px;
      height: 16px;
      border: 2px solid #999;
      border-top: 2px solid transparent;
      border-radius: 50%;
      animation: spin 0.8s linear infinite;
    } */

    @keyframes spin {
      to {
        transform: rotate(360deg);
      }
    }
  </style>



  <script>
    if (localStorage.darkmode && localStorage.darkmode != '') {
      document.documentElement.classList.add('dark-mode');
    }
  </script>

  <?= $this->renderSection('style'); ?>

</head>

<?php
//$this->load->helper('cookie');
$session = session();
$uri = service('uri');
?>

<body class="hold-transition layout-fixed layout-navbar-fixed text-xs">
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



    <?php
    // BENAR — Gunakan variabel yang sudah dikirim dari controller
    $current_reference = $current_reference ?? '';
    ?>

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-light-primary elevation-4">
      <!-- Brand Logo -->
      <a href="<?= base_url("/dashboard"); ?>" class="brand-link">
        <img src="<?= base_url('dist/img/logo.png'); ?>" alt="Delta Food Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?= $_ENV['APP_TITLE'] ?></span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">

            <!-- DASHBOARD Manual -->
            <!-- <li class="nav-item <?= ($current_reference === 'dashboard') ? 'menu-open' : ''; ?>">
              <a href="<?= base_url('dashboard'); ?>" class="nav-link <?= ($current_reference === 'dashboard') ? 'active-submenu' : ''; ?>">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p id="<?= ($current_reference === 'dashboard') ? 'active-menu' : ''; ?>">
                  DASHBOARD
                </p>
              </a>
            </li> -->

            <!-- Menu Multi-Level dari API tmst_menus (sudah termasuk header dengan garis bawah) -->
            <?= build_multi_level_sidebar($menu ?? [], null, $current_reference) ?>

          </ul>
        </nav>
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
  <!-- <script src="<?= base_url('plugins/summernote/summernote-bs4.min.js') ?>"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.js" integrity="sha512-ZESy0bnJYbtgTNGlAD+C2hIZCt4jKGF41T5jZnIXy4oP8CQqcrBGWyxNP16z70z/5Xy6TS/nUZ026WmvOcjNIQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
  <!-- Toastr -->
  <script src="<?= base_url('plugins/toastr/toastr.min.js') ?>"></script>
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
    // Function to format date into different formats
    // formatDate('10/29/2025 00:00:00')['yyyy-mm-dd'] --> '2025-10-29';
    function formatDate(rawDateStr) {
      const dateObj = new Date(rawDateStr); // contoh: '10/29/2025 00:00:00'
      const yyyy = dateObj.getFullYear();
      const mm = String(dateObj.getMonth() + 1).padStart(2, '0');
      const dd = String(dateObj.getDate()).padStart(2, '0');

      return {
        'yyyy-mm-dd': `${yyyy}-${mm}-${dd}`,
        'dd-mm-yyyy': `${dd}-${mm}-${yyyy}`,
        'dd/mm/yyyy': `${dd}/${mm}/${yyyy}`
      };
    }

    $(function() {

      if (localStorage.darkmode && localStorage.darkmode != '') {
        $('#customSwitch1').attr('checked', 'checked');
        $('#theme').removeClass("fa-sun");
        $('#theme').addClass("fa-moon");
        $('html').addClass("dark-mode");
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
        $('html').removeClass("dark-mode");
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
          localStorage.darkmode = $('#customSwitch1').val();
          $('#theme').removeClass("fa-sun");
          $('#theme').addClass("fa-moon");
          $('html').addClass("dark-mode");
          $('.sidebar-mini').addClass("dark-mode");
          $('.main-header').addClass("navbar-dark");
          $('.main-sidebar').removeClass("sidebar-light-primary");
          $('.main-sidebar').addClass("sidebar-dark-primary");
          $('a.active-submenu').css({
            "color": "yellow"
          });
        } else {
          localStorage.darkmode = '';
          $('#theme').removeClass("fa-moon");
          $('#theme').addClass("fa-sun");
          $('html').removeClass("dark-mode");
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

      $('.select2custom').select2({
        // placeholder: 'Cari kode...',
        // allowClear: true,
        templateResult: function(data) {
          // Tampilkan text lengkap saat dropdown terbuka
          return data.element ? $(data.element).data('fulltext') : data.text;
        },
        templateSelection: function(data) {
          // Tampilkan hanya kode (value) saat dipilih
          return data.id || '';
        }
      });


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

    // window.setTimeout(function() {
    //   $(".alert-close").fadeTo(500, 0).slideUp(500, function() {
    //     $(this).remove();
    //   });
    // }, 5000);


    $('#gambarBlog').on('change', function() {
      //get the file name
      var fileName = $(this).val();
      //replace the "Choose a file" label
      $(this).next('.custom-file-label').html(fileName);
    });
  </script>

  <script>
    // $(document).ready(function() {
    //   $("#show_hide_password a").on('click', function(event) {
    //     event.preventDefault();
    //     if ($('#show_hide_password input').attr("type") == "text") {
    //       $('#show_hide_password input').attr('type', 'password');
    //       $('#show_hide_password i').addClass("fa-eye-slash");
    //       $('#show_hide_password i').removeClass("fa-eye");
    //     } else if ($('#show_hide_password input').attr("type") == "password") {
    //       $('#show_hide_password input').attr('type', 'text');
    //       $('#show_hide_password i').removeClass("fa-eye-slash");
    //       $('#show_hide_password i').addClass("fa-eye");
    //     }
    //   });

    //   //Apabila session expired saat request ajax
    //   function cekSession(response) {
    //     if (response.status === 'session_expired') {
    //       window.location.href = '<?= base_url('auth/login'); ?>';
    //     }
    //   }

    // });
  </script>

  <script>
    function convertDateIndo(date) {
      var d_arr = date.split("/");
      var fromDate = d_arr[1] + '/' + d_arr[0] + '/' + d_arr[2];
      dateNew = fromDate.split(' ')[0];
      // var fromDate = date.toLocaleDateString('en-GB');
      return dateNew;
    }

    function convertDateUs(date) {
      var d_arr = date.split("/");
      var fromDate = d_arr[1] + '/' + d_arr[0] + '/' + d_arr[2];
      dateNew = fromDate.split(' ')[0];
      return dateNew;
    }

    function getDateUs() {
      var dateNew = new Date().toLocaleDateString('en-US');
      // var dateNew = date.toLocaleDateString('en-US');
      return dateNew;
    }

    function getDateIndo() {
      var dateNew = new Date().toLocaleDateString('en-GB');
      return dateNew;
    }

    function calculate() {
      //var birth_dt = new Date();
      var d_arr2 = $('#birth_dt').val().split("/");
      var fromDate = d_arr2[1] + '-' + d_arr2[0] + '-' + d_arr2[2];
      var toDate = new Date();

      try {
        // document.getElementById('usia').innerHTML = '';
        $('p#usia').val('');

        var result = getDateDifference(new Date(fromDate), new Date(toDate));

        if (result && !isNaN(result.years)) {
          document.getElementById('usia').innerHTML = '<b>' +
            result.years + '</b> Tahun, <b>' +
            result.months + '</b> Bulan, <b>' +
            result.days + '</b> Hari';

          $('#tahun').val(result.years);
          $('#bulan').val(result.months);
          $('#hari').val(result.days);
        }
      } catch (e) {
        console.error(e);
      }
    }

    function getDateDifference(startDate, endDate) {
      if (startDate > endDate) {
        console.error('Start date must be before end date');
        return null;
      }
      var startYear = startDate.getFullYear();
      var startMonth = startDate.getMonth();
      var startDay = startDate.getDate();

      var endYear = endDate.getFullYear();
      var endMonth = endDate.getMonth();
      var endDay = endDate.getDate();

      // We calculate February based on end year as it might be a leep year which might influence the number of days.
      var february = (endYear % 4 == 0 && endYear % 100 != 0) || endYear % 400 == 0 ? 29 : 28;
      var daysOfMonth = [31, february, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

      var startDateNotPassedInEndYear = (endMonth < startMonth) || endMonth == startMonth && endDay < startDay;
      var years = endYear - startYear - (startDateNotPassedInEndYear ? 1 : 0);

      var months = (12 + endMonth - startMonth - (endDay < startDay ? 1 : 0)) % 12;

      // (12 + ...) % 12 makes sure index is always between 0 and 11
      var days = startDay <= endDay ? endDay - startDay : daysOfMonth[(12 + endMonth - 1) % 12] - startDay + endDay;

      return {
        years: years,
        months: months,
        days: days
      };
    }
  </script>



  <!-- <script>
    $(document).ajaxComplete(function(event, xhr, settings) {
      try {
        const res = JSON.parse(xhr.responseText);
        if (res.session_expired) {
          alert('Sesi Anda telah berakhir. Anda akan diarahkan ke halaman login.');
          window.location.href = res.redirect_url;
        }
      } catch (e) {
        // response bukan JSON, abaikan
      }
    });
  </script> -->

  <script>
    $(function() {
      // Terapkan kondisi tersimpan saat halaman dimuat
      if (localStorage.pushmenu && localStorage.pushmenu !== '') {
        $('body').addClass('sidebar-collapse');
      }

      // Tangkap klik tombol pushmenu
      $('[data-widget="pushmenu"]').on('click', function(e) {
        e.preventDefault();

        // Panggil fungsi bawaan AdminLTE agar animasi jalan
        $(document).trigger('collapsed.lte.pushmenu'); // event collapse
        $(document).trigger('shown.lte.pushmenu'); // event expand

        // Simpan kondisi setelah AdminLTE toggle
        setTimeout(function() {
          if ($('body').hasClass('sidebar-collapse')) {
            localStorage.pushmenu = 'true';
          } else {
            localStorage.pushmenu = '';
          }
        }, 200);
      });
    });
  </script>

  <?= $this->renderSection('script'); ?>
  <!-- <div class="jqvmap-label" style="display: none;"></div> -->

</body>

<?= $this->renderSection('script'); ?>
<!-- Tambahkan script cleanup di sini -->
<script>
  // Cleanup modal backdrops dan class modal-open saat halaman dimuat
  (function cleanupModals() {
    // Hapus semua backdrop modal yang tersisa
    $('.modal-backdrop').remove();

    // Hapus class modal-open dari body
    $('body').removeClass('modal-open');

    // Reset overflow body
    $('body').css('overflow', 'auto');

    // Hapus attribute style yang mungkin tersisa
    $('body').removeAttr('style');

    // Pastikan tidak ada modal yang masih terbuka
    $('.modal.show').modal('hide');

    console.log('Modal cleanup completed');
  })();

  // Intercept AJAX session expired - TAMBAHKAN INI
  $(document).ajaxComplete(function(event, xhr, settings) {
    try {
      // Coba parse response sebagai JSON
      const res = JSON.parse(xhr.responseText);
      if (res.session_expired || res.redirect_url === '/auth/login') {
        // Bersihkan modal sebelum redirect
        $('.modal').modal('hide');
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open');
        $('body').css('overflow', 'auto');

        // Redirect ke login
        window.location.href = res.redirect_url || '<?= base_url('auth/login') ?>';
      }
    } catch (e) {
      // Response bukan JSON, cek status code 401
      if (xhr.status === 401) {
        $('.modal').modal('hide');
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open');
        window.location.href = '<?= base_url('auth/login') ?>';
      }
    }
  });
</script>

</html>