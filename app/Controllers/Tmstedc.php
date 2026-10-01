<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as excel;

class Tmstedc extends BaseController
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
        return view('tmstedc/index', $this->data);
    }

    public function datatables()
    {
        helper(['restclient']);
        $rawBody = $this->request->getBody();
        $json = json_decode($rawBody, true);

        $url = "{$this->server3}/api/edc/datatables";
        $response = akses_restapikey('POST', $url, $json);
        $result = json_decode($response, true);

        // Tambahkan kolom aksi ke setiap data
        foreach ($result['data'] as $i => &$row) {
            // if (isset($row['tanggal_aktif'])) {
            //     // Menggunakan DateTime PHP untuk format yang lebih fleksibel
            //     $date = new \DateTime($row['tanggal_aktif']);
            //     $row['tanggal_aktif'] = $date->format('d-m-Y'); 
            //     // Hasil: 2026-02-12 (Tanpa T00:00:00)
            // }
            $edc_id = $row['edc_id'];
            $row['rownum'] = $i + ($json['start'] ?? 0) + 1;
            $row['aksi'] = '
            <div class="btn-group">
                <a class="btn btn-sm btn-info view ' . ($this->session->get("flag_view") === 1 ? "" : "d-none") . '" data-edc_id="' . $edc_id . '"><i class="fas fa-eye"></i></a>
                <a class="btn btn-sm btn-primary edit ' . ($this->session->get("flag_update") === 1 ? "" : "d-none") . '" data-edc_id="' . $edc_id . '"><i class="fas fa-tags"></i></a>
                <a class="btn btn-sm btn-danger delete ' . ($this->session->get("flag_delete") === 1 ? "" : "d-none") . '" data-edc_id="' . $edc_id . '"><i class="fas fa-trash"></i></a>
            </div>';
        }

        return $this->response->setJSON($result);
    }

    public function apiDataGetAll()
    {
        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "{$this->server3}/api/edc";

        // Parameter yang ingin dikirim
        $query = [
            'action' => 'getall',
            'edc_id' => ''
        ];

        // client request
        $response = akses_restapikey('GET', $url, $body = [], $query);
        $data = json_decode($response, true);

        return $data["data"];
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $edc_id = $this->request->getVar('edc_id');

            // helper curl request
            helper(['restclient']);

            // endpoint
            $url = "{$this->server3}/api/edc";
            $query = [
                'edc_id' => $edc_id
            ];
            // client request
            $result = akses_restapikey('DELETE', $url, $body = [], $query);

            // pastikan hasilnya berupa array
            $result = is_string($result) ? json_decode($result, true) : $result;

            // Tampilkan hasil
            if (isset($result['success']) && $result['success'] === true) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => $result['message'] ?? 'Data EDC berhasil dihapus',
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
                    'kode_mesin' => [
                        'label' => 'Kode Mesin',
                        'rules' => 'required',
                        'errors' => []
                    ],
                    'nama_mesin' => [
                        'label' => 'Nama Mesin',
                        'rules' => 'required',
                        'errors' => []
                    ],
                    'lokasi_pos' => [
                        'label' => 'Lokasi',
                        'rules' => 'required',
                        'errors' => []
                    ],
                    'bank' => [
                        'label' => 'Bank',
                        'rules' => 'required',
                        'errors' => []
                    ],
                    'no_rekening' => [
                        'label' => 'No Rekening',
                        'rules' => 'required',
                        'errors' => []
                    ],
                    'tanggal_aktif' => [
                        'label' => 'Tanggal Aktif',
                        'rules' => 'required',
                        'errors' => []
                    ],
                    'aktif_sta' => [
                        'label' => 'Status',
                        'rules' => 'required',
                        'errors' => []
                    ]
                ]);

                if (!$valid) {
                    return $this->response->setJSON([
                        'error' => [
                            'kode_mesin' => $validation->getError('kode_mesin'),
                            'nama_mesin' => $validation->getError('nama_mesin'),
                            'lokasi_pos' => $validation->getError('lokasi_pos'),
                            'bank' => $validation->getError('bank'),
                            'no_rekening' => $validation->getError('no_rekening'),
                            'tanggal_aktif' => $validation->getError('tanggal_aktif'),
                            'aktif_sta' => $validation->getError('aktif_sta')
                        ]
                    ]);
                } else {

                    if ($this->request->getVar('action') == 'Add') {

                        // helper curl request
                        helper(['restclient']);

                        // endpoint
                        $url = "{$this->server3}/api/edc";

                        // Format tanggal dari datetime-local ke ISO 8601
                        $tanggal_aktif = $this->request->getVar('tanggal_aktif');
                        
                        // datetime-local format: 2026-02-12T14:30
                        // Convert to ISO 8601: 2026-02-12T14:30:00.000Z
                        if ($tanggal_aktif) {
                            $dt = new \DateTime($tanggal_aktif);
                            $formatted_date = $dt->format('Y-m-d\TH:i:s.v\Z');
                        } else {
                            $formatted_date = date('Y-m-d\TH:i:s.v\Z');
                        }

                        // form params - edc_id TIDAK dikirim karena auto-increment
                        $body = [
                            "kode_mesin" => trim($this->request->getVar('kode_mesin')),
                            "nama_mesin" => trim($this->request->getVar('nama_mesin')),
                            "lokasi_pos" => trim($this->request->getVar('lokasi_pos')),
                            "bank" => trim($this->request->getVar('bank')),
                            "no_rekening" => trim($this->request->getVar('no_rekening')),
                            "tanggal_aktif" => $formatted_date,
                            "status" => $this->request->getVar('aktif_sta'),
                        ];

                        // Log untuk debugging
                        log_message('debug', 'EDC Add Request: ' . json_encode($body));

                        // client request
                        $result = akses_restapikey('POST', $url, $body, $query = []);

                        // Log response
                        log_message('debug', 'EDC Add Response: ' . $result);

                        // pastikan hasilnya berupa array
                        $result = is_string($result) ? json_decode($result, true) : $result;

                        // Tampilkan hasil
                        if (isset($result['success']) && $result['success'] === true) {
                            return $this->response->setJSON([
                                'status' => 'success',
                                'message' => 'Data EDC berhasil ditambahkan',
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
                        $url = "{$this->server3}/api/edc";

                        // Format tanggal dari datetime-local ke ISO 8601
                        $tanggal_aktif = $this->request->getVar('tanggal_aktif');
                        
                        // datetime-local format: 2026-02-12T14:30
                        // Convert to ISO 8601: 2026-02-12T14:30:00.000Z
                        if ($tanggal_aktif) {
                            $dt = new \DateTime($tanggal_aktif);
                            $formatted_date = $dt->format('Y-m-d\TH:i:s.v\Z');
                        } else {
                            $formatted_date = date('Y-m-d\TH:i:s.v\Z');
                        }

                        // Parameter query untuk identifier
                        $query = ['edc_id' => $this->request->getVar('hidden_id')];
                        
                        $body = [
                            'kode_mesin' => trim($this->request->getVar('kode_mesin')),
                            'nama_mesin' => trim($this->request->getVar('nama_mesin')),
                            'lokasi_pos' => trim($this->request->getVar('lokasi_pos')),
                            'bank' => trim($this->request->getVar('bank')),
                            'no_rekening' => trim($this->request->getVar('no_rekening')),
                            'tanggal_aktif' => $formatted_date,
                            'status' => $this->request->getVar('aktif_sta'),
                        ];

                        // Log untuk debugging
                        log_message('debug', 'EDC Edit Request: ' . json_encode($body));
                        log_message('debug', 'EDC Edit Query: ' . json_encode($query));

                        // client request
                        $result = akses_restapikey('PUT', $url, $body, $query);

                        // Log response
                        log_message('debug', 'EDC Edit Response: ' . $result);

                        // pastikan hasilnya berupa array
                        $result = is_string($result) ? json_decode($result, true) : $result;

                        // Tampilkan hasil
                        if (isset($result['success']) && $result['success'] === true) {
                            return $this->response->setJSON([
                                'status' => 'success',
                                'message' => 'Data EDC berhasil diubah',
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

            $edc_id = $this->request->getVar('edc_id');

            if ($edc_id) {

                // helper curl request
                helper(['restclient']);

                // end point
                $url = "{$this->server3}/api/edc";
                $query = [
                    'action' => 'getby',
                    'edc_id' => $edc_id
                ];

                // Log untuk debugging
                log_message('debug', 'Fetch Single EDC - ID: ' . $edc_id);
                log_message('debug', 'Fetch Single EDC - Query: ' . json_encode($query));

                try {
                    // client request
                    $response = akses_restapikey('GET', $url, $body = [], $query);

                    // Log response
                    log_message('debug', 'Fetch Single EDC Response: ' . $response);

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
                    $edcData = isset($data["data"][0]) ? $data["data"][0] : $data["data"];

                    // Format tanggal untuk input datetime-local (YYYY-MM-DDTHH:MM)
                    $tanggal_aktif = $edcData["tanggal_aktif"] ?? '';
                    if ($tanggal_aktif) {
                        // Konversi dari ISO format "2026-02-12T00:00:00.000Z" ke "2026-02-12T00:00"
                        $dt = new \DateTime($tanggal_aktif);
                        $tanggal_aktif = $dt->format('Y-m-d');
                    }

                    $msg = [
                        'data' => [
                            'edc_id' => $edcData["edc_id"] ?? '',
                            'kode_mesin' => $edcData["kode_mesin"] ?? '',
                            'nama_mesin' => $edcData["nama_mesin"] ?? '',
                            'lokasi_pos' => $edcData["lokasi_pos"] ?? '',
                            'bank' => $edcData["bank"] ?? '',
                            'no_rekening' => $edcData["no_rekening"] ?? '',
                            'tanggal_aktif' => $tanggal_aktif,
                            'status' => $edcData["status"] ?? '',
                        ]
                    ];

                    log_message('debug', 'Parsed EDC Data: ' . json_encode($msg));

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
                'status' => 'error',
                'message' => 'Request bukan AJAX'
            ]);
        }
    }

    function fetchSingleDataPrint($edc_id)
    {
        if ($edc_id) {

            // helper curl request
            helper(['restclient']);

            // end point
            $url = "{$this->server3}/api/edc";
            $query = [
                'action' => 'getby',
                'edcID' => $edc_id
            ];
            // client request
            $response = akses_restapikey('GET', $url, $body = [], $query);
            $data['response_data'] = json_decode($response, true);

            $pdf_data = $data['response_data'];
            $pdf_name = 'Single Data EDC';
            $pdf_title = 'Data EDC';
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

        $sheet->setCellValue("A1", "KODE MESIN");
        $sheet->setCellValue("B1", "NAMA MESIN");
        $sheet->setCellValue("C1", "LOKASI");
        $sheet->setCellValue("D1", "BANK");
        $sheet->setCellValue("E1", "NO REKENING");
        $sheet->setCellValue("F1", "TANGGAL AKTIF");
        $sheet->setCellValue("G1", "STATUS");

        $count = 2;

        $sheet->setCellValue("A" . $count, "");
        $sheet->setCellValue("B" . $count, "");
        $sheet->setCellValue("C" . $count, "");
        $sheet->setCellValue("D" . $count, "");
        $sheet->setCellValue("E" . $count, "");
        $sheet->setCellValue("F" . $count, "");
        $sheet->setCellValue("G" . $count, "");

        $writer = new Xlsx($spreadsheet);
        $writer->save("data.xlsx");
        return $this->response->download("data.xlsx", null)->setFileName("TEMPLATE EDC.xlsx");
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
                             <th>Kode Mesin</th>
                             <th>Nama Mesin</th>
                             <th>Lokasi</th>
                             <th>Bank</th>
                             <th>No Rekening</th>
                             <th>Tanggal Aktif</th>
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

                            $kode_mesin = $sheetData[$i][0];
                            $nama_mesin = $sheetData[$i][1];
                            $lokasi_pos = $sheetData[$i][2];
                            $bank = $sheetData[$i][3];
                            $no_rekening = $sheetData[$i][4];
                            $tanggal_aktif = $sheetData[$i][5];
                            $status = $sheetData[$i][6];

                            $kode_mesin_td = ($kode_mesin !== null && $kode_mesin !== '') ? "" : " style='background: #E07171;'";
                            $nama_mesin_td = ($nama_mesin !== null && $nama_mesin !== '') ? "" : " style='background: #E07171;'";
                            $lokasi_pos_td = ($lokasi_pos !== null && $lokasi_pos !== '') ? "" : " style='background: #E07171;'";
                            $bank_td = ($bank !== null && $bank !== '') ? "" : " style='background: #E07171;'";
                            $no_rekening_td = ($no_rekening !== null && $no_rekening !== '') ? "" : " style='background: #E07171;'";
                            $tanggal_aktif_td = ($tanggal_aktif !== null && $tanggal_aktif !== '') ? "" : " style='background: #E07171;'";
                            $status_td = ($status !== null && $status !== '') ? "" : " style='background: #E07171;'";

                            // Jika salah satu data ada yang kosong
                            if (empty($kode_mesin) || empty($nama_mesin) || empty($lokasi_pos) || empty($bank) || empty($no_rekening) || empty($tanggal_aktif) || empty($status)) {
                                $kosong++;
                            }

                            $output .= '
                            <tr>
                                <td ' . $kode_mesin_td . '>' . htmlspecialchars($kode_mesin) . '</td>
                                <td ' . $nama_mesin_td . '>' . htmlspecialchars($nama_mesin) . '</td>
                                <td ' . $lokasi_pos_td . '>' . htmlspecialchars($lokasi_pos) . '</td>
                                <td ' . $bank_td . '>' . htmlspecialchars($bank) . '</td>
                                <td ' . $no_rekening_td . '>' . htmlspecialchars($no_rekening) . '</td>
                                <td ' . $tanggal_aktif_td . '>' . htmlspecialchars($tanggal_aktif) . '</td>
                                <td ' . $status_td . '>' . htmlspecialchars($status) . '</td>
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

                                $.post("' . site_url('tmstedc/upload') . '", {

                                })
                                .done(function(response) {
                                    Swal.fire({
                                        icon: "success",
                                        title: "Berhasil",
                                        text: response.success || "Data berhasil diimport."
                                    });
                                    $("#modalimport").modal("hide");
                                    $("#edcTable").DataTable().ajax.reload(null, false);
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

            if (!empty($sheetData)) {
                for ($i = 1; $i < count($sheetData); $i++) {
                    $kode_mesin = trim($sheetData[$i][0]);
                    $nama_mesin = trim($sheetData[$i][1]);
                    $lokasi_pos = trim($sheetData[$i][2]);
                    $bank = trim($sheetData[$i][3]);
                    $no_rekening = trim($sheetData[$i][4]);
                    $tanggal_aktif = $sheetData[$i][5];
                    $status = trim($sheetData[$i][6]);

                    // Skip jika ada data kosong
                    if (empty($kode_mesin) || empty($nama_mesin) || empty($lokasi_pos) || empty($bank) || empty($no_rekening) || empty($tanggal_aktif) || empty($status)) {
                        $failCount++;
                        $errors[] = "Baris " . ($i + 1) . ": Data tidak lengkap";
                        continue;
                    }

                    // Format tanggal ke ISO 8601
                    try {
                        // Jika dari Excel bisa berbentuk tanggal saja atau datetime
                        if (is_numeric($tanggal_aktif)) {
                            // Excel serial date number
                            $unix_date = ($tanggal_aktif - 25569) * 86400;
                            $dt = new \DateTime("@$unix_date");
                            $formatted_date = $dt->format('Y-m-d\TH:i:s.v\Z');
                        } else {
                            // String date/datetime
                            $dt = new \DateTime($tanggal_aktif);
                            $formatted_date = $dt->format('Y-m-d\TH:i:s.v\Z');
                        }
                    } catch (\Exception $e) {
                        $failCount++;
                        $errors[] = "Baris " . ($i + 1) . ": Format tanggal salah - " . $e->getMessage();
                        continue;
                    }

                    // helper curl request
                    helper(['restclient']);
                    // endpoint
                    $url = "{$this->server3}/api/edc";

                    $body = [
                        "kode_mesin" => $kode_mesin,
                        "nama_mesin" => $nama_mesin,
                        "lokasi_pos" => $lokasi_pos,
                        "bank" => $bank,
                        "no_rekening" => $no_rekening,
                        "tanggal_aktif" => $formatted_date,
                        "status" => $status,
                    ];

                    // Log untuk debugging
                    log_message('debug', 'Import EDC Row ' . $i . ': ' . json_encode($body));

                    // client request
                    $response = akses_restapikey('POST', $url, $body, $query = []);
                    
                    // Log response
                    log_message('debug', 'Import EDC Row ' . $i . ' Response: ' . $response);

                    $result = is_string($response) ? json_decode($response, true) : $response;

                    if (isset($result['success']) && $result['success'] === true) {
                        $successCount++;
                    } else {
                        $failCount++;
                        $errors[] = "Baris " . ($i + 1) . ": " . ($result['message'] ?? 'Gagal import');
                    }
                }

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