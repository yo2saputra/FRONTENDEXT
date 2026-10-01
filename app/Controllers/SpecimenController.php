<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class SpecimenController extends BaseController
{
    // ==========================================================
    // INDEX - Daftar Specimen
    // ==========================================================
    public function index()
    {
        $patientId = $this->request->getGet('patient_id') ?? '100000030009';
        $patientId = str_replace('Patient/', '', $patientId);

        // Filter: hanya Specimen milik patient tertentu
        $result = ss_api('GET', '/Specimen', [
            'subject' => 'Patient/' . $patientId,
        ]);

        // Filter response: hanya resourceType Specimen yang valid
        $allEntries = $result['body']['entry'] ?? [];
        $validSpecimens = [];
        $suppressedCount = 0;

        foreach ($allEntries as $entry) {
            $resourceType = $entry['resource']['resourceType'] ?? '';
            if ($resourceType === 'Specimen') {
                $validSpecimens[] = $entry;
            } elseif ($resourceType === 'OperationOutcome') {
                $suppressedCount++;
            }
        }

        $data = [
            'title'           => 'Daftar Specimen',
            'patientId'       => $patientId,
            'specimens'       => $validSpecimens,
            'suppressedCount' => $suppressedCount,
            'total'           => $result['body']['total'] ?? 0,
            'error'           => $result['status'] !== 200
                ? ($result['error'] ?? $result['raw'])
                : null,
        ];

        return view('specimen/index', $data);
    }

    // ==========================================================
    // CREATE - Form tambah Specimen
    // ==========================================================
    public function create()
    {
        return view('specimen/form', [
            'title'    => 'Tambah Specimen',
            'action'   => base_url('specimen/store'),
            'specimen' => null,
        ]);
    }

    // ==========================================================
    // STORE - Simpan Specimen baru (POST)
    // ==========================================================
    public function store()
    {
        // 1. AMBIL INPUT
        $patientId      = trim((string) $this->request->getPost('patient_id'));
        $patientName    = trim((string) $this->request->getPost('patient_name'));
        $specimenId     = trim((string) $this->request->getPost('specimen_id'));
        $specimenType   = trim((string) $this->request->getPost('specimen_type'));
        $specimenTypeDisplay = trim((string) $this->request->getPost('specimen_type_display'));
        $collectionTime = trim((string) $this->request->getPost('collection_time'));
        $collectorId    = trim((string) $this->request->getPost('collector_id'));
        $collectorName  = trim((string) $this->request->getPost('collector_name'));
        $serviceRequestId = trim((string) $this->request->getPost('service_request_id'));  // ← TAMBAHAN

        // ✅ ORG ID DARI .env (BUKAN DARI FORM)
        $orgId = $_ENV['SATUSEHAT_ORG_ID'] ?? '';

        // Bersihkan prefix
        $patientId        = str_replace('Patient/', '', $patientId);
        $collectorId      = str_replace('Practitioner/', '', $collectorId);
        $serviceRequestId = str_replace('ServiceRequest/', '', $serviceRequestId);

        // 2. VALIDASI
        $errors = [];
        if ($patientId === '')          $errors[] = 'Patient ID wajib diisi.';
        if ($orgId === '')              $errors[] = 'SATUSEHAT_ORG_ID belum diisi di .env.';
        if ($specimenId === '')         $errors[] = 'Nomor Spesimen wajib diisi.';
        if ($specimenType === '')       $errors[] = 'Kode Spesimen (SNOMED-CT) wajib diisi.';
        if ($collectionTime === '')     $errors[] = 'Waktu Pengambilan wajib diisi.';
        if ($serviceRequestId === '')   $errors[] = 'ServiceRequest ID wajib diisi (Specimen.request).';

        if (!empty($errors)) {
            session()->setFlashdata('error', implode(' ', $errors));
            return redirect()->back()->withInput();
        }

        // 3. FORMAT WAKTU
        $collectedFormatted = date('Y-m-d\TH:i:s', strtotime($collectionTime)) . '+00:00';

        // 4. SUSUN PAYLOAD
        $payload = [
            'resourceType' => 'Specimen',
            'identifier' => [
                [
                    'system' => 'http://sys-ids.kemkes.go.id/specimen/' . $orgId,
                    'use'    => 'official',
                    'value'  => $specimenId
                ]
            ],
            'status' => 'available',
            'type' => [
                'coding' => [
                    [
                        'system'  => 'http://snomed.info/sct',
                        'code'    => $specimenType,
                        'display' => $specimenTypeDisplay ?: 'Specimen'
                    ]
                ]
            ],
            'subject' => [
                'reference' => 'Patient/' . $patientId,
                'display'   => $patientName ?: 'Pasien'
            ],
            'request' => [                                       // ← WAJIB
                [
                    'reference' => 'ServiceRequest/' . $serviceRequestId
                ]
            ],
            'collection' => [
                'collectedDateTime' => $collectedFormatted
            ]
        ];

        if ($collectorId !== '') {
            $payload['collection']['collector'] = [
                'reference' => 'Practitioner/' . $collectorId,
                'display'   => $collectorName ?: 'Petugas'
            ];
        }

        // 5. LOG
        log_message('debug', '[SS] POST /Specimen payload: '
            . json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        // 6. KIRIM
        try {
            $result = ss_api('POST', '/Specimen', $payload);
        } catch (\Throwable $e) {
            session()->setFlashdata('error', 'Gagal terhubung ke SATUSEHAT: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }

        // 7. HANDLE
        if (in_array($result['status'], [200, 201])) {
            $newId = $result['body']['id'] ?? '-';
            session()->setFlashdata(
                'success',
                "✅ Specimen berhasil dibuat!<br>ID SATUSEHAT: <strong>{$newId}</strong>"
            );
            return redirect()->to('/specimen?patient_id=' . $patientId);
        }

        session()->setFlashdata('error', $this->_parseError($result));
        return redirect()->back()->withInput();
    }

    // ==========================================================
    // EDIT - Form edit Specimen
    // ==========================================================
    public function edit($id)
    {
        $result = ss_api('GET', '/Specimen/' . $id);

        if ($result['status'] !== 200) {
            session()->setFlashdata('error', 'Specimen tidak ditemukan.');
            return redirect()->to('/specimen');
        }

        return view('specimen/form', [
            'title'    => 'Edit Specimen',
            'action'   => base_url('specimen/update/' . $id),
            'specimen' => $result['body'],
        ]);
    }

    // ==========================================================
    // UPDATE - PUT (update lengkap)
    // ==========================================================
    public function update($id)
    {
        $getResult = ss_api('GET', '/Specimen/' . $id);
        if ($getResult['status'] !== 200) {
            session()->setFlashdata('error', 'Specimen tidak ditemukan.');
            return redirect()->to('/specimen');
        }

        $specimen = $getResult['body'];

        // Ambil input
        $specimenId         = trim((string) $this->request->getPost('specimen_id'));
        $specimenType       = trim((string) $this->request->getPost('specimen_type'));
        $specimenTypeDisplay = trim((string) $this->request->getPost('specimen_type_display'));
        $collectionTime     = trim((string) $this->request->getPost('collection_time'));

        // Modifikasi
        $specimen['identifier'][0]['value'] = $specimenId;
        $specimen['type']['coding'][0]['code'] = $specimenType;
        $specimen['type']['coding'][0]['display'] = $specimenTypeDisplay;
        $specimen['collection']['collectedDateTime'] = date('Y-m-d\TH:i:s', strtotime($collectionTime)) . '+00:00';

        // Hapus meta
        unset($specimen['meta']);

        try {
            $result = ss_api('PUT', '/Specimen/' . $id, $specimen);
        } catch (\Throwable $e) {
            session()->setFlashdata('error', 'Gagal: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }

        if ($result['status'] === 200) {
            session()->setFlashdata('success', '✅ Specimen berhasil diupdate!');
        } else {
            session()->setFlashdata('error', $this->_parseError($result));
        }

        return redirect()->to('/specimen');
    }

    // ==========================================================
    // DELETE - PATCH status ke 'unavailable' (bukan DELETE asli)
    // ==========================================================
    public function delete($id)
    {
        $payload = [
            [
                'op'    => 'replace',
                'path'  => '/status',
                'value' => 'unavailable'
            ]
        ];

        $result = ss_api('PATCH', '/Specimen/' . $id, $payload);

        if ($result['status'] === 200) {
            session()->setFlashdata('success', '✅ Specimen ditandai unavailable.');
        } else {
            session()->setFlashdata('error', $this->_parseError($result));
        }

        return redirect()->to('/specimen');
    }

    // ==========================================================
    // DEBUG - lihat detail Specimen
    // ==========================================================
    public function debug($id)
    {
        $result = ss_api('GET', '/Specimen/' . $id);
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

        $patientId        = $this->request->getGet('patient_id') ?? '100000030009';
        $serviceRequestId = $this->request->getGet('service_request_id') ?? '';

        // ✅ ORG ID DARI .env
        $orgId = $_ENV['SATUSEHAT_ORG_ID'] ?? '';

        if (empty($orgId)) {
            return $this->response->setJSON([
                'error' => 'SATUSEHAT_ORG_ID belum diisi di .env',
                'hint'  => 'Tambahkan: SATUSEHAT_ORG_ID = "10000004"'
            ]);
        }

        if (empty($serviceRequestId)) {
            return $this->response->setJSON([
                'error' => 'service_request_id wajib diisi (Specimen.request)',
                'hint'  => 'Contoh: /specimen/test-doc?service_request_id=xxx-yyy-zzz'
            ]);
        }

        $payload = [
            'resourceType' => 'Specimen',
            'identifier' => [
                [
                    'system' => 'http://sys-ids.kemkes.go.id/specimen/' . $orgId,
                    'use'    => 'official',
                    'value'  => '00001'
                ]
            ],
            'status' => 'available',
            'type' => [
                'coding' => [
                    [
                        'system'  => 'http://snomed.info/sct',
                        'code'    => '119294007',
                        'display' => 'Dried blood specimen'
                    ]
                ]
            ],
            'subject' => [
                'reference' => 'Patient/' . $patientId,
                'display'   => 'Budi Santoso'
            ],
            'request' => [                                     // ← WAJIB
                [
                    'reference' => 'ServiceRequest/' . $serviceRequestId
                ]
            ],
            'collection' => [
                'collectedDateTime' => date('Y-m-d\TH:i:s') . '+00:00'
            ]
        ];

        $result = ss_api('POST', '/Specimen', $payload);

        return $this->response->setJSON([
            'sent_payload' => $payload,
            'status_code'  => $result['status'],
            'response'     => $result['body'],
            'raw'          => $result['raw'],
        ]);
    }

    // ==========================================================
    // HELPER - parse error OperationOutcome
    // ==========================================================
    private function _parseError(array $result): string
    {
        $msg = 'Gagal memproses Specimen. ';

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
