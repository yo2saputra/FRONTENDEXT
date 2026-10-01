<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as excel;

class Tmstpakethdr extends BaseController
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
        return view('tmstpakethdr/index', $this->data);
    }

    public function datatables()
    {
        helper(['restclient']);
        $rawBody = $this->request->getBody();
        $json = json_decode($rawBody, true);

        $url = "{$this->server3}/api/mi-paket-hdr/datatables";
        $response = akses_restapikey('POST', $url, $json);
        $result = json_decode($response, true);

        foreach ($result['data'] as $i => &$row) {
            $id = $row['paket_ID'];
            $row['rownum'] = $i + ($json['start'] ?? 0) + 1;
            $row['aksi'] = '
            <div class="btn-group">
                <a class="btn btn-sm btn-info view ' . ($this->session->get("flag_view") === 1 ? "" : "d-none") . '" data-paket_id="' . $id . '"><i class="fas fa-eye"></i></a>
                <a class="btn btn-sm btn-primary edit ' . ($this->session->get("flag_update") === 1 ? "" : "d-none") . '" data-paket_id="' . $id . '"><i class="fas fa-tags"></i></a>
                <a class="btn btn-sm btn-danger delete ' . ($this->session->get("flag_delete") === 1 ? "" : "d-none") . '" data-paket_id="' . $id . '"><i class="fas fa-trash"></i></a>
            </div>';
        }

        return $this->response->setJSON($result);
    }

    public function fetchAll()
    {
        helper(['restclient']);

        $url = "{$this->server3}/api/mi-paket-hdr";

        $query = [
            'action' => 'getall',
            'paketId' => ''
        ];

        $response = akses_restapikey('GET', $url, $body = [], $query);
        $data = json_decode($response, true);

        return $data["data"];
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $paket_id = $this->request->getVar('paket_id');

            helper(['restclient']);

            $url = "{$this->server3}/api/mi-paket-hdr/{$paket_id}";
            $query = [];

            $result = akses_restapikey('DELETE', $url, $body = [], $query);

            $result = is_string($result) ? json_decode($result, true) : $result;

            if (isset($result['success']) && $result['success'] === true) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => $result['message'] ?? 'Data paket berhasil dihapus',
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
                    'paket_Name' => [
                        'label' => 'Nama Paket',
                        'rules' => 'required',
                        'errors' => []
                    ],
                    'jumlah_Visit' => [
                        'label' => 'Jumlah Visit',
                        'rules' => 'required',
                        'errors' => []
                    ],
                    'include_Admin' => [
                        'label' => 'Include Admin',
                        'rules' => 'required',
                        'errors' => []
                    ],
                ]);

                if (!$valid) {
                    return $this->response->setJSON([
                        'error' => [
                            'paket_ID'      => $validation->getError('paket_ID'),
                            'paket_Name'    => $validation->getError('paket_Name'),
                            'jumlah_Visit'  => $validation->getError('jumlah_Visit'),
                            'include_Admin' => $validation->getError('include_Admin'),
                        ]
                    ]);
                } else {

                    if ($this->request->getVar('action') == 'Add') {

                        helper(['restclient']);

                        $url = "{$this->server3}/api/mi-paket-hdr";

                        $body = [
                            "paket_ID"      => str_replace(" ", "_", trim($this->request->getVar('paket_ID'))),
                            "paket_Name"    => $this->request->getVar('paket_Name'),
                            "jumlah_Visit"  => (int) $this->request->getVar('jumlah_Visit'),
                            "include_Admin" => $this->request->getVar('include_Admin'),
                        ];

                        $result = akses_restapikey('POST', $url, $body, $query = []);
                        $result = is_string($result) ? json_decode($result, true) : $result;

                        if (isset($result['success']) && $result['success'] === true) {
                            return $this->response->setJSON([
                                'status' => 'success',
                                'message' => 'Data paket berhasil ditambahkan',
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

                        $paket_id = str_replace(" ", "_", trim($this->request->getVar('paket_ID')));
                        $url = "{$this->server3}/api/mi-paket-hdr/{$paket_id}";

                        $body = [
                            "paket_Name"    => $this->request->getVar('paket_Name'),
                            "jumlah_Visit"  => (int) $this->request->getVar('jumlah_Visit'),
                            "include_Admin" => $this->request->getVar('include_Admin'),
                        ];

                        $result = akses_restapikey('PUT', $url, $body, $query = []);
                        $result = is_string($result) ? json_decode($result, true) : $result;

                        if (isset($result['success']) && $result['success'] === true) {
                            return $this->response->setJSON([
                                'status' => 'success',
                                'message' => 'Data paket berhasil diubah',
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

            $paket_id = $this->request->getVar('paket_id');

            if ($paket_id) {

                helper(['restclient']);

                $url = "{$this->server3}/api/mi-paket-hdr/{$paket_id}";

                $response = akses_restapikey('GET', $url, $body = [], $query = []);
                $data = json_decode($response, true);

                $msg = [
                    'data' => [
                        'paket_ID'      => $data["data"][0]["paket_ID"]      ?? $data["data"]["paket_ID"]      ?? '',
                        'paket_Name'    => $data["data"][0]["paket_Name"]    ?? $data["data"]["paket_Name"]    ?? '',
                        'jumlah_Visit'  => $data["data"][0]["jumlah_Visit"]  ?? $data["data"]["jumlah_Visit"]  ?? '',
                        'include_Admin' => $data["data"][0]["include_Admin"] ?? $data["data"]["include_Admin"] ?? '',
                    ]
                ];

                echo json_encode($msg);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    function fetchSingleDataPrint($paket_id)
    {
        if ($paket_id) {

            helper(['restclient']);

            $url = "{$this->server3}/api/mi-paket-hdr/{$paket_id}";

            $response = akses_restapikey('GET', $url, $body = [], $query = []);
            $data['response_data'] = json_decode($response, true);

            $pdf_data = $data['response_data'];
            $pdf_name = 'Single Data Paket';
            $pdf_title = 'Data Paket';
            $pdf_paper = 'A4';
            $pdf_orientation = 'portrait';
            $pdf_format = 'laporan_pdf';

            $this->view_pdf($pdf_name, $pdf_title, $pdf_data, $pdf_paper, $pdf_orientation, $pdf_format);
        }
    }

    public function view_pdf($pdf_name, $pdf_title, $pdf_data, $pdf_paper, $pdf_orientation, $pdf_format)
    {
        $Pdfgenerator = new Pdfgenerator();

        $file_pdf = $pdf_name;
        $this->data['title_pdf'] = $pdf_title;
        $this->data['produk'] = $pdf_data;

        $paper = $pdf_paper;
        $orientation = $pdf_orientation;

        $html = view($pdf_format, $this->data);
        $Pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
    }

    public function download()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue("A1", "KODE");
        $sheet->setCellValue("B1", "NAMA PAKET");
        $sheet->setCellValue("C1", "JUMLAH VISIT");
        $sheet->setCellValue("D1", "INCLUDE ADMIN");

        $count = 2;
        $sheet->setCellValue("A" . $count, "");
        $sheet->setCellValue("B" . $count, "");
        $sheet->setCellValue("C" . $count, "");
        $sheet->setCellValue("D" . $count, "");

        $writer = new Xlsx($spreadsheet);
        $writer->save("data.xlsx");
        return $this->response->download("data.xlsx", null)->setFileName("TEMPLATE PAKET HDR.xlsx");
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
                $this->session->set("fileupload", $path . "" . $filename->getName());
            } else {
                return $this->response->setStatusCode(400)->setJSON(['error' => 'File yang diunggah harus berformat .xlsx']);
            }
        } else {

            if ($this->session->get("fileupload") !== '') {

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
                             <th>Nama Paket</th>
                             <th>Jumlah Visit</th>
                             <th>Include Admin</th>
                         </tr>
                     </thead>
                         ';
                if (empty($sheetData)) {
                    $output .= '<tr>
                                 <td>Data not Found</td>
                                 <td></td><td></td><td></td>
                             </tr>';
                } else {
                    if (count($sheetData) > 1) {
                        $kosong = 0;
                        for ($i = 1; $i < count($sheetData); $i++) {

                            $paket_ID      = $sheetData[$i][0];
                            $paket_Name    = $sheetData[$i][1];
                            $jumlah_Visit  = $sheetData[$i][2];
                            $include_Admin = $sheetData[$i][3];

                            $td0 = ($paket_ID      !== null) ? "" : " style='background: #E07171;'";
                            $td1 = ($paket_Name    !== null) ? "" : " style='background: #E07171;'";
                            $td2 = ($jumlah_Visit  !== null) ? "" : " style='background: #E07171;'";
                            $td3 = ($include_Admin !== null) ? "" : " style='background: #E07171;'";

                            if ($paket_ID == "" || $paket_Name == "" || $jumlah_Visit == "" || $include_Admin == "") {
                                $kosong++;
                            }

                            $output .= '
                            <tr data-id="' . $paket_ID . '">
                                <td ' . $td0 . '>' . $paket_ID . '</td>
                                <td ' . $td1 . '>' . $paket_Name . '</td>
                                <td ' . $td2 . '>' . $jumlah_Visit . '</td>
                                <td ' . $td3 . '>' . $include_Admin . '</td>
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
                         columnDefs: [{ orderable: false, targets: 3 }],
                         "responsive": true,
                         "lengthChange": false,
                         "autoWidth": false,
                         "buttons": [{
                            text: "Import",
                            action: function(e, dt, node, config) {
                                $.post("' . site_url('tmstpakethdr/upload') . '", {})
                                .done(function(response) {
                                    Swal.fire({ icon: "success", title: "Berhasil", text: "Data berhasil diimport." });
                                    $("#modalimport").modal("hide");
                                    $("#paketHdrTable").DataTable().ajax.reload(null, false);
                                })
                                .fail(function(error) {
                                    Swal.fire({ icon: "error", title: "Gagal", text: "Terjadi kesalahan saat mengimport data." });
                                });
                            },
                            attr: {
                                id: "postButton",
                                style: "background-color:#56b746;' . ($this->session->get("flag_insert") === 1 ? "" : "display:none;") . '",
                                name:"postButton",
                                nameClass:"btn-sm"
                            }
                        }],
                         "oLanguage": {
                             "sSearch": "Cari Data:",
                             "sInfoEmpty": "Tidak ada data",
                             "sInfo": "Total: _TOTAL_ data",
                             "sInfoFiltered": " dari _MAX_ data",
                             "sZeroRecords": "Data tidak ditemukan",
                             "oPaginate": { "sFirst": "Awal", "sPrevious": "Sebelum", "sNext": "Berikut", "sLast": "Akhir" },
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

    public function uploaded()
    {
        return $this->preview();
    }

    public function upload()
    {
        if ($this->request->getMethod() == "post") {

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
                    $paket_ID      = $sheetData[$i][0];
                    $paket_Name    = $sheetData[$i][1];
                    $jumlah_Visit  = $sheetData[$i][2];
                    $include_Admin = $sheetData[$i][3];

                    helper(['restclient']);
                    $url = "{$this->server3}/api/mi-paket-hdr";

                    $body = [
                        "paket_ID"      => $paket_ID,
                        "paket_Name"    => $paket_Name,
                        "jumlah_Visit"  => (int) $jumlah_Visit,
                        "include_Admin" => $include_Admin ?? 'NO',
                    ];

                    $response = akses_restapikey('POST', $url, $body, $query = []);
                }

                $msg = ['success' => $i . ' data berhasil di import!'];
                return $this->response->setJSON($msg);
            } else {
                return view("upload");
            }
        } else {
            return view("upload");
        }
    }
}