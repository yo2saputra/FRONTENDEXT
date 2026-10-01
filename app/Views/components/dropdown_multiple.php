<div class="mb-3">
    <select
        id="dropdown-<?= esc($name) ?>"
        name="<?= esc($name) ?><?= isset($multiple) && $multiple ? '[]' : '' ?>"
        <?= isset($multiple) && $multiple ? 'multiple' : '' ?>
        class="form-control form-control-sm select2 <?= isset($multiple) && $multiple ? 'select2-multiple' : '' ?> <?= isset($errors[$name]) ? 'is-invalid' : '' ?>"
        data-api-url="<?= esc($apiUrl) ?>"
        data-selected='<?= isset($selected) ? json_encode($selected) : '[]' ?>'
        data-extra-keys='<?= json_encode($extraKeys ?? []) ?>'
        data-multiple="<?= isset($multiple) && $multiple ? 'true' : 'false' ?>">
        <?php if (!isset($multiple) || !$multiple): ?>
            <option value="">--Loading--</option>
        <?php endif; ?>
    </select>
    <?php if (isset($errors[$name])): ?>
        <div class="invalid-feedback"><?= esc($errors[$name]) ?></div>
    <?php endif; ?>
</div>

<script>
    // Cek apakah jQuery sudah ready
    function waitForJQuery(callback) {
        if (window.jQuery) {
            callback();
        } else {
            setTimeout(function() {
                waitForJQuery(callback);
            }, 50);
        }
    }

    waitForJQuery(function() {
        $(document).ready(function() {
            initializeDropdownMultiple('#dropdown-<?= esc($name) ?>');
        });
    });

    function initializeDropdownMultiple(selector) {
        const $select = $(selector);

        // Ambil konfigurasi dari data attributes
        const apiUrl = $select.data('api-url');
        const selectedValues = $select.data('selected') || [];
        const extraKeys = $select.data('extra-keys') || {};
        const isMultiple = $select.data('multiple') === 'true';

        function loadOptions() {
            $.ajax({
                url: apiUrl,
                method: "GET",
                dataType: "json",
                beforeSend: function() {
                    $select.prop('disabled', true);
                    if (!isMultiple) {
                        $select.html('<option value="">Loading...</option>');
                    } else {
                        $select.html('');
                    }
                },
                success: function(response) {
                    $select.empty();

                    if (!isMultiple) {
                        $select.append('<option value="">--Select--</option>');
                    }

                    // Sesuaikan dengan struktur response API Anda
                    const items = response.data || response;

                    if (Array.isArray(items)) {
                        items.forEach(function(item) {
                            const value = item.warehouse_cd || item.id || item.value;
                            const text = item.warehouse_nm || item.name || item.text || item.desc;

                            const $option = $("<option>")
                                .val(value)
                                .text(text);

                            // Tambahkan data-* attributes
                            if (extraKeys) {
                                Object.keys(extraKeys).forEach(function(attr) {
                                    const field = extraKeys[attr];
                                    if (item[field]) {
                                        $option.attr(attr, item[field]);
                                    }
                                });
                            }

                            // Set selected untuk multiple
                            if (isMultiple && Array.isArray(selectedValues)) {
                                if (selectedValues.includes(value) || selectedValues.includes(item.id)) {
                                    $option.prop('selected', true);
                                }
                            }
                            // Set selected untuk single
                            else if (!isMultiple && selectedValues) {
                                if (selectedValues === value || selectedValues === item.id) {
                                    $option.prop('selected', true);
                                }
                            }

                            $select.append($option);
                        });
                    }

                    $select.prop('disabled', false);
                    $select.removeClass('is-invalid');

                    // Trigger change untuk update Select2 jika digunakan
                    $select.trigger('change');
                },
                error: function(xhr, status, error) {
                    console.error('Error loading dropdown:', error);

                    if (!isMultiple) {
                        $select.html('<option value="">Error loading data</option>');
                    } else {
                        $select.html('');
                    }

                    $select.prop('disabled', false)
                        .addClass('is-invalid');

                    // Hapus pesan error lama jika ada
                    $select.siblings('.invalid-feedback').remove();

                    // Tambah pesan error baru
                    $select.after('<div class="invalid-feedback">Gagal memuat data</div>');
                }
            });
        }

        // Load pertama kali
        loadOptions();

        // Refresh saat dropdown dibuka (opsional)
        $select.on("mousedown", function(e) {
            if (isMultiple) {
                if ($select.find('option').length === 0) {
                    loadOptions();
                }
            } else {
                if ($select.find('option').length <= 1) {
                    loadOptions();
                }
            }
        });

        // Expose function ke global
        window["refreshDropdown_<?= esc($name) ?>"] = loadOptions;

        // Di dalam initializeDropdown, tambahkan ini
        $(document).on('refresh-dropdown:' + selector, function() {
            loadOptions();
        });
    }
</script>