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

        // NOTE: arahkan ke base URL API RmPatients (.NET) yang baru.
        // Tambahkan APP_API_RM di file .env, contoh:
        //   APP_API_RM=https://api-medicelle.example.com
        $this->server5 = $_ENV['APP_API5'];

        helper(['restclient', 'form', 'url']);
        $this->client = service('curlrequest');
    }

    public function index()
    {
        $this->data['title'] = 'Riwayat Rekam Medis | ' . $_ENV['APP_TITLE'];

        return view('rm_riwayat_medis/index', $this->data);
    }

    // ==============================================
    // STEP 1: SEARCH PASIEN (gambar 1.png)
    // ==============================================
    public function searchPatient()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request']);
        }

        $keyword = $this->request->getVar('keyword');

        if (empty($keyword)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Keyword tidak boleh kosong']);
        }

        // NOTE: sesuaikan key session role & kode dokter dengan
        // yang dipakai di aplikasi Anda (di Dashboard.php lama
        // Anda pakai session()->get('role_cd')).
        $roleCd   = $this->session->get('role_cd');
        $dokterCd = $this->session->get('user_cd');

        $url = "$this->server5/api/RmPatients/search"
            . "?keyword=" . urlencode($keyword)
            . "&roleCd=" . urlencode($roleCd ?? '')
            . "&dokterCd=" . urlencode($dokterCd ?? '');

        // $url = "$this->server5/api/RmPatients/search"
        //     . "?keyword=" . urlencode('sari')
        //     . "&roleCd=" . urlencode('ROLE006')
        //     . "&dokterCd=" . urlencode('E0028');

        $response = akses_restapi('GET', $url, []);

        $result   = json_decode($response, true);

        if (empty($result['data'])) {
            return $this->response->setJSON(['status' => 'empty', 'data' => []]);
        }

        return $this->response->setJSON(['status' => 'success', 'data' => $result['data']]);
    }

    // ==============================================
    // STEP 2: DETAIL PASIEN + BADGE MENU (gambar 2.png)
    // ==============================================
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

    // ==============================================
    // STEP 3a: CARD "Riwayat kunjungan pasien" (gambar 3.png)
    // ==============================================
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

    // ==============================================
    // STEP 3b: CARD "Alergi"
    // ==============================================
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
        $result   = json_decode($response, true);

        return $this->response->setJSON(['status' => 'success', 'data' => $result['data'] ?? []]);
    }

    // ==============================================
    // STEP 3c: CARD "Diagnosis"
    // ==============================================
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

    // ==============================================
    // DETAIL 1 KUNJUNGAN (saat item di-expand)
    // ==============================================
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

    // ==============================================
    // NEW: HALAMAN KUNJUNGAN (NEW TAB)
    // ==============================================
    public function kunjungan($patientNo)
    {
        $this->data['title'] = 'Riwayat Kunjungan | ' . $_ENV['APP_TITLE'];
        $this->data['patientNo'] = $patientNo;
        $this->data['menu'] = 'kunjungan';

        return view('rm_riwayat_medis/detail_page', $this->data);
    }

    // ==============================================
    // NEW: HALAMAN ALERGI (NEW TAB)
    // ==============================================
    public function alergi($patientNo)
    {
        $this->data['title'] = 'Riwayat Alergi | ' . $_ENV['APP_TITLE'];
        $this->data['patientNo'] = $patientNo;
        $this->data['menu'] = 'alergi';

        return view('rm_riwayat_medis/detail_page', $this->data);
    }

    // ==============================================
    // NEW: HALAMAN DIAGNOSIS (NEW TAB)
    // ==============================================
    public function diagnosis($patientNo)
    {
        $this->data['title'] = 'Riwayat Diagnosis | ' . $_ENV['APP_TITLE'];
        $this->data['patientNo'] = $patientNo;
        $this->data['menu'] = 'diagnosis';

        return view('rm_riwayat_medis/detail_page', $this->data);
    }

    // ==============================================
    // API untuk mengambil data detail halaman
    // ==============================================
    public function getDetailPageData()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request']);
        }

        $patientNo = $this->request->getVar('patient_no');
        $menu = $this->request->getVar('menu');

        if (empty($patientNo) || empty($menu)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Parameter tidak lengkap']);
        }

        // Ambil data pasien
        $urlPatient = "$this->server5/api/RmPatients/$patientNo";
        $responsePatient = akses_restapi('GET', $urlPatient, []);
        $resultPatient = json_decode($responsePatient, true);

        // Ambil data sesuai menu
        $urlData = "$this->server5/api/RmPatients/$patientNo/" . $menu;
        $responseData = akses_restapi('GET', $urlData, []);
        $resultData = json_decode($responseData, true);

        return $this->response->setJSON([
            'status' => 'success',
            'patient' => $resultPatient['data']['patient'] ?? [],
            'data' => $resultData['data'] ?? []
        ]);
    }
}
