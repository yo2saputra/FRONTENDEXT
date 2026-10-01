<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class EncounterController extends BaseController
{
    // ==========================================================
    // INDEX - Daftar semua Encounter
    // ==========================================================
    public function index()
    {
        // Ambil semua encounter dari SATUSEHAT
        // (Untuk demo, kita ambil berdasarkan subject)
        $patientId = $this->request->getGet('patient_id') ?? '100000030009';

        $result = ss_api('GET', '/Encounter', [
            'subject' => $patientId
        ]);

        $data = [
            'title'     => 'Daftar Encounter',
            'patientId' => $patientId,
            'encounters' => $result['body']['entry'] ?? [],
            'error'     => $result['status'] !== 200 ? ($result['error'] ?? $result['raw']) : null,
        ];

        return view('encounter/index', $data);
    }

    // ==========================================================
    // CREATE - Form tambah Encounter
    // ==========================================================
    public function create()
    {
        return view('encounter/form', [
            'title'    => 'Tambah Encounter',
            'action'   => base_url('encounter/store'),
            'encounter' => null, // Kosong untuk create
        ]);
    }

    public function store()
    {
        // ==========================================================
        // 1. AMBIL INPUT DARI FORM
        // ==========================================================
        $patientId    = trim((string) $this->request->getPost('patient_id'));
        $patientName  = trim((string) $this->request->getPost('patient_name'));
        $practId      = trim((string) $this->request->getPost('practitioner_id'));
        $practName    = trim((string) $this->request->getPost('practitioner_name'));
        $orgId        = trim((string) $this->request->getPost('org_id'));
        $locId        = trim((string) $this->request->getPost('location_id'));
        $locName      = trim((string) $this->request->getPost('location_name'));
        $encValue     = trim((string) $this->request->getPost('encounter_value'));
        $startTime    = trim((string) $this->request->getPost('start_time'));
        $status       = trim((string) $this->request->getPost('status')) ?: 'arrived';

        // Bersihkan prefix kalau user tidak sengaja mengetik "Patient/xxx"
        $patientId = str_replace('Patient/', '', $patientId);
        $practId   = str_replace('Practitioner/', '', $practId);
        $orgId     = str_replace('Organization/', '', $orgId);
        $locId     = str_replace('Location/', '', $locId);

        // ==========================================================
        // 2. VALIDASI INPUT
        // ==========================================================
        $errors = [];

        if ($patientId === '')  $errors[] = 'Patient ID wajib diisi.';
        if ($practId === '')    $errors[] = 'Practitioner ID wajib diisi.';
        if ($orgId === '')      $errors[] = 'Organization ID wajib diisi.';
        if ($locId === '')      $errors[] = 'Location ID wajib diisi.';
        if ($startTime === '')  $errors[] = 'Waktu Mulai wajib diisi.';
        if ($encValue === '')   $errors[] = 'Nomor Encounter wajib diisi.';

        if (!empty($errors)) {
            session()->setFlashdata('error', implode(' ', $errors));
            return redirect()->back()->withInput();
        }

        // ==========================================================
        // 3. FORMAT WAKTU (+07:00 untuk WIB)
        // ==========================================================
        // Contoh output: 2024-09-21T09:30:00+07:00
        $startTimestamp = strtotime($startTime);
        $startFormatted = date('Y-m-d\TH:i:s', $startTimestamp) . '+07:00';

        // ==========================================================
        // 4. SUSUN PAYLOAD FHIR (SESUAI DOKUMENTASI SATUSEHAT)
        // ==========================================================
        // PENTING: Struktur nested array harus benar.
        // participant → array
        //   type → array
        //     coding → array
        //       object coding (system, code, display)
        // ==========================================================
        $payload = [
            'resourceType' => 'Encounter',
            'status'       => $status,
            'class'        => [
                'system'  => 'http://terminology.hl7.org/CodeSystem/v3-ActCode',
                'code'    => 'AMB',
                'display' => 'ambulatory'
            ],
            'subject'      => [
                'reference' => 'Patient/' . $patientId,
                'display'   => $patientName ?: 'Pasien'
            ],
            'participant'  => [
                [
                    'type' => [
                        [
                            'coding' => [
                                [
                                    'system'  => 'http://terminology.hl7.org/CodeSystem/v3-ParticipationType',
                                    'code'    => 'ATND',
                                    'display' => 'attender'
                                ]
                            ]
                        ]
                    ],
                    'individual' => [
                        'reference' => 'Practitioner/' . $practId,
                        'display'   => $practName ?: 'Dokter'
                    ]
                ]
            ],
            'period'       => [
                'start' => $startFormatted
            ],
            'location'     => [
                [
                    'location' => [
                        'reference' => 'Location/' . $locId,
                        'display'   => $locName ?: 'Ruang Periksa'
                    ]
                ]
            ],
            'statusHistory' => [
                [
                    'status' => $status,
                    'period' => [
                        'start' => $startFormatted
                    ]
                ]
            ],
            'serviceProvider' => [
                'reference' => 'Organization/' . $orgId
            ],
            'identifier'   => [
                [
                    'system' => 'http://sys-ids.kemkes.go.id/encounter/' . $orgId,
                    'value'  => $encValue
                ]
            ]
        ];

        // ==========================================================
        // 5. LOG PAYLOAD (untuk debugging)
        // ==========================================================
        log_message('debug', '[SS] POST /Encounter payload: '
            . json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        // ==========================================================
        // 6. KIRIM KE SATUSEHAT
        // ==========================================================
        try {
            $result = ss_api('POST', '/Encounter', $payload);
        } catch (\Throwable $e) {
            log_message('error', '[SS] Exception store: ' . $e->getMessage());
            session()->setFlashdata('error', 'Gagal terhubung ke SATUSEHAT: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }

        // ==========================================================
        // 7. HANDLE RESPONSE
        // ==========================================================
        $statusCode = $result['status'] ?? 0;

        // --- SUKSES ---
        if (in_array($statusCode, [200, 201])) {
            $newId       = $result['body']['id'] ?? '-';
            $identifier  = $result['body']['identifier'][0]['value'] ?? $encValue;

            // Simpan ID ke session untuk ditampilkan sekali
            session()->setFlashdata(
                'success',
                "✅ Encounter berhasil dibuat!<br>" .
                    "ID SATUSEHAT: <strong>{$newId}</strong><br>" .
                    "Nomor Encounter: <strong>{$identifier}</strong>"
            );

            // TODO: Simpan $newId ke database lokal untuk referensi
            // $this->saveToLocalDb($newId, $encValue, $patientId, $status);

            return redirect()->to('/encounter');
        }

        // --- GAGAL ---
        $errorMsg = 'Gagal membuat Encounter. ';

        if (!empty($result['body']['issue'])) {
            // Ambil pesan error dari OperationOutcome
            $issues = [];
            foreach ($result['body']['issue'] as $issue) {
                $text = $issue['details']['text'] ?? ($issue['diagnostics'] ?? 'Unknown error');
                $expr = !empty($issue['expression']) ? ' (' . implode(', ', $issue['expression']) . ')' : '';
                $issues[] = "• {$text}{$expr}";
            }
            $errorMsg .= '<br>' . implode('<br>', $issues);
        } elseif (!empty($result['error'])) {
            $errorMsg .= $result['error'];
        } else {
            $errorMsg .= 'HTTP ' . $statusCode . '. Response: ' . substr($result['raw'] ?? '', 0, 300);
        }

        log_message('error', '[SS] POST /Encounter gagal: ' . ($result['raw'] ?? 'no response'));

        session()->setFlashdata('error', $errorMsg);
        return redirect()->back()->withInput();
    }

    // ==========================================================
    // EDIT - Form edit Encounter
    // ==========================================================
    public function edit($id)
    {
        // Ambil data encounter by ID
        $result = ss_api('GET', '/Encounter/' . $id);

        if ($result['status'] !== 200) {
            session()->setFlashdata('error', 'Encounter tidak ditemukan.');
            return redirect()->to('/encounter');
        }

        return view('encounter/form', [
            'title'    => 'Edit Encounter',
            'action'   => base_url('encounter/update/' . $id),
            'encounter' => $result['body'],
        ]);
    }

    // ==========================================================
    // UPDATE - Simpan perubahan (PUT)
    // ==========================================================
    public function update($id)
    {
        // 1. AMBIL data Encounter yang ada dulu (WAJIB!)
        $getResult = ss_api('GET', '/Encounter/' . $id);

        if ($getResult['status'] !== 200) {
            session()->setFlashdata('error', 'Encounter tidak ditemukan.');
            return redirect()->to('/encounter');
        }

        $encounter = $getResult['body'];

        // 2. Ambil input dari form
        $patientId = $this->request->getPost('patient_id');
        $orgId     = $this->request->getPost('org_id');
        $startTime = $this->request->getPost('start_time');
        $endTime   = $this->request->getPost('end_time');
        $status    = $this->request->getPost('status') ?? 'finished';

        // 3. MODIFIKASI data yang ada
        $encounter['status'] = $status;
        $encounter['period'] = [
            'start' => gmdate('Y-m-d\TH:i:s\Z', strtotime($startTime)),
        ];
        if (!empty($endTime)) {
            $encounter['period']['end'] = gmdate('Y-m-d\TH:i:s\Z', strtotime($endTime));
        }
        $encounter['subject']['reference'] = 'Patient/' . $patientId;
        $encounter['serviceProvider']['reference'] = 'Organization/' . $orgId;

        // 4. Hapus meta (tidak boleh dikirim ulang)
        unset($encounter['meta']);

        // 5. PUT
        $result = ss_api('PUT', '/Encounter/' . $id, $encounter);

        if ($result['status'] === 200) {
            session()->setFlashdata('success', 'Encounter berhasil diupdate!');
        } else {
            session()->setFlashdata('error', 'Gagal update: ' . ($result['error'] ?? $result['raw']));
        }

        return redirect()->to('/encounter');
    }

    // ==========================================================
    // DELETE - Hapus Encounter (PATCH status ke 'cancelled')
    // ==========================================================
    // Catatan: FHIR tidak mengenal DELETE untuk data klinis.
    // Yang benar adalah PATCH status menjadi 'cancelled' atau
    // 'entered-in-error'. Ini contoh implementasi PATCH.
    // ==========================================================
    public function delete($id)
    {
        // PATCH: ganti status menjadi 'cancelled'
        $payload = [
            [
                'op'    => 'replace',
                'path'  => '/status',
                'value' => 'cancelled'
            ]
        ];

        $result = ss_api('PATCH', '/Encounter/' . $id, $payload);

        if ($result['status'] === 200) {
            session()->setFlashdata('success', 'Encounter dibatalkan (cancelled).');
        } else {
            session()->setFlashdata('error', 'Gagal membatalkan: ' . ($result['error'] ?? $result['raw']));
        }

        return redirect()->to('/encounter');
    }

    public function debug($id)
    {
        $result = ss_api('GET', '/Encounter/' . $id);

        if ($result['status'] !== 200) {
            return $this->response->setJSON(['error' => 'Not found']);
        }

        $enc = $result['body'];

        return $this->response->setJSON([
            'encounter_id'    => $enc['id'],
            'status'          => $enc['status'],
            'statusHistory'   => $enc['statusHistory'] ?? 'TIDAK ADA', // ← Cek ini
            'org_in_encounter' => $enc['serviceProvider']['reference'] ?? '-',
            'subject'         => $enc['subject']['reference'] ?? '-',
        ]);
    }

    public function testDoc()
    {
        // Payload PERSIS dari dokumentasi sandbox
        $payload = [
            'resourceType' => 'Encounter',
            'status'       => 'arrived',
            'class'        => [
                'system'  => 'http://terminology.hl7.org/CodeSystem/v3-ActCode',
                'code'    => 'AMB',
                'display' => 'ambulatory'
            ],
            'subject'      => [
                'reference' => 'Patient/100000030009',
                'display'   => 'Budi Santoso'
            ],
            'participant' => [
                [
                    'type' => [
                        [
                            'coding' => [
                                [
                                    'system'  => 'http://terminology.hl7.org/CodeSystem/v3-ParticipationType',
                                    'code'    => 'ATND',
                                    'display' => 'attender'
                                ]
                            ]
                        ]
                    ],
                    'individual' => [
                        'reference' => 'Practitioner/N10000001',
                        'display'   => 'Dokter Bronsig'
                    ]
                ]
            ],
            'period'       => [
                'start' => '2022-06-14T07:00:00+07:00'
            ],
            'location'     => [
                [
                    'location' => [
                        'reference' => 'Location/b017aa54-f1df-4ec2-9d84-8823815d7228',
                        'display'   => 'Ruang 1A, Poliklinik Bedah Rawat Jalan Terpadu, Lantai 2, Gedung G'
                    ]
                ]
            ],
            'statusHistory' => [
                [
                    'status' => 'arrived',
                    'period' => ['start' => '2022-06-14T07:00:00+07:00']
                ]
            ],
            'serviceProvider' => [
                'reference' => 'Organization/' . env('SATUSEHAT_ORG_ID', 'GANTI_DENGAN_ORG_UUID')
            ],
            'identifier'   => [
                [
                    'system' => 'http://sys-ids.kemkes.go.id/encounter/' . env('SATUSEHAT_ORG_ID', 'GANTI_DENGAN_ORG_UUID'),
                    'value'  => 'P20240001'
                ]
            ]
        ];

        $result = ss_api('POST', '/Encounter', $payload);
        return $this->response->setJSON($result);
    }
}
