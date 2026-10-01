<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as excel;

class Tmstwarehousebins extends BaseController
{
    protected $data;
    protected $server5;

    public function __construct()
    {
        $this->server5 = $_ENV['APP_API5'];
    }

    public function index()
    {
        return view('tmstwarehousebins/index', $this->data);
    }

    public function datatables()
    {
        helper(['restclient']);
        $rawBody = $this->request->getBody();
        $json    = json_decode($rawBody, true);

        $url      = "{$this->server5}/api/WarehouseBins/datatable";
        $response = akses_restapikey('POST', $url, $json);
        $result   = json_decode($response, true);

        if (!isset($result['data']) || !is_array($result['data'])) {
            log_message('error', 'WarehouseBins Datatables invalid response: ' . $response);
            return $this->response->setJSON([
                'draw'            => $json['draw'] ?? 1,
                'recordsTotal'    => 0,
                'recordsFiltered' => 0,
                'data'            => []
            ]);
        }

        foreach ($result['data'] as $i => &$row) {
            $id            = $row['binId'];
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
            $binId = $this->request->getVar('binId');

            if ($binId) {
                helper(['restclient']);

                $url = "{$this->server5}/api/WarehouseBins/{$binId}";
                log_message('debug', 'Fetch Single WarehouseBin - ID: ' . $binId);

                try {
                    $response = akses_restapikey('GET', $url, [], []);
                    log_message('debug', 'Fetch Single WarehouseBin Response: ' . $response);

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
                            'binId'          => $d['binId']          ?? '',
                            'warehouseId'    => $d['warehouseId']    ?? '',
                            'warehouseCode'  => $d['warehouseCode']  ?? '',
                            'warehouseName'  => $d['warehouseName']  ?? '',
                            'binCode'        => $d['binCode']        ?? '',
                            'binName'        => $d['binName']        ?? '',
                            'binType'        => $d['binType']        ?? '',
                            'zoneCode'       => $d['zoneCode']       ?? '',
                            'rackCode'       => $d['rackCode']       ?? '',
                            'levelCode'      => $d['levelCode']      ?? '',
                            'positionCode'   => $d['positionCode']   ?? '',
                            'isDefault'      => $d['isDefault']      ?? false,
                            'isPickingArea'  => $d['isPickingArea']  ?? false,
                            'isBlocked'      => $d['isBlocked']      ?? false,
                            'capacityQty'    => $d['capacityQty']    ?? 0,
                            'capacityWeight' => $d['capacityWeight'] ?? 0,
                            'notes'          => $d['notes']          ?? '',
                            'isActive'       => $d['isActive']       ?? true,
                            'createdBy'      => $d['createdBy']      ?? '',
                            'createdDate'    => $d['createdDate']    ?? '',
                            'updatedBy'      => $d['updatedBy']      ?? '',
                            'updatedDate'    => $d['updatedDate']    ?? '',
                        ]
                    ]);
                } catch (\Exception $e) {
                    log_message('error', 'Exception in fetchSingleData WarehouseBin: ' . $e->getMessage());
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

                if (empty(trim($this->request->getVar('warehouseId')))) {
                    $errors['warehouseId'] = 'Warehouse harus dipilih';
                }
                if (empty(trim($this->request->getVar('binCode')))) {
                    $errors['binCode'] = 'Bin Code harus diisi';
                }
                if (empty(trim($this->request->getVar('binName')))) {
                    $errors['binName'] = 'Bin Name harus diisi';
                }

                if (!empty($errors)) {
                    return $this->response->setJSON(['error' => $errors]);
                }

                $empCd = $this->session->get('fullname') ?? '';

                $body = [
                    'warehouseId'    => trim($this->request->getVar('warehouseId')),
                    'binCode'        => trim($this->request->getVar('binCode')),
                    'binName'        => trim($this->request->getVar('binName')),
                    'binType'        => trim($this->request->getVar('binType')),
                    'zoneCode'       => trim($this->request->getVar('zoneCode')),
                    'rackCode'       => trim($this->request->getVar('rackCode')),
                    'levelCode'      => trim($this->request->getVar('levelCode')),
                    'positionCode'   => trim($this->request->getVar('positionCode')),
                    'isDefault'      => $this->request->getVar('isDefault')     === '1' ? true : false,
                    'isPickingArea'  => $this->request->getVar('isPickingArea') === '1' ? true : false,
                    'isBlocked'      => $this->request->getVar('isBlocked')     === '1' ? true : false,
                    'capacityQty'    => (float) ($this->request->getVar('capacityQty')    ?? 0),
                    'capacityWeight' => (float) ($this->request->getVar('capacityWeight') ?? 0),
                    'notes'          => trim($this->request->getVar('notes')),
                    'isActive'       => $this->request->getVar('isActive') === '1' ? true : false,
                ];

                helper(['restclient']);

                if ($this->request->getVar('action') === 'Add') {
                    $body['createdBy'] = $empCd;
                    $url = "{$this->server5}/api/WarehouseBins";

                    log_message('debug', 'WarehouseBin Add Request: ' . json_encode($body));
                    $result = akses_restapikey('POST', $url, $body, []);
                    log_message('debug', 'WarehouseBin Add Response: ' . $result);
                    $result = is_string($result) ? json_decode($result, true) : $result;

                    if (isset($result['success']) && $result['success'] === true) {
                        return $this->response->setJSON([
                            'status'  => 'success',
                            'message' => 'Data Warehouse Bin berhasil ditambahkan',
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
                    $binId = $this->request->getVar('hidden_id');
                    $url   = "{$this->server5}/api/WarehouseBins/{$binId}";

                    log_message('debug', 'WarehouseBin Edit Request: ' . json_encode($body));
                    $result = akses_restapikey('PUT', $url, $body, []);
                    log_message('debug', 'WarehouseBin Edit Response: ' . $result);
                    $result = is_string($result) ? json_decode($result, true) : $result;

                    if (isset($result['success']) && $result['success'] === true) {
                        return $this->response->setJSON([
                            'status'  => 'success',
                            'message' => 'Data Warehouse Bin berhasil diubah',
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
            $binId = $this->request->getVar('binId');

            helper(['restclient']);

            $url    = "{$this->server5}/api/WarehouseBins/{$binId}";
            $result = akses_restapikey('DELETE', $url, [], []);
            $result = is_string($result) ? json_decode($result, true) : $result;

            if (isset($result['success']) && $result['success'] === true) {
                return $this->response->setJSON([
                    'status'  => 'success',
                    'message' => $result['message'] ?? 'Data Warehouse Bin berhasil dihapus',
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

        $sheet->setCellValue('A1', 'Warehouse ID');
        $sheet->setCellValue('B1', 'Bin Code');
        $sheet->setCellValue('C1', 'Bin Name');
        $sheet->setCellValue('D1', 'Bin Type');
        $sheet->setCellValue('E1', 'Zone Code');
        $sheet->setCellValue('F1', 'Rack Code');
        $sheet->setCellValue('G1', 'Level Code');
        $sheet->setCellValue('H1', 'Position Code');
        $sheet->setCellValue('I1', 'Is Default (1/0)');
        $sheet->setCellValue('J1', 'Is Picking Area (1/0)');
        $sheet->setCellValue('K1', 'Is Blocked (1/0)');
        $sheet->setCellValue('L1', 'Capacity Qty');
        $sheet->setCellValue('M1', 'Capacity Weight');
        $sheet->setCellValue('N1', 'Notes');
        $sheet->setCellValue('O1', 'Is Active (1/0)');

        foreach (range('A', 'O') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save('data.xlsx');
        return $this->response->download('data.xlsx', null)->setFileName('TEMPLATE WAREHOUSE BINS.xlsx');
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
                    <th>Warehouse ID</th><th>Bin Code</th><th>Bin Name</th><th>Bin Type</th>
                    <th>Zone Code</th><th>Rack Code</th><th>Level Code</th><th>Position Code</th>
                    <th>Is Default</th><th>Is Picking Area</th><th>Is Blocked</th>
                    <th>Capacity Qty</th><th>Capacity Weight</th><th>Notes</th><th>Is Active</th>
                </tr></thead><tbody>';

                if (empty($sheetData)) {
                    $output .= '<tr><td colspan="15">Data not Found</td></tr>';
                } else {
                    $kosong = 0;
                    for ($i = 1; $i < count($sheetData); $i++) {
                        $warehouseId    = $sheetData[$i][0];
                        $binCode        = $sheetData[$i][1];
                        $binName        = $sheetData[$i][2];
                        $binType        = $sheetData[$i][3];
                        $zoneCode       = $sheetData[$i][4];
                        $rackCode       = $sheetData[$i][5];
                        $levelCode      = $sheetData[$i][6];
                        $positionCode   = $sheetData[$i][7];
                        $isDefault      = $sheetData[$i][8];
                        $isPickingArea  = $sheetData[$i][9];
                        $isBlocked      = $sheetData[$i][10];
                        $capacityQty    = $sheetData[$i][11];
                        $capacityWeight = $sheetData[$i][12];
                        $notes          = $sheetData[$i][13];
                        $isActive       = $sheetData[$i][14];

                        $wh_td   = (!empty($warehouseId)) ? '' : " style='background:#E07171;'";
                        $code_td = (!empty($binCode))     ? '' : " style='background:#E07171;'";
                        $name_td = (!empty($binName))     ? '' : " style='background:#E07171;'";

                        if (empty($warehouseId) || empty($binCode) || empty($binName)) {
                            $kosong++;
                        }

                        $output .= '<tr>
                            <td' . $wh_td   . '>' . htmlspecialchars($warehouseId)    . '</td>
                            <td' . $code_td . '>' . htmlspecialchars($binCode)         . '</td>
                            <td' . $name_td . '>' . htmlspecialchars($binName)         . '</td>
                            <td>'               . htmlspecialchars($binType)           . '</td>
                            <td>'               . htmlspecialchars($zoneCode)          . '</td>
                            <td>'               . htmlspecialchars($rackCode)          . '</td>
                            <td>'               . htmlspecialchars($levelCode)         . '</td>
                            <td>'               . htmlspecialchars($positionCode)      . '</td>
                            <td>'               . htmlspecialchars($isDefault)         . '</td>
                            <td>'               . htmlspecialchars($isPickingArea)     . '</td>
                            <td>'               . htmlspecialchars($isBlocked)         . '</td>
                            <td>'               . htmlspecialchars($capacityQty)       . '</td>
                            <td>'               . htmlspecialchars($capacityWeight)    . '</td>
                            <td>'               . htmlspecialchars($notes)             . '</td>
                            <td>'               . htmlspecialchars($isActive)          . '</td>
                        </tr>';
                    }
                }

                $output .= '</tbody></table><script>
                if(' . $kosong . '>0){
                    Swal.fire({icon:"warning",title:"Perhatian",text:"Ada ' . $kosong . ' baris yang terdapat data kosong!"});
                }
                $(function(){
                    $("#exampleImport").DataTable({
                        "responsive":true,"lengthChange":false,"autoWidth":false,"scrollX":true,
                        "buttons":[{
                            text:"Import",
                            action:function(){
                                $.post("' . site_url('tmstwarehousebins/upload') . '",{})
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
                                    $("#warehousebinsTable").DataTable().ajax.reload(null,false);
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
            $empCd        = $this->session->get('fullname') ?? '';

            if (!empty($sheetData)) {
                for ($i = 1; $i < count($sheetData); $i++) {
                    $warehouseId    = trim($sheetData[$i][0]);
                    $binCode        = trim($sheetData[$i][1]);
                    $binName        = trim($sheetData[$i][2]);
                    $binType        = trim($sheetData[$i][3]);
                    $zoneCode       = trim($sheetData[$i][4]);
                    $rackCode       = trim($sheetData[$i][5]);
                    $levelCode      = trim($sheetData[$i][6]);
                    $positionCode   = trim($sheetData[$i][7]);
                    $isDefault      = trim($sheetData[$i][8]);
                    $isPickingArea  = trim($sheetData[$i][9]);
                    $isBlocked      = trim($sheetData[$i][10]);
                    $capacityQty    = trim($sheetData[$i][11]);
                    $capacityWeight = trim($sheetData[$i][12]);
                    $notes          = trim($sheetData[$i][13]);
                    $isActive       = trim($sheetData[$i][14]);

                    if (empty($warehouseId) || empty($binCode) || empty($binName)) {
                        $failCount++;
                        $errors[] = 'Baris ' . ($i + 1) . ': Data tidak lengkap';
                        continue;
                    }

                    helper(['restclient']);
                    $url  = "{$this->server5}/api/WarehouseBins";
                    $body = [
                        'warehouseId'    => $warehouseId,
                        'binCode'        => $binCode,
                        'binName'        => $binName,
                        'binType'        => $binType,
                        'zoneCode'       => $zoneCode,
                        'rackCode'       => $rackCode,
                        'levelCode'      => $levelCode,
                        'positionCode'   => $positionCode,
                        'isDefault'      => $isDefault     === '1' ? true : false,
                        'isPickingArea'  => $isPickingArea === '1' ? true : false,
                        'isBlocked'      => $isBlocked     === '1' ? true : false,
                        'capacityQty'    => (float) $capacityQty,
                        'capacityWeight' => (float) $capacityWeight,
                        'notes'          => $notes,
                        'isActive'       => $isActive === '1' ? true : false,
                        'createdBy'      => $empCd,
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