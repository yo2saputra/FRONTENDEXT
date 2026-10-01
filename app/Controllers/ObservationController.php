<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class ObservationController extends BaseController
{
    // ==========================================================
    // INDEX - Daftar Observation (by patient)
    // ==========================================================
    public function index()
    {
        $patientId = $this->request->getGet('patient_id') ?? '100000030009';
        $patientId = str_replace('Patient/', '', $patientId);

        $result = ss_api('GET', '/Observation', [
            'subject' => 'Patient/' . $patientId,
        ]);

        $allEntries = $result['body']['entry'] ?? [];
        $validEntries = [];
        $suppressedCount = 0;

        foreach ($allEntries as $entry) {
            $resourceType = $entry['resource']['resourceType'] ?? '';
            if ($resourceType === 'Observation') {
                $validEntries[] = $entry;
            } elseif ($resourceType === 'OperationOutcome') {
                $suppressedCount++;
            }
        }

        $data = [
            'title'           => 'Daftar Hasil Pemeriksaan (Observation)',
            'patientId'       => $patientId,
            'observations'    => $validEntries,
            'suppressedCount' => $suppressedCount,
            'total'           => $result['body']['total'] ?? 0,
            'error'           => $result['status'] !== 200
                ? ($result['error'] ?? $result['raw'])
                : null,
        ];

        return view('observation/index', $data);
    }

    // ==========================================================
    // CREATE - Form tambah Observation
    // ==========================================================
    public function create()
    {
        return view('observation/form', [
            'title'       => 'Tambah Hasil Pemeriksaan (Observation)',
            'action'      => base_url('observation/store'),
            'observation' => null,
        ]);
    }

    // ==========================================================
    // STORE - POST Observation
    // ==========================================================
    public function store()
    {
        // 1. AMBIL INPUT
        $patientId       = trim((string) $this->request->getPost('patient_id'));
        $patientName     = trim((string) $this->request->getPost('patient_name'));
        $encounterId     = trim((string) $this->request->getPost('encounter_id'));
        $encounterDisplay = trim((string) $this->request->getPost('encounter_display'));
        $serviceRequestId = trim((string) $this->request->getPost('service_request_id'));
        $specimenId      = trim((string) $this->request->getPost('specimen_id'));
        $performerId     = trim((string) $this->request->getPost('performer_id'));
        $loincCode       = trim((string) $this->request->getPost('loinc_code'));
        $loincDisplay    = trim((string) $this->request->getPost('loinc_display'));
        $categoryCode    = trim((string) $this->request->getPost('category_code')) ?: 'vital-signs';
        $categoryDisplay = trim((string) $this->request->getPost('category_display')) ?: 'Vital Signs';
        $valueQuantity   = trim((string) $this->request->getPost('value_quantity'));
        $valueUnit       = trim((string) $this->request->getPost('value_unit'));
        $valueUnitCode   = trim((string) $this->request->getPost('value_unit_code'));
        $effectiveDate   = trim((string) $this->request->getPost('effective_date'));
        $issuedDate      = trim((string) $this->request->getPost('issued_date'));
        $status          = trim((string) $this->request->getPost('status')) ?: 'final';

        $orgId = ENV('SATUSEHAT_ORG_ID') ?: '';

        // Bersihkan prefix
        $patientId       = str_replace('Patient/', '', $patientId);
        $encounterId     = str_replace('Encounter/', '', $encounterId);
        $serviceRequestId = str_replace('ServiceRequest/', '', $serviceRequestId);
        $specimenId      = str_replace('Specimen/', '', $specimenId);
        $performerId     = str_replace('Practitioner/', '', $performerId);

        // 2. VALIDASI
        $errors = [];
        if ($patientId === '')       $errors[] = 'Patient ID wajib diisi.';
        if ($orgId === '')           $errors[] = 'SATUSEHAT_ORG_ID belum diisi di .env.';
        if ($encounterId === '')     $errors[] = 'Encounter ID wajib diisi.';
        if ($loincCode === '')       $errors[] = 'Kode LOINC wajib diisi.';
        if ($valueQuantity === '')   $errors[] = 'Nilai hasil wajib diisi.';
        if ($valueUnit === '')       $errors[] = 'Satuan wajib diisi.';
        if ($valueUnitCode === '')   $errors[] = 'Kode satuan (UCUM) wajib diisi.';
        if ($effectiveDate === '')   $errors[] = 'Waktu pemeriksaan wajib diisi.';

        if (!empty($errors)) {
            session()->setFlashdata('error', implode(' ', $errors));
            return redirect()->back()->withInput();
        }

        // 3. FORMAT WAKTU
        // effectiveDateTime: bisa tanggal saja atau dengan waktu
        $effectiveFormatted = date('Y-m-d\TH:i:s', strtotime($effectiveDate)) . '+07:00';

        // issued: default ke sekarang (UTC +00 atau WIB +07)
        $issuedFormatted = !empty($issuedDate)
            ? date('Y-m-d\TH:i:s', strtotime($issuedDate)) . '+07:00'
            : date('Y-m-d\TH:i:s') . '+07:00';

        // 4. SUSUN PAYLOAD
        $payload = [
            'resourceType' => 'Observation',
            'status' => $status,
            'category' => [
                [
                    'coding' => [
                        [
                            'system'  => 'http://terminology.hl7.org/CodeSystem/observation-category',
                            'code'    => $categoryCode,
                            'display' => $categoryDisplay
                        ]
                    ]
                ]
            ],
            'code' => [
                'coding' => [
                    [
                        'system'  => 'http://loinc.org',
                        'code'    => $loincCode,
                        'display' => $loincDisplay ?: 'Observation'
                    ]
                ]
            ],
            'subject' => [
                'reference' => 'Patient/' . $patientId,
                'display'   => $patientName ?: 'Pasien'
            ],
            'performer' => [
                [
                    'reference' => 'Practitioner/' . $performerId
                ]
            ],
            'encounter' => [
                'reference' => 'Encounter/' . $encounterId,
                'display'   => $encounterDisplay ?: 'Pemeriksaan'
            ],
            'effectiveDateTime' => $effectiveFormatted,
            'issued' => $issuedFormatted,
            'valueQuantity' => [
                'value'  => (float) $valueQuantity,
                'unit'   => $valueUnit,
                'system' => 'http://unitsofmeasure.org',
                'code'   => $valueUnitCode
            ]
        ];

        // Tambahkan basedOn (ServiceRequest) — opsional
        if ($serviceRequestId !== '') {
            $payload['basedOn'] = [['reference' => 'ServiceRequest/' . $serviceRequestId]];
        }

        // Tambahkan specimen — HANYA untuk kategori laboratory
        if ($specimenId !== '' && $categoryCode === 'laboratory') {
            $payload['specimen'] = ['reference' => 'Specimen/' . $specimenId];
        }

        // 5. LOG
        log_message('debug', '[SS] POST /Observation payload: '
            . json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        // 6. KIRIM
        try {
            $result = ss_api('POST', '/Observation', $payload);
        } catch (\Throwable $e) {
            session()->setFlashdata('error', 'Gagal terhubung: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }

        // 7. HANDLE
        if (in_array($result['status'], [200, 201])) {
            $newId = $result['body']['id'] ?? '-';
            session()->setFlashdata(
                'success',
                "✅ Observation berhasil dibuat!<br>ID SATUSEHAT: <strong>{$newId}</strong>"
            );
            return redirect()->to('/observation?patient_id=' . $patientId);
        }

        session()->setFlashdata('error', $this->_parseError($result));
        return redirect()->back()->withInput();
    }

    // ==========================================================
    // EDIT - Preprocess dari SATUSEHAT
    // ==========================================================
    public function edit($id)
    {
        $result = ss_api('GET', '/Observation/' . $id);

        if ($result['status'] !== 200) {
            session()->setFlashdata('error', 'Observation tidak ditemukan.');
            return redirect()->to('/observation');
        }

        $observation = $result['body'];

        // Preprocess
        $observation['patient_id']    = str_replace('Patient/', '', $observation['subject']['reference'] ?? '');
        $observation['patient_name']  = $observation['subject']['display'] ?? '';
        $observation['encounter_id']  = str_replace('Encounter/', '', $observation['encounter']['reference'] ?? '');
        $observation['encounter_display'] = $observation['encounter']['display'] ?? '';
        $observation['service_request_id'] = str_replace('ServiceRequest/', '', $observation['basedOn'][0]['reference'] ?? '');
        $observation['specimen_id']   = str_replace('Specimen/', '', $observation['specimen']['reference'] ?? '');
        $observation['performer_id']  = str_replace('Practitioner/', '', $observation['performer'][0]['reference'] ?? '');
        $observation['loinc_code']    = $observation['code']['coding'][0]['code'] ?? '';
        $observation['loinc_display'] = $observation['code']['coding'][0]['display'] ?? '';
        $observation['category_code'] = $observation['category'][0]['coding'][0]['code'] ?? 'vital-signs';
        $observation['category_display'] = $observation['category'][0]['coding'][0]['display'] ?? 'Vital Signs';
        $observation['effective_date'] = $observation['effectiveDateTime'] ?? '';
        $observation['issued_date']    = $observation['issued'] ?? '';
        $observation['value_quantity'] = $observation['valueQuantity']['value'] ?? '';
        $observation['value_unit']     = $observation['valueQuantity']['unit'] ?? '';
        $observation['value_unit_code'] = $observation['valueQuantity']['code'] ?? '';
        $observation['status']         = $observation['status'] ?? 'final';

        return view('observation/form', [
            'title'       => 'Edit Observation',
            'action'      => base_url('observation/update/' . $id),
            'observation' => $observation,
        ]);
    }

    // ==========================================================
    // UPDATE - PUT
    // ==========================================================
    public function update($id)
    {
        $getResult = ss_api('GET', '/Observation/' . $id);
        if ($getResult['status'] !== 200) {
            session()->setFlashdata('error', 'Observation tidak ditemukan.');
            return redirect()->to('/observation');
        }

        $observation = $getResult['body'];

        // Ambil input
        $status        = trim((string) $this->request->getPost('status')) ?: 'final';
        $valueQuantity = trim((string) $this->request->getPost('value_quantity'));
        $valueUnit     = trim((string) $this->request->getPost('value_unit'));
        $valueUnitCode = trim((string) $this->request->getPost('value_unit_code'));

        $observation['status'] = $status;

        if ($valueQuantity !== '') {
            $observation['valueQuantity'] = [
                'value'  => (float) $valueQuantity,
                'unit'   => $valueUnit,
                'system' => 'http://unitsofmeasure.org',
                'code'   => $valueUnitCode
            ];
        }

        unset($observation['meta']);

        $result = ss_api('PUT', '/Observation/' . $id, $observation);

        if ($result['status'] === 200) {
            session()->setFlashdata('success', '✅ Observation berhasil diupdate!');
        } else {
            session()->setFlashdata('error', $this->_parseError($result));
        }

        return redirect()->to('/observation');
    }

    // ==========================================================
    // DELETE - PATCH status
    // ==========================================================
    public function delete($id)
    {
        $payload = [
            [
                'op'    => 'replace',
                'path'  => '/status',
                'value' => 'entered-in-error'
            ]
        ];

        $result = ss_api('PATCH', '/Observation/' . $id, $payload);

        if ($result['status'] === 200) {
            session()->setFlashdata('success', '✅ Observation ditandai entered-in-error.');
        } else {
            session()->setFlashdata('error', $this->_parseError($result));
        }

        return redirect()->to('/observation');
    }

    // ==========================================================
    // DEBUG
    // ==========================================================
    public function debug($id)
    {
        $result = ss_api('GET', '/Observation/' . $id);
        return $this->response->setJSON($result);
    }

    // ==========================================================
    // HELPER
    // ==========================================================
    private function _parseError(array $result): string
    {
        $msg = 'Gagal memproses Observation. ';
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
