<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $validation;
    protected $userModel;
    protected $server;
    protected $client;
    protected $session;

    public function __construct()
    {
        $this->server = $_ENV['APP_API'];

        //membuat user model untuk konek ke database 
        //$userModel = new UserModel();

        //library CURLrequest
        // $this->client = service('curlrequest');

        //meload validation
        $validation = \Config\Services::validation();

        //meload session
        $session = \Config\Services::session();
    }

    public function login()
    {
        if (session()->get('isLogin')) {
            return redirect()->to('');
        }

        $data = [
            'title' => 'Login | ' . $_ENV['APP_TITLE']
        ];

        //menampilkan halaman login
        return view('auth/login', $data);
    }

    public function valid_login()
    {
        helper(['form']);
        $session = session();

        $data = [
            'title' => 'Reset | ' . $_ENV['APP_TITLE']
        ];

        $rules = [
            'username' => [
                'label' => 'Username',
                'rules' => 'required',
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required',
            ]
        ];

        if ($this->validate($rules)) {

            $user = $this->request->getVar('username');
            $password = $this->request->getVar('password');

            // $curl = service('curlrequest');

            // $response = $curl->request("GET", "$this->server/login/checklogin/$user/$password", [
            //     "headers" => [
            //         "Accept" => "application/json"
            //     ]
            // ]);
            // $content = $response->getBody();
            // $data['response_data'] = json_decode($content, true);

            // helper curl request
            helper(['restclient']);
            // endpoint
            $url = "$this->server/login/checklogin/$user/$password";
            // client request
            $response = akses_restapi('GET', $url, []);

            // dd($response);
            $data['response_data'] = json_decode($response, true);

            if ($data['response_data']) {

                if ($data['response_data'][0]['confirm'] === "PASSED") {
                    $ses_data = [
                        'usr_id' => $data['response_data'][0]['usr_id'],
                        'emp_cd' => $data['response_data'][0]['emp_cd'],
                        'fullname' => $data['response_data'][0]['fullname'],
                        'emp_nm' => $data['response_data'][0]['emp_nm'],
                        'email' => $data['response_data'][0]['email'],
                        'mobile_no' => $data['response_data'][0]['mobile_no'],
                        'pwd_exp_dt' => $data['response_data'][0]['pwd_exp_dt'],
                        'whatsapp_no' => $data['response_data'][0]['whatsapp_no'],
                        'role_cd' => $data['response_data'][0]['role_cd'],
                        'isLogin' => TRUE,
                        'salespointcd' => $data['response_data'][0]['salespointcd']
                    ];

                    $session->set($ses_data);
                    return redirect()->to('/dashboard');
                } else {
                    $session->setFlashdata('msg', 'Password is incorrect.');
                    return redirect()->to('/auth/login')->withInput();
                }
            } else {
                $session->setFlashdata('msg', 'User does not exist.');
                return redirect()->to('/auth/login')->withInput();
            }
        } else {
            echo view('/auth/login', ['validation' => $this->validator, 'title' => $data['title']]);

            // $session->setFlashdata('msg', 'user or password can\'t empty');
            // return redirect()->to('/auth/login')->withInput();
        }
    }

    public function changepassword()
    {
        $data = [
            'title' => 'Change Password | ' . $_ENV['APP_TITLE']
        ];

        //hapus session 
        // $this->session->destroy();

        //menampilkan halaman register
        return view('auth/changepassword', $data);
    }

    public function valid_changepassword()
    {
        helper(['form']);
        $session = session();

        $data = [
            'title' => 'Change Password | ' . $_ENV['APP_TITLE']
        ];

        $rules = [
            'newpassword' => [
                'label' => 'New Password',
                'rules' => 'required|min_length[4]|max_length[100]',
            ],
            'confirmnewpassword' => [
                'label' => 'Confirm New Password',
                'rules' => 'matches[newpassword]',
            ],

        ];

        if ($this->validate($rules)) {

            $usr_id = $session->get('usr_id');
            $newpassword = $this->request->getVar('newpassword');

            // helper curl request
            helper(['restclient']);
            // endpoint
            $url = "$this->server/login/changepassword";
            // form params
            $data = [
                "usr_id" => $usr_id,
                "newpassword" => $newpassword
            ];
            // client request
            $response = akses_restapi('PUT', $url, $data);

            $session->setFlashdata('msg_success', 'Change Password Success.');
            return redirect()->to('/auth/login')->withInput();
        } else {
            $data['validation'] = $this->validator;
            echo view('/auth/changepassword', $data);
        }
    }

    public function register()
    {
        $data = [
            'title' => 'Register | ' . $_ENV['APP_TITLE']
        ];

        //menampilkan halaman register
        return view('auth/register', $data);
    }

    public function valid_register()
    {
        helper(['form']);
        $rules = [
            'username' => [
                'label' => 'Username',
                'rules' => 'required|min_length[2]|max_length[50]',
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required|min_length[4]|max_length[100]',
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required|min_length[4]|max_length[50]',
            ],
            'confirmpassword' => [
                'label' => 'Confirm Password',
                'rules' => 'matches[password]',
            ]
        ];

        if ($this->validate($rules)) {
            $userModel = new UserModel();
            $data = [
                'username' => $this->request->getVar('username'),
                'email'    => $this->request->getVar('email'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
            ];
            $userModel->save($data);

            session()->setFlashdata('login', 'Anda berhasil mendaftar, silahkan login');
            return redirect()->to('/auth/login');
        } else {
            $data['validation'] = $this->validator;
            echo view('/auth/register', $data);
        }
    }

    public function logout()
    {
        //hapus session 
        $this->session->destroy();
        //balikan ke halaman login
        return redirect()->to('/auth/login');
    }

    public function reset()
    {
        $data = [
            'title' => 'Reset | ' . $_ENV['APP_TITLE']
        ];

        //menampilkan halaman reset
        return view('auth/reset', $data);
    }
}
