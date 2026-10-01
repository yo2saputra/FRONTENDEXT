<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

class InqRegistrasi extends BaseController
{

    protected $data;
    protected $server;
    protected $client;

    public function __construct()
    {
        $this->session = session();
        $uri = service('uri');
        $this->server = $_ENV['APP_API'];
    }

    public function index()
    {
        // helper dropdown
        helper(['dropdown']);
        $this->data['cb_pasien'] = getDropdownPasienSearch('no_pasien', 'Pasien', 1, 4); // (key,Label,label size, input size)
        return view('inqregistrasi/index', $this->data);
    }

    public function apiDataGetAll()
    {

        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/tregistrasi/getall";

        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);
        return $data['response_data'];
    }

    public function search()
    {
        // if ($this->request->isAJAX()) {

        $no_pasien = $this->request->getVar('no_pasien');
        $tgl1 = date("Y-m-d", strtotime($this->request->getVar('tgl_praktek1')));
        $tgl2 = date("Y-m-d", strtotime($this->request->getVar('tgl_praktek2')));

        // Set Session 
        $this->session->set(["no_pasien" => $no_pasien]);
        $this->session->set(["tgl1" => $tgl1]);
        $this->session->set(["tgl2" => $tgl2]);

        // helper curl request
        helper(['restclient']);

        // end point
        $url = "$this->server/inqregistrasi/search/$no_pasien/$tgl1/$tgl2";

        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);

        $output = '';
        $data =  $data['response_data'];
        $output .= '  
                    <table id="example4" class="table table-sm table-bordered table-striped">
                    <thead>
                            <tr>
                                <th>No. REG</th>
                                <th>Pasien</th>
                                <th>Tgl Registrasi</th>
                                <th>Via</th>
                                <th>Tujuan</th>
                                <th>Dokter</th>
                                <th>Tgl Praktek</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                            </tr>
                        </thead>
                            ';
        if ($data == '') {
            $output .= '<tr>  
                                <td >Data not Found</td>
                                <td ></td>
                                <td ></td>
                                <td ></td>
                                <td ></td>
                                <td ></td>
                                <td ></td>
                                <td ></td>
                                <td ></td>
                            </tr>';
        } else {
            for ($a = 0; $a < count($data); $a++) {
                $output .= '  
                            <tr id="addMdlBarang" data-id="' . $data[$a]["no_registrasi"] . '">
                                <td >' . $data[$a]["no_registrasi"] . '</td>
                                <td >' . $data[$a]["fullname"] . '</td>
                                <td >' . date('d/m/Y', strtotime($data[$a]["tgl_registrasi"])) . '</td>
                                <td >' . $data[$a]["registrasi_via"] . '</td>
                                <td >' . $data[$a]["tujuan_registrasi_desc"] . '</td>
                                <td >' . $data[$a]["nama_dokter"] . '</td>
                                <td >' . date('d/m/Y', strtotime($data[$a]["tgl_praktek"])) . '</td>
                                <td >' . $data[$a]["jam_mulai"] . '</td>
                                <td >' . $data[$a]["jam_selesai"] . '</td>
                            </tr>  
                    ';
            }
        }
        $output .= '</table>
            <script>
            $(function() {
                $("#example4").DataTable({
                    // "responsive": true, "lengthChange": false, "autoWidth": false,
                    columnDefs: [{
                        orderable: false,
                        targets: 8
                    }],
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    // "columns": [
                    //   { "width": "10%" }, null, null, null, nuul, null
                    // ],
                    "buttons": false,
                    "oLanguage": {
                        "sSearch": "Cari Data:",
                        "sInfoEmpty": "Tidak ada data",
                        // "sInfo": "_START_ untuk _END_ dari _TOTAL_ data",
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
                }).buttons().container().appendTo("#example4_wrapper .col-md-6:eq(0)");
            });
            </script>
            ';
        echo $output;
        // } else {
        //     exit('Maaf tidak dapat diproses!');
        // }
    }

    function fetchAllView()
    {
        if ($this->request->isAJAX()) {

            $no_registrasi = $this->request->getVar('no_registrasi');

            if ($no_registrasi) {

                // helper curl request
                helper(['restclient']);

                // end point
                $url = "$this->server/tregistrasi/getby/$no_registrasi";

                // client request
                $response = akses_restapi('GET', $url, []);
                $data['response_data'] = json_decode($response, true);

                $msg = [
                    'data' => [
                        'no_registrasi' => $data["response_data"][0]["no_registrasi"],
                        'no_pasien' => $data["response_data"][0]["no_pasien"],
                        'tgl_registrasi' => $data["response_data"][0]["tgl_registrasi"],
                        'registrasi_via' => $data["response_data"][0]["registrasi_via"],
                        'tujuan_registrasi' => $data["response_data"][0]["tujuan_registrasi"],
                        'dokter' => $data["response_data"][0]["dokter"],
                        'jadwal_dokter' => $data["response_data"][0]["jadwal_dokter"],
                        'created_by' => $data["response_data"][0]["created_by"],
                        'created_date' => $data["response_data"][0]["created_date"],
                        'tgl_praktek' => $data["response_data"][0]["tgl_praktek"],
                        'jam_mulai' => $data["response_data"][0]["jam_mulai"],
                        'jam_selesai' => $data["response_data"][0]["jam_selesai"],
                        'tahun' => $data["response_data"][0]["tahun"],
                        'bulan' => $data["response_data"][0]["bulan"],
                        'hari' => $data["response_data"][0]["hari"],
                        'fullname' => $data["response_data"][0]["fullname"],
                        'gender' => $data["response_data"][0]["gender"],
                        'birth_dt' => $data["response_data"][0]["birth_dt"],
                        'addr' => $data["response_data"][0]["addr"],
                        'mobile_no' => $data["response_data"][0]["mobile_no"],
                        'nama_dokter' => $data["response_data"][0]["nama_dokter"],
                        'daftar' => $data["response_data"][0]["daftar"],
                        'hadir' => $data["response_data"][0]["hadir"],
                        'selesai' => $data["response_data"][0]["selesai"],
                        'Tipe_Pasien' => $data["response_data"][0]["type_pasien"],
                        'asr_cd' => $data["response_data"][0]["asr_cd"]

                    ]
                ];

                echo json_encode($msg);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    function fetchSingleDataPrint($menu_cd)
    {

        if ($menu_cd) {

            // helper curl request
            helper(['restclient']);

            // end point
            $url = "$this->server/menu/getby/$menu_cd";

            // client request
            $response = akses_restapi('GET', $url, []);
            $data['response_data'] = json_decode($response, true);

            $pdf_data = $data['response_data'];
            $pdf_name = 'Single Data Field Value';
            $pdf_title = 'Data Field Value';
            $pdf_paper = 'A4';
            $pdf_orientation = 'portrait';
            $pdf_format = 'laporan_pdf';

            $this->view_pdf($pdf_name, $pdf_title, $pdf_data, $pdf_paper, $pdf_orientation, $pdf_format);
        }
    }

    function fetchAllDataPrint()
    {
        $no_pasien = session()->get("no_pasien");
        $tgl1 = session()->get("tgl1");
        $tgl2 = session()->get("tgl2");

        // helper curl request
        helper(['restclient']);

        // end point
        $url = "$this->server/inqregistrasi/search/$no_pasien/$tgl1/$tgl2";

        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);

        $pdf_data = $data['response_data'];
        $pdf_name = 'Single Data Patient';
        $pdf_title = 'Data Registrasi';
        $pdf_paper = 'A4';
        $pdf_orientation = 'portrait';
        $pdf_format = 'inq_registrasi_pdf';

        $this->view_pdf($pdf_name, $pdf_title, $pdf_data, $pdf_paper, $pdf_orientation, $pdf_format);
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
}
