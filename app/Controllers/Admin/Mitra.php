<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Master\MitraModel;

class Mitra extends BaseController
{
    protected $mitraModel;
    protected $data;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->mitraModel = new MitraModel();
    }

    public function index()
    {
        $this->data = [
            'title' => 'Mitra | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['mitras'] = $this->mitraModel->getMitra();

        return view('admin/mitra/index', $this->data);
    }

    public function detail($id)
    {

        $this->data = [
            'title' => 'Detail Mitra | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['mitras'] = $this->mitraModel->where(['id' => $id])->first();

        if (empty($this->data['mitras'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Id ' . $id . ' tidak ditemukan.');
        }

        return view('admin/mitra/detail', $this->data);
    }

    public function create()
    {
        helper(['form']);
        $this->data = [
            'title' => 'Create Mitra | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['validation'] = $this->validator;

        return view('admin/mitra/create', $this->data);
    }

    public function save()
    {
        helper(['form']);
        $rules = [
            'namaMitra' => [
                'label' => 'Nama',
                'rules' => 'required|is_unique[mitra.namaMitra]'
            ],
            'keteranganMitra' => [
                'label' => 'Keterangan',
                'rules' => 'required'
            ],
            'logoMitra' => [
                'label' => 'Logo',
                'rules' => 'max_size[logoMitra,1024]|is_image[logoMitra]|mime_in[logoMitra,image/jpg,image/jpeg,image/png]',
            ]
        ];

        if ($this->validate($rules)) {

            $gambar = $this->request->getFile('logoMitra');

            if ($gambar->getError() == 4) {
                $namagambar = 'default.jpg';
            } else {
                $namagambar = $gambar->getRandomName();
                $gambar->move('assets/img/mitra/', $namagambar);
            }

            $this->mitraModel->save([
                'namaMitra' => $this->request->getVar('namaMitra'),
                'keteranganMitra' => $this->request->getVar('keteranganMitra'),
                'logoMitra' => $namagambar,
                'kategoriMitra' => $this->request->getVar('kategoriMitra'),
                'userId' => session()->get('id')
            ]);

            session()->setFlashdata('pesan', 'Data berhasil tambah!');

            return redirect()->to('/admin/mitra');
        } else {

            $this->data = [
                'title' => 'Create Mitra | PT. DELTA FOOD DISTRIBUSI'
            ];

            return redirect()->to('/admin/mitra/create')->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function edit($id)
    {
        helper(['form']);
        $this->data = [
            'title' => 'Edit Mitra | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['mitras'] = $this->mitraModel->getMitra($id);

        return view('admin/mitra/edit', $this->data);
    }

    public function update($id)
    {
        helper(['form']);
        $datalama = $this->mitraModel->getMitra($this->request->getVar('id'));

        if ($datalama['namaMitra'] == $this->request->getVar('namaMitra')) {
            $rule_judul = 'required';
        } else {
            $rule_judul = 'required|is_unique[mitra.namaMitra]';
        }

        $rules = [
            'namaMitra' => [
                'label' => 'Judul',
                'rules' => $rule_judul
            ],
            'keteranganMitra' => [
                'label' => 'Keterangan',
                'rules' => 'required'
            ],
            'logoMitra' => [
                'label' => 'Logo',
                'rules' => 'max_size[logoMitra,1024]|is_image[logoMitra]|mime_in[logoMitra,image/jpg,image/jpeg,image/png]',
            ]
        ];


        if ($this->validate($rules)) {

            $gambar = $this->request->getFile('logoMitra');
            $gambarlama = $this->request->getVar('logoMitraLama');

            // jika tidak ada file yang diupload
            if ($gambar->getError() == 4) {
                // gunakan nama file lama
                $namagambar = $gambarlama;
            } else {
                // buat nama gambar acak
                $namagambar = $gambar->getRandomName();
                // upload gambar baru
                $gambar->move('assets/img/mitra/', $namagambar);

                // jika gambar bukan default maka hapus
                if ($gambarlama != 'default.jpg') {
                    // hapus gambar lama
                    unlink('assets/img/mitra/' . $gambarlama);
                }
            }

            $this->mitraModel->save([
                'id' => $id,
                'namaMitra' => $this->request->getVar('namaMitra'),
                'keteranganMitra' => $this->request->getVar('keteranganMitra'),
                'logoMitra' => $namagambar,
                'kategoriMitra' => $this->request->getVar('kategoriMitra'),
                'userId' => session()->get('id')
            ]);

            // buat session pesan
            session()->setFlashdata('pesan', 'Data berhasil diupdate!');

            return redirect()->to('/admin/mitra');
        } else {

            $this->data = [
                'title' => 'Edit Mitra | PT. DELTA FOOD DISTRIBUSI'
            ];

            return redirect()->to('/admin/mitra/edit/' . $this->request->getVar('id'))->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function delete($id)
    {
        //cari gambar berdasarkan id
        $gambar = $this->mitraModel->find($id);


        // jika gambar bukan default maka hapus
        if ($gambar['logoMitra'] != 'default.jpg') {
            // hapus gambar
            unlink('assets/img/mitra/' . $gambar['logoMitra']);
        }


        $this->mitraModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus!');
        return redirect()->to('/admin/mitra');
    }
}
