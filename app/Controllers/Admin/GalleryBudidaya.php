<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Master\GalleryBudidayaModel;
use App\Models\Master\BudidayaModel;

class GalleryBudidaya extends BaseController
{
    protected $galleryBudidayaModel;
    protected $budidayaModel;
    protected $data;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->galleryBudidayaModel = new GalleryBudidayaModel();
        $this->budidayaModel = new BudidayaModel();
    }

    public function index()
    {
        $this->data = [
            'title' => 'Gallery Budidaya | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['gallerybudidayas'] = $this->galleryBudidayaModel->getGalleryBudidaya();

        return view('admin/gallery_budidaya/index', $this->data);
    }

    public function detail($id)
    {

        $this->data = [
            'title' => 'Detail Gallery | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['gallerybudidayas'] = $this->galleryBudidayaModel->where(['id' => $id])->first();

        if (empty($this->data['gallerybudidayas'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Id ' . $id . ' tidak ditemukan.');
        }

        return view('admin/gallery_budidaya/detail', $this->data);
    }

    public function create()
    {
        helper(['form']);
        $this->data = [
            'title' => 'Create Gallery Budidaya | PT. DELTA FOOD DISTRIBUSI'
        ];
        $this->data['budidayas'] = $this->budidayaModel->getBudidaya();
        $this->data['validation'] = $this->validator;

        return view('admin/gallery_budidaya/create', $this->data);
    }

    public function save()
    {
        helper(['form']);
        $rules = [
            'textGalleryBudidaya' => [
                'label' => 'Text',
                'rules' => 'required'
            ],
            'gambarGalleryBudidaya' => [
                'label' => 'Gambar',
                'rules' => 'max_size[gambarGalleryBudidaya,1024]|is_image[gambarGalleryBudidaya]|mime_in[gambarGalleryBudidaya,image/jpg,image/jpeg,image/png]',
            ]
        ];

        if ($this->validate($rules)) {

            $gambar = $this->request->getFile('gambarGalleryBudidaya');

            if ($gambar->getError() == 4) {
                $namagambar = 'default.jpg';
            } else {
                $namagambar = $gambar->getRandomName();
                $gambar->move('assets/img/gallerybudidaya/', $namagambar);
            }

            $this->galleryBudidayaModel->save([
                'textGalleryBudidaya' => $this->request->getVar('textGalleryBudidaya'),
                'gambarGalleryBudidaya' => $namagambar,
                'budidayaId' => $this->request->getVar('budidayaId'),
                'userId' => session()->get('id')
            ]);

            session()->setFlashdata('pesan', 'Data berhasil tambah!');

            return redirect()->to('/admin/gallerybudidaya');
        } else {

            $this->data = [
                'title' => 'Create Gallery Budidaya | PT. DELTA FOOD DISTRIBUSI'
            ];

            return redirect()->to('/admin/gallerybudidaya/create')->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function edit($id)
    {
        helper(['form']);
        $this->data = [
            'title' => 'Edit Gallery Budidaya | PT. DELTA FOOD DISTRIBUSI'
        ];
        $this->data['budidayas'] = $this->budidayaModel->getBudidaya();
        $this->data['gallerybudidayas'] = $this->galleryBudidayaModel->getGalleryBudidaya($id);

        return view('admin/gallery_budidaya/edit', $this->data);
    }

    public function update($id)
    {
        helper(['form']);
        $datalama = $this->galleryBudidayaModel->getGalleryBudidaya($this->request->getVar('id'));

        $rules = [
            'textGalleryBudidaya' => [
                'label' => 'Text',
                'rules' => 'required'
            ],
            'gambarGalleryBudidaya' => [
                'label' => 'Logo',
                'rules' => 'max_size[gambarGalleryBudidaya,1024]|is_image[gambarGalleryBudidaya]|mime_in[gambarGalleryBudidaya,image/jpg,image/jpeg,image/png]',
            ]
        ];


        if ($this->validate($rules)) {

            $gambar = $this->request->getFile('gambarGalleryBudidaya');
            $gambarlama = $this->request->getVar('gambarGalleryBudidayaLama');

            // jika tidak ada file yang diupload
            if ($gambar->getError() == 4) {
                // gunakan nama file lama
                $namagambar = $gambarlama;
            } else {
                // buat nama gambar acak
                $namagambar = $gambar->getRandomName();
                // upload gambar baru
                $gambar->move('assets/img/gallerybudidaya/', $namagambar);

                // jika gambar bukan default maka hapus
                if ($gambarlama != 'default.jpg') {
                    // hapus gambar lama
                    unlink('assets/img/gallerybudidaya/' . $gambarlama);
                }
            }

            $this->galleryBudidayaModel->save([
                'id' => $id,
                'textGalleryBudidaya' => $this->request->getVar('textGalleryBudidaya'),
                'gambarGalleryBudidaya' => $namagambar,
                'budidayaId' => $this->request->getVar('budidayaId'),
                'userId' => session()->get('id')
            ]);

            // buat session pesan
            session()->setFlashdata('pesan', 'Data berhasil diupdate!');

            return redirect()->to('/admin/gallerybudidaya');
        } else {

            $this->data = [
                'title' => 'Edit Gallery Budidaya | PT. DELTA FOOD DISTRIBUSI'
            ];

            return redirect()->to('/admin/gallerybudidaya/edit/' . $this->request->getVar('id'))->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function delete($id)
    {
        //cari gambar berdasarkan id
        $gambar = $this->galleryBudidayaModel->find($id);


        // jika gambar bukan default maka hapus
        if ($gambar['gambarGalleryBudidaya'] != 'default.jpg') {
            // hapus gambar
            unlink('assets/img/gallerybudidaya/' . $gambar['gambarGalleryBudidaya']);
        }


        $this->galleryBudidayaModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus!');
        return redirect()->to('/admin/gallerybudidaya');
    }
}
