<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>
<link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<style>
    .btn-fix-w {
        width: 80px;
        padding-top: 2px;
        padding-bottom: 2px;
        font-size: .720rem !important;
    }

    .table-vcenter td {
        vertical-align: middle !important;
        font-size: .850rem;
    }
</style>
<?= $this->endSection('style'); ?>

<?= $this->section('content'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Administrasi Formulir Pasien</h1>
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
                            <h3 class="card-title">Daftar Formulir</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-sm table-bordered table-striped table-hover table-vcenter">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="width: 50px" class="text-center">No</th>
                                        <th>Nama Formulir</th>
                                        <th>Keterangan</th>
                                        <th style="width: 180px" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $forms = [
                                        ['id' => 'cppt', 'nama' => 'Catatan Perkembangan Pasien Terintegrasi (CPPT)', 'ket' => 'Formulir SOAP Pasien.'],
                                        ['id' => 'discharge', 'nama' => 'Discharge Planning', 'ket' => 'Perencanaan pulang pasien rawat inap.'],
                                        ['id' => 'pulang', 'nama' => 'Petunjuk Pasien Pulang', 'ket' => 'Instruksi perawatan dirumah & jadwal kontrol.'],
                                        ['id' => 'observasi', 'nama' => 'Lembar Observasi Tindakan', 'ket' => 'Monitoring Pra, Intra, dan Post Anestesi.'],
                                        ['id' => 'operasi', 'nama' => 'Surgical Safety Checklist', 'ket' => 'Checklist keselamatan pasien operasi.'],
                                        ['id' => 'rawatJalan', 'nama' => 'Asesmen Risiko Jatuh Rawat Jalan', 'ket' => 'Penilaian risiko jatuh pasien.'],
                                    ];
                                    foreach ($forms as $idx => $f): ?>
                                        <tr>
                                            <td class="text-center"><?= $idx + 1 ?></td>
                                            <td><strong><?= $f['nama'] ?></strong></td>
                                            <td class="text-muted"><?= $f['ket'] ?></td>
                                            <td class="text-center">
                                                <a href="<?= base_url('tmstformulir/input/' . $f['id']) ?>" class="btn btn-info btn-fix-w" target="_blank">
                                                    <i class="fas fa-edit"></i> Input
                                                </a>
                                                <a href="<?= base_url('tmstformulir/cetak/' . $f['id']) ?>" target="_blank" class="btn btn-secondary btn-fix-w">
                                                    <i class="fas fa-print"></i> Cetak
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <?= view('components/dropdown3', [
                                'name'      => 'warehouse',
                                'apiUrl'    => base_url('dropdown/warehouse'),
                                'extraKeys' => [
                                    'data-id'   => 'id',
                                    'data-code' => 'warehouse_cd'
                                ],
                                'selected'  => 'WH001', // optional
                                'errors'    => $errors ?? []
                            ]) ?>

                            <?= view('components/dropdown3', [
                                'name'      => 'warehouse2',
                                'apiUrl'    => base_url('dropdown/warehouse'),
                                'extraKeys' => [
                                    'data-id'   => 'id',
                                    'data-code' => 'warehouse_cd'
                                ],
                                'selected'  => 'WH00002', // optional
                                'errors'    => $errors ?? []
                            ]) ?>

                            // Untuk multiple select
                            <?= view('components/dropdown_multiple', [
                                'name'      => 'warehouses',  // nama field
                                'apiUrl'    => base_url('dropdown/warehouse'),
                                'multiple'  => true,  // tambahkan parameter ini untuk multiple
                                'selected'  => ['WH00002', 'BSD'], // array untuk multiple selected
                                'extraKeys' => [
                                    'data-id'   => 'id',
                                    'data-code' => 'warehouse_cd'
                                ],
                                'errors'    => $errors ?? []
                            ]) ?>

                            // Untuk single select
                            <?= view('components/dropdown_multiple', [
                                'name'      => 'warehouses2',  // nama field
                                'apiUrl'    => base_url('dropdown/warehouse'),
                                'multiple'  => false,  // tambahkan parameter ini untuk single select
                                'selected'  => 'WH00002', // string untuk single selected
                                'extraKeys' => [
                                    'data-id'   => 'id',
                                    'data-code' => 'warehouse_cd'
                                ],
                                'errors'    => $errors ?? []
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection('content'); ?>