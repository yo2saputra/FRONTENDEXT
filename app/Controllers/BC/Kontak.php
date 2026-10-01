<?php

namespace App\Controllers;

use App\Models\KontakModel;

class Kontak extends BaseController
{
    protected $data;
    protected $session;
    protected $kontakModel;

    public function __construct()
    {
        $this->kontakModel = new KontakModel();
        $this->data = [
            'template' => $this->getTemplateData()
        ];
    }

    public function index()
    {
        helper(['url', 'form']);
        $this->data['title'] = 'Kontak | PT. DELTA FOOD DISTRIBUSI';
        $this->data['kontak'] = $this->kontakModel->findAll();
        $this->data['validation'] = \Config\Services::validation();

        $this->client = \Config\Services::curlrequest();
        //Set metode request dan endpoint
        $response = $this->client->request('GET', 'https://test-api.jualinternet.com/kontak');
        //Ambil body dari response
        $content = $response->getBody();
        $data['respon_kontak'] = json_decode($content, true);
        $this->data['kontak_api'] = $data['respon_kontak']['kontak'][0];

        return view('kontak', $this->data);
    }

    public function sendEmail()
    {
        $this->data['title'] = 'Kontak | PT. DELTA FOOD DISTRIBUSI';
        $this->data['kontak'] = $this->kontakModel->findAll();

        // dd($this->data['kontak'][0]['email']);

        $this->client = \Config\Services::curlrequest();
        //Set metode request dan endpoint
        $response = $this->client->request('GET', 'https://test-api.jualinternet.com/kontak');
        //Ambil body dari response
        $content = $response->getBody();
        $data['respon_kontak'] = json_decode($content, true);
        $this->data['kontak_api'] = $data['respon_kontak']['kontak'][0];

        //validasi form input kontak
        if (!$this->validate([
            'email' => 'required|valid_email',
            'name' => 'required',
            'phone' => 'required',
            'subject' => 'required',
            'message' => 'required'
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->to('/kontak')->withInput()->with('validation', $validation);
        }

        $email = \Config\Services::email();

        $config['protocol'] = 'smtp'; // mail, sendmail, smtp
        $config['mailPath'] = '/usr/sbin/sendmail';
        $config['charset']  = 'utf-8'; // Character set (utf-8, iso-8859-1, etc.)
        $config['mailType'] = 'html'; // Type of mail, either 'text' or 'html'
        $config['wordWrap'] = true;
        $config['SMTPHost'] = 'deltafood.co.id';
        $config['SMTPUser'] = $this->data['kontak'][0]['email'];
        $config['SMTPPass'] = '4d1bfd12345!';
        $config['SMTPCrypto'] = 'ssl'; // SMTP Encryption. Either tls or ssl
        $config['SMTPPort'] = 465;
        $config['SMTPTimeout'] = 20; // Timeout (in seconds)
        $email->initialize($config);

        //post data form kontak
        $data['fromEmail'] = $this->request->getPost('email');
        $data['fromName'] = $this->request->getPost('name');
        $data['phone'] = $this->request->getPost('phone');
        $data['to'] = $this->data['kontak'][0]['email'];
        $data['subject'] = $this->request->getPost('subject');
        $data['message'] = $this->request->getPost('message');



        $email->setFrom($data['to'], $data['fromName']);
        $email->setTo($data['to']);
        // Gunakan template email HTML
        $template = view("email_template", $data);

        $email->setSubject("Website Contact Form:  " . $data['fromName']);
        $email->setMessage($template);

        if ($email->send()) {
            session()->setFlashdata('berhasil', 'berhasil terkirim!');
        } else {
            session()->setFlashdata('gagal', 'gagal terkirim!');
        }

        return view('kontak', $this->data);
    }
}
