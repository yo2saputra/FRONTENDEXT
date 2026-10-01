<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Master\ResepModel;
use App\Controllers\Admin\Produk;

class Resep extends BaseController
{
    protected $resepModel;
    protected $produk;
    protected $data;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->resepModel = new ResepModel();
        $this->produk = new Produk();
    }

    public function index()
    {
        $this->data = [
            'title' => 'Resep | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['reseps'] = $this->resepModel->getResep();

        return view('admin/resep/index', $this->data);
    }

    public function detail($slug)
    {

        $this->data = [
            'title' => 'Detail Resep | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['reseps'] = $this->resepModel->where(['slugResep' => $slug])->first();

        if (empty($this->data['reseps'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul Resep ' . $slug . ' tidak ditemukan.');
        }

        return view('admin/resep/detail', $this->data);
    }

    public function create()
    {
        helper(['form']);
        $this->data = [
            'title' => 'Create Resep | PT. DELTA FOOD DISTRIBUSI'
        ];
        $this->data['produk'] = $this->produk->apiProdukGetAll();
        $this->data['produk_filter'] = $this->produk->getProdukFilter();
        $this->data['validation'] = $this->validator;

        return view('admin/resep/create', $this->data);
    }

    public function save()
    {
        helper(['form']);
        $rules = [
            'judulResep' => [
                'label' => 'Judul',
                'rules' => 'required|is_unique[resep.judulResep]',
            ],
            'isiResep' => [
                'label' => 'Isi',
                'rules' => 'required',
            ],
            'gambarResep' => [
                'label' => 'Gambar',
                'rules' => 'max_size[gambarResep,1024]|is_image[gambarResep]|mime_in[gambarResep,image/jpg,image/jpeg,image/png]',
            ]
        ];

        if ($this->validate($rules)) {

            $gambar = $this->request->getFile('gambarResep');

            if ($gambar->getError() == 4) {
                $namagambar = 'default.jpg';
            } else {
                $namagambar = $gambar->getRandomName();
                $gambar->move('assets/img/resep/', $namagambar);
            }


            $slug = url_title($this->request->getVar('judulResep'), '-', true);

            $this->resepModel->save([
                'judulResep' => $this->request->getVar('judulResep'),
                'slugResep' => $slug,
                'isiResep' => $this->request->getVar('isiResep'),
                'statusResep' => $this->request->getPost('statusResep'),
                'prosesResep' => $this->request->getPost('prosesResep'),
                'kategoriResep' => $this->request->getPost('kategoriResep'),
                'gambarResep' => $namagambar,
                'userId' => session()->get('id')
            ]);

            session()->setFlashdata('pesan', 'Data berhasil tambah!');

            return redirect()->to('/admin/resep');
        } else {
            $this->data = [
                'title' => 'Create Resep | PT. DELTA FOOD DISTRIBUSI'
            ];

            return redirect()->to('/admin/resep/create')->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function edit($slug)
    {
        helper(['form']);
        $this->data = [
            'title' => 'Edit Resep | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['reseps'] = $this->resepModel->getResep($slug);
        $this->data['produk'] = $this->produk->apiProdukGetAll();
        $this->data['produk_filter'] = $this->produk->getProdukFilter();

        // if (empty($this->data['reseps'])) {
        //     throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul Resep ' . $slug . ' tidak ditemukan.');
        // }

        return view('admin/resep/edit', $this->data);
    }

    public function update($id)
    {

        helper(['form']);
        $datalama = $this->resepModel->getResep($this->request->getVar('slugResep'));

        if ($datalama['judulResep'] == $this->request->getVar('judulResep')) {
            $rule_judul = 'required';
        } else {
            $rule_judul = 'required|is_unique[resep.judulResep]';
        }

        $rules = [
            'judulResep' => [
                'label' => 'Judul',
                'rules' => $rule_judul
            ],
            'isiResep' => [
                'label' => 'Isi',
                'rules' => 'required'
            ],
            'gambarResep' => [
                'label' => 'Gambar',
                'rules' => 'max_size[gambarResep,1024]|is_image[gambarResep]|mime_in[gambarResep,image/jpg,image/jpeg,image/png]',
            ]
        ];

        if ($this->validate($rules)) {

            $gambar = $this->request->getFile('gambarResep');
            $gambarlama = $this->request->getVar('gambarResepLama');
            // dd($gambarlama);

            // jika tidak ada file yang diupload
            if ($gambar->getError() == 4) {
                // gunakan nama file lama
                $namagambar = $gambarlama;
            } else {
                // buat nama gambar acak
                $namagambar = $gambar->getRandomName();
                // upload gambar baru
                $gambar->move('assets/img/resep/', $namagambar);

                // jika gambar bukan default maka hapus
                if ($gambarlama != 'default.jpg') {
                    // hapus gambar lama
                    unlink('assets/img/resep/' . $gambarlama);
                }
            }
            // ganti space dengan stripe
            $slug = url_title($this->request->getVar('judulResep'), '-', true);

            $this->resepModel->save([
                'id' => $id,
                'judulResep' => $this->request->getVar('judulResep'),
                'slugResep' => $slug,
                'isiResep' => $this->request->getVar('isiResep'),
                'statusResep' => $this->request->getVar('statusResep'),
                'prosesResep' => $this->request->getPost('prosesResep'),
                'kategoriResep' => $this->request->getPost('kategoriResep'),
                'gambarResep' => $namagambar,
                'userId' => session()->get('id')
            ]);

            // buat session pesan
            session()->setFlashdata('pesan', 'Data berhasil diupdate!');

            return redirect()->to('/admin/resep');
        } else {

            $this->data = [
                'title' => 'Edit Resep | PT. DELTA FOOD DISTRIBUSI'
            ];

            return redirect()->to('/admin/resep/edit/' . $this->request->getVar('slugResep'))->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function delete($id)
    {
        //cari gambar berdasarkan id
        $gambar = $this->resepModel->find($id);


        // jika gambar bukan default maka hapus
        if ($gambar['gambarResep'] != 'default.jpg') {
            // hapus gambar
            unlink('assets/img/resep/' . $gambar['gambarResep']);
        }


        $this->resepModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus!');
        return redirect()->to('/admin/resep');
    }
}
