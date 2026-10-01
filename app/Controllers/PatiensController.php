<?php

namespace App\Controllers;

use  App\Controllers\BaseController;

class PatiensController extends BaseController
{
    // ==========================================================
    // INDEX - Daftar / Pencarian Patient
    // ==========================================================
    public function index()
    {
        $nik  = $this->request->getGet('nik');
        $name = $this->request->getGet('name');
        $id   = $this->request->getGet('id');

        $patients = [];
        $error    = null;

        // Mode 1: GET by IHS Number
        if (!empty($id)) {
            $result = ss_api('GET', '/Patient/' . $id);
            if ($result['status'] === 200) {
                $patients[] = ['resource' => $result['body']];
            } else {
                $error = $result['error'] ?? $result['raw'];
            }
        }
        // Mode 2: Search by NIK
        elseif (!empty($nik)) {
            $result = ss_api('GET', '/Patient', [
                'identifier' => 'https://fhir.kemkes.go.id/id/nik|' . $nik,
            ]);
            $patients = $this->filterEntries($result);
            if (empty($patients) && $result['status'] !== 200) {
                $error = $result['error'] ?? $result['raw'];
            }
        }
        // Mode 3: Search by Name
        elseif (!empty($name)) {
            $result = ss_api('GET', '/Patient', [
                'name' => $name,
            ]);
            $patients = $this->filterEntries($result);
            if (empty($patients) && $result['status'] !== 200) {
                $error = $result['error'] ?? $result['raw'];
            }
        }
        // Default
        else {
            $error = 'Masukkan NIK, Nama, atau IHS Number untuk mencari pasien.';
        }

        return view('patiens/index', [
            'title'    => 'Daftar Pasien (Patient)',
            'nik'      => $nik,
            'name'     => $name,
            'id'       => $id,
            'patients' => $patients,
            'error'    => $error,
        ]);
    }

    private function filterEntries(array $result): array
    {
        $allEntries = $result['body']['entry'] ?? [];
        $validEntries = [];

        foreach ($allEntries as $entry) {
            $resourceType = $entry['resource']['resourceType'] ?? '';
            if ($resourceType === 'Patient') {
                $validEntries[] = $entry;
            }
        }

        return $validEntries;
    }

    // ==========================================================
    // CREATE - Form tambah Patient
    // ==========================================================
    public function create()
    {
        return view('patiens/form', [
            'title'   => 'Tambah Pasien Baru',
            'action'  => base_url('patiens/store'),
            'patient' => null,
        ]);
    }

    // ==========================================================
    // STORE - POST Patient
    // ==========================================================
    public function store()
    {
        // 1. AMBIL INPUT
        $nik            = trim((string) $this->request->getPost('nik'));
        $paspor         = trim((string) $this->request->getPost('paspor'));
        $kk             = trim((string) $this->request->getPost('kk'));
        $name           = trim((string) $this->request->getPost('name'));
        $gender         = trim((string) $this->request->getPost('gender')) ?: 'unknown';
        $birthDate      = trim((string) $this->request->getPost('birth_date'));
        $birthPlace     = trim((string) $this->request->getPost('birth_place'));
        $citizenship    = trim((string) $this->request->getPost('citizenship_status')) ?: 'WNI';
        $deceased       = $this->request->getPost('deceased_boolean') === '1';
        $multipleBirth  = (int) ($this->request->getPost('multiple_birth') ?? 0);

        $phone          = trim((string) $this->request->getPost('phone'));
        $homePhone      = trim((string) $this->request->getPost('home_phone'));
        $email          = trim((string) $this->request->getPost('email'));

        $addressLine    = trim((string) $this->request->getPost('address_line'));
        $city           = trim((string) $this->request->getPost('city'));
        $postalCode     = trim((string) $this->request->getPost('postal_code'));
        $country        = trim((string) $this->request->getPost('country')) ?: 'ID';
        $provinceCode   = trim((string) $this->request->getPost('province_code'));
        $cityCode       = trim((string) $this->request->getPost('city_code'));
        $districtCode   = trim((string) $this->request->getPost('district_code'));
        $villageCode    = trim((string) $this->request->getPost('village_code'));
        $rt             = trim((string) $this->request->getPost('rt'));
        $rw             = trim((string) $this->request->getPost('rw'));

        $maritalStatus  = trim((string) $this->request->getPost('marital_status'));

        // 2. VALIDASI
        $errors = [];
        if ($nik === '')          $errors[] = 'NIK wajib diisi.';
        if (strlen($nik) !== 16)  $errors[] = 'NIK harus 16 digit.';
        if ($name === '')         $errors[] = 'Nama wajib diisi.';
        if ($birthDate === '')    $errors[] = 'Tanggal lahir wajib diisi.';
        if ($birthPlace === '')   $errors[] = 'Tempat lahir wajib diisi.';
        if ($gender === 'unknown') $errors[] = 'Jenis kelamin wajib dipilih.';

        if (!empty($errors)) {
            session()->setFlashdata('error', implode(' ', $errors));
            return redirect()->back()->withInput();
        }

        // ==========================================================
        // 3. SUSUN PAYLOAD (SESUAI DOKUMENTASI SATUSEHAT)
        // ==========================================================
        $payload = [
            'resourceType' => 'Patient',
            'meta' => [
                'profile' => ['https://fhir.kemkes.go.id/r4/StructureDefinition/Patient']
            ],
            'identifier' => [
                [
                    'use'    => 'official',
                    'system' => 'https://fhir.kemkes.go.id/id/nik',
                    'value'  => $nik
                ]
            ],
            'active' => true,
            'name' => [
                ['use' => 'official', 'text' => $name]
            ],
            'gender'    => $gender,
            'birthDate' => $birthDate,
            'deceasedBoolean' => $deceased,
            'multipleBirthInteger' => $multipleBirth
        ];

        // Identifier tambahan
        if ($paspor !== '') {
            $payload['identifier'][] = [
                'use'    => 'official',
                'system' => 'https://fhir.kemkes.go.id/id/paspor',
                'value'  => $paspor
            ];
        }
        if ($kk !== '') {
            $payload['identifier'][] = [
                'use'    => 'official',
                'system' => 'https://fhir.kemkes.go.id/id/kk',
                'value'  => $kk
            ];
        }

        // Telecom
        $telecom = [];
        if ($phone !== '') {
            $telecom[] = ['system' => 'phone', 'value' => $phone, 'use' => 'mobile'];
        }
        if ($homePhone !== '') {
            $telecom[] = ['system' => 'phone', 'value' => $homePhone, 'use' => 'home'];
        }
        if ($email !== '') {
            $telecom[] = ['system' => 'email', 'value' => $email, 'use' => 'home'];
        }
        if (!empty($telecom)) {
            $payload['telecom'] = $telecom;
        }

        // Address dengan extension administrativeCode (HURUF KECIL!)
        if ($addressLine !== '' || $city !== '') {
            $address = [
                'use'     => 'home',
                'line'    => [$addressLine ?: '-'],
                'city'    => $city ?: '-',
                'country' => $country,
                'extension' => [
                    [
                        'url' => 'https://fhir.kemkes.go.id/r4/StructureDefinition/administrativeCode',
                        'extension' => [
                            ['url' => 'province', 'valueCode' => $provinceCode ?: '10'],
                            ['url' => 'city',     'valueCode' => $cityCode     ?: '1010'],
                            ['url' => 'district', 'valueCode' => $districtCode ?: '1010101'],
                            ['url' => 'village',  'valueCode' => $villageCode  ?: '1010101101'],
                            ['url' => 'rt',       'valueCode' => $rt           ?: '0'],
                            ['url' => 'rw',       'valueCode' => $rw           ?: '0']
                        ]
                    ]
                ]
            ];
            if ($postalCode !== '') {
                $address['postalCode'] = $postalCode;
            }
            $payload['address'] = [$address];
        }

        // Marital Status
        if ($maritalStatus !== '') {
            $payload['maritalStatus'] = [
                'coding' => [
                    [
                        'system'  => 'http://terminology.hl7.org/CodeSystem/v3-MaritalStatus',
                        'code'    => $maritalStatus,
                        'display' => $this->mapMaritalStatus($maritalStatus)
                    ]
                ],
                'text' => $this->mapMaritalStatus($maritalStatus)
            ];
        }

        // Extension: birthPlace + citizenshipStatus
        $extensions = [
            [
                'url' => 'https://fhir.kemkes.go.id/r4/StructureDefinition/birthPlace',
                'valueAddress' => [
                    'city'    => $birthPlace,
                    'country' => 'ID'
                ]
            ],
            [
                'url' => 'https://fhir.kemkes.go.id/r4/StructureDefinition/citizenshipStatus',
                'valueCode' => $citizenship
            ]
        ];
        $payload['extension'] = $extensions;

        // 4. LOG
        log_message('debug', '[SS] POST /Patient payload: '
            . json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        // 5. KIRIM
        try {
            $result = ss_api('POST', '/Patient', $payload);
        } catch (\Throwable $e) {
            session()->setFlashdata('error', 'Gagal terhubung: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }

        // 6. HANDLE
        if (in_array($result['status'], [200, 201])) {
            $newId = $result['body']['id'] ?? '-';
            session()->setFlashdata(
                'success',
                "✅ Patient berhasil dibuat!<br>" .
                    "IHS Number: <strong>{$newId}</strong><br>" .
                    "NIK: <strong>{$nik}</strong><br>" .
                    "<small>Simpan IHS Number di atas — dipakai untuk semua resource klinis.</small>"
            );
            return redirect()->to('/patiens?id=' . $newId);
        }

        session()->setFlashdata('error', $this->_parseError($result));
        return redirect()->back()->withInput();
    }

    // ==========================================================
    // EDIT - Preprocess dari SATUSEHAT
    // ==========================================================
    public function edit($id)
    {
        $result = ss_api('GET', '/Patient/' . $id);

        if ($result['status'] !== 200) {
            session()->setFlashdata('error', 'Patient tidak ditemukan.');
            return redirect()->to('/patiens');
        }

        $patient = $result['body'];

        // Preprocess
        $patient['nik']           = $this->getIdentifierValue($patient, 'https://fhir.kemkes.go.id/id/nik');
        $patient['paspor']        = $this->getIdentifierValue($patient, 'https://fhir.kemkes.go.id/id/paspor');
        $patient['kk']            = $this->getIdentifierValue($patient, 'https://fhir.kemkes.go.id/id/kk');
        $patient['name']          = $patient['name'][0]['text'] ?? '';
        $patient['gender']        = $patient['gender'] ?? 'unknown';
        $patient['birth_date']    = $patient['birthDate'] ?? '';
        $patient['birth_place']   = $this->getExtensionValue($patient, 'birthPlace', 'city');
        $patient['citizenship_status'] = $this->getExtensionValue($patient, 'citizenshipStatus');
        $patient['deceased_boolean']   = ($patient['deceasedBoolean'] ?? false) ? '1' : '0';
        $patient['multiple_birth']     = $patient['multipleBirthInteger'] ?? 0;

        $patient['phone']         = $this->getTelecomValue($patient, 'phone', 'mobile');
        $patient['home_phone']    = $this->getTelecomValue($patient, 'phone', 'home');
        $patient['email']         = $this->getTelecomValue($patient, 'email');

        $patient['address_line']  = $patient['address'][0]['line'][0] ?? '';
        $patient['city']          = $patient['address'][0]['city'] ?? '';
        $patient['postal_code']   = $patient['address'][0]['postalCode'] ?? '';
        $patient['country']       = $patient['address'][0]['country'] ?? 'ID';

        // Kode wilayah dari extension address
        $addrExt = $this->getAddressExtension($patient);
        $patient['province_code'] = $addrExt['province'] ?? '';
        $patient['city_code']     = $addrExt['city'] ?? '';
        $patient['district_code'] = $addrExt['district'] ?? '';
        $patient['village_code']  = $addrExt['village'] ?? '';
        $patient['rt']            = $addrExt['rt'] ?? '';
        $patient['rw']            = $addrExt['rw'] ?? '';

        $patient['marital_status'] = $patient['maritalStatus']['coding'][0]['code'] ?? '';

        return view('patiens/form', [
            'title'   => 'Edit Patient',
            'action'  => base_url('patiens/update/' . $id),
            'patient' => $patient,
        ]);
    }

    private function getIdentifierValue(array $patient, string $system): string
    {
        foreach ($patient['identifier'] ?? [] as $id) {
            if (($id['system'] ?? '') === $system) {
                return $id['value'] ?? '';
            }
        }
        return '';
    }

    private function getTelecomValue(array $patient, string $system, string $use = ''): string
    {
        foreach ($patient['telecom'] ?? [] as $t) {
            if (($t['system'] ?? '') === $system) {
                if ($use === '' || ($t['use'] ?? '') === $use) {
                    return $t['value'] ?? '';
                }
            }
        }
        return '';
    }

    private function getExtensionValue(array $patient, string $urlPart, string $subUrl = ''): string
    {
        foreach ($patient['extension'] ?? [] as $ext) {
            if (strpos($ext['url'] ?? '', $urlPart) !== false) {
                if ($subUrl !== '' && isset($ext['valueAddress'][$subUrl])) {
                    return $ext['valueAddress'][$subUrl];
                }
                return $ext['valueCode'] ?? '';
            }
        }
        return '';
    }

    private function getAddressExtension(array $patient): array
    {
        $result = [];
        $addressExt = $patient['address'][0]['extension'][0]['extension'] ?? [];
        foreach ($addressExt as $ext) {
            $result[$ext['url'] ?? ''] = $ext['valueCode'] ?? '';
        }
        return $result;
    }

    private function mapMaritalStatus(string $code): string
    {
        $map = [
            'S' => 'Never Married',
            'M' => 'Married',
            'D' => 'Divorced',
            'W' => 'Widowed',
            'U' => 'Unknown'
        ];
        return $map[$code] ?? 'Unknown';
    }

    // ==========================================================
    // UPDATE - PUT (NIK tidak bisa diubah)
    // ==========================================================
    public function update($id)
    {
        $getResult = ss_api('GET', '/Patient/' . $id);
        if ($getResult['status'] !== 200) {
            session()->setFlashdata('error', 'Patient tidak ditemukan.');
            return redirect()->to('/patiens');
        }

        $patient = $getResult['body'];

        // Ambil input
        $name       = trim((string) $this->request->getPost('name'));
        $gender     = trim((string) $this->request->getPost('gender'));
        $phone      = trim((string) $this->request->getPost('phone'));
        $email      = trim((string) $this->request->getPost('email'));
        $addressLine = trim((string) $this->request->getPost('address_line'));
        $city       = trim((string) $this->request->getPost('city'));
        $postalCode = trim((string) $this->request->getPost('postal_code'));

        if ($name !== '') {
            $patient['name'] = [['use' => 'official', 'text' => $name]];
        }
        if ($gender !== '') {
            $patient['gender'] = $gender;
        }

        if ($phone !== '' || $email !== '') {
            $telecom = [];
            if ($phone !== '') $telecom[] = ['system' => 'phone', 'value' => $phone, 'use' => 'mobile'];
            if ($email !== '') $telecom[] = ['system' => 'email', 'value' => $email];
            $patient['telecom'] = $telecom;
        }

        if ($addressLine !== '' || $city !== '') {
            if (!empty($patient['address'][0])) {
                $patient['address'][0]['line'] = [$addressLine];
                $patient['address'][0]['city'] = $city;
                if ($postalCode !== '') $patient['address'][0]['postalCode'] = $postalCode;
            }
        }

        unset($patient['meta']);

        $result = ss_api('PUT', '/Patient/' . $id, $patient);

        if ($result['status'] === 200) {
            session()->setFlashdata('success', '✅ Patient berhasil diupdate!');
        } else {
            session()->setFlashdata('error', $this->_parseError($result));
        }

        return redirect()->to('/patiens?id=' . $id);
    }

    // ==========================================================
    // DEBUG
    // ==========================================================
    public function debug($id)
    {
        $result = ss_api('GET', '/Patient/' . $id);
        return $this->response->setJSON($result);
    }

    // ==========================================================
    // HELPER
    // ==========================================================
    private function _parseError(array $result): string
    {
        $msg = 'Gagal memproses Patient. ';
        if (!empty($result['body']['issue'])) {
            $issues = [];
            foreach ($result['body']['issue'] as $issue) {
                $text = $issue['details']['text'] ?? ($issue['diagnostics'] ?? 'Unknown');
                $expr = !empty($issue['expression']) ? ' (' . implode(', ', $issue['expression']) . ')' : '';
                $issues[] = "• {$text}{$expr}";
            }
            $msg .= '<br>' . implode('<br>', $issues);
        } else {
            $msg .= 'HTTP ' . ($result['status'] ?? '?');
        }
        return $msg;
    }
}
