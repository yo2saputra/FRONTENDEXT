<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as excel;

class Tmstglbatchlist extends BaseController
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

        // $this->data['cb_sourceledger'] = getDropdownSourceLedgerGL('SrceLedger', 'cb_sourceledger', ['GL']);
        // ('key, id, input_size, filter')
        $this->data['cb_sourceledger'] = getDropdownSourceLedgerGLJE('SrceLedger', 'cb_sourceledger');
        $this->data['cb_batchtype'] = getDropdownBatchTypeGlBatch('BatchType', 'cb_batchtype', ['1']);
        // ('key, id, input_size, filter')
        $this->data['cb_batchstatus'] = getDropdownBatchStatusGlBatch('BatchStatus', 'cb_batchstatus', ['1', '2']);

        // ('key, id, input_size, filter')
        return view('tmstglbatchlist/index', $this->data);
    }

    public function datatables()
    {
        helper(['restclient']);

        $rawBody = $this->request->getBody();
        $json = json_decode($rawBody, true);

        $url = "{$this->server3}/api/tmstglbatchlist/datatables";
        $response = akses_restapikey('POST', $url, $json);

        $result = json_decode($response, true);

        if (!isset($result['data']) || !is_array($result['data'])) {
            $result['data'] = [];
        }

        foreach ($result['data'] as $i => &$row) {

            $cd = $row['batchId'] ?? '';

            $row['rownum'] = $i + ($json['start'] ?? 0) + 1;

            $row['aksi'] = '
        <div class="btn-group">
            <a class="btn btn-sm btn-info view ' . ($this->session->get("flag_view") === 1 ? "" : "d-none") . '" data-batchid="' . $cd . '">
                <i class="fas fa-eye"></i>
            </a>

            <a class="btn btn-sm btn-primary edit ' . (
                $this->session->get("flag_update") === 1 &&
                ($row['batchStat'] ?? '') !== '4' &&
                ($row['batchStat'] ?? '') !== '9'
                ? ""
                : "d-none"
            ) . '" data-batchid="' . $cd . '" title="Edit">
                <i class="fas fa-tags"></i>
            </a>

            <a class="btn btn-sm btn-danger delete ' . (
                $this->session->get("flag_update") === 1 &&
                ($row['batchStat'] ?? '') === '1'
                ? ""
                : "d-none"
            ) . '" data-batchid="' . $cd . '" title="Delete">
                <i class="fas fa-trash"></i>
            </a>

            <a href="' . base_url("tmstgljournal?batchId={$cd}") . '" 
               class="btn btn-sm btn-warning ' . ($this->session->get("flag_view") === 1 ? "" : "d-none") . '" 
               title="Journal Entry" 
               target="_blank">
                <i class="fas fa-arrow-right"></i>
            </a>

            <a class="btn btn-sm btn-success posting ' . (
                $this->session->get("flag_update") === 1 &&
                ($row['batchStat'] ?? '') === '2'
                ? ""
                : "d-none"
            ) . '" data-batchid="' . $cd . '" title="Posting">
                Posting
            </a>
        </div>';
        }

        return $this->response->setJSON($result);
    }

    public function action()
    {
        if ($this->request->isAJAX()) {
            $action = $this->request->getVar('action');
            if (!$action) return;

            helper(['form', 'url', 'restclient', 'dropdown']);

            $audtDate = date('Y-m-d');
            $audtTime = date('H:i:s');
            $audtUser = session()->get('usr_id');

            if ($action == 'Add') {
                $valid = $this->validate(['BatchDesc' => 'required']);
                if (!$valid) return $this->response->setJSON(['status' => 'error', 'errors' => ['BatchDesc' => 'Batch Description tidak boleh kosong']]);

                $url = "{$this->server3}/api/tmstglbatchlist";
                $body = [
                    "BatchId" => $this->request->getVar('BatchId'),
                    "BatchDesc" => $this->request->getVar('BatchDesc'),
                    "SrceLedgr" => apiDropdownSourceLedgerJE()['data'][0]['value'],
                    "SrceType" => apiDropdownSourceLedgerTypeGlJe()['data'][0]['value'],
                    "BatchType" => $this->request->getVar('cb_batchtype'),
                    "BatchStat" => $this->request->getVar('cb_batchstatusins'),
                    "DateCreat" => $audtDate,
                    "AudtUser" => $audtUser,
                    "AudtTime" => $audtTime,
                    "AudtDate" => $audtDate,
                    "DateEdit" => $audtDate,
                    "SwPrinted" => 0
                ];
                $result = akses_restapikey('POST', $url, $body);
                $result = is_string($result) ? json_decode($result, true) : $result;

                if (isset($result['success']) && $result['success'] == 1)
                    return $this->response->setJSON(['status' => 'success', 'message' => 'Batch Number berhasil ditambahkan', 'data' => $result]);

                return $this->response->setJSON(['status' => 'error', 'message' => $result['message'] ?? 'Gagal menambahkan data', 'errors' => $result['errors'] ?? null]);
            }

            if ($action == 'Edit') {
                $valid = $this->validate(['BatchDesc' => 'required']);
                if (!$valid) return $this->response->setJSON(['status' => 'error', 'errors' => ['BatchDesc' => 'Batch Description tidak boleh kosong']]);

                $url = "{$this->server3}/api/tmstglbatchlist/update";
                $query = ['batchId' => str_replace(" ", "_", trim($this->request->getVar('BatchId')))];
                $body = [
                    "batchId" => $this->request->getVar('BatchId'),
                    "batchDesc" => $this->request->getVar('BatchDesc'),
                    "batchStat" => $this->request->getVar('cb_batchstatus'),
                    "audtUser" => $audtUser,
                    "audtTime" => $audtTime,
                    "audtDate" => $audtDate,
                    "dateEdit" => $audtDate
                ];
                $result = akses_restapikey('PUT', $url, $body, $query);
                $result = is_string($result) ? json_decode($result, true) : $result;

                if (isset($result['status']) && $result['status'] === 'validation_error') return $this->response->setJSON($result);

                return $this->response->setJSON($result);
            }

            if ($action == 'SoftDelete') {

                $batchId = trim($this->request->getVar('BatchId'));

                $url = "{$this->server3}/api/tmstglbatchlist/softdelete";

                $query = [
                    'batchId' => str_replace(" ", "_", $batchId)
                ];

                $body = [
                    "batchId"   => $batchId,
                    "batchStat" => '9'
                ];

                $result = akses_restapikey('PUT', $url, $body, $query);
                $result = is_string($result) ? json_decode($result, true) : $result;

                return $this->response->setJSON($result);
            }

            if ($action == 'Posting') {
                $BatchId = $this->request->getVar('PostBatchId');
                $url = "{$this->server3}/api/tmstglbatchlist/updatepost";
                $query = ['batchId' => str_replace(" ", "_", trim($BatchId))];
                $body = ["batchId" => $BatchId, "batchStat" => "4"];

                $result = akses_restapikey('PUT', $url, $body, $query);
                $result = is_string($result) ? json_decode($result, true) : $result;

                if (isset($result['status'])) {
                    switch ($result['status']) {
                        case 'validation_error':
                            return $this->response->setJSON($result);

                        case 'success':
                            return $this->PostBatch($BatchId);

                        case 'error':
                            return $this->response->setJSON([
                                'status' => 'error',
                                'message' => $result['message'] ?? 'Gagal mengubah data'
                            ]);
                    }
                }

                if (isset($result['success']) && $result['success'] == 1) {
                    return $this->PostBatch($BatchId);
                }

                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $result['message'] ?? 'Gagal memproses posting'
                ]);
            }
        }
    }

    public function PostBatch($BatchId)
    {
        helper(['restclient']);
        $audtDate = date('Y-m-d');
        $audtTime = date('H:i:s');
        $audtUser = session()->get('usr_id');

        $url = "{$this->server3}/api/tmstglbatchlist/postbatch";
        $body = ["BatchId" => $BatchId, "AudtUser" => $audtUser, "AudtTime" => $audtTime, "AudtDate" => $audtDate, "DateEdit" => $audtDate];
        akses_restapikey('POST', $url, $body);

        return $this->response->setJSON(['status' => 'success', 'message' => 'Batch berhasil diposting']);
    }

    public function fetchSingleData()
    {
        if ($this->request->isAJAX()) {

            $batchid = $this->request->getVar('BatchId');

            if ($batchid) {

                helper(['restclient']);

                $url = "{$this->server3}/api/tmstglbatchlist";
                $query = [
                    'action' => 'getby',
                    'batchid' => $batchid
                ];

                $response = akses_restapikey('GET', $url, [], $query);
                $data = json_decode($response, true);

                if (isset($data['success']) && $data['success'] === true && !empty($data['data'])) {

                    $row = $data['data'][0];

                    $msg = [
                        'success' => true,
                        'data' => [
                            'BatchId'       => $row['batchId'],
                            'BatchDesc'     => $row['batchDesc'],
                            'DateCreat'     => $row['dateCreat'],
                            'AudtUser'      => $row['audtUser'],
                            'SrceLedger'    => $row['srceLedgr'],
                            'BatchType'     => $row['batchType'],
                            'BatchTypeDesc' => $row['batchTypeDesc'],
                            'DebitTot'      => $row['debitTot'],
                            'CreditTot'     => $row['creditTot'],
                            'EntryCnt'      => $row['entryCnt'],
                            'BatchStatus'   => $row['batchStat'],
                            'BatchStatDesc' => $row['batchStatDesc'],
                            'AudtDate'      => $row['audtDate'],
                            'AudtTime'      => $row['audtTime'],
                            'SwPrinted'     => $row['swPrinted'],
                            'PostSeq'       => $row['postngSeq'],
                            'NextEntry'     => $row['nextEntry'],
                            'ErrorCnt'      => $row['errorCnt']
                        ]
                    ];

                    return $this->response->setJSON($msg);
                }

                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }

        exit('Maaf tidak dapat diproses!');
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
}
