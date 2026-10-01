<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as excel;

    class Tmstprincipals extends BaseController
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
        return view('tmstprincipals/index', $this->data);
    }

    public function datatables()
    {
        helper(['restclient']);
        $rawBody = $this->request->getBody();
        $json    = json_decode($rawBody, true);

        $url      = "{$this->server5}/api/Principals/datatable";
        $response = akses_restapikey('POST', $url, $json);
        $result   = json_decode($response, true);

        if (!isset($result['data']) || !is_array($result['data'])) {
            log_message('error', 'Principals Datatables invalid response: ' . $response);
            return $this->response->setJSON([
                'draw'            => $json['draw'] ?? 1,
                'recordsTotal'    => 0,
                'recordsFiltered' => 0,
                'data'            => []
            ]);
        }

        foreach ($result['data'] as $i => &$row) {
            $principalId   = $row['principalId'];
            $row['rownum'] = $i + ($json['start'] ?? 0) + 1;

            $row['aksi'] = '
            <div class="btn-group">
                <a class="btn btn-sm btn-info view '    . ($this->session->get('flag_view')   === 1 ? '' : 'd-none') . '" data-id="' . $principalId . '"><i class="fas fa-eye"></i></a>
                <a class="btn btn-sm btn-primary edit ' . ($this->session->get('flag_update') === 1 ? '' : 'd-none') . '" data-id="' . $principalId . '"><i class="fas fa-tags"></i></a>
                <a class="btn btn-sm btn-danger delete '. ($this->session->get('flag_delete') === 1 ? '' : 'd-none') . '" data-id="' . $principalId . '"><i class="fas fa-trash"></i></a>
            </div>';
        }

        return $this->response->setJSON($result);
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $principalId = $this->request->getVar('principalId');

            helper(['restclient']);

            $url    = "{$this->server5}/api/Principals/{$principalId}";
            $result = akses_restapikey('DELETE', $url, [], []);
            $result = is_string($result) ? json_decode($result, true) : $result;

            if (isset($result['success']) && $result['success'] === true) {
                return $this->response->setJSON([
                    'status'  => 'success',
                    'message' => $result['message'] ?? 'Data Principal berhasil dihapus',
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

                if (empty(trim($this->request->getVar('principalCode')))) {
                    $errors['principalCode'] = 'Principal Code harus diisi';
                }
                if (empty(trim($this->request->getVar('principalName')))) {
                    $errors['principalName'] = 'Principal Name harus diisi';
                }
                if (empty(trim($this->request->getVar('address')))) {
                    $errors['address'] = 'Address harus diisi';
                }

                if (!empty($errors)) {
                    return $this->response->setJSON(['error' => $errors]);
                }

                $empCd = $this->session->get('fullname') ?? '';

                $body = [
                    'principalCode' => trim($this->request->getVar('principalCode')),
                    'principalName' => trim($this->request->getVar('principalName')),
                    'address'       => trim($this->request->getVar('address')),
                    'city'          => trim($this->request->getVar('city')),
                    'province'      => trim($this->request->getVar('province')),
                    'country'       => trim($this->request->getVar('country')),
                    'phone'         => trim($this->request->getVar('phone')),
                    'email'         => trim($this->request->getVar('email')),
                    'website'       => trim($this->request->getVar('website')),
                    'contactPerson' => trim($this->request->getVar('contactPerson')),
                    'taxNumber'     => trim($this->request->getVar('taxNumber')),
                    'logoUrl'       => trim($this->request->getVar('logoUrl')),
                    'isActive'      => $this->request->getVar('isActive') === '1' ? true : false,
                ];

                helper(['restclient']);

                if ($this->request->getVar('action') === 'Add') {
                    $body['createdBy'] = $empCd;
                    $url = "{$this->server5}/api/Principals";

                    log_message('debug', 'Principal Add Request: ' . json_encode($body));
                    $result = akses_restapikey('POST', $url, $body, []);
                    log_message('debug', 'Principal Add Response: ' . $result);
                    $result = is_string($result) ? json_decode($result, true) : $result;

                    if (isset($result['success']) && $result['success'] === true) {
                        return $this->response->setJSON([
                            'status'  => 'success',
                            'message' => 'Data Principal berhasil ditambahkan',
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
                    $principalId = $this->request->getVar('hidden_id');
                    $url         = "{$this->server5}/api/Principals/{$principalId}";

                    log_message('debug', 'Principal Edit Request: ' . json_encode($body));
                    $result = akses_restapikey('PUT', $url, $body, []);
                    log_message('debug', 'Principal Edit Response: ' . $result);
                    $result = is_string($result) ? json_decode($result, true) : $result;

                    if (isset($result['success']) && $result['success'] === true) {
                        return $this->response->setJSON([
                            'status'  => 'success',
                            'message' => 'Data Principal berhasil diubah',
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
            $principalId = $this->request->getVar('principalId');

            if ($principalId) {
                helper(['restclient']);

                $url = "{$this->server5}/api/Principals/{$principalId}";

                log_message('debug', 'Fetch Single Principal - ID: ' . $principalId);

                try {
                    $response = akses_restapikey('GET', $url, [], []);
                    log_message('debug', 'Fetch Single Principal Response: ' . $response);

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
                            'principalId'   => $d['principalId']   ?? '',
                            'principalCode' => $d['principalCode'] ?? '',
                            'principalName' => $d['principalName'] ?? '',
                            'address'       => $d['address']       ?? '',
                            'city'          => $d['city']          ?? '',
                            'province'      => $d['province']      ?? '',
                            'country'       => $d['country']       ?? '',
                            'phone'         => $d['phone']         ?? '',
                            'email'         => $d['email']         ?? '',
                            'website'       => $d['website']       ?? '',
                            'contactPerson' => $d['contactPerson'] ?? '',
                            'taxNumber'     => $d['taxNumber']     ?? '',
                            'logoUrl'       => $d['logoUrl']       ?? '',
                            'isActive'      => $d['isActive']      ?? true,
                            'createdBy'     => $d['createdBy']     ?? '',
                            'createdDate'   => $d['createdDate']   ?? '',
                            'updatedBy'     => $d['updatedBy']     ?? '',
                            'updatedDate'   => $d['updatedDate']   ?? '',
                        ]
                    ]);
                } catch (\Exception $e) {
                    log_message('error', 'Exception in fetchSingleData Principal: ' . $e->getMessage());
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

        $sheet->setCellValue('A1', 'Principal Code');
        $sheet->setCellValue('B1', 'Principal Name');
        $sheet->setCellValue('C1', 'Address');
        $sheet->setCellValue('D1', 'City');
        $sheet->setCellValue('E1', 'Province');
        $sheet->setCellValue('F1', 'Country');
        $sheet->setCellValue('G1', 'Phone');
        $sheet->setCellValue('H1', 'Email');
        $sheet->setCellValue('I1', 'Website');
        $sheet->setCellValue('J1', 'Contact Person');
        $sheet->setCellValue('K1', 'Tax Number');
        $sheet->setCellValue('L1', 'Logo URL');
        $sheet->setCellValue('M1', 'Is Active (1/0)');

        foreach (range('A', 'M') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save('data.xlsx');
        return $this->response->download('data.xlsx', null)->setFileName('TEMPLATE PRINCIPALS.xlsx');
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
                    <th>Principal Code</th><th>Principal Name</th><th>Address</th>
                    <th>City</th><th>Province</th><th>Country</th><th>Phone</th>
                    <th>Email</th><th>Website</th><th>Contact Person</th>
                    <th>Tax Number</th><th>Logo URL</th><th>Is Active</th>
                </tr></thead><tbody>';

                if (empty($sheetData)) {
                    $output .= '<tr><td colspan="13">Data not Found</td></tr>';
                } else {
                    $kosong = 0;
                    for ($i = 1; $i < count($sheetData); $i++) {
                        $principalCode = $sheetData[$i][0];
                        $principalName = $sheetData[$i][1];
                        $address       = $sheetData[$i][2];
                        $city          = $sheetData[$i][3];
                        $province      = $sheetData[$i][4];
                        $country       = $sheetData[$i][5];
                        $phone         = $sheetData[$i][6];
                        $email         = $sheetData[$i][7];
                        $website       = $sheetData[$i][8];
                        $contactPerson = $sheetData[$i][9];
                        $taxNumber     = $sheetData[$i][10];
                        $logoUrl       = $sheetData[$i][11];
                        $isActive      = $sheetData[$i][12];

                        $code_td = (!empty($principalCode)) ? '' : " style='background:#E07171;'";
                        $name_td = (!empty($principalName)) ? '' : " style='background:#E07171;'";
                        $addr_td = (!empty($address))       ? '' : " style='background:#E07171;'";

                        if (empty($principalCode) || empty($principalName) || empty($address)) {
                            $kosong++;
                        }

                        $output .= '<tr>
                            <td' . $code_td . '>' . htmlspecialchars($principalCode) . '</td>
                            <td' . $name_td . '>' . htmlspecialchars($principalName) . '</td>
                            <td' . $addr_td . '>' . htmlspecialchars($address)       . '</td>
                            <td>'               . htmlspecialchars($city)          . '</td>
                            <td>'               . htmlspecialchars($province)      . '</td>
                            <td>'               . htmlspecialchars($country)       . '</td>
                            <td>'               . htmlspecialchars($phone)         . '</td>
                            <td>'               . htmlspecialchars($email)         . '</td>
                            <td>'               . htmlspecialchars($website)       . '</td>
                            <td>'               . htmlspecialchars($contactPerson) . '</td>
                            <td>'               . htmlspecialchars($taxNumber)     . '</td>
                            <td>'               . htmlspecialchars($logoUrl)       . '</td>
                            <td>'               . htmlspecialchars($isActive)      . '</td>
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
                                $.post("' . site_url('tmstprincipals/upload') . '",{})
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
                                    $("#principalsTable").DataTable().ajax.reload(null,false);
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
                    $principalCode = trim($sheetData[$i][0]);
                    $principalName = trim($sheetData[$i][1]);
                    $address       = trim($sheetData[$i][2]);
                    $city          = trim($sheetData[$i][3]);
                    $province      = trim($sheetData[$i][4]);
                    $country       = trim($sheetData[$i][5]);
                    $phone         = trim($sheetData[$i][6]);
                    $email         = trim($sheetData[$i][7]);
                    $website       = trim($sheetData[$i][8]);
                    $contactPerson = trim($sheetData[$i][9]);
                    $taxNumber     = trim($sheetData[$i][10]);
                    $logoUrl       = trim($sheetData[$i][11]);
                    $isActive      = trim($sheetData[$i][12]);

                    if (empty($principalCode) || empty($principalName) || empty($address)) {
                        $failCount++;
                        $errors[] = 'Baris ' . ($i + 1) . ': Data tidak lengkap';
                        continue;
                    }

                    helper(['restclient']);
                    $url  = "{$this->server5}/api/Principals";
                    $body = [
                        'principalCode' => $principalCode,
                        'principalName' => $principalName,
                        'address'       => $address,
                        'city'          => $city,
                        'province'      => $province,
                        'country'       => $country,
                        'phone'         => $phone,
                        'email'         => $email,
                        'website'       => $website,
                        'contactPerson' => $contactPerson,
                        'taxNumber'     => $taxNumber,
                        'logoUrl'       => $logoUrl,
                        'isActive'      => $isActive === '1' ? true : false,
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