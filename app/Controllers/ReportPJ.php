<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class ReportPJ extends BaseController
{

    protected $data;
    // protected $server;
    // protected $server3;
    protected $server4;

    public function __construct()
    {

        // $this->session = session();
        // $uri = service('uri');
        // $this->server = $_ENV['APP_API'];
        // $this->server3 = $_ENV['APP_API3'];
        $this->server4 = $_ENV['APP_API4'];
    }

    public function index()
    {
        // helper dropdown
        helper(['dropdown']);

        $this->data['cb_report'] = getDropdownGetListReport2('PJ', 'report_file');
        return view('reportpj/index', $this->data);
    }


    /**
     * Mengambil daftar file .rpt yang tersedia menggunakan helper restclient
     */
    public function getAvailableReports()
    {
        helper(['restclient']);
        $url = "{$this->server4}/api/reports/list2";
        $result = akses_restapikey('GET', $url, [], []);
        $result = is_string($result) ? json_decode($result, true) : $result;
        return $this->response->setJSON($result);
    }

    /**
     * Metode POST: Cocok untuk dipanggil dari Form dengan target="_blank"
     */
    public function generateReport()
    {
        helper(['restclient']);
        $url = "{$this->server4}/api/reports/print-dynamic2";

        // Mengambil input dari POST (Form)
        $reportFile = "GL_Posting_Journal.rpt";
        $format     = strtolower($this->request->getPost('format'));
        $parameters = $this->request->getPost('params');

        // $body = [
        //     "ReportFile"   => $reportFile,
        //     "ReportGroup"  => "PJ",
        //     "ExportFormat" => $format,
        //     "Parameters"   => $parameters
        // ];
        
        // Jika params tidak ada atau bukan array, set default
        if (!is_array($parameters)) {
            $parameters = [];
        }

        // Ambil Year dan Period dari array params
        $year = isset($parameters['Year']) ? $parameters['Year'] : "2000";
        $period = isset($parameters['Period']) ? $parameters['Period'] : "01";

        // === PERBAIKAN UTAMA: Parameters harus object, bukan integer ===
        $body = [
            "ReportFile"   => $reportFile,
            "ReportGroup"  => "PJ",
            "ExportFormat" => $format,
            "Parameters"   => [  // <-- Ini harus ARRAY/OBJECT, bukan integer
                "Year"   => $year,
                "Period" => $period
            ]
        ];

        // Memanggil API .NET
        $result = akses_restapikey('POST', $url, $body, []);

        // Jika hasilnya adalah binary (bukan JSON error)
        if (!is_array(json_decode($result, true))) {
            // Tentukan Content-Type & ekstensi file berdasarkan format
            switch ($format) {
                case "pdf":
                    $contentType = "application/pdf";
                    $ext = "pdf";
                    break;
                case "excel":
                case "excelworkbook":
                    $contentType = "application/vnd.ms-excel";
                    $ext = "xls";
                    break;
                case "word":
                    $contentType = "application/msword";
                    $ext = "doc";
                    break;
                case "rtf":
                    $contentType = "application/rtf";
                    $ext = "rtf";
                    break;
                case "csv":
                    $contentType = "text/csv";
                    $ext = "csv";
                    break;
                case "xml":
                    $contentType = "application/xml";
                    $ext = "xml";
                    break;
                case "html":
                    $contentType = "text/html";
                    $ext = "html";
                    break;
                default:
                    $contentType = "application/pdf";
                    $ext = "pdf";
                    break;
            }

            return $this->response
                ->setHeader('Content-Type', $contentType)
                ->setHeader('Content-Disposition', 'inline; filename="' . pathinfo($reportFile, PATHINFO_FILENAME) . '_' . date('YmdHis') . '.' . $ext . '"')
                ->setBody($result);
        }

        // Jika gagal, kirim JavaScript untuk menutup tab
        return $this->response
            ->setHeader('Content-Type', 'text/html')
            ->setBody('<script>window.close();</script>');
    }
}
