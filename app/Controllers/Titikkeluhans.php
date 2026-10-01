<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as excel;

class Titikkeluhans extends BaseController
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
        return view('titikkeluhans/index', $this->data);
    }

    public function datatables()
    {
        helper(['restclient']);
        $rawBody = $this->request->getBody();
        $json    = json_decode($rawBody, true);

        $url      = "{$this->server5}/api/TitikKeluhans/datatable";
        $response = akses_restapikey('POST', $url, $json);
        $result   = json_decode($response, true);

        foreach ($result['data'] as $i => &$row) {
            $titikKeluhanId = $row['id'];
            $row['rownum']  = $i + ($json['start'] ?? 0) + 1;

            $row['aksi'] = '
            <div class="btn-group">
                <a class="btn btn-sm btn-info view '    . ($this->session->get('flag_view')   === 1 ? '' : 'd-none') . '" data-id="' . $titikKeluhanId . '"><i class="fas fa-eye"></i></a>
                <a class="btn btn-sm btn-primary edit ' . ($this->session->get('flag_update') === 1 ? '' : 'd-none') . '" data-id="' . $titikKeluhanId . '"><i class="fas fa-tags"></i></a>
                <a class="btn btn-sm btn-danger delete ' . ($this->session->get('flag_delete') === 1 ? '' : 'd-none') . '" data-id="' . $titikKeluhanId . '"><i class="fas fa-trash"></i></a>
            </div>';
        }

        return $this->response->setJSON($result);
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $titikKeluhanId = $this->request->getVar('titikKeluhanId');

            helper(['restclient']);

            $url    = "{$this->server5}/api/TitikKeluhans/{$titikKeluhanId}";
            $result = akses_restapikey('DELETE', $url, [], []);
            $result = is_string($result) ? json_decode($result, true) : $result;

            if (isset($result['success']) && $result['success'] === true) {
                return $this->response->setJSON([
                    'status'  => 'success',
                    'message' => $result['message'] ?? 'Data Titik Keluhan berhasil dihapus',
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

                if (empty(trim($this->request->getVar('nama')))) {
                    $errors['nama'] = 'Nama harus diisi';
                }
                if (empty(trim($this->request->getVar('slug')))) {
                    $errors['slug'] = 'Slug harus diisi';
                }

                if (!empty($errors)) {
                    return $this->response->setJSON(['error' => $errors]);
                }

                $empCd = $this->session->get('fullname') ?? '';

                // subUnitIds[] arrives as a normal array from the select2
                // multiple field; force it to an array even if empty/absent.
                $subUnitIds = $this->request->getVar('subUnitIds') ?? [];
                if (!is_array($subUnitIds)) {
                    $subUnitIds = [$subUnitIds];
                }

                $isAllPoly = $this->request->getVar('isAllPoly') === '1' ? true : false;

                $body = [
                    'nama'       => trim($this->request->getVar('nama')),
                    'slug'       => trim($this->request->getVar('slug')),
                    'gambar'     => trim($this->request->getVar('gambar')),
                    'isAllPoly'  => $isAllPoly,
                    'isActive'   => $this->request->getVar('isActive') === '1' ? true : false,
                    // Ignored server-side when isAllPoly = true
                    'subUnitIds' => $isAllPoly ? [] : array_values($subUnitIds),
                ];

                helper(['restclient']);

                if ($this->request->getVar('action') === 'Add') {
                    $body['createdBy'] = $empCd;
                    $url = "{$this->server5}/api/TitikKeluhans";

                    log_message('debug', 'TitikKeluhan Add Request: ' . json_encode($body));
                    $result = akses_restapikey('POST', $url, $body, []);
                    log_message('debug', 'TitikKeluhan Add Response: ' . $result);
                    $result = is_string($result) ? json_decode($result, true) : $result;

                    if (isset($result['success']) && $result['success'] === true) {
                        return $this->response->setJSON([
                            'status'  => 'success',
                            'message' => 'Data Titik Keluhan berhasil ditambahkan',
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
                    $body['updatedBy']     = $empCd;
                    $titikKeluhanId = $this->request->getVar('hidden_id');
                    $url            = "{$this->server5}/api/TitikKeluhans/{$titikKeluhanId}";

                    log_message('debug', 'TitikKeluhan Edit Request: ' . json_encode($body));
                    $result = akses_restapikey('PUT', $url, $body, []);
                    log_message('debug', 'TitikKeluhan Edit Response: ' . $result);
                    $result = is_string($result) ? json_decode($result, true) : $result;

                    if (isset($result['success']) && $result['success'] === true) {
                        return $this->response->setJSON([
                            'status'  => 'success',
                            'message' => 'Data Titik Keluhan berhasil diubah',
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
            $titikKeluhanId = $this->request->getVar('titikKeluhanId');

            if ($titikKeluhanId) {
                helper(['restclient']);

                $url = "{$this->server5}/api/TitikKeluhans/{$titikKeluhanId}";

                log_message('debug', 'Fetch Single TitikKeluhan - ID: ' . $titikKeluhanId);

                try {
                    $response = akses_restapikey('GET', $url, [], []);
                    log_message('debug', 'Fetch Single TitikKeluhan Response: ' . $response);

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
                            'titikKeluhanId' => $d['id']             ?? '',
                            'nama'           => $d['nama']           ?? '',
                            'slug'           => $d['slug']           ?? '',
                            'gambar'         => $d['gambar']         ?? '',
                            'isAllPoly'      => $d['isAllPoly']      ?? false,
                            'isActive'       => $d['isActive']       ?? true,
                            'createdBy'      => $d['createdBy']      ?? '',
                            'createdDate'    => $d['createdDate']    ?? '',
                            'updatedBy'      => $d['updatedBy']      ?? '',
                            'updatedDate'    => $d['updatedDate']    ?? '',
                            // Raw ids (for the payload) + id/text pairs (to pre-fill select2 labels)
                            'subUnitIds'     => $d['subUnitIds']     ?? [],
                            'subUnitOptions' => $d['subUnitOptions'] ?? [],
                        ]
                    ]);
                } catch (\Exception $e) {
                    log_message('error', 'Exception in fetchSingleData TitikKeluhan: ' . $e->getMessage());
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

    // Proxy for select2 ajax "processResults" - front-end hits this instead of
    // calling the .NET API directly.
    public function subunitOptions()
    {
        helper(['restclient']);

        $search = $this->request->getVar('search') ?? '';
        $url    = "{$this->server5}/api/TitikKeluhans/subunit-options?search=" . urlencode($search);

        $response = akses_restapikey('GET', $url, [], []);
        $result   = is_string($response) ? json_decode($response, true) : $response;

        // API already returns { results: [{ id, text }, ...] } - pass through as-is
        return $this->response->setJSON($result);
    }

    public function download()
    {
        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Nama');
        $sheet->setCellValue('B1', 'Slug');
        $sheet->setCellValue('C1', 'Gambar');
        $sheet->setCellValue('D1', 'Berlaku Semua Sub Unit (1/0)');
        $sheet->setCellValue('E1', 'Is Active (1/0)');

        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save('data.xlsx');
        return $this->response->download('data.xlsx', null)->setFileName('TEMPLATE TITIK KELUHAN.xlsx');
    }

    public function uploadGambar()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Request bukan AJAX']);
        }

        $rules = [
            'gambar_file' => 'uploaded[gambar_file]|max_size[gambar_file,2048]|is_image[gambar_file]|ext_in[gambar_file,jpg,jpeg,png]',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => $this->validator->getError('gambar_file'),
            ]);
        }

        $file = $this->request->getFile('gambar_file');

        if (!$file || !$file->isValid() || $file->hasMoved()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'File tidak valid atau tidak ditemukan']);
        }

        $newName   = $file->getRandomName();
        $uploadDir = FCPATH . 'dist/img/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        try {
            $file->move($uploadDir, $newName);
        } catch (\Exception $e) {
            log_message('error', 'Gagal upload gambar titik keluhan: ' . $e->getMessage());
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal menyimpan file']);
        }

        return $this->response->setJSON([
            'status'   => 'success',
            'message'  => 'Gambar berhasil diupload',
            'filename' => $newName,
            'url'      => base_url('dist/img/' . $newName),
        ]);
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
                    <th>Nama</th><th>Slug</th><th>Gambar</th><th>Semua Sub Unit</th><th>Is Active</th>
                </tr></thead><tbody>';

                if (empty($sheetData)) {
                    $output .= '<tr><td colspan="5">Data not Found</td></tr>';
                } else {
                    $kosong = 0;
                    for ($i = 1; $i < count($sheetData); $i++) {
                        $nama      = $sheetData[$i][0];
                        $slug      = $sheetData[$i][1];
                        $gambar    = $sheetData[$i][2];
                        $isAllPoly = $sheetData[$i][3];
                        $isActive  = $sheetData[$i][4];

                        $nama_td = (!empty($nama)) ? '' : " style='background:#E07171;'";
                        $slug_td = (!empty($slug)) ? '' : " style='background:#E07171;'";

                        if (empty($nama) || empty($slug)) {
                            $kosong++;
                        }

                        $output .= '<tr>
                            <td' . $nama_td . '>' . htmlspecialchars($nama)   . '</td>
                            <td' . $slug_td . '>' . htmlspecialchars($slug)   . '</td>
                            <td>'                 . htmlspecialchars($gambar) . '</td>
                            <td>'                 . htmlspecialchars($isAllPoly) . '</td>
                            <td>'                 . htmlspecialchars($isActive)  . '</td>
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
                                $.post("' . site_url('titikkeluhans/upload') . '",{})
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
                                    $("#titikKeluhansTable").DataTable().ajax.reload(null,false);
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
                    $nama      = trim($sheetData[$i][0]);
                    $slug      = trim($sheetData[$i][1]);
                    $gambar    = trim($sheetData[$i][2]);
                    $isAllPoly = trim($sheetData[$i][3]);
                    $isActive  = trim($sheetData[$i][4]);

                    if (empty($nama) || empty($slug)) {
                        $failCount++;
                        $errors[] = 'Baris ' . ($i + 1) . ': Data tidak lengkap';
                        continue;
                    }

                    helper(['restclient']);
                    $url  = "{$this->server5}/api/TitikKeluhans";
                    $body = [
                        'nama'       => $nama,
                        'slug'       => $slug,
                        'gambar'     => $gambar,
                        'isAllPoly'  => $isAllPoly === '1' ? true : false,
                        'isActive'   => $isActive === '1' ? true : false,
                        // Bulk import doesn't assign sub units - edit the row afterwards to set them
                        'subUnitIds' => [],
                        'createdBy'  => $empCd,
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
