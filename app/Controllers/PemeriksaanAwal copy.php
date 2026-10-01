<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;
use CodeIgniter\I18n\Time;



class PemeriksaanAwal extends BaseController
{

    protected $data;
    protected $server;
    protected $client;

    public function __construct()
    {
        $this->session = session();
        $uri = service('uri');
        $this->server = $_ENV['APP_API'];

        //set flag session
        $this->apiMenuFlag($this->apiMenuMenucd($uri->getSegment(1))[0]['menu_cd'], session()->get('role_cd'));

        $this->data = [
            'menu_header' => $this->apiMenuHeader(session()->get('usr_id')),
            'menu' => $this->apiMenu(session()->get('usr_id'))
        ];
    }

    public function index()
    {
        return view('patient/index', $this->data);
    }

    function fetchAllDataPrint()
    {
        // helper curl request
        helper(['restclient']);
        // end point
        $url = "$this->server/pasien/getby/23090001";
        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);

        $pdf_data = $data['response_data'];
        $pdf_name = 'Single Data Patient';
        $pdf_title = 'Data Patient';
        $pdf_paper = 'A4';
        $pdf_orientation = 'portrait';
        $pdf_format = 'rpt_checklist_verifikasi_pdf';

        $this->view_pdf($pdf_name, $pdf_title, $pdf_data, $pdf_paper, $pdf_orientation, $pdf_format);
    }


    public function view_pdf($pdf_name, $pdf_title, $pdf_data, $pdf_paper, $pdf_orientation, $pdf_format)
    {

        $Pdfgenerator = new Pdfgenerator();

        // filename dari pdf ketika didownload
        $file_pdf = $pdf_name;

        // title dari pdf
        $this->data['title_pdf'] = $pdf_title;

        //data
        $this->data['produk'] = $pdf_data;

        // setting paper
        $paper = $pdf_paper;

        //orientasi paper potrait / landscape
        $orientation = $pdf_orientation;

        $html = view($pdf_format, $this->data);

        // run dompdf
        $Pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
    }
}
