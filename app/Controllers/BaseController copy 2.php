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
// use CodeIgniter\I18n\Time;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['form', 'url'];

    protected $data;
    protected $templateModel;
    protected $deltafoodModel;
    protected $client;
    protected $session;
    protected $server;
    protected $server3;

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
        $this->session = session();
        $this->server = $_ENV['APP_API'];
        $this->server3 = $_ENV['APP_API3'];

        // Load menu dari API
        $this->data['menu'] = $this->getMenuFromApi();  // Ganti apiMenu() dengan ini


        // if (session()->get('isLogin')) {
        //     $this->data = [
        //         'menu_header' => $this->apiMenuHeader(session()->get('usr_id')),
        //         'menu' => $this->apiMenu(session()->get('usr_id'))
        //     ];
        // }
    }

    private function getMenuFromApi()
    {
        $usr_id = $this->session->get('usr_id');
        if (!$usr_id) {
            return [];
        }

        $url = $this->server3 . "/api/menu/sidebar";  // Endpoint API baru

        $client = \Config\Services::curlrequest();

        try {
            $response = $client->get($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->session->get('token'),  // Sesuaikan jika pakai token
                    'Accept' => 'application/json'
                ]
            ]);

            $result = json_decode($response->getBody(), true);

            if (isset($result['success']) && $result['success'] && isset($result['data'])) {
                return $result['data'];
            }
        } catch (\Exception $e) {
            log_message('error', 'API Menu Error: ' . $e->getMessage());
        }

        return [];
    }

    public function getTemplateData()
    {
        $this->templateModel = new TemplateModel();
        $this->deltafoodModel = new DeltafoodModel();
        $this->data['template'] = $this->templateModel->getTemplate();
        $this->data['textFooterDeltafood'] = $this->deltafoodModel->getTextFooterDeltafood();

        $this->client = \Config\Services::curlrequest();
        //Set metode request dan endpoint
        $response = $this->client->request('GET', 'https://test-api.jualinternet.com/kontak');
        //Ambil body dari response
        $content = $response->getBody();
        $data['respon_kontak'] = json_decode($content, true);
        $this->data['kontak_api'] = $data['respon_kontak']['kontak'][0];

        return $this->data;
    }

    public function apiMenuHeader($user_id)
    {

        // helper curl request
        helper(['restclient']);
        // endpoint
        $url = "$this->server/menu/menuheader/$user_id";
        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);
        return $data['response_data'];
    }

    public function apiMenu($user_id)
    {

        // helper curl request
        helper(['restclient']);
        // endpoint
        $url = "$this->server/menu/menu/$user_id";
        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);
        return $data['response_data'];
    }

    public function apiMenuFlag($menu_cd, $role_cd)
    {
        $session = session();

        // helper curl request
        helper(['restclient']);
        // endpoint
        $url = "$this->server/menurole/getby/$menu_cd/$role_cd";
        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);
        // return $data['response_data'];

        $ses_data = [
            'flag_insert' => $data['response_data'][0]['flag_insert'],
            'flag_update' => $data['response_data'][0]['flag_update'],
            'flag_delete' => $data['response_data'][0]['flag_delete'],
            'flag_view' => $data['response_data'][0]['flag_view'],
            'flag_print' => $data['response_data'][0]['flag_print'],
            'flag_export' => $data['response_data'][0]['flag_export']
        ];

        $session->set($ses_data);
    }

    public function apiMenuMenucd($reference)
    {

        // helper curl request
        helper(['restclient']);
        // endpoint
        $url = "$this->server/menu/menucd/$reference";
        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);
        return $data['response_data'];
    }
}
