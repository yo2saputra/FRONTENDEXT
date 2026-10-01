<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title; ?></title>

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

  <?= $this->renderSection('style'); ?>
</head>
<?php $session = session() ?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Preloader -->
    <!-- <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="<?= base_url('dist/img/logo.png'); ?>" alt="AdminLTELogo" height="60" width="60">
    </div> -->

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="<?= base_url(); ?>" class="nav-link">Beranda</a>
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
            <i class="far fa-user"></i>
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
            <span class="text-muted text-xs">
              <a href="/admin/user/reset" class="dropdown-item">
                Reset Password</a>
              <a href="/auth/logout" class="dropdown-item float-right">
                <i class="fas fas fa-power-off mr-2"></i>
                Logout</a>
            </span>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-light-primary elevation-4" style="background-color:#e8e7e3;">
      <!-- Brand Logo -->
      <a href="<?= base_url(); ?>" class="brand-link text-center">
        <!-- <img src="<?= base_url('dist/img/logo.png'); ?>" alt="Delta Food Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
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
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <!-- <li class="nav-item">
              <a href="pages/widgets.html" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li> -->

            <li class="nav-header">MASTER PAGE</li>
            <li class="nav-item">
              <a href="<?= base_url('/clinic/dokter2'); ?>" class="nav-link">
                <i class="nav-icon fas fa-user-md"></i>
                <p>
                  Dokter
                </p>
              </a>
            </li>


            <?php if ($session->get('role') == 1) : ?>
              <li class="nav-header">MASTER PAGE</li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-home"></i>
                  <p>
                    Beranda
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= base_url('/admin/beranda'); ?>" class="nav-link">
                      <i class="fas fa-home nav-icon"></i>
                      <p>Beranda</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= base_url('/admin/carousel'); ?>" class="nav-link">
                      <i class="fas fa-arrows-alt-h nav-icon"></i>
                      <p>Carousel</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('admin/resep'); ?>" class="nav-link">
                  <i class="nav-icon fas fa-flask"></i>
                  <p>
                    Resep
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('admin/blog'); ?>" class="nav-link">
                  <i class="nav-icon fas fas fa-blog"></i>
                  <p>
                    Blog
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-box"></i>
                  <p>
                    Produk
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= base_url('/admin/produk'); ?>" class="nav-link">
                      <i class="fas fa-box nav-icon"></i>
                      <p>Produk</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= base_url('/admin/produk/filter'); ?>" class="nav-link">
                      <i class="fas fa-box nav-icon"></i>
                      <p>Produk Filter</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= base_url('/admin/produk/filter_modul'); ?>" class="nav-link">
                      <i class="fas fa-box nav-icon"></i>
                      <p>Produk Filter Modul </p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-seedling"></i>
                  <p>
                    Budidaya
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= base_url('/admin/budidaya'); ?>" class="nav-link">
                      <i class="fas fa-seedling nav-icon"></i>
                      <p>Budidaya</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= base_url('/admin/gallerybudidaya'); ?>" class="nav-link">
                      <i class="fas fa-image nav-icon"></i>
                      <p>Gallery Budidaya</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-business-time"></i>
                  <p>
                    Operasional
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= base_url('/admin/operasional'); ?>" class="nav-link">
                      <i class="fas fa-business-time nav-icon"></i>
                      <p>Operasional</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= base_url('/admin/galleryoperasional'); ?>" class="nav-link">
                      <i class="fas fa-image nav-icon"></i>
                      <p>Gallery Operasional</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-truck"></i>
                  <p>
                    Distribusi
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= base_url('/admin/pagedistribusi'); ?>" class="nav-link">
                      <i class="fas fa-desktop nav-icon"></i>
                      <p>Page Distribusi</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= base_url('/admin/distribusi'); ?>" class="nav-link">
                      <i class="fas fa-truck nav-icon"></i>
                      <p>Distribusi</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('/admin/deltafood'); ?>" class="nav-link">
                  <i class="nav-icon fas fa-building"></i>
                  <p>
                    Delta Food
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('admin/kontak'); ?>" class="nav-link">
                  <i class="nav-icon fas fa-address-book"></i>
                  <p>
                    Kontak
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('admin/mitra'); ?>" class="nav-link">
                  <i class="nav-icon fas fa-users"></i>
                  <p>
                    Mitra
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('admin/deal'); ?>" class="nav-link">
                  <i class="nav-icon fas fas fa-tags"></i>
                  <p>
                    Deal
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('admin/iklan'); ?>" class="nav-link">
                  <i class="nav-icon fas fa-shopping-bag"></i>
                  <p>
                    Iklan
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('admin/testimoni'); ?>" class="nav-link">
                  <i class="nav-icon fas fa-quote-right"></i>
                  <p>
                    Testimoni
                  </p>
                </a>
              </li>

            <?php endif; ?>

            <?php if ($session->get('role') == 2) : ?>
              <li class="nav-header">MASTER PAGE</li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-home"></i>
                  <p>
                    Beranda
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= base_url('/admin/beranda'); ?>" class="nav-link">
                      <i class="fas fa-home nav-icon"></i>
                      <p>Beranda</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= base_url('/admin/carousel'); ?>" class="nav-link">
                      <i class="fas fa-arrows-alt-h nav-icon"></i>
                      <p>Carousel</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('admin/resep'); ?>" class="nav-link">
                  <i class="nav-icon fas fa-flask"></i>
                  <p>
                    Resep
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('admin/blog'); ?>" class="nav-link">
                  <i class="nav-icon fas fas fa-blog"></i>
                  <p>
                    Blog
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-box-open"></i>
                  <p>
                    Produk
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= base_url('/admin/produk/filter'); ?>" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Produk Filter</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= base_url('/admin/produk/filter_modul'); ?>" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Produk Filter Modul </p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-seedling"></i>
                  <p>
                    Budidaya
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= base_url('/admin/budidaya'); ?>" class="nav-link">
                      <i class="fas fa-seedling nav-icon"></i>
                      <p>Budidaya</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= base_url('/admin/gallerybudidaya'); ?>" class="nav-link">
                      <i class="fas fa-image nav-icon"></i>
                      <p>Gallery Budidaya</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-business-time"></i>
                  <p>
                    Operasional
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= base_url('/admin/operasional'); ?>" class="nav-link">
                      <i class="fas fa-business-time nav-icon"></i>
                      <p>Operasional</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= base_url('/admin/galleryoperasional'); ?>" class="nav-link">
                      <i class="fas fa-image nav-icon"></i>
                      <p>Gallery Operasional</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-truck"></i>
                  <p>
                    Distribusi
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= base_url('/admin/pagedistribusi'); ?>" class="nav-link">
                      <i class="fas fa-desktop nav-icon"></i>
                      <p>Page Distribusi</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= base_url('/admin/distribusi'); ?>" class="nav-link">
                      <i class="fas fa-truck nav-icon"></i>
                      <p>Distribusi</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('/admin/deltafood'); ?>" class="nav-link">
                  <i class="nav-icon fas fa-building"></i>
                  <p>
                    Delta Food
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('admin/kontak'); ?>" class="nav-link">
                  <i class="nav-icon fas fa-address-book"></i>
                  <p>
                    Kontak
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('admin/mitra'); ?>" class="nav-link">
                  <i class="nav-icon fas fa-users"></i>
                  <p>
                    Mitra
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('admin/deal'); ?>" class="nav-link">
                  <i class="nav-icon fas fas fa-tags"></i>
                  <p>
                    Deal
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('admin/iklan'); ?>" class="nav-link">
                  <i class="nav-icon fas fa-shopping-bag"></i>
                  <p>
                    Iklan
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('admin/testimoni'); ?>" class="nav-link">
                  <i class="nav-icon fas fa-quote-right"></i>
                  <p>
                    Testimoni
                  </p>
                </a>
              </li>
            <?php endif; ?>

            <?php if ($session->get('role') == 1) : ?>
              <li class="nav-header">WEBSITE</li>
              <li class="nav-item">
                <a href="<?= base_url('admin/user'); ?>" class="nav-link">
                  <i class="nav-icon fas fa-user" style='color: brown'></i>
                  <p>
                    User
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('admin/template'); ?>" class="nav-link">
                  <i class="nav-icon fas fa-cogs" style='color: brown'></i>
                  <p>
                    Template Setting
                  </p>
                </a>
              </li>

            <?php endif; ?>

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
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
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
  <script src="<?= base_url('dist/js/pages/dashboard.js') ?>"></script>
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
      CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
        mode: "htmlmixed",
        theme: "monokai"
      });
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
      $("#example2").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example1').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>
  <script>
    $(document).ready(function(even) {
      $('#example2 tbody').on('click', '.filter', function() {
        var checkvalue = [];
        $.each($('#example2').DataTable().$("input[name='produk']:checked"), function() {
          checkvalue.push($(this).val());
        });
        $("#filter").val(checkvalue.join(","));
        if ($("#filter").val() == " ") {
          $("#filter").val(" ")
        }
      });
    });
  </script>

  <?= $this->renderSection('script'); ?>


</body>

</html>