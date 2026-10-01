<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class DiagnosticReportController extends BaseController
{
    // ==========================================================
    // INDEX - Daftar DiagnosticReport (by patient)
    // ==========================================================
    public function index()
    {
        $patientId = $this->request->getGet('patient_id') ?? '100000030009';
        $patientId = str_replace('Patient/', '', $patientId);

        $result = ss_api('GET', '/DiagnosticReport', [
            'subject' => 'Patient/' . $patientId,
        ]);

        $allEntries = $result['body']['entry'] ?? [];
        $validEntries = [];
        $suppressedCount = 0;

        foreach ($allEntries as $entry) {
            $resourceType = $entry['resource']['resourceType'] ?? '';
            if ($resourceType === 'DiagnosticReport') {
                $validEntries[] = $entry;
            } elseif ($resourceType === 'OperationOutcome') {
                $suppressedCount++;
            }
        }

        $data = [
            'title'           => 'Daftar Laporan Pemeriksaan (DiagnosticReport)',
            'patientId'       => $patientId,
            'reports'         => $validEntries,
            'suppressedCount' => $suppressedCount,
            'total'           => $result['body']['total'] ?? 0,
            'error'           => $result['status'] !== 200
                ? ($result['error'] ?? $result['raw'])
                : null,
        ];

        return view('diagnostic_report/index', $data);
    }

    // ==========================================================
    // CREATE - Form tambah DiagnosticReport
    // ==========================================================
    public function create()
    {
        return view('diagnostic_report/form', [
            'title'  => 'Buat Laporan Pemeriksaan (DiagnosticReport)',
            'action' => base_url('diagnostic-report/store'),
            'report' => null,
        ]);
    }

    // ==========================================================
    // STORE - POST DiagnosticReport
    // ==========================================================
    public function store()
    {
        // 1. AMBIL INPUT
        $patientId       = trim((string) $this->request->getPost('patient_id'));
        $patientName     = trim((string) $this->request->getPost('patient_name'));
        $encounterId     = trim((string) $this->request->getPost('encounter_id'));
        $serviceRequestId = trim((string) $this->request->getPost('service_request_id'));
        $specimenId      = trim((string) $this->request->getPost('specimen_id'));
        $observationIds  = $this->request->getPost('observation_id') ?? [];
        $practitionerId  = trim((string) $this->request->getPost('practitioner_id'));
        $practitionerName = trim((string) $this->request->getPost('practitioner_name'));
        $reportCode      = trim((string) $this->request->getPost('report_code'));
        $reportDisplay   = trim((string) $this->request->getPost('report_display'));
        $reportSystem    = trim((string) $this->request->getPost('report_system')) ?: 'http://loinc.org';
        $effectiveDate   = trim((string) $this->request->getPost('effective_date'));
        $issuedDate      = trim((string) $this->request->getPost('issued_date'));
        $conclusion      = trim((string) $this->request->getPost('conclusion'));
        $status          = trim((string) $this->request->getPost('status')) ?: 'final';

        $orgId = ENV('SATUSEHAT_ORG_ID') ?: '';

        // Bersihkan prefix
        $patientId       = str_replace('Patient/', '', $patientId);
        $encounterId     = str_replace('Encounter/', '', $encounterId);
        $serviceRequestId = str_replace('ServiceRequest/', '', $serviceRequestId);
        $specimenId      = str_replace('Specimen/', '', $specimenId);
        $practitionerId  = str_replace('Practitioner/', '', $practitionerId);
        $observationIds  = array_map(function ($id) {
            return str_replace('Observation/', '', trim($id));
        }, $observationIds);

        // 2. VALIDASI
        $errors = [];
        if ($patientId === '')       $errors[] = 'Patient ID wajib diisi.';
        if ($orgId === '')           $errors[] = 'SATUSEHAT_ORG_ID belum diisi di .env.';
        if ($encounterId === '')     $errors[] = 'Encounter ID wajib diisi.';
        if ($reportCode === '')      $errors[] = 'Kode Laporan wajib diisi.';
        if ($effectiveDate === '')   $errors[] = 'Waktu pemeriksaan wajib diisi.';

        if (!empty($errors)) {
            session()->setFlashdata('error', implode(' ', $errors));
            return redirect()->back()->withInput();
        }

        // 3. FORMAT WAKTU (UTC +00)
        $effectiveFormatted = gmdate('Y-m-d\TH:i:s', strtotime($effectiveDate)) . '+00:00';
        $issuedFormatted    = !empty($issuedDate)
            ? gmdate('Y-m-d\TH:i:s', strtotime($issuedDate)) . '+00:00'
            : gmdate('Y-m-d\TH:i:s') . '+00:00';

        // 4. SUSUN PAYLOAD
        $payload = [
            'resourceType' => 'DiagnosticReport',
            'identifier' => [
                [
                    'system' => 'http://sys-ids.kemkes.go.id/diagnosticreport/' . $orgId,
                    'use'    => 'official',
                    'value'  => 'DR' . date('YmdHis')
                ]
            ],
            'status' => $status,
            'category' => [
                [
                    'coding' => [
                        [
                            'system'  => 'http://terminology.hl7.org/CodeSystem/v2-0074',
                            'code'    => 'LAB',
                            'display' => 'Laboratory'
                        ]
                    ]
                ]
            ],
            'code' => [
                'coding' => [
                    [
                        'system'  => $reportSystem,
                        'code'    => $reportCode,
                        'display' => $reportDisplay ?: 'Diagnostic Report'
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
            'effectiveDateTime' => $effectiveFormatted,
            'issued' => $issuedFormatted
        ];

        // Tambahkan basedOn (ServiceRequest)
        if ($serviceRequestId !== '') {
            $payload['basedOn'] = [
                [
                    'reference' => 'ServiceRequest/' . $serviceRequestId
                ]
            ];
        }

        // Tambahkan specimen
        if ($specimenId !== '') {
            $payload['specimen'] = [
                [
                    'reference' => 'Specimen/' . $specimenId
                ]
            ];
        }

        // Tambahkan result (Observations)
        if (!empty($observationIds)) {
            $payload['result'] = [];
            foreach ($observationIds as $obsId) {
                if ($obsId !== '') {
                    $payload['result'][] = [
                        'reference' => 'Observation/' . $obsId
                    ];
                }
            }
        }

        // Tambahkan performer
        if ($practitionerId !== '') {
            $payload['performer'] = [
                [
                    'reference' => 'Practitioner/' . $practitionerId,
                    'display'   => $practitionerName ?: 'Petugas'
                ]
            ];
        }

        // Tambahkan conclusion
        if ($conclusion !== '') {
            $payload['conclusion'] = $conclusion;
        }

        // 5. LOG
        log_message('debug', '[SS] POST /DiagnosticReport payload: '
            . json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        // 6. KIRIM
        try {
            $result = ss_api('POST', '/DiagnosticReport', $payload);
        } catch (\Throwable $e) {
            session()->setFlashdata('error', 'Gagal terhubung: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }

        // 7. HANDLE
        if (in_array($result['status'], [200, 201])) {
            $newId = $result['body']['id'] ?? '-';
            session()->setFlashdata(
                'success',
                "✅ DiagnosticReport berhasil dibuat!<br>ID SATUSEHAT: <strong>{$newId}</strong>"
            );
            return redirect()->to('/diagnostic-report?patient_id=' . $patientId);
        }

        session()->setFlashdata('error', $this->_parseError($result));
        return redirect()->back()->withInput();
    }

    // ==========================================================
    // EDIT - Preprocess dari SATUSEHAT
    // ==========================================================
    public function edit($id)
    {
        $result = ss_api('GET', '/DiagnosticReport/' . $id);

        if ($result['status'] !== 200) {
            session()->setFlashdata('error', 'DiagnosticReport tidak ditemukan.');
            return redirect()->to('/diagnostic-report');
        }

        $report = $result['body'];

        // Preprocess untuk form
        $report['patient_id']       = str_replace('Patient/', '', $report['subject']['reference'] ?? '');
        $report['patient_name']     = $report['subject']['display'] ?? '';
        $report['encounter_id']     = str_replace('Encounter/', '', $report['encounter']['reference'] ?? '');
        $report['service_request_id'] = str_replace('ServiceRequest/', '', $report['basedOn'][0]['reference'] ?? '');
        $report['specimen_id']      = str_replace('Specimen/', '', $report['specimen'][0]['reference'] ?? '');
        $report['practitioner_id']  = str_replace('Practitioner/', '', $report['performer'][0]['reference'] ?? '');
        $report['practitioner_name'] = $report['performer'][0]['display'] ?? '';
        $report['report_code']      = $report['code']['coding'][0]['code'] ?? '';
        $report['report_display']   = $report['code']['coding'][0]['display'] ?? '';
        $report['report_system']    = $report['code']['coding'][0]['system'] ?? 'http://loinc.org';
        $report['effective_date']   = $report['effectiveDateTime'] ?? '';
        $report['issued_date']      = $report['issued'] ?? '';
        $report['conclusion']       = $report['conclusion'] ?? '';
        $report['observation_ids']  = array_map(function ($r) {
            return str_replace('Observation/', '', $r['reference'] ?? '');
        }, $report['result'] ?? []);

        return view('diagnostic_report/form', [
            'title'  => 'Edit DiagnosticReport',
            'action' => base_url('diagnostic-report/update/' . $id),
            'report' => $report,
        ]);
    }

    // ==========================================================
    // UPDATE - PUT
    // ==========================================================
    public function update($id)
    {
        $getResult = ss_api('GET', '/DiagnosticReport/' . $id);
        if ($getResult['status'] !== 200) {
            session()->setFlashdata('error', 'DiagnosticReport tidak ditemukan.');
            return redirect()->to('/diagnostic-report');
        }

        $report = $getResult['body'];

        // Ambil input yang boleh diubah
        $status     = trim((string) $this->request->getPost('status')) ?: 'final';
        $conclusion = trim((string) $this->request->getPost('conclusion'));
        $issuedDate = trim((string) $this->request->getPost('issued_date'));

        // Modifikasi
        $report['status'] = $status;

        if ($conclusion !== '') {
            $report['conclusion'] = $conclusion;
        } else {
            unset($report['conclusion']);
        }

        if ($issuedDate !== '') {
            $report['issued'] = gmdate('Y-m-d\TH:i:s', strtotime($issuedDate)) . '+00:00';
        }

        // Hapus meta
        unset($report['meta']);

        $result = ss_api('PUT', '/DiagnosticReport/' . $id, $report);

        if ($result['status'] === 200) {
            session()->setFlashdata('success', '✅ DiagnosticReport berhasil diupdate!');
        } else {
            session()->setFlashdata('error', $this->_parseError($result));
        }

        return redirect()->to('/diagnostic-report');
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

        $result = ss_api('PATCH', '/DiagnosticReport/' . $id, $payload);

        if ($result['status'] === 200) {
            session()->setFlashdata('success', '✅ DiagnosticReport ditandai entered-in-error.');
        } else {
            session()->setFlashdata('error', $this->_parseError($result));
        }

        return redirect()->to('/diagnostic-report');
    }

    // ==========================================================
    // DEBUG
    // ==========================================================
    public function debug($id)
    {
        $result = ss_api('GET', '/DiagnosticReport/' . $id);
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

        $patientId       = $this->request->getGet('patient_id') ?? '100000030009';
        $encounterId     = $this->request->getGet('encounter_id') ?? '';
        $serviceRequestId = $this->request->getGet('service_request_id') ?? '';
        $specimenId      = $this->request->getGet('specimen_id') ?? '';
        $observationId   = $this->request->getGet('observation_id') ?? '';

        if (empty($encounterId) || empty($observationId)) {
            return $this->response->setJSON([
                'error' => 'encounter_id dan observation_id wajib diisi',
                'hint'  => 'Contoh: /diagnostic-report/test-doc?encounter_id=xxx&observation_id=yyy'
            ]);
        }

        $payload = [
            'resourceType' => 'DiagnosticReport',
            'status' => 'final',
            'category' => [
                [
                    'coding' => [
                        [
                            'system'  => 'http://terminology.hl7.org/CodeSystem/v2-0074',
                            'code'    => 'LAB',
                            'display' => 'Laboratory'
                        ]
                    ]
                ]
            ],
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
            'effectiveDateTime' => gmdate('Y-m-d\TH:i:s') . '+00:00',
            'issued' => gmdate('Y-m-d\TH:i:s') . '+00:00',
            'result' => [
                [
                    'reference' => 'Observation/' . $observationId
                ]
            ]
        ];

        if ($serviceRequestId !== '') {
            $payload['basedOn'] = [['reference' => 'ServiceRequest/' . $serviceRequestId]];
        }
        if ($specimenId !== '') {
            $payload['specimen'] = [['reference' => 'Specimen/' . $specimenId]];
        }

        $result = ss_api('POST', '/DiagnosticReport', $payload);

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
        $msg = 'Gagal memproses DiagnosticReport. ';
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
