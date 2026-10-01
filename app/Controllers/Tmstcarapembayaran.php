<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as excel;

class Tmstcarapembayaran extends BaseController
{

    protected $data;
    protected $server3;

    public function __construct()
    {
        $this->server3 = $_ENV['APP_API3'];
    }

    public function index()
    {
        helper(['dropdown']);

        $this->data['cb_jenis_pembayaran'] = getJenisPembayaranDropdown();
        $this->data['cb_account_no'] = getDropdownGetSourceAccount('accountNo');
        return view('tmstcarapembayaran/index', $this->data);
    }

    public function datatables()
    {
        helper(['restclient']);
        $rawBody = $this->request->getBody();
        $json = json_decode($rawBody, true);

        $url = "{$this->server3}/api/caraPembayaran/datatables";
        $response = akses_restapikey('POST', $url, $json);
        $result = json_decode($response, true);

        foreach ($result['data'] as $i => &$row) {
            $caraPembayaranId = $row['caraPembayaranId'];
            $row['rownum'] = $i + ($json['start'] ?? 0) + 1;
            
            $row['aksi'] = '
            <div class="btn-group">
                <a class="btn btn-sm btn-info view ' . ($this->session->get("flag_view") === 1 ? "" : "d-none") . '" data-id="' . $caraPembayaranId . '"><i class="fas fa-eye"></i></a>
                <a class="btn btn-sm btn-primary edit ' . ($this->session->get("flag_update") === 1 ? "" : "d-none") . '" data-id="' . $caraPembayaranId . '"><i class="fas fa-tags"></i></a>
                <a class="btn btn-sm btn-danger delete ' . ($this->session->get("flag_delete") === 1 ? "" : "d-none") . '" data-id="' . $caraPembayaranId . '"><i class="fas fa-trash"></i></a>
            </div>';
        }

        return $this->response->setJSON($result);
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $caraPembayaranId = $this->request->getVar('caraPembayaranId');

            helper(['restclient']);

            $url = "{$this->server3}/api/caraPembayaran";
            $query = ['caraPembayaranId' => $caraPembayaranId];
            
            $result = akses_restapikey('DELETE', $url, [], $query);
            $result = is_string($result) ? json_decode($result, true) : $result;

            if (isset($result['success']) && $result['success'] === true) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => $result['message'] ?? 'Data Cara Pembayaran berhasil dihapus',
                    'data' => $result
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $result['message'] ?? 'Gagal menghapus data',
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

                $params = $this->request->getVar('params');
                $accountNo = isset($params['accountNo']) ? trim($params['accountNo']) : '';
                
                $errors = [];
                
                if (empty($this->request->getVar('jenisPembayaranId'))) {
                    $errors['jenisPembayaranId'] = 'Jenis Pembayaran harus diisi';
                }
                
                if (empty(trim($this->request->getVar('descriptionCaraPembayaran')))) {
                    $errors['descriptionCaraPembayaran'] = 'Deskripsi harus diisi';
                }
                
                if (empty(trim($this->request->getVar('type')))) {
                    $errors['type'] = 'Type harus diisi';
                }
                
                if (empty($accountNo)) {
                    $errors['accountNo'] = 'Nomor Akun harus diisi';
                }
                
                $valid = empty($errors);

                if (!$valid) {
                    return $this->response->setJSON([
                        'error' => $errors
                    ]);
                } else {

                    $empCd = $this->session->get('fullname') ?? '';

                    if ($this->request->getVar('action') == 'Add') {

                        helper(['restclient']);
                        $url = "{$this->server3}/api/caraPembayaran";

                        $body = [
                            "jenisPembayaranId"        => (int)$this->request->getVar('jenisPembayaranId'),
                            "jenisPembayaranNm"        => trim($this->request->getVar('jenisPembayaranNm')),
                            "descriptionCaraPembayaran" => trim($this->request->getVar('descriptionCaraPembayaran')),
                            "type"                     => trim($this->request->getVar('type')),
                            "integratedModule"         => trim($this->request->getVar('integratedModule')),
                            "markupPercentage"         => (int)($this->request->getVar('markupPercentage') ?? 0),
                            "accountNo"                => $accountNo,
                            "acctName"                 => trim($this->request->getVar('acctName')),
                            "createdBy"                => $empCd,
                        ];

                        log_message('debug', 'Cara Pembayaran Add Request: ' . json_encode($body));

                        $result = akses_restapikey('POST', $url, $body, []);

                        log_message('debug', 'Cara Pembayaran Add Response: ' . $result);

                        $result = is_string($result) ? json_decode($result, true) : $result;

                        if (isset($result['success']) && $result['success'] === true) {
                            return $this->response->setJSON([
                                'status' => 'success',
                                'message' => 'Data Cara Pembayaran berhasil ditambahkan',
                                'data' => $result
                            ]);
                        } else {
                            return $this->response->setJSON([
                                'status' => 'error',
                                'message' => $result['message'] ?? 'Gagal menambahkan data',
                                'errors' => $result['errors'] ?? null
                            ]);
                        }
                    }

                    if ($this->request->getVar('action') == 'Edit') {

                        helper(['restclient']);
                        $url = "{$this->server3}/api/caraPembayaran";

                        $query = ['caraPembayaranId' => $this->request->getVar('hidden_id')];
                    
                        $body = [
                            "jenisPembayaranId"        => (int)$this->request->getVar('jenisPembayaranId'),
                            "jenisPembayaranNm"        => trim($this->request->getVar('jenisPembayaranNm')),
                            "descriptionCaraPembayaran" => trim($this->request->getVar('descriptionCaraPembayaran')),
                            "type"                     => trim($this->request->getVar('type')),
                            "integratedModule"         => trim($this->request->getVar('integratedModule')),
                            "markupPercentage"         => (int)($this->request->getVar('markupPercentage') ?? 0),
                            "accountNo"                => $accountNo,
                            "acctName"                 => trim($this->request->getVar('acctName')),
                            "updatedBy"                => $empCd,
                        ];

                        log_message('debug', 'Cara Pembayaran Edit Request: ' . json_encode($body));
                        log_message('debug', 'Cara Pembayaran Edit Query: ' . json_encode($query));

                        $result = akses_restapikey('PUT', $url, $body, $query);

                        log_message('debug', 'Cara Pembayaran Edit Response: ' . $result);

                        $result = is_string($result) ? json_decode($result, true) : $result;

                        if (isset($result['success']) && $result['success'] === true) {
                            return $this->response->setJSON([
                                'status' => 'success',
                                'message' => 'Data Cara Pembayaran berhasil diubah',
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

            $caraPembayaranId = $this->request->getVar('caraPembayaranId');

            if ($caraPembayaranId) {

                helper(['restclient']);

                $url = "{$this->server3}/api/caraPembayaran";
                $query = [
                    'action'          => 'getby',
                    'caraPembayaranId' => $caraPembayaranId
                ];

                log_message('debug', 'Fetch Single Cara Pembayaran - ID: ' . $caraPembayaranId);

                try {
                    $response = akses_restapikey('GET', $url, [], $query);

                    log_message('debug', 'Fetch Single Cara Pembayaran Response: ' . $response);

                    $data = json_decode($response, true);

                    if (!isset($data["data"]) || empty($data["data"])) {
                        log_message('error', 'Invalid response format: ' . $response);
                        return $this->response->setJSON([
                            'status'       => 'error',
                            'message'      => 'Data tidak ditemukan atau format response salah',
                            'raw_response' => $response
                        ]);
                    }

                    $caraPembayaranData = isset($data["data"][0]) ? $data["data"][0] : $data["data"];

                    $msg = [
                        'status' => 'success',
                        'data'   => [
                            'caraPembayaranId'          => $caraPembayaranData["caraPembayaranId"] ?? '',
                            'jenisPembayaranId'         => $caraPembayaranData["jenisPembayaranId"] ?? '',
                            'jenisPembayaranNm'         => $caraPembayaranData["jenisPembayaranNm"] ?? '',
                            'descriptionCaraPembayaran' => $caraPembayaranData["descriptionCaraPembayaran"] ?? '',
                            'type'                      => $caraPembayaranData["type"] ?? '',
                            'integratedModule'          => $caraPembayaranData["integratedModule"] ?? '',
                            'markupPercentage'          => (int)($caraPembayaranData["markupPercentage"] ?? 0),
                            'accountNo'                 => $caraPembayaranData["accountNo"] ?? '',
                            'acctName'                  => $caraPembayaranData["acctName"] ?? '',
                            'createdBy'                 => $caraPembayaranData["createdBy"] ?? '',
                            'createdDate'               => $caraPembayaranData["createdDate"] ?? '',
                            'updatedBy'                 => $caraPembayaranData["updatedBy"] ?? '',
                            'updatedDate'               => $caraPembayaranData["updatedDate"] ?? '',
                        ]
                    ];

                    log_message('debug', 'Parsed Cara Pembayaran Data: ' . json_encode($msg));

                    return $this->response->setJSON($msg);
                    
                } catch (\Exception $e) {
                    log_message('error', 'Exception in fetchSingleData: ' . $e->getMessage());
                    return $this->response->setJSON([
                        'status'  => 'error',
                        'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                    ]);
                }
            } else {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'ID tidak ditemukan'
                ]);
            }
        } else {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Request bukan AJAX'
            ]);
        }
    }

    public function download()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue("A1", "Jenis Pembayaran ID");
        $sheet->setCellValue("B1", "Deskripsi Cara Pembayaran");
        $sheet->setCellValue("C1", "Type");
        $sheet->setCellValue("D1", "Integrated Module");
        $sheet->setCellValue("E1", "Markup Percentage");
        $sheet->setCellValue("F1", "Account No");
        
        $sheet->getStyle('A2:G2')->getFont()->setItalic(true)->setSize(9);
        $sheet->getStyle('A2:G2')->getFont()->getColor()->setARGB('FF808080');

        $count = 3;
        $sheet->setCellValue("A" . $count, "");
        $sheet->setCellValue("B" . $count, "");
        $sheet->setCellValue("C" . $count, "");
        $sheet->setCellValue("D" . $count, "");
        $sheet->setCellValue("E" . $count, "");
        $sheet->setCellValue("F" . $count, "");
        $sheet->setCellValue("G" . $count, "");

        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save("data.xlsx");
        return $this->response->download("data.xlsx", null)->setFileName("TEMPLATE CARA PEMBAYARAN.xlsx");
    }

    public function preview()
    {
        if ($this->request->getMethod() == "post") {
            $rules = $this->validate([
                'filename' => 'uploaded[filename]|max_size[filename,500]|ext_in[filename,csv,xlsx]',
            ]);
            if ($rules == true) {
                $filename = $this->request->getFile('filename');
                $path = WRITEPATH . 'uploads/';
                $filename->move($path, $filename->getName());
                $this->session->set("fileupload", $path . $filename->getName());
            } else {
                return $this->response->setStatusCode(400)->setJSON(['error' => 'File yang diunggah harus berformat .xlsx']);
            }
        } else {
            if ($this->session->get("fileupload") !== '') {
                $arr_file = explode(".", $this->session->get("fileupload"));
                $extension = end($arr_file);
                $reader = ('csv' == $extension) ? new Csv() : new excel();

                $spreadsheet = $reader->load($this->session->get("fileupload"));
                $sheetData = $spreadsheet->getActiveSheet()->toArray();

                $output = '<br><table id="exampleImport" class="table table-sm table-bordered table-striped">
                <thead><tr>
                    <th>Jenis Pembayaran ID</th>
                    <th>Deskripsi</th>
                    <th>Type</th>
                    <th>Integrated Module</th>
                    <th>Markup %</th>
                    <th>Account No</th>
                    <th>Account Name</th>
                </tr></thead>';
                
                if (empty($sheetData)) {
                    $output .= '<tr><td colspan="7">Data not Found</td></tr>';
                } else {
                    $kosong = 0;
                    for ($i = 1; $i < count($sheetData); $i++) {
                        $jenisPembayaranId  = $sheetData[$i][0];
                        $description        = $sheetData[$i][1];
                        $type               = $sheetData[$i][2];
                        $integratedModule   = $sheetData[$i][3];
                        $markupPercentage   = $sheetData[$i][4];
                        $accountNo          = $sheetData[$i][5];
                        $acctName        = $sheetData[$i][6];

                        $jenisPembayaranId_td = (!empty($jenisPembayaranId)) ? "" : " style='background: #E07171;'";
                        $description_td       = (!empty($description)) ? "" : " style='background: #E07171;'";
                        $type_td              = (!empty($type)) ? "" : " style='background: #E07171;'";
                        $accountNo_td         = (!empty($accountNo)) ? "" : " style='background: #E07171;'";

                        if (empty($jenisPembayaranId) || empty($description) || empty($type) || empty($accountNo)) {
                            $kosong++;
                        }

                        $output .= '<tr>
                            <td ' . $jenisPembayaranId_td . '>' . htmlspecialchars($jenisPembayaranId) . '</td>
                            <td ' . $description_td . '>' . htmlspecialchars($description) . '</td>
                            <td ' . $type_td . '>' . htmlspecialchars($type) . '</td>
                            <td>' . htmlspecialchars($integratedModule) . '</td>
                            <td>' . htmlspecialchars($markupPercentage) . '</td>
                            <td ' . $accountNo_td . '>' . htmlspecialchars($accountNo) . '</td>
                            <td>' . htmlspecialchars($acctName) . '</td>
                        </tr>';
                    }
                }
                
                $output .= '</table><script>
                if(' . $kosong . '>0){
                    Swal.fire({icon: "warning", title: "Perhatian", text: "Ada ' . $kosong . ' baris yang terdapat data kosong!"});
                }
                $(function() {
                    $("#exampleImport").DataTable({
                        "responsive": true, "lengthChange": false, "autoWidth": false,
                        "buttons": [{
                            text: "Import",
                            action: function(e, dt, node, config) {
                                $.post("' . site_url('tmstcarapembayaran/upload') . '", {})
                                .done(function(response) {
                                    let message = response.success || "Data berhasil diimport.";
                                    if (response.details?.errors?.length > 0) {
                                        message += "\\n\\nDetail Error:\\n" + response.details.errors.join("\\n");
                                    }
                                    Swal.fire({
                                        icon: response.details.fail_count > 0 ? "warning" : "success",
                                        title: response.details.fail_count > 0 ? "Import Selesai dengan Error" : "Berhasil",
                                        text: message, width: 600
                                    });
                                    $("#modalimport").modal("hide");
                                    $("#caraPembayaranTable").DataTable().ajax.reload(null, false);
                                })
                                .fail(function(error) {
                                    Swal.fire({icon: "error", title: "Gagal", text: error.responseJSON?.message || "Terjadi kesalahan saat mengimport data."});
                                });
                            },
                            attr: {id: "postButton", style: "background-color:#56b746;' . ($this->session->get("flag_insert") === 1 ? "" : "display:none;") . '", name:"postButton"}
                        }],
                        "oLanguage": {
                            "sSearch": "Cari Data:", "sInfoEmpty": "Tidak ada data",
                            "sInfo": "Total: _TOTAL_ data", "sInfoFiltered": " dari _MAX_ data",
                            "sZeroRecords": "Data tidak ditemukan",
                            "oPaginate": {"sFirst": "Awal", "sPrevious": "Sebelum", "sNext": "Berikut", "sLast": "Akhir"}
                        }
                    }).buttons().container().appendTo("#exampleImport_wrapper .col-md-6:eq(0)");
                });
                </script>';
                echo $output;
            } else {
                echo '';
            }
        }
    }

    public function upload()
    {
        if ($this->request->getMethod() == "post") {
            $arr_file = explode(".", $this->session->get("fileupload"));
            $extension = end($arr_file);
            $reader = ('csv' == $extension) ? new Csv() : new excel();

            $spreadsheet = $reader->load($this->session->get("fileupload"));
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            
            $successCount = 0;
            $failCount    = 0;
            $errors       = [];
            $empCd        = $this->session->get('fullname') ?? '';

            if (!empty($sheetData)) {
                for ($i = 1; $i < count($sheetData); $i++) {
                    $jenisPembayaranId = trim($sheetData[$i][0]);
                    $description       = trim($sheetData[$i][1]);
                    $type              = trim($sheetData[$i][2]);
                    $integratedModule  = trim($sheetData[$i][3]);
                    $markupPercentage  = trim($sheetData[$i][4]);
                    $accountNo         = trim($sheetData[$i][5]);
                    $acctName       = trim($sheetData[$i][6]);

                    if (empty($jenisPembayaranId) || empty($description) || empty($type) || empty($accountNo)) {
                        $failCount++;
                        $errors[] = "Baris " . ($i + 1) . ": Data tidak lengkap";
                        continue;
                    }

                    helper(['restclient']);
                    $url = "{$this->server3}/api/caraPembayaran";

                    $body = [
                        "jenisPembayaranId"        => (int)$jenisPembayaranId,
                        "descriptionCaraPembayaran" => $description,
                        "type"                     => $type,
                        "integratedModule"         => $integratedModule,
                        "markupPercentage"         => (int)($markupPercentage ?? 0),
                        "accountNo"                => $accountNo,
                        "acctName"                 => $acctName,
                        "createdBy"                => $empCd,
                    ];

                    $response = akses_restapikey('POST', $url, $body, []);
                    $result   = is_string($response) ? json_decode($response, true) : $response;

                    if (isset($result['success']) && $result['success'] === true) {
                        $successCount++;
                    } else {
                        $failCount++;
                        $errors[] = "Baris " . ($i + 1) . ": " . ($result['message'] ?? 'Gagal import');
                    }
                }

                return $this->response->setJSON([
                    'success' => $successCount . ' data berhasil diimport' . ($failCount > 0 ? ', ' . $failCount . ' data gagal' : ''),
                    'details' => [
                        'success_count' => $successCount,
                        'fail_count'    => $failCount,
                        'errors'        => $errors
                    ]
                ]);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'File Excel kosong']);
            }
        }
    }
}