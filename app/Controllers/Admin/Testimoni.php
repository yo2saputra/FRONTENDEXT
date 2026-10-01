<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Master\TestimoniModel;

class Testimoni extends BaseController
{
    protected $testimoniModel;
    protected $data;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->testimoniModel = new TestimoniModel();
    }

    public function index()
    {
        $this->data = [
            'title' => 'Testimoni | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['testimonis'] = $this->testimoniModel->getTestimoni();

        return view('admin/testimoni/index', $this->data);
    }

    public function detail($id)
    {

        $this->data = [
            'title' => 'Detail Testimoni | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['testimonis'] = $this->testimoniModel->where(['id' => $id])->first();

        if (empty($this->data['testimonis'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Id ' . $id . ' tidak ditemukan.');
        }

        return view('admin/testimoni/detail', $this->data);
    }

    public function create()
    {
        helper(['form']);
        $this->data = [
            'title' => 'Create Testimoni | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['validation'] = $this->validator;

        return view('admin/testimoni/create', $this->data);
    }

    public function save()
    {
        helper(['form']);
        $rules = [
            'namaBuyer' => [
                'label' => 'Nama',
                'rules' => 'required|is_unique[testimoni.namaBuyer]',
            ],
            'pekerjaanBuyer' => [
                'label' => 'Pekerjaan',
                'rules' => 'required',
            ],
            'isiTestimoni' => [
                'label' => 'Isi',
                'rules' => 'required',
            ],
            'gambarBuyer' => [
                'label' => 'Gambar',
                'rules' => 'max_size[gambarBuyer,1024]|is_image[gambarBuyer]|mime_in[gambarBuyer,image/jpg,image/jpeg,image/png]',
            ]
        ];

        if ($this->validate($rules)) {

            $gambar = $this->request->getFile('gambarBuyer');

            if ($gambar->getError() == 4) {
                $namagambar = 'default.jpg';
            } else {
                $namagambar = $gambar->getRandomName();
                $gambar->move('assets/img/testimoni/', $namagambar);
            }

            $this->testimoniModel->save([
                'namaBuyer' => $this->request->getVar('namaBuyer'),
                'pekerjaanBuyer' => $this->request->getVar('pekerjaanBuyer'),
                'isiTestimoni' => $this->request->getVar('isiTestimoni'),
                'gambarBuyer' => $namagambar,
                'userId' => session()->get('id')
            ]);

            session()->setFlashdata('pesan', 'Data berhasil tambah!');

            return redirect()->to('/admin/testimoni');
        } else {
            $this->data = [
                'title' => 'Create Testimoni | PT. DELTA FOOD DISTRIBUSI'
            ];

            return redirect()->to('/admin/testimoni/create')->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function edit($id)
    {
        helper(['form']);
        $this->data = [
            'title' => 'Edit Testimoni | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['testimonis'] = $this->testimoniModel->getTestimoni($id);

        return view('admin/testimoni/edit', $this->data);
    }

    public function update($id)
    {
        helper(['form']);
        $datalama = $this->testimoniModel->getTestimoni($this->request->getVar('id'));

        if ($datalama['namaBuyer'] == $this->request->getVar('namaBuyer')) {
            $rule_judul = 'required';
        } else {
            $rule_judul = 'required|is_unique[testimoni.namaBuyer]';
        }

        $rules = [
            'namaBuyer' => [
                'label' => 'Judul',
                'rules' => $rule_judul
            ],
            'pekerjaanBuyer' => [
                'label' => 'Pekerjaan',
                'rules' => 'required',
            ],
            'isiTestimoni' => [
                'label' => 'Isi',
                'rules' => 'required'
            ],
            'gambarBuyer' => [
                'label' => 'Gambar',
                'rules' => 'max_size[gambarBuyer,1024]|is_image[gambarBuyer]|mime_in[gambarBuyer,image/jpg,image/jpeg,image/png]',
            ]
        ];


        if ($this->validate($rules)) {

            $gambar = $this->request->getFile('gambarBuyer');
            $gambarlama = $this->request->getVar('gambarBuyerLama');


            // jika tidak ada file yang diupload
            if ($gambar->getError() == 4) {
                // gunakan nama file lama
                $namagambar = $gambarlama;
            } else {
                // buat nama gambar acak
                $namagambar = $gambar->getRandomName();
                // upload gambar baru
                $gambar->move('assets/img/testimoni/', $namagambar);

                // jika gambar bukan default maka hapus
                if ($gambarlama != 'default.jpg') {
                    // hapus gambar lama
                    unlink('assets/img/testimoni/' . $gambarlama);
                }
            }

            $this->testimoniModel->save([
                'id' => $id,
                'namaBuyer' => $this->request->getVar('namaBuyer'),
                'pekerjaanBuyer' => $this->request->getVar('pekerjaanBuyer'),
                'isiTestimoni' => $this->request->getVar('isiTestimoni'),
                'gambarBuyer' => $namagambar,
                'userId' => session()->get('id')
            ]);

            // buat session pesan
            session()->setFlashdata('pesan', 'Data berhasil diupdate!');

            return redirect()->to('/admin/testimoni');
        } else {

            $this->data = [
                'title' => 'Edit Buyer | PT. DELTA FOOD DISTRIBUSI'
            ];

            return redirect()->to('/admin/testimoni/edit/' . $this->request->getVar('id'))->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function delete($id)
    {
        //cari gambar berdasarkan id
        $gambar = $this->testimoniModel->find($id);


        // jika gambar bukan default maka hapus
        if ($gambar['gambarBuyer'] != 'default.jpg') {
            // hapus gambar
            unlink('assets/img/testimoni/' . $gambar['gambarBuyer']);
        }


        $this->testimoniModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus!');
        return redirect()->to('/admin/testimoni');
    }
}
