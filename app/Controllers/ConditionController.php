<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class ConditionController extends BaseController
{
    // ==========================================================
    // INDEX - Daftar Condition
    // ==========================================================
    public function index()
    {
        $patientId = $this->request->getGet('patient_id') ?? '100000030009';

        $result = ss_api('GET', '/Condition', [
            'subject' => $patientId,
        ]);

        $data = [
            'title'      => 'Daftar Condition (Diagnosis)',
            'patientId'  => $patientId,
            'conditions' => $result['body']['entry'] ?? [],
            'error'      => $result['status'] !== 200
                ? ($result['error'] ?? $result['raw'])
                : null,
        ];

        return view('condition/index', $data);
    }

    // ==========================================================
    // CREATE - Form tambah Condition
    // ==========================================================
    public function create()
    {
        // Prefill encounter_id kalau dikirim dari link
        $encounterId = $this->request->getGet('encounter_id') ?? '';

        return view('condition/form', [
            'title'     => 'Tambah Condition',
            'action'    => base_url('condition/store'),
            'condition' => ['encounter_id' => $encounterId],
        ]);
    }

    // ==========================================================
    // STORE - Simpan Condition baru (POST)
    // ==========================================================
    public function store()
    {
        // 1. AMBIL INPUT
        $patientId    = trim((string) $this->request->getPost('patient_id'));
        $patientName  = trim((string) $this->request->getPost('patient_name'));
        $encounterId  = trim((string) $this->request->getPost('encounter_id'));
        $icdCode      = trim((string) $this->request->getPost('icd_code'));
        $icdDisplay   = trim((string) $this->request->getPost('icd_display'));
        $category     = trim((string) $this->request->getPost('category')) ?: 'encounter-diagnosis';
        $clinical     = trim((string) $this->request->getPost('clinical_status')) ?: 'active';
        $onsetDate    = trim((string) $this->request->getPost('onset_date'));
        $note         = trim((string) $this->request->getPost('note'));

        // Bersihkan prefix
        $patientId   = str_replace('Patient/', '', $patientId);
        $encounterId = str_replace('Encounter/', '', $encounterId);

        // 2. VALIDASI
        $errors = [];
        if ($patientId === '')   $errors[] = 'Patient ID wajib diisi.';
        if ($encounterId === '') $errors[] = 'Encounter ID wajib diisi.';
        if ($icdCode === '')     $errors[] = 'Kode ICD-10 wajib diisi.';
        if ($icdDisplay === '')  $errors[] = 'Nama diagnosis wajib diisi.';

        if (!empty($errors)) {
            session()->setFlashdata('error', implode(' ', $errors));
            return redirect()->back()->withInput();
        }

        // 3. FORMAT WAKTU
        $onsetFormatted = $onsetDate !== ''
            ? date('Y-m-d\TH:i:s', strtotime($onsetDate)) . '+07:00'
            : null;

        // 4. SUSUN PAYLOAD (SESUAI STRUKTUR FHIR CONDITION)
        $payload = [
            'resourceType' => 'Condition',
            'clinicalStatus' => [
                'coding' => [
                    [
                        'system'  => 'http://terminology.hl7.org/CodeSystem/condition-clinical',
                        'code'    => $clinical,
                        'display' => ucfirst($clinical)
                    ]
                ]
            ],
            'verificationStatus' => [
                'coding' => [
                    [
                        'system'  => 'http://terminology.hl7.org/CodeSystem/condition-ver-status',
                        'code'    => 'confirmed',
                        'display' => 'Confirmed'
                    ]
                ]
            ],
            'category' => [
                [
                    'coding' => [
                        [
                            'system'  => 'http://terminology.hl7.org/CodeSystem/condition-category',
                            'code'    => $category,
                            'display' => $category === 'encounter-diagnosis'
                                ? 'Encounter Diagnosis'
                                : 'Problem List Item'
                        ]
                    ]
                ]
            ],
            'code' => [
                'coding' => [
                    [
                        'system'  => 'http://hl7.org/fhir/sid/icd-10',
                        'code'    => $icdCode,
                        'display' => $icdDisplay
                    ]
                ],
                'text' => $icdDisplay
            ],
            'subject' => [
                'reference' => 'Patient/' . $patientId,
                'display'   => $patientName ?: 'Pasien'
            ],
            'encounter' => [
                'reference' => 'Encounter/' . $encounterId
            ],
            'recordedDate' => date('Y-m-d\TH:i:s') . '+07:00'
        ];

        if ($onsetFormatted !== null) {
            $payload['onsetDateTime'] = $onsetFormatted;
        }

        if ($note !== '') {
            $payload['note'] = [
                ['text' => $note]
            ];
        }

        // 5. LOG PAYLOAD
        log_message('debug', '[SS] POST /Condition payload: '
            . json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        // 6. KIRIM
        try {
            $result = ss_api('POST', '/Condition', $payload);
        } catch (\Throwable $e) {
            log_message('error', '[SS] Exception store Condition: ' . $e->getMessage());
            session()->setFlashdata('error', 'Gagal terhubung ke SATUSEHAT: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }

        // 7. HANDLE RESPONSE
        if (in_array($result['status'], [200, 201])) {
            $newId = $result['body']['id'] ?? '-';
            session()->setFlashdata(
                'success',
                "✅ Condition berhasil dibuat!<br>ID SATUSEHAT: <strong>{$newId}</strong>"
            );
            return redirect()->to('/condition?patient_id=' . $patientId);
        }

        // Gagal → parse error
        $errorMsg = $this->_parseError($result);
        session()->setFlashdata('error', $errorMsg);
        return redirect()->back()->withInput();
    }

    // ==========================================================
    // EDIT - Form edit Condition
    // ==========================================================
    public function edit($id)
    {
        $result = ss_api('GET', '/Condition/' . $id);

        if ($result['status'] !== 200) {
            session()->setFlashdata('error', 'Condition tidak ditemukan.');
            return redirect()->to('/condition');
        }

        return view('condition/form', [
            'title'     => 'Edit Condition',
            'action'    => base_url('condition/update/' . $id),
            'condition' => $result['body'],
        ]);
    }

    // ==========================================================
    // UPDATE - PUT (update lengkap)
    // ==========================================================
    public function update($id)
    {
        // 1. Ambil data lama dulu (WAJIB untuk PUT)
        $getResult = ss_api('GET', '/Condition/' . $id);
        if ($getResult['status'] !== 200) {
            session()->setFlashdata('error', 'Condition tidak ditemukan.');
            return redirect()->to('/condition');
        }

        $condition = $getResult['body'];

        // 2. Ambil input
        $icdCode    = trim((string) $this->request->getPost('icd_code'));
        $icdDisplay = trim((string) $this->request->getPost('icd_display'));
        $clinical   = trim((string) $this->request->getPost('clinical_status')) ?: 'active';
        $onsetDate  = trim((string) $this->request->getPost('onset_date'));
        $note       = trim((string) $this->request->getPost('note'));

        // 3. Modifikasi data lama
        $condition['clinicalStatus']['coding'][0]['code']    = $clinical;
        $condition['clinicalStatus']['coding'][0]['display'] = ucfirst($clinical);

        $condition['code']['coding'][0]['code']    = $icdCode;
        $condition['code']['coding'][0]['display'] = $icdDisplay;
        $condition['code']['text'] = $icdDisplay;

        if ($onsetDate !== '') {
            $condition['onsetDateTime'] = date('Y-m-d\TH:i:s', strtotime($onsetDate)) . '+07:00';
        }

        if ($note !== '') {
            $condition['note'] = [['text' => $note]];
        }

        // 4. Hapus meta (tidak boleh dikirim ulang saat PUT)
        unset($condition['meta']);

        // 5. Kirim PUT
        try {
            $result = ss_api('PUT', '/Condition/' . $id, $condition);
        } catch (\Throwable $e) {
            session()->setFlashdata('error', 'Gagal: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }

        if ($result['status'] === 200) {
            session()->setFlashdata('success', '✅ Condition berhasil diupdate!');
        } else {
            session()->setFlashdata('error', $this->_parseError($result));
        }

        return redirect()->to('/condition');
    }

    // ==========================================================
    // DELETE - PATCH status ke 'resolved' (bukan DELETE asli)
    // ==========================================================
    public function delete($id)
    {
        $payload = [
            [
                'op'    => 'replace',
                'path'  => '/clinicalStatus/coding/0/code',
                'value' => 'resolved'
            ]
        ];

        $result = ss_api('PATCH', '/Condition/' . $id, $payload);

        if ($result['status'] === 200) {
            session()->setFlashdata('success', '✅ Condition ditandai resolved (sembuh).');
        } else {
            session()->setFlashdata('error', $this->_parseError($result));
        }

        return redirect()->to('/condition');
    }

    // ==========================================================
    // DEBUG - lihat detail Condition
    // ==========================================================
    public function debug($id)
    {
        $result = ss_api('GET', '/Condition/' . $id);
        return $this->response->setJSON($result);
    }

    // ==========================================================
    // HELPER - parse error OperationOutcome
    // ==========================================================
    private function _parseError(array $result): string
    {
        $msg = 'Gagal memproses Condition. ';

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

    /**
     * ==========================================================
     * TEST-DOC: Kirim payload persis sesuai dokumentasi SATUSEHAT
     * ==========================================================
     * HANYA untuk development. Jangan aktifkan di production.
     * ==========================================================
     */
    public function testDoc()
    {
        // Proteksi: hanya jalan di environment development
        if (ENVIRONMENT !== 'development') {
            return $this->response->setStatusCode(403)
                ->setJSON(['error' => 'Forbidden']);
        }

        // ==========================================================
        // PARAMETER — Ubah sesuai data test Anda
        // ==========================================================
        // Ganti nilai di bawah dengan data valid dari SATUSEHAT Sandbox Anda
        // ==========================================================
        $patientId   = $this->request->getGet('patient_id')   ?? '100000030009';
        $patientName = $this->request->getGet('patient_name') ?? 'Budi Santoso';
        $encounterId = $this->request->getGet('encounter_id') ?? 'GANTI_DENGAN_ENCOUNTER_ID';
        $icdCode     = $this->request->getGet('icd_code')     ?? 'A15.0';
        $icdDisplay  = $this->request->getGet('icd_display')  ?? 'Tuberculosis of lung';

        // ==========================================================
        // PAYLOAD — Persis sesuai dokumentasi SATUSEHAT
        // ==========================================================
        $payload = [
            'resourceType' => 'Condition',
            'clinicalStatus' => [
                'coding' => [
                    [
                        'system'  => 'http://terminology.hl7.org/CodeSystem/condition-clinical',
                        'code'    => 'active',
                        'display' => 'Active'
                    ]
                ]
            ],
            'verificationStatus' => [
                'coding' => [
                    [
                        'system'  => 'http://terminology.hl7.org/CodeSystem/condition-ver-status',
                        'code'    => 'confirmed',
                        'display' => 'Confirmed'
                    ]
                ]
            ],
            'category' => [
                [
                    'coding' => [
                        [
                            'system'  => 'http://terminology.hl7.org/CodeSystem/condition-category',
                            'code'    => 'encounter-diagnosis',
                            'display' => 'Encounter Diagnosis'
                        ]
                    ]
                ]
            ],
            'code' => [
                'coding' => [
                    [
                        'system'  => 'http://hl7.org/fhir/sid/icd-10',
                        'code'    => $icdCode,
                        'display' => $icdDisplay
                    ]
                ]
            ],
            'subject' => [
                'reference' => 'Patient/' . $patientId,
                'display'   => $patientName
            ],
            'encounter' => [
                'reference' => 'Encounter/' . $encounterId
            ],
            'onsetDateTime' => date('Y-m-d\TH:i:s') . '+07:00',
            'recordedDate'  => date('Y-m-d\TH:i:s') . '+07:00'
        ];

        // ==========================================================
        // LOG PAYLOAD
        // ==========================================================
        log_message('debug', '[SS] TEST-DOC POST /Condition payload: '
            . json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        // ==========================================================
        // KIRIM
        // ==========================================================
        try {
            $result = ss_api('POST', '/Condition', $payload);
        } catch (\Throwable $e) {
            return $this->response->setJSON([
                'status' => 0,
                'error'  => 'Exception: ' . $e->getMessage(),
            ]);
        }

        // ==========================================================
        // RESPONSE LENGKAP (untuk debugging)
        // ==========================================================
        return $this->response->setJSON([
            'sent_payload' => $payload,
            'status_code'  => $result['status'],
            'response'     => $result['body'],
            'raw'          => $result['raw'],
        ]);
    }

    /**
     * ==========================================================
     * TEST-GET: Lihat data Condition dari SATUSEHAT
     * ==========================================================
     * Mode:
     *   - ?id=xxx          → ambil 1 Condition by ID
     *   - ?patient_id=xxx  → cari semua Condition milik Patient
     *   - ?encounter_id=xxx→ cari semua Condition untuk Encounter
     * ==========================================================
     */
    public function testGet()
    {
        // Proteksi: hanya development
        if (ENVIRONMENT !== 'development') {
            return $this->response->setStatusCode(403)
                ->setJSON(['error' => 'Forbidden']);
        }

        // ==========================================================
        // 1. TENTUKAN MODE QUERY
        // ==========================================================
        $id          = $this->request->getGet('id');
        $patientId   = $this->request->getGet('patient_id');
        $encounterId = $this->request->getGet('encounter_id');

        // --- Mode 1: GET by Condition ID ---
        if (!empty($id)) {
            log_message('debug', '[SS] TEST-GET /Condition/' . $id);

            try {
                $result = ss_api('GET', '/Condition/' . $id);
            } catch (\Throwable $e) {
                return $this->response->setJSON([
                    'mode'  => 'by_id',
                    'error' => $e->getMessage(),
                ]);
            }

            return $this->response->setJSON([
                'mode'         => 'by_id',
                'condition_id' => $id,
                'status_code'  => $result['status'],
                'response'     => $result['body'],
                'raw'          => $result['raw'],
            ]);
        }

        // --- Mode 2: GET by Encounter ---
        if (!empty($encounterId)) {
            log_message('debug', '[SS] TEST-GET /Condition?encounter=' . $encounterId);

            try {
                $result = ss_api('GET', '/Condition', [
                    'encounter' => 'Encounter/' . $encounterId,
                ]);
            } catch (\Throwable $e) {
                return $this->response->setJSON([
                    'mode'  => 'by_encounter',
                    'error' => $e->getMessage(),
                ]);
            }

            return $this->response->setJSON([
                'mode'          => 'by_encounter',
                'encounter_id'  => $encounterId,
                'status_code'   => $result['status'],
                'total'         => $result['body']['total'] ?? 0,
                'response'      => $result['body'],
                'raw'           => $result['raw'],
            ]);
        }

        // --- Mode 3: GET by Patient (DEFAULT) ---
        if (empty($patientId)) {
            $patientId = '100000030009'; // default test patient
        }
        $patientId = str_replace('Patient/', '', $patientId);

        log_message('debug', '[SS] TEST-GET /Condition?subject=Patient/' . $patientId);

        try {
            $result = ss_api('GET', '/Condition', [
                'subject' => 'Patient/' . $patientId,
            ]);
        } catch (\Throwable $e) {
            return $this->response->setJSON([
                'mode'  => 'by_patient',
                'error' => $e->getMessage(),
            ]);
        }

        // ==========================================================
        // 2. RINGKASAN HASIL (biar mudah dibaca)
        // ==========================================================
        $entries = $result['body']['entry'] ?? [];
        $ringkasan = [];

        foreach ($entries as $entry) {
            $c = $entry['resource'] ?? [];
            $ringkasan[] = [
                'id'              => $c['id'] ?? '-',
                'icd_code'        => $c['code']['coding'][0]['code'] ?? '-',
                'icd_display'     => $c['code']['coding'][0]['display'] ?? '-',
                'clinical_status' => $c['clinicalStatus']['coding'][0]['code'] ?? '-',
                'onset'           => $c['onsetDateTime'] ?? '-',
                'encounter'       => $c['encounter']['reference'] ?? '-',
            ];
        }

        return $this->response->setJSON([
            'mode'          => 'by_patient',
            'patient_id'    => $patientId,
            'status_code'   => $result['status'],
            'total'         => $result['body']['total'] ?? 0,
            'ringkasan'     => $ringkasan,      // versi simple
            'response'      => $result['body'], // versi mentah
        ]);
    }

    public function testEncounter()
    {
        if (ENVIRONMENT !== 'development') {
            return $this->response->setStatusCode(403)
                ->setJSON(['error' => 'Forbidden']);
        }

        $patientId   = $this->request->getGet('patient_id') ?? '100000030009';
        $patientName = $this->request->getGet('patient_name') ?? 'Budi Santoso';

        $payload = [
            'resourceType' => 'Encounter',
            'status' => 'arrived', // atau 'in-progress' / 'finished'
            'class' => [
                'system'  => 'http://terminology.hl7.org/CodeSystem/v3-ActCode',
                'code'    => 'AMB',
                'display' => 'ambulatory'
            ],
            'subject' => [
                'reference' => 'Patient/' . $patientId,
                'display'   => $patientName
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
                        'reference' => 'Practitioner/N10000001', // ganti dgn practitioner valid
                    ]
                ]
            ],
            'period' => [
                'start' => date('Y-m-d\TH:i:s') . '+07:00'
            ],
            'location' => [
                [
                    'location' => [
                        'reference' => 'Location/' . 'GANTI_LOCATION_ID',
                    ]
                ]
            ],
            'statusHistory' => [
                [
                    'status' => 'arrived',
                    'period' => [
                        'start' => date('Y-m-d\TH:i:s') . '+07:00'
                    ]
                ]
            ],
            // identifier lokal agar mudah dicari kembali
            'identifier' => [
                [
                    'system' => 'http://sys-ids.kemkes.go.id/encounter/' . 'GANTI_ORG_ID',
                    'value'  => 'KUNJUNGAN-' . date('YmdHis')
                ]
            ]
        ];

        try {
            $result = ss_api('POST', '/Encounter', $payload);
        } catch (\Throwable $e) {
            return $this->response->setJSON([
                'status' => 0,
                'error'  => 'Exception: ' . $e->getMessage(),
            ]);
        }

        // 🔑 Ambil encounter_id dari response
        $body = json_decode($result['body'], true);
        $encounterId = $body['id'] ?? null;

        return $this->response->setJSON([
            'sent_payload' => $payload,
            'status_code'  => $result['status'],
            'encounter_id' => $encounterId,   // <-- ini yang Anda cari
            'response'     => $body,
        ]);
    }
}
