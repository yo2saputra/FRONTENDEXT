<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;
use CodeIgniter\I18n\Time;

class PurchaseRequest extends BaseController
{

    protected $data;
    protected $server;
    protected $client;

    public function __construct()
    {
        $this->session = session();
        $uri = service('uri');
        $this->server = $_ENV['APP_API'];

        //set flag session
        $this->apiMenuFlag($this->apiMenuMenucd($uri->getSegment(1))[0]['menu_cd'], session()->get('role_cd'));

        $this->data = [
            'menu_header' => $this->apiMenuHeader(session()->get('usr_id')),
            'menu' => $this->apiMenu(session()->get('usr_id'))
        ];
    }

    public function index()
    {
        // helper dropdown
        helper(['dropdown']);

        // $this->data['cb_pasien'] = getDropdownPasien2('patient_no', 'Pasien', 2, 4); // (id,Label,label size, input size)
        // $this->data['cb_tujuan'] = getDropdownCustomFilter('tujuan_registrasi', 'tujuan_registrasi', 'Tujuan Registrasi', 2, 4, ['dokter']); // (key,id,Label,label size, input size, filter)
        // $this->data['cb_pasien2'] = getDropdownPasienCustom('patient_no', 'patient_no_v', 'Pasien', 2, 4); // (key,id,Label,label size, input size)
        // $this->data['cb_tujuan2'] = getDropdownCustom('tujuan_registrasi', 'tujuan_registrasi_v', 'Tujuan Registrasi', 2, 4); // (key,id,Label,label size, input size)
        // $this->data['cb_type_pasien'] = getDropdown2('Tipe_Pasien', 'Tipe Pasien', 2, 4); // (id,Label,label size, input size)
        // $this->data['cb_type_pasien2'] = getDropdownCustom('Tipe_Pasien', 'Tipe_Pasien_v', 'Tipe Pasien', 2, 4); // (key,id,Label,label size, input size)
        // $this->data['cb_asuransi'] = getDropdownAsuransiCustomFilter('asr_cd', 'asr_cd', 'Asuransi', 2, 4, []); // (key,id,Label,label size, input size)
        // $this->data['cb_asuransi2'] = getDropdownAsuransiCustomFilter('asr_cd', 'asr_cd_v', 'Asuransi', 2, 4, []); // (key,id,Label,label size, input size)
        $this->data['cb_pajak'] = getDropdownCustom('pajak_sta', 'detailPajak', 'Pajak', 2, 4); // (key,id,Label,label size, input size)
        $this->data['cb_satuan'] = getDropdownCustom('satuan_obat', 'detailSatuan', 'Satuan', 2, 2); // (key,id,Label,label size, input size)
        $this->data['cb_tipe'] = getDropdownCustom('tipe_produk', 'detailTipe', 'Tipe', 2, 4); // (key,id,Label,label size, input size)
        $this->data['cb_distributor'] = getDropdownSupplierCustom('supplierID', 'detailDistributor', 'Distributor', 2, 4); // (key,id,Label,label size, input size)
        $this->data['cb_principal'] = getDropdownPrincipalCustom('principal_cd', 'detailPrincipal', 'Principal', 2, 4); // (key,id,Label,label size, input size)
        $this->data['cb_obat'] = getDropdownObatCustomFilter('obat_cd', 'detailKode', 'Produk', 2, 4, ['dokter']); // (key,id,Label,label size, input size, filter)


        return view('purchaserequest/index', $this->data);
    }

    public function edit()
    {
        return view('purchaserequest/edit', $this->data);
    }

    public function apiDataGetAll()
    {

        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/tregistrasi/getallop";

        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);
        return $data['response_data'];
    }

    public function apiDataGetRegistrasiPm()
    {

        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/list/registrasipm";

        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);
        return $data['response_data'];
    }

    public function apiDataGetItem()
    {

        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/list/item";

        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);
        return $data['response_data'];
    }

    public function apiDataGetPrincipal()
    {

        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/list/principal";

        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);
        return $data['response_data'];
    }

    public function apiDataGetSupplier()
    {

        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/list/supplier";

        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);
        return $data['response_data'];
    }

    public function apiDataGetBranch()
    {

        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/list/branch";

        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);
        return $data['response_data'];
    }

    public function apiDataGetWarehouse()
    {

        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/list/warehouse";

        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);
        return $data['response_data'];
    }

    public function apiDataGetBilling()
    {

        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/billing/getall";

        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);
        return $data['response_data'];
    }

    public function fetchAll()
    {
        // if ($this->request->isAJAX()) {

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
                    // "responsive": true, "lengthChange": false, "autoWidth": false,
                    columnDefs: [{
                        orderable: false,
                        targets: 9
                    }],
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    // "columns": [
                    //   { "width": "10%" }, null, null, null, nuul, null
                    // ],
                    "buttons": [{
                            text: "Tambah data",
                            action: function(e, dt, node, config) {
                                // alert("Button activated");
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
                        // "sInfo": "_START_ untuk _END_ dari _TOTAL_ data",
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
        // } else {
        //     exit('Maaf tidak dapat diproses!');
        // }
    }

    function fetchDataKasirListRegistrasi()
    {
        $output = '';
        $data = $this->apiDataGetRegistrasiPm();
        $output .= '  
		           <table id="example4" class="table table-sm table-hover" style="width:100%">
				   <thead>
		                <tr>  
		                    <th >NO</th>  
		                    <th >Pasien</th>  
		                    <th >Dokter</th>
                            <th >Tgl Lahir</th>
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
		                <tr id="addRowRegistrasi" data-id="' . $row["no_registrasi"] . '">  
		                    <td class="text-uppercase">' . $row["no_registrasi"] . '</td>  
		                    <td class="text-uppercase">' . $row["pasien"] . '</td>  
                            <td class="text-uppercase">' . $row["dokter"] . '</td>
                            <td class="text-uppercase">' . date('d/m/Y', strtotime($row["birth_dt"])) . '</td> 
                            <td class="text-right">
                                    <div class="btn-group">
                                    <a data-toggle="tooltip" data-placement="top" title="Add" class="btn btn-sm btn-success addRegistrasi ' . ($this->session->get("flag_insert") === 1 ? "" : "d-none") . '" data-id="' . $row["no_registrasi"] . '" data-no_kwitansi="' . $row["no_kwitansi"] . '"><i class="fas fa-plus"></i></a>
                                    </div>
                            </td>
		                </tr>  
		           ';
            }
        }
        $output .= '</table>
			  <script type="text/javascript">
			  $(function () {
				$("#example4").DataTable({
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
		                     </tr>';
        } else {
            foreach ($data as $row) {
                $output .= '  
		                <tr id="addRowItem" data-id="' . $row["no_kwitansi"] . '">  
		                    <td class="text-uppercase addItem" data-id="' . $row["no_kwitansi"] . '">' . $row["no_kwitansi"] . '</td>  
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

                // helper curl request
                helper(['restclient']);

                // end point
                $url = "$this->server/tregistrasi/getby/$no_registrasi";

                // client request
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

    function fetchAllItems()
    {
        // if ($this->request->isAJAX()) {

        $no_registrasi = $this->request->getVar('no_registrasi');
        // $no_registrasi = 'REG240500178';

        if ($no_registrasi) {

            // helper curl request
            helper(['restclient']);

            // end point
            $url = "$this->server/billingdetail/getbynoregistrasi/$no_registrasi";

            // client request
            $response = akses_restapi('GET', $url, []);
            // $data['response_data'] = json_decode($response, true);

            // $msg = [
            //     'data' => [
            //         'no_kwitansi' => $data["response_data"][0]["no_kwitansi"],
            //         'item_cd' => $data["response_data"][0]["item_cd"],
            //         'jumlah' => $data["response_data"][0]["jumlah"],
            //         'tarif' => $data["response_data"][0]["tarif"],
            //         'potongan' => $data["response_data"][0]["potongan"],
            //         'pajak' => $data["response_data"][0]["pajak"],
            //         'total' => $data["response_data"][0]["total"]
            //     ]
            // ];

            // $msg = [
            //     'data' => [
            //         'no_kwitansi' => $data["response_data"][0]["no_kwitansi"],
            //         'item_cd' => $data["response_data"][0]["item_cd"],
            //         'jumlah' => $data["response_data"][0]["jumlah"],
            //         'tarif' => $data["response_data"][0]["tarif"],
            //         'potongan' => $data["response_data"][0]["potongan"],
            //         'pajak' => $data["response_data"][0]["pajak"],
            //         'total' => $data["response_data"][0]["total"]
            //     ]
            // ];

            // echo json_encode($msg);
            echo $response;
        }
        // } else {
        //     exit('Maaf tidak dapat diproses!');
        // }
    }

    public function hadir()
    {
        if ($this->request->isAJAX()) {
            $no_registrasi = $this->request->getVar('no_registrasi');

            // helper curl request
            helper(['restclient']);

            // endpoint
            $url = "$this->server/tregistrasi/hadir/$no_registrasi";

            // client request
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

            // helper curl request
            helper(['restclient']);

            // endpoint
            $url = "$this->server/tregistrasi/batal/$no_registrasi";

            // client request
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

            // helper curl request
            helper(['restclient']);

            // endpoint
            $url = "$this->server/tregistrasi/delete/$no_registrasi";

            // client request
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
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'tujuan_registrasi' => [
                        'label' => 'Tujuan',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'Tipe_Pasien' => [
                        'label' => 'Tipe Pasien',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'asr_cd' => [
                        'label' => 'Asuransi',
                        'rules' => $this->request->getVar('Tipe_Pasien') === 'ASRN' ? 'required' : 'permit_empty',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'kode_dokter' => [
                        'label' => 'Dokter',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
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

                        // helper curl request
                        helper(['restclient']);

                        // endpoint
                        $url = "$this->server/tregistrasi/insert";

                        // form params
                        $data = [
                            "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('no_registrasi'))),
                            "no_pasien" => str_replace(" ", "_", trim($this->request->getVar('no_pasien'))),
                            "type_pasien" => $this->request->getVar('Tipe_Pasien'),
                            "asr_cd" => $this->request->getVar('asr_cd'),
                            // "reference" => $this->request->getVar('reference'),
                            // "deleted" => ($this->request->getVar('deleted') == FALSE) ? 0 : 1,
                            // "header_id" => $this->request->getVar('id'),
                            // "menu_order" => $this->request->getVar('menu_order'),
                            // "menu_icon" => $this->request->getVar('menu_icon')
                        ];
                        // client request
                        $response = akses_restapi('POST', $url, $data);

                        $msg = [
                            'success' => 'data berhasil di create!'
                        ];
                    }

                    if ($this->request->getVar('action') == 'Registrasi') {

                        // helper curl request
                        helper(['restclient']);

                        // endpoint
                        $url = "$this->server/tregistrasi/insert";

                        // form params
                        $data = [
                            // "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('no_registrasi'))),
                            "no_registrasi" => '',
                            "no_pasien" => str_replace(" ", "_", trim($this->request->getVar('patient_no'))),
                            "tgl_registrasi" => $this->request->getVar('tgl_registrasi'),
                            // "deleted" => ($this->request->getVar('deleted') == FALSE) ? 0 : 1,
                            // "registrasi_via" => $this->request->getVar('registrasi_via'),
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
                        // client request
                        $response = akses_restapi('POST', $url, $data);

                        $msg = [
                            'success' => 'data berhasil di create!'
                        ];
                    }

                    if ($this->request->getVar('action') == 'Edit') {

                        // helper curl request
                        helper(['restclient']);

                        // endpoint
                        $url = "$this->server/tregistrasi/update";

                        // form params
                        $data = [
                            "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('no_registrasi'))),
                            "no_pasien" => str_replace(" ", "_", trim($this->request->getVar('no_pasien'))),
                            // "reference" => $this->request->getVar('reference'),
                            // "deleted" => ($this->request->getVar('deleted') == FALSE) ? 0 : 1,
                            // "header_id" => $this->request->getVar('id'),
                            // "menu_order" => $this->request->getVar('menu_order'),
                            // "menu_icon" => $this->request->getVar('menu_icon')
                        ];
                        // client request
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

                // helper curl request
                helper(['restclient']);

                // end point
                $url = "$this->server/tmstitem/tarifgetby/$item_cd";

                // client request
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

        // helper dropdown
        helper(['dropdown']);

        $poli = $this->request->getVar('poli');

        $cb_dokter = getDropdownDokterCustomTree($poli); // (key,id,Label,label size, input size);

        return $cb_dokter;
    }

    function getPRDetailLastestPrice()
    {
        if ($this->request->isAJAX()) {

            $obat_cd = $this->request->getVar('obat_cd');
            $BranchID = $this->request->getVar('BranchID');
            $SupplierID = $this->request->getVar('SupplierID');
            $principal_cd = $this->request->getVar('principal_cd');

            if (!empty($obat_cd) && !empty($BranchID) && !empty($SupplierID) && !empty($principal_cd)) {

                // helper curl request
                helper(['restclient']);

                // end point
                $url = "$this->server/purchaserequestdetail/getprdetaillatestprice/$obat_cd/$BranchID/$SupplierID/$principal_cd";

                // client request
                $response = akses_restapi('GET', $url, []);
                $data['response_data'] = json_decode($response, true);

                $msg = [
                    'data' => [
                        'HNA' => $data["response_data"][0]["hna"],
                        'HargaUnit' => $data["response_data"][0]["hargaUnit"],
                        'Diskon' => $data["response_data"][0]["diskon"],
                        'Bonus' => $data["response_data"][0]["bonus"]
                    ]
                ];

                echo json_encode($msg);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    public function store()
    {
        // if ($this->request->isAJAX()) {
        $request = $this->request->getJSON(true);


        if (!empty($request) && is_array($request)) {

            // helper curl request
            helper(['restclient']);

            // endpoint
            $urlbilling = "$this->server/notransaksi/purchaserequest";
            // client request
            $response = akses_restapi('GET', $urlbilling, []);
            $prid = json_decode($response, true);

            // Merubah status
            // $no_registrasi = $this->session->get('no_registrasi_deposit');
            // $url = "$this->server/tregistrasi/deposit/$no_registrasi";
            // $response = akses_restapi('PATCH', $url, []);
            // $data['response_data'] = json_decode($response, true);

            // $sumTotal = 0;
            // foreach ($request as $itemloop) {
            //     $sumTotal += $itemloop->subtotal;
            // }

            // form params
            // Insert Header (Purchase Request)
            $databilling = [
                'PRID' => $prid[0]['generated'],
                'TanggalPR' => date("Y-m-d"),
                'TanggalStartPR' => \CodeIgniter\I18n\Time::createFromFormat('d-m-Y', $request['tglStart'])->toDateString(),
                'TanggalEndPR' => \CodeIgniter\I18n\Time::createFromFormat('d-m-Y', $request['tglEnd'])->toDateString(),
                'TotalPR' => 0,
                'StatusPR' => 'A',
                'Keterangan' => '',
                'RequestBy' => '',
                'emp_cd' => $this->session->get('usr_id'),
            ];

            // Kirim header ke API
            $urlbilling = "$this->server/purchaserequest/insert";
            akses_restapi('POST', $urlbilling, $databilling);

            // **Insert setiap detail satu per satu**
            if (!empty($request['details']) && is_array($request['details'])) {
                foreach ($request['details'] as $item) {
                    $databillingdetail = [
                        'PRID' => $prid[0]['generated'],
                        'obat_cd' => $item['kode'],
                        'Jumlah' => $item['qty'],
                        'HargaUnit' => $item['harga'],
                        'BranchID' => 'BR001',
                        'SupplierID' => $item['distributor'],
                        'HNA' => $item['hna'],
                        'Bonus' => $item['bonus'],
                        'Diskon' => $item['diskon'],
                        'Pajak' => $item['pajak'],
                        'Tipe' => $item['tipe'],
                        'DiskonOff' => $item['diskon_off'],
                        'principal_cd' => $item['principal'],
                    ];

                    $urlbillingdetail = "$this->server/purchaserequestdetail/insert";
                    akses_restapi('POST', $urlbillingdetail, $databillingdetail);
                }
            }

            // // helper curl request
            // helper(['restclient']);

            // // endpoint
            // $url = "$this->server/tregistrasi/deposit/$no_registrasi";

            // // client request
            // $response = akses_restapi('PATCH', $url, []);
            // $data['response_data'] = json_decode($response, true);


            $msg = [
                'success' => 'data berhasil diupdate',
                'prid' => 0
            ];

            // $msg = substr("$response", 1, 12);

            echo json_encode($databillingdetail);

            // return $this->response->setJSON(['status' => 'success', 'message' => 'Data has been inserted successfully.']);
        }

        // return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid JSON data.' . $no]);
        // } else {
        //     exit('Maaf tidak dapat diproses!');
        // }
    }

    public function setNoRegistrasi()
    {
        if ($this->request->isAJAX()) {
            $this->session->set(["no_registrasi_pembayaran" => $this->request->getVar('no_registrasi')]);
            $this->session->set(["no_kwitansi_pembayaran" => $this->request->getVar('no_kwitansi')]);
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
            $this->session->remove("no_registrasi_pembayaran");
            $this->session->remove("no_kwitansi_pembayaran");
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

            // helper curl request
            helper(['restclient']);
            // end point
            $url = "$this->server/billing/printby/$no_kwitansi";
            // client request
            $response = akses_restapi('GET', $url, []);
            $data['response_data'] = json_decode($response, true);

            $pdf_data = $data['response_data'];
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
        // helper curl request
        helper(['restclient']);
        // end point
        $url = "$this->server/pasien/getby/23090001";
        // client request
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

        // filename dari pdf ketika didownload
        $file_pdf = $pdf_name;

        // title dari pdf
        $this->data['title_pdf'] = $pdf_title;

        //data
        $this->data['produk'] = $pdf_data;

        // setting paper
        $paper = $pdf_paper;

        //orientasi paper potrait / landscape
        $orientation = $pdf_orientation;

        $html = view($pdf_format, $this->data);

        // run dompdf
        $Pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
    }
}
