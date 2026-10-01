<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>
<!-- Toastr -->
<link rel="stylesheet" href="<?= base_url('plugins/toastr/toastr.min.css') ?>">
<!-- Button datatable -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<style>
    /* set width action button crud */
    .btn-fix-w {
        width: 60px;
        padding-top: 0px;
        padding-bottom: 0px;
    }

    /* set font size dropdown select2 */
    select.form-control-sm~.select2-container--default {
        font-size: .720rem !important;
    }

    /* set font size input form */
    .form-control-sm {
        font-size: .720rem !important;
    }
</style>
<?= $this->endSection('style'); ?>

<?= $this->section('content'); ?>

<?php
$session = session();
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1></h1>
                </div>
                <div class="col-sm-6">
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="container-fluid">

            <div class="row">
                <!-- left column -->
                <div class="col-md-12">

                    <!-- jquery validation -->
                    <div class="card card-outline card-info">

                        <div class="card-body">
                            <?= view('components/dropdownfilter', [
                                'id'          => 'testing3',
                                'name'        => 'testing3',
                                'apiUrl'      => base_url('/dropdown/customize/2/1/dropdown/parentmenu/action/parentmenu/null/null'),
                                'extraKeys'   => [],
                                'selected'    => '',
                                'errors'      => $errors ?? [],
                                'inFilter'    => ['value' => ['1098']],   // hanya tampilkan status tertentu
                                'notInFilter' => [] // sembunyikan nama tertentu
                            ]) ?>


                            <?= view('components/dropdown', [
                                'name'        => 'menus1',
                                'apiUrl'      => base_url('/dropdown/customize/2/1/dropdown/menu/null/null/null/null'),
                                'extraKeys'   => [
                                    'data-lokasi' => 'lokasi',
                                    'data-status' => 'warehouse_sta_id'
                                ],
                                'selected'    => '',           // Nilai yang akan terselect
                                'errors'      => $errors ?? []
                            ]) ?>

                            <?= view('components/dropdown', [
                                'name'        => 'menus',
                                'apiUrl'      => base_url('/dropdown/customize/2/1/dropdown/menu/action/menu/null/null'),
                                'extraKeys'   => [
                                    'data-lokasi' => 'lokasi',
                                    'data-status' => 'warehouse_sta_id'
                                ],
                                'selected'    => '',           // Nilai yang akan terselect
                                'errors'      => $errors ?? []
                            ]) ?>

                            <?= view('components/dropdown2', [
                                'id'          => 'testing2',
                                'name'        => 'testing2',
                                'apiUrl'      => base_url('/dropdown/customize/2/1/dropdown/item-types/action/parentmenu/null/null'),
                                'extraKeys'   => [
                                    'data-nama' => '',
                                    'data-status' => ''
                                ],
                                'selected'    => '',           // Nilai yang akan terselect
                                'errors'      => $errors ?? []
                            ]) ?>
                            <?= view('components/dropdown2', [
                                'id'          => 'demo-single',
                                'name'        => 'demo_single',
                                'apiUrl'      => base_url('/dropdown/server5/2/1/dropdown/item-types/action/getall/null/null'),
                                'selected'    => '',
                                'placeholder' => 'Pilih Tipe',
                                'extraKeys'   => []
                            ]) ?>

                            <?= view('components/dropdown', [
                                'name'        => 'testing',
                                'apiUrl'      => base_url('/dropdown/customize/2/1/dropdown/parentmenu/action/parentmenu/null/null'),
                                'extraKeys'   => [
                                    'data-nama' => '',
                                    'data-status' => ''
                                ],
                                'selected'    => '',           // Nilai yang akan terselect
                                'errors'      => $errors ?? []
                            ]) ?>

                            <?= view('components/dropdown_multiple', [
                                'name'        => 'multiple',
                                'apiUrl'      => base_url('/dropdown/customize/1/1/warehouse/null/action/getall/null/null'),
                                'extraKeys'  => [],
                                'selected'    => '',
                                'errors'      => $errors ?? []
                            ]) ?>

                            <?= view('components/dropdown_filter', [
                                'name'        => 'warehos2',
                                'apiUrl'      => base_url('/dropdown/customize/1/1/warehouse/null/action/getall/null/null'),
                                'extraKeys'  => [
                                    'data-warehouse_nm' => 'warehouse_nm',
                                    'data-warehouse_sta_id' => 'warehouse_sta_id',
                                    'data-lokasi' => 'lokasi'
                                ],
                                'filterIn'  => [
                                    'WH00002',
                                    'WH00005'
                                ],
                                'selected'    => '',
                                'errors'      => $errors ?? []
                            ]) ?>


                            <button type="button" class="btn btn-sm btn-primary" id="btnTest">Refresh</button>
                            <div class="card-title">
                            </div>


                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="modalform" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="exampleModalLabel"></h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="post" id="data_form" autocomplete="off">
                                        <?= csrf_field(); ?>
                                        <div class="modal-body">
                                            <div class="mb-3 row">
                                                <label for="kode_mesin" class="col-sm-2 col-form-label">Kode Mesin</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="kode_mesin" name="kode_mesin">
                                                    <span class="error invalid-feedback errorKode_mesin"></span>
                                                </div>
                                                <label for="nama_mesin" class="col-sm-2 col-form-label">Nama Mesin</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="nama_mesin" name="nama_mesin">
                                                    <span class="error invalid-feedback errorNama_mesin"></span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="lokasi_pos" class="col-sm-2 col-form-label">Lokasi</label>
                                                <div class="col-sm-4">
                                                    <textarea class="form-control form-control-sm" rows="3" placeholder="..." id="lokasi_pos" name="lokasi_pos" autocomplete="off"></textarea>
                                                    <span class="error invalid-feedback errorLokasi_pos"></span>
                                                </div>
                                                <label for="aktif_sta" class="col-sm-2 col-form-label">Status</label>
                                                <div class="col-sm-4">
                                                    <?= view('components/dropdown', [
                                                        'name'      => 'warehouse2',
                                                        'apiUrl'    => base_url('dropdown/warehouse'),
                                                        'extraKeys' => [
                                                            'data-id'   => 'id',
                                                            'data-code' => 'warehouse_cd'
                                                        ],
                                                        'selected'  => 'WH001', // optional
                                                        'errors'    => $errors ?? []
                                                    ]) ?>

                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <label for="bank" class="col-sm-2 col-form-label">Bank</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="bank" name="bank">
                                                    <span class="error invalid-feedback errorBank"></span>
                                                </div>
                                                <label for="no_rekening" class="col-sm-2 col-form-label">No Rekening</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="no_rekening" name="no_rekening">
                                                    <span class="error invalid-feedback errorNo_rekening"></span>
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <label for="tanggal_aktif" class="col-sm-2 col-form-label">Tanggal Aktif</label>
                                                <div class="col-sm-4">
                                                    <input type="date" class="form-control form-control-sm" id="tanggal_aktif" name="tanggal_aktif">
                                                    <span class="error invalid-feedback errorTanggal_aktif"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" id="hidden_id" name="hidden_id" />
                                            <input type="hidden" id="action" name="action" value="Add" />
                                            <button type="submit" name="submit" id="submit_button" class="btn btn-sm btn-primary" value="Simpan">Simpan</button>
                                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Import -->
                        <div class="modal fade" id="modalimport" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="exampleModalLabel"></h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="<?= site_url("tmstedc/preview") ?>" id="uploadForm" method="post" enctype="multipart/form-data">
                                            <?= csrf_field(); ?>
                                            <label for="filename">Import Excel File : <a href="<?= site_url("tmstedc/download") ?>"><u>Download Format</u></a></label> <br>
                                            <input type="file" name="filename" id="filename">
                                            <button type="submit" name="preview" class="btn btn-sm btn-primary" id="preview">Preview</button>
                                        </form>

                                        <div id="viewpreview"></div>
                                        <br>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
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
</div>
<!-- /.content-wrapper -->


<?= $this->endSection('content'); ?>

<?= $this->section('script'); ?>

<!-- Toastr -->
<script src="<?= base_url('plugins/toastr/toastr.min.js') ?>"></script>

<!-- Button datatable -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<!-- set menu name by active-menu -->
<script>
    $('#active-menu').html($('p#active-menu').html());
    $(document).prop("title", $('p#active-menu').html());
</script>

<script>
    function tmstdiagnosapreview() {
        $.ajax({
            method: "get",
            url: "<?= site_url('tmstedc/preview'); ?>",
            success: function(data) {
                $('#viewpreview').html(data);
            }
        });
    }

    $(document).ready(function() {

        function checkSession(response) {
            if (response && response.status === 'session_expired') {
                window.location.href = "<?= base_url('auth/login') ?>";
                return false;
            }
            return true;
        }

        $(document).on('click', '#add_record', function() {

            $('#data_form')[0].reset();
            $('.is-invalid').removeClass('is-invalid');
            $('[class^="error"]').html('');

            // Enable all fields for adding
            $('#kode_mesin').prop('disabled', false);
            $('#nama_mesin').prop('disabled', false);
            $('#lokasi_pos').prop('disabled', false);
            $('#bank').prop('disabled', false);
            $('#no_rekening').prop('disabled', false);
            $('#tanggal_aktif').prop('disabled', false);
            $('#aktif_sta').prop('disabled', false);

            $('#aktif_sta').val('').trigger('change.select2');

            $('.modal-title').text('Tambah Data');
            $('#action').val('Add');
            $('#hidden_id').val('');
            $('#submit_button').val('Simpan').html('Simpan').show();
            $('#modalform').modal('show');
        });

        $('#data_form').on('submit', function(event) {
            event.preventDefault();

            $.ajax({
                url: "<?= site_url('tmstedc/action'); ?>",
                method: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                beforeSend: function() {
                    $('#submit_button').prop('disabled', true).html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('#submit_button').prop('disabled', false).html('Simpan');
                },
                success: function(response) {

                    if (!checkSession(response)) return;

                    // Jika response berisi error validasi
                    if (response.error) {
                        showValidationErrors(response.error);
                    } else if (response.status === 'error') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message || 'Terjadi kesalahan saat menyimpan data.'
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message || 'Data berhasil disimpan.'
                        });

                        clearFormValidation();
                        $('#data_form')[0].reset();
                        $('#modalform').modal('hide');
                        $('#edcTable').DataTable().ajax.reload(null, false);

                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: 'Gagal menghubungi server. Silakan coba lagi nanti.'
                    });
                    console.error('AJAX Error:', status, error);
                }
            });
        });

        // 🔧 Fungsi bantu untuk menampilkan error validasi
        function showValidationErrors(errors) {
            const fields = ['kode_mesin', 'nama_mesin', 'lokasi_pos', 'bank', 'no_rekening', 'tanggal_aktif', 'aktif_sta'];
            fields.forEach(function(field) {
                if (errors[field]) {
                    $('#' + field).addClass('is-invalid');
                    $('.error' + capitalize(field)).html(errors[field]);
                } else {
                    $('#' + field).removeClass('is-invalid');
                    $('.error' + capitalize(field)).html('');
                }
            });
        }

        // 🔧 Fungsi bantu untuk reset validasi
        function clearFormValidation() {
            const fields = ['kode_mesin', 'nama_mesin', 'lokasi_pos', 'bank', 'no_rekening', 'tanggal_aktif', 'aktif_sta'];
            fields.forEach(function(field) {
                $('#' + field).removeClass('is-invalid');
                $('.error' + capitalize(field)).html('');
            });
        }

        // 🔧 Capitalize helper
        function capitalize(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }

        /*--------------------------------------------------*/

        $(document).on('click', '.view', function() {
            const edc_id = $(this).data('edc_id');

            console.log('View clicked - edc_id:', edc_id);

            $.ajax({
                url: "<?= site_url('tmstedc/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    edc_id: edc_id
                },
                dataType: "JSON",
                beforeSend: function() {
                    console.log('Fetching data for edc_id:', edc_id);
                },
                success: function(response) {
                    console.log('Response received:', response);

                    if (!checkSession(response)) return;

                    // Cek jika response error
                    if (response.status === 'error') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message || 'Gagal mengambil data'
                        });
                        return;
                    }

                    // Cek jika tidak ada data
                    if (!response.data) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Data tidak ditemukan'
                        });
                        return;
                    }

                    $('#data_form')[0].reset();
                    $('.is-invalid').removeClass('is-invalid');
                    $('[class^="error"]').html('');

                    const data = response.data;

                    $('#kode_mesin').val(data.kode_mesin).prop('disabled', true);
                    $('#nama_mesin').val(data.nama_mesin).prop('disabled', true);
                    $('#lokasi_pos').val(data.lokasi_pos).prop('disabled', true);
                    $('#bank').val(data.bank).prop('disabled', true);
                    $('#no_rekening').val(data.no_rekening).prop('disabled', true);
                    $('#tanggal_aktif').val(data.tanggal_aktif).prop('disabled', true);
                    $('#aktif_sta').val(data.status).prop('disabled', true).trigger('change.select2');

                    $('.modal-title').text('Lihat Data');
                    $('#action').val('View');
                    $('#hidden_id').val(data.edc_id);
                    $('#submit_button').hide();
                    $('#modalform').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal mengambil data',
                        text: 'Terjadi kesalahan saat mengambil data edc: ' + error
                    });
                }
            });
        });

        $(document).on('click', '.edit', function() {
            const edc_id = $(this).data('edc_id');

            console.log('Edit clicked - edc_id:', edc_id);

            $.ajax({
                url: "<?= site_url('tmstedc/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    edc_id: edc_id
                },
                dataType: "JSON",
                beforeSend: function() {
                    console.log('Fetching data for edc_id:', edc_id);
                },
                success: function(response) {
                    console.log('Response received:', response);

                    if (!checkSession(response)) return;

                    // Cek jika response error
                    if (response.status === 'error') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message || 'Gagal mengambil data'
                        });
                        return;
                    }

                    // Cek jika tidak ada data
                    if (!response.data) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Data tidak ditemukan'
                        });
                        return;
                    }

                    $('#data_form')[0].reset();
                    $('.is-invalid').removeClass('is-invalid');
                    $('[class^="error"]').html('');

                    const data = response.data;

                    $('#kode_mesin').val(data.kode_mesin).prop('disabled', false);
                    $('#nama_mesin').val(data.nama_mesin).prop('disabled', false);
                    $('#lokasi_pos').val(data.lokasi_pos).prop('disabled', false);
                    $('#bank').val(data.bank).prop('disabled', false);
                    $('#no_rekening').val(data.no_rekening).prop('disabled', false);
                    $('#tanggal_aktif').val(data.tanggal_aktif).prop('disabled', false);
                    $('#aktif_sta').val(data.status).prop('disabled', false).trigger('change.select2');

                    $('.modal-title').text('Ubah Data');
                    $('#action').val('Edit');
                    $('#hidden_id').val(data.edc_id);
                    $('#submit_button').val('Simpan').html('Simpan').show();
                    $('#modalform').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal mengambil data',
                        text: 'Terjadi kesalahan saat mengambil data edc: ' + error
                    });
                }
            });
        });

        $(document).on('click', '.delete', function() {
            const edc_id = $(this).data('edc_id');

            Swal.fire({
                title: 'Yakin ingin menghapus data?',
                text: 'Data edc akan dihapus secara permanen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= site_url('tmstedc/delete'); ?>",
                        method: "POST",
                        data: {
                            edc_id
                        },
                        dataType: "JSON",
                        success: function(response) {

                            if (!checkSession(response)) return;

                            if (response.status === 'error') {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: response.message || 'Terjadi kesalahan saat menghapus data.'
                                });
                            } else {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message || 'Data berhasil dihapus.'
                                });
                                $('#edcTable').DataTable().ajax.reload(null, false);

                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal menghapus data',
                                text: 'Terjadi kesalahan saat menghubungi server.'
                            });
                            console.error('AJAX Error:', status, error);
                        }
                    });
                }
            });
        });
    });
</script>

<script>
    // Event onclick untuk button
    $("#btnTest").on("click", function() {
        $(document).trigger('refresh-dropdown:#dropdown-testing');
        $(document).trigger('refresh-dropdown:#testing2');
        // $('#dropdown-warehouses').val(['WH00002', 'WH00005', 'WH00007']).trigger('change');
        // $(document).trigger('refresh-dropdown_multiple:#dropdown-warehouses');

        // Cara 2: Set dengan string dipisah koma
        //const values = 'WH00002,WH00005,WH00007'.split(',');
        const values2 = '1098';

        // alert(values);

        $('#dropdown-multiple').val(values).trigger('change');
        // $('#testing3').val(values2).trigger('change');

        const aa = $('#dropdown-multiple').val();
        alert(aa);

    });
</script>

<script>
    $(document).ready(function() {

        $(document).on('click', '#import', function() {
            $('.modal-title').text('Import Data');
            $("#filename").val(null);
            $('#viewpreview').html('');
            $('#modalimport').modal('show');
        });

        $('#uploadForm').submit(function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            $.ajax({
                url: '/tmstedc/preview',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#preview').prop('disabled', true);
                    $('#preview').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('#preview').prop('disabled', false);
                    $('#preview').html('Preview');
                },
                success: function(response) {
                    tmstdiagnosapreview();
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                }
            });
        });

    });
</script>

<script>
    $(document).ready(function() {

        $("#edcTable").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            dom: 'Bfrtip',
            ajax: {
                url: "<?= base_url('tmstedc/datatables') ?>",
                type: "POST",
                contentType: "application/json",
                data: function(d) {
                    return JSON.stringify(d);
                }
            },
            columnDefs: [{
                    orderable: false,
                    targets: [0, 8]
                },
                {
                    targets: [0, 8],
                    className: 'text-center'
                }
            ],
            columns: [{
                    data: 'rownum',
                    orderable: false
                },
                {
                    data: 'kode_mesin'
                },
                {
                    data: 'nama_mesin'
                },
                {
                    data: 'lokasi_pos'
                },
                {
                    data: 'bank'
                },
                {
                    data: 'no_rekening'
                },
                {
                    data: 'tanggal_aktif',

                    // --- Function Format Tanggal --- //

                    render: function(data, type, row) {
                        if (!data) return '';
                        return formatDate(data)['dd/mm/yyyy'];
                    }
                },
                {
                    data: 'status',
                    render: function(data, type, row) {
                        if (data === 'A') {
                            return '<span class="badge badge-success">Aktif</span>';
                        } else if (data === 'T') {
                            return '<span class="badge badge-danger">Tidak Aktif</span>';
                        } else {
                            return '<span class="badge badge-secondary">' + data + '</span>';
                        }
                    }
                },
                {
                    data: 'aksi',
                    orderable: false
                }
            ],
            buttons: [{
                    text: "Tambah",
                    action: function() {},
                    attr: {
                        id: "add_record",
                        style: "background-color:#56b746; <?= session()->get('flag_insert') === 1 ? '' : 'display:none;' ?>",
                        name: "add_record",
                    }

                },
                {
                    extend: "excel",
                    text: "Excel",
                    className: "btn-sm btn-primary <?= session()->get('flag_export') === 1 ? '' : 'd-none' ?>",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                },
                {
                    extend: "print",
                    text: "Cetak",
                    className: "btn-sm btn-info <?= session()->get('flag_print') === 1 ? '' : 'd-none' ?>",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                },
                {
                    text: "Import",
                    action: function() {},
                    attr: {
                        id: "import",
                        style: "background-color:#56b746; <?= session()->get('flag_insert') === 1 ? '' : 'display:none;' ?>",
                        nameClass: "btn btn-sm btn-warning"
                    }
                }
            ],
            oLanguage: {
                sSearch: "Cari Data:",
                sInfoEmpty: "Tidak ada data",
                sInfo: "Total: _TOTAL_ data",
                sInfoFiltered: " dari _MAX_ data",
                sZeroRecords: "Data tidak ditemukan",
                oPaginate: {
                    sFirst: "Awal",
                    sPrevious: "Sebelum",
                    sNext: "Berikut",
                    sLast: "Akhir"
                }
            }
        }).buttons().container().appendTo("#edcTable_wrapper .col-md-6:eq(0)");

        $('#edcTable').on('xhr.dt', function(e, settings, json, xhr) {
            if (json && json.status === 'session_expired') {
                window.location.href = "<?= base_url('auth/login') ?>";
                alert('Sesi Anda telah berakhir. Silakan login kembali.');
            }
        });
    });
</script>

<?= $this->endSection('script'); ?>