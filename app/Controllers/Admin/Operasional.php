<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Master\OperasionalModel;

class Operasional extends BaseController
{
    protected $data;
    protected $operasionalModel;

    public function __construct()
    {
        $this->operasionalModel = new OperasionalModel();
        $this->data = [
            'template' => $this->getTemplateData()
        ];
    }

    public function index()
    {
        $this->data['title'] = 'Operasional | PT. DELTA FOOD DISTRIBUSI';
        $this->data['operasionals'] = $this->operasionalModel->getOperasional();
        return view('admin/operasional/index', $this->data);
    }

    public function create()
    {
        helper(['form']);
        $this->data = [
            'title' => 'Create Operasional | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['validation'] = $this->validator;

        return view('admin/operasional/create', $this->data);
    }

    public function save()
    {
        helper(['form']);
        $rules = [
            'judulOperasional' => [
                'label' => 'Judul Operasional',
                'rules' => 'required'
            ],
            'judulOperasionalWarna' => [
                'label' => 'Judul Operasional Warna',
                'rules' => 'required'
            ],
            'textOperasional' => [
                'label' => 'Text Operasional',
                'rules' => 'required'
            ],
            'isiOperasional' => [
                'label' => 'Isi Operasional',
                'rules' => 'required'
            ]
        ];

        if ($this->validate($rules)) {

            $this->operasionalModel->save([
                'judulOperasional' => $this->request->getVar('judulOperasional'),
                'judulOperasionalWarna' => $this->request->getVar('judulOperasionalWarna'),
                'textOperasional' => $this->request->getVar('textOperasional'),
                'isiOperasional' => $this->request->getVar('isiOperasional'),
                'userId' => session()->get('id')
            ]);

            session()->setFlashdata('pesan', 'Data berhasil tambah!');

            return redirect()->to('/admin/operasional');
        } else {

            $this->data = [
                'title' => 'Create Operasional | PT. DELTA FOOD DISTRIBUSI'
            ];

            return redirect()->to('/admin/operasional/create')->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function detail($id = null)
    {
        $this->data['title'] = 'Detail Operasional | PT. DELTA FOOD DISTRIBUSI';
        if (is_null($id)) {
            return redirect()->to('admin/operasional');
        }
        $this->data['operasional'] = $this->operasionalModel->getOperasional($id);
        return view('admin/operasional/detail', $this->data);
    }

    public function edit($id)
    {
        helper(['form']);
        $this->data = [
            'title' => 'Edit Operasional | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['operasional'] = $this->operasionalModel->getOperasional($id);
        return view('admin/operasional/edit', $this->data);
    }

    public function update($id)
    {
        helper(['form']);

        $rules = [
            'judulOperasional' => [
                'label' => 'Judul Operasinal',
                'rules' => 'required'
            ],
            'judulOperasionalWarna' => [
                'label' => 'Judul Operasional Warna',
                'rules' => 'required'
            ],
            'textOperasional' => [
                'label' => 'Text Operasional',
                'rules' => 'required'
            ],
            'isiOperasional' => [
                'label' => 'Isi Operasional',
                'rules' => 'required'
            ]
        ];

        if ($this->validate($rules)) {

            $this->operasionalModel->save([
                'id' => $id,
                'judulOperasional' => $this->request->getVar('judulOperasional'),
                'judulOperasionalWarna' => $this->request->getVar('judulOperasionalWarna'),
                'textOperasional' => $this->request->getVar('textOperasional'),
                'isiOperasional' => $this->request->getVar('isiOperasional'),
                'userId' => session()->get('id')
            ]);

            // buat session pesan
            session()->setFlashdata('pesan', 'Data berhasil diupdate!');

            return redirect()->to('/admin/operasional');
        } else {

            $this->data = [
                'title' => 'Edit Operasional | PT. DELTA FOOD DISTRIBUSI'
            ];

            return redirect()->to('/admin/operasional/edit/' . $this->request->getVar('id'))->withInput()->with('errors', $this->validator->getErrors());
        }
    }
}
