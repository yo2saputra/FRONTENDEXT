<div class="mb-3">
    <select
        id="<?= esc($id) ?>"
        name="<?= esc($name) ?>"
        class="form-control form-control-sm select2 <?= isset($errors[$name]) ? 'is-invalid' : '' ?>"
        data-api-url="<?= esc($apiUrl) ?>"
        data-selected="<?= esc($selected ?? '') ?>"
        data-extra-keys='<?= json_encode($extraKeys ?? []) ?>'>
        <option value="">--Loading--</option>
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
            initializeDropdown('#<?= esc($id) ?>');
        });
    });

    function initializeDropdown(selector) {
        const $select = $(selector);

        // Ambil konfigurasi dari data attributes
        const apiUrl = $select.data('api-url');
        const selectedValue = $select.data('selected');
        const extraKeys = $select.data('extra-keys') || {};
        // const extraAttrs = $select.data('extra-attrs') || {};

        function loadOptions() {
            // alert('Reloading options...');

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
                            const $option = $("<option>")
                                .val(item.warehouse_cd || item.cd || item.id || item.value)
                                .text(item.warehouse_nm || item.nm || item.name || item.text || item.desc);

                            // Tambahkan data-* attributes - CARA YANG BENAR
                            if (extraKeys && typeof extraKeys === 'object') {
                                // Gunakan jQuery's data() untuk menyimpan data
                                Object.keys(extraKeys).forEach(function(dataAttr) {
                                    const fieldName = extraKeys[dataAttr]; // nama field di response
                                    if (item[fieldName]) {
                                        // Gunakan attr() untuk menambahkan atribut data-*
                                        $option.attr(dataAttr, item[fieldName]);

                                        // Alternatif: bisa juga gunakan data() jQuery
                                        // Tapi attr() lebih baik karena terlihat di DOM
                                        // $option.data(dataAttr.replace('data-', ''), item[fieldName]);
                                    }
                                });
                            }

                            // Custom attributes dari extraAttrs
                            // if (extraAttrs && typeof extraAttrs === 'object') {
                            //     Object.keys(extraAttrs).forEach(function(attr) {
                            //         const field = extraAttrs[attr];
                            //         if (item[field]) {
                            //             $option.attr(attr, item[field]); // attr untuk custom atribut
                            //         }
                            //     });
                            // }

                            // Set selected jika cocok
                            if (selectedValue && selectedValue === $option.val()) {
                                $option.prop('selected', true);
                            }

                            $select.append($option);
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

        // Di dalam initializeDropdown, tambahkan ini
        $(document).on('refresh-dropdown:' + selector, function() {
            // alert('test');
            loadOptions();
        });
    }
</script>