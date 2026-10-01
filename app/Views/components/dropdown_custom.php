<div class="mb-3">
    <select
        id="dropdown-<?= esc($name) ?>"
        name="<?= esc($name) ?>"
        class="form-control form-control-sm select2 <?= isset($errors[$name]) ? 'is-invalid' : '' ?>"
        data-api-url="<?= esc($apiUrl) ?>"
        data-selected="<?= esc($selected ?? '') ?>"
        data-value-key="<?= esc($valueKey ?? 'ideee') ?>"
        data-caption-key="<?= esc($captionKey ?? 'nameeee') ?>"
        data-extra-keys='<?= json_encode($extraKeys ?? []) ?>'>
        <option value="">--Loading-- yyy</option>
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
            initializeDropdown('#dropdown-<?= esc($name) ?>');
        });
    });

    function initializeDropdown(selector) {
        const $select = $(selector);

        // Ambil konfigurasi dari data attributes
        const apiUrl = $select.data('api-url');
        const selectedValue = $select.data('selected');
        const valueKey = $select.data('value-key') || 'idxxx';
        const captionKey = $select.data('caption-key') || 'namexxx';
        const extraKeys = $select.data('extra-keys') || {};

        function loadOptions() {
            $.ajax({
                url: apiUrl,
                method: "GET",
                dataType: "json",
                beforeSend: function() {
                    $select.prop('disabled', true).html('<option value="">Loading...</option>');
                },
                success: function(response) {
                    $select.empty().append('<option value="">--Select--</option>');

                    // Sesuaikan dengan struktur response API Anda
                    const items = response.data || response;

                    if (Array.isArray(items)) {
                        items.forEach(function(item) {
                            // Gunakan valueKey dan captionKey dari parameter
                            const value = getNestedValue(item, valueKey);
                            const caption = getNestedValue(item, captionKey);

                            if (value !== undefined && caption !== undefined) {
                                const $option = $("<option>")
                                    .val(value)
                                    .text(caption);

                                // Tambahkan data-* attributes
                                if (extraKeys) {
                                    Object.keys(extraKeys).forEach(function(attr) {
                                        const field = extraKeys[attr];
                                        const fieldValue = getNestedValue(item, field);
                                        if (fieldValue) {
                                            $option.attr(attr, fieldValue);
                                        }
                                    });
                                }

                                // Set selected jika cocok
                                if (selectedValue && selectedValue == value) {
                                    $option.prop('selected', true);
                                }

                                $select.append($option);
                            }
                        });
                    }

                    $select.prop('disabled', false);
                    $select.removeClass('is-invalid');
                },
                error: function(xhr, status, error) {
                    console.error('Error loading dropdown:', error);
                    $select.html('<option value="">Error loading data</option>')
                        .prop('disabled', false)
                        .addClass('is-invalid');

                    // Hapus pesan error lama jika ada
                    $select.siblings('.invalid-feedback').remove();

                    // Tambah pesan error baru
                    $select.after('<div class="invalid-feedback">Gagal memuat data</div>');
                }
            });
        }

        // Fungsi untuk mengambil nilai nested object (contoh: 'user.address.city')
        function getNestedValue(obj, path) {
            if (!path) return undefined;

            // Jika path bukan string, return undefined
            if (typeof path !== 'string') return undefined;

            return path.split('.').reduce(function(current, key) {
                return current && current[key] !== undefined ? current[key] : undefined;
            }, obj);
        }

        // Load pertama kali
        loadOptions();

        // Refresh saat dropdown dibuka (opsional - bisa dihapus jika tidak perlu)
        $select.on("mousedown", function(e) {
            // Cek apakah sudah ada data (lebih dari 1 option karena ada --Select--)
            if ($select.find('option').length <= 1) {
                loadOptions();
            }
        });

        // Expose function ke global
        window["refreshDropdown_<?= esc($name) ?>"] = loadOptions;

        // Event listener untuk refresh
        $(document).on('refresh-dropdown:' + selector, function() {
            loadOptions();
        });
    }
</script>