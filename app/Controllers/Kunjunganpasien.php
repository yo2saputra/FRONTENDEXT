<?php

namespace App\Controllers;

use App\Controllers\BaseController;
// use Config\Services;
// use App\Libraries\Pdfgenerator;
// use CodeIgniter\I18n\Time;



class Kunjunganpasien extends BaseController
{

    public function __construct()
    {
        $this->session = session();
        $this->server = $_ENV['APP_API'];

        //library CURLrequest
        // $this->client = service('curlrequest');

        $this->data = [
            'menu_header' => $this->apiMenuHeader(session()->get('usr_id')),
            'menu' => $this->apiMenu(session()->get('usr_id'))
        ];
    }

    public function index()
    {
        $this->data['title'] = ' | ' . $_ENV['APP_TITLE'];

        // helper dropdown
        helper(['dropdown']);

        $this->data['cb_gender'] = getDropdown('gender', 'Jenis Kelamin', 4, 8); // (id,Label,label size, input size)
        $this->data['cb_id_typ'] = getDropdown('id_typ', 'Jenis Identitas Pasien', 4, 8); // (id,Label,label size, input size)
        $this->data['cb_job_title_cd'] = getDropdown('job_title_cd', 'Pekerjaan', 4, 8); // (id,Label,label size, input size)
        $this->data['cb_religion'] = getDropdown('religion', 'Agama', 4, 8); // (id,Label,label size, input size)
        $this->data['cb_city_cd'] = getDropdownNolabelHorizontal('city_cd', 4); // (id, input size)
        $this->data['cb_married_sta_id'] = getDropdown('married_sta_id', 'Status', 4, 8); // (id,Label,label size, input size)
        $this->data['cb_source_info'] = getDropdown('source_info', 'Source Info', 4, 8); // (id,Label,label size, input size)
        $this->data['cb_education'] = getDropdown('education', 'Pendidikan', 4, 8); // (id,Label,label size, input size)
        $this->data['cb_family_relation'] = getDropdown('family_relation', 'Hubungan dengan Pasien', 4, 8); // (id,Label,label size, input size)

        return view('kunjunganpasien/index', $this->data);
    }

    public function apiDataGetAll()
    {
        // helper curl request
        helper(['restclient']);
        // endpoint
        $url = "$this->server/patient/getall";
        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);

        return $data['response_data'];
    }

    public function fetchAll()
    {
        if ($this->request->isAJAX()) {
            $output = '';
            $data =  $this->apiDataGetAll();
            $output .= '
            <div class="table-responsive">
                    <table id="example4" class="table table-hover table-striped">
                    <thead>
                            <tr>  
                                <th>Patient No</th>
                                <th>Full Name</th>
                                <th>ID No</th>
                                <th>Gender</th>
                                <th>Address</th>
                                <th>Mobile</th>
                                <th>Birth Date</th>
                                <th></th>
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
                        </tr>';
            } else {
                for ($a = 0; $a < count($data); $a++) {
                    $output .= '  
                    <tr id="addMdlBarang" data-id="' . $data[$a]["patient_no"] . '">
                        <td >' . $data[$a]["patient_no"] . '</td>
                        <td >' . $data[$a]["fullname"] . '</td>
                        <td >' . $data[$a]["id_no"] . '</td>
                        <td >' . $data[$a]["gender"] . '</td>
                        <td >' . $data[$a]["addr"] . '</td>
                        <td >' . $data[$a]["mobile_no"] . '</td>
                        <td >' . date('d/m/Y', strtotime($data[$a]["birth_dt"])) . '</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm float-right mr-1 mt-1 delete btn-fix-w" data-patient_no="' . $data[$a]["patient_no"] . '" >
                                <i class="fas fa-trash"></i>
                            </button>
                            <button type="button" class="btn btn-primary btn-sm float-right mr-1 mt-1 edit btn-fix-w" data-patient_no="' . $data[$a]["patient_no"] . '" >
                                <i class="fas fa-tags"></i>
                            </button>
                            <a href="' . base_url('/patient/fetchSingleDataPrint/') . $data[$a]['patient_no'] . '" target="_blank" class="btn btn-warning btn-sm float-right mr-1 mt-1 print btn-fix-w" > <i class="fas fa-print"></i></a>
                        </td>
                    </tr>  
            ';
                }
            }
            $output .= '</table></div>
            <script type="text/javascript">
            $(function() {
                $("#example4").DataTable({
                    columnDefs: [{
                        orderable: false,
                        targets: 7
                    }],
                    "dom": "Bfplit",
                    "buttons": [
                        "copy", "csv", "excel", "pdf", "print"
                    ],
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "info": true,
                    "autoWidth": true,
                    "responsive": true,
                });
            });
            </script>
            ';
            echo $output;
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }
}
