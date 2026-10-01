<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as excel;

class Tmstwarehouses extends BaseController
{
    protected $data;
    protected $server3;
    protected $server5;

    public function __construct()
    {
        $this->server3 = $_ENV['APP_API3'];
        $this->server5 = $_ENV['APP_API5'];
    }

    public function index()
    {
        return view('tmstwarehouses/index', $this->data);
    }

    public function datatables()
    {
        helper(['restclient']);
        $rawBody = $this->request->getBody();
        $json    = json_decode($rawBody, true);

        $url      = "{$this->server5}/api/Warehouses/datatable";
        $response = akses_restapikey('POST', $url, $json);
        $result   = json_decode($response, true);

        if (!isset($result['data']) || !is_array($result['data'])) {
            log_message('error', 'Warehouses Datatables invalid response: ' . $response);
            return $this->response->setJSON([
                'draw'            => $json['draw'] ?? 1,
                'recordsTotal'    => 0,
                'recordsFiltered' => 0,
                'data'            => []
            ]);
        }

        foreach ($result['data'] as $i => &$row) {
            $id            = $row['warehouseId'];
            $row['rownum'] = $i + ($json['start'] ?? 0) + 1;
            $row['aksi']   = '
            <div class="btn-group">
                <a class="btn btn-sm btn-info view '    . ($this->session->get('flag_view')   === 1 ? '' : 'd-none') . '" data-id="' . $id . '"><i class="fas fa-eye"></i></a>
                <a class="btn btn-sm btn-primary edit ' . ($this->session->get('flag_update') === 1 ? '' : 'd-none') . '" data-id="' . $id . '"><i class="fas fa-tags"></i></a>
                <a class="btn btn-sm btn-danger delete '. ($this->session->get('flag_delete') === 1 ? '' : 'd-none') . '" data-id="' . $id . '"><i class="fas fa-trash"></i></a>
            </div>';
        }

        return $this->response->setJSON($result);
    }

    public function fetchSingleData()
    {
        if ($this->request->isAJAX()) {
            $warehouseId = $this->request->getVar('warehouseId');

            if ($warehouseId) {
                helper(['restclient']);

                $url = "{$this->server5}/api/Warehouses/{$warehouseId}";

                log_message('debug', 'Fetch Single Warehouse - ID: ' . $warehouseId);

                try {
                    $response = akses_restapikey('GET', $url, [], []);
                    log_message('debug', 'Fetch Single Warehouse Response: ' . $response);

                    $data = json_decode($response, true);

                    if (!isset($data['data']) || empty($data['data'])) {
                        return $this->response->setJSON([
                            'status'  => 'error',
                            'message' => 'Data tidak ditemukan atau format response salah'
                        ]);
                    }

                    $d = isset($data['data'][0]) ? $data['data'][0] : $data['data'];

                    return $this->response->setJSON([
                        'status' => 'success',
                        'data'   => [
                            'warehouseId'   => $d['warehouseId']   ?? '',
                            'warehouseCode' => $d['warehouseCode'] ?? '',
                            'warehouseName' => $d['warehouseName'] ?? '',
                            'address'       => $d['address']       ?? '',
                            'warehouseType' => $d['warehouseType'] ?? '',
                            'isDefault'     => $d['isDefault']     ?? false,
                            'isActive'      => $d['isActive']      ?? true,
                            'createdBy'     => $d['createdBy']     ?? '',
                            'createdDate'   => $d['createdDate']   ?? '',
                            'updatedBy'     => $d['updatedBy']     ?? '',
                            'updatedDate'   => $d['updatedDate']   ?? '',
                        ]
                    ]);
                } catch (\Exception $e) {
                    log_message('error', 'Exception in fetchSingleData Warehouse: ' . $e->getMessage());
                    return $this->response->setJSON([
                        'status'  => 'error',
                        'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                    ]);
                }
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'ID tidak ditemukan']);
            }
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Request bukan AJAX']);
        }
    }

    public function action()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getVar('action')) {
                helper(['form', 'url']);

                $errors = [];

                if (empty(trim($this->request->getVar('warehouseCode')))) {
                    $errors['warehouseCode'] = 'Warehouse Code harus diisi';
                }
                if (empty(trim($this->request->getVar('warehouseName')))) {
                    $errors['warehouseName'] = 'Warehouse Name harus diisi';
                }
                if (empty(trim($this->request->getVar('address')))) {
                    $errors['address'] = 'Address harus diisi';
                }

                if (!empty($errors)) {
                    return $this->response->setJSON(['error' => $errors]);
                }

                $empCd = $this->session->get('fullname')
                      ?? $this->session->get('username')
                      ?? $this->session->get('emp_name')
                      ?? $this->session->get('name')
                      ?? 'UNKNOWN';

                $body = [
                    'warehouseCode' => trim($this->request->getVar('warehouseCode')),
                    'warehouseName' => trim($this->request->getVar('warehouseName')),
                    'address'       => trim($this->request->getVar('address')),
                    'warehouseType' => trim($this->request->getVar('warehouseType')),
                    'isDefault'     => $this->request->getVar('isDefault') === '1' ? true : false,
                    'isActive'      => $this->request->getVar('isActive')  === '1' ? true : false,
                ];

                helper(['restclient']);

                if ($this->request->getVar('action') === 'Add') {
                    $body['createdBy'] = $empCd;
                    $url = "{$this->server5}/api/Warehouses";

                    log_message('debug', 'Warehouse Add Request: ' . json_encode($body));
                    $result = akses_restapikey('POST', $url, $body, []);
                    log_message('debug', 'Warehouse Add Response: ' . $result);
                    $result = is_string($result) ? json_decode($result, true) : $result;

                    if (isset($result['success']) && $result['success'] === true) {
                        return $this->response->setJSON([
                            'status'  => 'success',
                            'message' => 'Data Warehouse berhasil ditambahkan',
                            'data'    => $result
                        ]);
                    } else {
                        return $this->response->setJSON([
                            'status'  => 'error',
                            'message' => $result['message'] ?? 'Gagal menambahkan data',
                            'errors'  => $result['errors'] ?? null
                        ]);
                    }
                }

                if ($this->request->getVar('action') === 'Edit') {
                    $body['updatedBy'] = $empCd;
                    $warehouseId = $this->request->getVar('hidden_id');
                    $url         = "{$this->server5}/api/Warehouses/{$warehouseId}";

                    log_message('debug', 'Warehouse Edit Request: ' . json_encode($body));
                    $result = akses_restapikey('PUT', $url, $body, []);
                    log_message('debug', 'Warehouse Edit Response: ' . $result);
                    $result = is_string($result) ? json_decode($result, true) : $result;

                    if (isset($result['success']) && $result['success'] === true) {
                        return $this->response->setJSON([
                            'status'  => 'success',
                            'message' => 'Data Warehouse berhasil diubah',
                            'data'    => $result
                        ]);
                    } else {
                        return $this->response->setJSON([
                            'status'  => 'error',
                            'message' => $result['message'] ?? 'Gagal mengubah data',
                            'errors'  => $result['errors'] ?? null
                        ]);
                    }
                }
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $warehouseId = $this->request->getVar('warehouseId');

            helper(['restclient']);

            $url    = "{$this->server5}/api/Warehouses/{$warehouseId}";
            $result = akses_restapikey('DELETE', $url, [], []);
            $result = is_string($result) ? json_decode($result, true) : $result;

            if (isset($result['success']) && $result['success'] === true) {
                return $this->response->setJSON([
                    'status'  => 'success',
                    'message' => $result['message'] ?? 'Data Warehouse berhasil dihapus',
                    'data'    => $result
                ]);
            } else {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => $result['message'] ?? 'Gagal menghapus data',
                    'errors'  => $result['errors'] ?? null
                ]);
            }
        }
    }

    public function download()
    {
        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Warehouse Code');
        $sheet->setCellValue('B1', 'Warehouse Name');
        $sheet->setCellValue('C1', 'Address');
        $sheet->setCellValue('D1', 'Warehouse Type');
        $sheet->setCellValue('E1', 'Is Default (1/0)');
        $sheet->setCellValue('F1', 'Is Active (1/0)');

        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save('data.xlsx');
        return $this->response->download('data.xlsx', null)->setFileName('TEMPLATE WAREHOUSES.xlsx');
    }

    public function preview()
    {
        if ($this->request->getMethod() == 'post') {
            $rules = $this->validate([
                'filename' => 'uploaded[filename]|max_size[filename,500]|ext_in[filename,csv,xlsx]',
            ]);
            if ($rules) {
                $filename = $this->request->getFile('filename');
                $path     = WRITEPATH . 'uploads/';
                $filename->move($path, $filename->getName());
                $this->session->set('fileupload', $path . $filename->getName());
            } else {
                return $this->response->setStatusCode(400)->setJSON(['error' => 'File harus berformat .xlsx']);
            }
        } else {
            if ($this->session->get('fileupload') !== '') {
                $arr_file  = explode('.', $this->session->get('fileupload'));
                $extension = end($arr_file);
                $reader    = ('csv' == $extension) ? new Csv() : new excel();

                $spreadsheet = $reader->load($this->session->get('fileupload'));
                $sheetData   = $spreadsheet->getActiveSheet()->toArray();

                $output = '<br><table id="exampleImport" class="table table-sm table-bordered table-striped">
                <thead><tr>
                    <th>Warehouse Code</th><th>Warehouse Name</th><th>Address</th>
                    <th>Warehouse Type</th><th>Is Default</th><th>Is Active</th>
                </tr></thead><tbody>';

                if (empty($sheetData)) {
                    $output .= '<tr><td colspan="6">Data not Found</td></tr>';
                } else {
                    $kosong = 0;
                    for ($i = 1; $i < count($sheetData); $i++) {
                        $warehouseCode = $sheetData[$i][0];
                        $warehouseName = $sheetData[$i][1];
                        $address       = $sheetData[$i][2];
                        $warehouseType = $sheetData[$i][3];
                        $isDefault     = $sheetData[$i][4];
                        $isActive      = $sheetData[$i][5];

                        $code_td = (!empty($warehouseCode)) ? '' : " style='background:#E07171;'";
                        $name_td = (!empty($warehouseName)) ? '' : " style='background:#E07171;'";
                        $addr_td = (!empty($address))       ? '' : " style='background:#E07171;'";

                        if (empty($warehouseCode) || empty($warehouseName) || empty($address)) {
                            $kosong++;
                        }

                        $output .= '<tr>
                            <td' . $code_td . '>' . htmlspecialchars($warehouseCode) . '</td>
                            <td' . $name_td . '>' . htmlspecialchars($warehouseName) . '</td>
                            <td' . $addr_td . '>' . htmlspecialchars($address)       . '</td>
                            <td>'               . htmlspecialchars($warehouseType)   . '</td>
                            <td>'               . htmlspecialchars($isDefault)       . '</td>
                            <td>'               . htmlspecialchars($isActive)        . '</td>
                        </tr>';
                    }
                }

                $output .= '</tbody></table><script>
                if(' . $kosong . '>0){
                    Swal.fire({icon:"warning",title:"Perhatian",text:"Ada ' . $kosong . ' baris yang terdapat data kosong!"});
                }
                $(function(){
                    $("#exampleImport").DataTable({
                        "responsive":true,"lengthChange":false,"autoWidth":false,
                        "buttons":[{
                            text:"Import",
                            action:function(){
                                $.post("' . site_url('tmstwarehouses/upload') . '",{})
                                .done(function(response){
                                    let message = response.success || "Data berhasil diimport.";
                                    if(response.details?.errors?.length>0){
                                        message += "\\n\\nDetail Error:\\n"+response.details.errors.join("\\n");
                                    }
                                    Swal.fire({
                                        icon: response.details.fail_count>0?"warning":"success",
                                        title: response.details.fail_count>0?"Import Selesai dengan Error":"Berhasil",
                                        text: message, width:600
                                    });
                                    $("#modalimport").modal("hide");
                                    $("#warehousesTable").DataTable().ajax.reload(null,false);
                                })
                                .fail(function(error){
                                    Swal.fire({icon:"error",title:"Gagal",text:error.responseJSON?.message||"Terjadi kesalahan."});
                                });
                            },
                            attr:{id:"postButton",style:"background-color:#56b746;' . ($this->session->get('flag_insert') === 1 ? '' : 'display:none;') . '",name:"postButton"}
                        }],
                        "oLanguage":{
                            "sSearch":"Cari Data:","sInfoEmpty":"Tidak ada data",
                            "sInfo":"Total: _TOTAL_ data","sInfoFiltered":" dari _MAX_ data",
                            "sZeroRecords":"Data tidak ditemukan",
                            "oPaginate":{"sFirst":"Awal","sPrevious":"Sebelum","sNext":"Berikut","sLast":"Akhir"}
                        }
                    }).buttons().container().appendTo("#exampleImport_wrapper .col-md-6:eq(0)");
                });
                </script>';
                echo $output;
            }
        }
    }

    public function upload()
    {
        if ($this->request->getMethod() == 'post') {
            $arr_file  = explode('.', $this->session->get('fileupload'));
            $extension = end($arr_file);
            $reader    = ('csv' == $extension) ? new Csv() : new excel();

            $spreadsheet  = $reader->load($this->session->get('fileupload'));
            $sheetData    = $spreadsheet->getActiveSheet()->toArray();
            $successCount = 0;
            $failCount    = 0;
            $errors       = [];
            $empCd = $this->session->get('fullname')
                  ?? $this->session->get('username')
                  ?? $this->session->get('emp_name')
                  ?? $this->session->get('name')
                  ?? 'UNKNOWN';

            if (!empty($sheetData)) {
                for ($i = 1; $i < count($sheetData); $i++) {
                    $warehouseCode = trim($sheetData[$i][0]);
                    $warehouseName = trim($sheetData[$i][1]);
                    $address       = trim($sheetData[$i][2]);
                    $warehouseType = trim($sheetData[$i][3]);
                    $isDefault     = trim($sheetData[$i][4]);
                    $isActive      = trim($sheetData[$i][5]);

                    if (empty($warehouseCode) || empty($warehouseName) || empty($address)) {
                        $failCount++;
                        $errors[] = 'Baris ' . ($i + 1) . ': Data tidak lengkap';
                        continue;
                    }

                    helper(['restclient']);
                    $url  = "{$this->server5}/api/Warehouses";
                    $body = [
                        'warehouseCode' => $warehouseCode,
                        'warehouseName' => $warehouseName,
                        'address'       => $address,
                        'warehouseType' => $warehouseType,
                        'isDefault'     => $isDefault === '1' ? true : false,
                        'isActive'      => $isActive  === '1' ? true : false,
                        'createdBy'     => $empCd,
                    ];

                    $response = akses_restapikey('POST', $url, $body, []);
                    $result   = is_string($response) ? json_decode($response, true) : $response;

                    if (isset($result['success']) && $result['success'] === true) {
                        $successCount++;
                    } else {
                        $failCount++;
                        $errors[] = 'Baris ' . ($i + 1) . ': ' . ($result['message'] ?? 'Gagal import');
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