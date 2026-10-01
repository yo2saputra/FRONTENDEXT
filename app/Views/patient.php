<!DOCTYPE html>
<html>

<head>
    <title>Test Patient SATUSEHAT</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .card {
            border: 1px solid #ddd;
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
        }

        .label {
            font-weight: bold;
            color: #555;
        }

        pre {
            background: #f5f5f5;
            padding: 10px;
            overflow-x: auto;
            border-radius: 5px;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
        }
    </style>
</head>

<body>

    <h1>🔍 Cek Patient SATUSEHAT</h1>

    <div>
        <label>Patient ID:</label>
        <input type="text" id="patientId" value="100000030009">
        <button onclick="getPatientById()">Get by ID</button>
        <button onclick="searchByNik()">Search by NIK</button>
    </div>

    <hr>
    <div id="result"></div>

    <script>
        // ============================================================
        // Fungsi utama: ambil patient by ID
        // ============================================================
        async function getPatientById() {
            const id = document.getElementById('patientId').value.trim();
            if (!id) return alert('ID wajib diisi');

            showLoading();

            try {
                const res = await fetch(`/satusehat/patient/${id}`);
                const json = await res.json();

                // Cek response valid
                if (!json.success) {
                    showError('API Error: ' + (json.error || json.message || 'Unknown error'));
                    return;
                }

                // Karena endpoint /Patient/{id} return single object,
                // json.data adalah object Patient langsung
                const patient = json.data;

                if (!patient || typeof patient !== 'object') {
                    showError('Response data tidak valid: ' + JSON.stringify(json));
                    return;
                }

                renderPatient(patient);

            } catch (err) {
                showError('Fetch error: ' + err.message);
            }
        }

        // ============================================================
        // Fungsi: search by NIK (return Bundle)
        // ============================================================
        async function searchByNik() {
            const nik = prompt('Masukkan NIK:');
            if (!nik) return;

            showLoading();

            try {
                const res = await fetch(`/satusehat/patient-search?nik=${encodeURIComponent(nik)}`);
                const json = await res.json();

                if (!json.success) {
                    showError('API Error: ' + (json.error || json.message || 'Unknown error'));
                    return;
                }

                const bundle = json.data;

                // Bundle biasanya punya field "entry"
                const entries = bundle?.entry || [];

                if (entries.length === 0) {
                    document.getElementById('result').innerHTML =
                        '<p class="error">Patient tidak ditemukan.</p>';
                    return;
                }

                // Render setiap patient
                let html = `<h3>Ditemukan ${entries.length} patient:</h3>`;
                entries.forEach((e, i) => {
                    html += `<div class="card"><h4>#${i + 1}</h4>`;
                    html += renderPatientHtml(e.resource);
                    html += `</div>`;
                });

                document.getElementById('result').innerHTML = html;

            } catch (err) {
                showError('Fetch error: ' + err.message);
            }
        }

        // ============================================================
        // Render patient ke HTML (SAFE ACCESS!)
        // ============================================================
        function renderPatient(patient) {
            const html = `<div class="card">
        <h3>Patient Detail</h3>
        ${renderPatientHtml(patient)}
        <hr>
        <details>
            <summary>Raw JSON</summary>
            <pre>${escapeHtml(JSON.stringify(patient, null, 2))}</pre>
        </details>
    </div>`;
            document.getElementById('result').innerHTML = html;
        }

        // Fungsi helper render (dipisah biar reusable)
        function renderPatientHtml(p) {
            if (!p) return '<p class="error">Data patient kosong.</p>';

            // ✅ SAFE ACCESS: pakai optional chaining (?.) dan fallback '-'
            const id = p.id || '-';
            const active = p.active === true ? 'Aktif' : (p.active === false ? 'Tidak Aktif' : '-');
            const resourceType = p.resourceType || '-';

            // Nama: cek array dulu
            let nama = '-';
            if (Array.isArray(p.name) && p.name.length > 0) {
                nama = p.name[0].text ||
                    (p.name[0].given ? p.name[0].given.join(' ') : null) ||
                    '-';
            }

            // Gender
            const gender = p.gender || '-';

            // Birth Date
            const birthDate = p.birthDate || '-';

            // Identifier list
            let identifiers = '-';
            if (Array.isArray(p.identifier) && p.identifier.length > 0) {
                identifiers = p.identifier.map(i =>
                    `<li><span class="label">${i.system || '?'}:</span> ${i.value || '-'}</li>`
                ).join('');
                identifiers = `<ul>${identifiers}</ul>`;
            }

            // Meta
            const lastUpdated = p.meta?.lastUpdated || '-';

            return `
        <p><span class="label">ID:</span> ${id}</p>
        <p><span class="label">Resource Type:</span> ${resourceType}</p>
        <p><span class="label">Active:</span> ${active}</p>
        <p><span class="label">Nama:</span> ${nama}</p>
        <p><span class="label">Gender:</span> ${gender}</p>
        <p><span class="label">Tanggal Lahir:</span> ${birthDate}</p>
        <p><span class="label">Identifier:</span></p>
        ${identifiers}
        <p><span class="label">Last Updated:</span> ${lastUpdated}</p>
    `;
        }

        // ============================================================
        // Utility
        // ============================================================
        function showLoading() {
            document.getElementById('result').innerHTML = '<p>⏳ Loading...</p>';
        }

        function showError(msg) {
            document.getElementById('result').innerHTML =
                `<p class="error">❌ ${escapeHtml(msg)}</p>`;
        }

        function escapeHtml(text) {
            if (text === null || text === undefined) return '';
            const div = document.createElement('div');
            div.textContent = String(text);
            return div.innerHTML;
        }
    </script>

</body>

</html>