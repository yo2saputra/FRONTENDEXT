<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as excel;

class Tmstjenispembayaran extends BaseController
{

    protected $data;
    protected $server;
    protected $server3;
    protected $client;

    public function __construct()
    {
        $this->server3 = $_ENV['APP_API3'];
    }

    public function index()
    {
        // helper dropdown
        helper(['dropdown']);

        $this->data['cb_aktif'] = getDropdownNolabelHorizontal2('aktif_sta');
        return view('tmstjenispembayaran/index', $this->data);
    }

    public function datatables()
    {
        helper(['restclient']);
        $rawBody = $this->request->getBody();
        $json = json_decode($rawBody, true);

        $url = "{$this->server3}/api/jenisPembayaran/datatables";
        $response = akses_restapikey('POST', $url, $json);
        $result = json_decode($response, true);

        // Tambahkan kolom aksi ke setiap data
        foreach ($result['data'] as $i => &$row) {
            $jenisPembayaranId = $row['jenisPembayaranId'];
            $row['rownum'] = $i + ($json['start'] ?? 0) + 1;
            
            // ✅ PERBAIKAN: Gunakan data-id saja (lebih simple)
            $row['aksi'] = '
            <div class="btn-group">
                <a class="btn btn-sm btn-info view ' . ($this->session->get("flag_view") === 1 ? "" : "d-none") . '" data-id="' . $jenisPembayaranId . '"><i class="fas fa-eye"></i></a>
                <a class="btn btn-sm btn-primary edit ' . ($this->session->get("flag_update") === 1 ? "" : "d-none") . '" data-id="' . $jenisPembayaranId . '"><i class="fas fa-tags"></i></a>
                <a class="btn btn-sm btn-danger delete ' . ($this->session->get("flag_delete") === 1 ? "" : "d-none") . '" data-id="' . $jenisPembayaranId . '"><i class="fas fa-trash"></i></a>
            </div>';
        }

        return $this->response->setJSON($result);
    }

    public function apiDataGetAll()
    {
        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "{$this->server3}/api/jenisPembayaran";

        // Parameter yang ingin dikirim
        $query = [
            'action' => 'getall',
            'jenisPembayaranId' => ''
        ];

        // client request
        $response = akses_restapikey('GET', $url, $body = [], $query);
        $data = json_decode($response, true);

        return $data["data"];
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $jenisPembayaranId = $this->request->getVar('jenisPembayaranId');

            // helper curl request
            helper(['restclient']);

            // endpoint
            $url = "{$this->server3}/api/jenisPembayaran";
            $query = [
                'jenisPembayaranId' => $jenisPembayaranId
            ];
            // client request
            $result = akses_restapikey('DELETE', $url, $body = [], $query);

            // pastikan hasilnya berupa array
            $result = is_string($result) ? json_decode($result, true) : $result;

            // Tampilkan hasil
            if (isset($result['success']) && $result['success'] === true) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => $result['message'] ?? 'Data Jenis Pembayaran berhasil dihapus',
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

                $validation = \Config\Services::validation();
                $valid = $this->validate([
                    // 'kode_mesin' => [
                    //     'label' => 'Kode Mesin',
                    //     'rules' => 'required',
                    //     'errors' => []
                    // ],
                    'jenisPembayaranNm' => [
                        'label' => 'Nama Mesin',
                        'rules' => 'required',
                        'errors' => []
                    ],
                    // 'lokasi_pos' => [
                    //     'label' => 'Lokasi',
                    //     'rules' => 'required',
                    //     'errors' => []
                    // ],
                    // 'bank' => [
                    //     'label' => 'Bank',
                    //     'rules' => 'required',
                    //     'errors' => []
                    // ],
                    // 'no_rekening' => [
                    //     'label' => 'No Rekening',
                    //     'rules' => 'required',
                    //     'errors' => []
                    // ],
                    // 'tanggal_aktif' => [
                    //     'label' => 'Tanggal Aktif',
                    //     'rules' => 'required',
                    //     'errors' => []
                    // ],
                    'aktif_sta' => [
                        'label' => 'jenisPembayaranStaId',
                        'rules' => 'required',
                        'errors' => []
                    ]
                ]);

                if (!$valid) {
                    return $this->response->setJSON([
                        'error' => [
                            // 'kode_mesin' => $validation->getError('kode_mesin'),
                            'jenisPembayaranNm' => $validation->getError('jenisPembayaranNm'),
                            // 'lokasi_pos' => $validation->getError('lokasi_pos'),
                            // 'bank' => $validation->getError('bank'),
                            // 'no_rekening' => $validation->getError('no_rekening'),
                            // 'tanggal_aktif' => $validation->getError('tanggal_aktif'),
                            'aktif_sta' => $validation->getError('aktif_sta')
                        ]
                    ]);
                } else {

                    if ($this->request->getVar('action') == 'Add') {

                        // helper curl request
                        helper(['restclient']);

                        // endpoint
                        $url = "{$this->server3}/api/jenisPembayaran";

                        // // Format tanggal dari datetime-local ke ISO 8601
                        // $tanggal_aktif = $this->request->getVar('tanggal_aktif');
                        
                        // datetime-local format: 2026-02-12T14:30
                        // Convert to ISO 8601: 2026-02-12T14:30:00.000Z
                        // if ($tanggal_aktif) {
                        //     $dt = new \DateTime($tanggal_aktif);
                        //     $formatted_date = $dt->format('Y-m-d\TH:i:s.v\Z');
                        // } else {
                        //     $formatted_date = date('Y-m-d\TH:i:s.v\Z');
                        // }

                        // form params - edc_id TIDAK dikirim karena auto-increment
                        $body = [
                            // "kode_mesin" => trim($this->request->getVar('kode_mesin')),
                            "jenisPembayaranNm" => trim($this->request->getVar('jenisPembayaranNm')),
                            // "lokasi_pos" => trim($this->request->getVar('lokasi_pos')),
                            // "bank" => trim($this->request->getVar('bank')),
                            // "no_rekening" => trim($this->request->getVar('no_rekening')),
                            // "tanggal_aktif" => $formatted_date,
                            "jenisPembayaranStaId" => $this->request->getVar('aktif_sta'),
                        ];

                        // Log untuk debugging
                        log_message('debug', 'Jenis Pembayaran Add Request: ' . json_encode($body));

                        // client request
                        $result = akses_restapikey('POST', $url, $body, $query = []);

                        // Log response
                        log_message('debug', 'Jenis Pembayaran Add Response: ' . $result);

                        // pastikan hasilnya berupa array
                        $result = is_string($result) ? json_decode($result, true) : $result;

                        // Tampilkan hasil
                        if (isset($result['success']) && $result['success'] === true) {
                            return $this->response->setJSON([
                                'status' => 'success',
                                'message' => 'Data Jenis Pembayaran berhasil ditambahkan',
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

                        // helper curl request
                        helper(['restclient']);

                        // endpoint
                        $url = "{$this->server3}/api/jenisPembayaran";

                        // Format tanggal dari datetime-local ke ISO 8601
                        // $tanggal_aktif = $this->request->getVar('tanggal_aktif');
                        
                        // // datetime-local format: 2026-02-12T14:30
                        // // Convert to ISO 8601: 2026-02-12T14:30:00.000Z
                        // if ($tanggal_aktif) {
                        //     $dt = new \DateTime($tanggal_aktif);
                        //     $formatted_date = $dt->format('Y-m-d\TH:i:s.v\Z');
                        // } else {
                        //     $formatted_date = date('Y-m-d\TH:i:s.v\Z');
                        // }

                        // Parameter query untuk identifier
                        $query = ['jenisPembayaranId' => $this->request->getVar('hidden_id')];
                        
                        $body = [
                            // 'kode_mesin' => trim($this->request->getVar('kode_mesin')),
                            'jenisPembayaranNm' => trim($this->request->getVar('jenisPembayaranNm')),
                            // 'lokasi_pos' => trim($this->request->getVar('lokasi_pos')),
                            // 'bank' => trim($this->request->getVar('bank')),
                            // 'no_rekening' => trim($this->request->getVar('no_rekening')),
                            // 'tanggal_aktif' => $formatted_date,
                            'jenisPembayaranStaId' => $this->request->getVar('aktif_sta'),
                        ];

                        // Log untuk debugging
                        log_message('debug', 'Jenis Pembayaran Edit Request: ' . json_encode($body));
                        log_message('debug', 'Jenis Pembayaran Edit Query: ' . json_encode($query));

                        // client request
                        $result = akses_restapikey('PUT', $url, $body, $query);

                        // Log response
                        log_message('debug', 'Jenis Pembayaran Edit Response: ' . $result);

                        // pastikan hasilnya berupa array
                        $result = is_string($result) ? json_decode($result, true) : $result;

                        // Tampilkan hasil
                        if (isset($result['success']) && $result['success'] === true) {
                            return $this->response->setJSON([
                                'jenisPembayaranStaId' => 'success',
                                'message' => 'Data Jenis Pembayaran berhasil diubah',
                                'data' => $result
                            ]);
                        } else {
                            return $this->response->setJSON([
                                'jenisPembayaranStaId' => 'error',
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

            $jenisPembayaranId = $this->request->getVar('jenisPembayaranId');

            if ($jenisPembayaranId) {

                // helper curl request
                helper(['restclient']);

                // end point
                $url = "{$this->server3}/api/jenisPembayaran";
                $query = [
                    'action' => 'getby',
                    'jenisPembayaranId' => $jenisPembayaranId
                ];

                // Log untuk debugging
                log_message('debug', 'Fetch Single Jenis Pembayaran - ID: ' . $jenisPembayaranId);
                log_message('debug', 'Fetch Single Jenis Pembayaran - Query: ' . json_encode($query));

                try {
                    // client request
                    $response = akses_restapikey('GET', $url, $body = [], $query);

                    // Log response
                    log_message('debug', 'Fetch Single Jenis Pembayaran Response: ' . $response);

                    $data = json_decode($response, true);

                    // Cek apakah response valid
                    if (!isset($data["data"]) || empty($data["data"])) {
                        log_message('error', 'Invalid response format: ' . $response);
                        return $this->response->setJSON([
                            'status' => 'error',
                            'message' => 'Data tidak ditemukan atau format response salah',
                            'raw_response' => $response
                        ]);
                    }

                    // Cek apakah data adalah array atau object
                    $jenisPembayaranData = isset($data["data"][0]) ? $data["data"][0] : $data["data"];

                    // Format tanggal untuk input datetime-local (YYYY-MM-DDTHH:MM)
                    // $tanggal_aktif = $edcData["tanggal_aktif"] ?? '';
                    // if ($tanggal_aktif) {
                    //     // Konversi dari ISO format "2026-02-12T00:00:00.000Z" ke "2026-02-12T00:00"
                    //     $dt = new \DateTime($tanggal_aktif);
                    //     $tanggal_aktif = $dt->format('Y-m-d');
                    // }

                    $msg = [
                        'status' => 'success',  // ✅ TAMBAHKAN                       
                        'data' => [
                            'jenisPembayaranId' => $jenisPembayaranData["jenisPembayaranId"] ?? '',
                            // 'kode_mesin' => $edcData["kode_mesin"] ?? '',
                            'jenisPembayaranNm' => $jenisPembayaranData["jenisPembayaranNm"] ?? '',
                            // 'lokasi_pos' => $edcData["lokasi_pos"] ?? '',
                            // 'bank' => $edcData["bank"] ?? '',
                            // 'no_rekening' => $edcData["no_rekening"] ?? '',
                            // 'tanggal_aktif' => $tanggal_aktif,
                            'jenisPembayaranStaId' => $jenisPembayaranData["jenisPembayaranStaId"] ?? '',
                        ]
                    ];

                    log_message('debug', 'Parsed Jenis Pembayaran Data: ' . json_encode($msg));

                    return $this->response->setJSON($msg);
                    
                } catch (\Exception $e) {
                    log_message('error', 'Exception in fetchSingleData: ' . $e->getMessage());
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                    ]);
                }
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'ID tidak ditemukan'
                ]);
            }
        } else {
            return $this->response->setJSON([
                'jenisPembayaranStaId' => 'error',
                'message' => 'Request bukan AJAX'
            ]);
        }
    }

    function fetchSingleDataPrint($jenisPembayaranId)
    {
        if ($jenisPembayaranId) {

            // helper curl request
            helper(['restclient']);

            // end point
            $url = "{$this->server3}/api/jenisPembayaran";
            $query = [
                'action' => 'getby',
                'jenisPembayaranId' => $jenisPembayaranId
            ];
            // client request
            $response = akses_restapikey('GET', $url, $body = [], $query);
            $data['response_data'] = json_decode($response, true);

            $pdf_data = $data['response_data'];
            $pdf_name = 'Single Data Jenis Pembayaran';
            $pdf_title = 'Data Jenis Pembayaran';
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
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue("A1", "Nama Jenis Pembayaran");
        $sheet->setCellValue("B1", "STATUS");
        

        $count = 2;

        $sheet->setCellValue("A" . $count, "");
        $sheet->setCellValue("B" . $count, "");


        $writer = new Xlsx($spreadsheet);
        $writer->save("data.xlsx");
        return $this->response->download("data.xlsx", null)->setFileName("TEMPLATE JENIS PEMBAYARAN.xlsx");
    }

    public function preview()
    {
        if ($this->request->getMethod() == "post") {
            $rules = $this->validate([
                'filename' => 'uploaded[filename]|max_size[filename,500]|ext_in[filename,csv,xlsx]',
            ]);
            if ($rules == true) {
                $filename = $this->request->getFile('filename');
                $name = $filename->getName();
                $tempName = $filename->getTempName();

                $path = WRITEPATH . 'uploads/';
                $filename->move($path, $filename->getName());

                $this->session->set("fileupload", $path . "" . $filename->getName());
            } else {
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
                             <th>Nama Jenis Pembayaran</th>
                             <th>Status</th>
                         </tr>
                     </thead>
                         ';
                if (empty($sheetData)) {
                    $output .= '<tr>
                                 <td colspan="7">Data not Found</td>
                             </tr>';
                } else {
                    if (count($sheetData) > 1) {
                        $kosong = 0;
                        for ($i = 1; $i < count($sheetData); $i++) {

                            $jenisPembayaranNm = $sheetData[$i][0];
                            $jenisPembayaranStaId = $sheetData[$i][1];

                            $jenisPembayaranNm_td = ($jenisPembayaranNm !== null && $jenisPembayaranNm !== '') ? "" : " style='background: #E07171;'";
                            $jenisPembayaranStaId_td = ($jenisPembayaranStaId !== null && $jenisPembayaranStaId !== '') ? "" : " style='background: #E07171;'";

                            // Jika salah satu data ada yang kosong
                            if (empty($jenisPembayaranNm) || empty($jenisPembayaranStaId)) {
                                $kosong++;
                            }

                            $output .= '
                            <tr>
                                <td ' . $jenisPembayaranNm_td . '>' . htmlspecialchars($jenisPembayaranNm) . '</td>
                                <td ' . $jenisPembayaranStaId_td . '>' . htmlspecialchars($jenisPembayaranStaId) . '</td>
                            </tr>
                            ';
                        }
                    }
                }
                $output .= '</table>

                 <script>
                 if(' . $kosong . '>0){
                    Swal.fire({
                        icon: "warning",
                        title: "Perhatian",
                        text: "Ada ' . $kosong . ' baris yang terdapat data kosong!"
                    });
                 }

                 $(function() {
                     $("#exampleImport").DataTable({
                         "responsive": true,
                         "lengthChange": false,
                         "autoWidth": false,
                         "buttons": [{
                            text: "Import",
                            action: function(e, dt, node, config) {

                                $.post("' . site_url('tmstjenispembayaran/upload') . '", {

                                })
                                .done(function(response) {
                                    Swal.fire({
                                        icon: "success",
                                        title: "Berhasil",
                                        text: response.success || "Data berhasil diimport."
                                    });
                                    $("#modalimport").modal("hide");
                                    $("#jenisPembayaranTable").DataTable().ajax.reload(null, false);
                                })
                                .fail(function(error) {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Gagal",
                                        text: error.responseJSON?.message || "Terjadi kesalahan saat mengimport data."
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

            // ✅ TAMBAHKAN FUNGSI HELPER untuk normalisasi status
            $normalizeStatus = function($status) {
                // Trim dan convert ke uppercase
                $status = strtoupper(trim($status));
                
                // Mapping berbagai variasi input ke kode standar
                $statusMap = [
                    'A' => 'A',
                    'AKTIF' => 'A',
                    'ACTIVE' => 'A',
                    'T' => 'T',
                    'TIDAK AKTIF' => 'T',
                    'TIDAKTAKTIF' => 'T',
                    'TIDAK' => 'T',
                    'INACTIVE' => 'T',
                    'NON AKTIF' => 'T',
                    'NONAKTIF' => 'T',
                    'NON-AKTIF' => 'T',
                ];
                
                // Cek apakah status ada di mapping
                if (isset($statusMap[$status])) {
                    return $statusMap[$status];
                }
                
                // Jika tidak ditemukan, return null atau nilai asli
                return null;
            };

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
            
            $successCount = 0;
            $failCount = 0;
            $errors = [];

            log_message('debug', '=== IMPORT START ===');
            log_message('debug', 'Total rows in Excel: ' . count($sheetData));

            if (!empty($sheetData)) {
                for ($i = 1; $i < count($sheetData); $i++) {
                    $jenisPembayaranNm = trim($sheetData[$i][0]);
                    $rawStatus = trim($sheetData[$i][1]);
                    
                    // ✅ NORMALISASI STATUS
                    $jenisPembayaranStaId = $normalizeStatus($rawStatus);

                    log_message('debug', "Row $i - Nama: $jenisPembayaranNm, Status Input: '$rawStatus', Status Normalized: '$jenisPembayaranStaId'");

                    // ✅ VALIDASI: Cek apakah status valid setelah normalisasi
                    if (empty($jenisPembayaranNm)) {
                        $failCount++;
                        $errors[] = "Baris " . ($i + 1) . ": Nama jenis pembayaran kosong";
                        log_message('debug', "Row $i - SKIPPED: Nama kosong");
                        continue;
                    }
                    
                    if ($jenisPembayaranStaId === null) {
                        $failCount++;
                        $errors[] = "Baris " . ($i + 1) . ": Status tidak valid ('$rawStatus'). Gunakan: A/Aktif atau T/Tidak Aktif";
                        log_message('debug', "Row $i - SKIPPED: Status tidak valid");
                        continue;
                    }

                    // helper curl request
                    helper(['restclient']);
                    // endpoint
                    $url = "{$this->server3}/api/jenisPembayaran";

                    $body = [
                        "jenisPembayaranNm" => $jenisPembayaranNm,
                        "jenisPembayaranStaId" => $jenisPembayaranStaId,
                    ];
                    
                    log_message('debug', 'Import Row ' . $i . ' - Request Body: ' . json_encode($body));

                    // client request
                    $response = akses_restapikey('POST', $url, $body, $query = []);
                    
                    log_message('debug', 'Import Row ' . $i . ' - API Response: ' . $response);

                    $result = is_string($response) ? json_decode($response, true) : $response;

                    log_message('debug', 'Import Row ' . $i . ' - Decoded Result: ' . json_encode($result));

                    if (isset($result['success']) && $result['success'] === true) {
                        $successCount++;
                        log_message('debug', "Row $i - SUCCESS");
                    } else {
                        $failCount++;
                        $errorMsg = $result['message'] ?? 'Gagal import';
                        $errors[] = "Baris " . ($i + 1) . ": " . $errorMsg;
                        log_message('error', "Row $i - FAILED: " . $errorMsg);
                        
                        if (isset($result['errors'])) {
                            log_message('error', "Row $i - Error Details: " . json_encode($result['errors']));
                        }
                    }
                }

                log_message('debug', '=== IMPORT END ===');
                log_message('debug', "Success: $successCount, Failed: $failCount");

                $msg = [
                    'success' => $successCount . ' data berhasil diimport' . ($failCount > 0 ? ', ' . $failCount . ' data gagal' : ''),
                    'details' => [
                        'success_count' => $successCount,
                        'fail_count' => $failCount,
                        'errors' => $errors
                    ]
                ];

                return $this->response->setJSON($msg);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'File Excel kosong'
                ]);
            }
        } else {
            return view("upload");
        }
    }
}