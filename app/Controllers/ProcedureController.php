<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class ProcedureController extends BaseController
{
    // ==========================================================
    // INDEX - Daftar Procedure (by patient)
    // ==========================================================
    public function index()
    {
        $patientId = $this->request->getGet('patient_id') ?? '100000030009';
        $patientId = str_replace('Patient/', '', $patientId);

        $result = ss_api('GET', '/Procedure', [
            'subject' => 'Patient/' . $patientId,
        ]);

        $allEntries = $result['body']['entry'] ?? [];
        $validEntries = [];
        $suppressedCount = 0;

        foreach ($allEntries as $entry) {
            $resourceType = $entry['resource']['resourceType'] ?? '';
            if ($resourceType === 'Procedure') {
                $validEntries[] = $entry;
            } elseif ($resourceType === 'OperationOutcome') {
                $suppressedCount++;
            }
        }

        $data = [
            'title'           => 'Daftar Tindakan Medis (Procedure)',
            'patientId'       => $patientId,
            'procedures'      => $validEntries,
            'suppressedCount' => $suppressedCount,
            'total'           => $result['body']['total'] ?? 0,
            'error'           => $result['status'] !== 200
                ? ($result['error'] ?? $result['raw'])
                : null,
        ];

        return view('procedure/index', $data);
    }

    // ==========================================================
    // CREATE - Form tambah Procedure
    // ==========================================================
    public function create()
    {
        return view('procedure/form', [
            'title'    => 'Tambah Tindakan Medis (Procedure)',
            'action'   => base_url('procedure/store'),
            'procedure' => null,
        ]);
    }

    // ==========================================================
    // STORE - POST Procedure
    // ==========================================================
    public function store()
    {
        // 1. AMBIL INPUT
        $patientId       = trim((string) $this->request->getPost('patient_id'));
        $patientName     = trim((string) $this->request->getPost('patient_name'));
        $encounterId     = trim((string) $this->request->getPost('encounter_id'));
        $practitionerId  = trim((string) $this->request->getPost('practitioner_id'));
        $practitionerName = trim((string) $this->request->getPost('practitioner_name'));
        $procedureCode   = trim((string) $this->request->getPost('procedure_code'));
        $procedureDisplay = trim((string) $this->request->getPost('procedure_display'));
        $procedureSystem = trim((string) $this->request->getPost('procedure_system')) ?: 'http://hl7.org/fhir/sid/icd-9-cm';
        $performedDate   = trim((string) $this->request->getPost('performed_date'));
        $status          = trim((string) $this->request->getPost('status')) ?: 'completed';
        $note            = trim((string) $this->request->getPost('note'));

        $orgId = ENV('SATUSEHAT_ORG_ID') ?: '';

        // Bersihkan prefix
        $patientId      = str_replace('Patient/', '', $patientId);
        $encounterId    = str_replace('Encounter/', '', $encounterId);
        $practitionerId = str_replace('Practitioner/', '', $practitionerId);

        // 2. VALIDASI
        $errors = [];
        if ($patientId === '')       $errors[] = 'Patient ID wajib diisi.';
        if ($orgId === '')           $errors[] = 'SATUSEHAT_ORG_ID belum diisi di .env.';
        if ($encounterId === '')     $errors[] = 'Encounter ID wajib diisi.';
        if ($practitionerId === '')  $errors[] = 'Practitioner ID wajib diisi.';
        if ($procedureCode === '')   $errors[] = 'Kode tindakan wajib diisi.';
        if ($performedDate === '')   $errors[] = 'Waktu tindakan wajib diisi.';

        if (!empty($errors)) {
            session()->setFlashdata('error', implode(' ', $errors));
            return redirect()->back()->withInput();
        }

        // 3. FORMAT WAKTU (UTC +00)
        $performedFormatted = gmdate('Y-m-d\TH:i:s', strtotime($performedDate)) . '+00:00';

        // 4. SUSUN PAYLOAD
        $payload = [
            'resourceType' => 'Procedure',
            'status' => $status,
            'code' => [
                'coding' => [
                    [
                        'system'  => $procedureSystem,
                        'code'    => $procedureCode,
                        'display' => $procedureDisplay ?: 'Procedure'
                    ]
                ]
            ],
            'subject' => [
                'reference' => 'Patient/' . $patientId,
                'display'   => $patientName ?: 'Pasien'
            ],
            'encounter' => [
                'reference' => 'Encounter/' . $encounterId
            ],
            'performedDateTime' => $performedFormatted,
            'performer' => [
                [
                    'actor' => [
                        'reference' => 'Practitioner/' . $practitionerId,
                        'display'   => $practitionerName ?: 'Dokter'
                    ]
                ]
            ]
        ];

        if ($note !== '') {
            $payload['note'] = [
                ['text' => $note]
            ];
        }

        // 5. LOG
        log_message('debug', '[SS] POST /Procedure payload: '
            . json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        // 6. KIRIM
        try {
            $result = ss_api('POST', '/Procedure', $payload);
        } catch (\Throwable $e) {
            session()->setFlashdata('error', 'Gagal terhubung: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }

        // 7. HANDLE
        if (in_array($result['status'], [200, 201])) {
            $newId = $result['body']['id'] ?? '-';
            session()->setFlashdata(
                'success',
                "✅ Procedure berhasil dibuat!<br>ID SATUSEHAT: <strong>{$newId}</strong>"
            );
            return redirect()->to('/procedure?patient_id=' . $patientId);
        }

        session()->setFlashdata('error', $this->_parseError($result));
        return redirect()->back()->withInput();
    }

    // ==========================================================
    // EDIT - Preprocess dari SATUSEHAT
    // ==========================================================
    public function edit($id)
    {
        $result = ss_api('GET', '/Procedure/' . $id);

        if ($result['status'] !== 200) {
            session()->setFlashdata('error', 'Procedure tidak ditemukan.');
            return redirect()->to('/procedure');
        }

        $procedure = $result['body'];

        // Preprocess untuk form
        $procedure['patient_id']      = str_replace('Patient/', '', $procedure['subject']['reference'] ?? '');
        $procedure['patient_name']    = $procedure['subject']['display'] ?? '';
        $procedure['encounter_id']    = str_replace('Encounter/', '', $procedure['encounter']['reference'] ?? '');
        $procedure['practitioner_id'] = str_replace('Practitioner/', '', $procedure['performer'][0]['actor']['reference'] ?? '');
        $procedure['practitioner_name'] = $procedure['performer'][0]['actor']['display'] ?? '';
        $procedure['procedure_code']  = $procedure['code']['coding'][0]['code'] ?? '';
        $procedure['procedure_display'] = $procedure['code']['coding'][0]['display'] ?? '';
        $procedure['procedure_system'] = $procedure['code']['coding'][0]['system'] ?? 'http://hl7.org/fhir/sid/icd-9-cm';
        $procedure['performed_date']  = $procedure['performedDateTime'] ?? '';
        $procedure['note']            = $procedure['note'][0]['text'] ?? '';

        return view('procedure/form', [
            'title'    => 'Edit Procedure',
            'action'   => base_url('procedure/update/' . $id),
            'procedure' => $procedure,
        ]);
    }

    // ==========================================================
    // UPDATE - PUT
    // ==========================================================
    public function update($id)
    {
        $getResult = ss_api('GET', '/Procedure/' . $id);
        if ($getResult['status'] !== 200) {
            session()->setFlashdata('error', 'Procedure tidak ditemukan.');
            return redirect()->to('/procedure');
        }

        $procedure = $getResult['body'];

        // Ambil input yang boleh diubah
        $status        = trim((string) $this->request->getPost('status')) ?: 'completed';
        $performedDate = trim((string) $this->request->getPost('performed_date'));
        $note          = trim((string) $this->request->getPost('note'));

        // Modifikasi
        $procedure['status'] = $status;

        if ($performedDate !== '') {
            $procedure['performedDateTime'] = gmdate('Y-m-d\TH:i:s', strtotime($performedDate)) . '+00:00';
        }

        if ($note !== '') {
            $procedure['note'] = [['text' => $note]];
        } else {
            unset($procedure['note']);
        }

        // Hapus meta
        unset($procedure['meta']);

        $result = ss_api('PUT', '/Procedure/' . $id, $procedure);

        if ($result['status'] === 200) {
            session()->setFlashdata('success', '✅ Procedure berhasil diupdate!');
        } else {
            session()->setFlashdata('error', $this->_parseError($result));
        }

        return redirect()->to('/procedure');
    }

    // ==========================================================
    // DELETE - PATCH status ke 'entered-in-error'
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

        $result = ss_api('PATCH', '/Procedure/' . $id, $payload);

        if ($result['status'] === 200) {
            session()->setFlashdata('success', '✅ Procedure ditandai entered-in-error.');
        } else {
            session()->setFlashdata('error', $this->_parseError($result));
        }

        return redirect()->to('/procedure');
    }

    // ==========================================================
    // DEBUG
    // ==========================================================
    public function debug($id)
    {
        $result = ss_api('GET', '/Procedure/' . $id);
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

        if (empty($encounterId)) {
            return $this->response->setJSON([
                'error' => 'encounter_id wajib diisi',
                'hint'  => 'Contoh: /procedure/test-doc?encounter_id=xxx'
            ]);
        }

        $payload = [
            'resourceType' => 'Procedure',
            'status' => 'completed',
            'code' => [
                'coding' => [
                    [
                        'system'  => 'http://hl7.org/fhir/sid/icd-9-cm',
                        'code'    => '89.03',
                        'display' => 'Physical examination'
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
            'performedDateTime' => gmdate('Y-m-d\TH:i:s') . '+00:00',
            'performer' => [
                [
                    'actor' => [
                        'reference' => 'Practitioner/' . $practitionerId,
                        'display'   => 'dr. Abele Rose'
                    ]
                ]
            ]
        ];

        $result = ss_api('POST', '/Procedure', $payload);

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
        $msg = 'Gagal memproses Procedure. ';
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
