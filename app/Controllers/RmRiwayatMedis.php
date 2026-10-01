<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class RmRiwayatMedis extends BaseController
{
    protected $data;
    protected $session;
    protected $server5;
    protected $client;

    public function __construct()
    {
        $this->session = session();
        $this->server5 = $_ENV['APP_API5'];
        helper(['restclient', 'form', 'url']);
        $this->client = service('curlrequest');
    }

    public function index()
    {
        $this->data['title'] = 'Riwayat Rekam Medis | ' . $_ENV['APP_TITLE'];
        return view('rm_riwayat_medis/index', $this->data);
    }

    public function searchPatient()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request']);
        }

        $keyword = $this->request->getVar('keyword');

        if (empty($keyword)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Keyword tidak boleh kosong']);
        }

        $roleCd   = $this->session->get('role_cd');
        $dokterCd = $this->session->get('emp_cd');

        $url = "$this->server5/api/RmPatients/search"
            . "?keyword=" . urlencode($keyword)
            . "&roleCd=" . urlencode($roleCd ?? '')
            . "&dokterCd=" . urlencode($dokterCd ?? '');

        $response = akses_restapi('GET', $url, []);
        $result   = json_decode($response, true);

        if (empty($result['data'])) {
            return $this->response->setJSON(['status' => 'empty', 'data' => []]);
        }

        return $this->response->setJSON(['status' => 'success', 'data' => $result['data']]);
    }

    public function getPatientDetail()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request']);
        }

        $patientNo = $this->request->getVar('patient_no');

        if (empty($patientNo)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Patient No tidak boleh kosong']);
        }

        $url      = "$this->server5/api/RmPatients/$patientNo";
        $response = akses_restapi('GET', $url, []);
        $result   = json_decode($response, true);

        if (empty($result) || ($result['success'] ?? false) === false) {
            return $this->response->setJSON(['status' => 'empty', 'data' => []]);
        }

        return $this->response->setJSON(['status' => 'success', 'data' => $result['data']]);
    }

    public function getRiwayatKunjungan()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request']);
        }

        $patientNo = $this->request->getVar('patient_no');

        if (empty($patientNo)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Patient No tidak boleh kosong']);
        }

        $url      = "$this->server5/api/RmPatients/$patientNo/kunjungan";
        $response = akses_restapi('GET', $url, []);
        $result   = json_decode($response, true);

        return $this->response->setJSON(['status' => 'success', 'data' => $result['data'] ?? []]);
    }

    public function getAlergi()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request']);
        }

        $patientNo = $this->request->getVar('patient_no');

        if (empty($patientNo)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Patient No tidak boleh kosong']);
        }

        $url      = "$this->server5/api/RmPatients/$patientNo/alergi";
        $response = akses_restapi('GET', $url, []);

        dd($response); // Debugging line to inspect the response
        $result   = json_decode($response, true);

        return $this->response->setJSON(['status' => 'success', 'data' => $result['data'] ?? []]);
    }

    public function getDiagnosis()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request']);
        }

        $patientNo = $this->request->getVar('patient_no');

        if (empty($patientNo)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Patient No tidak boleh kosong']);
        }

        $url      = "$this->server5/api/RmPatients/$patientNo/diagnosis";
        $response = akses_restapi('GET', $url, []);
        $result   = json_decode($response, true);

        return $this->response->setJSON(['status' => 'success', 'data' => $result['data'] ?? []]);
    }

    public function getDetailKunjungan()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request']);
        }

        $noRegistrasi = $this->request->getVar('no_registrasi');

        if (empty($noRegistrasi)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'No Registrasi tidak boleh kosong']);
        }

        $url      = "$this->server5/api/RmPatients/kunjungan/$noRegistrasi";
        $response = akses_restapi('GET', $url, []);
        $result   = json_decode($response, true);

        if (empty($result) || ($result['success'] ?? false) === false) {
            return $this->response->setJSON(['status' => 'empty', 'data' => []]);
        }

        return $this->response->setJSON(['status' => 'success', 'data' => $result['data']]);
    }

    public function kunjungan($patientNo)
    {
        $this->data['title'] = 'Riwayat Kunjungan | ' . $_ENV['APP_TITLE'];
        $this->data['patientNo'] = $patientNo;

        return view('rm_riwayat_medis/kunjungan', $this->data);
    }

    public function alergi($patientNo)
    {
        $this->data['title'] = 'Riwayat Alergi | ' . $_ENV['APP_TITLE'];
        $this->data['patientNo'] = $patientNo;

        return view('rm_riwayat_medis/alergi', $this->data);
    }

    public function diagnosis($patientNo)
    {
        $this->data['title'] = 'Riwayat Diagnosis | ' . $_ENV['APP_TITLE'];
        $this->data['patientNo'] = $patientNo;

        return view('rm_riwayat_medis/diagnosis', $this->data);
    }

    public function getDetailPageDataKunjungan()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request']);
        }

        $patientNo = $this->request->getVar('patient_no');

        if (empty($patientNo)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Parameter tidak lengkap']);
        }

        // Ambil data pasien
        $urlPatient = "$this->server5/api/RmPatients/$patientNo";
        $responsePatient = akses_restapi('GET', $urlPatient, []);
        $resultPatient = json_decode($responsePatient, true);

        // Ambil data kunjungan
        $urlData = "$this->server5/api/RmPatients/$patientNo/kunjungan";
        $responseData = akses_restapi('GET', $urlData, []);
        $resultData = json_decode($responseData, true);

        return $this->response->setJSON([
            'status' => 'success',
            'patient' => $resultPatient['data']['patient'] ?? [],
            'data' => $resultData['data'] ?? []
        ]);
    }

    public function getDetailPageDataAlergi()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request']);
        }

        $patientNo = $this->request->getVar('patient_no');

        if (empty($patientNo)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Parameter tidak lengkap']);
        }

        // Ambil data pasien
        $urlPatient = "$this->server5/api/RmPatients/$patientNo";
        $responsePatient = akses_restapi('GET', $urlPatient, []);
        $resultPatient = json_decode($responsePatient, true);

        // Ambil data kunjungan
        $urlData = "$this->server5/api/RmPatients/$patientNo/alergi";
        $responseData = akses_restapi('GET', $urlData, []);
        $resultData = json_decode($responseData, true);

        return $this->response->setJSON([
            'status' => 'success',
            'patient' => $resultPatient['data']['patient'] ?? [],
            'data' => $resultData['data'] ?? []
        ]);
    }

    public function getDetailPageDataDiagnosis()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request']);
        }

        $patientNo = $this->request->getVar('patient_no');

        if (empty($patientNo)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Parameter tidak lengkap']);
        }

        // Ambil data pasien
        $urlPatient = "$this->server5/api/RmPatients/$patientNo";
        $responsePatient = akses_restapi('GET', $urlPatient, []);
        $resultPatient = json_decode($responsePatient, true);

        // Ambil data kunjungan
        $urlData = "$this->server5/api/RmPatients/$patientNo/diagnosis";
        $responseData = akses_restapi('GET', $urlData, []);
        $resultData = json_decode($responseData, true);

        return $this->response->setJSON([
            'status' => 'success',
            'patient' => $resultPatient['data']['patient'] ?? [],
            'data' => $resultData['data'] ?? []
        ]);
    }
}
