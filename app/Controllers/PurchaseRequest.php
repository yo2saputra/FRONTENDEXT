<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as excel;

class Purchaserequest extends BaseController
{

    protected $data;
    protected $server;
    protected $server3;
    protected $client;

    public function __construct()
    {

        $this->session = session();
        $uri = service('uri');
        $this->server = $_ENV['APP_API'];
        $this->server3 = $_ENV['APP_API3'];
    }

    public function index()
    {

        // helper dropdown
        helper(['dropdown']);

        $this->data['cb_pajak'] = getDropdownCustom('pajak_sta', 'detailPajak', 'Pajak', 2, 4); // (key,id,Label,label size, input size)
        $this->data['cb_satuan'] = getDropdownCustom('satuan_obat', 'detailSatuan', 'Satuan', 2, 2); // (key,id,Label,label size, input size)
        $this->data['cb_tipe'] = getDropdownCustom('tipe_produk', 'detailTipe', 'Tipe', 2, 4); // (key,id,Label,label size, input size)
        $this->data['cb_distributor'] = getDropdownSupplierCustom('supplierID', 'detailDistributor', 'Distributor', 2, 4); // (key,id,Label,label size, input size)
        $this->data['cb_principal'] = getDropdownPrincipalCustom('principal_cd', 'detailPrincipal', 'Principal', 2, 4); // (key,id,Label,label size, input size)
        $this->data['cb_obat'] = getDropdownObatCustomFilter('obat_cd', 'detailKode', 'Produk', 2, 4, ['dokter']); // (key,id,Label,label size, input size, filter)


        return view('purchaserequest/index', $this->data);
    }

    public function datatables()
    {
        helper(['restclient']);
        $rawBody = $this->request->getBody();
        $json = json_decode($rawBody, true);

        $startDate = $json['startDate'] ?? null;
        $endDate = $json['endDate'] ?? null;
        $search = $json['search']['value'] ?? '';

        $url = "{$this->server3}/api/purchaserequest/datatables2";
        $payload = $json + [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'search' =>  $search,
        ];



        // $url = "{$this->server3}/api/purchaserequest/datatables";
        $response = akses_restapikey('POST', $url, $payload);
        $result = json_decode($response, true);

        dd($result);

        // Tambahkan kolom aksi ke setiap data
        foreach ($result['data'] as $i => &$row) {
            $cd = $row['prid'];
            $row['rownum'] = $i + ($json['start'] ?? 0) + 1;
            $row['aksi'] = '
            <div class="btn-group">
                <a class="btn btn-sm btn-info view ' . ($this->session->get("flag_view") === 1 ? "" : "d-none") . '" data-prid="' . $cd . '"><i class="fas fa-eye"></i></a>
                <a class="btn btn-sm btn-primary edit ' . ($this->session->get("flag_update") === 1 ? "" : "d-none") . '" data-prid="' . $cd . '"><i class="fas fa-tags"></i></a>
                <a class="btn btn-sm btn-danger delete ' . ($this->session->get("flag_delete") === 1 ? "" : "d-none") . '" data-prid="' . $cd . '"><i class="fas fa-trash"></i></a>
            </div>';
        }

        return $this->response->setJSON($result);
    }

    // public function datatables2()
    // {
    //     helper(['restclient']);
    //     $rawBody = $this->request->getBody();
    //     $json = json_decode($rawBody, true);

    //     $startDate = $json['start_date'] ?? null;
    //     $endDate = $json['end_date'] ?? null;
    //     $searchKeyword = $json['search_keyword'] ?? '';

    //     $url = "{$this->server3}/api/warehouse/datatables";
    //     $response = akses_restapikey('POST', $url, $json + [
    //         'start_date' => $startDate,
    //         'end_date' => $endDate,
    //         'search_keyword' => $searchKeyword
    //     ]);
    //     $result = json_decode($response, true);

    //     // Tambahkan kolom aksi ke setiap data
    //     foreach ($result['data'] as $i => &$row) {
    //         $cd = $row['warehouse_cd'];
    //         $row['rownum'] = $i + ($json['start'] ?? 0) + 1;
    //         $row['aksi'] = '
    //         <div class="btn-group">
    //             <a class="btn btn-sm btn-info view ' . ($this->session->get("flag_view") === 1 ? "" : "d-none") . '" data-warehouse_cd="' . $cd . '"><i class="fas fa-eye"></i></a>
    //             <a class="btn btn-sm btn-primary edit ' . ($this->session->get("flag_update") === 1 ? "" : "d-none") . '" data-warehouse_cd="' . $cd . '"><i class="fas fa-tags"></i></a>
    //             <a class="btn btn-sm btn-danger delete ' . ($this->session->get("flag_delete") === 1 ? "" : "d-none") . '" data-warehouse_cd="' . $cd . '"><i class="fas fa-trash"></i></a>
    //         </div>';
    //     }

    //     return $this->response->setJSON($result);
    // }

    public function indexx()
    {

        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "{$this->server3}/api/warehouse";

        // Parameter yang ingin dikirim
        $params = [
            'action' => 'getby',          // atau 'getall'
            'warehouseCd' => 'WH00002'        // ganti sesuai kebutuhan
        ];

        // client request
        $response = akses_restapikey('GET', $url, $params);
        $data['response_data'] = json_decode($response, true);

        dd($data['response_data']);
    }

    public function apiDataGetAll()
    {

        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "{$this->server3}/api/warehouse";

        // Parameter yang ingin dikirim
        $query = [
            'action' => 'getall',          // atau 'getall'
            'warehouseCd' => ''        // ganti sesuai kebutuhan
        ];

        // client request
        $response = akses_restapikey('GET', $url, $body = [], $query);
        $data = json_decode($response, true);


        return $data["data"];
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
                'StatusPR' => 'N',
                'Keterangan' => $request['keterangan'],
                'RequestBy' => $this->session->get('usr_id'),
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

    function getPRDetailLastestPrice()
    {
        if ($this->request->isAJAX()) {

            $obat_cd = $this->request->getVar('obat_cd');
            $BranchID = $this->request->getVar('BranchID');
            $SupplierID = $this->request->getVar('SupplierID');

            if (!empty($obat_cd) && !empty($BranchID) && !empty($SupplierID)) {

                // helper curl request
                helper(['restclient']);

                // end point
                $url = "$this->server/purchaserequestdetail/getprdetaillatestprice/$obat_cd/$BranchID/$SupplierID";

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

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $warehouse_cd = $this->request->getVar('warehouse_cd');

            // helper curl request
            helper(['restclient']);

            // endpoint
            $url = "{$this->server3}/api/warehouse";
            $query = [
                'warehouse_cd' => $warehouse_cd
            ];
            // client request
            $result = akses_restapikey('DELETE', $url, $body = [], $query);

            // pastikan hasilnya berupa array
            $result = is_string($result) ? json_decode($result, true) : $result;

            // Tampilkan hasil (bisa diganti dengan redirect atau view)
            if (isset($result['success']) && $result['success'] === true) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => $result['message'] ?? 'Data warehouse berhasil dihapus',
                    'data' => $result
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $result['message'] ?? 'Gagal mengubah data',
                    'errors' => $result['errors'] ?? null
                ]);
            }
        }
    }

    function action()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getVar('action')) {
                helper(['form', 'url']);

                $validation = \Config\Services::validation();
                if ($this->session->get('role_cd') == 'ROLE002') {
                    $valid = $this->validate([
                        // 'warehouse_cd' => [
                        //     'label' => 'Code',
                        //     'rules' => 'required',
                        //     'errors' => [
                        //         //'required' => '{field} tidak boleh kosong',
                        //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        //     ]
                        // ],
                        'warehouse_nm' => [
                            'label' => 'Warehouse',
                            'rules' => 'required',
                            'errors' => [
                                //'required' => '{field} tidak boleh kosong',
                                //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                            ]
                        ],
                        'lokasi' => [
                            'label' => 'Lokasi',
                            'rules' => 'required',
                            'errors' => [
                                //'required' => '{field} tidak boleh kosong',
                                //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                            ]
                        ],
                        'warehouse_sta_id' => [
                            'label' => 'Status',
                            'rules' => 'required',
                            'errors' => [
                                //'required' => '{field} tidak boleh kosong',
                                //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                            ]
                        ]
                    ]);
                } else {
                    $valid = $this->validate([
                        // 'warehouse_cd' => [
                        //     'label' => 'Code',
                        //     'rules' => 'required',
                        //     'errors' => [
                        //         //'required' => '{field} tidak boleh kosong',
                        //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        //     ]
                        // ],
                        'warehouse_nm' => [
                            'label' => 'Warehouse',
                            'rules' => 'required',
                            'errors' => [
                                //'required' => '{field} tidak boleh kosong',
                                //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                            ]
                        ],
                        'lokasi' => [
                            'label' => 'Lokasi',
                            'rules' => 'required',
                            'errors' => [
                                //'required' => '{field} tidak boleh kosong',
                                //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                            ]
                        ],
                        'warehouse_sta_id' => [
                            'label' => 'Status',
                            'rules' => 'required',
                            'errors' => [
                                //'required' => '{field} tidak boleh kosong',
                                //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                            ]
                        ]
                    ]);
                }

                if (!$valid) {

                    return $this->response->setJSON([
                        'error' => [
                            'warehouse_cd' => $validation->getError('warehouse_cd'),
                            'warehouse_nm' => $validation->getError('warehouse_nm'),
                            'lokasi' => $validation->getError('lokasi'),
                            'warehouse_sta_id' => $validation->getError('warehouse_sta_id')
                        ]
                    ]);
                } else {

                    if ($this->request->getVar('action') == 'Add') {

                        // helper curl request
                        helper(['restclient']);

                        // endpoint
                        $url = "{$this->server3}/api/warehouse";

                        // form params
                        $body = [
                            "warehouse_cd" => str_replace(" ", "_", trim($this->request->getVar('warehouse_cd'))),
                            "warehouse_nm" => $this->request->getVar('warehouse_nm'),
                            "lokasi" => $this->request->getVar('lokasi'),
                            "warehouse_sta_id" => $this->request->getVar('warehouse_sta_id')
                        ];
                        // client request
                        $result = akses_restapikey('POST', $url, $body, $query = []);

                        // pastikan hasilnya berupa array
                        $result = is_string($result) ? json_decode($result, true) : $result;

                        // Tampilkan hasil (bisa diganti dengan redirect atau view)
                        if (isset($result['success']) && $result['success'] === true) {
                            return $this->response->setJSON([
                                'status' => 'success',
                                'message' => 'Data warehouse berhasil ditambahkan',
                                'data' => $result
                            ]);
                        } else {
                            return $this->response->setJSON([
                                'status' => 'error',
                                'message' => $result['message'] ?? 'Gagal menambahkan data',
                                'errors' => $result['errors'] ?? null
                            ]);
                        }


                        // $msg = [
                        //     'success' => 'data berhasil di create!'
                        // ];
                    }

                    if ($this->request->getVar('action') == 'Edit') {

                        // helper curl request
                        helper(['restclient']);

                        // endpoint
                        $url = "{$this->server3}/api/warehouse";

                        // Parameter yang ingin dikirim
                        $query = ['warehouse_cd' => str_replace(" ", "_", trim($this->request->getVar('warehouse_cd')))];
                        $body = [
                            'warehouse_nm' => $this->request->getVar('warehouse_nm'),
                            'lokasi' => $this->request->getVar('lokasi'),
                            'warehouse_sta_id' => $this->request->getVar('warehouse_sta_id'),
                            'warehousecode' => null
                        ];

                        // client request
                        $result = akses_restapikey('PUT', $url, $body, $query);

                        // pastikan hasilnya berupa array
                        $result = is_string($result) ? json_decode($result, true) : $result;

                        // Tampilkan hasil (bisa diganti dengan redirect atau view)
                        if (isset($result['success']) && $result['success'] === true) {
                            return $this->response->setJSON([
                                'status' => 'success',
                                'message' => 'Data warehouse berhasil diubah',
                                'data' => $result
                            ]);
                        } else {
                            return $this->response->setJSON([
                                'status' => 'error',
                                'message' => $result['message'] ?? 'Gagal mengubah data',
                                'errors' => $result['errors'] ?? null
                            ]);
                        }
                    }
                }
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }



    function fetchSingleData()
    {
        if ($this->request->isAJAX()) {

            $prid = $this->request->getVar('prid');

            if ($prid) {

                // helper curl request
                helper(['restclient']);

                // end point
                $url = "{$this->server3}/api/purchaserequest";
                $query = [
                    'action' => 'getby', // atau 'getall'
                    'prid' => $prid // ganti sesuai kebutuhan
                ];

                // client request
                $response = akses_restapikey('GET', $url, $body = [], $query);

                $data = json_decode($response, true);

                $msg = [
                    'data' => [
                        'prid' => $data["data"][0]["prid"],
                        'tanggalPR' => $data["data"][0]["tanggalPR"],
                        'tanggalStartPR' => $data["data"][0]["tanggalStartPR"],
                        'tanggalEndPR' => $data["data"][0]["tanggalEndPR"],
                        'totalPR' => $data["data"][0]["totalPR"],
                        'statusPR' => $data["data"][0]["statusPR"],
                        'keterangan' => $data["data"][0]["keterangan"],
                        'requestBy' => $data["data"][0]["requestBy"],
                        'emp_cd' => $data["data"][0]["emp_cd"]
                    ]
                ];

                echo json_encode($msg);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    function fetchSingleDataPrint($warehouse_cd)
    {

        if ($warehouse_cd) {

            // helper curl request
            helper(['restclient']);

            // end point
            $url = "{$this->server3}/api/warehouse";
            $query = [
                'action' => 'getby', // atau 'getall'
                'warehouseCd' => $warehouse_cd // ganti sesuai kebutuhan
            ];
            // client request
            $response = akses_restapikey('GET', $url, $body = [], $query);
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

    public function download()
    {
        // $model = new CommonModel();
        $spreadsheet = new Spreadsheet();
        // $result = $model->selectQuery();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue("A1", "KODE");
        $sheet->setCellValue("B1", "WAREHOUSE");
        $sheet->setCellValue("C1", "LOKASI");
        $sheet->setCellValue("D1", "STATUS");

        $count = 2;

        $sheet->setCellValue("A" . $count, "");
        $sheet->setCellValue("B" . $count, "");
        $sheet->setCellValue("C" . $count, "");
        $sheet->setCellValue("D" . $count, "");


        $writer = new Xlsx($spreadsheet);
        $writer->save("data.xlsx");
        return $this->response->download("data.xlsx", null)->setFileName("TEMPLATE WAREHOUSE.xlsx");
    }

    public function preview()
    {

        if ($this->request->getMethod() == "post") {
            $rules = $this->validate([
                'filename' => 'uploaded[filename]|max_size[filename,500]|ext_in[filename,csv,xlsx]',
            ]);
            if ($rules == true) {
                $filename =  $this->request->getFile('filename');
                $name = $filename->getName();
                $tempName = $filename->getTempName();
                $tgl_sekarang = date('YmdHis');

                $path = WRITEPATH . 'uploads/'; // Folder untuk menyimpan file
                $filename->move($path, $filename->getName());

                $this->session->set("fileupload", $path . "" . $filename->getName());
            } else {
                // return view("upload");
                return $this->response->setStatusCode(400)->setJSON(['error' => 'File yang diunggah harus berformat .xlsx']);
            }
        } else {

            if ($this->session->get("fileupload") !== '') {

                // Load Excel file
                $arr_file = explode(".", $this->session->get("fileupload"));
                $extension = end($arr_file);
                if ('csv' == $extension) {
                    $reader = new Csv();
                } else {
                    $reader = new excel();
                }

                $spreadsheet = $reader->load($this->session->get("fileupload"));
                $sheetData = $spreadsheet->getActiveSheet()->toArray();

                $output = '';
                $output .= '
                <br>
                 <table id="exampleImport" class="table table-sm table-bordered table-striped">
                 <thead>
                         <tr>  
                             <th>Kode</th>
                             <th>Warehouse</th>
                             <th>Lokasi</th>
                             <th>Status</th>
                             
                         </tr>
                     </thead>
                         ';
                if (empty($sheetData)) {
                    $output .= '<tr>  
                                 <td >Data not Found</td>
                                 <td ></td>
                                 <td ></td>
                                 <td ></td>
                                 
                             </tr>';
                } else {
                    if (count($sheetData) > 1) {
                        $kosong = 0;
                        for ($i = 1; $i < count($sheetData); $i++) {

                            $warehouse_cd = $sheetData[$i][0];
                            $warehouse_nm = $sheetData[$i][1];
                            $lokasi = $sheetData[$i][2];
                            $warehouse_sta_id = $sheetData[$i][3];


                            $warehouse_cd_td = ($warehouse_cd !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            $warehouse_nm_td = ($warehouse_nm !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            $keterangan_td = ($lokasi !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            $warehouse_sta_id_td = ($warehouse_sta_id !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,


                            // Jika salah satu data ada yang kosong
                            if ($warehouse_cd == "" or $warehouse_nm == "" or $lokasi == "" or $warehouse_sta_id == "") {
                                $kosong++; // Tambah 1 variabel $kosong
                            }

                            $output .= '  
                            <tr id="addMdlBarang" data-id="' . $warehouse_cd . '">
                                <td ' . $warehouse_cd_td . '>' . $warehouse_cd . '</td>
                                <td ' . $warehouse_nm_td . '>' . $warehouse_nm . '</td>
                                <td ' . $keterangan_td . '>' . $lokasi . '</td>
                                <td ' . $warehouse_sta_id_td . '>' . $warehouse_sta_id . '</td>
                                
                            </tr>  
                            ';
                        }
                    }
                }
                $output .= '</table>
                
                 <script>
                 if(' . $kosong . '>0){
                    alert("Ada ' . $kosong . ' Baris Yang Terdapat Data Kosong!");
                 }
                 
                 $(function() {
                     $("#exampleImport").DataTable({
                         // "responsive": true, "lengthChange": false, "autoWidth": false,
                         columnDefs: [{
                             orderable: false,
                             targets: 3
                         }],
                         "responsive": true,
                         "lengthChange": false,
                         "autoWidth": false,
                         // "columns": [
                         //   { "width": "10%" }, null, null, null, nuul, null
                         // ],
                         "buttons": [{
                            text: "Import",
                            action: function(e, dt, node, config) {
                                
                                $.post("' . site_url('tmstwarehouse/upload') . '", {

                                })
                                .done(function(response) {
                                    Swal.fire({
                                        icon: "success",
                                        title: "Berhasil",
                                        text: "Data berhasil diimport."
                                    });
                                    $("#modalimport").modal("hide");
                                    $("#warehouseTable").DataTable().ajax.reload(null, false); // false = tetap di halaman sekarang
                                })
                                .fail(function(error) {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Gagal",
                                        text: "Terjadi kesalahan saat mengimport data."
                                    });
                                });
                            },
                            attr: {
                                id: "postButton",
                                style: "background-color:#56b746;' . ($this->session->get("flag_insert") === 1 ? "" : "display:none;") . '",
                                name:"postButton",
                                nameClass:"btn-sm"
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
                     }).buttons().container().appendTo("#exampleImport_wrapper .col-md-6:eq(0)");
                 });
                 </script>
                 ';
                echo $output;
            } else {
                echo '';
            }
        }
    }

    public function upload()
    {
        if ($this->request->getMethod() == "post") {

            // Load Excel file
            $arr_file = explode(".", $this->session->get("fileupload"));
            $extension = end($arr_file);
            if ('csv' == $extension) {
                $reader = new Csv();
            } else {
                $reader = new excel();
            }

            $spreadsheet = $reader->load($this->session->get("fileupload"));
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            if (!empty($sheetData)) {
                for ($i = 1; $i < count($sheetData); $i++) {
                    $warehouse_cd = $sheetData[$i][0];
                    $warehouse_nm = $sheetData[$i][1];
                    $lokasi = $sheetData[$i][2];
                    $warehouse_sta_id = $sheetData[$i][3];


                    // helper curl request
                    helper(['restclient']);
                    // endpoint
                    $url = "{$this->server3}/api/warehouse";

                    $body = [
                        "warehouse_cd" => '',
                        "warehouse_nm" => $warehouse_nm,
                        "lokasi" => $lokasi,
                        "warehouse_sta_id" => 'A', // Default A = 'Aktif'
                    ];


                    // client request
                    $response = akses_restapikey('POST', $url, $body, $query = []);
                }

                $msg = [
                    'success' => $i . ' data berhasil di import!'
                ];

                return $this->response->setJSON($msg);

                // echo json_encode($msg);
                // return redirect()->to(site_url("/"));
            } else {
                return view("upload");
            }
        } else {
            return view("upload");
        }
    }


    function fetchSingleDataDetail2()
    {
        // if ($this->request->isAJAX()) {

        $dataId = $this->request->getVar('dataId');

        // if ($dataId) {

        // helper curl request
        helper(['restclient']);

        // end point
        $url = "{$this->server3}/api/purchaserequestdetail";
        $query = [
            'action' => 'getdetail', // atau 'getall'
            'prid' => $dataId // ganti sesuai kebutuhan
        ];

        // client request
        $response = akses_restapikey('GET', $url, $body = [], $query);

        $data = json_decode($response, true);

        $msg = [
            'data' => [
                'prid' => $data["data"][0]["prid"],
                'obat_cd' => $data["data"][0]["obat_cd"],
                'jumlah' => $data["data"][0]["jumlah"],
                'hargaUnit' => $data["data"][0]["hargaUnit"],
                'branchID' => $data["data"][0]["branchID"],
                'supplierID' => $data["data"][0]["SupplierID"],
                'hna' => $data["data"][0]["hna"],
                'bonus' => $data["data"][0]["bonus"],
                'diskon' => $data["data"][0]["diskon"],
                'pajak' => $data["data"][0]["pajak"],
                'tipe' => $data["data"][0]["tipe"],
                'diskonOff' => $data["data"][0]["diskonOff"],
                'principal_cd' => $data["data"][0]["principal_cd"],
                'satuan' => $data["data"][0]["satuan"],
                'jumlahDisetujui' => $data["data"][0]["jumlahDisetujui"],
                'approveSta' => $data["data"][0]["approveSta"],
                'produkHD' => $data["data"][0]["produkHD"],
                'satuanHD' => $data["data"][0]["satuanHD"],
                'supplierHD' => $data["data"][0]["supplierHD"],
                'principalHD' => $data["data"][0]["principalHD"]
            ]
        ];


        echo json_encode($msg);
        //     }
        // } else {
        //     exit('Maaf tidak dapat diproses!');
        // }
    }

    function fetchSingleDataDetail()
    {
        if ($this->request->isAJAX()) {

            $dataId = $this->request->getVar('dataId');

            if ($dataId) {

                helper(['restclient']);

                $url = "{$this->server3}/api/purchaserequestdetail";
                $query = [
                    'action' => 'getdetail',
                    'prid' => $dataId
                    // 'prid' => $dataId //PR250500029
                ];

                $response = akses_restapikey('GET', $url, $body = [], $query);
                $data = json_decode($response, true);

                $detailList = [];

                if (!empty($data['data'])) {
                    foreach ($data['data'] as $row) {
                        $detailList[] = [
                            'prid' => $row['prid'],
                            'obat_cd' => $row['obat_cd'],
                            'jumlah' => $row['jumlah'],
                            'hargaUnit' => $row['hargaUnit'],
                            'branchID' => $row['branchID'],
                            'supplierID' => $row['supplierID'],
                            'hna' => $row['hna'],
                            'bonus' => $row['bonus'],
                            'diskon' => $row['diskon'],
                            'pajak' => $row['pajak'],
                            'tipe' => $row['tipe'],
                            'diskonOff' => $row['diskonOff'],
                            'principal_cd' => $row['principal_cd'],
                            'satuan' => $row['satuan'],
                            'jumlahDisetujui' => $row['jumlahDisetujui'],
                            'approveSta' => $row['approveSta'],
                            'produkHD' => $row['produkHD'],
                            'satuanHD' => $row['satuanHD'],
                            'supplierHD' => $row['supplierHD'],
                            'principalHD' => $row['principalHD']
                        ];
                    }
                }

                // dd($data);

                echo json_encode(['data' => $detailList]);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }
}
