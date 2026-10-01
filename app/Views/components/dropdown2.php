<?php

/**
 * Komponen Dropdown Universal dengan Select2 - FINAL FIX
 * 
 * @param string $id          ID elemen (wajib)
 * @param string $name        Nama field (wajib)
 * @param string $apiUrl      URL API (wajib)
 * @param array  $extraKeys   Data atribut tambahan ['data-nama' => 'field_nama']
 * @param string|array $selected Nilai yang dipilih (string untuk single, array untuk multiple)
 * @param array  $errors      Error validasi
 * @param bool   $multiple    Mode multiple select (default: false)
 * @param array  $filterIn    Filter nilai yang ditampilkan (default: [])
 * @param array  $filterNotIn Filter nilai yang disembunyikan (default: [])
 * @param string $placeholder Teks placeholder (default: '--Pilih--')
 * @param bool   $allowClear  Izinkan clear selection (default: true)
 * @param string $class       Kelas tambahan (default: '')
 * @param bool   $disabled    Nonaktifkan dropdown (default: false)
 * @param array  $attributes  Atribut tambahan HTML
 * @param string $filterMode  Mode filter: 'show' atau 'hide' (default: 'show')
 * @param string $parentId    ID elemen <select> induk untuk dropdown berjenjang (misal: id dropdown provinsi)
 * @param string $parentParam (opsional) Nama query parameter tambahan yang dikirim ke API saat parent berubah,
 *                             untuk endpoint yang membaca $_GET langsung. Kalau memakai controller
 *                             customize() bawaan, gunakan placeholder {parent} di dalam $apiUrl saja
 *                             (contoh: '.../customize/1/2/city/null/action/getall/province_id/{parent}')
 * @param string $parentPlaceholder Teks placeholder saat menunggu parent dipilih (default: sama seperti $placeholder)
 */
?>

<?php
// Hindari nama field dobel kurung siku, misal caller mengirim
// name => 'field[]' sekaligus multiple => true.
$baseName = preg_replace('/\[\]$/', '', isset($name) ? $name : '');
?>
<div class="mb-3">
    <select
        id="<?= esc(isset($id) ? $id : '') ?>"
        name="<?= esc($baseName) . (($multiple ?? false) ? '[]' : '') ?>"
        class="form-control form-control-sm select2 <?= esc($class ?? '') ?> <?= isset($errors[$baseName]) ? 'is-invalid' : '' ?>"
        data-api-url="<?= esc(isset($apiUrl) ? $apiUrl : '') ?>"
        data-selected='<?= json_encode($selected ?? '') ?>'
        data-extra-keys='<?= json_encode($extraKeys ?? []) ?>'
        data-filter-in='<?= json_encode($filterIn ?? []) ?>'
        data-filter-not-in='<?= json_encode($filterNotIn ?? []) ?>'
        data-multiple="<?= ($multiple ?? false) ? 'true' : 'false' ?>"
        data-placeholder="<?= esc($placeholder ?? '--Pilih--') ?>"
        data-allow-clear="<?= ($allowClear ?? true) ? 'true' : 'false' ?>"
        data-filter-mode="<?= isset($filterMode) ? esc($filterMode) : 'show' ?>"
        data-parent-id="<?= esc($parentId ?? '') ?>"
        data-parent-param="<?= esc($parentParam ?? '') ?>"
        data-parent-placeholder="<?= esc($parentPlaceholder ?? ($placeholder ?? '--Pilih--')) ?>"
        <?= ($multiple ?? false) ? 'multiple' : '' ?>
        <?= ($disabled ?? false) ? 'disabled' : '' ?>
        <?php if (!empty($attributes)): ?>
        <?php foreach ($attributes as $key => $value): ?>
        <?= esc($key) ?>="<?= esc($value) ?>"
        <?php endforeach; ?>
        <?php endif; ?>>
    </select>
    <?php if (isset($errors[$baseName])): ?>
        <div class="invalid-feedback"><?= esc($errors[$baseName]) ?></div>
    <?php endif; ?>
</div>

<style>
    /* ========================================== */
    /* STYLE UNTUK OPTION DISABLED */
    /* ========================================== */
    .select2-container--bootstrap4 .select2-results__option--disabled {
        color: #adb5bd !important;
        background-color: #f8f9fa !important;
        cursor: not-allowed !important;
        opacity: 0.6 !important;
    }

    .select2-container--bootstrap4 .select2-results__option--disabled:hover {
        background-color: #f8f9fa !important;
        color: #adb5bd !important;
    }

    .select2-container--bootstrap4 .select2-results__option--disabled::before {
        content: "🔒 ";
        opacity: 0.5;
    }

    .select2-container--bootstrap4 .select2-results__option--disabled:hover::after {
        content: "❌ Tidak tersedia";
        position: absolute;
        right: 10px;
        color: #dc3545;
        font-size: 11px;
        font-weight: bold;
    }

    .filter-mode-show .select2-container--bootstrap4 .select2-results__option--disabled {
        color: #adb5bd !important;
        background-color: #f8f9fa !important;
        cursor: not-allowed !important;
    }

    .filter-mode-hide .select2-container--bootstrap4 .select2-results__option--disabled {
        display: none !important;
    }

    .select2-container--bootstrap4 .select2-results__option {
        transition: all 0.2s ease;
    }

    .select2-container--bootstrap4 .select2-results__option--disabled {
        transition: all 0.2s ease;
    }

    .is-invalid~.select2-container--bootstrap4 .select2-selection {
        border-color: #dc3545 !important;
    }

    .is-invalid~.select2-container--bootstrap4.select2-container--focus .select2-selection {
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
    }

    /* ========================================== */
    /* STYLE UNTUK MULTIPLE SELECT - HIDE CAPTION */
    /* ========================================== */
    .select2-container--bootstrap4.select2-container--multiple .select2-selection__choice {
        display: none !important;
    }

    .select2-container--bootstrap4.select2-container--multiple .select2-selection__choice__remove {
        display: none !important;
    }

    .select2-container--bootstrap4.select2-container--multiple .select2-selection__rendered>span:not(.select2-selection__placeholder):not(.select2-multiple-count) {
        display: none !important;
    }

    .select2-container--bootstrap4.select2-container--multiple .select2-selection__placeholder {
        color: #6c757d !important;
    }

    .select2-multiple-count {
        color: #495057;
        font-size: 14px;
        font-weight: normal;
    }

    .select2-multiple-count .badge {
        background-color: #007bff;
        color: white;
        border-radius: 50%;
        padding: 2px 8px;
        font-size: 11px;
        margin-left: 5px;
    }

    .select2-container--bootstrap4.select2-container--multiple .select2-selection__rendered {
        padding: 0.375rem 0.75rem !important;
        min-height: 38px;
        display: flex !important;
        align-items: center !important;
        flex-wrap: wrap !important;
    }

    /* Fix untuk select2 di form-control-sm */
    select.form-control-sm~.select2-container--default {
        font-size: .720rem !important;
    }
</style>

<script>
    (function() {
        'use strict';

        function waitForJQuery(callback) {
            if (typeof jQuery !== 'undefined') {
                callback();
            } else {
                setTimeout(() => waitForJQuery(callback), 50);
            }
        }

        waitForJQuery(function() {
            $(document).ready(function() {
                initDropdownInstance('#<?= esc(isset($id) ? $id : '') ?>');
            });
        });

        function initDropdownInstance(selector) {
            const $select = $(selector);
            if (!$select.length) return;

            // Ambil id dari elemen DOM saat runtime (bukan literal PHP),
            // supaya setiap instance komponen punya funcName yang benar
            // meskipun beberapa dropdown dirender di halaman yang sama.
            const elementId = $select.attr('id');

            const config = {
                apiUrl: $select.data('api-url'),
                selected: $select.data('selected'),
                extraKeys: $select.data('extra-keys') || {},
                filterIn: $select.data('filter-in') || [],
                filterNotIn: $select.data('filter-not-in') || [],
                multiple: $select.data('multiple') === 'true',
                placeholder: $select.data('placeholder') || '--Pilih--',
                allowClear: $select.data('allow-clear') !== 'false',
                filterMode: $select.data('filter-mode') || 'show',
                parentId: $select.data('parent-id') || '',
                parentParam: $select.data('parent-param') || '',
                parentPlaceholder: $select.data('parent-placeholder') || ''
            };
            if (!config.parentPlaceholder) {
                config.parentPlaceholder = config.placeholder;
            }
            if (config.parentId && typeof console !== 'undefined' && !$('#' + config.parentId).length) {
                console.warn('[dropdown2] parentId "#' + config.parentId + '" untuk "#' + elementId + '" tidak ditemukan di DOM.');
            }

            let isLoading = false;
            let isLoaded = false;
            let isInitialized = false;
            let valueQueue = [];
            let isProcessing = false;

            // ============================================
            // LOAD DATA
            // ============================================
            function loadData(callback) {
                if (isLoading) {
                    setTimeout(() => loadData(callback), 100);
                    return;
                }

                if (isLoaded) {
                    if (callback) callback();
                    return;
                }

                // ============================================
                // CASCADE: cek apakah dropdown ini punya parent
                // ============================================
                let parentValue = null;
                if (config.parentId) {
                    const $parent = $('#' + config.parentId);
                    parentValue = $parent.val();
                    if (Array.isArray(parentValue)) {
                        parentValue = parentValue.length > 0 ? parentValue[0] : null;
                    }

                    if (!parentValue) {
                        // Parent belum dipilih -> select ini dikosongkan &
                        // dinonaktifkan sampai parent dipilih. Tidak perlu
                        // memanggil API dulu.
                        $select.empty();
                        if (!config.multiple) {
                            $select.append('<option value="">' + config.parentPlaceholder + '</option>');
                        }
                        $select.prop('disabled', true).removeClass('is-invalid');
                        isLoaded = false;
                        initSelect2(function() {
                            if (callback) callback();
                        });
                        return;
                    }
                }

                isLoading = true;

                // Ganti placeholder {parent} pada apiUrl dengan nilai parent
                // terpilih -> cocok dengan pola controller customize() yang
                // membaca segmen route/query dari URL, bukan dari body/$_GET.
                // Contoh: '.../customize/1/2/city/null/action/getall/province_id/{parent}'
                let requestUrl = config.apiUrl;
                if (config.parentId) {
                    if (requestUrl.indexOf('{parent}') !== -1) {
                        requestUrl = requestUrl.replace(/\{parent\}/g, encodeURIComponent(parentValue));
                    } else if (!config.parentParam && typeof console !== 'undefined') {
                        console.warn('[dropdown2] "#' + elementId + '" punya parentId tapi apiUrl tidak mengandung placeholder {parent} dan parentParam tidak diisi. Data parent tidak akan terkirim ke API.');
                    }
                }

                $.ajax({
                    url: requestUrl,
                    method: "GET",
                    dataType: "json",
                    data: (config.parentId && config.parentParam) ? {
                        [config.parentParam]: parentValue
                    } : {},
                    beforeSend: function() {
                        $select.prop('disabled', true).empty();
                    },
                    success: function(response) {
                        $select.empty();

                        const items = response.data || response;

                        if (Array.isArray(items) && items.length > 0) {
                            // Parse selected values
                            let selectedValues = [];
                            if (config.selected) {
                                if (Array.isArray(config.selected)) {
                                    selectedValues = config.selected.map(v => String(v));
                                } else if (typeof config.selected === 'string' && config.selected !== '') {
                                    selectedValues = config.selected.split(',').map(s => String(s).trim()).filter(v => v !== '');
                                } else if (config.selected !== null && config.selected !== undefined) {
                                    selectedValues = [String(config.selected)];
                                }
                            }

                            // Tambahkan placeholder untuk single select
                            if (!config.multiple) {
                                $select.append('<option value="">' + config.placeholder + '</option>');
                            }

                            items.forEach(function(item) {
                                const value = item.cd || item.id || item.value || item.code || item.kode;
                                const text = item.nm || item.name || item.text || item.desc || item.label || item.nama || value;

                                if (value === null || value === undefined) return;

                                const strValue = String(value);

                                // Filter
                                const isFilteredNotIn = config.filterNotIn.length > 0 && config.filterNotIn.some(function(f) {
                                    return String(f) === strValue;
                                });
                                const isFilteredIn = config.filterIn.length > 0 && config.filterIn.some(function(f) {
                                    return String(f) === strValue;
                                });

                                let isActive = true;
                                if (config.filterIn.length > 0) {
                                    isActive = isFilteredIn;
                                } else if (config.filterNotIn.length > 0) {
                                    isActive = !isFilteredNotIn;
                                }

                                const shouldHide = config.filterMode === 'hide' && !isActive;

                                const $option = $("<option>")
                                    .val(strValue)
                                    .text(text);

                                if (!isActive) {
                                    $option.addClass('disabled-option');
                                    $option.prop('disabled', true);
                                }

                                $option.attr('data-active', isActive ? 'true' : 'false');

                                // Extra keys
                                if (config.extraKeys && typeof config.extraKeys === 'object') {
                                    Object.keys(config.extraKeys).forEach(function(dataAttr) {
                                        const fieldName = config.extraKeys[dataAttr];
                                        if (item[fieldName] !== undefined && item[fieldName] !== null) {
                                            $option.attr(dataAttr, item[fieldName]);
                                        }
                                    });
                                }

                                // Set selected dari config
                                if (isActive && selectedValues.length > 0) {
                                    const isSelected = selectedValues.some(function(sel) {
                                        return String(sel).toLowerCase() === strValue.toLowerCase();
                                    });
                                    if (isSelected) {
                                        $option.prop('selected', true);
                                    }
                                }

                                if (shouldHide) {
                                    $option.hide();
                                }

                                $select.append($option);
                            });

                            // Jika tidak ada data aktif
                            if ($select.find('option:not([style*="display: none"])').length === 0) {
                                if (!config.multiple) {
                                    $select.append('<option value="">' + config.placeholder + '</option>');
                                }
                                $select.append('<option value="">--Tidak ada data aktif--</option>');
                            }

                        } else {
                            if (!config.multiple) {
                                $select.append('<option value="">' + config.placeholder + '</option>');
                            }
                            $select.append('<option value="">--Tidak ada data--</option>');
                        }

                        $select.prop('disabled', false).removeClass('is-invalid');
                        isLoaded = true;

                        // Init Select2
                        initSelect2(function() {
                            // Process queue
                            processQueue();

                            // CASCADE: kalau select ini sudah punya nilai
                            // (misal dari parameter 'selected' saat render
                            // awal, form edit) tapi belum pernah memicu
                            // event 'change', picu sekali di sini supaya
                            // dropdown turunan (child) ikut memuat data.
                            const currentVal = $select.val();
                            const hasValue = Array.isArray(currentVal) ? currentVal.length > 0 : !!currentVal;
                            if (hasValue) {
                                $select.trigger('change');
                            }

                            if (callback) callback();
                        });

                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading dropdown:', error);
                        if (!config.multiple) {
                            $select.append('<option value="">' + config.placeholder + '</option>');
                        }
                        $select.append('<option value="">Error loading data</option>')
                            .prop('disabled', false)
                            .addClass('is-invalid');

                        if (callback) callback();
                    },
                    complete: function() {
                        isLoading = false;
                    }
                });
            }

            // ============================================
            // INIT SELECT2
            // ============================================
            function initSelect2(callback) {
                if (typeof $.fn.select2 === 'undefined') {
                    console.warn('Select2 not loaded');
                    if (callback) callback();
                    return;
                }

                if ($select.hasClass('select2-hidden-accessible')) {
                    try {
                        $select.select2('destroy');
                    } catch (e) {}
                }

                const options = {
                    placeholder: config.placeholder,
                    allowClear: config.allowClear,
                    width: '100%',
                    theme: 'bootstrap4',
                    dropdownAutoWidth: true,
                    language: {
                        noResults: function() {
                            return 'Tidak ada hasil';
                        },
                        searching: function() {
                            return 'Mencari...';
                        }
                    },
                    templateResult: function(data, container) {
                        if (!data.element) return data.text;
                        const $element = $(data.element);
                        const isDisabled = $element.prop('disabled') || $element.hasClass('disabled-option');
                        const isActive = $element.data('active') !== false;

                        if (isDisabled || !isActive) {
                            const $result = $('<span>');
                            $result.css({
                                'color': '#adb5bd',
                                'opacity': '0.6',
                                'cursor': 'not-allowed'
                            });
                            $result.html('🔒 ' + data.text);
                            $result.append(' <span class="badge badge-secondary" style="font-size:9px; margin-left:5px;">Tidak Tersedia</span>');
                            return $result;
                        }
                        return data.text;
                    },
                    templateSelection: function(data, container) {
                        // Untuk multiple, selalu return placeholder
                        if (config.multiple) {
                            return config.placeholder;
                        }
                        // Untuk single select
                        if (!data.element) return data.text;
                        const $element = $(data.element);
                        const isDisabled = $element.prop('disabled') || $element.hasClass('disabled-option');
                        if (isDisabled) {
                            return null;
                        }
                        return data.text;
                    }
                };

                if (config.multiple) {
                    options.multiple = true;
                    options.closeOnSelect = false;
                    options.tags = false;
                }

                $select.select2(options);
                isInitialized = true;

                const container = $select.next('.select2-container');
                if (container.length) {
                    container.addClass('filter-mode-' + config.filterMode);
                }

                // Events
                $select.on('change.select2-fix', function() {
                    setTimeout(function() {
                        updateMultipleDisplay();
                    }, 10);
                    $(this).trigger('dropdown-change');
                });

                $select.on('select2:select.select2-fix', function(e) {
                    setTimeout(function() {
                        updateMultipleDisplay();
                    }, 10);
                });

                $select.on('select2:unselect.select2-fix', function(e) {
                    setTimeout(function() {
                        updateMultipleDisplay();
                    }, 10);
                });

                $select.on('select2:close.select2-fix', function(e) {
                    setTimeout(function() {
                        updateMultipleDisplay();
                    }, 50);
                });

                // Prevent disabled selection
                $select.on('select2:select', function(e) {
                    const data = e.params.data;
                    if (data && data.element) {
                        const $option = $(data.element);
                        if ($option.prop('disabled') || $option.hasClass('disabled-option')) {
                            e.preventDefault();
                            return false;
                        }
                    }
                });

                setTimeout(function() {
                    updateMultipleDisplay();
                }, 200);

                if (callback) {
                    setTimeout(callback, 300);
                }
            }

            // ============================================
            // UPDATE MULTIPLE DISPLAY
            // ============================================
            function updateMultipleDisplay() {
                if (!config.multiple || !isInitialized) return;

                setTimeout(function() {
                    const $container = $select.next('.select2-container');
                    if (!$container.length) return;

                    const $rendered = $container.find('.select2-selection__rendered');
                    if (!$rendered.length) return;

                    // Hapus semua child
                    $rendered.empty();

                    const selectedValues = $select.val();
                    const count = selectedValues ? (Array.isArray(selectedValues) ? selectedValues.length : 1) : 0;

                    if (count === 0) {
                        const $placeholder = $('<span class="select2-selection__placeholder">');
                        $placeholder.text(config.placeholder);
                        $rendered.append($placeholder);
                    } else {
                        const $countDisplay = $('<span class="select2-multiple-count">');
                        $countDisplay.html(count + ' item' + (count > 1 ? 's' : '') + ' selected <span class="badge">' + count + '</span>');
                        $rendered.append($countDisplay);
                    }
                }, 0);
            }

            // ============================================
            // QUEUE SYSTEM
            // ============================================
            function processQueue() {
                if (isProcessing) return;
                if (valueQueue.length === 0) return;

                isProcessing = true;
                const value = valueQueue.shift();

                setTimeout(function() {
                    applyValue(value);
                    isProcessing = false;
                    setTimeout(function() {
                        processQueue();
                    }, 100);
                }, 100);
            }

            function addToQueue(value) {
                valueQueue.push(value);
                if (!isProcessing && isLoaded && isInitialized) {
                    processQueue();
                }
            }

            // ============================================
            // APPLY VALUE
            // ============================================
            function applyValue(value) {
                if (!isLoaded || !isInitialized) {
                    addToQueue(value);
                    return;
                }

                try {
                    // Parse value
                    let values = [];
                    if (Array.isArray(value)) {
                        values = value.filter(v => v !== null && v !== undefined && v !== '').map(v => String(v));
                    } else if (typeof value === 'string' && value !== '') {
                        values = value.split(',').map(s => String(s).trim()).filter(v => v !== '');
                    } else if (value !== null && value !== undefined && value !== '') {
                        values = [String(value)];
                    }

                    // Ambil available values dari options
                    const availableValues = [];
                    $select.find('option').each(function() {
                        const val = $(this).val();
                        if (val && val !== '') {
                            availableValues.push(String(val));
                        }
                    });

                    // Filter valid values (case-insensitive, terutama untuk GUID/UUID
                    // yang sering beda huruf besar/kecil antara backend & data API).
                    // Gunakan value ASLI dari <option> (bukan value dari API) karena
                    // $select.val() di DOM tetap case-sensitive saat mencocokkan option.
                    const validValues = [];
                    values.forEach(function(v) {
                        const matched = availableValues.find(function(av) {
                            return String(av).toLowerCase() === String(v).toLowerCase();
                        });
                        if (matched !== undefined) {
                            validValues.push(matched);
                        }
                    });

                    // Set value
                    if (config.multiple) {
                        $select.val(validValues.length > 0 ? validValues : []).trigger('change');
                    } else {
                        if (validValues.length > 0) {
                            $select.val(validValues[0]).trigger('change');
                        } else {
                            // Jika value tidak valid, pilih placeholder (empty)
                            $select.val('').trigger('change');
                        }
                    }

                    // Update display
                    setTimeout(function() {
                        updateMultipleDisplay();
                        $select.trigger('dropdown-value-set', [$select.val()]);
                    }, 50);

                } catch (e) {
                    console.error('Error applying value:', e);
                }
            }

            // ============================================
            // PUBLIC METHODS
            // ============================================
            function setValue(value) {
                console.log('setValue:', value, 'multiple:', config.multiple);
                if (!isLoaded || !isInitialized) {
                    addToQueue(value);
                    if (!isLoaded) {
                        loadData();
                    }
                } else {
                    applyValue(value);
                }
            }

            function getValue() {
                return $select.val();
            }

            function getSelectedText() {
                return $select.find('option:selected:not([disabled])').text();
            }

            function getSelectedData() {
                const selected = $select.find('option:selected:not([disabled])');
                if (selected.length === 0) return null;

                const result = [];
                selected.each(function() {
                    const $option = $(this);
                    const data = {
                        value: $option.val(),
                        text: $option.text()
                    };
                    const attrs = $option[0].attributes;
                    for (let i = 0; i < attrs.length; i++) {
                        const attr = attrs[i];
                        if (attr.name.startsWith('data-')) {
                            data[attr.name] = attr.value;
                        }
                    }
                    result.push(data);
                });

                return config.multiple ? result : result[0];
            }

            function refresh(callback) {
                isLoaded = false;
                isInitialized = false;
                valueQueue = [];
                // Catatan: JANGAN destroy select2 di sini. initSelect2() sudah
                // menghancurkan & membuat ulang instance select2 tepat sebelum
                // data baru ditampilkan (setelah AJAX selesai). Kalau di-destroy
                // di sini, <select> mentah (tanpa skin Select2) akan terlihat
                // selama proses AJAX berlangsung -> menyebabkan tampilan
                // "berkedip aneh" lalu kembali normal.
                loadData(callback);
            }

            // ============================================
            // EXPOSE GLOBAL
            // ============================================
            const funcName = 'dropdown_' + elementId.replace(/-/g, '_');
            window[funcName] = {
                setValue: setValue,
                getValue: getValue,
                getSelectedText: getSelectedText,
                getSelectedData: getSelectedData,
                refresh: refresh,
                select2: $select,
                isLoaded: function() {
                    return isLoaded;
                },
                isInitialized: function() {
                    return isInitialized;
                }
            };

            // ============================================
            // EVENT LISTENERS
            // ============================================
            $(document).on('refresh-dropdown:' + selector, function() {
                refresh();
            });

            $(document).on('refresh-all-dropdowns', function() {
                refresh();
            });

            $select.on('select2:open', function(e) {
                if (!isLoaded) {
                    loadData();
                }
            });

            // ============================================
            // CASCADE: reload otomatis saat parent berubah
            // ============================================
            if (config.parentId) {
                $(document).on('change.cascade-' + elementId, '#' + config.parentId, function() {
                    isLoaded = false;
                    isInitialized = false;
                    valueQueue = [];
                    // Reset value sendiri & lanjutkan trigger 'change' supaya
                    // dropdown turunan (kalau ada, misal kota di bawah provinsi)
                    // juga ikut ter-reset secara berjenjang.
                    $select.val(config.multiple ? [] : '').trigger('change');
                    loadData();
                });
            }

            // ============================================
            // START
            // ============================================
            loadData();

            return {
                setValue: setValue,
                getValue: getValue,
                getSelectedText: getSelectedText,
                getSelectedData: getSelectedData,
                refresh: refresh,
                select2: $select,
                isLoaded: function() {
                    return isLoaded;
                },
                isInitialized: function() {
                    return isInitialized;
                }
            };
        }

    })();
</script>