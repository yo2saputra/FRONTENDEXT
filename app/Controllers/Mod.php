<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Mod extends BaseController
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

    function fetchSingleDataPasien()
    {
        if ($this->request->isAJAX()) {

            $patient_no = $this->request->getVar('patient_no');

            if ($patient_no) {

                // helper curl request
                helper(['restclient']);

                // end point
                $url = "$this->server/pasien/getby/$patient_no";

                // client request
                $response = akses_restapi('GET', $url, []);
                $data['response_data'] = json_decode($response, true);


                $msg = [
                    'data' => [
                        'patient_no' => $data["response_data"][0]["patient_no"],
                        'fullname' => $data["response_data"][0]["fullname"],
                        'id_no' => $data["response_data"][0]["id_no"],
                        'gender' => $data["response_data"][0]["gender"],
                        'addr' => $data["response_data"][0]["addr"],
                        'mobile_no' => $data["response_data"][0]["mobile_no"],
                        'birth_dt' => date('m/d/Y', strtotime($data["response_data"][0]["birth_dt"])),
                        'id_typ' => $data["response_data"][0]["id_typ"],
                        'job_title_cd' => $data["response_data"][0]["job_title_cd"],
                        'religion' => $data["response_data"][0]["religion"],
                        'city_cd' => $data["response_data"][0]["city_cd"],
                        'married_sta_id' => $data["response_data"][0]["married_sta_id"],
                        'source_info' => $data["response_data"][0]["source_info"],
                        'birthplace' => $data["response_data"][0]["birthplace"],
                        'postcode' => $data["response_data"][0]["postcode"],
                        'education' => $data["response_data"][0]["education"],
                        'family_name' => $data["response_data"][0]["family_name"],
                        'family_addr' => $data["response_data"][0]["family_addr"],
                        'family_handphone' => $data["response_data"][0]["family_handphone"],
                        'family_relation' => $data["response_data"][0]["family_relation"],
                    ]
                ];

                echo json_encode($msg);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    function fetchSingleDataAsuransi()
    {
        if ($this->request->isAJAX()) {

            $asr_cd = $this->request->getVar('asr_cd');

            if ($asr_cd) {

                // helper curl request
                helper(['restclient']);

                // end point
                $url = "$this->server/tmstasuransi/getby/$asr_cd";

                // client request
                $response = akses_restapi('GET', $url, []);
                $data['response_data'] = json_decode($response, true);


                $msg = [
                    'data' => [
                        'asr_cd' => $data["response_data"][0]["asr_cd"],
                        'cashless' => $data["response_data"][0]["cashless"]
                    ]
                ];

                echo json_encode($msg);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    // public function checkSession()
    // {
    //     if ($this->request->isAJAX()) {
    //         if ($this->session->get('usr_id') !== '') {
    //             $msg = [
    //                 'session' => 1
    //             ];
    //         } else {
    //             $msg = [
    //                 'session' => 0
    //             ];
    //         }

    //         echo json_encode($msg);
    //     } else {
    //         exit('Maaf tidak dapat diproses!');
    //     }
    // }
}
