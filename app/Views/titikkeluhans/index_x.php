<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>
<link rel="stylesheet" href="<?= base_url('plugins/toastr/toastr.min.css') ?>">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<link rel="stylesheet" href="<?= base_url('plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">
<style>
    .btn-fix-w {
        width: 60px;
        padding-top: 0;
        padding-bottom: 0;
    }

    .form-control-sm {
        font-size: .720rem !important;
    }

    .img-preview-modal {
        max-height: 100px;
        border-radius: 4px;
        border: 1px solid #ddd;
        padding: 3px;
        margin-top: 5px;
    }

    .img-thumbnail {
        border-radius: 4px;
        border: 1px solid #ddd;
        padding: 3px;
    }
</style>
<?= $this->endSection('style'); ?>

<?= $this->section('content'); ?>
<?php $session = session(); ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Master Titik Keluhan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Titik Keluhan</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Titik Keluhan</h3>
                        </div>
                        <div class="card-body">
                            <table id="keluhanTable" class="table table-sm table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="50">No</th>
                                        <th width="80">Gambar</th>
                                        <th>Nama Keluhan</th>
                                        <th>Slug (URL)</th>
                                        <th width="150">Akses Sub Unit</th>
                                        <th width="120">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal Form -->
<div class="modal fade" id="modalform" tabindex="-1" role="dialog" aria-labelledby="modalformLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalformLabel">Tambah Titik Keluhan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="data_form" autocomplete="off" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3 row">
                                <label class="col-sm-4 col-form-label">Nama Keluhan <span class="text-danger">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="nama" name="nama" placeholder="Masukkan nama keluhan">
                                    <span class="error invalid-feedback errorNama"></span>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-4 col-form-label">Slug</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm bg-light" id="slug" name="slug" readonly>
                                    <small class="text-muted">Akan digenerate otomatis</small>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-4 col-form-label">Gambar</label>
                                <div class="col-sm-8">
                                    <input type="file" class="form-control form-control-sm" id="gambar" name="gambar" accept="image/*">
                                    <input type="hidden" id="hidden_gambar" name="hidden_gambar">
                                    <div id="previewContainer" class="mt-2" style="display:none;">
                                        <img id="previewImg" src="#" alt="Preview" class="img-preview-modal">
                                        <br>
                                        <small class="text-muted">Klik gambar untuk memperbesar</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3 row">
                                <label class="col-sm-4 col-form-label">Akses</label>
                                <div class="col-sm-8 d-flex align-items-center">
                                    <div class="icheck-primary">
                                        <input type="checkbox" id="isAllPoly" name="isAllPoly" value="1">
                                        <label for="isAllPoly">Bisa Diakses Semua Sub Unit</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 row" id="subUnitWrapper">
                                <label class="col-sm-4 col-form-label">Pilih Sub Unit</label>
                                <div class="col-sm-8">
                                    <select name="sub_unit_ids[]" multiple="multiple" class="form-control form-control-sm" id="subUnitSelect" style="width: 100%;"></select>
                                    <small class="text-muted">Pilih jika tidak dicentang "Semua"</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="hidden_id" name="hidden_id">
                    <input type="hidden" id="action" name="action" value="Add">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" id="submit_button" class="btn btn-sm btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection('content'); ?>

<?= $this->section('script'); ?>
<script src="<?= base_url('plugins/toastr/toastr.min.js') ?>"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="<?= base_url('plugins/select2/js/select2.full.min.js') ?>"></script>

<script>
    // Active Menu Sidebar
    $('#active-menu').html($('p#active-menu').html());
    $(document).prop("title", $('p#active-menu').html());

    $(document).ready(function() {
        // ── Constants ──────────────────────────────────────────────
        const BASE_URL = '<?= base_url() ?>';
        const SITE_URL = '<?= site_url('titikkeluhan') ?>';
        const USERNAME = '<?= session()->get('username') ?? '' ?>';
        const FLAG_INSERT = '<?= session()->get('flag_insert') ?>';
        const FLAG_VIEW = '<?= session()->get('flag_view') ?>';
        const FLAG_UPDATE = '<?= session()->get('flag_update') ?>';
        const FLAG_DELETE = '<?= session()->get('flag_delete') ?>';

        // ── Init Components ────────────────────────────────────────
        initSelect2();
        initICheck();
        initDataTable();
        initFormHandlers();

        // ── Functions ──────────────────────────────────────────────

        function initSelect2() {
            $('#subUnitSelect').select2({
                placeholder: '-- Cari Sub Unit --',
                allowClear: true,
                dropdownParent: $('#modalform'),
                ajax: {
                    url: SITE_URL + '/get-subunit-select2',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.results || []
                        };
                    },
                    cache: true
                },
                minimumInputLength: 0,
                language: {
                    noResults: function() {
                        return 'Sub Unit tidak ditemukan';
                    }
                }
            });
        }

        function initICheck() {
            $('input[type="checkbox"]').iCheck({
                checkboxClass: 'icheckbox_flat-blue'
            });

            $('#isAllPoly').on('ifChecked', function() {
                $('#subUnitSelect').val(null).trigger('change');
                $('#subUnitSelect').prop('disabled', true);
                $('#subUnitWrapper').find('.text-muted').text('Akses ke semua sub unit');
            });

            $('#isAllPoly').on('ifUnchecked', function() {
                $('#subUnitSelect').prop('disabled', false);
                $('#subUnitWrapper').find('.text-muted').text('Pilih jika tidak dicentang "Semua"');
            });
        }

        function initDataTable() {
            $('#keluhanTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                dom: '<"row"<"col-md-6"B><"col-md-6"f>>rt<"row"<"col-md-6"i><"col-md-6"p>>',
                ajax: {
                    url: SITE_URL + '/datatables',
                    type: 'POST',
                    contentType: 'application/json',
                    data: function(d) {
                        return JSON.stringify(d);
                    },
                    error: function(xhr, error, thrown) {
                        console.error('DataTable Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Gagal memuat data. Silakan refresh halaman.'
                        });
                    }
                },
                columnDefs: [{
                        orderable: false,
                        targets: [0, 1, 4, 5]
                    },
                    {
                        className: 'text-center',
                        targets: [0, 1, 5]
                    },
                    {
                        className: 'align-middle',
                        targets: '_all'
                    }
                ],
                columns: [{
                        data: 'rownum'
                    },
                    {
                        data: 'gambarPreview'
                    },
                    {
                        data: 'nama'
                    },
                    {
                        data: 'slug'
                    },
                    {
                        data: 'statusAkses'
                    },
                    {
                        data: 'aksi'
                    }
                ],
                buttons: [{
                    text: '<i class="fas fa-plus"></i> Tambah',
                    className: 'btn btn-success btn-sm',
                    action: function() {
                        $('#add_record').trigger('click');
                    },
                    attr: {
                        id: 'add_record_btn',
                        style: FLAG_INSERT === '1' ? '' : 'display:none;'
                    }
                }],
                oLanguage: {
                    sSearch: 'Cari Data:',
                    sSearchPlaceholder: 'Cari nama keluhan...',
                    sInfoEmpty: 'Tidak ada data',
                    sInfo: 'Total: _TOTAL_ data',
                    sZeroRecords: 'Data tidak ditemukan',
                    sProcessing: '<i class="fa fa-spinner fa-spin"></i> Memuat data...',
                    oPaginate: {
                        sFirst: 'Awal',
                        sPrevious: 'Sebelum',
                        sNext: 'Berikut',
                        sLast: 'Akhir'
                    },
                    buttons: {
                        colvis: 'Kolom'
                    }
                }
            }).buttons().container().appendTo('#keluhanTable_wrapper .col-md-6:eq(0)');
        }

        function initFormHandlers() {
            // Auto generate slug
            $('#nama').on('keyup change', function() {
                var slug = $(this).val().toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/[\s_]+/g, '-')
                    .replace(/^-+|-+$/g, '');
                $('#slug').val(slug);
            });

            // Preview gambar
            $('#gambar').on('change', function() {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#previewImg').attr('src', e.target.result);
                        $('#previewContainer').show();
                    };
                    reader.readAsDataURL(this.files[0]);
                } else {
                    $('#previewContainer').hide();
                }
            });

            // Click preview to enlarge
            $(document).on('click', '#previewImg', function() {
                var imgSrc = $(this).attr('src');
                if (imgSrc && imgSrc !== '#') {
                    Swal.fire({
                        imageUrl: imgSrc,
                        imageAlt: 'Preview Gambar',
                        showConfirmButton: true,
                        confirmButtonText: 'Tutup',
                        width: 'auto',
                        imageWidth: '100%',
                        imageHeight: 'auto'
                    });
                }
            });

            // Form submit
            $('#data_form').on('submit', function(e) {
                e.preventDefault();
                submitForm();
            });

            // Modal hidden event - reset form
            $('#modalform').on('hidden.bs.modal', function() {
                resetForm();
            });

            // Tambah record
            $(document).on('click', '#add_record', function() {
                resetForm();
                $('.modal-title').text('Tambah Titik Keluhan');
                $('#action').val('Add');
                $('#hidden_id').val('');
                $('#submit_button').html('Simpan').show();
                $('#modalform').modal('show');
            });
        }

        // ── CRUD Operations ────────────────────────────────────────

        function resetForm() {
            $('#data_form')[0].reset();
            clearValidation();
            $('#isAllPoly').iCheck('uncheck');
            $('#subUnitSelect').val([]).trigger('change');
            $('#subUnitSelect').prop('disabled', false);
            $('#previewContainer').hide();
            $('#hidden_gambar').val('');
            $('#nama, #slug, #gambar, #subUnitSelect').prop('disabled', false);
            $('#submit_button').show();
            $('#action').val('Add');
            $('#hidden_id').val('');
        }

        function clearValidation() {
            ['nama'].forEach(function(field) {
                $('#' + field).removeClass('is-invalid');
                $('.error' + field.charAt(0).toUpperCase() + field.slice(1)).html('');
            });
        }

        function submitForm() {
            var formData = new FormData(document.getElementById('data_form'));

            // Tambahkan username untuk createdBy/updatedBy
            if (USERNAME) {
                formData.append('createdBy', USERNAME);
                formData.append('updatedBy', USERNAME);
            }

            $.ajax({
                url: SITE_URL + '/action',
                method: 'POST',
                data: formData,
                dataType: 'JSON',
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#submit_button').prop('disabled', true)
                        .html('<i class="fa fa-spin fa-spinner"></i> Menyimpan...');
                },
                complete: function() {
                    $('#submit_button').prop('disabled', false).html('Simpan');
                },
                success: function(response) {
                    handleResponse(response);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: 'Terjadi kesalahan pada server. Silakan coba lagi.'
                    });
                }
            });
        }

        function handleResponse(response) {
            if (response.error) {
                clearValidation();
                Object.keys(response.error).forEach(function(key) {
                    $('#' + key).addClass('is-invalid');
                    $('.error' + key.charAt(0).toUpperCase() + key.slice(1))
                        .html(response.error[key]);
                });
                toastr.error('Mohon periksa kembali input Anda', 'Validasi Gagal');
            } else if (response.status === 'error') {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: response.message
                });
            } else if (response.status === 'success') {
                toastr.success(response.message, 'Berhasil');
                $('#modalform').modal('hide');
                $('#keluhanTable').DataTable().ajax.reload(null, false);
            } else {
                toastr.info('Operasi berhasil', 'Informasi');
                $('#modalform').modal('hide');
                $('#keluhanTable').DataTable().ajax.reload(null, false);
            }
        }

        // ── Event Handlers ─────────────────────────────────────────

        // View
        $(document).on('click', '.view', function() {
            var id = $(this).data('id');
            fetchData(id, 'View');
        });

        // Edit
        $(document).on('click', '.edit', function() {
            var id = $(this).data('id');
            fetchData(id, 'Edit');
        });

        // Delete
        $(document).on('click', '.delete', function() {
            var id = $(this).data('id');
            var gambar = $(this).data('gambar');
            confirmDelete(id, gambar);
        });

        // ── Helper Functions ───────────────────────────────────────

        function fetchData(id, mode) {
            if (!id) {
                toastr.error('ID tidak valid', 'Error');
                return;
            }

            // Show loading
            Swal.fire({
                title: 'Memuat data...',
                allowOutsideClick: false,
                didOpen: function() {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: SITE_URL + '/fetchSingleData',
                method: 'GET',
                data: {
                    id: id
                },
                dataType: 'JSON',
                success: function(response) {
                    Swal.close();

                    if (response.status === 'error') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message
                        });
                        return;
                    }

                    if (response.data) {
                        populateForm(response.data, mode);
                    } else {
                        toastr.error('Data tidak ditemukan', 'Error');
                    }
                },
                error: function(xhr, status, error) {
                    Swal.close();
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: 'Gagal mengambil data. Silakan coba lagi.'
                    });
                }
            });
        }

        function populateForm(data, mode) {
            resetForm();

            var isView = mode === 'View';
            var isEdit = mode === 'Edit';

            // Isi data
            $('#nama').val(data.nama || '').prop('disabled', isView);
            $('#slug').val(data.slug || '').prop('disabled', true);
            $('#hidden_gambar').val(data.gambar || '');
            $('#hidden_id').val(data.id || '');

            // Preview gambar
            if (data.gambar) {
                var imgUrl = BASE_URL + data.gambar;
                $('#previewImg').attr('src', imgUrl);
                $('#previewContainer').show();
            } else {
                $('#previewContainer').hide();
            }

            $('#gambar').prop('disabled', isView);

            // Handle checkbox IsAllPoly
            if (data.isAllPoly) {
                $('#isAllPoly').iCheck('check');
                $('#subUnitSelect').prop('disabled', true);
            } else {
                $('#isAllPoly').iCheck('uncheck');
                $('#subUnitSelect').prop('disabled', isView);
            }

            // Set sub unit ids ke Select2
            if (data.subUnitIds && data.subUnitIds.length > 0) {
                $('#subUnitSelect').val(data.subUnitIds).trigger('change');
            } else {
                $('#subUnitSelect').val([]).trigger('change');
            }

            // Set modal title dan action
            var title = '';
            if (isView) {
                title = 'Lihat Titik Keluhan';
                $('#submit_button').hide();
                $('#action').val('View');
            } else if (isEdit) {
                title = 'Ubah Titik Keluhan';
                $('#submit_button').html('Update').show();
                $('#action').val('Edit');
            } else {
                title = 'Tambah Titik Keluhan';
                $('#submit_button').html('Simpan').show();
                $('#action').val('Add');
            }

            $('.modal-title').text(title);
            $('#modalform').modal('show');
        }

        function confirmDelete(id, gambar) {
            if (!id) {
                toastr.error('ID tidak valid', 'Error');
                return;
            }

            Swal.fire({
                title: 'Hapus Data?',
                text: "File gambar juga akan ikut terhapus. Tindakan ini tidak dapat dibatalkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then(function(result) {
                if (result.isConfirmed) {
                    processDelete(id, gambar);
                }
            });
        }

        function processDelete(id, gambar) {
            // Show loading
            Swal.fire({
                title: 'Menghapus data...',
                allowOutsideClick: false,
                didOpen: function() {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: SITE_URL + '/delete',
                method: 'POST',
                data: {
                    id: id,
                    gambar: gambar
                },
                dataType: 'JSON',
                success: function(response) {
                    Swal.close();

                    if (response.status === 'error') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message
                        });
                    } else {
                        toastr.success(response.message || 'Data berhasil dihapus', 'Berhasil');
                        $('#keluhanTable').DataTable().ajax.reload(null, false);
                    }
                },
                error: function(xhr, status, error) {
                    Swal.close();
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: 'Gagal menghapus data. Silakan coba lagi.'
                    });
                }
            });
        }

        // ── Toastr Configuration ───────────────────────────────────
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000"
        };

        // ── Additional: Click on add_record_btn ────────────────────
        // Ini untuk trigger dari button DataTables
        $(document).on('click', '#add_record_btn', function(e) {
            e.preventDefault();
            $('#add_record').trigger('click');
        });

    });
</script>
<?= $this->endSection('script'); ?>