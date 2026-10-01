<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Master\BlogModel;

class Blog extends BaseController
{
    protected $blogModel;
    protected $data;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->blogModel = new BlogModel();
    }

    public function index()
    {
        $this->data = [
            'title' => 'Blog | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['blogs'] = $this->blogModel->getBlog();

        return view('admin/blog/index', $this->data);
    }

    public function detail($slug)
    {

        $this->data = [
            'title' => 'Detail Blog | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['blogs'] = $this->blogModel->where(['slugBlog' => $slug])->first();

        if (empty($this->data['blogs'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul blog ' . $slug . ' tidak ditemukan.');
        }

        return view('admin/blog/detail', $this->data);
    }

    public function create()
    {
        helper(['form']);
        $this->data = [
            'title' => 'Create Blog | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['validation'] = $this->validator;

        return view('admin/blog/create', $this->data);
    }

    public function save()
    {
        helper(['form']);
        $rules = [
            'judulBlog' => [
                'label' => 'Judul',
                'rules' => 'required|is_unique[blog.judulBlog]',
            ],
            'isiBlog' => [
                'label' => 'Isi',
                'rules' => 'required',
            ],
            'gambarBlog' => [
                'label' => 'Gambar',
                'rules' => 'max_size[gambarBlog,1024]|is_image[gambarBlog]|mime_in[gambarBlog,image/jpg,image/jpeg,image/png]',
            ]
        ];

        if ($this->validate($rules)) {

            $gambar = $this->request->getFile('gambarBlog');

            if ($gambar->getError() == 4) {
                $namagambar = 'default.jpg';
            } else {
                $namagambar = $gambar->getRandomName();
                $gambar->move('assets/img/blog/', $namagambar);
            }


            $slug = url_title($this->request->getVar('judulBlog'), '-', true);

            $this->blogModel->save([
                'judulBlog' => $this->request->getVar('judulBlog'),
                'slugBlog' => $slug,
                'isiBlog' => $this->request->getVar('isiBlog'),
                'statusBlog' => $this->request->getPost('statusBlog'),
                'gambarBlog' => $namagambar,
                'userId' => session()->get('id')
            ]);

            session()->setFlashdata('pesan', 'Data berhasil tambah!');

            return redirect()->to('/admin/blog');
        } else {
            $this->data = [
                'title' => 'Create Blog | PT. DELTA FOOD DISTRIBUSI'
            ];

            return redirect()->to('/admin/blog/create')->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function edit($slug)
    {
        helper(['form']);
        $this->data = [
            'title' => 'Edit Blog | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['blogs'] = $this->blogModel->getBlog($slug);

        // if (empty($this->data['blogs'])) {
        //     throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul blog ' . $slug . ' tidak ditemukan.');
        // }

        return view('admin/blog/edit', $this->data);
    }

    public function update($id)
    {

        helper(['form']);
        $datalama = $this->blogModel->getBlog($this->request->getVar('slugBlog'));

        if ($datalama['judulBlog'] == $this->request->getVar('judulBlog')) {
            $rule_judul = 'required';
        } else {
            $rule_judul = 'required|is_unique[blog.judulBlog]';
        }

        $rules = [
            'judulBlog' => [
                'label' => 'Judul',
                'rules' => $rule_judul
            ],
            'isiBlog' => [
                'label' => 'Isi',
                'rules' => 'required'
            ],
            'gambarBlog' => [
                'label' => 'Gambar',
                'rules' => 'max_size[gambarBlog,1024]|is_image[gambarBlog]|mime_in[gambarBlog,image/jpg,image/jpeg,image/png]',
            ]
        ];

        if ($this->validate($rules)) {

            $gambar = $this->request->getFile('gambarBlog');
            $gambarlama = $this->request->getVar('gambarBlogLama');
            // dd($gambarlama);

            // jika tidak ada file yang diupload
            if ($gambar->getError() == 4) {
                // gunakan nama file lama
                $namagambar = $gambarlama;
            } else {
                // buat nama gambar acak
                $namagambar = $gambar->getRandomName();
                // upload gambar baru
                $gambar->move('assets/img/blog/', $namagambar);

                // jika gambar bukan default maka hapus
                if ($gambarlama != 'default.jpg') {
                    // hapus gambar lama
                    unlink('assets/img/blog/' . $gambarlama);
                }
            }
            // ganti space dengan stripe
            $slug = url_title($this->request->getVar('judulBlog'), '-', true);

            $this->blogModel->save([
                'id' => $id,
                'judulBlog' => $this->request->getVar('judulBlog'),
                'slugBlog' => $slug,
                'isiBlog' => $this->request->getVar('isiBlog'),
                'statusBlog' => $this->request->getVar('statusBlog'),
                'gambarBlog' => $namagambar,
                'userId' => session()->get('id')
            ]);

            // buat session pesan
            session()->setFlashdata('pesan', 'Data berhasil diupdate!');

            return redirect()->to('/admin/blog');
        } else {

            $this->data = [
                'title' => 'Edit Blog | PT. DELTA FOOD DISTRIBUSI'
            ];

            return redirect()->to('/admin/blog/edit/' . $this->request->getVar('slugBlog'))->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function delete($id)
    {
        //cari gambar berdasarkan id
        $gambar = $this->blogModel->find($id);


        // jika gambar bukan default maka hapus
        if ($gambar['gambarBlog'] != 'default.jpg') {
            // hapus gambar
            unlink('assets/img/blog/' . $gambar['gambarBlog']);
        }


        $this->blogModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus!');
        return redirect()->to('/admin/blog');
    }
}
