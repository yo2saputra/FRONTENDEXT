<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\TemplateModel;
use App\Models\DeltafoodModel;

/**
 * Class BaseController
 *
 * BaseController untuk semua controller di aplikasi.
 */
abstract class BaseController extends Controller
{
    protected $request;
    protected $helpers = ['form', 'url'];

    protected $data = [];
    protected $templateModel;
    protected $deltafoodModel;
    protected $client;
    protected $session;
    protected $server;
    protected $server3;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->session = session();
        $this->server  = $_ENV['APP_API'];
        $this->server3 = $_ENV['APP_API3'];

        // Autoload helper restclient agar tidak perlu dipanggil berulang
        helper(['restclient', 'menu']);

        // Load menu sidebar multi-level dari API .NET
        $this->loadSidebarMenu();

        // Hitung current reference untuk active menu
        $this->setCurrentReference();

        // Set flag akses (insert/update/delete/view) berdasarkan menu aktif
        $this->setMenuAccessFlags();
    }


    private function setCurrentReference()
    {
        $segment1 = $this->request->getUri()->getSegment(1) ?: '';
        $this->data['current_reference'] = $segment1;
    }

    private function loadSidebarMenu()
    {
        $usr_id = $this->session->get('usr_id');

        if (empty($usr_id)) {
            $this->data['menu'] = [];
            return;
        }

        helper(['restclient']);

        $url = rtrim($this->server3, '/') . '/api/menu/side/' . urlencode($usr_id);

        try {
            $responseBody = akses_restapikey('GET', $url);

            $result = json_decode($responseBody, true);

            if (
                json_last_error() === JSON_ERROR_NONE &&
                isset($result['success']) &&
                $result['success'] === true &&
                isset($result['data'])
            ) {
                $this->data['menu'] = $result['data'];
            } else {
                $this->data['menu'] = [];
            }
        } catch (\Exception $e) {
            log_message('error', '[SIDEBAR MENU] Exception: ' . $e->getMessage());
            $this->data['menu'] = [];
        }
    }

    /**
     * Set flag akses (insert, update, delete, view, print, export) berdasarkan menu aktif
     */
    private function setMenuAccessFlags()
    {
        $uri = $this->request->getUri();
        $segment1 = $uri->getSegment(1) ?: '';
        $segment2 = $uri->getSegment(2) ?: '';

        $reference = $segment1;
        if ($segment2) {
            $reference .= '/' . $segment2;
        }

        if (empty($segment1)) {
            return;
        }

        $menu_info = $this->apiMenuMenucd($segment1);

        $menu_cd   = $menu_info['data'][0]['menu_cd'] ?? '';

        if (!empty($menu_cd)) {
            $this->apiMenuFlag($menu_cd, $this->session->get('role_cd') ?? '');
        }
    }

    // ===================================================================
    // Fungsi untuk template dan data lain
    // ===================================================================

    public function getTemplateData()
    {
        $this->templateModel = new TemplateModel();
        $this->deltafoodModel = new DeltafoodModel();

        $this->data['template'] = $this->templateModel->getTemplate();
        $this->data['textFooterDeltafood'] = $this->deltafoodModel->getTextFooterDeltafood();

        $this->client = \Config\Services::curlrequest();

        try {
            $response = $this->client->request('GET', 'https://test-api.jualinternet.com/kontak');
            $content = $response->getBody();
            $data = json_decode($content, true);
            $this->data['kontak_api'] = $data['kontak'][0] ?? null;
        } catch (\Exception $e) {
            log_message('error', 'Gagal ambil data kontak API: ' . $e->getMessage());
            $this->data['kontak_api'] = null;
        }

        return $this->data;
    }

    public function apiMenuFlag($menu_cd, $role_cd)
    {
        $session = session();

        if (empty($menu_cd) || empty($role_cd)) {
            return;
        }

        $url = "$this->server/menurole/getby/$menu_cd/$role_cd";
        $response = akses_restapi('GET', $url, []);
        $data = json_decode($response, true);

        if (!empty($data) && is_array($data) && isset($data[0])) {
            $ses_data = [
                'flag_insert' => $data[0]['flag_insert'] ?? 0,
                'flag_update' => $data[0]['flag_update'] ?? 0,
                'flag_delete' => $data[0]['flag_delete'] ?? 0,
                'flag_view'   => $data[0]['flag_view']   ?? 0,
                'flag_print'  => $data[0]['flag_print']  ?? 0,
                'flag_export' => $data[0]['flag_export'] ?? 0
            ];
            $session->set($ses_data);
        }
    }

    public function apiMenuMenucd($reference)
    {
        if (empty($reference)) {
            return [];
        }


        $url = "{$this->server3}/api/menu/menucd/$reference";
        $response = akses_restapikey('GET', $url, []);
        $data = json_decode($response, true);

        return $data ?? [];
    }
}
