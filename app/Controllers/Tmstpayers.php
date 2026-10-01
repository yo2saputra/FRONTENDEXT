<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as excel;

class Tmstpayers extends BaseController
{
    protected $data;
    protected $server5;

    public function __construct()
    {
        $this->server5 = $_ENV['APP_API5'];
    }

    public function index()
    {
        return view('tmstpayers/index', $this->data);
    }

    public function datatables()
    {
        helper(['restclient']);
        $rawBody = $this->request->getBody();
        $json    = json_decode($rawBody, true);

        $url      = "{$this->server5}/api/Payers/datatable";
        $response = akses_restapikey('POST', $url, $json);
        $result   = json_decode($response, true);

        if (!isset($result['data']) || !is_array($result['data'])) {
            log_message('error', 'Payers Datatables invalid response: ' . $response);
            return $this->response->setJSON([
                'draw'            => $json['draw'] ?? 1,
                'recordsTotal'    => 0,
                'recordsFiltered' => 0,
                'data'            => []
            ]);
        }

        foreach ($result['data'] as $i => &$row) {
            $payerId       = $row['payerId'];
            $row['rownum'] = $i + ($json['start'] ?? 0) + 1;

            $row['aksi'] = '
            <div class="btn-group">
                <a class="btn btn-sm btn-info view '    . ($this->session->get('flag_view')   === 1 ? '' : 'd-none') . '" data-id="' . $payerId . '"><i class="fas fa-eye"></i></a>
                <a class="btn btn-sm btn-primary edit ' . ($this->session->get('flag_update') === 1 ? '' : 'd-none') . '" data-id="' . $payerId . '"><i class="fas fa-tags"></i></a>
                <a class="btn btn-sm btn-danger delete '. ($this->session->get('flag_delete') === 1 ? '' : 'd-none') . '" data-id="' . $payerId . '"><i class="fas fa-trash"></i></a>
            </div>';
        }

        return $this->response->setJSON($result);
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $payerId = $this->request->getVar('payerId');

            helper(['restclient']);

            $url    = "{$this->server5}/api/Payers/{$payerId}";
            $result = akses_restapikey('DELETE', $url, [], []);
            $result = is_string($result) ? json_decode($result, true) : $result;

            if (isset($result['success']) && $result['success'] === true) {
                return $this->response->setJSON([
                    'status'  => 'success',
                    'message' => $result['message'] ?? 'Data Payer berhasil dihapus',
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

    public function action()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getVar('action')) {
                helper(['form', 'url']);

                $errors = [];

                if (empty(trim($this->request->getVar('payerCode')))) {
                    $errors['payerCode'] = 'Payer Code harus diisi';
                }
                if (empty(trim($this->request->getVar('payerName')))) {
                    $errors['payerName'] = 'Payer Name harus diisi';
                }
                if (empty(trim($this->request->getVar('payerType')))) {
                    $errors['payerType'] = 'Payer Type harus diisi';
                }

                if (!empty($errors)) {
                    return $this->response->setJSON(['error' => $errors]);
                }

                $empCd = $this->session->get('fullname') ?? '';

                $body = [
                    'payerCode'       => trim($this->request->getVar('payerCode')),
                    'payerName'       => trim($this->request->getVar('payerName')),
                    'payerType'       => trim($this->request->getVar('payerType')),
                    'address'         => trim($this->request->getVar('address')),
                    'phone'           => trim($this->request->getVar('phone')),
                    'email'           => trim($this->request->getVar('email')),
                    'contactPerson'   => trim($this->request->getVar('contactPerson')),
                    'coveragePercent' => $this->request->getVar('coveragePercent') !== '' ? (float) $this->request->getVar('coveragePercent') : 0,
                    'defaultDueDays'  => $this->request->getVar('defaultDueDays')  !== '' ? (int)   $this->request->getVar('defaultDueDays')  : 0,
                    'isActive'        => $this->request->getVar('isActive') === '1' ? true : false,
                ];

                helper(['restclient']);

                if ($this->request->getVar('action') === 'Add') {
                    $body['createdBy'] = $empCd;
                    $url = "{$this->server5}/api/Payers";

                    log_message('debug', 'Payer Add Request: ' . json_encode($body));
                    $result = akses_restapikey('POST', $url, $body, []);
                    log_message('debug', 'Payer Add Response: ' . $result);
                    $result = is_string($result) ? json_decode($result, true) : $result;

                    if (isset($result['success']) && $result['success'] === true) {
                        return $this->response->setJSON([
                            'status'  => 'success',
                            'message' => 'Data Payer berhasil ditambahkan',
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
                    $payerId = $this->request->getVar('hidden_id');
                    $url     = "{$this->server5}/api/Payers/{$payerId}";

                    log_message('debug', 'Payer Edit Request: ' . json_encode($body));
                    $result = akses_restapikey('PUT', $url, $body, []);
                    log_message('debug', 'Payer Edit Response: ' . $result);
                    $result = is_string($result) ? json_decode($result, true) : $result;

                    if (isset($result['success']) && $result['success'] === true) {
                        return $this->response->setJSON([
                            'status'  => 'success',
                            'message' => 'Data Payer berhasil diubah',
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

    public function fetchSingleData()
    {
        if ($this->request->isAJAX()) {
            $payerId = $this->request->getVar('payerId');

            if ($payerId) {
                helper(['restclient']);

                $url = "{$this->server5}/api/Payers/{$payerId}";

                log_message('debug', 'Fetch Single Payer - ID: ' . $payerId);

                try {
                    $response = akses_restapikey('GET', $url, [], []);
                    log_message('debug', 'Fetch Single Payer Response: ' . $response);

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
                            'payerId'         => $d['payerId']         ?? '',
                            'payerCode'       => $d['payerCode']       ?? '',
                            'payerName'       => $d['payerName']       ?? '',
                            'payerType'       => $d['payerType']       ?? '',
                            'address'         => $d['address']         ?? '',
                            'phone'           => $d['phone']           ?? '',
                            'email'           => $d['email']           ?? '',
                            'contactPerson'   => $d['contactPerson']   ?? '',
                            'coveragePercent' => $d['coveragePercent'] ?? 0,
                            'defaultDueDays'  => $d['defaultDueDays']  ?? 0,
                            'isActive'        => $d['isActive']        ?? true,
                            'isDeleted'       => $d['isDeleted']       ?? false,
                            'createdBy'       => $d['createdBy']       ?? '',
                            'createdDate'     => $d['createdDate']     ?? '',
                            'updatedBy'       => $d['updatedBy']       ?? '',
                            'updatedDate'     => $d['updatedDate']     ?? '',
                        ]
                    ]);
                } catch (\Exception $e) {
                    log_message('error', 'Exception in fetchSingleData Payer: ' . $e->getMessage());
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

    public function download()
    {
        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Payer Code');
        $sheet->setCellValue('B1', 'Payer Name');
        $sheet->setCellValue('C1', 'Payer Type');
        $sheet->setCellValue('D1', 'Address');
        $sheet->setCellValue('E1', 'Phone');
        $sheet->setCellValue('F1', 'Email');
        $sheet->setCellValue('G1', 'Contact Person');
        $sheet->setCellValue('H1', 'Coverage Percent');
        $sheet->setCellValue('I1', 'Default Due Days');
        $sheet->setCellValue('J1', 'Is Active (1/0)');

        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save('data.xlsx');
        return $this->response->download('data.xlsx', null)->setFileName('TEMPLATE PAYERS.xlsx');
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
                    <th>Payer Code</th><th>Payer Name</th><th>Payer Type</th>
                    <th>Address</th><th>Phone</th><th>Email</th>
                    <th>Contact Person</th><th>Coverage %</th><th>Due Days</th><th>Is Active</th>
                </tr></thead><tbody>';

                if (empty($sheetData)) {
                    $output .= '<tr><td colspan="10">Data not Found</td></tr>';
                } else {
                    $kosong = 0;
                    for ($i = 1; $i < count($sheetData); $i++) {
                        $payerCode       = $sheetData[$i][0];
                        $payerName       = $sheetData[$i][1];
                        $payerType       = $sheetData[$i][2];
                        $address         = $sheetData[$i][3];
                        $phone           = $sheetData[$i][4];
                        $email           = $sheetData[$i][5];
                        $contactPerson   = $sheetData[$i][6];
                        $coveragePercent = $sheetData[$i][7];
                        $defaultDueDays  = $sheetData[$i][8];
                        $isActive        = $sheetData[$i][9];

                        $code_td = (!empty($payerCode)) ? '' : " style='background:#E07171;'";
                        $name_td = (!empty($payerName)) ? '' : " style='background:#E07171;'";
                        $type_td = (!empty($payerType)) ? '' : " style='background:#E07171;'";

                        if (empty($payerCode) || empty($payerName) || empty($payerType)) {
                            $kosong++;
                        }

                        $output .= '<tr>
                            <td' . $code_td . '>' . htmlspecialchars($payerCode)       . '</td>
                            <td' . $name_td . '>' . htmlspecialchars($payerName)       . '</td>
                            <td' . $type_td . '>' . htmlspecialchars($payerType)       . '</td>
                            <td>'               . htmlspecialchars($address)         . '</td>
                            <td>'               . htmlspecialchars($phone)           . '</td>
                            <td>'               . htmlspecialchars($email)           . '</td>
                            <td>'               . htmlspecialchars($contactPerson)   . '</td>
                            <td>'               . htmlspecialchars($coveragePercent) . '</td>
                            <td>'               . htmlspecialchars($defaultDueDays)  . '</td>
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
                                $.post("' . site_url('tmstpayers/upload') . '",{})
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
                                    $("#payersTable").DataTable().ajax.reload(null,false);
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
                    $payerCode       = trim($sheetData[$i][0]);
                    $payerName       = trim($sheetData[$i][1]);
                    $payerType       = trim($sheetData[$i][2]);
                    $address         = trim($sheetData[$i][3]);
                    $phone           = trim($sheetData[$i][4]);
                    $email           = trim($sheetData[$i][5]);
                    $contactPerson   = trim($sheetData[$i][6]);
                    $coveragePercent = trim($sheetData[$i][7]);
                    $defaultDueDays  = trim($sheetData[$i][8]);
                    $isActive        = trim($sheetData[$i][9]);

                    if (empty($payerCode) || empty($payerName) || empty($payerType)) {
                        $failCount++;
                        $errors[] = 'Baris ' . ($i + 1) . ': Data tidak lengkap';
                        continue;
                    }

                    helper(['restclient']);
                    $url  = "{$this->server5}/api/Payers";
                    $body = [
                        'payerCode'       => $payerCode,
                        'payerName'       => $payerName,
                        'payerType'       => $payerType,
                        'address'         => $address,
                        'phone'           => $phone,
                        'email'           => $email,
                        'contactPerson'   => $contactPerson,
                        'coveragePercent' => $coveragePercent !== '' ? (float) $coveragePercent : 0,
                        'defaultDueDays'  => $defaultDueDays  !== '' ? (int)   $defaultDueDays  : 0,
                        'isActive'        => $isActive === '1' ? true : false,
                        'createdBy'       => $empCd,
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