<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;
use CodeIgniter\I18n\Time;

class PurchaseRequestApproval extends BaseController
{

    protected $data;
    protected $server;
    protected $client;

    public function __construct()
    {
        $this->session = session();
        $uri = service('uri');
        $this->server = $_ENV['APP_API'];
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
        $this->data['cb_satuan'] = getDropdownCustom('satuan_obat', 'detailSatuan', 'Satuan', 2, 4); // (key,id,Label,label size, input size)
        $this->data['cb_tipe'] = getDropdownCustom('tipe_produk', 'detailTipe', 'Tipe', 2, 4); // (key,id,Label,label size, input size)
        $this->data['cb_distributor'] = getDropdownSupplierCustom('supplierID', 'detailDistributor', 'Distributor', 2, 4); // (key,id,Label,label size, input size)
        $this->data['cb_principal'] = getDropdownPrincipalCustom('principal_cd', 'detailPrincipal', 'Principal', 2, 4); // (key,id,Label,label size, input size)
        $this->data['cb_obat'] = getDropdownObatCustomFilter('obat_cd', 'detailKode', 'Produk', 2, 4, ['dokter']); // (key,id,Label,label size, input size, filter)


        return view('purchaserequestapproval/index', $this->data);
    }

    public function edit()
    {
        return view('purchaserequestapproval/edit', $this->data);
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

    public function apiDataGetPurchaseRequest()
    {

        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/list/purchaserequest";

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

    function search()
    {
        if ($this->request->isAJAX()) {

            // $no_pasien = $this->request->getVar('no_pasien');
            $tgl1 = date("Y-m-d", strtotime($this->request->getVar('tgl_praktek1')));
            $tgl2 = date("Y-m-d", strtotime($this->request->getVar('tgl_praktek2')));

            // Set Session 
            // $this->session->set(["no_pasien" => $no_pasien]);
            $this->session->set(["tgl1" => $tgl1]);
            $this->session->set(["tgl2" => $tgl2]);

            // helper curl request
            helper(['restclient']);

            // end point
            $url = "$this->server/list/search/$tgl1/$tgl2";

            // client request
            $response = akses_restapi('GET', $url, []);
            $data['response_data'] = json_decode($response, true);

            $output = '';
            $data = $data['response_data'];
            $output .= ' <div class="table-wrapper" style="height:100px; overflow-y:auto;">
            <table id="example5" class="table table-sm table-hover w-100" style="table-layout: fixed;">
				   <thead  class="thead-light" style="z-index:1;">
		                <tr>  
		                    <th >ID</th>
                            <th >Status</th>
                            <th >Created</th>
                            <th ></th>
		                </tr>
					</thead>
                    <tbody>
						';
            if ($data == '') {
                $output .= '<tr>  
                            <td >Data not Found</td>
                            <td ></td>
                            <td ></td>
                            <td ></td>
                        </tr>';
            } else {
                foreach ($data as $row) {
                    $output .= '  
		                <tr id="addRowItem" data-id="' . $row["prid"] . '">  
		                    <td class="text-uppercase addItem" data-id="' . $row["prid"] . '">' . $row["prid"] . '</td>   
                            <td class="text-uppercase">' . $row["statusPR"] . '</td>
                            <td class="text-uppercase">' . $row["emp_cd"] . '</td>
                            <td class="text-right">
                                    <div class="btn-group">
                                    <a data-toggle="tooltip" data-placement="top" title="Add" class="btn btn-xs btn-success addItem ' . ($this->session->get("flag_insert") === 1 ? "" : "d-none") . '" data-id="' . $row["prid"] . '"><i class="fas fa-plus"></i></a>
                                    </div>
                            </td>
		                </tr>  
		           ';
                }
            }
            $output .= '</tbody></table></div>
			  <script type="text/javascript">
              // let table; // deklarasi di scope global agar bisa diakses di mana saja
                $(function () {
                    table = $("#example5").DataTable({
                    dom: "lrtip", // ✅ hilangkan search box bawaan (hapus "f")
                    paging: false,
                    lengthChange: false,
                    searching: true,
                    ordering: false,
                    info: false,
                    pageLength: 3,
                    lengthMenu: [3, 5, 10, 25, 50, 100],
                    autoWidth: false
                    });

                    // Event handler custom search di dalam $(function) agar aman
                    $("#customSearch").on("keyup", function () {
                    table.search(this.value).draw();
                    });
                });

		       </script>
			   ';
            echo $output;
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    function fetchDataPurchaseRequestListPR()
    {
        $output = '';
        $data = $this->apiDataGetPurchaseRequest();
        $output .= ' <div class="table-wrapper" style="height:100px; overflow-y:auto;">
        <table id="example5" class="table table-sm table-hover w-100" style="table-layout: fixed;">
				   <thead  class="thead-light" style="z-index:1;">
		                <tr>  
		                    <th >ID</th>
                            <th >Status</th>
                            <th >Created</th>
                            <th ></th>
		                </tr>
					</thead>
                    <tbody>
						';
        if ($data == '') {
            $output .= '<tr>  
                            <td >Data not Found</td>
                            <td ></td>
                            <td ></td>
                            <td ></td>
                        </tr>';
        } else {
            foreach ($data as $row) {
                $output .= '  
		                <tr id="addRowItem" data-id="' . $row["prid"] . '">  
		                    <td class="text-uppercase addItem" data-id="' . $row["prid"] . '">' . $row["prid"] . '</td>   
                            <td class="text-uppercase">' . $row["statusPR"] . '</td>
                            <td class="text-uppercase">' . $row["emp_cd"] . '</td>
                            <td class="text-right">
                                    <div class="btn-group">
                                    <a data-toggle="tooltip" data-placement="top" title="Add" class="btn btn-xs btn-success addItem ' . ($this->session->get("flag_insert") === 1 ? "" : "d-none") . '" data-id="' . $row["prid"] . '"><i class="fas fa-plus"></i></a>
                                    </div>
                            </td>
		                </tr>  
		           ';
            }
        }
        $output .= '</tbody></table></div>
			  <script type="text/javascript">
              let table; // deklarasi di scope global agar bisa diakses di mana saja
                $(function () {
                    table = $("#example5").DataTable({
                    dom: "lrtip", // ✅ hilangkan search box bawaan (hapus "f")
                    paging: false,
                    lengthChange: false,
                    searching: true,
                    ordering: false,
                    info: false,
                    pageLength: 3,
                    lengthMenu: [3, 5, 10, 25, 50, 100],
                    autoWidth: false
                    });

                    // Event handler custom search di dalam $(function) agar aman
                    $("#customSearch").on("keyup", function () {
                    table.search(this.value).draw();
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
        // if ($this->request->isAJAX()) {

        $prid = $this->request->getVar('prid');


        if ($prid) {

            // helper curl request
            helper(['restclient']);

            // end point
            $url = "$this->server/purchaserequest/headerdetail/$prid";
            // client request
            $response = akses_restapi('GET', $url, []);
            // $data['response_data'] = json_decode($response, true);


            // $data = json_decode('[{"prid":"PR250500022","tanggalPR":"5/22/2025 12:00:00 AM","tanggalStartPR":"5/22/2025 12:00:00 AM","tanggalEndPR":"5/22/2025 12:00:00 AM","totalPR":0,"statusPR":"A","keterangan":"","requestBy":"","emp_cd":"amira","details":[{"prid":"PR250500022","obat_cd":"OB00001","jumlah":"10.00","hargaUnit":"1000.00","branchID":"BR001","supplierID":"SUP001","hna":"1000.00","bonus":"0.00","diskon":"0.00","pajak":"11","tipe":"JUAL","diskonOff":"0.00","principal_cd":"PR00001"}]}]}', true);

            $data = json_decode($response, true);

            // Mengambil detail dari respons API
            $details = isset($data[0]["details"]) ? $data[0]["details"] : [];

            // Format ulang data
            $msg = [
                'prid' => $data[0]["prid"] ?? null,
                'tglStart' => $data[0]["tanggalStartPR"] ?? null,
                'tglEnd' => $data[0]["tanggalEndPR"] ?? null,
                'details' => array_map(function ($detail) {
                    return [
                        'prid' => $detail["prid"] ?? null,
                        'kode' => $detail["obat_cd"] ?? null,
                        'distributor' => $detail["supplierID"] ?? null,
                        'principal' => $detail["principal_cd"] ?? null,
                        'qty' => $detail["jumlah"] ?? null,
                        'harga' => $detail["hargaUnit"] ?? null,
                        'hna' => $detail["hna"] ?? null,
                        'bonus' => $detail["bonus"] ?? null,
                        'diskon' => $detail["diskon"] ?? null,
                        'pajak' => $detail["pajak"] ?? null,
                        'tipe' => $detail["tipe"] ?? null,
                        'diskon_off' => $detail["diskonOff"] ?? null,
                        'subtotal' => 0,
                        'satuan' => $detail["satuan"] ?? null,
                        'satuanhd' => $detail["satuanHD"] ?? null,
                        'supplierhd' => $detail["supplierHD"] ?? null,
                        'principalhd' => $detail["principalHD"] ?? null,
                        'produk' => $detail["produkHD"] ?? null,
                        'distributorhd' => $detail["supplierHD"] ?? null,
                        'qtyapproved' => $detail["jumlahDisetujui"] ?? null,
                        // 'staapproved' => $detail["approveSta"] ?? null,
                    ];
                }, $details)
            ];

            echo json_encode($msg);
        }
        // } else {
        //     exit('Maaf tidak dapat diproses!');
        // }
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
                'PRID' => $request['prid'],
                // 'TanggalPR' => date("Y-m-d"),
                // 'TanggalStartPR' => \CodeIgniter\I18n\Time::createFromFormat('d-m-Y', $request['tglStart'])->toDateString(),
                // 'TanggalEndPR' => \CodeIgniter\I18n\Time::createFromFormat('d-m-Y', $request['tglEnd'])->toDateString(),
                // 'SupplierID' => 'SUP001',
                // 'TotalPR' => 0,
                'StatusPR' => 0,
                // 'Keterangan' => '',
                // 'BranchID' => 'BR001',
            ];

            // Kirim header ke API
            $urlbilling = "$this->server/purchaserequest/update";
            akses_restapi('POST', $urlbilling, $databilling);

            // print_r($request['details'][0]);

            // **Insert setiap detail satu per satu**
            if (!empty($request['details']) && is_array($request['details'])) {
                foreach ($request['details'] as $item) {

                    $databillingdetail = [
                        // 'PRID' => $prid[0]['generated'],
                        'PRID' => $item['prid'],
                        'obat_cd' => $item['kode'],
                        // 'ProdukHD' => $item['produk'],
                        // 'Jumlah' => $item['qty'],
                        // 'Satuan' => $item['satuan'],
                        // 'SatuanHD' => $item['satuanhd'],
                        // 'HargaUnit' => $item['harga'],
                        // 'BranchID' => 'BR001',
                        // 'SupplierID' => $item['distributor'],
                        // 'SupplierHD' => $item['distributorhd'],
                        // 'HNA' => $item['hna'],
                        // 'Bonus' => $item['bonus'],
                        // 'Diskon' => $item['diskon'],
                        // 'Pajak' => $item['pajak'],
                        // 'Tipe' => $item['tipe'],
                        // 'DiskonOff' => $item['diskon_off'],
                        // 'principal_cd' => $item['principal'],
                        // 'PrincipalHD' => $item['principalhd'],
                        'JumlahDisetujui' => $item['qtyapproved'],
                        // 'ApproveSta' => $item['staapproved'],
                    ];

                    $urlbillingdetail = "$this->server/purchaserequestdetail/update";
                    akses_restapi('PUT', $urlbillingdetail, $databillingdetail);
                }
            }


            /*
            if (!empty($request['details']) && is_array($request['details'])) {
                $groupedData = [];

                // Mengelompokkan data berdasarkan distributor
                foreach ($request['details'] as $item) {
                    $supplierID = $item['distributor'];

                    if (!isset($groupedData[$supplierID])) {
                        $groupedData[$supplierID] = [];
                    }

                    $groupedData[$supplierID][] = $item;
                }

                // Looping melalui setiap grup distributor
                foreach ($groupedData as $supplierID => $details) {
                    foreach ($details as $item) {
                        $databillingdetail = [
                            'PRID' => $item['prid'],
                            'obat_cd' => $item['kode'],
                            'ProdukHD' => $item['produk'],
                            'Jumlah' => $item['qty'],
                            'Satuan' => $item['satuan'],
                            'SatuanHD' => $item['satuanhd'],
                            'HargaUnit' => $item['harga'],
                            'BranchID' => 'BR001',
                            'SupplierID' => $item['distributor'],
                            'SupplierHD' => $item['distributorhd'],
                            'HNA' => $item['hna'],
                            'Bonus' => $item['bonus'],
                            'Diskon' => $item['diskon'],
                            'Pajak' => $item['pajak'],
                            'Tipe' => $item['tipe'],
                            'DiskonOff' => $item['diskon_off'],
                            'principal_cd' => $item['principal'],
                            'PrincipalHD' => $item['principalhd'],
                            'JumlahDisetujui' => $item['qtyapproved'],
                            'ApproveSta' => isset($item['staapproved']) ? $item['staapproved'] : null,
                        ];

                        $urlbillingdetail = "$this->server/purchaserequestdetail/insert";
                        akses_restapi('PUT', $urlbillingdetail, $databillingdetail);
                    }
                }
            }
            

            // **Ambil ID baru dari API untuk setiap grup**
            $urlpo = "$this->server/notransaksi/approval";
            $response = akses_restapi('GET', $urlpo, []);
            $poid = json_decode($response, true);

            // Insert Header (Approval)
            $dataapproval = [
                'ApprovalID' => $poid[0]['generated'], // ID yang diperoleh dari API
                'TransactionType' => date("Y-m-d"),
                'TransactionID' => date("Y-m-d"),
                'ApprovedBy' => date("Y-m-d"),
                'ApprovalStatus' => date("Y-m-d"),
                'ApprovalDate' => date("Y-m-d"),
                'Remarks' => date("Y-m-d"),
            ];

            // Kirim header ke API
            $urlapproval = "$this->server/approval/insert";
            akses_restapi('POST', $urlapproval, $dataapproval);
            */

            /*
            $datapodetail = [
                'POID' => 'PO250600004',  // **ID unik diambil dalam setiap iterasi grup**
                // 'PRID' => $item['prid'],
                'obat_cd' => 'OB00001',
                'ProdukHD' => '19',
                'Jumlah' => 10,
                'Satuan' => '',
                'SatuanHD' => '',
                'HargaUnit' => 1000,
                'BranchID' => 'BR001',
                'SupplierID' => 'SUP001',
                'SupplierHD' => 'PT Sumber Jaya',
                'HNA' => 1000,
                'Bonus' => 0,
                'Diskon' => 0,
                'Pajak' => 11,
                'Tipe' => 'JUAL',
                'DiskonOff' => 0,
                'principal_cd' => 'PR00001',
                'PrincipalHD' => 'BAYER',
                // 'JumlahDisetujui' => 10,
                'ApproveSta' => isset($item['staapproved']) ? $item['staapproved'] : null,
            ];

            $urlpodetail = "$this->server/purchaseorderdetail/insert";
            akses_restapi('POST', $urlpodetail, $datapodetail);
            */


            if (!empty($request['details']) && is_array($request['details'])) {
                $groupedData = [];
                $prid = $request['prid'];

                // Mengelompokkan data berdasarkan distributor
                foreach ($request['details'] as $item) {
                    $supplierID = $item['distributor'];

                    if (!isset($groupedData[$supplierID])) {
                        $groupedData[$supplierID] = [];
                    }

                    $groupedData[$supplierID][] = $item;
                }

                // Looping melalui setiap grup distributor
                foreach ($groupedData as $supplierID => $details) {
                    // **Ambil ID baru dari API untuk setiap grup**
                    $urlpo = "$this->server/notransaksi/purchaseorder";
                    $response = akses_restapi('GET', $urlpo, []);
                    $poid = json_decode($response, true);
                    $poid_generated = $poid[0]['generated'];


                    // form params
                    // Insert Header (Purchase Request)

                    $datapo = [
                        'POID' => $poid_generated, // ID yang diperoleh dari API
                        'TanggalPO' => date("Y-m-d"),
                        // 'TanggalStartPR' => \CodeIgniter\I18n\Time::createFromFormat('d-m-Y', $request['tglStart'])->toDateString(),
                        // 'TanggalEndPR' => \CodeIgniter\I18n\Time::createFromFormat('d-m-Y', $request['tglEnd'])->toDateString(),
                        // 'SupplierID' => 'SUP001',
                        'TotalPO' => 0,
                        'StatusPO' => 0,
                        'Keterangan' => '',
                        'emp_cd' => 'amira',
                    ];

                    // Kirim header ke API
                    $urlpo = "$this->server/purchaseorder/insert";
                    akses_restapi('POST', $urlpo, $datapo);

                    foreach ($details as $item) {
                        /*
                        $datapodetail = [
                            'POID' => 'PO250600004',  // **ID unik diambil dalam setiap iterasi grup**
                            // 'PRID' => $item['prid'],
                            'obat_cd' => 'OB00001',
                            'ProdukHD' => '19',
                            'Jumlah' => 10,
                            'Satuan' => '',
                            'SatuanHD' => '',
                            'HargaUnit' => 1000,
                            'BranchID' => 'BR001',
                            'SupplierID' => 'SUP001',
                            'SupplierHD' => 'PT Sumber Jaya',
                            'HNA' => 1000,
                            'Bonus' => 0,
                            'Diskon' => 0,
                            'Pajak' => 11,
                            'Tipe' => 'JUAL',
                            'DiskonOff' => 0,
                            'principal_cd' => 'PR00001',
                            'PrincipalHD' => 'BAYER',
                            // 'JumlahDisetujui' => 10,
                            'ApproveSta' => isset($item['staapproved']) ? $item['staapproved'] : null,
                        ];
                        

                        
                        $datapodetail = [
                            'POID' => $poid_generated,  // **ID unik diambil dalam setiap iterasi grup**
                            // 'PRID' => $item['prid'],
                            'obat_cd' => $item['kode'],
                            'ProdukHD' => $item['produk'],
                            'Jumlah' => $item['qtyapproved'],
                            'Satuan' => $item['satuan'],
                            'SatuanHD' => $item['satuanhd'],
                            'HargaUnit' => $item['harga'],
                            'BranchID' => 'BR001',
                            'SupplierID' => $item['distributor'],
                            'SupplierHD' => $item['distributorhd'],
                            'HNA' => $item['hna'],
                            'Bonus' => $item['bonus'],
                            'Diskon' => $item['diskon'],
                            'Pajak' => $item['pajak'],
                            'Tipe' => $item['tipe'],
                            'DiskonOff' => $item['diskon_off'],
                            'principal_cd' => $item['principal'],
                            'PrincipalHD' => $item['principalhd'],
                            // 'JumlahDisetujui' => $item['qtyapproved'],
                            'ApproveSta' => isset($item['staapproved']) ? $item['staapproved'] : null,
                        ];
                        */


                        $datapodetail = [
                            'POID' => $poid_generated,  // **ID unik diambil dalam setiap iterasi grup**
                            'PRID' => $prid,
                            'obat_cd' => $item['kode'],
                            'ProdukHD' => $item['produk'],
                            'Jumlah' => $item['qtyapproved'],
                            'Satuan' => $item['satuan'],
                            'SatuanHD' => $item['satuanhd'],
                            'HargaUnit' => intval($item['harga']),
                            'BranchID' => 'BR001',
                            'SupplierID' => $item['distributor'],
                            'SupplierHD' => $item['distributorhd'],
                            'HNA' => intval($item['hna']),
                            'Bonus' => intval($item['bonus']),
                            'Diskon' => intval($item['diskon']),
                            'Pajak' => intval($item['pajak']),
                            'Tipe' => 'JUAL',
                            'DiskonOff' => intval($item['diskon_off']),
                            'principal_cd' => $item['principal'],
                            'PrincipalHD' => $item['principalhd'],
                            // 'JumlahDisetujui' => 10,
                            'ApproveSta' => isset($item['staapproved']) ? $item['staapproved'] : null,
                        ];


                        $urlpodetail = "$this->server/purchaseorderdetail/insert";
                        akses_restapi('POST', $urlpodetail, $datapodetail);
                    }
                }
            }


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
