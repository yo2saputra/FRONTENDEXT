<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $validation;
    protected $userModel;
    // protected $session;

    public function __construct()
    {
        //membuat user model untuk konek ke database 
        $userModel = new UserModel();

        //meload validation
        $validation = \Config\Services::validation();

        //meload session
        $session = \Config\Services::session();
    }

    public function login()
    {
        $data = [
            'title' => 'Login | PT. DELTA FOOD DISTRIBUSI'
        ];

        //menampilkan halaman login
        return view('auth/login', $data);
    }

    public function register()
    {
        $data = [
            'title' => 'Register | PT. DELTA FOOD DISTRIBUSI'
        ];

        //menampilkan halaman register
        return view('auth/register', $data);
    }

    public function valid_register()
    {
        helper(['form']);
        $rules = [
            'username'          => 'required|min_length[2]|max_length[50]',
            'email'         => 'required|min_length[4]|max_length[100]|valid_email|is_unique[user.email]',
            'password'      => 'required|min_length[4]|max_length[50]',
            'confirmpassword'  => 'matches[password]'
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

    public function valid_login()
    {
        helper(['form']);
        $session = session();
        $userModel = new UserModel();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $data = $userModel->where('email', $email)->where('aktif', 'yes')->first();

        if ($data) {
            $pass = $data['password'];
            $authenticatePassword = password_verify($password, $pass);
            if ($authenticatePassword) {
                $ses_data = [
                    'id' => $data['id'],
                    'username' => $data['username'],
                    'email' => $data['email'],
                    'role' => $data['role'],
                    'isLogin' => TRUE
                ];

                $session->set($ses_data);
                return redirect()->to('/admin/beranda');
            } else {
                $session->setFlashdata('msg', 'Password is incorrect.');
                return redirect()->to('/auth/login')->withInput();
            }
        } else {
            $session->setFlashdata('msg', 'Email does not exist.');
            return redirect()->to('/auth/login')->withInput();
        }
    }

    public function logout()
    {
        //hapus session 
        $this->session->destroy();

        //balikan ke halaman login
        return redirect()->to('/auth/login');
    }
}
