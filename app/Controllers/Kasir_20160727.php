<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

class Kasir extends BaseController
{

    protected $data;
    protected $server;
    protected $server5;
    protected $client;

    public function __construct()
    {
        $this->server  = $_ENV['APP_API'];
        $this->server5 = $_ENV['APP_API5'];
    }

    public function index()
    {
        $this->session->remove("no_registrasi_deposit");

        return view('kasir/index', $this->data);
    }

    public function edit()
    {
        return view('kasir/edit', $this->data);
    }

    public function apiDataGetAll()
    {

        helper(['restclient']);

        $url = "$this->server/tregistrasi/getallpm";

        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);
        return $data['response_data'];
    }

    public function apiDataGetRegistrasiPm()
    {

        helper(['restclient']);

        $url = "$this->server/list/registrasipm";

        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);
        return $data['response_data'];
    }

    public function apiDataGetItem()
    {

        helper(['restclient']);

        $url = "$this->server/list/item";

        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);
        return $data['response_data'];
    }

    public function apiDataGetBilling()
    {

        helper(['restclient']);

        $url = "$this->server/billing/getall";

        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);
        return $data['response_data'];
    }

    public function fetchAll()
    {
        $output = '';
        $data =  $this->apiDataGetAll();
        $output .= '  
                    <table id="example4" class="table table-sm table-bordered table-striped">
                    <thead>
                            <tr>
                                <th>No. REG</th>
                                <th>Pasien</th>
                                <th>Tgl Registrasi</th>
                                <th>Via</th>
                                <th>Tujuan</th>
                                <th>Dokter</th>
                                <th>Tgl Praktek</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th></th>
                            </tr>
                        </thead>
                            ';
        if ($data == '') {
            $output .= '<tr>  
                            <td >Data not Found</td>
                            <td ></td>
                            <td ></td>
                            <td ></td>
                            <td ></td>
                            <td ></td>
                            <td ></td>
                            <td ></td>
                            <td ></td>
                            <th></th>
                        </tr>';
        } else {
            for ($a = 0; $a < count($data); $a++) {
                $output .= '  
                            <tr id="addMdlBarang" data-id="' . $data[$a]["no_registrasi"] . '">
                                <td >' . $data[$a]["no_registrasi"] . '</td>
                                <td >' . $data[$a]["fullname"] . '</td>
                                <td >' . date('d/m/Y', strtotime($data[$a]["tgl_registrasi"])) . '</td>
                                <td >' . $data[$a]["registrasi_via"] . '</td>
                                <td >' . $data[$a]["tujuan_registrasi_desc"] . '</td>
                                <td >' . $data[$a]["nama_dokter"] . '</td>
                                <td >' . date('d/m/Y', strtotime($data[$a]["tgl_praktek"])) . '</td>
                                <td >' . $data[$a]["jam_mulai"] . '</td>
                                <td >' . $data[$a]["jam_selesai"] . '</td>
                                
                                <td class="text-right">
                                    
                                    <div class="btn-group">
                                    <a data-toggle="tooltip" data-placement="top" title="View" class="btn btn-sm btn-info view ' . ($this->session->get("flag_view") === 1 ? "" : "d-none") . '" data-no_registrasi="' . $data[$a]["no_registrasi"] . '"><i class="fas fa-eye"></i></a>
                                    <a data-toggle="tooltip" data-placement="top" title="Batal" class="btn btn-sm btn-warning batal ' . ($this->session->get("flag_update") === 1 ? "" : "d-none") . '" data-no_registrasi="' . $data[$a]["no_registrasi"] . '"><i class="fas fa-tags"></i></a>
                                    <a data-toggle="tooltip" data-placement="top" title="Hadir" class="btn btn-sm btn-success hadir ' . ($this->session->get("flag_update") === 1 ? "" : "d-none") . '" data-no_registrasi="' . $data[$a]["no_registrasi"] . '"><i class="fas fa-tags"></i></a>
                                    <a data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-sm btn-danger delete ' . ($this->session->get("flag_delete") === 1 ? "" : "d-none") . '" data-no_registrasi="' . $data[$a]["no_registrasi"] . '"><i class="fas fa-trash"></i></a>
                                    </div>
                                    
                                </td>
                            </tr>  
                    ';
            }
        }
        $output .= '</table>
            <script>
            $(function() {
                $("#example4").DataTable({
                    columnDefs: [{
                        orderable: false,
                        targets: 9
                    }],
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    "buttons": [{
                            text: "Tambah data",
                            action: function(e, dt, node, config) {
                            },
                            attr: {
                                id: "add_record",
                                style: "background-color:#56b746;' . ($this->session->get("flag_insert") === 1 ? "" : "display:none;") . '",
                                name:"add_record",
                                nameClass:"btn-lg"
                            }
                        },
                        { text: "Excel",extend: "excel", className: "btn-sm btn-primary ' . ($this->session->get("flag_export") === 1 ? "" : "d-none") . '", exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8]} },
                        { text: "Cetak",extend: "print", className: "btn-sm btn-info ' . ($this->session->get("flag_print") === 1 ? "" : "d-none") . '", exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8]} }
                           
                    ],
                    "oLanguage": {
                        "sSearch": "Cari Data:",
                        "sInfoEmpty": "Tidak ada data",
                        "sInfo": "Total: _TOTAL_ data",
                        "sInfoFiltered": " dari _MAX_ data",
                        "sZeroRecords": "Data tidak ditemukan",
                        "oPaginate": {
                            "sFirst": "Awal",
                            "sPrevious": "Sebelum",
                            "sNext": "Berikut",
                            "sLast": "Akhir"
                        },
                    },
                }).buttons().container().appendTo("#example4_wrapper .col-md-6:eq(0)");
            });
            </script>
            ';
        echo $output;
    }

    function fetchDataKasirListRegistrasi()
    {
        $output = '';
        $data = $this->apiDataGetRegistrasiPm();
        $output .= '  
            <table id="example4" class="table table-sm table-striped" style="border-spacing: 0;">
                <thead>
                    <tr>  
                        <th>Pasien</th>
                        <th>Dokter</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
        ';

        if (empty($data)) {
            $output .= '<tr><td colspan="3" class="text-center">Data tidak ditemukan</td></tr>';
        } else {
            foreach ($data as $row) {
                $output .= '  
                    <tr>  
                        <td>' . htmlspecialchars($row["pasien"]) . '</td>
                        <td>' . htmlspecialchars($row["dokter"]) . '</td> 
                        <td class="text-right">
                            <button data-widget="control-sidebar" data-slide="true"
                                type="button"
                                class="btn btn-info btn-sm float-right mr-1 mt-1 pilihpasien btn-fix-w"
                                data-no_registrasi="'          . $row['no_registrasi']                          . '"
                                data-patient_no="'             . $row['no_pasien']                              . '"
                                data-fullname="'               . htmlspecialchars($row['pasien'])               . '"
                                data-birth_dt="'               . $row['birth_dt']                               . '"
                                data-nama_dokter="'            . htmlspecialchars($row['dokter'])             . '"
                                data-no_kwitansi="'            . ($row['no_kwitansi'] ?? '')                    . '"
                                data-tujuan_registrasi_desc="Poli Umum"
                                data-gender="-"
                            >Pilih</button>
                        </td>
                    </tr>  
                ';
            }
        }
        $output .= '
                </tbody>
            </table>
            <script type="text/javascript">
            $(function () {
                if ($.fn.DataTable.isDataTable("#example4")) {
                    $("#example4").DataTable().destroy();
                }
                $("#example4").DataTable({
                    columnDefs: [{ orderable: false, targets: 2 }],
                    paging: false,
                    searching: false,
                    info: false,
                    autoWidth: false
                });
            });
            </script>
        ';
        echo $output;
    }

    function fetchDataKasirListItem()
    {
        $output = '';
        $data = $this->apiDataGetItem();
        $output .= '  
		           <table id="example5" class="table table-sm table-hover">
				   <thead>
		                <tr>  
		                    <th >Kode</th>  
		                    <th >Item</th>  
		                    <th class="text-right">Tarif</th>
                            <th >PPN</th>
                            <th ></th>
		                </tr>
					</thead>
						';
        if ($data == '') {
            $output .= '<tr>  
		                         <td >Data not Found</td>
								 <td ></td>
								 <td ></td>
                                 <td ></td>
                                 <td ></td>
		                     </tr>';
        } else {
            foreach ($data as $row) {
                $output .= '  
		                <tr id="addRowItem" data-id="' . $row["item_cd"] . '">  
		                    <td class="text-uppercase addItem" data-id="' . $row["item_cd"] . '">' . $row["item_cd"] . '</td>  
		                    <td class="text-uppercase">' . $row["item_nm"] . '</td>  
                            <td class="text-right">' . number_format(floatval($row["unitprice"]), 2, ",", ".") . '</td>  
                            <td class="text-uppercase">' . $row["isvat"] . '</td>
                            <td class="text-right">
                                    <div class="btn-group">
                                    <a data-toggle="tooltip" data-placement="top" title="Add" class="btn btn-sm btn-success addItem ' . ($this->session->get("flag_insert") === 1 ? "" : "d-none") . '" data-id="' . $row["item_cd"] . '"><i class="fas fa-plus"></i></a>
                                    </div>
                            </td>
		                </tr>  
		           ';
            }
        }
        $output .= '</table>
			  <script type="text/javascript">
			  $(function () {
				$("#example5").DataTable({
				"paging": true,
				  "lengthChange": true,
				  "searching": true,
				  "ordering": true,
				  "info": false,
				  "autoWidth": true
				});
			  });
		       </script>
			   ';
        echo $output;
    }

    function fetchDataKasirListBilling()
    {
        $output = '';
        $data = $this->apiDataGetBilling();
        $output .= '  
		           <table id="example6" class="table table-sm table-hover">
				   <thead>
		                <tr>  
		                    <th >No Kwitansi</th>
                            <th >Nama Pasien</th> 
		                    <th >No Registrasi</th>  
                            <th >Tgl Kwitansi</th>
                            <th >Employee</th>
                            <th >Status</th>
                            <th class="text-right">Tagihan</th>
                            <th class="text-right">Saldo</th>
                            <th class="text-right"></th>
		                </tr>
					</thead>
						';
        if ($data == '') {
            $output .= '<tr>  
		                         <td >Data not Found</td>
                                 <td ></td>
								 <td ></td>
								 <td ></td>
                                 <td ></td>
                                 <td ></td>
								 <td ></td>
                                 <td ></td>
                                 <td ></td>
		                     </tr>';
        } else {
            foreach ($data as $row) {
                $output .= '  
		                <tr id="addRowItem" data-id="' . $row["no_kwitansi"] . '">  
		                    <td class="text-uppercase addItem" data-id="' . $row["no_kwitansi"] . '">' . $row["no_kwitansi"] . '</td>  
		                    <td class="text-uppercase">' . $row["fullname"] . '</td> 
                            <td class="text-uppercase">' . $row["no_registrasi"] . '</td> 
                            <td class="text-uppercase">' . date('d/m/Y', strtotime($row["tgl_kwitansi"])) . '</td>
                            <td class="text-uppercase">' . $row["emp_cd"] . '</td> 
                            <td class="text-uppercase">' . $row["status_kwitansi"] . '</td> 
                            <td class="text-right">' . number_format(floatval($row["tagihan"]), 2, ",", ".") . '</td>  
                            <td class="text-right">' .  number_format(floatval($row["saldo"]), 2, ",", ".") . '</td>
                            <td class="text-right">
                            <a data-toggle="tooltip" data-placement="top" title="Print" class="btn btn-sm btn-info print ' . ($this->session->get("flag_print") === 1 ? "" : "d-none") . '" data-no_kwitansi="' . $row["no_kwitansi"] . '"><i class="fas fa-print"></i></a>
                            <a data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-sm btn-success edit ' . ($this->session->get("flag_print") === 1 ? "" : "d-none") . '" data-no_kwitansi="' . $row["no_kwitansi"] . '"><i class="fas fa-edit"></i></a>
                            </td>
		                </tr>  
		           ';
            }
        }
        $output .= '</table>
			  <script type="text/javascript">
			  $(function () {
				$("#example6").DataTable({
				"paging": true,
				  "lengthChange": true,
				  "searching": true,
				  "ordering": true,
				  "info": false,
				  "autoWidth": true
				});
			  });
		       </script>
			   ';
        echo $output;
    }

    function fetchAllView()
    {
        if ($this->request->isAJAX()) {

            $no_registrasi = $this->request->getVar('no_registrasi');

            if ($no_registrasi) {

                helper(['restclient']);

                $url = "$this->server/tregistrasi/getby/$no_registrasi";

                $response = akses_restapi('GET', $url, []);
                $data['response_data'] = json_decode($response, true);

                $msg = [
                    'data' => [
                        'no_registrasi' => $data["response_data"][0]["no_registrasi"],
                        'no_pasien' => $data["response_data"][0]["no_pasien"],
                        'tgl_registrasi' => $data["response_data"][0]["tgl_registrasi"],
                        'registrasi_via' => $data["response_data"][0]["registrasi_via"],
                        'tujuan_registrasi' => $data["response_data"][0]["tujuan_registrasi"],
                        'dokter' => $data["response_data"][0]["dokter"],
                        'jadwal_dokter' => $data["response_data"][0]["jadwal_dokter"],
                        'created_by' => $data["response_data"][0]["created_by"],
                        'created_date' => $data["response_data"][0]["created_date"],
                        'tgl_praktek' => $data["response_data"][0]["tgl_praktek"],
                        'jam_mulai' => $data["response_data"][0]["jam_mulai"],
                        'jam_selesai' => $data["response_data"][0]["jam_selesai"],
                        'tahun' => $data["response_data"][0]["tahun"],
                        'bulan' => $data["response_data"][0]["bulan"],
                        'hari' => $data["response_data"][0]["hari"],
                        'fullname' => $data["response_data"][0]["fullname"],
                        'gender' => $data["response_data"][0]["gender"],
                        'birth_dt' => $data["response_data"][0]["birth_dt"],
                        'addr' => $data["response_data"][0]["addr"],
                        'mobile_no' => $data["response_data"][0]["mobile_no"],
                        'nama_dokter' => $data["response_data"][0]["nama_dokter"],
                        'daftar' => $data["response_data"][0]["daftar"],
                        'hadir' => $data["response_data"][0]["hadir"],
                        'selesai' => $data["response_data"][0]["selesai"],
                        'Tipe_Pasien' => $data["response_data"][0]["type_pasien"],
                        'asr_cd' => $data["response_data"][0]["asr_cd"]

                    ]
                ];

                echo json_encode($msg);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    public function hadir()
    {
        if ($this->request->isAJAX()) {
            $no_registrasi = $this->request->getVar('no_registrasi');

            helper(['restclient']);

            $url = "$this->server/tregistrasi/hadir/$no_registrasi";

            $response = akses_restapi('PATCH', $url, []);
            $data['response_data'] = json_decode($response, true);

            $msg = [
                'success' => "Data dengan no $no_registrasi berhasil diubah"
            ];
            echo json_encode($msg);
        }
    }

    public function batal()
    {
        if ($this->request->isAJAX()) {
            $no_registrasi = $this->request->getVar('no_registrasi');

            helper(['restclient']);

            $url = "$this->server/tregistrasi/batal/$no_registrasi";

            $response = akses_restapi('PATCH', $url, []);
            $data['response_data'] = json_decode($response, true);

            $msg = [
                'success' => "Data dengan no $no_registrasi berhasil diubah"
            ];
            echo json_encode($msg);
        }
    }


    public function delete()
    {
        if ($this->request->isAJAX()) {
            $no_registrasi = $this->request->getVar('no_registrasi');

            helper(['restclient']);

            $url = "$this->server/tregistrasi/delete/$no_registrasi";

            $response = akses_restapi('DELETE', $url, []);
            $data['response_data'] = json_decode($response, true);

            $msg = [
                'success' => "Data dengan no $no_registrasi berhasil dihapus"
            ];
            echo json_encode($msg);
        }
    }

    function action()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getVar('action')) {
                helper(['form', 'url']);

                $validation = \Config\Services::validation();
                $valid = $this->validate([
                    'patient_no' => [
                        'label' => 'Pasien',
                        'rules' => 'required',
                        'errors' => []
                    ],
                    'tujuan_registrasi' => [
                        'label' => 'Tujuan',
                        'rules' => 'required',
                        'errors' => []
                    ],
                    'Tipe_Pasien' => [
                        'label' => 'Tipe Pasien',
                        'rules' => 'required',
                        'errors' => []
                    ],
                    'asr_cd' => [
                        'label' => 'Asuransi',
                        'rules' => $this->request->getVar('Tipe_Pasien') === 'ASRN' ? 'required' : 'permit_empty',
                        'errors' => []
                    ],
                    'kode_dokter' => [
                        'label' => 'Dokter',
                        'rules' => 'required',
                        'errors' => []
                    ]
                ]);
                if (!$valid) {
                    $msg = [
                        'error' => [
                            'patient_no' => $validation->getError('patient_no'),
                            'tujuan_registrasi' => $validation->getError('tujuan_registrasi'),
                            'Tipe_Pasien' => $validation->getError('Tipe_Pasien'),
                            'asr_cd' => $validation->getError('asr_cd'),
                            'kode_dokter' => $validation->getError('kode_dokter'),
                        ]
                    ];
                } else {

                    if ($this->request->getVar('action') == 'Add') {

                        helper(['restclient']);

                        $url = "$this->server/tregistrasi/insert";

                        $data = [
                            "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('no_registrasi'))),
                            "no_pasien" => str_replace(" ", "_", trim($this->request->getVar('no_pasien'))),
                            "type_pasien" => $this->request->getVar('Tipe_Pasien'),
                            "asr_cd" => $this->request->getVar('asr_cd'),
                        ];
                        $response = akses_restapi('POST', $url, $data);

                        $msg = [
                            'success' => 'data berhasil di create!'
                        ];
                    }

                    if ($this->request->getVar('action') == 'Registrasi') {

                        helper(['restclient']);

                        $url = "$this->server/tregistrasi/insert";

                        $data = [
                            "no_registrasi" => '',
                            "no_pasien" => str_replace(" ", "_", trim($this->request->getVar('patient_no'))),
                            "tgl_registrasi" => $this->request->getVar('tgl_registrasi'),
                            "registrasi_via" => "off",
                            "tujuan_registrasi" => $this->request->getVar('tujuan_registrasi'),
                            "dokter" => $this->request->getVar('kode_dokter'),
                            "jadwal_dokter" => $this->request->getVar('jadwal_id'),
                            "created_by" => session()->get('usr_id'),
                            "created_date" => $this->request->getVar('tgl_registrasi'),
                            "tgl_praktek" => $this->request->getVar('tanggal'),
                            "jam_mulai" => $this->request->getVar('jam_mulai'),
                            "jam_selesai" => $this->request->getVar('jam_selesai'),
                            "tahun" => $this->request->getVar('tahun'),
                            "bulan" => $this->request->getVar('bulan'),
                            "hari" => $this->request->getVar('hari'),
                            "daftar" => 1,
                            "hadir" => 0,
                            "type_pasien" => $this->request->getVar('Tipe_Pasien'),
                            "cashless" => $this->request->getVar('cashless'),
                            "asr_cd" => $this->request->getVar('asr_cd'),
                        ];
                        $response = akses_restapi('POST', $url, $data);

                        $msg = [
                            'success' => 'data berhasil di create!'
                        ];
                    }

                    if ($this->request->getVar('action') == 'Edit') {

                        helper(['restclient']);

                        $url = "$this->server/tregistrasi/update";

                        $data = [
                            "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('no_registrasi'))),
                            "no_pasien" => str_replace(" ", "_", trim($this->request->getVar('no_pasien'))),
                        ];
                        $response = akses_restapi('PUT', $url, $data);

                        $msg = [
                            'success' => 'data berhasil diupdate'
                        ];
                    }
                }

                echo json_encode($msg);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }


    function fetchSingleData()
    {
        if ($this->request->isAJAX()) {

            $item_cd = $this->request->getVar('item_cd');

            if ($item_cd) {

                helper(['restclient']);

                $url = "$this->server/tmstitem/tarifgetby/$item_cd";

                $response = akses_restapi('GET', $url, []);
                $data['response_data'] = json_decode($response, true);

                $msg = [
                    'data' => [
                        'item_nm' => $data["response_data"][0]["item_nm"],
                        'uom_base' => $data["response_data"][0]["uom_base"],
                        'barcode' => $data["response_data"][0]["barcode"],
                        'remark' => $data["response_data"][0]["remark"],
                        'deleted' => $data["response_data"][0]["deleted"],
                        'isvat' => $data["response_data"][0]["isvat"],
                        'unitprice' => $data["response_data"][0]["unitprice"],
                        'item_typ' => $data["response_data"][0]["item_typ"],
                        'item_cat_cd' => $data["response_data"][0]["item_cat_cd"],
                        'item_cd' => $data["response_data"][0]["item_cd"]
                    ]
                ];

                echo json_encode($msg);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }


    function getDropdown()
    {

        helper(['dropdown']);

        $poli = $this->request->getVar('poli');

        $cb_dokter = getDropdownDokterCustomTree($poli);

        return $cb_dokter;
    }

    public function store()
    {
        if ($this->request->isAJAX()) {
            $request = $this->request->getJSON();


            if ($request) {

                helper(['restclient']);

                $urlbilling = "$this->server/notransaksi/billing";
                $response = akses_restapi('GET', $urlbilling, []);
                $no_kwitansi = json_decode($response, true);
                $no_registrasi = $this->session->get('no_registrasi_deposit');

                $url = "$this->server/tregistrasi/deposit/$no_registrasi";

                $response = akses_restapi('PATCH', $url, []);
                $data['response_data'] = json_decode($response, true);

                $urlbillingdetail = "$this->server/billingdetail/insert";

                $sumTotal = 0;
                foreach ($request as $itemloop) {
                    $sumTotal += $itemloop->total;
                }

                $databilling = [
                    'no_kwitansi' => $no_kwitansi[0]['generated'],
                    'no_registrasi' => $no_registrasi,
                    'tgl_kwitansi' => date("Y-m-d H:i:s"),
                    'emp_cd' => $this->session->get('usr_id'),
                    'status_kwitansi' => 'aktif',
                    'terbilang' => '',
                    'tagihan' => $sumTotal,
                    'saldo' => 0,
                ];

                $urlbilling = "$this->server/billing/insert";
                $response = akses_restapi('POST', $urlbilling, $databilling);

                foreach ($request as $item) {
                    $databillingdetail = [
                        'no_kwitansi' => $no_kwitansi[0]['generated'],
                        'item_cd' => $item->item_cd,
                        'jumlah' => $item->quantity,
                        'tarif' => $item->rate,
                        'potongan' => $item->discount,
                        'pajak' => $item->tax,
                        'total' => $item->total,
                    ];

                    akses_restapi('POST', $urlbillingdetail, $databillingdetail);
                }

                $msg = [
                    'success' => 'data berhasil diupdate',
                    'no_kwitansi' => $response
                ];

                echo json_encode($msg);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    public function setNoRegistrasi()
    {
        if ($this->request->isAJAX()) {
            $this->session->set([
                "no_registrasi_deposit" => $this->request->getVar('no_registrasi'),
                "patient_no_deposit"    => $this->request->getVar('patient_no'),
            ]);
            $msg = [
                'success' => 'data berhasil diupdate'
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    public function removeNoRegistrasi()
    {
        if ($this->request->isAJAX()) {
            $this->session->remove("no_registrasi_deposit");
            $this->session->remove("patient_no_deposit");
            $msg = [
                'success' => 'data berhasil diupdate'
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    function fetchSingleDataPrint($no_kwitansi)
    {

        if ($no_kwitansi) {

            helper(['restclient']);

            // 1. Data item/billing dari kwitansi (item, harga, qty, pasien, dokter, dll)
            $url = "$this->server/billing/printby/$no_kwitansi";
            $response = akses_restapi('GET', $url, []);
            $data['response_data'] = json_decode($response, true);

            $pdf_data = $data['response_data'];

            // 2. Rincian pembayaran per metode (Cash/Transfer/Debit/Voucher/AR/Deposit) dari API3
            $urlDetail = "{$this->server5}/api/Payment/detail/{$no_kwitansi}";
            $riwayatBayar = [];

            try {
                $responseDetail = akses_restapikey('GET', $urlDetail, [], []);
                $resultDetail   = is_string($responseDetail) ? json_decode($responseDetail, true) : $responseDetail;

                if (isset($resultDetail['success']) && $resultDetail['success'] === true) {
                    $riwayatBayar = $resultDetail['data'] ?? [];
                }
            } catch (\Exception $e) {
                $riwayatBayar = [];
            }

            // Sisipkan rincian pembayaran ke setiap baris $pdf_data supaya bisa dipakai di view
            // (nilainya sama untuk semua baris karena ini rincian pembayaran per kwitansi, bukan per item)
            if (is_array($pdf_data)) {
                foreach ($pdf_data as $idx => $row) {
                    $pdf_data[$idx]['riwayat_pembayaran'] = $riwayatBayar;
                }
            }

            $pdf_name = 'Single Data Patient';
            $pdf_title = 'KWITANSI';
            $pdf_paper = 'A4';
            $pdf_orientation = 'portrait';
            $pdf_format = 'rpt_billing_pdf';

            $this->view_pdf($pdf_name, $pdf_title, $pdf_data, $pdf_paper, $pdf_orientation, $pdf_format);
        }
    }

    function fetchAllDataPrint()
    {
        helper(['restclient']);
        $url = "$this->server/pasien/getby/23090001";
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);

        $pdf_data = $data['response_data'];
        $pdf_name = 'Single Data Patient';
        $pdf_title = 'KWITANSI';
        $pdf_paper = 'A4';
        $pdf_orientation = 'portrait';
        $pdf_format = 'rpt_patient_pdf';

        $this->view_pdf($pdf_name, $pdf_title, $pdf_data, $pdf_paper, $pdf_orientation, $pdf_format);
    }


    public function view_pdf($pdf_name, $pdf_title, $pdf_data, $pdf_paper, $pdf_orientation, $pdf_format)
    {

        $Pdfgenerator = new Pdfgenerator();

        $file_pdf = $pdf_name;

        $this->data['title_pdf'] = $pdf_title;

        $this->data['produk'] = $pdf_data;

        $paper = $pdf_paper;

        $orientation = $pdf_orientation;

        $html = view($pdf_format, $this->data);

        $Pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
    }

    public function getSaldo()
    {
        if ($this->request->isAJAX()) {
            $no_pasien = $this->request->getVar('no_pasien');
            $no_registrasi = $this->request->getVar('no_registrasi');

            if (!$no_pasien) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'No. Pasien tidak ditemukan']);
            }

            if (!$no_registrasi) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'No. Registrasi tidak ditemukan - saldo deposit hanya berlaku untuk kunjungan ini']);
            }

            helper(['restclient']);

            $url = "{$this->server5}/api/Deposit/saldo/{$no_pasien}?noRegistrasi=" . urlencode($no_registrasi);

            try {
                $response = akses_restapikey('GET', $url, [], []);
                $result   = is_string($response) ? json_decode($response, true) : $response;

                if (isset($result['success']) && $result['success'] === true) {
                    return $this->response->setJSON([
                        'status' => 'success',
                        'data'   => $result['data'] ?? []
                    ]);
                } else {
                    return $this->response->setJSON([
                        'status'  => 'error',
                        'message' => $result['message'] ?? 'Gagal mengambil saldo deposit'
                    ]);
                }
            } catch (\Exception $e) {
                return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    public function getRiwayat()
    {
        if ($this->request->isAJAX()) {
            $no_pasien = $this->request->getVar('no_pasien');

            if (!$no_pasien) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'No. Pasien tidak ditemukan']);
            }

            helper(['restclient']);

            $url = "{$this->server5}/api/Deposit/riwayat/{$no_pasien}";

            try {
                $response = akses_restapikey('GET', $url, [], []);
                $result   = is_string($response) ? json_decode($response, true) : $response;

                if (isset($result['success']) && $result['success'] === true) {
                    return $this->response->setJSON([
                        'status' => 'success',
                        'data'   => $result['data'] ?? []
                    ]);
                } else {
                    return $this->response->setJSON([
                        'status'  => 'error',
                        'message' => $result['message'] ?? 'Gagal mengambil riwayat deposit'
                    ]);
                }
            } catch (\Exception $e) {
                return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    public function getDetailDeposit()
    {
        if ($this->request->isAJAX()) {
            $deposit_id = $this->request->getVar('deposit_id');

            if (!$deposit_id) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Deposit ID tidak ditemukan']);
            }

            helper(['restclient']);

            $url = "{$this->server5}/api/Deposit/{$deposit_id}";

            try {
                $response = akses_restapikey('GET', $url, [], []);
                $result   = is_string($response) ? json_decode($response, true) : $response;

                if (isset($result['success']) && $result['success'] === true) {
                    return $this->response->setJSON([
                        'status' => 'success',
                        'data'   => $result['data'] ?? []
                    ]);
                } else {
                    return $this->response->setJSON([
                        'status'  => 'error',
                        'message' => $result['message'] ?? 'Data deposit tidak ditemukan'
                    ]);
                }
            } catch (\Exception $e) {
                return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    public function simpanDeposit()
    {
        if ($this->request->isAJAX()) {
            helper(['form', 'restclient']);

            $valid = $this->validate([
                'no_pasien' => [
                    'label' => 'No. Pasien',
                    'rules' => 'required',
                ],
                'no_registrasi' => [
                    'label' => 'No. Registrasi',
                    'rules' => 'required',
                ],
                'jumlah_deposit' => [
                    'label' => 'Jumlah Deposit',
                    'rules' => 'required|numeric|greater_than[0]',
                ],
                'metode' => [
                    'label' => 'Metode Pembayaran',
                    'rules' => 'required',
                ],
            ]);

            if (!$valid) {
                $validation = \Config\Services::validation();
                return $this->response->setJSON([
                    'error' => [
                        'no_pasien'      => $validation->getError('no_pasien'),
                        'no_registrasi'  => $validation->getError('no_registrasi'),
                        'jumlah_deposit' => $validation->getError('jumlah_deposit'),
                        'metode'         => $validation->getError('metode'),
                    ]
                ]);
            }

            // Deposit adalah uang muka yang wajib habis di kunjungan/kwitansi yang sama
            // (dibatasi oleh NoRegistrasi, lihat DepositRepository), bukan berdasarkan
            // tanggal kedaluwarsa. Jadi berlakuHingga tidak lagi dipaksa "+1 tahun" -
            // biarkan null kecuali memang ada kebutuhan khusus mengirim tanggal tertentu.
            $berlaku_hingga = $this->request->getVar('berlaku_hingga');
            $berlaku_hingga_api = null;
            if (!empty($berlaku_hingga)) {
                $ts = strtotime($berlaku_hingga);
                $berlaku_hingga_api = $ts ? date('Y-m-d\TH:i:s.000\Z', $ts) : null;
            }

            $body = [
                'noPasien'      => $this->request->getVar('no_pasien'),
                'noRegistrasi'  => $this->request->getVar('no_registrasi'),
                'jumlahDeposit' => (float) $this->request->getVar('jumlah_deposit'),
                'metode'        => $this->request->getVar('metode'),
                'catatan'       => $this->request->getVar('catatan') ?? '',
                'berlakuHingga' => $berlaku_hingga_api,
                'createdBy'     => (string) ($this->session->get('usr_id') ?? ''),
            ];

            $url = "{$this->server5}/api/Deposit/simpan";

            try {
                $response = akses_restapikey('POST', $url, $body, []);
                $result   = is_string($response) ? json_decode($response, true) : $response;

                if (isset($result['success']) && $result['success'] === true) {
                    return $this->response->setJSON([
                        'success' => $result['message'] ?? 'Deposit berhasil disimpan',
                        'data'    => $result['data'] ?? []
                    ]);
                } else {
                    return $this->response->setJSON([
                        'error' => [
                            'jumlah_deposit' => $result['message'] ?? 'Gagal menyimpan deposit'
                        ]
                    ]);
                }
            } catch (\Exception $e) {
                return $this->response->setJSON(['error' => ['jumlah_deposit' => $e->getMessage()]]);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    public function gunakanDeposit()
    {
        if ($this->request->isAJAX()) {
            helper(['form', 'restclient']);

            $valid = $this->validate([
                'no_pasien' => [
                    'label' => 'No. Pasien',
                    'rules' => 'required',
                ],
                'no_registrasi' => [
                    'label' => 'No. Registrasi',
                    'rules' => 'required',
                ],
                'jumlah_digunakan' => [
                    'label' => 'Jumlah Digunakan',
                    'rules' => 'required|numeric|greater_than[0]',
                ],
            ]);

            if (!$valid) {
                $validation = \Config\Services::validation();
                return $this->response->setJSON([
                    'error' => [
                        'no_pasien'        => $validation->getError('no_pasien'),
                        'no_registrasi'    => $validation->getError('no_registrasi'),
                        'jumlah_digunakan' => $validation->getError('jumlah_digunakan'),
                    ]
                ]);
            }

            $body = [
                'noPasien'        => $this->request->getVar('no_pasien'),
                'noRegistrasi'    => $this->request->getVar('no_registrasi'),
                'noKwitansi'      => $this->request->getVar('no_kwitansi') ?? '',
                'jumlahDigunakan' => (float) $this->request->getVar('jumlah_digunakan'),
                'createdBy'       => (string) ($this->session->get('usr_id') ?? ''),
            ];

            $url = "{$this->server5}/api/Deposit/gunakan";

            try {
                $response = akses_restapikey('POST', $url, $body, []);
                $result   = is_string($response) ? json_decode($response, true) : $response;

                if (isset($result['success']) && $result['success'] === true) {
                    return $this->response->setJSON([
                        'success' => $result['message'] ?? 'Deposit berhasil digunakan',
                        'data'    => $result['data'] ?? []
                    ]);
                } else {
                    return $this->response->setJSON([
                        'error' => [
                            'jumlah_digunakan' => $result['message'] ?? 'Gagal menggunakan deposit'
                        ]
                    ]);
                }
            } catch (\Exception $e) {
                return $this->response->setJSON(['error' => ['jumlah_digunakan' => $e->getMessage()]]);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    public function batalDeposit()
    {
        if ($this->request->isAJAX()) {
            helper(['form', 'restclient']);

            $valid = $this->validate([
                'deposit_id' => [
                    'label' => 'Deposit ID',
                    'rules' => 'required',
                ],
                'alasan_batal' => [
                    'label' => 'Alasan Batal',
                    'rules' => 'required',
                ],
            ]);

            if (!$valid) {
                $validation = \Config\Services::validation();
                return $this->response->setJSON([
                    'error' => [
                        'deposit_id'   => $validation->getError('deposit_id'),
                        'alasan_batal' => $validation->getError('alasan_batal'),
                    ]
                ]);
            }

            $body = [
                'depositId'   => $this->request->getVar('deposit_id'),
                'alasanBatal' => $this->request->getVar('alasan_batal'),
                'updatedBy'   => (string) ($this->session->get('usr_id') ?? ''),
            ];

            $url = "{$this->server5}/api/Deposit/batal";

            try {
                $response = akses_restapikey('PATCH', $url, $body, []);
                $result   = is_string($response) ? json_decode($response, true) : $response;

                if (isset($result['success']) && $result['success'] === true) {
                    return $this->response->setJSON([
                        'success' => $result['message'] ?? 'Transaksi deposit berhasil dibatalkan',
                        'data'    => $result['data'] ?? []
                    ]);
                } else {
                    return $this->response->setJSON([
                        'error' => [
                            'alasan_batal' => $result['message'] ?? 'Gagal membatalkan transaksi'
                        ]
                    ]);
                }
            } catch (\Exception $e) {
                return $this->response->setJSON(['error' => ['alasan_batal' => $e->getMessage()]]);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    public function getKwitansiAktif()
    {
        if ($this->request->isAJAX()) {
            $no_registrasi = trim((string) $this->request->getVar('no_registrasi'));

            if (!$no_registrasi) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'No. Registrasi tidak ditemukan']);
            }

            try {
                $data = $this->apiDataGetBilling();

                $kandidat = [];
                if (is_array($data)) {
                    foreach ($data as $row) {
                        $rowRegistrasi = trim((string) ($row['no_registrasi'] ?? ''));

                        if (strcasecmp($rowRegistrasi, $no_registrasi) === 0) {
                            $kandidat[] = $row;
                        }
                    }
                }

                $aktif = array_values(array_filter($kandidat, function ($row) {
                    return strcasecmp(trim((string) ($row['status_kwitansi'] ?? '')), 'aktif') === 0;
                }));

                $pilihan = !empty($aktif) ? $aktif : $kandidat;

                if (!empty($pilihan)) {
                    usort($pilihan, function ($a, $b) {
                        return strtotime($b['tgl_kwitansi'] ?? '') <=> strtotime($a['tgl_kwitansi'] ?? '');
                    });

                    return $this->response->setJSON([
                        'status' => 'success',
                        'data'   => [
                            'no_kwitansi'     => $pilihan[0]['no_kwitansi'],
                            'status_kwitansi' => $pilihan[0]['status_kwitansi'] ?? null,
                        ]
                    ]);
                }

                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Kwitansi untuk registrasi ini tidak ditemukan'
                ]);
            } catch (\Exception $e) {
                return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    public function debugBilling()
    {
        $no_registrasi = trim((string) $this->request->getVar('no_registrasi'));
        $no_pasien     = trim((string) $this->request->getVar('no_pasien'));

        $data = $this->apiDataGetBilling();

        $filtered = [];
        if (is_array($data)) {
            foreach ($data as $row) {
                $matchRegistrasi = $no_registrasi ? (strcasecmp(trim((string) ($row['no_registrasi'] ?? '')), $no_registrasi) === 0) : true;
                $matchPasien     = $no_pasien ? (strcasecmp(trim((string) ($row['no_pasien'] ?? '')), $no_pasien) === 0) : true;

                if ($matchRegistrasi && $matchPasien) {
                    $filtered[] = $row;
                }
            }
        }

        return $this->response->setJSON([
            'total_billing_keseluruhan' => is_array($data) ? count($data) : 0,
            'filtered'                  => $filtered,
        ]);
    }

    public function getTagihanPembayaran()
    {
        if ($this->request->isAJAX()) {
            $no_kwitansi = $this->request->getVar('no_kwitansi');
            $no_pasien   = $this->request->getVar('no_pasien');

            if (!$no_kwitansi || !$no_pasien) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'No. Kwitansi / No. Pasien tidak ditemukan']);
            }

            helper(['restclient']);

            $url = "{$this->server5}/api/Payment/tagihan/{$no_kwitansi}/{$no_pasien}";

            try {
                $response = akses_restapikey('GET', $url, [], []);
                $result   = is_string($response) ? json_decode($response, true) : $response;

                if (isset($result['success']) && $result['success'] === true) {
                    return $this->response->setJSON([
                        'status' => 'success',
                        'data'   => $result['data'] ?? []
                    ]);
                } else {
                    return $this->response->setJSON([
                        'status'  => 'error',
                        'message' => $result['message'] ?? 'Gagal mengambil data tagihan'
                    ]);
                }
            } catch (\Exception $e) {
                return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    public function getRingkasanPembayaran()
    {
        if ($this->request->isAJAX()) {
            $no_kwitansi = $this->request->getVar('no_kwitansi');

            if (!$no_kwitansi) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'No. Kwitansi tidak ditemukan']);
            }

            helper(['restclient']);

            $url = "{$this->server5}/api/Payment/ringkasan/{$no_kwitansi}";

            try {
                $response = akses_restapikey('GET', $url, [], []);
                $result   = is_string($response) ? json_decode($response, true) : $response;

                if (isset($result['success']) && $result['success'] === true) {
                    return $this->response->setJSON([
                        'status' => 'success',
                        'data'   => $result['data'] ?? []
                    ]);
                } else {
                    return $this->response->setJSON([
                        'status'  => 'error',
                        'message' => $result['message'] ?? 'Gagal mengambil ringkasan pembayaran'
                    ]);
                }
            } catch (\Exception $e) {
                return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    public function payerList()
    {
        if ($this->request->isAJAX()) {
            helper(['restclient']);

            $search = $this->request->getVar('search');
            $url = "{$this->server5}/api/Payers/all" . ($search ? "?search=" . urlencode($search) : "");

            try {
                $response = akses_restapikey('GET', $url, [], []);
                $result   = is_string($response) ? json_decode($response, true) : $response;

                if (isset($result['success']) && $result['success'] === true) {
                    return $this->response->setJSON([
                        'status' => 'success',
                        'data'   => $result['data'] ?? []
                    ]);
                } else {
                    return $this->response->setJSON([
                        'status'  => 'error',
                        'message' => $result['message'] ?? 'Gagal mengambil data payer'
                    ]);
                }
            } catch (\Exception $e) {
                return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    public function prosesPembayaran()
    {
        if ($this->request->isAJAX()) {
            helper(['restclient']);

            $request = $this->request->getJSON(true);

            if (!$request || empty($request['noKwitansi']) || empty($request['noRegistrasi']) || empty($request['noPasien'])) {
                return $this->response->setJSON([
                    'error' => ['umum' => 'No. Kwitansi, No. Registrasi, dan No. Pasien wajib diisi.']
                ]);
            }

            if (empty($request['metodePembayaran']) || !is_array($request['metodePembayaran'])) {
                return $this->response->setJSON([
                    'error' => ['metodePembayaran' => 'Minimal satu metode pembayaran wajib diisi.']
                ]);
            }

            $body = [
                'noKwitansi'       => $request['noKwitansi'],
                'noRegistrasi'     => $request['noRegistrasi'],
                'noPasien'         => $request['noPasien'],
                'depositDigunakan' => (float) ($request['depositDigunakan'] ?? 0),
                'metodePembayaran' => $request['metodePembayaran'],
                'notes'            => $request['notes'] ?? '',
                'createdBy'        => (string) ($this->session->get('usr_id') ?? ''),
            ];

            $url = "{$this->server5}/api/Payment/proses";

            try {
                $response = akses_restapikey('POST', $url, $body, []);
                $result   = is_string($response) ? json_decode($response, true) : $response;

                if (isset($result['success']) && $result['success'] === true) {
                    return $this->response->setJSON([
                        'success' => $result['message'] ?? 'Pembayaran berhasil diproses',
                        'data'    => $result['data'] ?? []
                    ]);
                } else {
                    return $this->response->setJSON([
                        'error' => [
                            'umum' => $result['message'] ?? 'Gagal memproses pembayaran'
                        ]
                    ]);
                }
            } catch (\Exception $e) {
                return $this->response->setJSON(['error' => ['umum' => $e->getMessage()]]);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    public function getRiwayatPembayaran()
    {
        if ($this->request->isAJAX()) {
            $no_pasien = $this->request->getVar('no_pasien');

            if (!$no_pasien) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'No. Pasien tidak ditemukan']);
            }

            helper(['restclient']);

            $url = "{$this->server5}/api/Payment/riwayat/{$no_pasien}";

            try {
                $response = akses_restapikey('GET', $url, [], []);
                $result   = is_string($response) ? json_decode($response, true) : $response;

                if (isset($result['success']) && $result['success'] === true) {
                    return $this->response->setJSON([
                        'status' => 'success',
                        'data'   => $result['data'] ?? []
                    ]);
                } else {
                    return $this->response->setJSON([
                        'status'  => 'error',
                        'message' => $result['message'] ?? 'Gagal mengambil riwayat pembayaran'
                    ]);
                }
            } catch (\Exception $e) {
                return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    public function batalPembayaran($payment_id = null)
    {
        if ($this->request->isAJAX()) {
            if (!$payment_id) {
                $payment_id = $this->request->getVar('payment_id');
            }

            if (!$payment_id) {
                return $this->response->setJSON(['error' => ['payment_id' => 'Payment ID tidak ditemukan']]);
            }

            helper(['restclient']);

            $url = "{$this->server5}/api/Payment/batal/{$payment_id}";

            try {
                $response = akses_restapikey('DELETE', $url, [], []);
                $result   = is_string($response) ? json_decode($response, true) : $response;

                if (isset($result['success']) && $result['success'] === true) {
                    return $this->response->setJSON([
                        'success' => $result['message'] ?? 'Pembayaran berhasil dibatalkan',
                        'data'    => $result['data'] ?? []
                    ]);
                } else {
                    return $this->response->setJSON([
                        'error' => ['payment_id' => $result['message'] ?? 'Gagal membatalkan pembayaran']
                    ]);
                }
            } catch (\Exception $e) {
                return $this->response->setJSON(['error' => ['payment_id' => $e->getMessage()]]);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }
}
