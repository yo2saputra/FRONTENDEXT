<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class S3 extends BaseConfig
{
    // Ambil dari .env
    public $region = '';
    public $version = 'latest';
    public $bucket = '';
    public $endpoint = '';
    public $usePathStyleEndpoint = false;
    public $key = '';
    public $secret = '';

    public function __construct()
    {
        parent::__construct();

        // Load dari environment variables
        $this->region = env('S3_REGION', 'idn');
        $this->bucket = env('S3_BUCKET', '');
        $this->endpoint = env('S3_ENDPOINT', 'https://s3.biznetgio.com');
        $this->usePathStyleEndpoint = env('S3_USE_PATH_STYLE', false);

        // Credentials dari .env
        $this->key = env('S3_KEY', '');
        $this->secret = env('S3_SECRET', '');
    }
}
