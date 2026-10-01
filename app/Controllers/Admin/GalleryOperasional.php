<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Master\GalleryOperasionalModel;
use App\Models\Master\OperasionalModel;

class GalleryOperasional extends BaseController
{
    protected $galleryOperasionalModel;
    protected $operasionalModel;
    protected $data;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->galleryOperasionalModel = new GalleryOperasionalModel();
        $this->operasionalModel = new OperasionalModel();
    }

    public function index()
    {
        $this->data = [
            'title' => 'Gallery Operasional | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['galleryoperasionals'] = $this->galleryOperasionalModel->getGalleryOperasional();

        return view('admin/gallery_operasional/index', $this->data);
    }

    public function detail($id)
    {

        $this->data = [
            'title' => 'Detail Gallery | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['galleryoperasionals'] = $this->galleryOperasionalModel->where(['id' => $id])->first();

        if (empty($this->data['galleryoperasionals'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Id ' . $id . ' tidak ditemukan.');
        }

        return view('admin/gallery_operasional/detail', $this->data);
    }

    public function create()
    {
        helper(['form']);
        $this->data = [
            'title' => 'Create Gallery Operasional | PT. DELTA FOOD DISTRIBUSI'
        ];
        $this->data['operasionals'] = $this->operasionalModel->getOperasional();
        $this->data['validation'] = $this->validator;

        return view('admin/gallery_operasional/create', $this->data);
    }

    public function save()
    {
        helper(['form']);
        $rules = [
            'textGalleryOperasional' => [
                'label' => 'Text',
                'rules' => 'required'
            ],
            'gambarGalleryOperasional' => [
                'label' => 'Gambar',
                'rules' => 'max_size[gambarGalleryOperasional,1024]|is_image[gambarGalleryOperasional]|mime_in[gambarGalleryOperasional,image/jpg,image/jpeg,image/png]',
            ]
        ];

        if ($this->validate($rules)) {

            $gambar = $this->request->getFile('gambarGalleryOperasional');

            if ($gambar->getError() == 4) {
                $namagambar = 'default.jpg';
            } else {
                $namagambar = $gambar->getRandomName();
                $gambar->move('assets/img/galleryoperasional/', $namagambar);
            }

            $this->galleryOperasionalModel->save([
                'textGalleryOperasional' => $this->request->getVar('textGalleryOperasional'),
                'gambarGalleryOperasional' => $namagambar,
                'operasionalId' => $this->request->getVar('operasionalId'),
                'userId' => session()->get('id')
            ]);

            session()->setFlashdata('pesan', 'Data berhasil tambah!');

            return redirect()->to('/admin/galleryoperasional');
        } else {

            $this->data = [
                'title' => 'Create Gallery Operasional | PT. DELTA FOOD DISTRIBUSI'
            ];

            return redirect()->to('/admin/galleryoperasional/create')->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function edit($id)
    {
        helper(['form']);
        $this->data = [
            'title' => 'Edit Gallery Operasional | PT. DELTA FOOD DISTRIBUSI'
        ];
        $this->data['operasionals'] = $this->operasionalModel->getOperasional();
        $this->data['galleryoperasionals'] = $this->galleryOperasionalModel->getGalleryOperasional($id);

        return view('admin/gallery_operasional/edit', $this->data);
    }

    public function update($id)
    {
        helper(['form']);
        $datalama = $this->galleryOperasionalModel->getGalleryOperasional($this->request->getVar('id'));

        $rules = [
            'textGalleryOperasional' => [
                'label' => 'Text',
                'rules' => 'required'
            ],
            'gambarGalleryOperasional' => [
                'label' => 'Logo',
                'rules' => 'max_size[gambarGalleryOperasional,1024]|is_image[gambarGalleryOperasional]|mime_in[gambarGalleryOperasional,image/jpg,image/jpeg,image/png]',
            ]
        ];


        if ($this->validate($rules)) {

            $gambar = $this->request->getFile('gambarGalleryOperasional');
            $gambarlama = $this->request->getVar('gambarGalleryOperasionalLama');

            // jika tidak ada file yang diupload
            if ($gambar->getError() == 4) {
                // gunakan nama file lama
                $namagambar = $gambarlama;
            } else {
                // buat nama gambar acak
                $namagambar = $gambar->getRandomName();
                // upload gambar baru
                $gambar->move('assets/img/galleryoperasional/', $namagambar);

                // jika gambar bukan default maka hapus
                if ($gambarlama != 'default.jpg') {
                    // hapus gambar lama
                    unlink('assets/img/galleryoperasional/' . $gambarlama);
                }
            }

            $this->galleryOperasionalModel->save([
                'id' => $id,
                'textGalleryOperasional' => $this->request->getVar('textGalleryOperasional'),
                'gambarGalleryOperasional' => $namagambar,
                'operasionalId' => $this->request->getVar('operasionalId'),
                'userId' => session()->get('id')
            ]);

            // buat session pesan
            session()->setFlashdata('pesan', 'Data berhasil diupdate!');

            return redirect()->to('/admin/galleryoperasional');
        } else {

            $this->data = [
                'title' => 'Edit Gallery Operasional | PT. DELTA FOOD DISTRIBUSI'
            ];

            return redirect()->to('/admin/galleryoperasional/edit/' . $this->request->getVar('id'))->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function delete($id)
    {
        //cari gambar berdasarkan id
        $gambar = $this->galleryOperasionalModel->find($id);


        // jika gambar bukan default maka hapus
        if ($gambar['gambarGalleryOperasional'] != 'default.jpg') {
            // hapus gambar
            unlink('assets/img/galleryoperasional/' . $gambar['gambarGalleryOperasional']);
        }


        $this->galleryOperasionalModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus!');
        return redirect()->to('/admin/galleryoperasional');
    }
}
