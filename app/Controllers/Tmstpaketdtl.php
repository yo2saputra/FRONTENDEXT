<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as excel;

class Tmstpaketdtl extends BaseController
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
        helper(['dropdown']);

        $this->data['cb_paket'] = $this->_getPaketHdrDropdown();

        $this->data['cb_tindakan'] = getDropdownCustom('tindakan_ID', 'tindakan_ID', 'Tindakan', 2, 4);

        return view('tmstpaketdtl/index', $this->data);
    }

    private function _getPaketHdrDropdown()
    {
        helper(['restclient']);
        $url = "{$this->server3}/api/mi-paket-hdr/dropdown";
        $response = akses_restapikey('GET', $url, [], []);
        $data = json_decode($response, true);
        return $data['data'] ?? [];
    }

    public function getPaketHdr()
    {
        helper(['restclient']);
        $url = "{$this->server3}/api/mi-paket-hdr/dropdown";
        $response = akses_restapikey('GET', $url, [], []);
        return $this->response->setBody($response)->setContentType('application/json');
    }

    public function getTindakan()
    {
        helper(['restclient']);
        $url = "{$this->server3}/api/mi-tindakan/dropdown";
        $response = akses_restapikey('GET', $url, [], []);
        return $this->response->setBody($response)->setContentType('application/json');
    }

    public function datatables()
    {
        helper(['restclient']);
        $rawBody = $this->request->getBody();
        $json = json_decode($rawBody, true);

        $url = "{$this->server3}/api/mi-paket-dtl/datatables";
        $response = akses_restapikey('POST', $url, $json);
        $result = json_decode($response, true);

        foreach ($result['data'] as $i => &$row) {
            $paket_id = $row['paket_ID'];
            $line_no  = $row['lineNo'] ?? $row['line_no'] ?? '';
            $row['line_no']     = $line_no;
            $row['detail_Name'] = $row['detail_Name'] ?? $row['type_Name'] ?? '-';
            $row['rownum']      = $i + ($json['start'] ?? 0) + 1;
            $row['aksi'] = '
            <div class="btn-group">
                <a class="btn btn-sm btn-info view '    . ($this->session->get("flag_view")   === 1 ? "" : "d-none") . '" data-paket_id="' . $paket_id . '" data-line_no="' . $line_no . '"><i class="fas fa-eye"></i></a>
                <a class="btn btn-sm btn-primary edit ' . ($this->session->get("flag_update") === 1 ? "" : "d-none") . '" data-paket_id="' . $paket_id . '" data-line_no="' . $line_no . '"><i class="fas fa-tags"></i></a>
                <a class="btn btn-sm btn-danger delete '. ($this->session->get("flag_delete") === 1 ? "" : "d-none") . '" data-paket_id="' . $paket_id . '" data-line_no="' . $line_no . '"><i class="fas fa-trash"></i></a>
            </div>';
        }

        return $this->response->setJSON($result);
    }

    public function fetchAll()
    {
        helper(['restclient']);

        $url = "{$this->server3}/api/mi-paket-dtl";

        $query = [
            'action' => 'getall',
        ];

        $response = akses_restapikey('GET', $url, $body = [], $query);
        $data = json_decode($response, true);

        return $this->response->setJSON($data);
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $paket_id = $this->request->getVar('paket_id');
            $line_no  = $this->request->getVar('line_no');

            helper(['restclient']);

            $url = "{$this->server3}/api/mi-paket-dtl/{$paket_id}/{$line_no}";
            $query = [];

            $result = akses_restapikey('DELETE', $url, $body = [], $query);

            $result = is_string($result) ? json_decode($result, true) : $result;

            if (isset($result['success']) && $result['success'] === true) {
                return $this->response->setJSON([
                    'status'  => 'success',
                    'message' => $result['message'] ?? 'Data paket detail berhasil dihapus',
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

    function action()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getVar('action')) {
                helper(['form', 'url']);

                $validation = \Config\Services::validation();
                $valid = $this->validate([
                    'paket_ID' => [
                        'label'  => 'Paket ID',
                        'rules'  => 'required',
                        'errors' => []
                    ],
                    'type' => [
                        'label'  => 'Type',
                        'rules'  => 'required',
                        'errors' => []
                    ],
                    'detail_Code' => [
                        'label'  => 'Detail Code',
                        'rules'  => 'required',
                        'errors' => []
                    ],
                    'quantity' => [
                        'label'  => 'Quantity',
                        'rules'  => 'required',
                        'errors' => []
                    ],
                ]);

                if (!$valid) {
                    return $this->response->setJSON([
                        'error' => [
                            'paket_ID'    => $validation->getError('paket_ID'),
                            'type'        => $validation->getError('type'),
                            'detail_Code' => $validation->getError('detail_Code'),
                            'quantity'    => $validation->getError('quantity'),
                        ]
                    ]);
                } else {

                    if ($this->request->getVar('action') == 'Add') {

                        helper(['restclient']);

                        $url = "{$this->server3}/api/mi-paket-dtl";

                        $body = [
                            "paket_ID"    => trim($this->request->getVar('paket_ID')),
                            "type"        => $this->request->getVar('type'),
                            "detail_Code" => $this->request->getVar('detail_Code'),
                            "quantity"    => (int) $this->request->getVar('quantity'),
                        ];

                        $result = akses_restapikey('POST', $url, $body, $query = []);
                        $result = is_string($result) ? json_decode($result, true) : $result;

                        if (isset($result['success']) && $result['success'] === true) {
                            return $this->response->setJSON([
                                'status'  => 'success',
                                'message' => 'Data paket detail berhasil ditambahkan',
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

                    if ($this->request->getVar('action') == 'Edit') {

                        helper(['restclient']);

                        $paket_id = trim($this->request->getVar('paket_ID'));
                        $line_no  = $this->request->getVar('line_no');
                        $url = "{$this->server3}/api/mi-paket-dtl/{$paket_id}/{$line_no}";

                        $body = [
                            "type"        => $this->request->getVar('type'),
                            "detail_Code" => $this->request->getVar('detail_Code'),
                            "quantity"    => (int) $this->request->getVar('quantity'),
                        ];

                        $result = akses_restapikey('PUT', $url, $body, $query = []);
                        $result = is_string($result) ? json_decode($result, true) : $result;

                        if (isset($result['success']) && $result['success'] === true) {
                            return $this->response->setJSON([
                                'status'  => 'success',
                                'message' => 'Data paket detail berhasil diubah',
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
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    function fetchSingleData()
    {
        if ($this->request->isAJAX()) {

            $paket_id = $this->request->getVar('paket_id');
            $line_no  = $this->request->getVar('line_no');

            if ($paket_id && $line_no) {

                helper(['restclient']);

                $url = "{$this->server3}/api/mi-paket-dtl/{$paket_id}/{$line_no}";

                $response = akses_restapikey('GET', $url, $body = [], $query = []);
                $data = json_decode($response, true);

                $msg = [
                    'data' => [
                        'paket_ID'    => $data["data"][0]["paket_ID"]    ?? $data["data"]["paket_ID"]    ?? '',
                        'line_no'     => $data["data"][0]["line_no"]     ?? $data["data"]["line_no"]     ?? '',
                        'type'        => $data["data"][0]["type"]        ?? $data["data"]["type"]        ?? '',
                        'detail_Code' => $data["data"][0]["detail_Code"] ?? $data["data"]["detail_Code"] ?? '',
                        'quantity'    => $data["data"][0]["quantity"]    ?? $data["data"]["quantity"]    ?? '',
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

            $url = "{$this->server3}/api/mi-paket-dtl/by-paket/{$paket_id}";

            $response = akses_restapikey('GET', $url, $body = [], $query = []);
            $data['response_data'] = json_decode($response, true);

            $pdf_data        = $data['response_data'];
            $pdf_name        = 'Single Data Paket Detail';
            $pdf_title       = 'Data Paket Detail';
            $pdf_paper       = 'A4';
            $pdf_orientation = 'portrait';
            $pdf_format      = 'laporan_pdf';

            $this->view_pdf($pdf_name, $pdf_title, $pdf_data, $pdf_paper, $pdf_orientation, $pdf_format);
        }
    }

    public function view_pdf($pdf_name, $pdf_title, $pdf_data, $pdf_paper, $pdf_orientation, $pdf_format)
    {
        $Pdfgenerator = new Pdfgenerator();

        $file_pdf = $pdf_name;
        $this->data['title_pdf'] = $pdf_title;
        $this->data['produk']    = $pdf_data;

        $paper       = $pdf_paper;
        $orientation = $pdf_orientation;

        $html = view($pdf_format, $this->data);
        $Pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
    }

    public function download()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue("A1", "PAKET ID");
        $sheet->setCellValue("B1", "TYPE");
        $sheet->setCellValue("C1", "DETAIL CODE");
        $sheet->setCellValue("D1", "QUANTITY");

        $count = 2;
        $sheet->setCellValue("A" . $count, "");
        $sheet->setCellValue("B" . $count, "");
        $sheet->setCellValue("C" . $count, "");
        $sheet->setCellValue("D" . $count, "");

        $writer = new Xlsx($spreadsheet);
        $writer->save("data.xlsx");
        return $this->response->download("data.xlsx", null)->setFileName("TEMPLATE PAKET DETAIL.xlsx");
    }

    public function preview()
    {
        if ($this->request->getMethod() == "post") {
            $rules = $this->validate([
                'filename' => 'uploaded[filename]|max_size[filename,500]|ext_in[filename,csv,xlsx]',
            ]);
            if ($rules == true) {
                $filename = $this->request->getFile('filename');
                $path     = WRITEPATH . 'uploads/';
                $filename->move($path, $filename->getName());
                $this->session->set("fileupload", $path . "" . $filename->getName());
            } else {
                return $this->response->setStatusCode(400)->setJSON(['error' => 'File yang diunggah harus berformat .xlsx']);
            }
        } else {

            if ($this->session->get("fileupload") !== '') {

                $arr_file  = explode(".", $this->session->get("fileupload"));
                $extension = end($arr_file);
                if ('csv' == $extension) {
                    $reader = new Csv();
                } else {
                    $reader = new excel();
                }

                $spreadsheet = $reader->load($this->session->get("fileupload"));
                $sheetData   = $spreadsheet->getActiveSheet()->toArray();

                $output  = '';
                $output .= '
                <br>
                 <table id="exampleImport" class="table table-sm table-bordered table-striped">
                 <thead>
                         <tr>
                             <th>Paket ID</th>
                             <th>Type</th>
                             <th>Detail Code</th>
                             <th>Quantity</th>
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

                            $paket_ID    = $sheetData[$i][0];
                            $type        = $sheetData[$i][1];
                            $detail_Code = $sheetData[$i][2];
                            $quantity    = $sheetData[$i][3];

                            $td0 = ($paket_ID    !== null) ? "" : " style='background: #E07171;'";
                            $td1 = ($type        !== null) ? "" : " style='background: #E07171;'";
                            $td2 = ($detail_Code !== null) ? "" : " style='background: #E07171;'";
                            $td3 = ($quantity    !== null) ? "" : " style='background: #E07171;'";

                            if ($paket_ID == "" || $type == "" || $detail_Code == "" || $quantity == "") {
                                $kosong++;
                            }

                            $output .= '
                            <tr data-id="' . $paket_ID . '">
                                <td ' . $td0 . '>' . $paket_ID . '</td>
                                <td ' . $td1 . '>' . $type . '</td>
                                <td ' . $td2 . '>' . $detail_Code . '</td>
                                <td ' . $td3 . '>' . $quantity . '</td>
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
                                $.post("' . site_url('tmstpaketdtl/upload') . '", {})
                                .done(function(response) {
                                    Swal.fire({ icon: "success", title: "Berhasil", text: "Data berhasil diimport." });
                                    $("#modalimport").modal("hide");
                                    $("#paketdtlTable").DataTable().ajax.reload(null, false);
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

            $arr_file  = explode(".", $this->session->get("fileupload"));
            $extension = end($arr_file);
            if ('csv' == $extension) {
                $reader = new Csv();
            } else {
                $reader = new excel();
            }

            $spreadsheet = $reader->load($this->session->get("fileupload"));
            $sheetData   = $spreadsheet->getActiveSheet()->toArray();

            if (!empty($sheetData)) {
                for ($i = 1; $i < count($sheetData); $i++) {
                    $paket_ID    = $sheetData[$i][0];
                    $type        = $sheetData[$i][1];
                    $detail_Code = $sheetData[$i][2];
                    $quantity    = $sheetData[$i][3];

                    helper(['restclient']);
                    $url = "{$this->server3}/api/mi-paket-dtl";

                    $body = [
                        "paket_ID"    => $paket_ID,
                        "type"        => $type,
                        "detail_Code" => $detail_Code,
                        "quantity"    => (int) $quantity,
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