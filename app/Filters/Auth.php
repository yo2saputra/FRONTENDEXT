<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\I18n\Time;
use DateTime;


class Auth implements FilterInterface
{
    protected $server;
    protected $server3;

    public function __construct()
    {
        $this->server = $_ENV['APP_API'];
        $this->server3 = $_ENV['APP_API3'];
    }

    // public function before(RequestInterface $request, $arguments = null)
    // {
    //     if (!session()->get('isLogin')) {
    //         return redirect()->to('/auth/login');
    //     }

    //     // if (date('Y-m-d', strtotime(session()->get('pwd_exp_dt'))) == '1970-01-01') {
    //     //     $date = session()->get('pwd_exp_dt');
    //     //     $date = str_replace('/', '-', $date);
    //     // } else {
    //     //     $date = session()->get('pwd_exp_dt');
    //     // }

    //     $date_exp = Time::parse(date('Y-m-d', strtotime(session()->get('pwd_exp_dt'))));
    //     $date_now = Time::now();
    //     //$date_now = Time::parse(date('Y-m-d', strtotime('2023-10-10 00:00:00')));

    //     $diff = $date_now->difference($date_exp);

    //     if ($diff->getDays() < 0) {

    //         //load session
    //         $session = session();
    //         //delete session
    //         $session->destroy();

    //         return redirect()->to('/auth/reset');
    //     }

    //     $uri = service('URI');

    //     $server = $_ENV['APP_API'];
    //     $usr_id = session()->get('usr_id');


    //     // //Set metode request dan endpoint
    //     // $response = $client->request("GET", "$server/menu/menu/$usr_id");
    //     // //get body from response
    //     // $content = $response->getBody();
    //     // $data['response_data'] = json_decode($content, true);
    //     // $result = $data['response_data'];

    //     helper(['restclient']);
    //     $url = "$server/menu/menu/$usr_id";
    //     $response = akses_restapi('GET', $url, []);
    //     $data['response_data'] = json_decode($response, true);
    //     $result = $data['response_data'];

    //     $menu = [];
    //     foreach ($result as $data_menu) {
    //         $menu[] = $data_menu['reference'];
    //     }

    //     // Default menu for all user
    //     $default_menu = ['dashboard', 'mod'];
    //     // Merge default menu + menu by role
    //     $menu = array_merge($default_menu, $menu);

    //     $menuarr = implode(', ', $menu);

    //     $filter = explode(', ', $menuarr);

    //     if (!in_array($uri->getSegment(1), $filter)) {
    //         //hapus session 
    //         session()->destroy();
    //         return redirect()->to('/auth/login');
    //     }
    // }

    public function before(RequestInterface $request, $arguments = null)
    {
        // ✅ Cek login
        if (!session()->get('isLogin')) {
            if ($request instanceof IncomingRequest && !$request->isAJAX()) {
                return redirect()->to('/auth/login');
            } else {
                return \Config\Services::response()->setJSON(['status' => 'session_expired']);
            }
        }

        // ✅ Cek expired password
        // $pwdExp = session()->get('pwd_exp_dt');
        // if ($pwdExp) {
        //     $date_exp = Time::parse(date('Y-m-d', strtotime($pwdExp)));
        //     $date_now = Time::now();
        //     $diff = $date_now->difference($date_exp);

        //     if ($diff->getDays() < 0) {
        //         session()->destroy();
        //         return redirect()->to('/auth/reset');
        //     }
        // }


        // ✅ Cek expired password - enhanced
        $pwdExp = session()->get('pwd_exp_dt');
        if ($pwdExp) {
            // Parsing format d/m/Y H:i:s ke objek DateTime
            $dateObj = DateTime::createFromFormat('d/m/Y H:i:s', $pwdExp);

            if ($dateObj) {
                // Konversi ke format Y-m-d agar bisa diparse oleh Time
                $date_exp = Time::parse($dateObj->format('Y-m-d'));
                $date_now = Time::now();
                $diff = $date_now->difference($date_exp);

                if ($diff->getDays() < 0) {
                    session()->destroy();
                    return redirect()->to('/auth/reset');
                }
            }
            // else {
            //     // Optional: log error atau fallback jika parsing gagal
            //     log_message('error', 'Format tanggal tidak valid: ' . $pwdExp);
            // }
        }


        // ✅ Cek akses menu berdasarkan role
        $uri = service('uri');
        $menuSegment = $uri->getSegment(1); // misalnya 'tmstwarehouse'

        $usr_id = session()->get('usr_id');

        helper(['restclient']);

        // end point
        $url = "{$this->server3}/api/menu/menu/$usr_id";

        // client request
        $response = akses_restapikey('GET', $url, []);

        $result = json_decode($response, true);

        // Normalisasi respons agar formatnya sama
        if (isset($result['success']) && $result['success'] === true && isset($result['data'])) {
            $normalizedResult = $result['data'];
        } else {
            $normalizedResult = [];
        }

        $menu = [];
        if (is_array($normalizedResult)) {
            foreach ($normalizedResult as $data_menu) {
                if (isset($data_menu['reference'])) {
                    $menu[] = $data_menu['reference'];
                }
            }
        }

        $default_menu = ['dashboard', 'mod'];
        $allowed_menu = array_merge($default_menu, $menu);


        if (!in_array($menuSegment, $allowed_menu)) {
            session()->destroy();

            if ($request instanceof IncomingRequest && !$request->isAJAX()) {
                return redirect()->to('/auth/login');
            } else {
                return \Config\Services::response()->setJSON(['status' => 'session_expired']);
            }
        }

        return null; // ✅ lanjut ke controller
    }


    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
