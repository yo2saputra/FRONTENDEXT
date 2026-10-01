<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class MedicationRequestController extends BaseController
{
    // ==========================================================
    // INDEX - Daftar MedicationRequest
    // ==========================================================
    public function index()
    {
        $patientId = $this->request->getGet('patient_id') ?? '100000030009';
        $patientId = str_replace('Patient/', '', $patientId);

        // Search MedicationRequest by patient
        $result = ss_api('GET', '/MedicationRequest', [
            'subject' => 'Patient/' . $patientId,
        ]);

        // Filter response: hanya resourceType MedicationRequest yang valid
        $allEntries = $result['body']['entry'] ?? [];
        $validRequests = [];
        $suppressedCount = 0;

        foreach ($allEntries as $entry) {
            $resourceType = $entry['resource']['resourceType'] ?? '';
            if ($resourceType === 'MedicationRequest') {
                $validRequests[] = $entry;
            } elseif ($resourceType === 'OperationOutcome') {
                $suppressedCount++;
            }
        }

        $data = [
            'title'           => 'Daftar MedicationRequest (Resep)',
            'patientId'       => $patientId,
            'requests'        => $validRequests,
            'suppressedCount' => $suppressedCount,
            'total'           => $result['body']['total'] ?? 0,
            'error'           => $result['status'] !== 200
                ? ($result['error'] ?? $result['raw'])
                : null,
        ];

        return view('medication_request/index', $data);
    }

    // ==========================================================
    // CREATE - Form tambah MedicationRequest
    // ==========================================================
    public function create()
    {
        return view('medication_request/form', [
            'title'    => 'Tambah Resep Obat (MedicationRequest)',
            'action'   => base_url('medication-request/store'),
            'request'  => null,
        ]);
    }

    // ==========================================================
    // STORE - Simpan Medication + MedicationRequest (POST)
    // ==========================================================
    public function store()
    {
        // 1. AMBIL INPUT
        $patientId        = trim((string) $this->request->getPost('patient_id'));
        $patientName      = trim((string) $this->request->getPost('patient_name'));
        $practitionerId   = trim((string) $this->request->getPost('practitioner_id'));
        $practitionerName = trim((string) $this->request->getPost('practitioner_name'));
        $prescriptionId   = trim((string) $this->request->getPost('prescription_id'));
        $medicationName   = trim((string) $this->request->getPost('medication_name'));
        $kfaCode          = trim((string) $this->request->getPost('kfa_code'));
        $formCode         = trim((string) $this->request->getPost('form_code')) ?: 'BS023';
        $formDisplay      = trim((string) $this->request->getPost('form_display')) ?: 'Kaplet Salut Selaput';
        $manufacturerId   = trim((string) $this->request->getPost('manufacturer_id'));
        $medicationType   = trim((string) $this->request->getPost('medication_type')) ?: 'NC';
        $dosageText       = trim((string) $this->request->getPost('dosage_text'));
        $reasonCode       = trim((string) $this->request->getPost('reason_code'));
        $reasonDisplay    = trim((string) $this->request->getPost('reason_display'));
        $encounterId      = trim((string) $this->request->getPost('encounter_id'));  // ✅ TAMBAHAN

        // Ingredient array
        $ingredientCodes     = $this->request->getPost('ingredient_code')     ?? [];
        $ingredientDisplays  = $this->request->getPost('ingredient_display')  ?? [];
        $ingredientStrengths = $this->request->getPost('ingredient_strength') ?? [];

        // ORG ID DARI .env
        $orgId = ENV('SATUSEHAT_ORG_ID') ?: '';

        // Bersihkan prefix
        $patientId      = str_replace('Patient/', '', $patientId);
        $practitionerId = str_replace('Practitioner/', '', $practitionerId);
        $manufacturerId = str_replace('Organization/', '', $manufacturerId);
        $encounterId    = str_replace('Encounter/', '', $encounterId);  // ✅ TAMBAHAN

        // ✅ FALLBACK manufacturer
        if ($manufacturerId === '' || $manufacturerId === '900001') {
            $manufacturerId = $orgId;
        }

        // ✅ AUTO-GENERATE nomor resep
        if ($prescriptionId === '') {
            $prescriptionId = 'RESEP-' . date('YmdHis');
        }

        // 2. VALIDASI
        $errors = [];
        if ($patientId === '')       $errors[] = 'Patient ID wajib diisi.';
        if ($practitionerId === '')  $errors[] = 'Practitioner ID wajib diisi.';
        if ($orgId === '')           $errors[] = 'SATUSEHAT_ORG_ID belum diisi di .env.';
        if ($medicationName === '')  $errors[] = 'Nama Obat wajib diisi.';
        if ($kfaCode === '')         $errors[] = 'Kode KFA obat wajib diisi.';
        if ($dosageText === '')      $errors[] = 'Aturan pakai wajib diisi.';
        if ($encounterId === '')     $errors[] = 'Encounter ID wajib diisi.';  // ✅ TAMBAHAN

        if (!empty($errors)) {
            session()->setFlashdata('error', implode(' ', $errors));
            return redirect()->back()->withInput();
        }

        // 3. BUILD INGREDIENT
        $ingredients = [];
        foreach ($ingredientCodes as $i => $code) {
            if (empty($code)) continue;

            $ingredients[] = [
                'itemCodeableConcept' => [
                    'coding' => [[
                        'system'  => 'http://sys-ids.kemkes.go.id/kfa',
                        'code'    => $code,
                        'display' => $ingredientDisplays[$i] ?? 'Ingredient'
                    ]]
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

        // 4. SUSUN PAYLOAD MEDICATION
        $medicationPayload = [
            'resourceType' => 'Medication',
            'meta' => [
                'profile' => ['https://fhir.kemkes.go.id/r4/StructureDefinition/Medication']
            ],
            'identifier' => [
                [
                    'system' => 'http://sys-ids.kemkes.go.id/medication/' . $orgId,
                    'use'    => 'official',
                    'value'  => 'MED' . date('YmdHis')
                ]
            ],
            'code' => [
                'coding' => [[
                    'system'  => 'http://sys-ids.kemkes.go.id/kfa',
                    'code'    => $kfaCode,
                    'display' => $medicationName
                ]]
            ],
            'status' => 'active',
            'manufacturer' => [
                'reference' => 'Organization/' . $manufacturerId
            ],
            'form' => [
                'coding' => [[
                    'system'  => 'http://terminology.kemkes.go.id/CodeSystem/medication-form',
                    'code'    => $formCode,
                    'display' => $formDisplay
                ]]
            ],
            'ingredient' => $ingredients,
            'extension' => [
                [
                    'url' => 'https://fhir.kemkes.go.id/r4/StructureDefinition/MedicationType',
                    'valueCodeableConcept' => [
                        'coding' => [[
                            'system'  => 'http://terminology.kemkes.go.id/CodeSystem/medication-type',
                            'code'    => $medicationType,
                            'display' => $medicationType === 'NC' ? 'Non-compound' : 'Compound'
                        ]]
                    ]
                ]
            ]
        ];

        log_message('debug', '[SS] POST /Medication payload: '
            . json_encode($medicationPayload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        // 5. KIRIM MEDICATION
        try {
            $medResult = ss_api('POST', '/Medication', $medicationPayload);
        } catch (\Throwable $e) {
            session()->setFlashdata('error', 'Gagal terhubung (Medication): ' . $e->getMessage());
            return redirect()->back()->withInput();
        }

        if (!in_array($medResult['status'], [200, 201])) {
            session()->setFlashdata('error', 'Gagal membuat Medication: ' . $this->_parseError($medResult));
            return redirect()->back()->withInput();
        }

        $medicationId = $medResult['body']['id'] ?? null;
        if (empty($medicationId)) {
            session()->setFlashdata('error', 'Medication dibuat tapi ID tidak diterima.');
            return redirect()->back()->withInput();
        }

        // 6. SUSUN PAYLOAD MEDICATIONREQUEST
        $authoredOn = gmdate('Y-m-d\TH:i:s') . '+00:00';

        $medicationRequestPayload = [
            'resourceType' => 'MedicationRequest',
            'identifier' => [
                [
                    'system' => 'http://sys-ids.kemkes.go.id/prescription/' . $orgId,
                    'use'    => 'official',
                    'value'  => $prescriptionId
                ]
            ],
            'status' => 'active',
            'intent' => 'order',
            'medicationReference' => [
                'reference' => 'Medication/' . $medicationId
            ],
            'subject' => [
                'reference' => 'Patient/' . $patientId,
                'display'   => $patientName ?: 'Pasien'
            ],
            'encounter' => [                                            // ✅ TAMBAHAN WAJIB
                'reference' => 'Encounter/' . $encounterId
            ],
            'authoredOn' => $authoredOn,
            'requester' => [
                'reference' => 'Practitioner/' . $practitionerId,
                'display'   => $practitionerName ?: 'Dokter'
            ],
            'dosageInstruction' => [
                [
                    'sequence' => 1,
                    'text'     => $dosageText
                ]
            ]
        ];

        if ($reasonCode !== '') {
            $medicationRequestPayload['reasonCode'] = [
                [
                    'coding' => [[
                        'system'  => 'http://hl7.org/fhir/sid/icd-10',
                        'code'    => $reasonCode,
                        'display' => $reasonDisplay ?: $reasonCode
                    ]]
                ]
            ];
        }

        log_message('debug', '[SS] POST /MedicationRequest payload: '
            . json_encode($medicationRequestPayload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        // 7. KIRIM MEDICATIONREQUEST
        try {
            $reqResult = ss_api('POST', '/MedicationRequest', $medicationRequestPayload);
        } catch (\Throwable $e) {
            session()->setFlashdata('error', 'Gagal terhubung (MedicationRequest): ' . $e->getMessage());
            return redirect()->back()->withInput();
        }

        // 8. HANDLE RESPONSE
        if (in_array($reqResult['status'], [200, 201])) {
            $newId = $reqResult['body']['id'] ?? '-';
            session()->setFlashdata(
                'success',
                "✅ Resep berhasil dibuat!<br>" .
                    "MedicationRequest ID: <strong>{$newId}</strong><br>" .
                    "Medication ID: <strong>{$medicationId}</strong><br>" .
                    "Nomor Resep: <strong>{$prescriptionId}</strong>"
            );
            return redirect()->to('/medication-request?patient_id=' . $patientId);
        }

        session()->setFlashdata('error', $this->_parseError($reqResult));
        return redirect()->back()->withInput();
    }

    // ==========================================================
    // EDIT - Form edit MedicationRequest
    // ==========================================================
    public function edit($id)
    {
        $result = ss_api('GET', '/MedicationRequest/' . $id);

        if ($result['status'] !== 200) {
            session()->setFlashdata('error', 'MedicationRequest tidak ditemukan.');
            return redirect()->to('/medication-request');
        }

        return view('medication_request/form', [
            'title'    => 'Edit Resep Obat',
            'action'   => base_url('medication-request/update/' . $id),
            'request'  => $result['body'],
        ]);
    }

    // ==========================================================
    // UPDATE - PUT (update lengkap)
    // ==========================================================
    public function update($id)
    {
        $getResult = ss_api('GET', '/MedicationRequest/' . $id);
        if ($getResult['status'] !== 200) {
            session()->setFlashdata('error', 'MedicationRequest tidak ditemukan.');
            return redirect()->to('/medication-request');
        }

        $request = $getResult['body'];

        // Ambil input yang bisa diubah
        $prescriptionId = trim((string) $this->request->getPost('prescription_id'));
        $dosageText     = trim((string) $this->request->getPost('dosage_text'));

        // Modifikasi
        if (!empty($request['identifier'][0])) {
            $request['identifier'][0]['value'] = $prescriptionId;
        }
        if (!empty($request['dosageInstruction'][0])) {
            $request['dosageInstruction'][0]['text'] = $dosageText;
        }

        // Hapus meta (tidak boleh dikirim ulang saat PUT)
        unset($request['meta']);

        try {
            $result = ss_api('PUT', '/MedicationRequest/' . $id, $request);
        } catch (\Throwable $e) {
            session()->setFlashdata('error', 'Gagal: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }

        if ($result['status'] === 200) {
            session()->setFlashdata('success', '✅ MedicationRequest berhasil diupdate!');
        } else {
            session()->setFlashdata('error', $this->_parseError($result));
        }

        return redirect()->to('/medication-request');
    }

    // ==========================================================
    // DELETE - PATCH status ke 'cancelled' / 'stopped'
    // ==========================================================
    public function delete($id)
    {
        $payload = [
            [
                'op'    => 'replace',
                'path'  => '/status',
                'value' => 'cancelled'
            ]
        ];

        $result = ss_api('PATCH', '/MedicationRequest/' . $id, $payload);

        if ($result['status'] === 200) {
            session()->setFlashdata('success', '✅ Resep dibatalkan (cancelled).');
        } else {
            session()->setFlashdata('error', $this->_parseError($result));
        }

        return redirect()->to('/medication-request');
    }

    // ==========================================================
    // DEBUG - lihat detail MedicationRequest
    // ==========================================================
    public function debug($id)
    {
        $result = ss_api('GET', '/MedicationRequest/' . $id);
        return $this->response->setJSON($result);
    }

    // ==========================================================
    // TEST-DOC - POST payload contoh
    // ==========================================================
    public function testDoc()
    {
        if (ENVIRONMENT !== 'development') {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Forbidden']);
        }

        $patientId      = $this->request->getGet('patient_id') ?? '100000030009';
        $practitionerId = $this->request->getGet('practitioner_id') ?? 'N10000001';
        $orgId          = ENV('SATUSEHAT_ORG_ID') ?: '';

        if (empty($orgId)) {
            return $this->response->setJSON([
                'error' => 'SATUSEHAT_ORG_ID belum diisi di .env',
                'hint'  => 'Tambahkan: SATUSEHAT_ORG_ID = "10000004"'
            ]);
        }

        // 1. POST Medication
        $medicationPayload = [
            'resourceType' => 'Medication',
            'identifier' => [
                [
                    'system' => 'http://sys-ids.kemkes.go.id/medication/' . $orgId,
                    'use'    => 'official',
                    'value'  => 'MED' . date('YmdHis')
                ]
            ],
            'code' => [
                'coding' => [
                    [
                        'system'  => 'http://sys-ids.kemkes.go.id/kfa',
                        'code'    => '93001019',
                        'display' => 'Obat Anti Tuberculosis / Rifampicin 150 mg'
                    ]
                ]
            ],
            'status' => 'active'
        ];

        $medResult = ss_api('POST', '/Medication', $medicationPayload);

        if (!in_array($medResult['status'], [200, 201])) {
            return $this->response->setJSON([
                'step'    => 'Medication',
                'payload' => $medicationPayload,
                'status'  => $medResult['status'],
                'error'   => $medResult['body']
            ]);
        }

        $medicationId = $medResult['body']['id'];

        // 2. POST MedicationRequest
        $requestPayload = [
            'resourceType' => 'MedicationRequest',
            'identifier' => [
                [
                    'system' => 'http://sys-ids.kemkes.go.id/prescription/' . $orgId,
                    'use'    => 'official',
                    'value'  => 'RESEP' . date('YmdHis')
                ]
            ],
            'status' => 'active',
            'intent' => 'order',
            'medicationReference' => [
                'reference' => 'Medication/' . $medicationId
            ],
            'subject' => [
                'reference' => 'Patient/' . $patientId,
                'display'   => 'Budi Santoso'
            ],
            'authoredOn' => gmdate('Y-m-d\TH:i:s') . '+00:00',
            'requester' => [
                'reference' => 'Practitioner/' . $practitionerId,
                'display'   => 'Dokter Bronsig'
            ],
            'dosageInstruction' => [
                [
                    'sequence' => 1,
                    'text'     => '3 x 1 tablet setelah makan'
                ]
            ]
        ];

        $reqResult = ss_api('POST', '/MedicationRequest', $requestPayload);

        return $this->response->setJSON([
            'medication' => [
                'payload' => $medicationPayload,
                'status'  => $medResult['status'],
                'response' => $medResult['body']
            ],
            'medication_request' => [
                'payload' => $requestPayload,
                'status'  => $reqResult['status'],
                'response' => $reqResult['body']
            ]
        ]);
    }

    // ==========================================================
    // HELPER - parse error OperationOutcome
    // ==========================================================
    private function _parseError(array $result): string
    {
        $msg = 'Gagal memproses MedicationRequest. ';

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
}
