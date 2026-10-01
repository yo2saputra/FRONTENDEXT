<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as excel;

class Tmstmenus extends BaseController
{
    protected $data;
    protected $server3;

    public function __construct()
    {
        // helper dropdown
        helper(['dropdown']);
        $this->server3 = $_ENV['APP_API3'];
    }

    function apiDropdownGetSourceAccount($key)
    {
        $server3 = $_ENV['APP_API3'];
        $url = "{$server3}/api/gldropdown/glallocation/sourceaccount";

        $query = [
            'action' => 'sourceaccount'
        ];

        $response = akses_restapikey('GET', $url, [], $query);
        return $response;
    }

    public function index()
    {
        // $test = $this->apiDropdownGetSourceAccount('From_Account');
        // dd($test);

        $this->data['cb_aktif'] = getDropdownCustom('is_active', 'is_active', 'Status', 2, 4);
        $this->data['cb_parent'] = getDropdownGetParentMenu('ParentMenu', 'parent_cd');

        return view('tmstmenus/index', $this->data);
    }


    public function datatables()
    {
        helper(['restclient']);
        $rawBody = $this->request->getBody();
        $json = json_decode($rawBody, true);

        $url = "{$this->server3}/api/menus/datatables";
        $response = akses_restapikey('POST', $url, $json);
        $result = json_decode($response, true);

        // Tambahkan kolom aksi ke setiap data
        foreach ($result['data'] as $i => &$row) {
            $cd = $row['menu_cd'];
            $row['rownum'] = $i + ($json['start'] ?? 0) + 1;

            // Kolom Status dengan Badge
            $status = $row['is_active'] ?? '';
            if ($status === 'A' || $status == 1 || $status == '1') {
                $badge = '<span class="badge badge-success">Aktif</span>';
            } else {
                $badge = '<span class="badge badge-danger">Tidak Aktif</span>';
            }

            $row['is_active'] = $badge;
            $row['aksi'] = '
            <div class="btn-group">
                <a class="btn btn-sm btn-info view ' . ($this->session->get("flag_view") === 1 ? "" : "d-none") . '" data-menu_cd="' . $cd . '"><i class="fas fa-eye"></i></a>
                <a class="btn btn-sm btn-primary edit ' . ($this->session->get("flag_update") === 1 ? "" : "d-none") . '" data-menu_cd="' . $cd . '"><i class="fas fa-tags"></i></a>
                <a class="btn btn-sm btn-danger delete ' . ($this->session->get("flag_delete") === 1 ? "" : "d-none") . '" data-menu_cd="' . $cd . '"><i class="fas fa-trash"></i></a>
            </div>';
        }

        return $this->response->setJSON($result);
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $menu_cd = $this->request->getVar('menu_cd');

            helper(['restclient']);
            // endpoint
            $url = "{$this->server3}/api/menus";
            $query = [
                'menu_cd' => $menu_cd
            ];
            // client request
            $result = akses_restapikey('DELETE', $url, $body = [], $query);

            // pastikan hasilnya berupa array
            $result = is_string($result) ? json_decode($result, true) : $result;

            if (isset($result['success']) && $result['success'] === true) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => $result['message'] ?? 'Data menu berhasil dihapus',
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

    public function action()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getVar('action')) {
                helper(['form', 'url']);

                $validation = \Config\Services::validation();
                $valid = $this->validate([
                    // 'menu_cd' => [
                    //     'label' => 'Kode Menu',
                    //     'rules' => 'required',
                    //     'errors' => []
                    // ],
                    'menu_nm' => [
                        'label' => 'Nama Menu',
                        'rules' => 'required',
                        'errors' => []
                    ],
                    'menu_order' => [
                        'label' => 'Urutan Menu',
                        'rules' => 'required|numeric',
                        'errors' => []
                    ],
                    'is_active' => [
                        'label' => 'Status',
                        'rules' => 'required',
                        'errors' => []
                    ]
                ]);

                if (!$valid) {
                    return $this->response->setJSON([
                        'error' => [
                            'menu_cd' => $validation->getError('menu_cd'),
                            'menu_nm' => $validation->getError('menu_nm'),
                            'parent_cd' => $validation->getError('parent_cd'),
                            'reference' => $validation->getError('reference'),
                            'menu_order' => $validation->getError('menu_order'),
                            'menu_icon' => $validation->getError('menu_icon'),
                            'is_active' => $validation->getError('is_active')
                        ]
                    ]);
                } else {
                    helper(['restclient']);

                    if ($this->request->getVar('action') == 'Add') {

                        // endpoint
                        $url = "{$this->server3}/api/menus";

                        // form params
                        $body = [
                            "menu_cd" => $this->request->getVar('menu_cd'),
                            "parent_cd" => empty($this->request->getVar('parent_cd')) ? null : $this->request->getVar('parent_cd'),
                            "menu_nm" => $this->request->getVar('menu_nm'),
                            "reference" => $this->request->getVar('reference'),
                            "menu_order" => $this->request->getVar('menu_order'),
                            "menu_icon" => $this->request->getVar('menu_icon'),
                            "is_active" => $this->request->getVar('is_active') == '1' ? true : false
                        ];
                        // client request
                        $result = akses_restapikey('POST', $url, $body, $query = []);

                        $result = is_string($result) ? json_decode($result, true) : $result;

                        if (isset($result['success']) && $result['success'] === true) {
                            return $this->response->setJSON([
                                'status' => 'success',
                                'message' => 'Data menu berhasil ditambahkan',
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

                        // endpoint
                        $url = "{$this->server3}/api/menus";

                        // Parameter yang ingin dikirim
                        $query = ['menu_cd' => str_replace(" ", "_", trim($this->request->getVar('menu_cd')))];
                        $body = [
                            "menu_cd" => $this->request->getVar('menu_cd'),
                            "parent_cd" => empty($this->request->getVar('parent_cd')) ? null : $this->request->getVar('parent_cd'),
                            "menu_nm" => $this->request->getVar('menu_nm'),
                            "reference" => $this->request->getVar('reference'),
                            "menu_order" => $this->request->getVar('menu_order'),
                            "menu_icon" => $this->request->getVar('menu_icon'),
                            "is_active" => $this->request->getVar('is_active') == '1' ? true : false
                        ];

                        // client request
                        $result = akses_restapikey('PUT', $url, $body, $query);

                        $result = is_string($result) ? json_decode($result, true) : $result;

                        if (isset($result['success']) && $result['success'] === true) {
                            return $this->response->setJSON([
                                'status' => 'success',
                                'message' => 'Data menu berhasil diubah',
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

    public function fetchSingleData()
    {
        if ($this->request->isAJAX()) {
            $menu_cd = $this->request->getVar('menu_cd');

            // dd($menu_cd);

            if ($menu_cd) {
                // helper(['restclient']);
                // $url = "{$this->server3}/api/menus/getby/{$menu_cd}";

                // $response = akses_restapikey('GET', $url);
                // $data = json_decode($response, true);

                // end point
                $url = "{$this->server3}/api/menus";
                $query = [
                    'action' => 'getby', // atau 'getall'
                    'menuCd' => $menu_cd // ganti sesuai kebutuhan
                ];

                // client request
                $response = akses_restapikey('GET', $url, $body = [], $query);

                $data = json_decode($response, true);

                // dd($data);

                if (isset($data['success']) && $data['success'] === true) {


                    $msg = [
                        'data' => [
                            'menu_cd' => $data["data"][0]['menu_cd'] ?? 'tes',
                            'parent_cd' =>  $data["data"][0]['parent_cd'] ?? '',
                            'menu_nm' =>  $data["data"][0]['menu_nm'] ?? '',
                            'reference' =>  $data["data"][0]['reference'] ?? '',
                            'menu_order' =>  $data["data"][0]['menu_order'] ?? '',
                            'menu_icon' =>  $data["data"][0]['menu_icon'] ?? '',
                            'is_active' =>  $data["data"][0]['is_active'] ? '1' : '0'
                        ]
                    ];

                    return $this->response->setJSON($msg);
                } else {
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'Data tidak ditemukan'
                    ]);
                }
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    public function download()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue("A1", "KODE MENU");
        $sheet->setCellValue("B1", "PARENT KODE");
        $sheet->setCellValue("C1", "NAMA MENU");
        $sheet->setCellValue("D1", "REFERENSI");
        $sheet->setCellValue("E1", "URUTAN");
        $sheet->setCellValue("F1", "ICON");
        $sheet->setCellValue("G1", "STATUS");

        $count = 2;
        $sheet->setCellValue("A" . $count, "");
        $sheet->setCellValue("B" . $count, "");
        $sheet->setCellValue("C" . $count, "");
        $sheet->setCellValue("D" . $count, "");
        $sheet->setCellValue("E" . $count, "");
        $sheet->setCellValue("F" . $count, "");
        $sheet->setCellValue("G" . $count, "Y");

        $writer = new Xlsx($spreadsheet);
        $writer->save("data.xlsx");
        return $this->response->download("data.xlsx", null)->setFileName("TEMPLATE MENUS.xlsx");
    }
}
