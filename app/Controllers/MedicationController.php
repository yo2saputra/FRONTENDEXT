<?php

namespace App\Controllers;

use  App\Controllers\BaseController;

class MedicationController extends BaseController
{
    // ==========================================================
    // INDEX - Daftar Medication
    // ==========================================================
    public function index()
    {
        // Catatan: SATUSEHAT tidak menyediakan endpoint search global untuk
        // Medication tanpa parameter. Kita akan menampilkan daftar obat
        // dari database lokal (jika ada) atau pesan kosong.
        // Untuk demo, kita hanya tampilkan view kosong dengan form pencarian manual.

        $data = [
            'title'     => 'Daftar Medication (Obat)',
            'medications' => [], // Kosong karena tidak ada endpoint search global
            'error'     => null,
            'info'      => 'Medication tidak dapat dicari secara global. Data obat ditampilkan setelah dibuat atau melalui integrasi dengan database lokal.'
        ];

        return view('medication/index', $data);
    }

    // ==========================================================
    // CREATE - Form tambah Medication
    // ==========================================================
    public function create()
    {
        return view('medication/form', [
            'title'     => 'Tambah Medication (Obat)',
            'action'    => base_url('medication/store'),
            'medication' => null,
        ]);
    }

    // ==========================================================
    // STORE - Simpan Medication baru (POST)
    // ==========================================================
    public function store()
    {
        // 1. AMBIL INPUT
        $localId        = trim((string) $this->request->getPost('local_id'));
        $kfaCode        = trim((string) $this->request->getPost('kfa_code'));
        $medicationName = trim((string) $this->request->getPost('medication_name'));
        $formCode       = trim((string) $this->request->getPost('form_code')) ?: 'BS023';
        $formDisplay    = trim((string) $this->request->getPost('form_display')) ?: 'Kaplet Salut Selaput';
        $status         = trim((string) $this->request->getPost('status')) ?: 'active';
        $manufacturerId = trim((string) $this->request->getPost('manufacturer_id'));
        $medicationType = trim((string) $this->request->getPost('medication_type')) ?: 'NC';

        // Ingredient (array dari form)
        $ingredientCodes    = $this->request->getPost('ingredient_code')    ?? [];
        $ingredientDisplays = $this->request->getPost('ingredient_display') ?? [];
        $ingredientStrengths = $this->request->getPost('ingredient_strength') ?? [];

        // ORG ID DARI .env
        $orgId = env('SATUSEHAT_ORG_ID') ?: '';

        // Bersihkan prefix
        // $manufacturerId = str_replace('Organization/', '', $manufacturerId);
        // $manufacturerId = str_replace('Organization/', '', $manufacturerId ?: $orgId);
        $manufacturerId = str_replace('Organization/', '', $orgId);

        // 2. VALIDASI
        $errors = [];
        if ($orgId === '')           $errors[] = 'SATUSEHAT_ORG_ID belum diisi di .env.';
        if ($kfaCode === '')         $errors[] = 'Kode KFA obat wajib diisi.';
        if ($medicationName === '')  $errors[] = 'Nama Obat wajib diisi.';
        if ($manufacturerId === '')  $errors[] = 'Manufacturer ID (produsen) wajib diisi.';

        if (!empty($errors)) {
            session()->setFlashdata('error', implode(' ', $errors));
            return redirect()->back()->withInput();
        }

        // 3. BUILD INGREDIENT ARRAY
        $ingredients = [];
        foreach ($ingredientCodes as $i => $code) {
            if (empty($code)) continue;

            $ingredients[] = [
                'itemCodeableConcept' => [
                    'coding' => [
                        [
                            'system'  => 'http://sys-ids.kemkes.go.id/kfa',
                            'code'    => $code,
                            'display' => $ingredientDisplays[$i] ?? 'Ingredient'
                        ]
                    ]
                ],
                'isActive' => true,
                'strength' => [
                    'numerator' => [
                        'value'  => (float) ($ingredientStrengths[$i] ?? 0),
                        'system' => 'http://unitsofmeasure.org',
                        'code'   => 'mg'
                    ],
                    'denominator' => [
                        'value'  => 1,
                        'system' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm',
                        'code'   => 'TAB'
                    ]
                ]
            ];
        }

        // 4. SUSUN PAYLOAD (SESUAI DOKUMENTASI)
        $payload = [
            'resourceType' => 'Medication',
            'meta' => [
                'profile' => [
                    'https://fhir.kemkes.go.id/r4/StructureDefinition/Medication'
                ]
            ],
            'identifier' => [
                [
                    'system' => 'http://sys-ids.kemkes.go.id/medication/' . $orgId,
                    'use'    => 'official',
                    'value'  => $localId ?: 'MED' . date('YmdHis')
                ]
            ],
            'code' => [
                'coding' => [
                    [
                        'system'  => 'http://sys-ids.kemkes.go.id/kfa',
                        'code'    => $kfaCode,
                        'display' => $medicationName
                    ]
                ]
            ],
            'status' => $status,
            'manufacturer' => [
                'reference' => 'Organization/' . $manufacturerId
            ],
            'form' => [
                'coding' => [
                    [
                        'system'  => 'http://terminology.kemkes.go.id/CodeSystem/medication-form',
                        'code'    => $formCode,
                        'display' => $formDisplay
                    ]
                ]
            ],
            'ingredient' => $ingredients,
            'extension' => [
                [
                    'url' => 'https://fhir.kemkes.go.id/r4/StructureDefinition/MedicationType',
                    'valueCodeableConcept' => [
                        'coding' => [
                            [
                                'system'  => 'http://terminology.kemkes.go.id/CodeSystem/medication-type',
                                'code'    => $medicationType,
                                'display' => $medicationType === 'NC' ? 'Non-compound' : 'Compound'
                            ]
                        ]
                    ]
                ]
            ]
        ];

        // 5. LOG
        log_message('debug', '[SS] POST /Medication payload: '
            . json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        // 6. KIRIM
        try {
            $result = ss_api('POST', '/Medication', $payload);
        } catch (\Throwable $e) {
            log_message('error', '[SS] Exception store Medication: ' . $e->getMessage());
            session()->setFlashdata('error', 'Gagal terhubung ke SATUSEHAT: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }

        // 7. HANDLE RESPONSE
        if (in_array($result['status'], [200, 201])) {
            $newId = $result['body']['id'] ?? '-';
            session()->setFlashdata(
                'success',
                "✅ Medication berhasil dibuat!<br>ID SATUSEHAT: <strong>{$newId}</strong>"
            );
            return redirect()->to('/medication');
        }

        session()->setFlashdata('error', $this->_parseError($result));
        return redirect()->back()->withInput();
    }

    // ==========================================================
    // EDIT - Form edit Medication
    // ==========================================================
    public function edit($id)
    {
        $result = ss_api('GET', '/Medication/' . $id);

        if ($result['status'] !== 200) {
            session()->setFlashdata('error', 'Medication tidak ditemukan.');
            return redirect()->to('/medication');
        }

        return view('medication/form', [
            'title'     => 'Edit Medication',
            'action'    => base_url('medication/update/' . $id),
            'medication' => $result['body'],
        ]);
    }

    // ==========================================================
    // UPDATE - PUT (update lengkap)
    // ==========================================================
    public function update($id)
    {
        $getResult = ss_api('GET', '/Medication/' . $id);
        if ($getResult['status'] !== 200) {
            session()->setFlashdata('error', 'Medication tidak ditemukan.');
            return redirect()->to('/medication');
        }

        $medication = $getResult['body'];

        // Ambil input
        $localId        = trim((string) $this->request->getPost('local_id'));
        $kfaCode        = trim((string) $this->request->getPost('kfa_code'));
        $medicationName = trim((string) $this->request->getPost('medication_name'));
        $formCode       = trim((string) $this->request->getPost('form_code'));
        $formDisplay    = trim((string) $this->request->getPost('form_display'));
        $status         = trim((string) $this->request->getPost('status')) ?: 'active';

        // Modifikasi
        if (!empty($medication['identifier'][0])) {
            $medication['identifier'][0]['value'] = $localId;
        }
        $medication['code']['coding'][0]['code'] = $kfaCode;
        $medication['code']['coding'][0]['display'] = $medicationName;
        $medication['status'] = $status;
        $medication['form']['coding'][0]['code'] = $formCode;
        $medication['form']['coding'][0]['display'] = $formDisplay;

        // Hapus meta (tidak boleh dikirim ulang saat PUT)
        unset($medication['meta']);

        try {
            $result = ss_api('PUT', '/Medication/' . $id, $medication);
        } catch (\Throwable $e) {
            session()->setFlashdata('error', 'Gagal: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }

        if ($result['status'] === 200) {
            session()->setFlashdata('success', '✅ Medication berhasil diupdate!');
        } else {
            session()->setFlashdata('error', $this->_parseError($result));
        }

        return redirect()->to('/medication');
    }

    // ==========================================================
    // DELETE - PATCH status ke 'inactive'
    // ==========================================================
    public function delete($id)
    {
        $payload = [
            [
                'op'    => 'replace',
                'path'  => '/status',
                'value' => 'inactive'
            ]
        ];

        $result = ss_api('PATCH', '/Medication/' . $id, $payload);

        if ($result['status'] === 200) {
            session()->setFlashdata('success', '✅ Medication ditandai inactive.');
        } else {
            session()->setFlashdata('error', $this->_parseError($result));
        }

        return redirect()->to('/medication');
    }

    // ==========================================================
    // DEBUG - lihat detail Medication
    // ==========================================================
    public function debug($id)
    {
        $result = ss_api('GET', '/Medication/' . $id);
        return $this->response->setJSON($result);
    }

    // ==========================================================
    // HELPER - parse error OperationOutcome
    // ==========================================================
    private function _parseError(array $result): string
    {
        $msg = 'Gagal memproses Medication. ';

        if (!empty($result['body']['issue'])) {
            $issues = [];
            foreach ($result['body']['issue'] as $issue) {
                $text = $issue['details']['text'] ?? ($issue['diagnostics'] ?? 'Unknown');
                $expr = !empty($issue['expression'])
                    ? ' (' . implode(', ', $issue['expression']) . ')'
                    : '';
                $issues[] = "• {$text}{$expr}";
            }
            $msg .= '<br>' . implode('<br>', $issues);
        } elseif (!empty($result['error'])) {
            $msg .= $result['error'];
        } else {
            $msg .= 'HTTP ' . ($result['status'] ?? '?');
        }

        return $msg;
    }

    public function testDoc()
    {
        if (ENVIRONMENT !== 'development') {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Forbidden']);
        }

        $orgId = ENV('SATUSEHAT_ORG_ID') ?: '';
        if (empty($orgId)) {
            return $this->response->setJSON(['error' => 'SATUSEHAT_ORG_ID belum diisi']);
        }

        // Payload PERSIS dari dokumentasi (hanya ganti {{Org_id}})
        $payload = [
            'resourceType' => 'Medication',
            'meta' => [
                'profile' => [
                    'https://fhir.kemkes.go.id/r4/StructureDefinition/Medication'
                ]
            ],
            'identifier' => [
                [
                    'system' => 'http://sys-ids.kemkes.go.id/medication/' . $orgId,
                    'use'    => 'official',
                    'value'  => '123456789'
                ]
            ],
            'code' => [
                'coding' => [
                    [
                        'system'  => 'http://sys-ids.kemkes.go.id/kfa',
                        'code'    => '93001019',
                        'display' => 'Obat Anti Tuberculosis / Rifampicin 150 mg / Isoniazid 75 mg / Pyrazinamide 400 mg / Ethambutol 275 mg Kaplet Salut Selaput (KIMIA FARMA)'
                    ]
                ]
            ],
            'status' => 'active',
            'manufacturer' => [
                'reference' => 'Organization/900001'
            ],
            'form' => [
                'coding' => [
                    [
                        'system'  => 'http://terminology.kemkes.go.id/CodeSystem/medication-form',
                        'code'    => 'BS023',
                        'display' => 'Kaplet Salut Selaput'
                    ]
                ]
            ],
            'ingredient' => [
                [
                    'itemCodeableConcept' => [
                        'coding' => [[
                            'system' => 'http://sys-ids.kemkes.go.id/kfa',
                            'code'   => '91000330',
                            'display' => 'Rifampin'
                        ]]
                    ],
                    'isActive' => true,
                    'strength' => [
                        'numerator'   => ['value' => 150, 'system' => 'http://unitsofmeasure.org', 'code' => 'mg'],
                        'denominator' => ['value' => 1, 'system' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'code' => 'TAB']
                    ]
                ],
                [
                    'itemCodeableConcept' => [
                        'coding' => [[
                            'system' => 'http://sys-ids.kemkes.go.id/kfa',
                            'code'   => '91000328',
                            'display' => 'Isoniazid'
                        ]]
                    ],
                    'isActive' => true,
                    'strength' => [
                        'numerator'   => ['value' => 75, 'system' => 'http://unitsofmeasure.org', 'code' => 'mg'],
                        'denominator' => ['value' => 1, 'system' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'code' => 'TAB']
                    ]
                ],
                [
                    'itemCodeableConcept' => [
                        'coding' => [[
                            'system' => 'http://sys-ids.kemkes.go.id/kfa',
                            'code'   => '91000329',
                            'display' => 'Pyrazinamide'
                        ]]
                    ],
                    'isActive' => true,
                    'strength' => [
                        'numerator'   => ['value' => 400, 'system' => 'http://unitsofmeasure.org', 'code' => 'mg'],
                        'denominator' => ['value' => 1, 'system' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'code' => 'TAB']
                    ]
                ],
                [
                    'itemCodeableConcept' => [
                        'coding' => [[
                            'system' => 'http://sys-ids.kemkes.go.id/kfa',
                            'code'   => '91000288',
                            'display' => 'Ethambutol'
                        ]]
                    ],
                    'isActive' => true,
                    'strength' => [
                        'numerator'   => ['value' => 275, 'system' => 'http://unitsofmeasure.org', 'code' => 'mg'],
                        'denominator' => ['value' => 1, 'system' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'code' => 'TAB']
                    ]
                ]
            ],
            'extension' => [
                [
                    'url' => 'https://fhir.kemkes.go.id/r4/StructureDefinition/MedicationType',
                    'valueCodeableConcept' => [
                        'coding' => [[
                            'system'  => 'http://terminology.kemkes.go.id/CodeSystem/medication-type',
                            'code'    => 'NC',
                            'display' => 'Non-compound'
                        ]]
                    ]
                ]
            ]
        ];

        $result = ss_api('POST', '/Medication', $payload);

        return $this->response->setJSON([
            'sent_payload' => $payload,
            'status_code'  => $result['status'],
            'response'     => $result['body'],
            'raw'          => $result['raw'],
        ]);
    }
}
