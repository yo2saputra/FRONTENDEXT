<?php

namespace App\Controllers;

use  App\Controllers\BaseController;

class MedicationDispenseController extends BaseController
{
    // ==========================================================
    // INDEX - Daftar MedicationDispense
    // ==========================================================
    public function index()
    {
        $patientId = $this->request->getGet('patient_id') ?? '100000030009';
        $patientId = str_replace('Patient/', '', $patientId);

        $result = ss_api('GET', '/MedicationDispense', [
            'subject' => 'Patient/' . $patientId,
        ]);

        // Filter valid entries
        $allEntries = $result['body']['entry'] ?? [];
        $validEntries = [];
        $suppressedCount = 0;

        foreach ($allEntries as $entry) {
            $resourceType = $entry['resource']['resourceType'] ?? '';
            if ($resourceType === 'MedicationDispense') {
                $validEntries[] = $entry;
            } elseif ($resourceType === 'OperationOutcome') {
                $suppressedCount++;
            }
        }

        $data = [
            'title'           => 'Daftar Tebus Obat (MedicationDispense)',
            'patientId'       => $patientId,
            'dispenses'       => $validEntries,
            'suppressedCount' => $suppressedCount,
            'total'           => $result['body']['total'] ?? 0,
            'error'           => $result['status'] !== 200
                ? ($result['error'] ?? $result['raw'])
                : null,
        ];

        return view('medication_dispense/index', $data);
    }

    // ==========================================================
    // CREATE - Form tambah MedicationDispense
    // ==========================================================
    public function create()
    {
        return view('medication_dispense/form', [
            'title'    => 'Tambah Tebus Obat (MedicationDispense)',
            'action'   => base_url('medication-dispense/store'),
            'dispense' => null,
        ]);
    }

    // ==========================================================
    // STORE - Simpan MedicationDispense baru (POST)
    // ==========================================================
    public function store()
    {
        // ==========================================================
        // 1. AMBIL INPUT
        // ==========================================================
        $patientId       = trim((string) $this->request->getPost('patient_id'));
        $patientName     = trim((string) $this->request->getPost('patient_name'));
        $encounterId     = trim((string) $this->request->getPost('encounter_id'));
        $medicationReqId = trim((string) $this->request->getPost('medication_request_id'));
        $medicationId    = trim((string) $this->request->getPost('medication_id'));
        $medicationName  = trim((string) $this->request->getPost('medication_name'));
        $performerId     = trim((string) $this->request->getPost('performer_id'));
        $performerName   = trim((string) $this->request->getPost('performer_name'));
        $locationId      = trim((string) $this->request->getPost('location_id'));       // ← TAMBAHKAN
        $locationName    = trim((string) $this->request->getPost('location_name'));     // ← TAMBAHKAN
        $quantityValue   = trim((string) $this->request->getPost('quantity_value'));
        $quantityUnit    = trim((string) $this->request->getPost('quantity_unit')) ?: 'TAB';
        $daysSupply      = trim((string) $this->request->getPost('days_supply'));
        $whenPrepared    = trim((string) $this->request->getPost('when_prepared'));
        $whenHandedOver  = trim((string) $this->request->getPost('when_handed_over'));
        $dosageText      = trim((string) $this->request->getPost('dosage_text'));
        $category        = trim((string) $this->request->getPost('category')) ?: 'outpatient';

        // ORG ID
        $orgId = ENV('SATUSEHAT_ORG_ID') ?: '';

        // Bersihkan prefix
        $patientId       = str_replace('Patient/', '', $patientId);
        $encounterId     = str_replace('Encounter/', '', $encounterId);
        $medicationReqId = str_replace('MedicationRequest/', '', $medicationReqId);
        $medicationId    = str_replace('Medication/', '', $medicationId);
        $performerId     = str_replace('Practitioner/', '', $performerId);
        $locationId      = str_replace('Location/', '', $locationId);   // ← TAMBAHKAN

        // ==========================================================
        // 2. VALIDASI
        // ==========================================================
        $errors = [];
        if ($patientId === '')       $errors[] = 'Patient ID wajib diisi.';
        if ($orgId === '')           $errors[] = 'SATUSEHAT_ORG_ID belum diisi di .env.';
        if ($encounterId === '')     $errors[] = 'Encounter ID wajib diisi.';
        if ($medicationReqId === '') $errors[] = 'MedicationRequest ID wajib diisi.';
        if ($medicationId === '')    $errors[] = 'Medication ID wajib diisi.';
        if ($performerId === '')     $errors[] = 'Performer ID (Apoteker) wajib diisi.';
        if ($locationId === '')      $errors[] = 'Location ID (Apotek) wajib diisi.';   // ← TAMBAHKAN
        if ($quantityValue === '')   $errors[] = 'Jumlah obat wajib diisi.';
        if ($whenHandedOver === '')  $errors[] = 'Waktu serah terima wajib diisi.';

        if (!empty($errors)) {
            session()->setFlashdata('error', implode(' ', $errors));
            return redirect()->back()->withInput();
        }

        // ==========================================================
        // 3. FORMAT WAKTU (UTC +00)
        // ==========================================================
        $preparedFormatted = !empty($whenPrepared)
            ? gmdate('Y-m-d\TH:i:s', strtotime($whenPrepared)) . '+00:00'
            : null;
        $handedOverFormatted = gmdate('Y-m-d\TH:i:s', strtotime($whenHandedOver)) . '+00:00';

        // Generate kode unik untuk identifier
        $dispenseCode = 'DISP' . date('YmdHis');

        // ==========================================================
        // 4. SUSUN PAYLOAD
        // ==========================================================
        $payload = [
            'resourceType' => 'MedicationDispense',
            'identifier' => [
                [
                    'system' => 'http://sys-ids.kemkes.go.id/prescription/' . $orgId,
                    'use'    => 'official',
                    'value'  => $dispenseCode
                ],
                [
                    'system' => 'http://sys-ids.kemkes.go.id/prescription-item/' . $orgId,
                    'use'    => 'official',
                    'value'  => $dispenseCode . '-1'
                ]
            ],
            'status' => 'completed',
            'category' => [
                'coding' => [
                    [
                        'system'  => 'http://terminology.hl7.org/fhir/CodeSystem/medicationdispense-category',
                        'code'    => $category,
                        'display' => ucfirst($category)
                    ]
                ]
            ],
            'medicationReference' => [
                'reference' => 'Medication/' . $medicationId,
                'display'   => $medicationName ?: 'Obat'
            ],
            'subject' => [
                'reference' => 'Patient/' . $patientId,
                'display'   => $patientName ?: 'Pasien'
            ],
            'context' => [
                'reference' => 'Encounter/' . $encounterId
            ],
            'performer' => [
                [
                    'actor' => [
                        'reference' => 'Practitioner/' . $performerId,
                        'display'   => $performerName ?: 'Apoteker'
                    ]
                ]
            ],
            'location' => [
                'reference' => 'Location/' . $locationId,              // ✅ SUDAH ADA
                'display'   => $locationName ?: 'Apotek'
            ],
            'authorizingPrescription' => [
                [
                    'reference' => 'MedicationRequest/' . $medicationReqId
                ]
            ],
            'quantity' => [
                'value'  => (float) $quantityValue,
                'system' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm',
                'code'   => $quantityUnit,
                'unit'   => $quantityUnit
            ],
            'daysSupply' => [
                'value' => (int) $daysSupply,
                'unit'  => 'Day',
                'system' => 'http://unitsofmeasure.org',
                'code'  => 'd'
            ],
            'whenHandedOver' => $handedOverFormatted,
            'dosageInstruction' => [
                [
                    'sequence' => 1,
                    'text'     => $dosageText ?: 'Sesuai resep'
                ]
            ]
        ];

        if ($preparedFormatted !== null) {
            $payload['whenPrepared'] = $preparedFormatted;
        }

        // ==========================================================
        // 5. LOG PAYLOAD
        // ==========================================================
        log_message('debug', '[SS] POST /MedicationDispense payload: '
            . json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        // ==========================================================
        // 6. KIRIM
        // ==========================================================
        try {
            $result = ss_api('POST', '/MedicationDispense', $payload);
        } catch (\Throwable $e) {
            session()->setFlashdata('error', 'Gagal terhubung ke SATUSEHAT: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }

        // ==========================================================
        // 7. HANDLE RESPONSE
        // ==========================================================
        if (in_array($result['status'], [200, 201])) {
            $newId = $result['body']['id'] ?? '-';
            session()->setFlashdata(
                'success',
                "✅ MedicationDispense berhasil dibuat!<br>ID SATUSEHAT: <strong>{$newId}</strong>"
            );
            return redirect()->to('/medication-dispense?patient_id=' . $patientId);
        }

        session()->setFlashdata('error', $this->_parseError($result));
        return redirect()->back()->withInput();
    }

    // ==========================================================
    // EDIT - Form edit (preprocess dari SATUSEHAT)
    // ==========================================================
    public function edit($id)
    {
        $result = ss_api('GET', '/MedicationDispense/' . $id);

        if ($result['status'] !== 200) {
            session()->setFlashdata('error', 'MedicationDispense tidak ditemukan.');
            return redirect()->to('/medication-dispense');
        }

        $dispense = $result['body'];

        // Preprocess: ekstrak ID dari reference
        $dispense['patient_id'] = str_replace('Patient/', '', $dispense['subject']['reference'] ?? '');
        $dispense['patient_name'] = $dispense['subject']['display'] ?? '';
        $dispense['encounter_id'] = str_replace('Encounter/', '', $dispense['context']['reference'] ?? '');
        $dispense['medication_request_id'] = str_replace('MedicationRequest/', '', $dispense['authorizingPrescription'][0]['reference'] ?? '');
        $dispense['medication_id'] = str_replace('Medication/', '', $dispense['medicationReference']['reference'] ?? '');
        $dispense['performer_id'] = str_replace('Practitioner/', '', $dispense['performer'][0]['actor']['reference'] ?? '');
        $dispense['performer_name'] = $dispense['performer'][0]['actor']['display'] ?? '';
        $dispense['quantity_value'] = $dispense['quantity']['value'] ?? '';
        $dispense['quantity_unit'] = $dispense['quantity']['unit'] ?? 'TAB';
        $dispense['days_supply'] = $dispense['daysSupply']['value'] ?? '';
        $dispense['when_prepared'] = $dispense['whenPrepared'] ?? '';
        $dispense['when_handed_over'] = $dispense['whenHandedOver'] ?? '';
        $dispense['dosage_text'] = $dispense['dosageInstruction'][0]['text'] ?? '';

        return view('medication_dispense/form', [
            'title'    => 'Edit Tebus Obat',
            'action'   => base_url('medication-dispense/update/' . $id),
            'dispense' => $dispense,
        ]);
    }

    // ==========================================================
    // UPDATE - PUT
    // ==========================================================
    public function update($id)
    {
        $getResult = ss_api('GET', '/MedicationDispense/' . $id);
        if ($getResult['status'] !== 200) {
            session()->setFlashdata('error', 'MedicationDispense tidak ditemukan.');
            return redirect()->to('/medication-dispense');
        }

        $dispense = $getResult['body'];

        // Ambil input yang boleh diubah
        $quantityValue = trim((string) $this->request->getPost('quantity_value'));
        $quantityUnit  = trim((string) $this->request->getPost('quantity_unit')) ?: 'TAB';
        $daysSupply    = trim((string) $this->request->getPost('days_supply'));
        $dosageText    = trim((string) $this->request->getPost('dosage_text'));
        $whenHandedOver = trim((string) $this->request->getPost('when_handed_over'));
        $status        = trim((string) $this->request->getPost('status')) ?: 'completed';

        // Modifikasi
        $dispense['status'] = $status;
        $dispense['quantity']['value'] = (float) $quantityValue;
        $dispense['quantity']['unit'] = $quantityUnit;
        $dispense['daysSupply']['value'] = (int) $daysSupply;
        $dispense['dosageInstruction'][0]['text'] = $dosageText;

        if (!empty($whenHandedOver)) {
            $dispense['whenHandedOver'] = gmdate('Y-m-d\TH:i:s', strtotime($whenHandedOver)) . '+00:00';
        }

        // Hapus meta
        unset($dispense['meta']);

        $result = ss_api('PUT', '/MedicationDispense/' . $id, $dispense);

        if ($result['status'] === 200) {
            session()->setFlashdata('success', '✅ MedicationDispense berhasil diupdate!');
        } else {
            session()->setFlashdata('error', $this->_parseError($result));
        }

        return redirect()->to('/medication-dispense');
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

        $result = ss_api('PATCH', '/MedicationDispense/' . $id, $payload);

        if ($result['status'] === 200) {
            session()->setFlashdata('success', '✅ MedicationDispense ditandai entered-in-error.');
        } else {
            session()->setFlashdata('error', $this->_parseError($result));
        }

        return redirect()->to('/medication-dispense');
    }

    // ==========================================================
    // DEBUG
    // ==========================================================
    public function debug($id)
    {
        $result = ss_api('GET', '/MedicationDispense/' . $id);
        return $this->response->setJSON($result);
    }

    // ==========================================================
    // HELPER
    // ==========================================================
    private function _parseError(array $result): string
    {
        $msg = 'Gagal memproses MedicationDispense. ';
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
