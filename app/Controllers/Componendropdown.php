<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Componendropdown extends BaseController
{

    // protected $data;
    protected $server1;
    protected $server2;
    protected $server3;
    protected $server4;
    protected $server5;
    // protected $client;

    public function __construct()
    {
        $this->session = session();
        // $uri = service('uri');
        $this->server1 = $_ENV['APP_API'];
        $this->server2 = $_ENV['APP_API2'];
        $this->server3 = $_ENV['APP_API3'];
        $this->server4 = $_ENV['APP_API4'];
        $this->server5 = $_ENV['APP_API5'];
    }

    public function customize(
        $uri,           // Jumlah segmen URI yang digunakan untuk menentukan endpoint API
        $key,           // Jumlah parameter kunci (key) yang digunakan untuk filter
        $uri1 = null,   // Segmen URI pertama (misalnya: 'dropdown')
        $uri2 = null,   // Segmen URI kedua (misalnya: 'subunit')
        $key1 = null,   // Nama parameter kunci pertama (misalnya: 'action')
        $val1 = null,   // Nilai parameter kunci pertama (misalnya: 'getall')
        $key2 = null,   // Nama parameter kunci kedua (misalnya: 'SubUnit_ID')
        $val2 = null    // Nilai parameter kunci kedua (misalnya: 'SU00001')
    ) {
        if ($uri == 1 && $key == 1) {
            // Proxy ke API eksternal dengan API key
            $url = "{$this->server5}/api/$uri1";
            $query = [
                $key1 => $val1
            ];
        } elseif ($uri == 1 && $key == 2) {
            $url = "{$this->server5}/api/{$uri1}";
            $query = [
                $key1 => $val1,
                $key2 => $val2
            ];
        } elseif ($uri == 2 && $key == 1) {
            $url = "{$this->server5}/api/{$uri1}/{$uri2}";
            $query = [
                $key1 => $val1
            ];
        } elseif ($uri == 2 && $key == 2) {
            $url = "{$this->server5}/api/{$uri1}/{$uri2}";
            $query = [
                $key1 => $val1,
                $key2 => $val2
            ];
        } else {
            // Default case jika tidak ada kondisi yang cocok
            return $this->response->setJSON(['error' => 'Invalid parameters']);
        }

        // client request
        $response = akses_restapikey('GET', $url, $body = [], $query);

        return $this->response->setJSON($response);
    }

    public function server1(
        $uri,           // Jumlah segmen URI yang digunakan untuk menentukan endpoint API
        $key,           // Jumlah parameter kunci (key) yang digunakan untuk filter
        $uri1 = null,   // Segmen URI pertama (misalnya: 'dropdown')
        $uri2 = null,   // Segmen URI kedua (misalnya: 'subunit')
        $key1 = null,   // Nama parameter kunci pertama (misalnya: 'action')
        $val1 = null,   // Nilai parameter kunci pertama (misalnya: 'getall')
        $key2 = null,   // Nama parameter kunci kedua (misalnya: 'SubUnit_ID')
        $val2 = null    // Nilai parameter kunci kedua (misalnya: 'SU00001')
    ) {
        if ($uri == 1 && $key == 1) {
            // Proxy ke API eksternal dengan API key
            $url = "{$this->server1}/api/$uri1";
            $query = [
                $key1 => $val1
            ];
        } elseif ($uri == 1 && $key == 2) {
            $url = "{$this->server1}/api/{$uri1}";
            $query = [
                $key1 => $val1,
                $key2 => $val2
            ];
        } elseif ($uri == 2 && $key == 1) {
            $url = "{$this->server1}/api/{$uri1}/{$uri2}";
            $query = [
                $key1 => $val1
            ];
        } elseif ($uri == 2 && $key == 2) {
            $url = "{$this->server1}/api/{$uri1}/{$uri2}";
            $query = [
                $key1 => $val1,
                $key2 => $val2
            ];
        } else {
            // Default case jika tidak ada kondisi yang cocok
            return $this->response->setJSON(['error' => 'Invalid parameters']);
        }

        // client request
        $response = akses_restapikey('GET', $url, $body = [], $query);

        return $this->response->setJSON($response);
    }

    public function server2(
        $uri,           // Jumlah segmen URI yang digunakan untuk menentukan endpoint API
        $key,           // Jumlah parameter kunci (key) yang digunakan untuk filter
        $uri1 = null,   // Segmen URI pertama (misalnya: 'dropdown')
        $uri2 = null,   // Segmen URI kedua (misalnya: 'subunit')
        $key1 = null,   // Nama parameter kunci pertama (misalnya: 'action')
        $val1 = null,   // Nilai parameter kunci pertama (misalnya: 'getall')
        $key2 = null,   // Nama parameter kunci kedua (misalnya: 'SubUnit_ID')
        $val2 = null    // Nilai parameter kunci kedua (misalnya: 'SU00001')
    ) {
        if ($uri == 1 && $key == 1) {
            // Proxy ke API eksternal dengan API key
            $url = "{$this->server2}/api/$uri1";
            $query = [
                $key1 => $val1
            ];
        } elseif ($uri == 1 && $key == 2) {
            $url = "{$this->server2}/api/{$uri1}";
            $query = [
                $key1 => $val1,
                $key2 => $val2
            ];
        } elseif ($uri == 2 && $key == 1) {
            $url = "{$this->server2}/api/{$uri1}/{$uri2}";
            $query = [
                $key1 => $val1
            ];
        } elseif ($uri == 2 && $key == 2) {
            $url = "{$this->server2}/api/{$uri1}/{$uri2}";
            $query = [
                $key1 => $val1,
                $key2 => $val2
            ];
        } else {
            // Default case jika tidak ada kondisi yang cocok
            return $this->response->setJSON(['error' => 'Invalid parameters']);
        }

        // client request
        $response = akses_restapikey('GET', $url, $body = [], $query);

        return $this->response->setJSON($response);
    }

    public function server3(
        $uri,           // Jumlah segmen URI yang digunakan untuk menentukan endpoint API
        $key,           // Jumlah parameter kunci (key) yang digunakan untuk filter
        $uri1 = null,   // Segmen URI pertama (misalnya: 'dropdown')
        $uri2 = null,   // Segmen URI kedua (misalnya: 'subunit')
        $key1 = null,   // Nama parameter kunci pertama (misalnya: 'action')
        $val1 = null,   // Nilai parameter kunci pertama (misalnya: 'getall')
        $key2 = null,   // Nama parameter kunci kedua (misalnya: 'SubUnit_ID')
        $val2 = null    // Nilai parameter kunci kedua (misalnya: 'SU00001')
    ) {
        if ($uri == 1 && $key == 1) {
            // Proxy ke API eksternal dengan API key
            $url = "{$this->server3}/api/$uri1";
            $query = [
                $key1 => $val1
            ];
        } elseif ($uri == 1 && $key == 2) {
            $url = "{$this->server3}/api/{$uri1}";
            $query = [
                $key1 => $val1,
                $key2 => $val2
            ];
        } elseif ($uri == 2 && $key == 1) {
            $url = "{$this->server3}/api/{$uri1}/{$uri2}";
            $query = [
                $key1 => $val1
            ];
        } elseif ($uri == 2 && $key == 2) {
            $url = "{$this->server3}/api/{$uri1}/{$uri2}";
            $query = [
                $key1 => $val1,
                $key2 => $val2
            ];
        } else {
            // Default case jika tidak ada kondisi yang cocok
            return $this->response->setJSON(['error' => 'Invalid parameters']);
        }

        // client request
        $response = akses_restapikey('GET', $url, $body = [], $query);

        return $this->response->setJSON($response);
    }

    public function server4(
        $uri,           // Jumlah segmen URI yang digunakan untuk menentukan endpoint API
        $key,           // Jumlah parameter kunci (key) yang digunakan untuk filter
        $uri1 = null,   // Segmen URI pertama (misalnya: 'dropdown')
        $uri2 = null,   // Segmen URI kedua (misalnya: 'subunit')
        $key1 = null,   // Nama parameter kunci pertama (misalnya: 'action')
        $val1 = null,   // Nilai parameter kunci pertama (misalnya: 'getall')
        $key2 = null,   // Nama parameter kunci kedua (misalnya: 'SubUnit_ID')
        $val2 = null    // Nilai parameter kunci kedua (misalnya: 'SU00001')
    ) {
        if ($uri == 1 && $key == 1) {
            // Proxy ke API eksternal dengan API key
            $url = "{$this->server4}/api/$uri1";
            $query = [
                $key1 => $val1
            ];
        } elseif ($uri == 1 && $key == 2) {
            $url = "{$this->server4}/api/{$uri1}";
            $query = [
                $key1 => $val1,
                $key2 => $val2
            ];
        } elseif ($uri == 2 && $key == 1) {
            $url = "{$this->server4}/api/{$uri1}/{$uri2}";
            $query = [
                $key1 => $val1
            ];
        } elseif ($uri == 2 && $key == 2) {
            $url = "{$this->server4}/api/{$uri1}/{$uri2}";
            $query = [
                $key1 => $val1,
                $key2 => $val2
            ];
        } else {
            // Default case jika tidak ada kondisi yang cocok
            return $this->response->setJSON(['error' => 'Invalid parameters']);
        }

        // client request
        $response = akses_restapikey('GET', $url, $body = [], $query);

        return $this->response->setJSON($response);
    }

    public function server5(
        $uri,           // Jumlah segmen URI yang digunakan untuk menentukan endpoint API
        $key,           // Jumlah parameter kunci (key) yang digunakan untuk filter
        $uri1 = null,   // Segmen URI pertama (misalnya: 'dropdown')
        $uri2 = null,   // Segmen URI kedua (misalnya: 'subunit')
        $key1 = null,   // Nama parameter kunci pertama (misalnya: 'action')
        $val1 = null,   // Nilai parameter kunci pertama (misalnya: 'getall')
        $key2 = null,   // Nama parameter kunci kedua (misalnya: 'SubUnit_ID')
        $val2 = null    // Nilai parameter kunci kedua (misalnya: 'SU00001')
    ) {
        if ($uri == 1 && $key == 1) {
            // Proxy ke API eksternal dengan API key
            $url = "{$this->server5}/api/dropdown/$uri1";
            $query = [
                $key1 => $val1
            ];
        } elseif ($uri == 1 && $key == 2) {
            $url = "{$this->server5}/api/dropdown/{$uri1}";
            $query = [
                $key1 => $val1,
                $key2 => $val2
            ];
        } elseif ($uri == 2 && $key == 1) {
            $url = "{$this->server5}/api/dropdown/{$uri1}/{$uri2}";
            $query = [
                $key1 => $val1
            ];
        } elseif ($uri == 2 && $key == 2) {
            $url = "{$this->server5}/api/dropdown/{$uri1}/{$uri2}";
            $query = [
                $key1 => $val1,
                $key2 => $val2
            ];
        } else {
            // Default case jika tidak ada kondisi yang cocok
            return $this->response->setJSON(['error' => 'Invalid parameters']);
        }

        // client request
        $response = akses_restapikey('GET', $url, $body = [], $query);

        return $this->response->setJSON($response);
    }
}
