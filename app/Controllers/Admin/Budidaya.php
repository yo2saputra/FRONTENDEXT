<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Master\BudidayaModel;

class Budidaya extends BaseController
{
    protected $data;
    protected $budidayaModel;

    public function __construct()
    {
        $this->budidayaModel = new BudidayaModel();
        $this->data = [
            'template' => $this->getTemplateData()
        ];
    }

    public function index()
    {
        $this->data['title'] = 'Budidaya | PT. DELTA FOOD DISTRIBUSI';
        $this->data['budidayas'] = $this->budidayaModel->getBudidaya();
        return view('admin/budidaya/index', $this->data);
    }

    public function create()
    {
        helper(['form']);
        $this->data = [
            'title' => 'Create Budidaya | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['validation'] = $this->validator;

        return view('admin/budidaya/create', $this->data);
    }

    public function save()
    {
        helper(['form']);
        $rules = [
            'judulBudidaya' => [
                'label' => 'Judul Budidaya',
                'rules' => 'required'
            ],
            'judulBudidayaWarna' => [
                'label' => 'Judul Budidaya Warna',
                'rules' => 'required'
            ],
            'textBudidaya' => [
                'label' => 'Text Budidaya',
                'rules' => 'required'
            ],
            'isiBudidaya' => [
                'label' => 'Isi Budidaya',
                'rules' => 'required'
            ]
        ];

        if ($this->validate($rules)) {

            $this->budidayaModel->save([
                'judulBudidaya' => $this->request->getVar('judulBudidaya'),
                'judulBudidayaWarna' => $this->request->getVar('judulBudidayaWarna'),
                'textBudidaya' => $this->request->getVar('textBudidaya'),
                'isiBudidaya' => $this->request->getVar('isiBudidaya'),
                'userId' => session()->get('id')
            ]);

            session()->setFlashdata('pesan', 'Data berhasil tambah!');

            return redirect()->to('/admin/budidaya');
        } else {

            $this->data = [
                'title' => 'Create Budidaya | PT. DELTA FOOD DISTRIBUSI'
            ];

            return redirect()->to('/admin/budidaya/create')->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function detail($id = null)
    {
        $this->data['title'] = 'Detail Budidaya | PT. DELTA FOOD DISTRIBUSI';
        if (is_null($id)) {
            return redirect()->to('admin/budidaya');
        }
        $this->data['budidaya'] = $this->budidayaModel->getBudidaya($id);
        return view('admin/budidaya/detail', $this->data);
    }

    public function edit($id)
    {
        helper(['form']);
        $this->data = [
            'title' => 'Edit Budidaya | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['budidaya'] = $this->budidayaModel->getBudidaya($id);
        return view('admin/budidaya/edit', $this->data);
    }

    public function update($id)
    {
        helper(['form']);

        $rules = [
            'judulBudidaya' => [
                'label' => 'Judul Operasinal',
                'rules' => 'required'
            ],
            'judulBudidayaWarna' => [
                'label' => 'Judul Budidaya Warna',
                'rules' => 'required'
            ],
            'textBudidaya' => [
                'label' => 'Text Budidaya',
                'rules' => 'required'
            ],
            'isiBudidaya' => [
                'label' => 'Isi Budidaya',
                'rules' => 'required'
            ]
        ];

        if ($this->validate($rules)) {

            $this->budidayaModel->save([
                'id' => $id,
                'judulBudidaya' => $this->request->getVar('judulBudidaya'),
                'judulBudidayaWarna' => $this->request->getVar('judulBudidayaWarna'),
                'textBudidaya' => $this->request->getVar('textBudidaya'),
                'isiBudidaya' => $this->request->getVar('isiBudidaya'),
                'userId' => session()->get('id')
            ]);

            // buat session pesan
            session()->setFlashdata('pesan', 'Data berhasil diupdate!');

            return redirect()->to('/admin/budidaya');
        } else {

            $this->data = [
                'title' => 'Edit Budidaya | PT. DELTA FOOD DISTRIBUSI'
            ];

            return redirect()->to('/admin/budidaya/edit/' . $this->request->getVar('id'))->withInput()->with('errors', $this->validator->getErrors());
        }
    }
}
