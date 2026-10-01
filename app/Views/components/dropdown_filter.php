<div class="mb-3">
    <select
        id="dropdown-<?= esc($name) ?>"
        name="<?= esc($name) ?>"
        class="form-control form-control-sm select2 <?= isset($errors[$name]) ? 'is-invalid' : '' ?>"
        data-api-url="<?= esc($apiUrl) ?>"
        data-selected="<?= esc($selected ?? '') ?>"
        data-extra-keys='<?= json_encode($extraKeys ?? []) ?>'
        data-filter-in='<?= json_encode($filterIn ?? []) ?>'>
        <option value="">--Loading-- xxx</option>
    </select>
    <?php if (isset($errors[$name])): ?>
        <div class="invalid-feedback"><?= esc($errors[$name]) ?></div>
    <?php endif; ?>
</div>

<script>
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

        const apiUrl = $select.data('api-url');
        const selectedValue = $select.data('selected');
        const extraKeys = $select.data('extra-keys') || {};
        const extraAttrs = $select.data('extra-attrs') || {};

        // Pastikan filterIn berupa array
        let filterIn = $select.attr('data-filter-in');
        try {
            filterIn = JSON.parse(filterIn);
        } catch (e) {
            filterIn = [];
        }

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

                    const items = response.data || response;

                    if (Array.isArray(items)) {
                        items.forEach(function(item) {
                            const value = item.warehouse_cd || item.cd || item.id || item.value;

                            // FilterIn: hanya tampilkan jika termasuk
                            if (Array.isArray(filterIn) && filterIn.length > 0 && !filterIn.includes(value)) {
                                return; // skip item
                            }

                            const $option = $("<option>")
                                .val(value)
                                .text(item.warehouse_nm || item.nm || item.name || item.text || item.desc);

                            // Tambahkan data-* attributes
                            if (extraKeys && typeof extraKeys === 'object') {
                                Object.keys(extraKeys).forEach(function(dataAttr) {
                                    const fieldName = extraKeys[dataAttr];
                                    if (item[fieldName]) {
                                        $option.attr(dataAttr, item[fieldName]);
                                    }
                                });
                            }

                            // Custom attributes dari extraAttrs
                            if (extraAttrs && typeof extraAttrs === 'object') {
                                Object.keys(extraAttrs).forEach(function(attr) {
                                    const field = extraAttrs[attr];
                                    if (item[field]) {
                                        $option.attr(attr, item[field]);
                                    }
                                });
                            }

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

                    $select.siblings('.invalid-feedback').remove();
                    $select.after('<div class="invalid-feedback">Gagal memuat data</div>');
                }
            });
        }

        loadOptions();

        $select.on("mousedown", function(e) {
            if ($select.find('option').length <= 1) {
                loadOptions();
            }
        });

        window["refreshDropdown_<?= esc($name) ?>"] = loadOptions;

        $(document).on('refresh-dropdown:' + selector, function() {
            loadOptions();
        });
    }
</script>