<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Master\KontakModel;

class Kontak extends BaseController
{
    protected $kontakModel;
    protected $data;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->kontakModel = new KontakModel();
    }

    public function index()
    {
        $this->data = [
            'title' => 'Kontak | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['kontaks'] = $this->kontakModel->getKontak();

        return view('admin/kontak/index', $this->data);
    }

    public function detail($id)
    {
        $this->data = [
            'title' => 'Detail Kontak | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['kontaks'] = $this->kontakModel->where(['id' => $id])->first();

        if (empty($this->data['kontaks'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Id ' . $id . ' tidak ditemukan.');
        }

        return view('admin/kontak/detail', $this->data);
    }

    public function edit($id)
    {
        helper(['form']);
        $this->data = [
            'title' => 'Edit Kontak | PT. DELTA FOOD DISTRIBUSI'
        ];
        $this->data['kontaks'] = $this->kontakModel->getKontak($id);

        return view('admin/kontak/edit', $this->data);
    }

    public function update($id)
    {
        helper(['form']);

        $rules = [
            'email' => [
                'label' => 'Email',
                'rules' => 'required'
            ],
            'textKontak' => [
                'label' => 'Text Kontak',
                'rules' => 'required'
            ],
            'map' => [
                'label' => 'Map',
                'rules' => 'required'
            ]
        ];

        if ($this->validate($rules)) {

            $this->kontakModel->save([
                'id' => $id,
                'email' => $this->request->getVar('email'),
                'textKontak' => $this->request->getVar('textKontak'),
                'map' => $this->request->getVar('map'),
                'userId' => session()->get('id')
            ]);

            // buat session pesan
            session()->setFlashdata('pesan', 'Data berhasil diupdate!');

            return redirect()->to('/admin/kontak');
        } else {

            $this->data = [
                'title' => 'Edit Kontak | PT. DELTA FOOD DISTRIBUSI'
            ];

            return redirect()->to('/admin/kontak/edit/' . $this->request->getVar('id'))->withInput()->with('errors', $this->validator->getErrors());
        }
    }
}
