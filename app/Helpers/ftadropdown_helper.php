<?php

if (!function_exists('getFtaDropdown')) {
    function getFtaDropdown($action, $name, $id = null, $params = [], $config = [])
    {
        $id = $id ?? $name;

        $config = array_merge([
            'format' => null,
            'empty_text' => '-- Select --',
            'class' => 'form-control form-control-sm select2',
            'selected' => null,
        ], $config);

        $server3 = $_ENV['APP_API3'] ?? '';
        $url = "{$server3}/api/getftadropdown?action={$action}";

        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $url .= '&' . urlencode($key) . '=' . urlencode($value);
            }
        }

        $response = akses_restapikey('GET', $url, [], []);
        $result = json_decode($response, true);
        $data = $result['data'] ?? [];

        $html = '<select class="' . $config['class'] . '" name="' . $name . '" id="' . $id . '">';
        $html .= '<option value="">' . $config['empty_text'] . '</option>';

        foreach ($data as $item) {
            $value = '';
            $desc = '';

            foreach ($item as $key => $val) {
                $keyLower = strtolower($key);
                if (($keyLower === 'value' || $key === 'Value' || $key === '[value]') && $value === '') {
                    $value = $val;
                }
                if (($keyLower === 'desc' || $key === 'Desc' || $key === '[desc]') && $desc === '') {
                    $desc = $val;
                }
            }

            if ($value === '' && $desc === '') continue;

            if (!empty($config['format'])) {
                $display = str_replace('{value}', $value, $config['format']);
                $display = str_replace('{desc}', $desc, $display);
            } else {
                $display = $item['desc'] ?? $value;
                if (empty($display)) {
                    $display = $value;
                    if (!empty($desc)) {
                        $display .= ' - ' . $desc;
                    }
                }
            }

            $selected = ($config['selected'] !== null && $config['selected'] == $value) ? ' selected' : '';

            $extraAttr = '';
            foreach ($item as $key => $val) {
                $keyLower = strtolower($key);
                if ($keyLower === 'value' || $keyLower === 'desc' || $key === '[desc]' || $key === 'Value' || $key === 'Desc' || $key === '[value]') {
                    continue;
                }
                if ($val === null || $val === '') {
                    continue;
                }
                $attrKey = strtolower(str_replace(' ', '_', $key));
                $extraAttr .= ' data-' . $attrKey . '="' . htmlspecialchars($val) . '"';
            }

            $html .= '<option value="' . htmlspecialchars($value) . '"' . $extraAttr . $selected . '>';
            $html .= htmlspecialchars($display);
            $html .= '</option>';
        }

        $html .= '</select>';
        $html .= '<span class="error invalid-feedback error' . ucfirst($name) . '"></span>';

        return $html;
    }
}
