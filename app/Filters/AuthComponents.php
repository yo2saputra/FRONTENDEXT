<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\I18n\Time;
use DateTime;


class AuthComponents implements FilterInterface
{
    protected $server;
    protected $server3;

    public function __construct()
    {
        $this->server = $_ENV['APP_API'];
        $this->server3 = $_ENV['APP_API3'];
    }

    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('isLogin')) {
            // Cek apakah request adalah AJAX
            if ($request instanceof IncomingRequest && !$request->isAJAX()) {
                // Jika bukan AJAX, return response dengan status 403 Forbidden
                return redirect()->to('/auth/login');
            } else {
                return \Config\Services::response()->setJSON(['status' => 'session_expired']);
            }
        }

        return null; // Lanjutkan ke controller jika session valid
    }


    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
