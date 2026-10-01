<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Master\BerandaModel;


class Beranda extends BaseController
{
    protected $berandaModel;
    protected $data;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->session = session();
        $this->berandaModel = new BerandaModel();
    }

    public function index()
    {

        $this->data = [
            'title' => 'Beranda | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['berandas'] = $this->berandaModel->getBeranda();

        return view('admin/beranda/index', $this->data);
    }

    public function detail($id)
    {

        $this->data = [
            'title' => 'Detail Beranda | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['berandas'] = $this->berandaModel->where(['id' => $id])->first();

        if (empty($this->data['berandas'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Id ' . $id . ' tidak ditemukan.');
        }

        return view('admin/beranda/detail', $this->data);
    }

    public function edit($id)
    {
        helper(['form']);
        $this->data = [
            'title' => 'Edit Beranda | PT. DELTA FOOD DISTRIBUSI'
        ];
        $this->data['berandas'] = $this->berandaModel->getBeranda($id);

        return view('admin/beranda/edit', $this->data);
    }

    public function update($id)
    {
        helper(['form']);

        $rules = [
            'judulProduk' => [
                'label' => 'Judul Produk',
                'rules' => 'required'
            ],
            'judulProdukWarna' => [
                'label' => 'Judul Produk Warna',
                'rules' => 'required'
            ],
            'textProduk' => [
                'label' => 'Text Produk',
                'rules' => 'required'
            ],
            'judulBlog' => [
                'label' => 'Judul Blog',
                'rules' => 'required'
            ],
            'judulBlogWarna' => [
                'label' => 'Judul Blog Warna',
                'rules' => 'required'
            ],
            'textBlog' => [
                'label' => 'Text Blog',
                'rules' => 'required'
            ]
        ];

        if ($this->validate($rules)) {

            $this->berandaModel->save([
                'id' => $id,
                'judulProduk' => $this->request->getVar('judulProduk'),
                'judulProdukWarna' => $this->request->getVar('judulProdukWarna'),
                'textProduk' => $this->request->getVar('textProduk'),
                'judulBlog' => $this->request->getVar('judulBlog'),
                'judulBlogWarna' => $this->request->getVar('judulBlogWarna'),
                'textBlog' => $this->request->getVar('textBlog'),
                'userId' => session()->get('id')
            ]);

            // buat session pesan
            session()->setFlashdata('pesan', 'Data berhasil diupdate!');

            return redirect()->to('/admin/beranda');
        } else {

            $this->data = [
                'title' => 'Edit Beranda | PT. DELTA FOOD DISTRIBUSI'
            ];

            return redirect()->to('/admin/beranda/edit/' . $this->request->getVar('id'))->withInput()->with('errors', $this->validator->getErrors());
        }
    }
}
