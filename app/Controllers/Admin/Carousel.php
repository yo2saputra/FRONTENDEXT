<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Master\CarouselModel;

class Carousel extends BaseController
{
    protected $carouselModel;
    protected $data;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->carouselModel = new CarouselModel();
    }

    public function index()
    {
        $this->data = [
            'title' => 'Carousel | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['carousels'] = $this->carouselModel->getCarousel();

        return view('admin/carousel/index', $this->data);
    }

    public function detail($id)
    {

        $this->data = [
            'title' => 'Detail Carousel | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['carousels'] = $this->carouselModel->where(['id' => $id])->first();

        if (empty($this->data['carousels'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Id ' . $id . ' tidak ditemukan.');
        }

        return view('admin/carousel/detail', $this->data);
    }

    public function create()
    {
        helper(['form']);
        $this->data = [
            'title' => 'Create Carousel | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['validation'] = $this->validator;

        return view('admin/carousel/create', $this->data);
    }

    public function save()
    {
        helper(['form']);
        $rules = [
            'namaCarousel' => [
                'label' => 'Nama',
                'rules' => 'required|is_unique[carousel.namaCarousel]'
            ],
            'gambarCarousel' => [
                'label' => 'Logo',
                'rules' => 'max_size[gambarCarousel,1024]|is_image[gambarCarousel]|mime_in[gambarCarousel,image/jpg,image/jpeg,image/png]',
            ]
        ];

        if ($this->validate($rules)) {

            $gambar = $this->request->getFile('gambarCarousel');

            if ($gambar->getError() == 4) {
                $namagambar = 'default.jpg';
            } else {
                $namagambar = $gambar->getRandomName();
                $gambar->move('assets/img/carousel/', $namagambar);
            }

            $this->carouselModel->save([
                'namaCarousel' => $this->request->getVar('namaCarousel'),
                'gambarCarousel' => $namagambar,
                'userId' => session()->get('id')
            ]);

            session()->setFlashdata('pesan', 'Data berhasil tambah!');

            return redirect()->to('/admin/carousel');
        } else {

            $this->data = [
                'title' => 'Create Carousel | PT. DELTA FOOD DISTRIBUSI'
            ];

            return redirect()->to('/admin/carousel/create')->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function edit($id)
    {
        helper(['form']);
        $this->data = [
            'title' => 'Edit Carousel | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['carousels'] = $this->carouselModel->getCarousel($id);

        return view('admin/carousel/edit', $this->data);
    }

    public function update($id)
    {
        helper(['form']);
        $datalama = $this->carouselModel->getCarousel($this->request->getVar('id'));

        if ($datalama['namaCarousel'] == $this->request->getVar('namaCarousel')) {
            $rule_judul = 'required';
        } else {
            $rule_judul = 'required|is_unique[carousel.namaCarousel]';
        }

        $rules = [
            'namaCarousel' => [
                'label' => 'Judul',
                'rules' => $rule_judul
            ],
            'gambarCarousel' => [
                'label' => 'Logo',
                'rules' => 'max_size[gambarCarousel,1024]|is_image[gambarCarousel]|mime_in[gambarCarousel,image/jpg,image/jpeg,image/png]',
            ]
        ];


        if ($this->validate($rules)) {

            $gambar = $this->request->getFile('gambarCarousel');
            $gambarlama = $this->request->getVar('gambarCarouselLama');

            // jika tidak ada file yang diupload
            if ($gambar->getError() == 4) {
                // gunakan nama file lama
                $namagambar = $gambarlama;
            } else {
                // buat nama gambar acak
                $namagambar = $gambar->getRandomName();
                // upload gambar baru
                $gambar->move('assets/img/carousel/', $namagambar);

                // jika gambar bukan default maka hapus
                if ($gambarlama != 'default.jpg') {
                    // hapus gambar lama
                    unlink('assets/img/carousel/' . $gambarlama);
                }
            }

            $this->carouselModel->save([
                'id' => $id,
                'namaCarousel' => $this->request->getVar('namaCarousel'),
                'gambarCarousel' => $namagambar,
                'userId' => session()->get('id')
            ]);

            // buat session pesan
            session()->setFlashdata('pesan', 'Data berhasil diupdate!');

            return redirect()->to('/admin/carousel');
        } else {

            $this->data = [
                'title' => 'Edit Carousel | PT. DELTA FOOD DISTRIBUSI'
            ];

            return redirect()->to('/admin/carousel/edit/' . $this->request->getVar('id'))->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function delete($id)
    {
        //cari gambar berdasarkan id
        $gambar = $this->carouselModel->find($id);


        // jika gambar bukan default maka hapus
        if ($gambar['gambarCarousel'] != 'default.jpg') {
            // hapus gambar
            unlink('assets/img/carousel/' . $gambar['gambarCarousel']);
        }


        $this->carouselModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus!');
        return redirect()->to('/admin/carousel');
    }
}
