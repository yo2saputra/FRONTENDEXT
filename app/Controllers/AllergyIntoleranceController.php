<?php

namespace App\Controllers;

use  App\Controllers\BaseController;

class AllergyIntoleranceController extends BaseController
{
    // ==========================================================
    // INDEX - Daftar AllergyIntolerance (by patient)
    // ==========================================================
    public function index()
    {
        $patientId = $this->request->getGet('patient_id') ?? '100000030009';
        $patientId = str_replace('Patient/', '', $patientId);

        $result = ss_api('GET', '/AllergyIntolerance', [
            'patient' => 'Patient/' . $patientId,
        ]);

        $allEntries = $result['body']['entry'] ?? [];
        $validEntries = [];
        $suppressedCount = 0;

        foreach ($allEntries as $entry) {
            $resourceType = $entry['resource']['resourceType'] ?? '';
            if ($resourceType === 'AllergyIntolerance') {
                $validEntries[] = $entry;
            } elseif ($resourceType === 'OperationOutcome') {
                $suppressedCount++;
            }
        }

        $data = [
            'title'           => 'Daftar Riwayat Alergi (AllergyIntolerance)',
            'patientId'       => $patientId,
            'allergies'       => $validEntries,
            'suppressedCount' => $suppressedCount,
            'total'           => $result['body']['total'] ?? 0,
            'error'           => $result['status'] !== 200
                ? ($result['error'] ?? $result['raw'])
                : null,
        ];

        return view('allergy_intolerance/index', $data);
    }

    // ==========================================================
    // CREATE - Form tambah AllergyIntolerance
    // ==========================================================
    public function create()
    {
        return view('allergy_intolerance/form', [
            'title'   => 'Tambah Riwayat Alergi (AllergyIntolerance)',
            'action'  => base_url('allergy-intolerance/store'),
            'allergy' => null,
        ]);
    }

    // ==========================================================
    // STORE - POST AllergyIntolerance
    // ==========================================================
    public function store()
    {
        // 1. AMBIL INPUT
        $patientId       = trim((string) $this->request->getPost('patient_id'));
        $patientName     = trim((string) $this->request->getPost('patient_name'));
        $encounterId     = trim((string) $this->request->getPost('encounter_id'));
        $practitionerId  = trim((string) $this->request->getPost('practitioner_id'));
        $practitionerName = trim((string) $this->request->getPost('practitioner_name'));
        $allergenCode    = trim((string) $this->request->getPost('allergen_code'));
        $allergenDisplay = trim((string) $this->request->getPost('allergen_display'));
        $allergenText    = trim((string) $this->request->getPost('allergen_text'));
        $category        = trim((string) $this->request->getPost('category')) ?: 'medication';
        $clinicalStatus  = trim((string) $this->request->getPost('clinical_status')) ?: 'active';
        $localId         = trim((string) $this->request->getPost('local_id'));

        $orgId = ENV('SATUSEHAT_ORG_ID') ?: '';

        // Bersihkan prefix
        $patientId      = str_replace('Patient/', '', $patientId);
        $encounterId    = str_replace('Encounter/', '', $encounterId);
        $practitionerId = str_replace('Practitioner/', '', $practitionerId);

        // Auto-generate ID lokal
        if ($localId === '') {
            $localId = 'ALG' . date('YmdHis');
        }

        // 2. VALIDASI
        $errors = [];
        if ($patientId === '')       $errors[] = 'Patient ID wajib diisi.';
        if ($orgId === '')           $errors[] = 'SATUSEHAT_ORG_ID belum diisi di .env.';
        if ($allergenCode === '')    $errors[] = 'Kode alergen wajib diisi.';
        if ($allergenDisplay === '') $errors[] = 'Nama alergen wajib diisi.';

        if (!empty($errors)) {
            session()->setFlashdata('error', implode(' ', $errors));
            return redirect()->back()->withInput();
        }

        // 3. FORMAT WAKTU (UTC +00)
        $recordedDate = gmdate('Y-m-d\TH:i:s') . '+00:00';

        // ==========================================================
        // 4. TENTUKAN SISTEM KODE BERDASARKAN KATEGORI
        // ==========================================================
        // medication → KFA
        // food, environment, biologic → SNOMED-CT
        if ($category === 'medication') {
            $codeSystem = 'http://sys-ids.kemkes.go.id/kfa';
        } else {
            $codeSystem = 'http://snomed.info/sct';
        }

        // ==========================================================
        // 5. SUSUN PAYLOAD (SESUAI DOKUMENTASI SATUSEHAT)
        // ==========================================================
        $payload = [
            'resourceType' => 'AllergyIntolerance',
            'identifier' => [
                [
                    'system' => 'http://sys-ids.kemkes.go.id/allergy/' . $orgId,
                    'use'    => 'official',
                    'value'  => $localId
                ]
            ],
            'clinicalStatus' => [
                'coding' => [
                    [
                        'system'  => 'http://terminology.hl7.org/CodeSystem/allergyintolerance-clinical',
                        'code'    => $clinicalStatus,
                        'display' => ucfirst($clinicalStatus)
                    ]
                ]
            ],
            'verificationStatus' => [
                'coding' => [
                    [
                        'system'  => 'http://terminology.hl7.org/CodeSystem/allergyintolerance-verification',
                        'code'    => 'confirmed',
                        'display' => 'Confirmed'
                    ]
                ]
            ],
            'category' => [$category],
            'code' => [
                'coding' => [
                    [
                        'system'  => $codeSystem,
                        'code'    => $allergenCode,
                        'display' => $allergenDisplay
                    ]
                ],
                'text' => $allergenText ?: $allergenDisplay
            ],
            'patient' => [
                'reference' => 'Patient/' . $patientId,
                'display'   => $patientName ?: 'Pasien'
            ],
            'recordedDate' => $recordedDate
        ];

        // Tambahkan encounter
        if ($encounterId !== '') {
            $payload['encounter'] = [
                'reference' => 'Encounter/' . $encounterId
            ];
        }

        // Tambahkan recorder
        if ($practitionerId !== '') {
            $payload['recorder'] = [
                'reference' => 'Practitioner/' . $practitionerId,
                'display'   => $practitionerName ?: 'Dokter'
            ];
        }

        // 6. LOG
        log_message('debug', '[SS] POST /AllergyIntolerance payload: '
            . json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        // 7. KIRIM
        try {
            $result = ss_api('POST', '/AllergyIntolerance', $payload);
        } catch (\Throwable $e) {
            session()->setFlashdata('error', 'Gagal terhubung: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }

        // 8. HANDLE
        if (in_array($result['status'], [200, 201])) {
            $newId = $result['body']['id'] ?? '-';
            session()->setFlashdata(
                'success',
                "✅ AllergyIntolerance berhasil dibuat!<br>ID SATUSEHAT: <strong>{$newId}</strong>"
            );
            return redirect()->to('/allergy-intolerance?patient_id=' . $patientId);
        }

        session()->setFlashdata('error', $this->_parseError($result));
        return redirect()->back()->withInput();
    }

    // ==========================================================
    // EDIT - Preprocess dari SATUSEHAT
    // ==========================================================
    public function edit($id)
    {
        $result = ss_api('GET', '/AllergyIntolerance/' . $id);

        if ($result['status'] !== 200) {
            session()->setFlashdata('error', 'AllergyIntolerance tidak ditemukan.');
            return redirect()->to('/allergy-intolerance');
        }

        $allergy = $result['body'];

        // Preprocess
        $allergy['patient_id']    = str_replace('Patient/', '', $allergy['patient']['reference'] ?? '');
        $allergy['patient_name']  = $allergy['patient']['display'] ?? '';
        $allergy['encounter_id']  = str_replace('Encounter/', '', $allergy['encounter']['reference'] ?? '');
        $allergy['practitioner_id']   = str_replace('Practitioner/', '', $allergy['recorder']['reference'] ?? '');
        $allergy['practitioner_name'] = $allergy['recorder']['display'] ?? '';
        $allergy['allergen_code']    = $allergy['code']['coding'][0]['code'] ?? '';
        $allergy['allergen_display'] = $allergy['code']['coding'][0]['display'] ?? '';
        $allergy['allergen_system']  = $allergy['code']['coding'][0]['system'] ?? '';
        $allergy['allergen_text']    = $allergy['code']['text'] ?? '';
        $allergy['category']         = $allergy['category'][0] ?? 'medication';
        $allergy['clinical_status']  = $allergy['clinicalStatus']['coding'][0]['code'] ?? 'active';
        $allergy['local_id']         = $allergy['identifier'][0]['value'] ?? '';

        return view('allergy_intolerance/form', [
            'title'   => 'Edit AllergyIntolerance',
            'action'  => base_url('allergy-intolerance/update/' . $id),
            'allergy' => $allergy,
        ]);
    }

    // ==========================================================
    // UPDATE - PUT
    // ==========================================================
    public function update($id)
    {
        $getResult = ss_api('GET', '/AllergyIntolerance/' . $id);
        if ($getResult['status'] !== 200) {
            session()->setFlashdata('error', 'AllergyIntolerance tidak ditemukan.');
            return redirect()->to('/allergy-intolerance');
        }

        $allergy = $getResult['body'];

        // Ambil input yang boleh diubah
        $clinicalStatus = trim((string) $this->request->getPost('clinical_status')) ?: 'active';
        $allergenText   = trim((string) $this->request->getPost('allergen_text'));

        // Modifikasi
        $allergy['clinicalStatus']['coding'][0]['code']    = $clinicalStatus;
        $allergy['clinicalStatus']['coding'][0]['display'] = ucfirst($clinicalStatus);

        if ($allergenText !== '') {
            $allergy['code']['text'] = $allergenText;
        }

        unset($allergy['meta']);

        $result = ss_api('PUT', '/AllergyIntolerance/' . $id, $allergy);

        if ($result['status'] === 200) {
            session()->setFlashdata('success', '✅ AllergyIntolerance berhasil diupdate!');
        } else {
            session()->setFlashdata('error', $this->_parseError($result));
        }

        return redirect()->to('/allergy-intolerance');
    }

    // ==========================================================
    // DELETE - PATCH status ke 'resolved'
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

        $result = ss_api('PATCH', '/AllergyIntolerance/' . $id, $payload);

        if ($result['status'] === 200) {
            session()->setFlashdata('success', '✅ AllergyIntolerance ditandai resolved (sembuh).');
        } else {
            session()->setFlashdata('error', $this->_parseError($result));
        }

        return redirect()->to('/allergy-intolerance');
    }

    // ==========================================================
    // DEBUG
    // ==========================================================
    public function debug($id)
    {
        $result = ss_api('GET', '/AllergyIntolerance/' . $id);
        return $this->response->setJSON($result);
    }

    // ==========================================================
    // HELPER
    // ==========================================================
    private function _parseError(array $result): string
    {
        $msg = 'Gagal memproses AllergyIntolerance. ';
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
