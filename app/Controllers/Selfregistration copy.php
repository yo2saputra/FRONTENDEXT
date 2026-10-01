<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Config\Services;
// use App\Libraries\Pdfgenerator;
// use CodeIgniter\I18n\Time;



class Selfregistration extends BaseController
{

    public function __construct()
    {
        $this->session = session();
        $this->server = $_ENV['APP_API'];

        //library CURLrequest
        // $this->client = service('curlrequest');

        $this->data = [
            'menu_header' => $this->apiMenuHeader(session()->get('usr_id')),
            'menu' => $this->apiMenu(session()->get('usr_id'))
        ];
    }

    public function index()
    {
        $this->data['title'] = 'Self Registration | ' . $_ENV['APP_TITLE'];

        return view('selfregistration/index', $this->data);
    }

    public function doupload()
    {
        helper('form');


        //if ($this->request->isAJAX()) {
        $nobp = $this->request->getVar('nobp');

        $validation = \Config\Services::validation();

        if ($_FILES['foto']['name'] == NULL && $this->request->getPost('imagecam') == '') {
            $msg = ['error' => 'Silahkan pilih salah satu ya...'];
        } elseif ($_FILES['foto']['name'] == NULL) {

            //cek dulu fotonya
            // $cekdata = $this->mhs->find($nobp);
            // $fotolama = $cekdata['foto'];
            // if ($fotolama != NULL || $fotolama != "") {
            //     unlink($fotolama);
            // }


            $image = $this->request->getPost('imagecam');
            $image = str_replace('data:image/jpeg;base64,', '', $image);

            $image = base64_decode($image = '', true);
            // echo $image;
            $filename = $nobp . '.jpg';
            //$filename = 'yoyo' . '.jpg';
            file_put_contents(FCPATH . '/assets/img/foto/' . $filename, $image);

            // $updatedata = [
            //     'foto' => './assets/images/foto/' . $filename
            // ];

            // $this->mhs->update($nobp, $updatedata);
            $msg = [
                'sukses' => 'Foto berhasil di upload menggunakan webcam'
            ];
        } else {

            $valid = $this->validate([
                'foto' => [
                    'label' => 'Upload Foto',
                    'rules' => 'uploaded[foto]|mime_in[foto,image/png,image/jpg,image/jpeg]|is_image[foto]',
                    'errors' => [
                        'uploaded' => '{field} wajib diisi',
                        'mime_in' => 'Harus dalam bentuk gambar, jangan file yang lain'
                    ]
                ]
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'foto' => $validation->getError('foto')
                    ]
                ];
            } else {

                //cek dulu fotonya
                // $cekdata = $this->mhs->find($nobp);
                // $fotolama = $cekdata['foto'];
                // if ($fotolama != NULL || $fotolama != "") {
                //     unlink($fotolama);
                // }


                $filefoto = $this->request->getFile('foto');

                $filefoto->move('assets/img/foto', $nobp . '.' . $filefoto->getExtension());

                $updatedata = [
                    'foto' => './assets/img/foto/' . $filefoto->getName()
                ];

                //$this->mhs->update($nobp, $updatedata);

                $msg = [
                    'sukses' => 'Berhasil diupload'
                ];
            }
        }

        echo json_encode($msg);
        //}
    }
}
