<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Master\IklanModel;

class Iklan extends BaseController
{
    protected $iklanModel;
    protected $data;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->iklanModel = new IklanModel();
    }

    public function index()
    {
        $this->data = [
            'title' => 'Iklan | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['iklans'] = $this->iklanModel->getIklan();

        return view('admin/iklan/index', $this->data);
    }

    public function detail($id)
    {

        $this->data = [
            'title' => 'Detail Iklan | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['iklans'] = $this->iklanModel->where(['id' => $id])->first();

        if (empty($this->data['iklans'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Id ' . $id . ' tidak ditemukan.');
        }

        return view('admin/iklan/detail', $this->data);
    }

    public function create()
    {
        helper(['form']);
        $this->data = [
            'title' => 'Create Iklan | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['validation'] = $this->validator;

        return view('admin/iklan/create', $this->data);
    }

    public function save()
    {
        helper(['form']);
        $rules = [
            'judulIklan' => [
                'label' => 'Judul',
                'rules' => 'required'
            ],
            'judulIklanWarna' => [
                'label' => 'Judul Warna',
                'rules' => 'required'
            ],
            'discIklan' => [
                'label' => 'Disc',
                'rules' => 'required'
            ],
            'gambarIklan' => [
                'label' => 'Gambar',
                'rules' => 'max_size[gambarIklan,1024]|is_image[gambarIklan]|mime_in[gambarIklan,image/jpg,image/jpeg,image/png]',
            ]
        ];

        if ($this->validate($rules)) {

            $gambar = $this->request->getFile('gambarIklan');

            if ($gambar->getError() == 4) {
                $namagambar = 'default.jpg';
            } else {
                $namagambar = $gambar->getRandomName();
                $gambar->move('assets/img/iklan/', $namagambar);
            }

            $this->iklanModel->save([
                'judulIklan' => $this->request->getVar('judulIklan'),
                'judulIklanWarna' => $this->request->getVar('judulIklanWarna'),
                'discIklan' => $this->request->getPost('discIklan'),
                'statusIklan' => 'Draft',
                'gambarIklan' => $namagambar,
                'userId' => session()->get('id')
            ]);

            session()->setFlashdata('pesan', 'Data berhasil tambah!');

            return redirect()->to('/admin/iklan');
        } else {

            $this->data = [
                'title' => 'Create Iklan | PT. DELTA FOOD DISTRIBUSI'
            ];
            return redirect()->to('/admin/iklan/create')->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function edit($id)
    {
        helper(['form']);
        $this->data = [
            'title' => 'Edit Iklan | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['iklans'] = $this->iklanModel->getIklan($id);
        return view('admin/iklan/edit', $this->data);
    }

    public function update($id)
    {
        helper(['form']);
        $datalama = $this->iklanModel->getIklan($this->request->getVar('id'));

        if ($datalama['judulIklan'] == $this->request->getVar('judulIklan')) {
            $rule_judul = 'required';
        } else {
            $rule_judul = 'required|is_unique[iklan.judulIklan]';
        }

        $rules = [
            'judulIklan' => [
                'label' => 'Judul',
                'rules' => 'required'
            ],
            'judulIklanWarna' => [
                'label' => 'Judul Warna',
                'rules' => 'required'
            ],
            'discIklan' => [
                'label' => 'Disc',
                'rules' => 'required'
            ],
            'gambarIklan' => [
                'label' => 'Logo',
                'rules' => 'max_size[gambarIklan,1024]|is_image[gambarIklan]|mime_in[gambarIklan,image/jpg,image/jpeg,image/png]',
            ]
        ];


        if ($this->validate($rules)) {

            $gambar = $this->request->getFile('gambarIklan');
            $gambarlama = $this->request->getVar('gambarIklanLama');

            // jika tidak ada file yang diupload
            if ($gambar->getError() == 4) {
                // gunakan nama file lama
                $namagambar = $gambarlama;
            } else {
                // buat nama gambar acak
                $namagambar = $gambar->getRandomName();
                // upload gambar baru
                $gambar->move('assets/img/iklan/', $namagambar);

                // jika gambar bukan default maka hapus
                if ($gambarlama != 'default.jpg') {
                    // hapus gambar lama
                    unlink('assets/img/iklan/' . $gambarlama);
                }
            }

            $this->iklanModel->transStart();
            $this->iklanModel->save([
                'id' => $id,
                'judulIklan' => $this->request->getVar('judulIklan'),
                'judulIklanWarna' => $this->request->getVar('judulIklanWarna'),
                'discIklan' => $this->request->getPost('discIklan'),
                'statusIklan' => $this->request->getPost('statusIklan'),
                'gambarIklan' => $namagambar,
                'userId' => session()->get('id')
            ]);
            $this->iklanModel->where('id !=', $id)->set(['statusIklan' => 'Draft'])->update();
            $this->iklanModel->transComplete();

            if ($this->iklanModel->transStatus() === true) {
                // buat session pesan
                session()->setFlashdata('pesan', 'Data berhasil diupdate!');
            }



            return redirect()->to('/admin/iklan');
        } else {

            $this->data = [
                'title' => 'Edit Iklan | PT. DELTA FOOD DISTRIBUSI'
            ];

            return redirect()->to('/admin/iklan/edit/' . $this->request->getVar('id'))->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function delete($id)
    {
        //cari gambar berdasarkan id
        $gambar = $this->iklanModel->find($id);

        // jika gambar bukan default maka hapus
        if ($gambar['gambarIklan'] != 'default.jpg') {
            // hapus gambar
            unlink('assets/img/iklan/' . $gambar['gambarIklan']);
        }


        $this->iklanModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus!');
        return redirect()->to('/admin/iklan');
    }
}
