<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Master\UserModel;

class User extends BaseController
{
    protected $userModel;
    protected $data;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $this->data = [
            'title' => 'User | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['users'] = $this->userModel->getUser();

        return view('admin/user/index', $this->data);
    }

    public function detail($id)
    {

        $this->data = [
            'title' => 'Detail User | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['users'] = $this->userModel->where(['id' => $id])->first();

        if (empty($this->data['users'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Id ' . $id . ' tidak ditemukan.');
        }

        return view('admin/user/detail', $this->data);
    }

    public function create()
    {
        helper(['form']);
        $this->data = [
            'title' => 'Create User | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['validation'] = $this->validator;

        return view('admin/user/create', $this->data);
    }

    public function save()
    {
        helper(['form']);
        $rules = [
            'username' => [
                'label' => 'User Name',
                'rules' => 'required|is_unique[user.username]',
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required|is_unique[user.email]',
            ],
            'role' => [
                'label' => 'Role',
                'rules' => 'required',
            ],
            'aktif' => [
                'label' => 'Status Aktif',
                'rules' => 'required',
            ]
        ];

        // dd($this->request->getVar());

        if ($this->validate($rules)) {


            $this->userModel->save([
                'username' => $this->request->getVar('username'),
                'email' => $this->request->getVar('email'),
                'role' => $this->request->getVar('role'),
                'aktif' => session()->get('aktif')
            ]);

            session()->setFlashdata('pesan', 'Data berhasil tambah!');

            return redirect()->to('/admin/user');
        } else {
            $this->data = [
                'title' => 'Create User | PT. DELTA FOOD DISTRIBUSI'
            ];

            return redirect()->to('/admin/user/create')->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function edit($id)
    {
        helper(['form']);
        $this->data = [
            'title' => 'Edit User | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['users'] = $this->userModel->getUser($id);

        return view('admin/user/edit', $this->data);
    }

    public function update($id)
    {
        helper(['form']);
        $datalama = $this->userModel->getUser($this->request->getVar('id'));

        if ($datalama['username'] == $this->request->getVar('username')) {
            $rule_username = 'required';
        } else {
            $rule_username = 'required|is_unique[user.username]';
        }

        if ($datalama['email'] == $this->request->getVar('email')) {
            $rule_email = 'required';
        } else {
            $rule_email = 'required|is_unique[user.email]';
        }

        $rules = [
            'username' => [
                'label' => 'User Name',
                'rules' => $rule_username
            ],
            'email' => [
                'label' => 'Email',
                'rules' => $rule_email,
            ],
            'role' => [
                'label' => 'Role',
                'rules' => 'required'
            ],
            'aktif' => [
                'label' => 'Status Aktif',
                'rules' => 'required'
            ]
        ];

        if ($this->validate($rules)) {

            $this->userModel->save([
                'id' => $id,
                'username' => $this->request->getVar('username'),
                'email' => $this->request->getVar('email'),
                'role' => $this->request->getVar('role'),
                'aktif' => $this->request->getVar('aktif'),
                'userId' => session()->get('id')
            ]);

            // buat session pesan
            session()->setFlashdata('pesan', 'Data berhasil diupdate!');

            return redirect()->to('/admin/user');
        } else {

            $this->data = [
                'title' => 'Edit User | PT. DELTA FOOD DISTRIBUSI'
            ];

            return redirect()->to('/admin/user/edit/' . $this->request->getVar('id'))->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function reset()
    {
        $this->data = [
            'title' => 'Reset | PT. DELTA FOOD DISTRIBUSI'
        ];

        if (session()->get('id')) {
            echo view('/admin/user/reset', $this->data);
        } else {
            echo view('/auth/login');
        }
    }

    public function valid_reset()
    {
        helper(['form']);
        $rules = [
            'password'      => 'required|min_length[4]|max_length[50]',
            'confirmpassword'  => 'matches[password]'
        ];

        if ($this->validate($rules)) {
            $userModel = new UserModel();
            $id = session()->get('id');
            $data = [
                'id' => $id,
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
            ];
            $userModel->save($data);

            // session()->setFlashdata('login', 'Anda berhasil mendaftar, silahkan login');

            //hapus session 
            $this->session->destroy();

            //balikan ke halaman login
            return redirect()->to('/auth/login');
        } else {
            $data['validation'] = $this->validator;
            echo view('/admin/user/reset', $data);
        }
    }

    public function reset_default($id)
    {
        $data = [
            'id' => $id,
            'password' => password_hash(12345678, PASSWORD_DEFAULT)
        ];
        $this->userModel->save($data);
        session()->setFlashdata('pesan', 'Password berhasil set!');
        return redirect()->to('/admin/user');
    }

    public function delete($id)
    {
        $this->userModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus!');
        return redirect()->to('/admin/user');
    }
}
