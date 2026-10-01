<?php

namespace App\Filters;

use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class SessionCheck implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {


        if (!session()->get('isLogin')) {
            // if ($request->isAJAX()) {
            //     return \Config\Services::response()->setJSON(['status' => 'session_expired']);
            // } else {
            //     return redirect()->to('/auth/login');
            // }

            // Cek apakah request adalah AJAX
            if ($request instanceof IncomingRequest && !$request->isAJAX()) {
                // Jika bukan AJAX, return response dengan status 403 Forbidden
                return redirect()->to('/auth/login');
            } else {
                return \Config\Services::response()->setJSON(['status' => 'session_expired']);
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
