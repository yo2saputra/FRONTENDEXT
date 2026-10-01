<?php

namespace App\Controllers;

use  App\Controllers\BaseController;

class ServiceRequestController extends BaseController
{
    // ==========================================================
    // INDEX - Daftar ServiceRequest (by patient)
    // ==========================================================
    public function index()
    {
        $patientId = $this->request->getGet('patient_id') ?? '100000030009';
        $patientId = str_replace('Patient/', '', $patientId);

        // Search by patient
        $result = ss_api('GET', '/ServiceRequest', [
            'subject' => 'Patient/' . $patientId,
        ]);

        // Filter valid entries
        $allEntries = $result['body']['entry'] ?? [];
        $validEntries = [];
        $suppressedCount = 0;

        foreach ($allEntries as $entry) {
            $resourceType = $entry['resource']['resourceType'] ?? '';
            if ($resourceType === 'ServiceRequest') {
                $validEntries[] = $entry;
            } elseif ($resourceType === 'OperationOutcome') {
                $suppressedCount++;
            }
        }

        $data = [
            'title'           => 'Daftar Permintaan Lab (ServiceRequest)',
            'patientId'       => $patientId,
            'requests'        => $validEntries,
            'suppressedCount' => $suppressedCount,
            'total'           => $result['body']['total'] ?? 0,
            'error'           => $result['status'] !== 200
                ? ($result['error'] ?? $result['raw'])
                : null,
        ];

        return view('service_request/index', $data);
    }

    // ==========================================================
    // CREATE - Form tambah ServiceRequest
    // ==========================================================
    public function create()
    {
        return view('service_request/form', [
            'title'   => 'Buat Permintaan Lab (ServiceRequest)',
            'action'  => base_url('service-request/store'),
            'request' => null,
        ]);
    }

    // ==========================================================
    // STORE - POST ServiceRequest
    // ==========================================================
    public function store()
    {
        // ==========================================================
        // 1. AMBIL INPUT
        // ==========================================================
        $patientId        = trim((string) $this->request->getPost('patient_id'));
        $patientName      = trim((string) $this->request->getPost('patient_name'));
        $encounterId      = trim((string) $this->request->getPost('encounter_id'));
        $encounterDisplay = trim((string) $this->request->getPost('encounter_display'));
        $practitionerId   = trim((string) $this->request->getPost('practitioner_id'));
        $practitionerName = trim((string) $this->request->getPost('practitioner_name'));
        $performerId      = trim((string) $this->request->getPost('performer_id'));
        $performerName    = trim((string) $this->request->getPost('performer_name'));
        $loincCode        = trim((string) $this->request->getPost('loinc_code'));
        $loincDisplay     = trim((string) $this->request->getPost('loinc_display'));
        $loincText        = trim((string) $this->request->getPost('loinc_text'));
        $localId          = trim((string) $this->request->getPost('local_id'));
        $priority         = trim((string) $this->request->getPost('priority')) ?: 'routine';
        $intent           = trim((string) $this->request->getPost('intent')) ?: 'original-order';
        $occurrenceDate   = trim((string) $this->request->getPost('occurrence_date'));
        $reasonText       = trim((string) $this->request->getPost('reason_text'));

        $orgId = ENV('SATUSEHAT_ORG_ID') ?: '';

        // Bersihkan prefix
        $patientId      = str_replace('Patient/', '', $patientId);
        $encounterId    = str_replace('Encounter/', '', $encounterId);
        $practitionerId = str_replace('Practitioner/', '', $practitionerId);
        $performerId    = str_replace('Practitioner/', '', $performerId);

        // Auto-generate ID lokal
        if ($localId === '') {
            $localId = 'SR' . date('YmdHis');
        }

        // ==========================================================
        // 2. VALIDASI
        // ==========================================================
        $errors = [];
        if ($patientId === '')      $errors[] = 'Patient ID wajib diisi.';
        if ($orgId === '')          $errors[] = 'SATUSEHAT_ORG_ID belum diisi di .env.';
        if ($encounterId === '')    $errors[] = 'Encounter ID wajib diisi.';
        if ($practitionerId === '') $errors[] = 'Practitioner ID (dokter peminta) wajib diisi.';
        if ($loincCode === '')      $errors[] = 'Kode LOINC wajib diisi.';

        if (!empty($errors)) {
            session()->setFlashdata('error', implode(' ', $errors));
            return redirect()->back()->withInput();
        }

        // ==========================================================
        // 3. FORMAT WAKTU (UTC +07:00 sesuai dokumentasi)
        // ==========================================================
        // Dokumentasi SATUSEHAT pakai +07:00 (WIB) untuk ServiceRequest
        $authoredOn = date('Y-m-d\TH:i:s') . '+07:00';

        $occurrenceFormatted = null;
        if ($occurrenceDate !== '') {
            $occurrenceFormatted = date('Y-m-d\TH:i:s', strtotime($occurrenceDate)) . '+07:00';
        }

        // ==========================================================
        // 4. SUSUN PAYLOAD (SESUAI DOKUMENTASI)
        // ==========================================================
        $payload = [
            'resourceType' => 'ServiceRequest',
            'identifier' => [
                [
                    // ✅ PERBAIKAN: 'servicerequest' tanpa tanda hubung
                    'system' => 'http://sys-ids.kemkes.go.id/servicerequest/' . $orgId,
                    'value'  => $localId
                ]
            ],
            'status' => 'active',
            'intent' => $intent,
            'priority' => $priority,
            'category' => [
                [
                    'coding' => [
                        [
                            'system'  => 'http://snomed.info/sct',
                            'code'    => '108252007',
                            'display' => 'Laboratory procedure'
                        ]
                    ]
                ]
            ],
            'code' => [
                'coding' => [
                    [
                        'system'  => 'http://loinc.org',
                        'code'    => $loincCode,
                        'display' => $loincDisplay ?: 'Lab Test'
                    ]
                ]
            ],
            'subject' => [
                'reference' => 'Patient/' . $patientId,
                'display'   => $patientName ?: 'Pasien'
            ],
            'encounter' => [
                'reference' => 'Encounter/' . $encounterId,
                'display'   => $encounterDisplay ?: 'Permintaan pemeriksaan lab'
            ],
            'authoredOn' => $authoredOn,
            'requester' => [
                'reference' => 'Practitioner/' . $practitionerId,
                'display'   => $practitionerName ?: 'Dokter'
            ]
        ];

        // Tambahkan text di code (opsional)
        if ($loincText !== '') {
            $payload['code']['text'] = $loincText;
        }

        // Tambahkan occurrenceDateTime (opsional)
        if ($occurrenceFormatted !== null) {
            $payload['occurrenceDateTime'] = $occurrenceFormatted;
        }

        // Tambahkan performer (opsional)
        if ($performerId !== '') {
            $payload['performer'] = [
                [
                    'reference' => 'Practitioner/' . $performerId,
                    'display'   => $performerName ?: 'Petugas Lab'
                ]
            ];
        }

        // Tambahkan reasonCode (opsional)
        if ($reasonText !== '') {
            $payload['reasonCode'] = [
                [
                    'text' => $reasonText
                ]
            ];
        }

        // ==========================================================
        // 5. LOG PAYLOAD
        // ==========================================================
        log_message('debug', '[SS] POST /ServiceRequest payload: '
            . json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        // ==========================================================
        // 6. KIRIM
        // ==========================================================
        try {
            $result = ss_api('POST', '/ServiceRequest', $payload);
        } catch (\Throwable $e) {
            session()->setFlashdata('error', 'Gagal terhubung: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }

        // ==========================================================
        // 7. HANDLE RESPONSE
        // ==========================================================
        if (in_array($result['status'], [200, 201])) {
            $newId = $result['body']['id'] ?? '-';
            session()->setFlashdata(
                'success',
                "✅ ServiceRequest berhasil dibuat!<br>" .
                    "ServiceRequest ID: <strong>{$newId}</strong><br>" .
                    "Nomor Lokal: <strong>{$localId}</strong><br>" .
                    "<small>Salin ID di atas untuk membuat Specimen.</small>"
            );
            return redirect()->to('/service-request?patient_id=' . $patientId);
        }

        session()->setFlashdata('error', $this->_parseError($result));
        return redirect()->back()->withInput();
    }

    // ==========================================================
    // EDIT - Preprocess dari SATUSEHAT
    // ==========================================================
    public function edit($id)
    {
        $result = ss_api('GET', '/ServiceRequest/' . $id);

        if ($result['status'] !== 200) {
            session()->setFlashdata('error', 'ServiceRequest tidak ditemukan.');
            return redirect()->to('/service-request');
        }

        $request = $result['body'];

        // Preprocess untuk form
        $request['patient_id']      = str_replace('Patient/', '', $request['subject']['reference'] ?? '');
        $request['patient_name']    = $request['subject']['display'] ?? '';
        $request['encounter_id']    = str_replace('Encounter/', '', $request['encounter']['reference'] ?? '');
        $request['practitioner_id'] = str_replace('Practitioner/', '', $request['requester']['reference'] ?? '');
        $request['practitioner_name'] = $request['requester']['display'] ?? '';
        $request['loinc_code']      = $request['code']['coding'][0]['code'] ?? '';
        $request['loinc_display']   = $request['code']['coding'][0]['display'] ?? '';
        $request['local_id']        = $request['identifier'][0]['value'] ?? '';
        $request['category_code']   = $request['category'][0]['coding'][0]['code'] ?? '108252007';
        $request['category_display'] = $request['category'][0]['coding'][0]['display'] ?? 'Laboratory procedure';
        $request['priority']        = $request['priority'] ?? 'routine';
        $request['note']            = $request['note'][0]['text'] ?? '';

        return view('service_request/form', [
            'title'   => 'Edit ServiceRequest',
            'action'  => base_url('service-request/update/' . $id),
            'request' => $request,
        ]);
    }

    // ==========================================================
    // UPDATE - PUT
    // ==========================================================
    public function update($id)
    {
        $getResult = ss_api('GET', '/ServiceRequest/' . $id);
        if ($getResult['status'] !== 200) {
            session()->setFlashdata('error', 'ServiceRequest tidak ditemukan.');
            return redirect()->to('/service-request');
        }

        $request = $getResult['body'];

        // Ambil input yang boleh diubah
        $status    = trim((string) $this->request->getPost('status')) ?: 'active';
        $priority  = trim((string) $this->request->getPost('priority')) ?: 'routine';
        $note      = trim((string) $this->request->getPost('note'));

        // Modifikasi
        $request['status'] = $status;
        $request['priority'] = $priority;

        if ($note !== '') {
            $request['note'] = [['text' => $note]];
        } else {
            unset($request['note']);
        }

        // Hapus meta
        unset($request['meta']);

        $result = ss_api('PUT', '/ServiceRequest/' . $id, $request);

        if ($result['status'] === 200) {
            session()->setFlashdata('success', '✅ ServiceRequest berhasil diupdate!');
        } else {
            session()->setFlashdata('error', $this->_parseError($result));
        }

        return redirect()->to('/service-request');
    }

    // ==========================================================
    // DELETE - PATCH status ke 'revoked' / 'completed'
    // ==========================================================
    public function delete($id)
    {
        // ServiceRequest tidak punya 'cancelled', pakai 'revoked' untuk membatalkan
        $payload = [
            [
                'op'    => 'replace',
                'path'  => '/status',
                'value' => 'revoked'
            ]
        ];

        $result = ss_api('PATCH', '/ServiceRequest/' . $id, $payload);

        if ($result['status'] === 200) {
            session()->setFlashdata('success', '✅ ServiceRequest dibatalkan (revoked).');
        } else {
            session()->setFlashdata('error', $this->_parseError($result));
        }

        return redirect()->to('/service-request');
    }

    // ==========================================================
    // DEBUG - lihat detail
    // ==========================================================
    public function debug($id)
    {
        $result = ss_api('GET', '/ServiceRequest/' . $id);
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
        $encounterId    = $this->request->getGet('encounter_id') ?? '';
        $practitionerId = $this->request->getGet('practitioner_id') ?? 'N10000001';
        $orgId          = ENV('SATUSEHAT_ORG_ID') ?: '';

        if (empty($encounterId)) {
            return $this->response->setJSON([
                'error' => 'encounter_id wajib diisi',
                'hint'  => 'Contoh: /service-request/test-doc?encounter_id=xxx'
            ]);
        }

        $payload = [
            'resourceType' => 'ServiceRequest',
            'identifier' => [
                [
                    'system' => 'http://sys-ids.kemkes.go.id/service-request/' . $orgId,
                    'use'    => 'official',
                    'value'  => 'SR' . date('YmdHis')
                ]
            ],
            'status' => 'active',
            'intent' => 'order',
            'category' => [
                [
                    'coding' => [
                        [
                            'system'  => 'http://snomed.info/sct',
                            'code'    => '108252007',
                            'display' => 'Laboratory procedure'
                        ]
                    ]
                ]
            ],
            'priority' => 'routine',
            'code' => [
                'coding' => [
                    [
                        'system'  => 'http://loinc.org',
                        'code'    => '58410-2',
                        'display' => 'CBC panel - Blood by Automated count'
                    ]
                ]
            ],
            'subject' => [
                'reference' => 'Patient/' . $patientId,
                'display'   => 'Budi Santoso'
            ],
            'encounter' => [
                'reference' => 'Encounter/' . $encounterId
            ],
            'requester' => [
                'reference' => 'Practitioner/' . $practitionerId,
                'display'   => 'dr. Abele Rose'
            ],
            'performer' => [
                [
                    'reference' => 'Organization/' . $orgId
                ]
            ],
            'authoredOn' => gmdate('Y-m-d\TH:i:s') . '+00:00'
        ];

        $result = ss_api('POST', '/ServiceRequest', $payload);

        return $this->response->setJSON([
            'sent_payload' => $payload,
            'status_code'  => $result['status'],
            'response'     => $result['body'],
            'raw'          => $result['raw'],
        ]);
    }

    // ==========================================================
    // HELPER
    // ==========================================================
    private function _parseError(array $result): string
    {
        $msg = 'Gagal memproses ServiceRequest. ';
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
