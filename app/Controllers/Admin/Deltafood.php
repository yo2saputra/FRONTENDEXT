<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Master\DeltafoodModel;

class Deltafood extends BaseController
{
    protected $deltafoodModel;
    protected $data;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->session = session();
        $this->deltafoodModel = new DeltafoodModel();
    }

    public function index()
    {
        $this->data = [
            'title' => 'Delta Food | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['deltafoods'] = $this->deltafoodModel->getDeltafood();


        return view('admin/deltafood/index', $this->data);
    }

    public function detail($id)
    {

        $this->data = [
            'title' => 'Detail Delta Food | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['deltafoods'] = $this->deltafoodModel->where(['id' => $id])->first();

        if (empty($this->data['deltafoods'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Id ' . $id . ' tidak ditemukan.');
        }

        return view('admin/deltafood/detail', $this->data);
    }

    public function edit($id)
    {
        helper(['form']);
        $this->data = [
            'title' => 'Edit Delta Food | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['deltafoods'] = $this->deltafoodModel->getDeltafood($id);

        return view('admin/deltafood/edit', $this->data);
    }

    public function update($id)
    {
        helper(['form']);
        // $datalama = $this->deltafood->getDeltafood($this->request->getVar('id'));

        // if ($datalama['namaMitra'] == $this->request->getVar('namaMitra')) {
        //     $rule_judul = 'required';
        // } else {
        //     $rule_judul = 'required|is_unique[setting.namaMitra]';
        // }

        $rules = [
            'textDeltafood' => [
                'label' => 'Text ',
                'rules' => 'required'
            ],
            'linkVideoModulDeltafood' => [
                'label' => 'Link Video Modul Delta Food',
                'rules' => 'required'
            ],
            'judulDeltafood' => [
                'label' => 'Judul Delta Food',
                'rules' => 'required'
            ],
            'judulDeltafoodWarna' => [
                'label' => 'Judul Delta Food Warna',
                'rules' => 'required'
            ],
            'textModulDeltafood' => [
                'label' => 'Text Modul',
                'rules' => 'required'
            ],
            'judulModulDeltafood' => [
                'label' => 'Judul Modul Delta Food',
                'rules' => 'required'
            ],
            'judulModulDeltafoodWarna' => [
                'label' => 'Judul Modul Delta Food Warna',
                'rules' => 'required'
            ],
            'textFooterDeltafood' => [
                'label' => 'Text Footer',
                'rules' => 'required'
            ],
            'gambarDeltafood' => [
                'label' => 'Gambar',
                'rules' => 'max_size[gambarDeltafood,1024]|is_image[gambarDeltafood]|mime_in[gambarDeltafood,image/jpg,image/jpeg,image/png]',
            ],
            'gambarModulDeltafood' => [
                'label' => 'Gambar Modul',
                'rules' => 'max_size[gambarModulDeltafood,1024]|is_image[gambarModulDeltafood]|mime_in[gambarModulDeltafood,image/jpg,image/jpeg,image/png]',
            ]
        ];


        if ($this->validate($rules)) {

            $gambar = $this->request->getFile('gambarDeltafood');
            $gambarlama = $this->request->getVar('gambarDeltafoodLama');

            // jika tidak ada file yang diupload
            if ($gambar->getError() == 4) {
                // gunakan nama file lama
                $namagambar = $gambarlama;
            } else {
                // buat nama gambar acak
                $namagambar = $gambar->getRandomName();
                // upload gambar baru
                $gambar->move('assets/img/', $namagambar);

                // jika gambar bukan default maka hapus
                if ($gambarlama != 'default.jpg') {
                    // hapus gambar lama
                    unlink('assets/img/' . $gambarlama);
                }
            }

            $gambar2 = $this->request->getFile('gambarModulDeltafood');
            $gambar2lama = $this->request->getVar('gambarModulDeltafoodLama');

            // jika tidak ada file yang diupload
            if ($gambar2->getError() == 4) {
                // gunakan nama file lama
                $namagambar2 = $gambar2lama;
            } else {
                // buat nama gambar acak
                $namagambar2 = $gambar2->getRandomName();
                // upload gambar baru
                $gambar2->move('assets/img/', $namagambar2);

                // jika gambar bukan default maka hapus
                if ($gambar2lama != 'default.jpg') {
                    // hapus gambar lama
                    unlink('assets/img/' . $gambar2lama);
                }
            }

            $this->deltafoodModel->save([
                'id' => $id,
                'judulDeltafood' => $this->request->getVar('judulDeltafood'),
                'judulDeltafoodWarna' => $this->request->getVar('judulDeltafoodWarna'),
                'gambarDeltafood' => $namagambar,
                'textDeltafood' => $this->request->getVar('textDeltafood'),
                'linkVideoModulDeltafood' => $this->request->getVar('linkVideoModulDeltafood'),
                'judulModulDeltafood' => $this->request->getVar('judulModulDeltafood'),
                'judulModulDeltafoodWarna' => $this->request->getVar('judulModulDeltafoodWarna'),
                'gambarModulDeltafood' => $namagambar2,
                'textModulDeltafood' => $this->request->getVar('textModulDeltafood'),
                'textFooterDeltafood' => $this->request->getVar('textFooterDeltafood'),
                'userId' => session()->get('id')
            ]);

            // buat session pesan
            session()->setFlashdata('pesan', 'Data berhasil diupdate!');

            return redirect()->to('/admin/deltafood');
        } else {

            $this->data = [
                'title' => 'Edit Delta Food| PT. DELTA FOOD DISTRIBUSI'
            ];

            return redirect()->to('/admin/deltafood/edit/' . $this->request->getVar('id'))->withInput()->with('errors', $this->validator->getErrors());
        }
    }
}
