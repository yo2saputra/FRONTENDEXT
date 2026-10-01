<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Master\DistribusiModel;

class Distribusi extends BaseController
{
    protected $distribusiModel;
    protected $data;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->distribusiModel = new DistribusiModel();
    }

    public function index()
    {
        $this->data = [
            'title' => 'Distribusi | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['distribusies'] = $this->distribusiModel->getDistribusi();

        return view('admin/distribusi/index', $this->data);
    }

    public function detail($id)
    {

        $this->data = [
            'title' => 'Detail Distribusi | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['distribusies'] = $this->distribusiModel->where(['id' => $id])->first();

        if (empty($this->data['distribusies'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Id ' . $id . ' tidak ditemukan.');
        }

        return view('admin/distribusi/detail', $this->data);
    }

    public function create()
    {
        helper(['form']);
        $this->data = [
            'title' => 'Create Distribusi | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['validation'] = $this->validator;

        return view('admin/distribusi/create', $this->data);
    }

    public function save()
    {
        helper(['form']);
        $rules = [
            'namaDistribusi' => [
                'label' => 'Nama',
                'rules' => 'required|is_unique[distribusi.namaDistribusi]'
            ],
            'keteranganDistribusi' => [
                'label' => 'Keterangan',
                'rules' => 'required'
            ],
            'gambarDistribusi' => [
                'label' => 'Gambar',
                'rules' => 'max_size[gambarDistribusi,1024]|is_image[gambarDistribusi]|mime_in[gambarDistribusi,image/jpg,image/jpeg,image/png]',
            ]
        ];

        if ($this->validate($rules)) {

            $gambar = $this->request->getFile('gambarDistribusi');

            if ($gambar->getError() == 4) {
                $namagambar = 'default.jpg';
            } else {
                $namagambar = $gambar->getRandomName();
                $gambar->move('assets/img/distribusi/', $namagambar);
            }

            $this->distribusiModel->save([
                'namaDistribusi' => $this->request->getVar('namaDistribusi'),
                'keteranganDistribusi' => $this->request->getVar('keteranganDistribusi'),
                'gambarDistribusi' => $namagambar,
                'userId' => session()->get('id')
            ]);

            session()->setFlashdata('pesan', 'Data berhasil tambah!');

            return redirect()->to('/admin/distribusi');
        } else {

            $this->data = [
                'title' => 'Create Distribusi | PT. DELTA FOOD DISTRIBUSI'
            ];

            return redirect()->to('/admin/distribusi/create')->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function edit($id)
    {
        helper(['form']);
        $this->data = [
            'title' => 'Edit Distribusi | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['distribusies'] = $this->distribusiModel->getDistribusi($id);

        return view('admin/distribusi/edit', $this->data);
    }

    public function update($id)
    {
        helper(['form']);
        $datalama = $this->distribusiModel->getDistribusi($this->request->getVar('id'));

        if ($datalama['namaDistribusi'] == $this->request->getVar('namaDistribusi')) {
            $rule_judul = 'required';
        } else {
            $rule_judul = 'required|is_unique[distribusi.namaDistribusi]';
        }

        $rules = [
            'namaDistribusi' => [
                'label' => 'Judul',
                'rules' => $rule_judul
            ],
            'keteranganDistribusi' => [
                'label' => 'Keterangan',
                'rules' => 'required'
            ],
            'gambarDistribusi' => [
                'label' => 'Gambar',
                'rules' => 'max_size[gambarDistribusi,1024]|is_image[gambarDistribusi]|mime_in[gambarDistribusi,image/jpg,image/jpeg,image/png]',
            ]
        ];


        if ($this->validate($rules)) {

            $gambar = $this->request->getFile('gambarDistribusi');
            $gambarlama = $this->request->getVar('gambarDistribusiLama');

            // jika tidak ada file yang diupload
            if ($gambar->getError() == 4) {
                // gunakan nama file lama
                $namagambar = $gambarlama;
            } else {
                // buat nama gambar acak
                $namagambar = $gambar->getRandomName();
                // upload gambar baru
                $gambar->move('assets/img/distribusi/', $namagambar);

                // jika gambar bukan default maka hapus
                if ($gambarlama != 'default.jpg') {
                    // hapus gambar lama
                    unlink('assets/img/distribusi/' . $gambarlama);
                }
            }

            $this->distribusiModel->save([
                'id' => $id,
                'namaDistribusi' => $this->request->getVar('namaDistribusi'),
                'keteranganDistribusi' => $this->request->getVar('keteranganDistribusi'),
                'gambarDistribusi' => $namagambar,
                'userId' => session()->get('id')
            ]);

            // buat session pesan
            session()->setFlashdata('pesan', 'Data berhasil diupdate!');

            return redirect()->to('/admin/distribusi');
        } else {

            $this->data = [
                'title' => 'Edit Distribusi | PT. DELTA FOOD DISTRIBUSI'
            ];

            return redirect()->to('/admin/distribusi/edit/' . $this->request->getVar('id'))->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function delete($id)
    {
        //cari gambar berdasarkan id
        $gambar = $this->distribusiModel->find($id);


        // jika gambar bukan default maka hapus
        if ($gambar['gambarDistribusi'] != 'default.jpg') {
            // hapus gambar
            unlink('assets/img/distribusi/' . $gambar['gambarDistribusi']);
        }


        $this->distribusiModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus!');
        return redirect()->to('/admin/distribusi');
    }
}
