<?php


// function getDropdownDokterNolabelVertical($name)
// {
//     $obj = apiDropdownDokter($name);

//     $output = '';
//     $output .= '

//             <select class="form-control form-control-sm select2 form1" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
//                 <option value=" ">--Select--</option>
//         ';

//     foreach ($obj as $data) {
//         $output .= '
//                     <option value="' . $data['kode_dokter'] . '">' . $data['nama_dokter'] . '</option>
//         ';
//     }
//     $output .= '
//             </select>
//             <span class="error invalid-feedback error' . ucfirst($name) . '"></span>

//         ';

//     return $output;
// }

// ---------------------------------------- Start Dropdown By Rifaaa ----------------------------------------

// ---------- Start Create By RIfa | Menu GL Journal ----------
function apiDropdownFiscalCalender($fiscYear = null)
{
    $server3 = $_ENV['APP_API3'];
    $url = "{$server3}/api/gldropdown/tmstgljournal/fiscalcalender";

    $query = [
        'action' => 'fiscalyear',
        'FiscYear' => $fiscYear
    ];

    $response = akses_restapikey('GET', $url, $body = [], $query);
    $decoded = json_decode($response, true);

    return $decoded;
}

function getDropdownFiscalCalender($name, $fiscYear = null)
{
    $obj = apiDropdownFiscalCalender($fiscYear);

    $output = '<select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;">';
    $output .= '<option value="">--Select--</option>';

    if (!empty($obj['data'])) {
        foreach ($obj['data'] as $data) {
            $output .= '<option value="' . $data['value'] . '">'
                . $data['desc']
                . '</option>';
        }
    }

    $output .= '</select>';
    $output .= '<span class="error invalid-feedback error' . ucfirst($name) . '"></span>';

    return $output;
}
// ---------- Start Create By RIfa | Menu GL Journal ----------

// ---------- Start Create By RIfa | Menu GL Allocation Process ----------
function getDropdownFiscalPeriodAllocationProcess($key, $name, $filter)
{
    $obj = apiDropdown($key);

    $output  = '<select class="form-control select2 form-control-sm" ';
    $output .= 'name="' . $name . '" id="' . $name . '">';
    $output .= '<option value="">--Select--</option>';

    if (!empty($obj)) {
        foreach ($obj as $data) {
            if (!in_array($data['fld_valu'], $filter)) {
                $output .= '<option value="' . $data['fld_valu'] . '">'
                    . $data['fld_desc']
                    . '</option>';
            }
        }
    }

    $output .= '</select>';
    $output .= '<span class="error invalid-feedback error' . ucfirst($name) . '"></span>';

    return $output;
}

function apiDropdownFiscalCalenderYear()
{
    $server3 = $_ENV['APP_API3'];
    $url = "{$server3}/api/gldropdown/tmstglallocationprocess/fiscalcalenderyear";
    $query = ['action' => 'fiscalcalenderyear'];

    $response = akses_restapikey('GET', $url, $body = [], $query);
    return json_decode($response, true);
}

function getDropdownFiscalCalenderYear($name)
{
    $obj = apiDropdownFiscalCalenderYear();

    $output = '<select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;">';
    $output .= '<option value="">--Select--</option>';

    if (!empty($obj['data'])) {
        foreach ($obj['data'] as $data) {
            $output .= '<option value="' . $data['value'] . '">'
                . $data['desc']
                . '</option>';
        }
    }

    $output .= '</select>';
    $output .= '<span class="error invalid-feedback error' . ucfirst($name) . '"></span>';

    return $output;
}

// ---------- Start Create By RIfa | Menu GL Allocation Process ----------

// ---------- Start Create By RIfa | Menu GL Allocation Entry ----------
function apiDropdownToAllocationAccount($key)
{
    $server3 = $_ENV['APP_API3'];
    $url = "{$server3}/api/gldropdown/glallocation/sourceaccount";

    $query = [
        'action' => 'sourceaccount'
    ];

    $response = akses_restapikey('GET', $url, [], $query);
    $result = json_decode($response, true);

    return $result;
}

function getDropdownToAllocationAccount($key, $name)
{
    $obj = apiDropdownToAllocationAccount($key);

    $output = '<select class="form-control form-control-sm select2-dynamic" ';
    $output .= 'name="' . $name . '[]" ';
    $output .= 'data-placeholder="--Select Account--">';
    $output .= '<option value="">--Select--</option>';

    if (!empty($obj) && isset($obj['data']) && is_array($obj['data'])) {
        foreach ($obj['data'] as $data) {
            $output .= '<option value="' . htmlspecialchars($data['value']) . '" ';
            $output .= 'data-account-name="' . htmlspecialchars($data['desc'] ?? '') . '">';
            $output .= htmlspecialchars($data['value2'] ?? $data['value']) . '</option>';
        }
    }

    $output .= '</select>';

    return $output;
}

function apiDropdownFromAllocationAccount($key)
{
    $server3 = $_ENV['APP_API3'];
    $url = "{$server3}/api/gldropdown/glallocation/sourceaccount";

    $query = [
        'action' => 'sourceaccount'
    ];

    $response = akses_restapikey('GET', $url, [], $query);
    return json_decode($response, true);
}

function getDropdownFromAllocationAccount($key, $name)
{
    $obj = apiDropdownFromAllocationAccount($key);

    $output = '';
    $output .= '
        <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '">
    ';
    $output .= '<option value="">--Select--</option>';

    if (!empty($obj) && isset($obj['data']) && is_array($obj['data'])) {
        foreach ($obj['data'] as $data) {
            $output .= '<option value="' . htmlspecialchars($data['value']) . '" ';
            $output .= 'data-account-name="' . htmlspecialchars($data['desc'] ?? '') . '">';
            $output .= htmlspecialchars($data['value2'] ?? $data['value']) . '</option>';
        }
    }

    $output .= '</select>';
    $output .= '<span class="error invalid-feedback error' . ucfirst($name) . '"></span>';

    return $output;
}

function getDropdownAllocationMethod($key, $name)
{
    $obj = apiDropdown($key);

    $output = '';
    $output .= '
        <select class="form-control form-control-sm" name="' . $name . '" id="' . $name . '">
    ';
    $output .= '<option value="">--Select--</option>';

    foreach ($obj as $data) {
        $output .= '
            <option value="' . $data['fld_valu'] . '">' . $data['fld_desc'] . '</option>
        ';
    }

    $output .= '
        </select>
        <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
    ';

    return $output;
}
// ---------- Start Create By RIfa | Menu GL Allocation Entry ----------

// ---------- Start Create By RIfa | Menu GL Coa ----------

// -----
function apiDropdownGlSegmentCoa()
{
    $server3 = $_ENV['APP_API3'];
    $url = "{$server3}/api/gldropdown/glcoa/glsegmentcoa";
    $query = ['action' => 'glsegmentcoa'];

    $response = akses_restapikey('GET', $url, [], $query);
    return json_decode($response, true);
}

function getDropdownGlSegmentCoa($name, array $segmentNumberFilter = [])
{
    $obj = apiDropdownGlSegmentCoa();

    $output = '<select class="form-control form-control-sm" name="' . $name . '" id="' . $name . '">';
    $output .= '<option value="">-- Select --</option>';

    if (!empty($obj['data'])) {
        foreach ($obj['data'] as $data) {

            if (
                !empty($segmentNumberFilter)
                && !in_array((string)$data['segmentNumber'], $segmentNumberFilter, true)
            ) {
                continue;
            }

            $output .= '<option value="' . $data['segmentValueNumber'] . '">'
                . $data['segmentValueNumber'] .
                '</option>';
        }
    }

    $output .= '</select>';
    $output .= '<span class="error invalid-feedback error' . ucfirst($name) . '"></span>';

    return $output;
}
// -----

// -----
function apiDropdownSegmentDelimiter($key)
{
    $server3 = $_ENV['APP_API3'];
    $url = "{$server3}/api/gldropdown/gloptionsegment/segmentdelimiter";

    $query = [
        'action' => 'segmentdelimiter'
    ];

    $response = akses_restapikey('GET', $url, [], $query);
    return json_decode($response, true);
}

function getDropdownSegmentDelimiter($key, $name)
{
    $obj = apiDropdownSegmentDelimiter($key);

    $output = '<select class="form-control form-control-sm" name="' . $name . '" id="' . $name . '">';

    foreach ($obj['data'] as $data) {
        $output .= '<option value="' . $data['value'] . '">' . $data['desc'] . '</option>';
    }

    $output .= '</select>';
    $output .= '<span class="error invalid-feedback error' . ucfirst($name) . '"></span>';

    return $output;
}
// -----
function apiDropdownAccountStructure($key)
{
    $server3 = $_ENV['APP_API3'];
    $url = "{$server3}/api/gldropdown/glaccountstructure/structureid";

    $query = [
        'action' => 'structureid'
    ];

    $response = akses_restapikey('GET', $url, [], $query);
    return json_decode($response, true);
}

function getDropdownAccountStructure($key, $name)
{
    $obj = apiDropdownGetAccountStructure($key);

    $grouped = [];

    foreach ($obj['data'] as $row) {
        $sid = $row['structureID'];

        if (!isset($grouped[$sid])) {
            $grouped[$sid] = [
                'structureID'   => $row['structureID'],
                'structureName' => $row['structureName'],
                'segments'      => []
            ];
        }

        $grouped[$sid]['segments'][] = [
            'segmentNo'      => $row['segmentNo'],
            'segmentID'      => $row['segmentID'],
            'segmentName'    => $row['segmentName'],
            'segmentLength'  => $row['segmentLength'],
            'segmentClosing' => $row['segmentClosing']
        ];
    }

    $output  = '<select class="form-control form-control-sm select2" ';
    $output .= 'name="' . $name . '" id="' . $name . '" style="width:100%">';
    $output .= '<option value="">-- Select --</option>';

    foreach ($grouped as $data) {
        $output .= '
            <option value="' . $data['structureID'] . '"
                data-structure-name="' . $data['structureName'] . '"
                data-segments=\'' . json_encode($data['segments']) . '\'>
                ' . $data['structureID'] . '
            </option>';
    }

    $output .= '</select>';

    return $output;
}

function getDropdownTfieldValue($key, $name)
{
    $obj = apiDropdown($key);

    $output = '<select class="form-control form-control-sm" name="' . $name . '" id="' . $name . '">';
    $output .= '<option value="">--Select--</option>';

    foreach ($obj as $data) {
        $output .= '
            <option value="' . $data['fld_valu'] . '" 
                    data-id="' . $data['fld_valu'] . '" 
                    data-desc="' . $data['fld_desc'] . '" 
                    data-fulltext="' . $data['fld_valu'] . '">
                ' . $data['fld_valu'] . ' - ' . $data['fld_desc'] . '
            </option>
        ';
    }

    $output .= '</select>';
    $output .= '<span class="error invalid-feedback error' . ucfirst($name) . '"></span>';

    return $output;
}

function apiDropdownGetAccountStructure($key)
{
    $server3 = $_ENV['APP_API3'];
    $url = "{$server3}/api/gldropdown/glaccountstructure/structureid";

    $query = [
        'action' => 'structureid'
    ];

    $response = akses_restapikey('GET', $url, [], $query);
    return json_decode($response, true);
}

function getDropdownGetAccountStructure($key, $name)
{
    $obj = apiDropdownGetAccountStructure($key);

    $output  = '<select class="form-control form-control-sm select2" ';
    $output .= 'name="' . $name . '" id="' . $name . '" style="width:100%">';

    $output .= '<option value="">-- Select --</option>';

    if (!empty($obj['data'])) {
        foreach ($obj['data'] as $data) {
            $output .= '
                <option value="' . $data['structureID'] . '"
                    data-structure-id="' . $data['structureID'] . '"
                    data-structure-name="' . $data['structureName'] . '">
                    ' . $data['structureID'] . '
                </option>';
        }
    }

    $output .= '</select>';

    return $output;
}
// ---------- End Create By RIfa | Menu GL Coa ----------

// ---------- Start Create By RIfa | Menu GL Segment ----------
function apiDropdownGetGlSegment($key)
{
    $server3 = $_ENV['APP_API3'];
    $url = "{$server3}/api/gldropdown/glsegment/segmentid";

    $query = [
        'action' => 'segmentid'
    ];

    $response = akses_restapikey('GET', $url, [], $query);
    return json_decode($response, true);
}

function getDropdownGetGlSegment($key, $name)
{
    $obj = apiDropdownGetGlSegment($key);

    $output  = '<select class="form-control form-control-sm select2" ';
    $output .= 'name="' . $name . '" id="' . $name . '" style="width:100%">';

    $output .= '<option value="">-- Select --</option>';

    if (!empty($obj['data'])) {
        foreach ($obj['data'] as $data) {
            $output .= '
                <option value="' . $data['segmentId'] . '"
                    data-segment-number="' . $data['segmentNumber'] . '"
                    data-segment-name="' . $data['segmentName'] . '"
                    data-segment-length="' . $data['segmentLength'] . '">
                    ' . $data['segmentId'] . '
                </option>';
        }
    }

    $output .= '</select>';

    return $output;
}
// ---------- End Create By RIfa | Menu GL Segment ----------

// ---------- Start Create By RIfa | Menu Fiscal Calender ----------
function getDropdownFiscalPeriod($key, $name)
{
    $obj = apiDropdown($key);
    $output = '<select class="form-control form-control-sm" name="' . $name . '" id="' . $name . '">';
    $output .= '<option value="">--Select--</option>';

    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['fld_valu'] . '">' . $data['fld_desc'] . '</option>
        ';
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        ';

    return $output;
}
// ---------- End Create By RIfa | Menu Fiscal Calender ----------

// ---------- Start Create By RIfa | Menu Fiscal Calender Lock ----------
function apiDropdownFiscYear()
{
    $server3 = $_ENV['APP_API3'];
    $url = "{$server3}/api/fiscdropdown/fiscyear";
    $query = ['action' => 'fiscyear'];

    $response = akses_restapikey('GET', $url, $body = [], $query);
    return json_decode($response, true);
}

function getDropdownFiscYear($key, $name)
{
    $obj = apiDropdownFiscYear($key);

    $output = '<select class="form-control form-control-sm" name="' . $name . '" id="' . $name . '">';
    $output .= '<option value="">--Select--</option>';

    foreach ($obj['data'] as $data) {
        $output .= '<option value="' . $data['value'] . '">' . $data['desc'] . '</option>';
    }

    $output .= '</select>';
    $output .= '<span class="error invalid-feedback error' . ucfirst($name) . '"></span>';

    return $output;
}

function apiDropdownFiscPeriod()
{
    $server3 = $_ENV['APP_API3'];
    $url = "{$server3}/api/fiscdropdown/fiscperiod";
    $query = ['action' => 'fiscperiod'];

    $response = akses_restapikey('GET', $url, $body = [], $query);
    return json_decode($response, true);
}

function getDropdownFiscPeriod($key, $name)
{
    $obj = apiDropdownFiscPeriod($key);

    $output = '<select class="form-control form-control-sm" name="' . $name . '" id="' . $name . '">';
    $output .= '<option value="">--Select--</option>';

    foreach ($obj['data'] as $data) {
        $output .= '<option value="' . $data['value'] . '">' . $data['desc'] . '</option>';
    }

    $output .= '</select>';
    $output .= '<span class="error invalid-feedback error' . ucfirst($name) . '"></span>';

    return $output;
}

function apiDropdownModuleName()
{
    $server3 = $_ENV['APP_API3'];
    $url = "{$server3}/api/gldropdown/fiscalcalenderlock/modulname";
    $query = ['action' => 'modulname'];

    $response = akses_restapikey('GET', $url, $body = [], $query);
    return json_decode($response, true);
}

function getDropdownModuleName($key, $name)
{
    $obj = apiDropdownModuleName($key);

    $output = '<select class="form-control form-control-sm" name="' . $name . '" id="' . $name . '">';
    $output .= '<option value="">--Select--</option>';

    foreach ($obj['data'] as $data) {
        $output .= '<option value="' . $data['value'] . '">' . $data['desc'] . '</option>';
    }

    $output .= '</select>';
    $output .= '<span class="error invalid-feedback error' . ucfirst($name) . '"></span>';

    return $output;
}

function getDropdownFiscPeriode($key, $name)
{
    $obj = apiDropdown($key);
    $output = '<select class="form-control form-control-sm" name="' . $name . '" id="' . $name . '">';
    $output .= '<option value="">--Select--</option>';

    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['fld_valu'] . '">' . $data['fld_desc'] . '</option>
        ';
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        ';

    return $output;
}
// ---------- End Create By RIfa | Menu Fiscal Calender Lock ----------


// ---------- Start Create By Rifa | Menu GL Coa ----------
function apiDropdownSetDefaultCurency()
{
    $server3 = $_ENV['APP_API3'];
    $url = "{$server3}/api/gldropdown/glcoa/setdefaultcurency";
    $query = ['action' => 'setdefaultcurency'];

    $response = akses_restapikey('GET', $url, $body = [], $query);
    return json_decode($response, true);
}

function getDropdownSetDefaultCurency($key, $name)
{
    $obj = apiDropdownSetDefaultCurency($key);

    $output = '<select class="form-control form-control-sm" name="' . $name . '" id="' . $name . '">';

    foreach ($obj['data'] as $data) {
        $output .= '<option value="' . $data['value'] . '">' . $data['desc'] . '</option>';
    }

    $output .= '</select>';
    $output .= '<span class="error invalid-feedback error' . ucfirst($name) . '"></span>';

    return $output;
}

function apiDropdownSetFscsyr()
{
    $server3 = $_ENV['APP_API3'];
    $url = "{$server3}/api/gldropdown/glcoa/fscsyr";
    $query = ['action' => 'fscsyr'];

    $response = akses_restapikey('GET', $url, $body = [], $query);
    return json_decode($response, true);
}

function getDropdownFscsyr($key, $name)
{
    $obj = apiDropdownSetFscsyr($key);

    $output = '<select class="form-control form-control-sm" name="' . $name . '" id="' . $name . '">';

    foreach ($obj['data'] as $data) {
        $output .= '<option value="' . $data['value'] . '">' . $data['desc'] . '</option>';
    }

    $output .= '</select>';
    $output .= '<span class="error invalid-feedback error' . ucfirst($name) . '"></span>';

    return $output;
}
// ---------- End Create By Rifa | Menu GL Coa ----------

// ---------- Start Create By Rifa | Menu GL Option Address ----------
function getDropdownCountryFilterIn($key, $name, $filter)
{
    $obj = apiDropdown($key);

    $output = '';
    $output .= '
            <select class="form-control form-control-md" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
        ';

    foreach ($obj as $data) {

        if (in_array($data['fld_valu'], $filter)) {
            $output .= '
                    <option value="' . $data['fld_valu'] . '">' . $data['fld_desc'] . '</option>
        ';
        }
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        ';

    return $output;
}
// ---------- End Create By Rifa | Menu GL Option Address ----------

// ---------- Start Create By Rifa | Menu GL Option Posting ----------
function apiDropdownSrceLedgerGlOptionPosting()
{
    $server3 = $_ENV['APP_API3'];
    $url = "{$server3}/api/gldropdown/gloptionposting/srceledger";
    $query = ['action' => 'srceledgergloptionposting'];

    $response = akses_restapikey('GET', $url, $body = [], $query);
    return json_decode($response, true);
}

function getDropdownSrceLedgerGlOptionPosting($key, $name)
{
    $obj = apiDropdownSrceLedgerGlOptionPosting($key);

    $output = '<select class="form-control form-control-sm" name="' . $name . '" id="' . $name . '">';
    $output .= '<option value="">--Select--</option>';

    foreach ($obj['data'] as $data) {
        $output .= '<option value="' . $data['value'] . '">' . $data['desc'] . '</option>';
    }

    $output .= '</select>';
    $output .= '<span class="error invalid-feedback error' . ucfirst($name) . '"></span>';

    return $output;
}

function apiDropdownSrceTypeGlOptionPosting()
{
    $server3 = $_ENV['APP_API3'];
    $url = "{$server3}/api/gldropdown/gloptionposting/srcetype";
    $query = ['action' => 'srcetypegloptionposting'];

    $response = akses_restapikey('GET', $url, $body = [], $query);
    return json_decode($response, true);
}

function getDropdownSrceTypeGlOptionPosting($key, $name)
{
    $obj = apiDropdownSrceTypeGlOptionPosting($key);

    $output = '<select class="form-control form-control-sm" name="' . $name . '" id="' . $name . '">';
    $output .= '<option value="">--Select--</option>';

    foreach ($obj['data'] as $data) {
        $output .= '<option value="' . $data['value'] . '">' . $data['desc'] . '</option>';
    }

    $output .= '</select>';
    $output .= '<span class="error invalid-feedback error' . ucfirst($name) . '"></span>';

    return $output;
}

function apiDropdownFunctionalCurrency()
{
    $server3 = $_ENV['APP_API3'];
    $url = "{$server3}/api/gldropdown/gloptionposting/functionalcurrency";
    $query = ['action' => 'functionalcurrency'];

    $response = akses_restapikey('GET', $url, $body = [], $query);
    return json_decode($response, true);
}

function getDropdownFunctionalCurrency($key, $name)
{
    $obj = apiDropdownFunctionalCurrency($key);

    $output = '<select class="form-control form-control-sm" name="' . $name . '" id="' . $name . '">';
    $output .= '<option value="">--Select--</option>';

    foreach ($obj['data'] as $data) {
        $output .= '<option value="' . $data['value'] . '">' . $data['desc'] . '</option>';
    }

    $output .= '</select>';
    $output .= '<span class="error invalid-feedback error' . ucfirst($name) . '"></span>';

    return $output;
}

function apiDropdownDefaultClosingAccount()
{
    $server3 = $_ENV['APP_API3'];
    $url = "{$server3}/api/gldropdown/gloptionposting/defaultclosingaccount";
    $query = ['action' => 'defaultclosingaccount'];

    $response = akses_restapikey('GET', $url, $body = [], $query);
    return json_decode($response, true);
}

function getDropdownDefaultClosingAccount($key, $name)
{
    $obj = apiDropdownDefaultClosingAccount($key);

    $output = '<select class="form-control form-control-sm" name="' . $name . '" id="' . $name . '">';
    $output .= '<option value="">--Select--</option>';

    foreach ($obj['data'] as $data) {
        $output .= '<option value="' . $data['value'] . '">' . $data['desc'] . '</option>';
    }

    $output .= '</select>';
    $output .= '<span class="error invalid-feedback error' . ucfirst($name) . '"></span>';

    return $output;
}
// ---------- End Create By Rifa | Menu GL Option Posting ----------

// ---------- Start Create By Rifa | Menu GL Option Segment ----------
function apiDropdownAccountSegmentGlOptionSegment()
{
    $server3 = $_ENV['APP_API3'];
    $url = "{$server3}/api/gldropdown/gloptionsegment/segmentaccount";
    $query = ['action' => 'segmentaccount'];

    $response = akses_restapikey('GET', $url, $body = [], $query);
    return json_decode($response, true);
}

function getDropdownAccountSegmentGlOptionSegment($key, $name)
{
    $obj = apiDropdownAccountSegmentGlOptionSegment($key);

    $output = '<select class="form-control form-control-sm" name="' . $name . '" id="' . $name . '">';

    foreach ($obj['data'] as $data) {
        $output .= '<option value="' . $data['value'] . '">' . $data['desc'] . '</option>';
    }

    $output .= '</select>';
    $output .= '<span class="error invalid-feedback error' . ucfirst($name) . '"></span>';

    return $output;
}

function apiDropdownSegmentDelimiterGlOptionSegment()
{
    $server3 = $_ENV['APP_API3'];
    $url = "{$server3}/api/gldropdown/gloptionsegment/segmentdelimiter";
    $query = ['action' => 'segmentdelimiter'];

    $response = akses_restapikey('GET', $url, $body = [], $query);
    return json_decode($response, true);
}

function getDropdownSegmentDelimiterGlOptionSegment($key, $name)
{
    $obj = apiDropdownSegmentDelimiterGlOptionSegment($key);

    $output = '<select class="form-control form-control-sm" name="' . $name . '" id="' . $name . '">';

    foreach ($obj['data'] as $data) {
        $output .= '<option value="' . $data['value'] . '">' . $data['desc'] . '</option>';
    }

    $output .= '</select>';
    $output .= '<span class="error invalid-feedback error' . ucfirst($name) . '"></span>';

    return $output;
}

function apiDropdownDefaultStructureCodeGlOptionSegment()
{
    $server3 = $_ENV['APP_API3'];
    $url = "{$server3}/api/gldropdown/gloptionsegment/defaultstructurecode";
    $query = ['action' => 'defaultstructurecode'];

    $response = akses_restapikey('GET', $url, $body = [], $query);
    return json_decode($response, true);
}

function getDropdownDefaultStructureCodeGlOptionSegment($key, $name)
{
    $obj = apiDropdownDefaultStructureCodeGlOptionSegment($key);

    $output = '<select class="form-control form-control-sm" name="' . $name . '" id="' . $name . '">';

    foreach ($obj['data'] as $data) {
        $output .= '<option value="' . $data['value'] . '">' . $data['desc'] . '</option>';
    }

    $output .= '</select>';
    $output .= '<span class="error invalid-feedback error' . ucfirst($name) . '"></span>';

    return $output;
}
// ---------- End Create By Rifa | Menu GL Option Segment ----------

// ---------- Start Create By RIfa | Menu GL Option Email ----------
function getDropdownGlOptionEmailService($key, $name)
{
    $obj = apiDropdown($key);
    $output = '';
    $output .= '
            <select class="form-control form-control-md" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
        ';

    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['fld_valu'] . '">' . $data['fld_desc'] . '</option>
        ';
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        ';

    return $output;
}
// ---------- End Create By RIfa | Menu GL Option Email ----------

// ---------- Start Create By Rifa | Menu GL Batch List ----------
function apiDropdownSourceLedgerTypeGlJe()
{
    $server3 = $_ENV['APP_API3'];
    $url = "{$server3}/api/gldropdown/tmstglsourceledger/sourceledgertypeglje";
    $query = ['action' => 'sourceledgertypeglje'];

    $response = akses_restapikey('GET', $url, $body = [], $query);
    return json_decode($response, true);
}

function getDropdownSourceLedgerTypeGlJe($name)
{
    $obj = apiDropdownSourceLedgerTypeGlJe();

    $output  = '<select class="form-control form-control-sm" ';
    $output .= 'name="' . $name . '" id="' . $name . '">';

    if (!empty($obj['data'])) {
        foreach ($obj['data'] as $data) {
            $output .= '<option value="' . $data['value'] . '">'
                . $data['desc']
                . '</option>';
        }
    }

    $output .= '</select>';
    $output .= '<span class="error invalid-feedback error' . ucfirst($name) . '"></span>';

    return $output;
}

function apiDropdownSourceLedgerJE()
{
    $server3 = $_ENV['APP_API3'];
    $url = "{$server3}/api/gldropdown/tmstglsourceledger/sourceledgerglje";
    $query = ['action' => 'sourceledgerglje'];

    $response = akses_restapikey('GET', $url, $body = [], $query);
    return json_decode($response, true);
}

function getDropdownSourceLedgerGLJE($name)
{
    $obj = apiDropdownSourceLedgerJE();

    $output  = '<select class="form-control form-control-sm" ';
    $output .= 'name="' . $name . '" id="' . $name . '">';

    if (!empty($obj['data'])) {
        foreach ($obj['data'] as $data) {
            $output .= '<option value="' . $data['value'] . '">'
                . $data['desc']
                . '</option>';
        }
    }

    $output .= '</select>';
    $output .= '<span class="error invalid-feedback error' . ucfirst($name) . '"></span>';

    return $output;
}

function apiDropdownSourceLedger()
{
    $server3 = $_ENV['APP_API3'];
    $url = "{$server3}/api/gldropdown/tmstglsourceledger";
    $query = ['action' => 'sourceledger'];

    $response = akses_restapikey('GET', $url, $body = [], $query);
    return json_decode($response, true);
}

function getDropdownSourceLedgerGL($key, $name, $filter)
{
    $obj = apiDropdownSourceLedger($key);

    $output = '<select class="form-control form-control-sm" name="' . $name . '" id="' . $name . '">';

    foreach ($obj['data'] as $data) {
        if (in_array($data['value'], $filter)) {
            $output .= '<option value="' . $data['value'] . '">' . $data['desc'] . '</option>';
        }
    }

    $output .= '</select>';
    $output .= '<span class="error invalid-feedback error' . ucfirst($name) . '"></span>';

    return $output;
}

function getDropdownBatchTypeGlBatch($key, $name, $filter)
{
    $obj = apiDropdown($key);

    $output = '';
    $output .= '
            <select class="form-control form-control-sm" name="' . $name . '" id="' . $name . '">
        ';

    foreach ($obj as $data) {

        if (in_array($data['fld_valu'], $filter)) {
            $output .= '
                    <option value="' . $data['fld_valu'] . '">' . $data['fld_desc'] . '</option>
        ';
        }
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        ';

    return $output;
}

function getDropdownBatchStatusGlBatch($key, $name, $filter)
{
    $obj = apiDropdown($key);

    $output = '';
    $output .= '
            <select class="form-control form-control-sm" name="' . $name . '" id="' . $name . '">
        ';

    foreach ($obj as $data) {

        if (in_array($data['fld_valu'], $filter)) {
            $output .= '
                    <option value="' . $data['fld_valu'] . '">' . $data['fld_desc'] . '</option>
        ';
        }
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        ';

    return $output;
}

function getDropdownBatchStatusPostingGlBatch($key, $name, $filter)
{
    $obj = apiDropdown($key);

    $output = '';
    $output .= '
            <select class="form-control form-control-sm" name="' . $name . '" id="' . $name . '">
        ';

    foreach ($obj as $data) {

        if (in_array($data['fld_valu'], $filter)) {
            $output .= '
                    <option value="' . $data['fld_valu'] . '">' . $data['fld_desc'] . '</option>
        ';
        }
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        ';

    return $output;
}
// ---------- End Create By Rifa | Menu GL Batch List ----------

// ---------- Start Create By Rifa | Menu GL Journal ----------
function apiDropdownCurrencyRateGl()
{
    $server3 = $_ENV['APP_API3'];
    $url = "{$server3}/api/gldropdown/currencyrategl";
    $query = ['action' => 'currencyrategl'];

    $response = akses_restapikey('GET', $url, $body = [], $query);
    return json_decode($response, true);
}

function getDropdownCurrencyRateGl($key, $name)
{
    $obj = apiDropdownCurrencyRateGl($key);

    $output = '';
    $output .= '
        <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%; heigh: 100%;">
            <option value="">--Select--</option>
    ';

    foreach ($obj['data'] as $data) {
        $output .= '<option value="' . $data['currency'] . '" data-convrate="' . $data['rate'] . '">' . $data['currency'] . '</option>';
    }

    $output .= '</select>';
    $output .= '<span class="error invalid-feedback error' . ucfirst($name) . '"></span>';

    return $output;
}

// original tanpa pengkondisian role_cd
// function apiDropdownBatchEntry($key, $batchId = null)
// {
//     $server3 = $_ENV['APP_API3'];
//     $url = "{$server3}/api/gldropdown/entrynumber";

//     $query = ['action' => 'entrynumber', 'Key' => $key];
//     if ($batchId) {
//         $query['BatchId'] = $batchId;
//     }

//     $response = akses_restapikey('GET', $url, [], $query);
//     return json_decode($response, true);
// }

function apiDropdownBatchEntry($key, $batchId = null)
{
    $server3 = $_ENV['APP_API3'];
    $url = "{$server3}/api/gldropdown/entrynumber";

    $query = [
        'action'  => 'entrynumber',
        'Key'     => $key,
        'Role_Cd' => session('role_cd')
    ];

    if ($batchId) {
        $query['BatchId'] = $batchId;
    }

    $response = akses_restapikey('GET', $url, [], $query);
    return json_decode($response, true);
}


function getDropdownBatchEntry($key, $name, $batchId = null)
{
    $obj = apiDropdownBatchEntry($key, $batchId);

    $output = '<select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;">';
    $output .= '<option value="">--Select--</option>';

    $hasValidData = false;

    if (isset($obj['success']) && $obj['success'] && !empty($obj['data'])) {
        foreach ($obj['data'] as $data) {

            $value   = $data['value'];
            $desc    = $data['desc'];
            $batch   = $data['batchid'] ?? $batchId;
            $deleted = (bool)($data['deleted'] ?? false);

            if ($value !== '' && $desc !== '') {

                $deletedClass = $deleted ? 'text-danger fw-bold' : '';
                $deletedIcon  = $deleted ? ' 🗑️' : '';

                $output .= '<option value="' . $value . '" 
                                data-batchid="' . $batch . '" 
                                data-entrynumber="' . $desc . '"
                                data-deleted="' . ($deleted ? '1' : '0') . '"
                                class="' . $deletedClass . '">' .
                    $desc . $deletedIcon .
                    '</option>';

                $hasValidData = true;
            }
        }
    }

    $output .= '</select>';
    return $output;
}

function apiDropdownSrceType($key, $srceLedger = null)
{
    $server3 = $_ENV['APP_API3'];
    $url = "{$server3}/api/gldropdown/gljournal/srcetypegljournal";

    $query = [
        'action' => 'srcetypegljournal',
        'SrceLedger' => $srceLedger
    ];

    $response = akses_restapikey('GET', $url, $body = [], $query);
    $decoded = json_decode($response, true);

    return $decoded;
}

function getDropdownSrceType($key, $name)
{
    $obj = apiDropdownSrceType($key);

    $output = '<select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;">';
    $output .= '<option value="">--Select--</option>';
    $output .= '</select>';
    $output .= '<span class="error invalid-feedback error' . ucfirst($name) . '"></span>';

    return $output;
}

function apiDropdownSourceLedgerDesc($srceLedger = null)
{
    $server3 = $_ENV['APP_API3'];
    $url = "{$server3}/api/gldropdown/gljournal/srceledgergljournal";
    $query = ['action' => 'srceledgergljournal'];

    if ($srceLedger) {
        $query['SrceLedger'] = $srceLedger;
    }

    $response = akses_restapikey('GET', $url, $body = [], $query);
    return json_decode($response, true);
}

function getDropdownSrceLedgerDesc($key, $name, $srceLedger = null)
{
    $obj = apiDropdownSourceLedgerDesc($srceLedger);

    $output = '';
    $output .= '
        <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%; heigh: 100%;">
            <option value="">--Select--</option>
    ';

    foreach ($obj['data'] as $data) {
        $selected = ($srceLedger && $data['value'] == $srceLedger) ? 'selected' : '';
        $output .= '<option value="' . $data['value'] . '" data-srcedesc="' . $data['desc'] . '" ' . $selected . '>' . $data['value'] . '</option>';
    }

    $output .= '</select>';
    $output .= '<span class="error invalid-feedback error' . ucfirst($name) . '"></span>';

    return $output;
}

// original tanpa pengkondisian role_cd
// function apiDropdownBatchNumberInject()
// {
//     $server3 = $_ENV['APP_API3'];
//     $url = "{$server3}/api/gldropdown/gljournal/batchnumberinject";
//     $query = ['action' => 'batchnumberinject'];

//     $response = akses_restapikey('GET', $url, $body = [], $query);
//     return json_decode($response, true);
// }

function apiDropdownBatchNumberInject()
{
    $server3 = $_ENV['APP_API3'];
    $url = "{$server3}/api/gldropdown/gljournal/batchnumberinject";

    $query = [
        'action'  => 'batchnumberinject',
        'Role_Cd' => session('role_cd')
    ];

    $response = akses_restapikey('GET', $url, [], $query);
    return json_decode($response, true);
}

function getDropdownBatchNumberInject($key, $name)
{
    $obj = apiDropdownBatchNumberInject($key);

    $output = '';
    $output .= '
        <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%; heigh: 100%;">
            <option value=""></option>
    ';

    if (is_array($obj)) {
        foreach ($obj['data'] as $data) {
            $selected = '';

            $output .= '
                <option value="' . $data['batchId'] . '" ' . $selected . '
                        data-batchid="' . $data['batchId'] . '" 
                        data-batchdesc="' . $data['batchDesc'] . '" 
                        data-batchstat="' . $data['batchStat'] . '" 
                        data-summarybatchtype="' . $data['summaryBatchType'] . '" 
                        data-summarybatchstatus="' . $data['summaryBatchStatus'] . '" 
                        data-summaryentries="' . $data['summaryEntries'] . '" 
                        data-summarydebits="' . $data['summaryDebits'] . '" 
                        data-summarycredits="' . $data['summaryCredits'] . '" 
                        data-srcledgr="' . $data['srceLedgr'] . '" 
                        data-srcetype="' . $data['srceType'] . '" 
                        data-srcedesc="' . $data['srceDesc'] . '" 
                        data-audtuser="' . $data['audtUser'] . '">' . $data['batchId'] . '</option>
            ';
        }
    }

    $output .= '
        </select>
        <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
    ';

    return $output;
}

function apiDropdownGetLastBatchEntry($key, $batchId = null)
{
    $server3 = $_ENV['APP_API3'];
    $url = "{$server3}/api/gldropdown/gljournal/getlastbatchentry";

    $query = [
        'action' => 'getlastbatchentry',
        'BatchId' => $batchId
    ];

    $response = akses_restapikey('GET', $url, $body = [], $query);
    $decoded = json_decode($response, true);

    return $decoded;
}

function apiDropdownStartRangeBatchEntry()
{
    $server3 = $_ENV['APP_API3'];
    $url = "{$server3}/api/gldropdown/gljournal/startrangebatchentry";

    $response = akses_restapikey('GET', $url);
    return json_decode($response, true);
}

function getDropdownStartRangeBatchEntry($key, $name)
{
    $obj = apiDropdownStartRangeBatchEntry();

    $output = '<select class="form-control form-control-sm" name="' . $name . '" id="' . $name . '">';
    $output .= '<option value="">--Select--</option>';

    if (!empty($obj['data'])) {
        foreach ($obj['data'] as $data) {
            if (isset($data['batchEntry'])) {
                $batchEntry = htmlspecialchars($data['batchEntry']);
                $output .= '<option value="' . $batchEntry . '">' . $batchEntry . '</option>';
            }
        }
    } else {
        $output .= '<option value="">--No data--</option>';
    }

    $output .= '</select>';
    $output .= '<span class="error invalid-feedback error' . ucfirst($name) . '"></span>';

    return $output;
}

function apiDropdownEndRangeBatchEntry()
{
    $server3 = $_ENV['APP_API3'];
    $url = "{$server3}/api/gldropdown/gljournal/endrangebatchentry";

    $response = akses_restapikey('GET', $url);
    return json_decode($response, true);
}

function getDropdownEndRangeBatchEntry($key, $name)
{
    $obj = apiDropdownEndRangeBatchEntry();

    $output = '<select class="form-control form-control-sm" name="' . $name . '" id="' . $name . '">';
    $output .= '<option value="">--Select--</option>';

    if (!empty($obj['data'])) {
        foreach ($obj['data'] as $data) {
            if (isset($data['batchEntry'])) {
                $batchEntry = htmlspecialchars($data['batchEntry']);
                $output .= '<option value="' . $batchEntry . '">' . $batchEntry . '</option>';
            }
        }
    } else {
        $output .= '<option value="">--No data--</option>';
    }

    $output .= '</select>';
    $output .= '<span class="error invalid-feedback error' . ucfirst($name) . '"></span>';

    return $output;
}
// ---------- End Create By Rifa | Menu GL Journal ----------

// ---------------------------------------- End Dropdown By Rifaaa ----------------------------------------


// ---------- Start Create By Yoyo | Menu Menus ----------
function apiDropdownGetParentMenu($key)
{
    $server3 = $_ENV['APP_API3'];
    $url = "{$server3}/api/dropdown/parentmenu";

    $query = [
        'action' => 'parentmenu'
    ];

    $response = akses_restapikey('GET', $url, [], $query);
    return json_decode($response, true);
}

function apiDropdownGetListReport($key)
{
    $server4 = $_ENV['APP_API4'];
    $url = "{$server4}/api/reports/list";

    $query = [
        'group' => $key
    ];

    $response = akses_restapikey('GET', $url, [], $query);
    return json_decode($response, true);
}

function getDropdownGetListReport($key, $name)
{
    $obj = apiDropdownGetListReport($key);

    $output = '<select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;">';
    $output .= '<option value="">--SELECT--</option>';

    // Asumsi: $obj['data'] adalah array of strings seperti ["file1.rpt", "file2.rpt"]
    if (isset($obj['data']) && is_array($obj['data'])) {
        foreach ($obj['data'] as $fileName) {
            // Pastikan $fileName adalah string
            if (is_string($fileName)) {
                // Untuk value: gunakan nama file lengkap
                // Untuk display: hilangkan ekstensi .rpt
                $displayName = str_replace('.rpt', '', $fileName);
                $displayName = str_replace('.RPT', '', $displayName);

                $output .= '<option value="' . htmlspecialchars($fileName) . '">' . htmlspecialchars($displayName) . '</option>';
            }
        }
    } else {
        $output .= '<option value="">Data tidak tersedia</option>';
    }

    $output .= '</select>';
    $output .= '<span class="error invalid-feedback error' . ucfirst($name) . '"></span>';

    return $output;
}

function apiDropdownGetListReport2($key)
{
    $server4 = $_ENV['APP_API4'];
    $url = "{$server4}/api/reports/list2";

    $query = [
        'group' => $key
    ];

    $response = akses_restapikey('GET', $url, [], $query);
    return json_decode($response, true);
}

function getDropdownGetListReport2($key, $name)
{
    $obj = apiDropdownGetListReport2($key);

    $output = '<select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;">';
    $output .= '<option value="">--SELECT--</option>';

    // Asumsi: $obj['data'] adalah array of strings seperti ["file1.rpt", "file2.rpt"]
    if (isset($obj['data']) && is_array($obj['data'])) {
        foreach ($obj['data'] as $fileName) {
            // Pastikan $fileName adalah string
            if (is_string($fileName)) {
                // Untuk value: gunakan nama file lengkap
                // Untuk display: hilangkan ekstensi .rpt
                $displayName = str_replace('.rpt', '', $fileName);
                $displayName = str_replace('.RPT', '', $displayName);

                $output .= '<option value="' . htmlspecialchars($fileName) . '">' . htmlspecialchars($displayName) . '</option>';
            }
        }
    } else {
        $output .= '<option value="">Data tidak tersedia</option>';
    }

    $output .= '</select>';
    $output .= '<span class="error invalid-feedback error' . ucfirst($name) . '"></span>';

    return $output;
}

function apiDropdownGetListReport3($key)
{
    $server4 = $_ENV['APP_API4'];
    $url = "{$server4}/api/reports/list3";

    $query = [
        'group' => $key
    ];

    $response = akses_restapikey('GET', $url, [], $query);
    return json_decode($response, true);
}

function getDropdownGetListReport3($key, $name)
{
    $obj = apiDropdownGetListReport3($key);

    $output = '<select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '">';
    $output .= '<option value="">--SELECT--</option>';

    // Asumsi: $obj['data'] adalah array of strings seperti ["file1.rpt", "file2.rpt"]
    if (isset($obj['data']) && is_array($obj['data'])) {
        foreach ($obj['data'] as $fileName) {
            // Pastikan $fileName adalah string
            if (is_string($fileName)) {
                // Untuk value: gunakan nama file lengkap
                // Untuk display: hilangkan ekstensi .rpt
                $displayName = str_replace('.rpt', '', $fileName);
                $displayName = str_replace('.RPT', '', $displayName);

                $output .= '<option value="' . htmlspecialchars($fileName) . '">' . htmlspecialchars($displayName) . '</option>';
            }
        }
    } else {
        $output .= '<option value="">Data tidak tersedia</option>';
    }

    $output .= '</select>';
    $output .= '<span class="error invalid-feedback error' . ucfirst($name) . '"></span>';

    return $output;
}


// function getDropdownGetParentMenu($key, $name, $label, $label_size, $input_size)
// {
//     $obj = apiDropdownGetParentMenu($key);

//     $output = '';
//     $output .= '
//         <label for="' . $name . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
//         <div class="col-sm-' . $input_size . '">
//             <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
//                 <option value="">--ROOT--</option>
//         ';

//     foreach ($obj['data'] as $data) {
//         $output .= '
//                     <option value="' . $data['value'] . '">' . $data['desc'] . '</option>
//         ';
//     }
//     $output .= '
//             </select>
//             <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
//         </div>
//         ';

//     return $output;
// }

function getDropdownNolabelHorizontal2($name)
{
    $obj = apiDropdown($name);

    // Pastikan urut numerik ASC berdasarkan fld_valu
    usort($obj, function ($a, $b) {
        return (int)$a['fld_valu'] <=> (int)$b['fld_valu'];
    });

    // dd($obj);
    $output = '';
    $output .= '
       
            <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width:100%">
                <option value=" ">--Select--</option>
        ';

    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['fld_valu'] . '">' . $data['fld_desc'] . '</option>
        ';
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        ';

    return $output;
}

function getJenisPembayaranDropdown()
{
    helper(['restclient']);

    $url = "{$_ENV['APP_API3']}/api/jenisPembayaran";
    $query = ['action' => 'getall'];

    $response = akses_restapikey('GET', $url, [], $query);
    $result = json_decode($response, true);

    $options = '<option value="">-- Pilih Jenis Pembayaran --</option>';

    if (isset($result['data']) && is_array($result['data'])) {
        foreach ($result['data'] as $item) {
            $options .= '<option value="' . $item['jenisPembayaranId'] . '">' .
                htmlspecialchars($item['jenisPembayaranNm']) . '</option>';
        }
    }

    return '<select class="form-control form-control-sm select2" id="jenisPembayaranId" name="jenisPembayaranId" style="width: 100%;">' .
        $options . '</select>';
}

function getDropdownGetParentMenu($key, $name)
{
    $obj = apiDropdownGetParentMenu($key);

    $output = '<select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '">';
    $output .= '<option value="">--ROOT--</option>';
    foreach ($obj['data'] as $data) {
        $output .= '<option value="' . $data['value'] . '">' . $data['desc'] . '</option>';
    }

    $output .= '</select>';
    $output .= '<span class="error invalid-feedback error' . ucfirst($name) . '"></span>';

    return $output;
}

// ---------- End Create By Yoyo | Menu Menus ----------

// ---------- Start Create By Yoyo | Menu Menus ----------
function apiDropdownGetMenu($key)
{
    $server3 = $_ENV['APP_API3'];
    $url = "{$server3}/api/dropdown/menu";

    $query = [
        'action' => 'menu'
    ];

    $response = akses_restapikey('GET', $url, [], $query);
    return json_decode($response, true);
}

function getDropdownGetMenu($name, $label, $label_size, $input_size)
{
    $obj = apiDropdownGetMenu($name);

    // $output = '<select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '">';
    // $output .= '<option value="">--ROOT--</option>';
    // foreach ($obj['data'] as $data) {
    //     $output .= '<option value="' . $data['value'] . '">' . $data['desc'] . '</option>';
    // }

    // $output .= '</select>';
    // $output .= '<span class="error invalid-feedback error' . ucfirst($name) . '"></span>';

    // return $output;

    $output = '';
    $output .= '
        <label for="' . $name . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
        <div class="col-sm-' . $input_size . '">
            <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';

    foreach ($obj['data'] as $data) {
        $output .= '
                    <option value="' . $data['value'] . '">' . $data['desc'] . '</option>
        ';
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        </div>
        ';

    return $output;
}

// ---------- End Create By Yoyo | Menu Menu Role ----------


function apiDropdownGetSourceAccount($key)
{
    $server3 = $_ENV['APP_API3'];
    $url = "{$server3}/api/gldropdown/glallocation/sourceaccount";

    $query = [
        'action' => 'sourceaccount'
    ];

    $response = akses_restapikey('GET', $url, [], $query);
    return json_decode($response, true);
}

function getDropdownGetSourceAccount($name)
{
    $obj = apiDropdownGetSourceAccount($name);

    $output = '<select class="form-control form-control-sm select2" name="params[' . $name . ']" id="' . $name . '" style="width: 100%;">';
    $output .= '<option value="">--SELECT--</option>';

    foreach ($obj['data'] as $data) {
        $output .= '<option value="' . $data['value'] . '">' . $data['value'] . ' - ' . $data['desc'] . '</option>';
    }

    $output .= '</select>';
    $output .= '<span class="error invalid-feedback error' . ucfirst($name) . '"></span>';
    return $output;
}


function apiDropdownCaraBayar()
{
    $server = $_ENV['APP_API'];

    // helper curl request
    helper(['restclient']);
    // endpoint
    $url = "$server/dropdown/carabayar";
    // client request
    $response = akses_restapi('GET', $url, []);
    $data['response_data'] = json_decode($response, true);
    return $data['response_data'];
}

function getDropdownCaraBayarCustom($key, $name, $label, $label_size, $input_size)
{
    $obj = apiDropdownGlCoa($key);

    $output = '';
    $output .= '
        <label for="' . $name . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
        <div class="col-sm-' . $input_size . '">
            <select class="form-control form-control-sm select2custom" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';

    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['kodeCaraBayar'] . '"  data-kodecarabayar="' . $data['kodeCaraBayar'] . '" data-descriptioncarabayar="' . $data['descriptionCaraBayar'] . '">' . $data['kodeCaraBayar'] . ' - ' . $data['descriptionCaraBayar'] . '</option>
        ';
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        </div>
        ';

    return $output;
}


function apiDropdownGlCoa()
{
    $server = $_ENV['APP_API'];

    // helper curl request
    helper(['restclient']);
    // endpoint
    $url = "$server/dropdown/glcoa";
    // client request
    $response = akses_restapi('GET', $url, []);
    $data['response_data'] = json_decode($response, true);
    return $data['response_data'];
}

function getDropdownGlCoaCustom($key, $name, $label, $label_size, $input_size)
{
    $obj = apiDropdownGlCoa($key);

    $output = '';
    $output .= '
        <label for="' . $name . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
        <div class="col-sm-' . $input_size . '">
            <select class="form-control form-control-sm select2custom" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';

    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['acctNo'] . '"  data-acctno="' . $data['acctNo'] . '" data-desc="' . $data['acctName'] . '" data-acctname="' . $data['acctName'] . '" data-accttype="' . $data['acctType'] . '" data-fulltext="' . $data['acctNo'] . ' - ' . $data['acctName'] . '">' . $data['acctNo'] . ' - ' . $data['acctName'] . '</option>
        ';
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        </div>
        ';

    return $output;
}

function getDropdownCustomID($key, $name, $label, $label_size, $input_size)
{
    $obj = apiDropdown($key);
    // dd($obj);
    $output = '';
    $output .= '
        <label for="' . $name . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
        <div class="col-sm-' . $input_size . '">
            <select class="form-control form-control-sm select2custom" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';

    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['fld_valu'] . '" data-id="' . $data['fld_valu'] . '" data-desc="' . $data['fld_desc'] . '" data-fulltext="' . $data['fld_valu'] . ' - ' . $data['fld_desc'] . '">' . $data['fld_valu'] . ' - ' . $data['fld_desc'] . '</option>
        ';
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        </div>
        ';

    return $output;
}

function apiDropdownGlSegmentSeqTree($seq)
{
    $server = $_ENV['APP_API'];

    // helper curl request
    helper(['restclient']);
    // endpoint
    $url = "$server/dropdown/glsegment/$seq";
    // client request
    $response = akses_restapi('GET', $url, []);
    $data['response_data'] = json_decode($response, true);
    return $data['response_data'];
}

function getDropdownGlSegmentSeqCustomTree($seq, $name)
{
    $obj = apiDropdownGlSegmentSeqTree($seq);

    $output = '';
    $output .= '
            <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';
    if ($seq != ' ') {
        foreach ($obj as $data) {
            $output .= '
                    <option value="' . $data['segmentVaLNo'] . '" data-segmentvalno="' . $data['segmentVaLNo'] . '" data-segmentvalname="' . $data['segmentVaLName'] . '">' . $data['segmentVaLNo'] . ' - ' . $data['segmentVaLName'] . '</option>
        ';
        }
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        ';

    return $output;
}

function apiDropdownGlActGroup()
{
    $server = $_ENV['APP_API'];

    // helper curl request
    helper(['restclient']);
    // endpoint
    $url = "$server/dropdown/glactgroup";
    // client request
    $response = akses_restapi('GET', $url, []);
    $data['response_data'] = json_decode($response, true);
    return $data['response_data'];
}

function getDropdownGlActGroupCustom($key, $name, $label, $label_size, $input_size)
{
    $obj = apiDropdownGlActGroup($key);

    $output = '';
    $output .= '
        <label for="' . $name . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
        <div class="col-sm-' . $input_size . '">
            <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';

    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['accGrID'] . '"  data-accgrid="' . $data['accGrID'] . '" data-accrgrline="' . $data['accrGrLine'] . '" data-accgrname="' . $data['accGrName'] . '">' . $data['accGrName'] . '</option>
        ';
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        </div>
        ';

    return $output;
}


function getDropdownGlActStrucCustom($key, $name, $label, $label_size, $input_size)
{
    $obj = apiDropdownGlActStruc($key);

    $output = '';
    $output .= '
        <label for="' . $name . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
        <div class="col-sm-' . $input_size . '">
            <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';

    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['structureID'] . '"  data-structurename="' . $data['structureName'] . '" data-seglvid1="' . $data['segLvId1'] . '" data-seglvstrt1="' . $data['segLvStrt1'] . '" data-seglvsp1="' . $data['segLvSp1'] . '" data-seglvid2="' . $data['segLvId2'] . '" data-seglvstrt2="' . $data['segLvStrt2'] . '" data-seglvsp2="' . $data['segLvSp2'] . '" data-seglvid3="' . $data['segLvId3'] . '" data-seglvstrt3="' . $data['segLvStrt3'] . '" data-seglvsp3="' . $data['segLvSp3'] . '" data-seglvid4="' . $data['segLvId4'] . '" data-seglvstrt4="' . $data['segLvStrt4'] . '" data-seglvsp4="' . $data['segLvSp4'] . '" data-seglvid5="' . $data['segLvId5'] . '" data-seglvstrt5="' . $data['segLvStrt5'] . '" data-seglvsp5="' . $data['segLvSp5'] . '">' . $data['structureID'] . '</option>
        ';
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        </div>
        ';

    return $output;
}

function getDropdownGlActStrucNolabelVertical($name)
{
    $obj = apiDropdownGlActStruc($name);

    $output = '';
    $output .= '
        
            <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';

    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['structureID'] . '"  data-structurename="' . $data['structureName'] . '" data-seglvid1="' . $data['segLvId1'] . '" data-seglvstrt1="' . $data['segLvStrt1'] . '" data-seglvsp1="' . $data['segLvSp1'] . '" data-seglvid2="' . $data['segLvId2'] . '" data-seglvstrt2="' . $data['segLvStrt2'] . '" data-seglvsp2="' . $data['segLvSp2'] . '" data-seglvid3="' . $data['segLvId3'] . '" data-seglvstrt3="' . $data['segLvStrt3'] . '" data-seglvsp3="' . $data['segLvSp3'] . '" data-seglvid4="' . $data['segLvId4'] . '" data-seglvstrt4="' . $data['segLvStrt4'] . '" data-seglvsp4="' . $data['segLvSp4'] . '" data-seglvid5="' . $data['segLvId5'] . '" data-seglvstrt5="' . $data['segLvStrt5'] . '" data-seglvsp5="' . $data['segLvSp5'] . '">' . $data['structureID'] . '</option>
        ';
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        
        ';

    return $output;
}

function apiDropdownGlActStruc()
{
    $server = $_ENV['APP_API'];

    // helper curl request
    helper(['restclient']);
    // endpoint
    $url = "$server/dropdown/glactstruct";
    // client request
    $response = akses_restapi('GET', $url, []);
    $data['response_data'] = json_decode($response, true);
    return $data['response_data'];
}

function getDropdownGlSegmentNolabelVertical($name)
{
    $obj = apiDropdownGlSegment($name);

    $output = '';
    $output .= '
        
            <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';

    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['segmentID'] . '"  data-segmentseq="' . $data['segmentSeq'] . '" data-segmentid="' . $data['segmentID'] . '" data-segmentname="' . $data['segmentName'] . '" data-segmentmain="' . $data['segmentMain'] . '" data-segmentlen="' . $data['segmentLen'] . '">' . $data['segmentID'] . '</option>
        ';
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        
        ';

    return $output;
}

function apiDropdownGlSegment()
{
    $server = $_ENV['APP_API'];

    // helper curl request
    helper(['restclient']);
    // endpoint
    $url = "$server/dropdown/glsegment";
    // client request
    $response = akses_restapi('GET', $url, []);
    $data['response_data'] = json_decode($response, true);
    return $data['response_data'];
}

function getDropdownGlSegmentCustom($key, $name, $label, $label_size, $input_size)
{
    $obj = apiDropdownGlSegment($key);

    $output = '';
    $output .= '
        <label for="' . $name . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
        <div class="col-sm-' . $input_size . '">
            <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';

    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['segmentID'] . '"  data-segmentseq="' . $data['segmentSeq'] . '" data-segmentid="' . $data['segmentID'] . '" data-segmentname="' . $data['segmentName'] . '" data-segmentmain="' . $data['segmentMain'] . '" data-segmentlen="' . $data['segmentLen'] . '">' . $data['segmentID'] . '</option>
        ';
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        </div>
        ';

    return $output;
}

function apiDropdownTypePasien()
{
    $server = $_ENV['APP_API'];

    // helper curl request
    helper(['restclient']);
    // endpoint
    $url = "$server/dropdown/typepasien";
    // client request
    $response = akses_restapi('GET', $url, []);
    $data['response_data'] = json_decode($response, true);
    return $data['response_data'];
}

function getDropdownTypePasienCustom($key, $name, $label, $label_size, $input_size)
{
    $obj = apiDropdownTypePasien($key);

    $output = '';
    $output .= '
        <label for="' . $name . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
        <div class="col-sm-' . $input_size . '">
            <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';

    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['type_pasien_cd'] . '">' . $data['type_pasien_nm'] . '</option>
        ';
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        </div>
        ';

    return $output;
}

function apiDropdownJenisPembayaran()
{
    $server = $_ENV['APP_API'];

    // helper curl request
    helper(['restclient']);
    // endpoint
    $url = "$server/dropdown/jenispembayaran";
    // client request
    $response = akses_restapi('GET', $url, []);
    $data['response_data'] = json_decode($response, true);
    return $data['response_data'];
}

function getDropdownJenisPembayaranCustom($key, $name, $label, $label_size, $input_size)
{
    $obj = apiDropdownJenisPembayaran($key);

    $output = '';
    $output .= '
        <label for="' . $name . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
        <div class="col-sm-' . $input_size . '">
            <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';

    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['jenis_pembayaran_cd'] . '">' . $data['jenis_pembayaran_nm'] . '</option>
        ';
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        </div>
        ';

    return $output;
}

function apiDropdownSupplier()
{
    $server = $_ENV['APP_API'];

    // helper curl request
    helper(['restclient']);
    // endpoint
    $url = "$server/dropdown/supplier";
    // client request
    $response = akses_restapi('GET', $url, []);
    $data['response_data'] = json_decode($response, true);
    return $data['response_data'];
}

function getDropdownSupplierCustom($key, $name, $label, $label_size, $input_size)
{
    $obj = apiDropdownSupplier($key);

    $output = '';
    $output .= '
        <label for="' . $name . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
        <div class="col-sm-' . $input_size . '">
            <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';

    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['supplierID'] . '">' . $data['namaSupplier'] . '</option>
        ';
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        </div>
        ';

    return $output;
}

function apiDropdownPrincipal()
{
    $server = $_ENV['APP_API'];

    // helper curl request
    helper(['restclient']);
    // endpoint
    $url = "$server/dropdown/principal";
    // client request
    $response = akses_restapi('GET', $url, []);
    $data['response_data'] = json_decode($response, true);
    return $data['response_data'];
}

function getDropdownPrincipalCustom($key, $name, $label, $label_size, $input_size)
{
    $obj = apiDropdownPrincipal($key);

    $output = '';
    $output .= '
        <label for="' . $name . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
        <div class="col-sm-' . $input_size . '">
            <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';

    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['principal_cd'] . '">' . $data['principal_nm'] . '</option>
        ';
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        </div>
        ';

    return $output;
}

// dropdown kota dengan key dan filter
function getDropdownKotaCustomFilter($key, $name, $label, $label_size, $input_size, $filter)
{
    $obj = apiDropdownKota($key);

    // dd($obj);
    $output = '';
    $output .= '
        <label for="' . $name . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
        <div class="col-sm-' . $input_size . '">
            <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';

    foreach ($obj as $data) {

        if (!in_array($data['id'], $filter)) {
            $output .= '
                    <option value="' . $data['id'] . '">' . $data['nama'] . '</option>
        ';
        }
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        </div>
        ';

    return $output;
}

// dropdown dengan key dan filter
function getDropdownObatCustomFilter($key, $name, $label, $label_size, $input_size, $filter)
{
    $obj = apiDropdownObat($key);

    // dd($obj);
    $output = '';
    $output .= '
        <label for="' . $name . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
        <div class="col-sm-' . $input_size . '">
            <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';

    foreach ($obj as $data) {

        if (!in_array($data['obat_cd'], $filter)) {
            $output .= '
                    <option value="' . $data['obat_cd'] . '">' . $data['obat'] . '</option>
        ';
        }
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        </div>
        ';

    return $output;
}

function getDropdownPasienSearch($name, $label, $label_size, $input_size)
{
    $obj = apiDropdownPasien($name);
    $output = '';
    $output .= '
        <label for="' . $name . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
        <div class="col-sm-' . $input_size . '">
            <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value="all" selected>--ALL--</option>
        ';

    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['patient_no'] . '">' . $data['fullname'] . '</option>
        ';
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        </div>
        ';

    return $output;
}

function getDropdownNolabelVerticalTitikKeluhan($name)
{
    $obj = apiDropdown($name);

    // Pastikan urut numerik ASC berdasarkan fld_valu
    usort($obj, function ($a, $b) {
        return (int)$a['fld_valu'] <=> (int)$b['fld_valu'];
    });

    $output = '';
    $output .= '
        
            <select class="form-control form-control-sm select2 ' . $name . '" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';

    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['fld_valu'] . '">' . $data['fld_desc'] . '</option>
        ';
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        
        ';
    $output .= '
            <script type="text/javascript">
            $(document).on("change", "."' . $name . '", function(e) {
            var val = $(this).val();
            var link, linkimg;
        ';
    foreach ($obj as $data) {
        $output .= '
            if (val == "' . $data['fld_valu'] . '") {
                link = "/konsultasidokter/draw1";
                linkimg = "/dist/img/"+' . $data['fld_valu'] . '+".jpg";
                window.open(link,"_blank");
            }
        ';
    }
    $output .= '
            else {
                link = "/konsultasidokter/draw1";
                linkimg = "/dist/img/Blank.jpg";
            }
            $("."' . $name . '").attr("src", linkimg);
            });
            </script>
        ';

    return $output;
}

function getDropdownNolabelVertical($name)
{
    $obj = apiDropdown($name);

    // Pastikan urut numerik ASC berdasarkan fld_valu
    usort($obj, function ($a, $b) {
        return (int)$a['fld_valu'] <=> (int)$b['fld_valu'];
    });

    $output = '';
    $output .= '
        
            <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';

    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['fld_valu'] . '">' . $data['fld_desc'] . '</option>
        ';
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        
        ';

    return $output;
}

function getDropdownNolabelVertical2($key, $name)
{
    $obj = apiDropdown($key);

    // Pastikan urut numerik ASC berdasarkan fld_valu
    usort($obj, function ($a, $b) {
        return (int)$a['fld_valu'] <=> (int)$b['fld_valu'];
    });

    $output = '';
    $output .= '
        
            <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';

    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['fld_valu'] . '">' . $data['fld_desc'] . '</option>
        ';
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        
        ';

    return $output;
}

function getDropdownNolabelVerticalWithoutName($name)
{
    $obj = apiDropdown($name);

    // Pastikan urut numerik ASC berdasarkan fld_valu
    usort($obj, function ($a, $b) {
        return (int)$a['fld_valu'] <=> (int)$b['fld_valu'];
    });

    $output = '';
    $output .= '
        
            <select class="form-control form-control-sm select2" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';

    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['fld_valu'] . '">' . $data['fld_desc'] . '</option>
        ';
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        
        ';

    return $output;
}

function apiDropdownItemLaboratorium()
{
    $server = $_ENV['APP_API'];

    // helper curl request
    helper(['restclient']);
    // endpoint
    $url = "$server/dropdown/itemlaboratorium";
    // client request
    $response = akses_restapi('GET', $url, []);
    $data['response_data'] = json_decode($response, true);
    return $data['response_data'];
}

function getDropdownItemLaboratoriumCustom($key, $name, $label, $label_size, $input_size)
{
    $obj = apiDropdownItemLaboratorium($key);

    $output = '';
    $output .= '
        <label for="' . $name . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
        <div class="col-sm-' . $input_size . '">
            <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value="-">--Select--</option>
        ';

    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['kd_item'] . '">' . $data['nama_item'] . '</option>
        ';
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        </div>
        ';

    return $output;
}

function apiDropdownDiagnosa()
{
    $server = $_ENV['APP_API'];

    // helper curl request
    helper(['restclient']);
    // endpoint
    $url = "$server/dropdown/diagnosa";
    // client request
    $response = akses_restapi('GET', $url, []);
    $data['response_data'] = json_decode($response, true);
    return $data['response_data'];
}

function apiDropdownPolyclinic()
{
    $server = $_ENV['APP_API'];

    // helper curl request
    helper(['restclient']);
    // endpoint
    $url = "$server/dropdown/polyclinic";
    // client request
    $response = akses_restapi('GET', $url, []);
    $data['response_data'] = json_decode($response, true);
    return $data['response_data'];
}

function getDropdownPolyclinicCustom($key, $name, $label, $label_size, $input_size)
{
    $obj = apiDropdownPolyclinic($key);

    $output = '';
    $output .= '
        <label for="' . $name . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
        <div class="col-sm-' . $input_size . '">
            <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';

    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['poly_cd'] . '">' . $data['poly_nm'] . '</option>
        ';
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        </div>
        ';

    return $output;
}

function apiDropdown($nama)
{
    $server = $_ENV['APP_API'];

    // helper curl request
    helper(['restclient']);
    // endpoint
    $url = "$server/dropdown/tfield_value/$nama";
    // client request
    $response = akses_restapi('GET', $url, []);
    $data['response_data'] = json_decode($response, true);
    return $data['response_data'];
}

function apiDropdownMenuheader()
{
    $server = $_ENV['APP_API'];

    // helper curl request
    helper(['restclient']);
    // endpoint
    $url = "$server/dropdown/menu_header";
    // client request
    $response = akses_restapi('GET', $url, []);
    $data['response_data'] = json_decode($response, true);
    return $data['response_data'];
}

function apiDropdownMenu()
{
    $server = $_ENV['APP_API'];

    // helper curl request
    helper(['restclient']);
    // endpoint
    $url = "$server/dropdown/menu";
    // client request
    $response = akses_restapi('GET', $url, []);
    $data['response_data'] = json_decode($response, true);
    return $data['response_data'];
}

function apiDropdownObat()
{
    $server = $_ENV['APP_API'];

    // helper curl request
    helper(['restclient']);
    // endpoint
    $url = "$server/dropdown/obat";
    // client request
    $response = akses_restapi('GET', $url, []);
    $data['response_data'] = json_decode($response, true);
    return $data['response_data'];
}

function apiDropdownKota()
{
    $server = $_ENV['APP_API'];

    // helper curl request
    helper(['restclient']);
    // endpoint
    $url = "$server/dropdown/kota";
    // client request
    $response = akses_restapi('GET', $url, []);
    $data['response_data'] = json_decode($response, true);
    return $data['response_data'];
}

function apiDropdownRole()
{
    $server = $_ENV['APP_API'];

    // helper curl request
    helper(['restclient']);
    // endpoint
    $url = "$server/dropdown/role";
    // client request
    $response = akses_restapi('GET', $url, []);
    $data['response_data'] = json_decode($response, true);
    return $data['response_data'];
}

function apiDropdownDokter()
{
    $server = $_ENV['APP_API'];

    // helper curl request
    helper(['restclient']);
    // endpoint
    $url = "$server/dropdown/dokter";
    // client request
    $response = akses_restapi('GET', $url, []);
    $data['response_data'] = json_decode($response, true);
    return $data['response_data'];
}

function apiDropdownEmployee()
{
    $server = $_ENV['APP_API'];

    // helper curl request
    helper(['restclient']);
    // endpoint
    $url = "$server/dropdown/employee";
    // client request
    $response = akses_restapi('GET', $url, []);
    $data['response_data'] = json_decode($response, true);
    return $data['response_data'];
}

function apiDropdownPasien()
{
    $server = $_ENV['APP_API'];

    // helper curl request
    helper(['restclient']);
    // endpoint
    $url = "$server/dropdown/pasien";
    // client request
    $response = akses_restapi('GET', $url, []);
    $data['response_data'] = json_decode($response, true);
    return $data['response_data'];
}

function apiDropdownItem()
{
    $server = $_ENV['APP_API'];

    // helper curl request
    helper(['restclient']);
    // endpoint
    $url = "$server/tmstitem/getall";
    // client request
    $response = akses_restapi('GET', $url, []);
    $data['response_data'] = json_decode($response, true);
    return $data['response_data'];
}

// function apiDropdownAsuransi()
// {
//     $server = $_ENV['APP_API'];

//     // helper curl request
//     helper(['restclient']);
//     // endpoint
//     $url = "$server/tmstasuransi/getall";
//     // client request
//     $response = akses_restapi('GET', $url, []);
//     $data['response_data'] = json_decode($response, true);
//     return $data['response_data'];
// }

function apiDropdownAsuransi()
{
    $server = $_ENV['APP_API'];

    // helper curl request
    helper(['restclient']);
    // endpoint
    $url = "$server/dropdown/asuransi";
    // client request
    $response = akses_restapi('GET', $url, []);
    $data['response_data'] = json_decode($response, true);
    return $data['response_data'];
}

// function getDropdown($name, $label, $label_size, $input_size)
// {
//     $obj = apiDropdown($name);
//     $output = '';
//     $output .= '
//         <div class="mb-3 row">
//             <label for="' . $name . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
//             <div class="col-sm-' . $input_size . '">
//                 <select class="form-control form-control-sm" name="' . $name . '" id="' . $name . '">
//                     <option value=" ">--Select--</option>
//         ';
//     foreach ($obj as $data) {
//         $output .= '
//                     <option value="' . $data['fld_valu'] . '">' . $data['fld_desc'] . '</option>
//         ';
//     }
//     $output .= '
//                 </select>
//             </div>
//             <span class="error invalid-feedback error' . ucfirst($name) . '">
//             </span>
//         </div>
//         ';

//     return $output;
// }

function getDropdownNolabelDiagnosa($name, $input_size)
{
    $obj = apiDropdownDiagnosa($name);
    // dd($obj);
    $output = '';
    $output .= '
        
            <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';

    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['diagnosa_cd'] . '">' . $data['diagnosa'] . '</option>
        ';
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        
        ';

    return $output;
}

function getDropdown($name, $label, $label_size, $input_size)
{
    $obj = apiDropdown($name);

    // Pastikan urut numerik ASC berdasarkan fld_valu
    usort($obj, function ($a, $b) {
        return (int)$a['fld_valu'] <=> (int)$b['fld_valu'];
    });


    $output = '';
    if ($label_size == 0) {
        $output .= '
        <div class="mb-3 row">
            <div class="col-sm-' . $input_size . '">
                <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                    <option value=" ">--Select--</option>
        ';
    } else {
        $output .= '
        <div class="mb-3 row">
            <label for="' . $name . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
            <div class="col-sm-' . $input_size . '">
                <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                    <option value=" ">--Select--</option>
        ';
    }
    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['fld_valu'] . '">' . $data['fld_desc'] . '</option>
        ';
    }
    $output .= '
                </select>
                <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
            </div>
        </div>
        ';

    return $output;
}

function getDropdownNolabelHorizontal($name, $input_size)
{
    $obj = apiDropdown($name);

    // Pastikan urut numerik ASC berdasarkan fld_valu
    usort($obj, function ($a, $b) {
        return (int)$a['fld_valu'] <=> (int)$b['fld_valu'];
    });

    // dd($obj);
    $output = '';
    $output .= '
        <div class="col-sm-' . $input_size . '">
            <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '">
                <option value=" ">--Select--</option>
        ';

    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['fld_valu'] . '">' . $data['fld_desc'] . '</option>
        ';
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        </div>
        ';

    return $output;
}

function getDropdownNolabel($name, $input_size)
{
    $obj = apiDropdown($name);

    // Pastikan urut numerik ASC berdasarkan fld_valu
    usort($obj, function ($a, $b) {
        return (int)$a['fld_valu'] <=> (int)$b['fld_valu'];
    });

    // dd($obj);
    $output = '';
    $output .= '
        <div class="col-sm-' . $input_size . '">
            <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';

    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['fld_valu'] . '">' . $data['fld_desc'] . '</option>
        ';
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        </div>
        ';

    return $output;
}

function getDropdown2($name, $label, $label_size, $input_size)
{
    $obj = apiDropdown($name);

    // Pastikan urut numerik ASC berdasarkan fld_valu
    usort($obj, function ($a, $b) {
        return (int)$a['fld_valu'] <=> (int)$b['fld_valu'];
    });

    // dd($obj);
    $output = '';
    $output .= '
        <label for="' . $name . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
        <div class="col-sm-' . $input_size . '">
            <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';

    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['fld_valu'] . '">' . $data['fld_desc'] . '</option>
        ';
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        </div>
        ';

    return $output;
}

function getDropdownAktif($name, $label, $label_size, $input_size)
{

    $output = '';
    $output .= '
        <div class="mb-3 row">
        <label for="' . $name . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
        <div class="col-sm-' . $input_size . '">
            <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';

    $output .= '
                <option value="A">Aktif</option>
                <option value="T">Tidak</option>
        ';

    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        </div>
        </div>
        ';

    return $output;
}

function getDropdownAktif2($name, $label, $label_size, $input_size)
{

    $output = '';
    $output .= '
        <label for="' . $name . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
        <div class="col-sm-' . $input_size . '">
            <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';

    $output .= '
                <option value="A">Aktif</option>
                <option value="T">Tidak</option>
        ';

    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        </div>
        ';

    return $output;
}

function getDropdownCustom($key, $name, $label, $label_size, $input_size)
{
    $obj = apiDropdown($key);
    // dd($obj);
    $output = '';
    $output .= '
        <label for="' . $name . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
        <div class="col-sm-' . $input_size . '">
            <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';

    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['fld_valu'] . '">' . $data['fld_desc'] . '</option>
        ';
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        </div>
        ';

    return $output;
}

// dropdown dengan key dan filter
function getDropdownCustomFilter($key, $name, $label, $label_size, $input_size, $filter)
{
    $obj = apiDropdown($key);

    // dd($obj);
    $output = '';
    $output .= '
        <label for="' . $name . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
        <div class="col-sm-' . $input_size . '">
            <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';

    foreach ($obj as $data) {

        if (!in_array($data['fld_valu'], $filter)) {
            $output .= '
                    <option value="' . $data['fld_valu'] . '">' . $data['fld_desc'] . '</option>
        ';
        }
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        </div>
        ';

    return $output;
}

// dropdown dengan key dan filter
function getDropdownCustomFilterIn($key, $name, $label, $label_size, $input_size, $filter)
{
    $obj = apiDropdown($key);

    // dd($obj);
    $output = '';
    $output .= '
        <label for="' . $name . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
        <div class="col-sm-' . $input_size . '">
            <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';

    foreach ($obj as $data) {

        if (in_array($data['fld_valu'], $filter)) {
            $output .= '
                    <option value="' . $data['fld_valu'] . '">' . $data['fld_desc'] . '</option>
        ';
        }
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        </div>
        ';

    return $output;
}

// dropdown dengan key dan filter
function getDropdownCustomFilterNotIn($key, $name, $label, $label_size, $input_size, $filter)
{
    $obj = apiDropdown($key);

    // dd($obj);
    $output = '';
    $output .= '
        <label for="' . $name . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
        <div class="col-sm-' . $input_size . '">
            <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';

    foreach ($obj as $data) {

        if (!in_array($data['fld_valu'], $filter)) {
            $output .= '
                    <option value="' . $data['fld_valu'] . '">' . $data['fld_desc'] . '</option>
        ';
        }
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        </div>
        ';

    return $output;
}

function getDropdownMenuheader($name, $label, $label_size, $input_size)
{
    $obj = apiDropdownMenuheader($name);
    // dd($obj);
    $output = '';
    if ($label_size == 0) {
        $output .= '
        <div class="mb-3 row">
            <div class="col-sm-' . $input_size . '">
                <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                    <option value=" ">--Select--</option>
        ';
    } else {
        $output .= '
        <div class="mb-3 row">
            <label for="' . $name . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
            <div class="col-sm-' . $input_size . '">
                <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                    <option value=" ">--Select--</option>
        ';
    }
    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['id'] . '">' . $data['header_nm'] . '</option>
        ';
    }
    $output .= '
                </select>
                <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
            </div>
        </div>
        ';

    return $output;
}

function getDropdownMenuheader2($name, $label, $label_size, $input_size)
{
    $obj = apiDropdownMenuheader($name);
    // dd($obj);
    $output = '';
    $output .= '
        <label for="' . $name . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
        <div class="col-sm-' . $input_size . '">
            <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';

    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['id'] . '">' . $data['header_nm'] . '</option>
        ';
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        </div>
        ';

    return $output;
}

function getDropdownMenu($name, $label, $label_size, $input_size)
{
    $obj = apiDropdownMenu($name);
    // dd($obj);
    $output = '';
    if ($label_size == 0) {
        $output .= '
        <div class="mb-3 row">
            <div class="col-sm-' . $input_size . '">
                <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                    <option value=" ">--Select--</option>
        ';
    } else {
        $output .= '
        <div class="mb-3 row">
            <label for="' . $name . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
            <div class="col-sm-' . $input_size . '">
                <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                    <option value=" ">--Select--</option>
        ';
    }
    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['menu_cd'] . '">' . $data['menu_nm'] . '</option>
        ';
    }
    $output .= '
                </select>
                <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
            </div>
        </div>
        ';

    return $output;
}

function getDropdownMenu2($name, $label, $label_size, $input_size)
{
    $obj = apiDropdownMenu($name);
    // dd($obj);
    $output = '';
    $output .= '
        <label for="' . $name . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
        <div class="col-sm-' . $input_size . '">
            <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';

    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['menu_cd'] . '">' . $data['menu_nm'] . '</option>
        ';
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        </div>
        ';

    return $output;
}

function getDropdownRole($name, $label, $label_size, $input_size)
{
    $obj = apiDropdownRole($name);
    // dd($obj);
    $output = '';
    if ($label_size == 0) {
        $output .= '
        <div class="mb-3 row">
            <div class="col-sm-' . $input_size . '">
                <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                    <option value=" ">--Select--</option>
        ';
    } else {
        $output .= '
        <div class="mb-3 row">
            <label for="' . $name . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
            <div class="col-sm-' . $input_size . '">
                <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                    <option value=" ">--Select--</option>
        ';
    }
    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['role_cd'] . '">' . $data['role_nm'] . '</option>
        ';
    }
    $output .= '
                </select>
                <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
            </div>
        </div>
        ';

    return $output;
}

function getDropdownRole2($name, $label, $label_size, $input_size)
{
    $obj = apiDropdownRole($name);
    // dd($obj);
    $output = '';
    $output .= '
        <label for="' . $name . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
        <div class="col-sm-' . $input_size . '">
            <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';

    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['role_cd'] . '">' . $data['role_nm'] . '</option>
        ';
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        </div>
        ';

    return $output;
}

function getDropdownDokterNolabelVertical($name)
{
    $obj = apiDropdownDokter($name);

    $output = '';
    $output .= '
        
            <select class="form-control form-control-sm select2 form1" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';

    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['kode_dokter'] . '">' . $data['nama_dokter'] . '</option>
        ';
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        
        ';

    return $output;
}

function getDropdownDokter($name, $label, $label_size, $input_size)
{
    $obj = apiDropdownDokter($name);
    // dd($obj);
    $output = '';
    if ($label_size == 0) {
        $output .= '
        <div class="mb-3 row">
            <div class="col-sm-' . $input_size . '">
                <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                    <option value=" ">--Select--</option>
        ';
    } else {
        $output .= '
        <div class="mb-3 row">
            <label for="' . $name . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
            <div class="col-sm-' . $input_size . '">
                <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                    <option value=" ">--Select--</option>
        ';
    }
    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['kode_dokter'] . '">' . $data['nama_dokter'] . '</option>
        ';
    }
    $output .= '
                </select>
                <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
            </div>
        </div>
        ';

    return $output;
}

function getDropdownDokter2($name, $label, $label_size, $input_size)
{
    $obj = apiDropdownDokter($name);
    // dd($obj);
    $output = '';
    $output .= '
        <label for="' . $name . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
        <div class="col-sm-' . $input_size . '">
            <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';

    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['kode_dokter'] . '">' . $data['nama_dokter'] . '</option>
        ';
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        </div>
        ';

    return $output;
}

function getDropdownDokterSearch($name, $label, $label_size, $input_size)
{
    $obj = apiDropdownDokter($name);
    // dd($obj);
    $output = '';
    $output .= '
        <label for="' . $name . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
        <div class="col-sm-' . $input_size . '">
            <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value="all" selected>--ALL--</option>
        ';

    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['kode_dokter'] . '">' . $data['nama_dokter'] . '</option>
        ';
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        </div>
        ';

    return $output;
}

function getDropdownDokterCustom($key, $name, $label, $label_size, $input_size)
{
    $obj = apiDropdownDokter($key);

    $output = '';
    $output .= '
        <label for="' . $name . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
        <div class="col-sm-' . $input_size . '">
            <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';

    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['kode_dokter'] . '">' . $data['nama_dokter'] . '</option>
        ';
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        </div>
        ';

    return $output;
}

function getDropdownPasien($name, $label, $label_size, $input_size)
{
    $obj = apiDropdownPasien($name);
    // dd($obj);
    $output = '';
    if ($label_size == 0) {
        $output .= '
        <div class="mb-3 row">
            <div class="col-sm-' . $input_size . '">
                <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                    <option value=" ">--Select--</option>
        ';
    } else {
        $output .= '
        <div class="mb-3 row">
            <label for="' . $name . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
            <div class="col-sm-' . $input_size . '">
                <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                    <option value=" ">--Select--</option>
        ';
    }
    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['patient_no'] . '">' . $data['patient_no'] . '|' . $data['fullname'] . '</option>
        ';
    }
    $output .= '
                </select>
                <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
            </div>
        </div>
        ';

    return $output;
}

function getDropdownPasien2($name, $label, $label_size, $input_size)
{
    $obj = apiDropdownPasien($name);
    // dd($obj);
    $output = '';
    $output .= '
        <label for="' . $name . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
        <div class="col-sm-' . $input_size . '">
            <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';

    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['patient_no'] . '">' . $data['patient_no'] . '|' . $data['fullname'] . '</option>
        ';
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        </div>
        ';

    return $output;
}

function getDropdownPasienCustom($key, $name, $label, $label_size, $input_size)
{
    $obj = apiDropdownPasien($key);

    $output = '';
    $output .= '
        <label for="' . $name . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
        <div class="col-sm-' . $input_size . '">
            <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';

    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['patient_no'] . '">' . $data['fullname'] . '</option>
        ';
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        </div>
        ';

    return $output;
}

// dropdown dengan key dan filter
function getDropdownItemCustomFilter($key, $name, $label, $label_size, $input_size, $filter)
{
    $obj = apiDropdownItem($key);

    // dd($obj);
    $output = '';
    $output .= '
        <label for="' . $name . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
        <div class="col-sm-' . $input_size . '">
            <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';

    foreach ($obj as $data) {

        if (!in_array($data['item_cd'], $filter)) {
            $output .= '
                    <option value="' . $data['item_cd'] . '">' . $data['item_nm'] . '</option>
        ';
        }
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        </div>
        ';

    return $output;
}

// dropdown dengan key dan filter
function getDropdownAsuransiCustomFilter($key, $name, $label, $label_size, $input_size, $filter)
{
    $obj = apiDropdownAsuransi($key);

    // dd($obj);
    $output = '';
    $output .= '
        <label for="' . $name . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
        <div class="col-sm-' . $input_size . '">
            <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';

    foreach ($obj as $data) {

        if (!in_array($data['asr_cd'], $filter)) {
            $output .= '
                    <option value="' . $data['asr_cd'] . '">' . $data['asr_nm'] . '</option>
        ';
        }
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        </div>
        ';

    return $output;
}

// dropdown dengan key dan filter
function getDropdownEmployeeCustomFilter($key, $name, $label, $label_size, $input_size, $filter)
{
    $obj = apiDropdownEmployee($key);

    // dd($obj);
    $output = '';
    $output .= '
        <label for="' . $name . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
        <div class="col-sm-' . $input_size . '">
            <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';

    foreach ($obj as $data) {

        if (!in_array($data['emp_cd'], $filter)) {
            $output .= '
                    <option value="' . $data['emp_cd'] . '">' . $data['emp_nm'] . '</option>
        ';
        }
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        </div>
        ';

    return $output;
}

function apiDropdownDokterTree($poli)
{
    $server = $_ENV['APP_API'];

    // helper curl request
    helper(['restclient']);
    // endpoint
    $url = "$server/dropdown/dokter/$poli";
    // client request
    $response = akses_restapi('GET', $url, []);
    $data['response_data'] = json_decode($response, true);
    return $data['response_data'];
}

function getDropdownDokterCustomTreeX($poli, $name, $label, $label_size, $input_size)
{
    $obj = apiDropdownDokterTree($poli);

    $output = '';
    $output .= '
    <div class="mb-3 row">
        <label for="' . $name . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
        <div class="col-sm-' . $input_size . '">
            <select class="form-control form-control-sm select2" name="' . $name . '" id="' . $name . '" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';

    foreach ($obj as $data) {
        $output .= '
                    <option value="' . $data['kode_dokter'] . '">' . $data['nama_dokter'] . '</option>
        ';
    }
    $output .= '
            </select>
            <span class="error invalid-feedback error' . ucfirst($name) . '"></span>
        </div>
        </div>
        ';

    return $output;
}

function getDropdownDokterCustomTree($poli)
{
    $obj = apiDropdownDokterTree($poli);

    $output = '';
    $output .= '
            <select class="form-control form-control-sm select2" name="kode_dokter" id="kode_dokter" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';
    if ($poli != ' ') {
        foreach ($obj as $data) {
            $output .= '
                    <option value="' . $data['kode_dokter'] . '">' . $data['nama_dokter'] . '</option>
        ';
        }
    }
    $output .= '
            </select>
            <span class="error invalid-feedback errorKode_dokter"></span>
        ';

    return $output;
}

function apiDropdownLayananItemTree($layanan)
{
    $server = $_ENV['APP_API'];

    // helper curl request
    helper(['restclient']);
    // endpoint
    $url = "$server/dropdown/layananitem/$layanan";
    // client request
    $response = akses_restapi('GET', $url, []);
    $data['response_data'] = json_decode($response, true);
    return $data['response_data'];
}

function getDropdownLayananItemCustomTree($layanan)
{
    $obj = apiDropdownLayananItemTree($layanan);

    $output = '';
    $output .= '
            <select class="form-control form-control-sm select2" name="kode_item" id="kode_item" style="width: 100%;heigh:100%;">
                <option value=" ">--Select--</option>
        ';
    if ($layanan != ' ') {
        foreach ($obj as $data) {
            $output .= '
                    <option value="' . $data['kode_item'] . '" data-harga="' . $data['harga'] . '" data-category="' . $data['category'] . '" data-layanan="' . $data['layanan'] . '" data-namaitem="' . $data['nama_item'] . '">' . $data['nama_item_dropdown'] . '</option>
        ';
        }
    }
    $output .= '
            </select>
            <span class="error invalid-feedback errorKode_item"></span>
        ';

    return $output;
}
