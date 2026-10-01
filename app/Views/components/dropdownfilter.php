<div class="mb-3">
    <select
        id="<?= esc($id) ?>"
        name="<?= esc($name) ?>"
        class="form-control form-control-sm select2 <?= isset($errors[$name]) ? 'is-invalid' : '' ?>"
        data-api-url="<?= esc($apiUrl) ?>"
        data-selected="<?= esc($selected ?? '') ?>"
        data-extra-keys='<?= json_encode($extraKeys ?? []) ?>'
        data-in-filter='<?= json_encode($inFilter ?? []) ?>'
        data-notin-filter='<?= json_encode($notInFilter ?? []) ?>'>
        <option value="">--Loading--</option>
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
            initializeDropdown('#<?= esc($id) ?>');
        });
    });

    function initializeDropdown(selector) {
        const $select = $(selector);

        const apiUrl = $select.data('api-url');
        const selectedValue = $select.data('selected');
        const extraKeys = $select.data('extra-keys') || {};

        // Parse filter JSON dari atribut
        let inFilter = {};
        let notInFilter = {};
        try {
            const inFilterRaw = $select.attr('data-in-filter');
            const notInFilterRaw = $select.attr('data-notin-filter');
            if (inFilterRaw && inFilterRaw !== '{}') inFilter = JSON.parse(inFilterRaw);
            if (notInFilterRaw && notInFilterRaw !== '{}') notInFilter = JSON.parse(notInFilterRaw);
        } catch (e) {
            console.error("Error parsing filter JSON:", e);
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
                            let include = true;

                            // Filter IN
                            Object.keys(inFilter).forEach(function(field) {
                                const allowedValues = inFilter[field];
                                if (!allowedValues.includes(String(item[field]))) {
                                    include = false;
                                }
                            });

                            // Filter NOT IN
                            Object.keys(notInFilter).forEach(function(field) {
                                const blockedValues = notInFilter[field];
                                if (blockedValues.includes(String(item[field]))) {
                                    include = false;
                                }
                            });

                            if (!include) return;

                            const $option = $("<option>")
                                .val(item.value || item.id || item.cd)
                                .text(item.desc || item.name || item.text);

                            if (extraKeys && typeof extraKeys === 'object') {
                                Object.keys(extraKeys).forEach(function(dataAttr) {
                                    const fieldName = extraKeys[dataAttr];
                                    if (item[fieldName]) {
                                        $option.attr(dataAttr, item[fieldName]);
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

                    // Destroy dan re-init Select2 agar hanya option hasil filter yang tampil
                    if ($select.hasClass("select2")) {
                        $select.select2("destroy").select2();
                    }
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
    }
</script>