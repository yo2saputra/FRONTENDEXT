<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;



class fieldvalue extends BaseController
{

    protected $data;
    protected $server;
    protected $client;

    public function __construct()
    {
        $this->session = session();
        $this->server = $_ENV['APP_API'];

        //library CURLrequest
        // $this->client = service('curlrequest');

        $this->data = [
            'menu_header' => $this->apiMenuHeader(session()->get('usr_id')),
            'menu' => $this->apiMenu(session()->get('usr_id'))
        ];
    }

    public function index()
    {
        // helper dropdown
        helper(['dropdown']);

        $this->data['blood_typ'] = $this->apiDropdownq();
        $this->data['cb_city_cd'] = getDropdown('city_cd', 'Kota', 2, 10); // (id,Label,label size, input size)
        $this->data['cb_classteraphy_cd'] = getDropdown('classteraphy_cd', 'Kelas Terapi', 2, 10);
        $this->data['cb_drug_typ'] = getDropdown('drug_typ', 'Drug Type', 2, 10);


        return view('fieldvalue/index', $this->data);
    }

    public function apiDropdownq()
    {
        //Set metode request dan endpoint
        //$response = $this->client->request("GET", "$this->server/dropdown/tfieldvalues/blood_typ");
        //Ambil body dari response
        //$content = $response->getBody();
        //$data['response_data'] = json_decode($content, true);
        //return $data['response_data'];

        // helper curl request
        helper(['restclient']);
        // endpoint
        $url = "$this->server/dropdown/tfield_value/blood_typ";
        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);
        return $data['response_data'];
    }

    public function apiDataGetAll()
    {
        //Set metode request dan endpoint
        //$response = $this->client->request("GET", "$this->server/clinic/tfield_value/getall");
        //Ambil body dari response
        //$content = $response->getBody();
        //$data['response_data'] = json_decode($content, true);
        //return $data['response_data'];

        // helper curl request
        helper(['restclient']);
        // endpoint
        $url = "$this->server/tfield_value/getall";
        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);
        return $data['response_data'];
    }

    public function fetchAll()
    {
        if ($this->request->isAJAX()) {


            $output = '';
            $data =  $this->apiDataGetAll();
            $output .= '  
                    <table id="example4" class="table table-sm table-bordered table-striped">
                    <thead>
                            <tr>  
                                <th>Nama</th>
                                <th>Value</th>
                                <th>Desc</th>
                                <th>Hidden Field</th>
                                <th>Deleted</th>
                                <th>Order</th>
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
                                </tr>';
            } else {
                for ($a = 0; $a < count($data); $a++) {
                    $output .= '  
                            <tr id="addMdlBarang" data-id="' . $data[$a]["fld_valu"] . '">
                                <td >' . $data[$a]["fld_nm"] . '</td>
                                <td >' . $data[$a]["fld_valu"] . '</td>
                                <td >' . $data[$a]["fld_desc"] . '</td>
                                <td ><span class="right badge ' . ($data[$a]['hiddenfield'] == 1 ? 'badge-info' : 'badge-warning') . '">' . ($data[$a]["hiddenfield"] == 1 ? "Ya" : "Tidak") . '</span></td>
                                <td ><span class="right badge ' . ($data[$a]['deleted'] == 1 ? 'badge-info' : 'badge-warning') . '">' . ($data[$a]["deleted"] == 1 ? "Ya" : "Tidak") . '</span></td>
                                <td >' . $data[$a]["orderby"] . '</td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm float-right mr-1 mt-1 delete btn-fix-w" data-fld_nm="' . $data[$a]["fld_nm"] . '" data-fld_valu="' . $data[$a]["fld_valu"] . '">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm float-right mr-1 mt-1 edit btn-fix-w" data-fld_nm="' . $data[$a]["fld_nm"] . '" data-fld_valu="' . $data[$a]["fld_valu"] . '">
                                        <i class="fas fa-tags"></i>
                                    </button>
                                    <a href="' . base_url('/fieldvalue/fetchSingleDataPrint/') . $data[$a]['fld_nm'] . '/' . $data[$a]['fld_valu'] . '" target="_blank" class="btn btn-warning btn-sm float-right mr-1 mt-1 print btn-fix-w" > <i class="fas fa-print"></i></a>
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
            "responsive": true,
            "lengthChange": false,
            "autoWidth": true,
            // "columns": [
            //   { "width": "10%" }, null, null, null, nuul, null
            // ],
            "buttons": [{
                    text: "Pasien Baru",
                    action: function(e, dt, node, config) {
                        // alert("Button activated");
                    },
                    attr: {
                        id: "addPasien",
                        style: "background-color:#56b746;"
                    }
                },
                {
                    text: "Kunjungan Baru",
                    action: function(e, dt, node, config) {
                        alert("Button activated");
                    },
                    attr: {
                        id: "daftar"
                    }
                },
                {
                    text: "Jadwal Dokter",
                    action: function(e, dt, node, config) {
                        // alert("Button activated");
                    },
                    attr: {
                        id: "listJadwalDokter",
                        style: "background-color:yellow;"
                    }
                }
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
        }).buttons().container().appendTo("#example1_wrapper .col-md-6:eq(0)");
    });
</script>

            // <script type="text/javascript">
            // $(function() {
            //     $("#example4").DataTable({
            //         columnDefs: [{
            //             orderable: false,
            //             targets: 3
            //         }],
            //         "dom": "Bfplit",
            //         "buttons": [
            //             "copy", "csv", "excel", "pdf", "print"
            //         ],
            //         "paging": true,
            //         "lengthChange": true,
            //         "searching": true,
            //         "info": true,
            //         "autoWidth": false,
            //         "responsive": true,
            //     });
            // });
            // </script>
            ';
            echo $output;
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }


    public function delete()
    {
        if ($this->request->isAJAX()) {
            $fld_nm = $this->request->getVar('fld_nm');
            $fld_valu = $this->request->getVar('fld_valu');

            // $response = $this->client->request("DELETE", "$this->server/tfield_value/delete/$fld_nm/$fld_valu");

            // $content = $response->getBody();
            // $data['respon_data'] = json_decode($content, true);

            // helper curl request
            helper(['restclient']);
            // endpoint
            $url = "$this->server/tfield_value/delete/$fld_nm/$fld_valu";
            // $data = [
            //     "fld_nm" => $this->request->getVar('nama'),
            //     "fld_valu" => $this->request->getVar('value')
            // ];

            // client request
            $response = akses_restapi('DELETE', $url, []);
            $data['response_data'] = json_decode($response, true);

            $msg = [
                'success' => "Data dengan nama $fld_nm berhasil dihapus"
                //'success' => $data['respon_data']
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
                    'nama' => [
                        'label' => 'Nama',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'value' => [
                        'label' => 'Value',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'desc' => [
                        'label' => 'Desc',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'orderby' => [
                        'label' => 'Order By',
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
                            'nama' => $validation->getError('nama'),
                            'value' => $validation->getError('value'),
                            'desc' => $validation->getError('desc'),
                            'orderby' => $validation->getError('orderby')
                        ]
                    ];
                } else {

                    if ($this->request->getVar('action') == 'Add') {

                        // $response = $this->client->request("POST", "$this->server/tfield_value/insert", [
                        //     "headers" => [
                        //         //"Content-Type: application/json",
                        //         "Accept" => "application/json"
                        //     ],
                        //     "form_params" => [
                        //         "fld_nm" => $this->request->getVar('nama'),
                        //         "fld_valu" => $this->request->getVar('value'),
                        //         "fld_desc" => $this->request->getVar('desc')
                        //     ]
                        // ]);

                        // helper curl request
                        helper(['restclient']);
                        // endpoint
                        $url = "$this->server/tfield_value/insert";
                        // form params
                        $data = [
                            "fld_nm" => $this->request->getVar('nama'),
                            "fld_valu" => $this->request->getVar('value'),
                            "fld_desc" => $this->request->getVar('desc'),
                            "hiddenfield" => ($this->request->getVar('hiddenfield') == FALSE) ? 0 : 1,
                            "deleted" => ($this->request->getVar('deleted') == FALSE) ? 0 : 1,
                            "orderby" => $this->request->getVar('orderby')
                        ];
                        // client request
                        $response = akses_restapi('POST', $url, $data);

                        $msg = [
                            'success' => 'data berhasil di create!'
                        ];
                    }

                    if ($this->request->getVar('action') == 'Edit') {
                        // $fld_nm = $this->request->getVar('nama');
                        // $fld_valu = $this->request->getVar('value');

                        // $response = $this->client->request("PUT", "$this->server/tfield_value/update/$fld_nm/$fld_valu", [
                        //     "headers" => [
                        //         //"Content-Type: application/json",
                        //         "Accept" => "application/json"
                        //     ],
                        //     "form_params" => [
                        //         "fld_desc" => $this->request->getVar('desc')
                        //     ]
                        // ]);

                        // helper curl request
                        helper(['restclient']);
                        // endpoint
                        // $url = "$this->server/tfield_value/update/$fld_nm/$fld_valu";
                        $url = "$this->server/tfield_value/update";
                        // form params
                        $data = [
                            "fld_nm" => $this->request->getVar('nama'),
                            "fld_valu" => $this->request->getVar('value'),
                            "fld_desc" => $this->request->getVar('desc'),
                            "hiddenfield" => ($this->request->getVar('hiddenfield') == FALSE) ? 0 : 1,
                            "deleted" => ($this->request->getVar('deleted') == FALSE) ? 0 : 1,
                            "orderby" => $this->request->getVar('orderby')
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

            $fld_nm = $this->request->getVar('fld_nm');
            $fld_valu = $this->request->getVar('fld_valu');

            if ($fld_nm) {

                // $response = $this->client->request("GET", "$this->server/tfield_value/getby/$fld_nm/$fld_valu", [
                //     "headers" => [
                //         "Accept" => "application/json"
                //     ]
                // ]);

                // $content = $response->getBody();
                // $data['respon_produk'] = json_decode($content, true);

                // helper curl request
                helper(['restclient']);
                // end point
                $url = "$this->server/tfield_value/getby/$fld_nm/$fld_valu";
                // client request
                $response = akses_restapi('GET', $url, []);
                $data['response_data'] = json_decode($response, true);


                $msg = [
                    'data' => [
                        'nama' => $data["response_data"][0]["fld_nm"],
                        'value' => $data["response_data"][0]["fld_valu"],
                        'desc' => $data["response_data"][0]["fld_desc"],
                        'hiddenfield' => $data["response_data"][0]["hiddenfield"],
                        'deleted' => $data["response_data"][0]["deleted"],
                        'orderby' => $data["response_data"][0]["orderby"]
                    ]
                ];

                echo json_encode($msg);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    function fetchSingleDataPrint($fld_nm, $fld_valu)
    {

        if ($fld_nm) {

            // $response = $this->client->request("GET", "$this->server/tfield_value/getby/$fld_nm/$fld_valu", [
            //     "headers" => [
            //         "Accept" => "application/json"
            //     ]
            // ]);

            // $content = $response->getBody();
            // $data['respon_produk'] = json_decode($content, true);

            // helper curl request
            helper(['restclient']);
            // end point
            $url = "$this->server/tfield_value/getby/$fld_nm/$fld_valu";
            // client request
            $response = akses_restapi('GET', $url, []);
            $data['response_data'] = json_decode($response, true);

            $pdf_data = $data['response_data'];
            $pdf_name = 'Single Data Field Value';
            $pdf_title = 'Data Field Value';
            $pdf_paper = 'A4';
            $pdf_orientation = 'portrait';
            $pdf_format = 'laporan_pdf';

            $this->view_pdf($pdf_name, $pdf_title, $pdf_data, $pdf_paper, $pdf_orientation, $pdf_format);
        }
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
