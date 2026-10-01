<!-- Select2 JS -->
<script src="<?= base_url('plugins/select2/js/select2.min.js') ?>"></script>

<script>
    // Helper functions untuk dropdown
    $(document).ready(function() {
        // Fungsi refresh semua dropdown
        window.refreshAllDropdowns = function() {
            $(document).trigger('refresh-all-dropdowns');
        };

        // Fungsi refresh dropdown by ID
        window.refreshDropdown = function(id) {
            $(document).trigger('refresh-dropdown:#' + id);
        };

        // Fungsi set value dropdown
        window.setDropdownValue = function(id, value) {
            const funcName = 'dropdown_' + id.replace(/-/g, '_');
            if (window[funcName]) {
                window[funcName].setValue(value);
            } else {
                $('#' + id).val(value).trigger('change');
            }
        };

        // Fungsi get value dropdown
        window.getDropdownValue = function(id) {
            const funcName = 'dropdown_' + id.replace(/-/g, '_');
            if (window[funcName]) {
                return window[funcName].getValue();
            }
            return $('#' + id).val();
        };
    });
</script>