<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Master\PagedistribusiModel;


class Pagedistribusi extends BaseController
{
    protected $pagedistribusiModel;
    protected $data;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->session = session();
        $this->pagedistribusiModel = new PagedistribusiModel();
    }

    public function index()
    {

        $this->data = [
            'title' => 'Page Distribusi | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['pagedistribusies'] = $this->pagedistribusiModel->getPagedistribusi();

        return view('admin/pagedistribusi/index', $this->data);
    }

    public function detail($id)
    {

        $this->data = [
            'title' => 'Detail Page Distribusi | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['pagedistribusies'] = $this->pagedistribusiModel->where(['id' => $id])->first();

        if (empty($this->data['pagedistribusies'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Id ' . $id . ' tidak ditemukan.');
        }

        return view('admin/pagedistribusi/detail', $this->data);
    }

    public function edit($id)
    {
        helper(['form']);
        $this->data = [
            'title' => 'Edit Page Distribusi | PT. DELTA FOOD DISTRIBUSI'
        ];
        $this->data['pagedistribusies'] = $this->pagedistribusiModel->getPagedistribusi($id);

        return view('admin/pagedistribusi/edit', $this->data);
    }

    public function update($id)
    {
        helper(['form']);

        $rules = [
            'judulDistribusi' => [
                'label' => 'Judul Distribusi',
                'rules' => 'required'
            ],
            'judulDistribusiWarna' => [
                'label' => 'Judul Distribusi Warna',
                'rules' => 'required'
            ],
            'textDistribusi' => [
                'label' => 'Text Distribusi',
                'rules' => 'required'
            ],
            'judulCabang' => [
                'label' => 'Judul Cabang',
                'rules' => 'required'
            ],
            'judulCabangWarna' => [
                'label' => 'Judul Cabang Warna',
                'rules' => 'required'
            ],
            'textCabang' => [
                'label' => 'Text Cabang',
                'rules' => 'required'
            ]
        ];

        if ($this->validate($rules)) {

            $this->pagedistribusiModel->save([
                'id' => $id,
                'judulDistribusi' => $this->request->getVar('judulDistribusi'),
                'judulDistribusiWarna' => $this->request->getVar('judulDistribusiWarna'),
                'textDistribusi' => $this->request->getVar('textDistribusi'),
                'judulCabang' => $this->request->getVar('judulCabang'),
                'judulCabangWarna' => $this->request->getVar('judulCabangWarna'),
                'textCabang' => $this->request->getVar('textCabang'),
                'userId' => session()->get('id')
            ]);

            // buat session pesan
            session()->setFlashdata('pesan', 'Data berhasil diupdate!');

            return redirect()->to('/admin/pagedistribusi');
        } else {

            $this->data = [
                'title' => 'Edit Page Distribusi | PT. DELTA FOOD DISTRIBUSI'
            ];

            return redirect()->to('/admin/pagedistribusi/edit/' . $this->request->getVar('id'))->withInput()->with('errors', $this->validator->getErrors());
        }
    }
}
