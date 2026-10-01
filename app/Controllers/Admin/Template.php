<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Master\TemplateModel;

class Template extends BaseController
{
    protected $templateModel;
    protected $data;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->templateModel = new TemplateModel();
    }

    public function index()
    {
        $this->data = [
            'title' => 'Template | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['templates'] = $this->templateModel->getSetting();

        return view('admin/template/index', $this->data);
    }

    public function detail($id)
    {

        $this->data = [
            'title' => 'Detail Template | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['templates'] = $this->templateModel->where(['id' => $id])->first();

        if (empty($this->data['templates'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Id ' . $id . ' tidak ditemukan.');
        }

        return view('admin/template/detail', $this->data);
    }

    public function create()
    {
        helper(['form']);
        $this->data = [
            'title' => 'Create Template | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['validation'] = $this->validator;

        return view('admin/template/create', $this->data);
    }

    public function save()
    {
        helper(['form']);
        $rules = [
            'namaMitra' => [
                'label' => 'Nama',
                'rules' => 'required|is_unique[setting.namaMitra]'
            ],
            'keteranganMitra' => [
                'label' => 'Keterangan',
                'rules' => 'required'
            ],
            'logoMobile' => [
                'label' => 'Logo',
                'rules' => 'max_size[logoMobile,1024]|is_image[logoMobile]|mime_in[logoMobile,image/jpg,image/jpeg,image/png]',
            ]
        ];

        if ($this->validate($rules)) {

            $gambar = $this->request->getFile('logoMobile');

            if ($gambar->getError() == 4) {
                $namagambar = 'default.jpg';
            } else {
                $namagambar = $gambar->getRandomName();
                $gambar->move('assets/img/template/', $namagambar);
            }

            $this->templateModel->save([
                'logo' => $namagambar,
                'linkFacebook' => $this->request->getVar('linkFacebook'),
                'linkTwitter' => $this->request->getVar('linkTwitter'),
                'linkInstagram' => $this->request->getVar('linkInstagram'),
                'linkLinkedin' => $this->request->getVar('linkLinkedin'),
                'textCopyright' => $this->request->getVar('textCopyright'),
                'userId' => session()->get('id')
            ]);

            session()->setFlashdata('pesan', 'Data berhasil tambah!');

            return redirect()->to('/admin/template');
        } else {

            $this->data = [
                'title' => 'Create Setting | PT. DELTA FOOD DISTRIBUSI'
            ];

            return redirect()->to('/admin/template/create')->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function edit($id)
    {
        helper(['form']);
        $this->data = [
            'title' => 'Edit Template | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['templates'] = $this->templateModel->getSetting($id);

        return view('admin/template/edit', $this->data);
    }

    public function update($id)
    {
        helper(['form']);
        // $datalama = $this->templateModel->getSetting($this->request->getVar('id'));

        // if ($datalama['namaMitra'] == $this->request->getVar('namaMitra')) {
        //     $rule_judul = 'required';
        // } else {
        //     $rule_judul = 'required|is_unique[setting.namaMitra]';
        // }

        $rules = [
            'linkTwitter' => [
                'label' => 'Link Twitter',
                'rules' => 'required'
            ],
            'linkFacebook' => [
                'label' => 'Link Facebook',
                'rules' => 'required'
            ],
            'linkInstagram' => [
                'label' => 'Link Instagram',
                'rules' => 'required'
            ],
            'linkLinkedin' => [
                'label' => 'Link Linkedin',
                'rules' => 'required'
            ],
            'textCopyright' => [
                'label' => 'Text Copyright',
                'rules' => 'required'
            ],
            'favicon' => [
                'label' => 'Favicon',
                'rules' => 'max_size[favicon,1024]|is_image[favicon]|mime_in[favicon,image/jpg,image/jpeg,image/png]',
            ],
            'logo' => [
                'label' => 'Logo',
                'rules' => 'max_size[logo,1024]|is_image[logo]|mime_in[logo,image/jpg,image/jpeg,image/png]',
            ],
            'logoMobile' => [
                'label' => 'Logo Mobile',
                'rules' => 'max_size[logoMobile,1024]|is_image[logoMobile]|mime_in[logoMobile,image/jpg,image/jpeg,image/png]',
            ]
        ];


        if ($this->validate($rules)) {

            $gambar = $this->request->getFile('logo');
            $gambarlama = $this->request->getVar('logoLama');

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

            $gambar2 = $this->request->getFile('logoMobile');
            $gambar2lama = $this->request->getVar('logoMobileLama');

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

            $gambar3 = $this->request->getFile('favicon');
            $gambar3lama = $this->request->getVar('faviconLama');

            // jika tidak ada file yang diupload
            if ($gambar3->getError() == 4) {
                // gunakan nama file lama
                $namagambar3 = $gambar3lama;
            } else {
                // buat nama gambar acak
                $namagambar3 = $gambar3->getRandomName();
                // upload gambar baru
                $gambar3->move('assets/img/', $namagambar3);

                // jika gambar bukan default maka hapus
                if ($gambar3lama != 'default.jpg') {
                    // hapus gambar lama
                    unlink('assets/img/' . $gambar3lama);
                }
            }

            $this->templateModel->save([
                'id' => $id,
                'logo' => $namagambar,
                'logoMobile' => $namagambar2,
                'favicon' => $namagambar3,
                'linkFacebook' => $this->request->getVar('linkFacebook'),
                'linkTwitter' => $this->request->getVar('linkTwitter'),
                'linkInstagram' => $this->request->getVar('linkInstagram'),
                'linkLinkedin' => $this->request->getVar('linkLinkedin'),
                'textCopyright' => $this->request->getVar('textCopyright'),
                'color1' => $this->request->getVar('color1'),
                'color2' => $this->request->getVar('color2'),
                'color3' => $this->request->getVar('color3'),
                'color4' => $this->request->getVar('color4'),
                'color5' => $this->request->getVar('color5'),
                'color6' => $this->request->getVar('color6'),
                'color7' => $this->request->getVar('color7'),
                'color8' => $this->request->getVar('color8'),
                'color9' => $this->request->getVar('color9'),
                'color10' => $this->request->getVar('color10'),
                'color11' => $this->request->getVar('color11'),
                'color12' => $this->request->getVar('color12'),
                'color13' => $this->request->getVar('color13'),
                'color14' => $this->request->getVar('color14'),
                'color15' => $this->request->getVar('color15'),
                'color16' => $this->request->getVar('color16'),
                'color17' => $this->request->getVar('color17'),
                'color18' => $this->request->getVar('color18'),
                'color19' => $this->request->getVar('color19'),
                'color20' => $this->request->getVar('color20'),
                'color21' => $this->request->getVar('color21'),
                'color22' => $this->request->getVar('color22'),
                'userId' => session()->get('id')
            ]);

            // buat session pesan
            session()->setFlashdata('pesan', 'Data berhasil diupdate!');

            return redirect()->to('/admin/template');
        } else {

            $this->data = [
                'title' => 'Edit Template | PT. DELTA FOOD DISTRIBUSI'
            ];

            return redirect()->to('/admin/template/edit/' . $this->request->getVar('id'))->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function delete($id)
    {
        //cari gambar berdasarkan id
        $gambar = $this->templateModel->find($id);


        // jika gambar bukan default maka hapus
        if ($gambar['logoMobile'] != 'default.jpg') {
            // hapus gambar
            unlink('assets/img/template/' . $gambar['logoMobile']);
        }


        $this->templateModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus!');
        return redirect()->to('/admin/template');
    }
}
