<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>
<link rel="stylesheet" href="<?= base_url('plugins/toastr/toastr.min.css') ?>">
<style>
    .form-control-sm {
        font-size: .720rem !important;
    }
</style>
<?= $this->endSection('style'); ?>

<?= $this->section('content'); ?>

<div class="content-wrapper">
    <section class="content-header">
        <!-- <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>GL Account Structure</h1>
                </div>
            </div>
        </div> -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <div class="card card-outline card-info">
                        <div class="card-body">

                            <table id="glaccountstructureTable"
                                class="table table-sm table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Structure ID</th>
                                        <th>Structure Name</th>
                                        <th>Segment 1</th>
                                        <th>Segment 2</th>
                                        <th>Segment 3</th>
                                        <th>Segment 4</th>
                                        <th>Segment 5</th>
                                        <th>Segment 6</th>
                                        <th>Segment 7</th>
                                        <th>Segment 8</th>
                                        <th>Segment 9</th>
                                        <th>Segment 10</th>
                                        <!-- <th>Created Date</th>
                                        <th>Created By</th> -->
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

<?= $this->endSection('content'); ?>

<?= $this->section('script'); ?>
<script src="<?= base_url('plugins/toastr/toastr.min.js') ?>"></script>

<script>
    $(document).ready(function() {

        $('#active-menu').html($('p#active-menu').html());
        $(document).prop("title", $('p#active-menu').html());

        const segmentColumns = [{
                index: 3,
                field: 'segment1'
            },
            {
                index: 4,
                field: 'segment2'
            },
            {
                index: 5,
                field: 'segment3'
            },
            {
                index: 6,
                field: 'segment4'
            },
            {
                index: 7,
                field: 'segment5'
            },
            {
                index: 8,
                field: 'segment6'
            },
            {
                index: 9,
                field: 'segment7'
            },
            {
                index: 10,
                field: 'segment8'
            },
            {
                index: 11,
                field: 'segment9'
            },
            {
                index: 12,
                field: 'segment10'
            }
        ];

        const table = $('#glaccountstructureTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,

            paging: true,
            searching: false,
            lengthChange: false,
            info: false,

            dom: 't',

            ajax: {
                url: "<?= base_url('tmstglactstructur/datatables') ?>",
                type: "POST",
                contentType: "application/json",
                data: function(d) {
                    return JSON.stringify(d);
                }
            },

            columnDefs: [{
                targets: 0,
                orderable: false,
                className: 'text-center'
            }],

            columns: [{
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'structureID'
                },
                {
                    data: 'structureName'
                },
                {
                    data: 'segment1',
                    defaultContent: ''
                },
                {
                    data: 'segment2',
                    defaultContent: ''
                },
                {
                    data: 'segment3',
                    defaultContent: ''
                },
                {
                    data: 'segment4',
                    defaultContent: ''
                },
                {
                    data: 'segment5',
                    defaultContent: ''
                },
                {
                    data: 'segment6',
                    defaultContent: ''
                },
                {
                    data: 'segment7',
                    defaultContent: ''
                },
                {
                    data: 'segment8',
                    defaultContent: ''
                },
                {
                    data: 'segment9',
                    defaultContent: ''
                },
                {
                    data: 'segment10',
                    defaultContent: ''
                }
                // {
                //     data: 'createdDate',
                //     render: function(data) {
                //         if (!data) return '';
                //         const d = new Date(data);
                //         const day = String(d.getDate()).padStart(2, '0');
                //         const month = String(d.getMonth() + 1).padStart(2, '0');
                //         const year = d.getFullYear();
                //         return `${day}/${month}/${year}`;
                //     }
                // },
                // {
                //     data: 'createdBy'
                // }
            ]
        });

        table.on('xhr.dt', function(e, settings, json) {

            if (!json || !json.data) return;

            segmentColumns.forEach(col => {
                const hasValue = json.data.some(row => {
                    const val = row[col.field];
                    return val !== null && val !== '';
                });

                table.column(col.index).visible(hasValue);
            });

            if (json?.status === 'session_expired') {
                alert('Sesi Anda telah berakhir. Silakan login kembali.');
                window.location.href = "<?= base_url('auth/login') ?>";
            }
        });

    });
</script>
<?= $this->endSection('script'); ?>