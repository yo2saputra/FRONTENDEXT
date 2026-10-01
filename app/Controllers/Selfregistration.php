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
    }

    public function index()
    {
        $this->data['title'] = ' | ' . $_ENV['APP_TITLE'];

        return view('selfregistration/index', $this->data);
    }

    public function doupload()
    {
        helper('form');


        if ($this->request->isAJAX()) {
            $nobp = $this->request->getVar('nobp');

            $validation = \Config\Services::validation();

            if ($this->request->getPost('imagecam') == '') {
                $msg = ['error' => 'Silahkan klik ambil gambar...'];
            } else {

                //cek dulu fotonya
                // $cekdata = $this->mhs->find($nobp);
                // $fotolama = $cekdata['foto'];
                // if ($fotolama != NULL || $fotolama != "") {
                //     unlink($fotolama);
                // }


                $image = $this->request->getPost('imagecam');
                $image = str_replace('data:image/jpeg;base64,', '', $image);

                $image = base64_decode($image);
                // echo $image;
                $filename = $nobp . '.jpg';
                //$filename = 'yoyo' . '.jpg';
                file_put_contents(FCPATH . '/assets/img/foto/' . $filename, $image);

                // $updatedata = [
                //     'foto' => './assets/images/foto/' . $filename
                // ];

                // $this->mhs->update($nobp, $updatedata);
                $msg = [
                    'success' => 'Foto berhasil di upload menggunakan webcam'
                ];
            }


            echo json_encode($msg);
        }
    }
}
