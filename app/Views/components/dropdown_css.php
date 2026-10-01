<!-- Select2 CSS -->
<link rel="stylesheet" href="<?= base_url('plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">

<style>
    /* Style untuk Select2 */
    .select2-container--bootstrap4 .select2-selection {
        min-height: 31px !important;
        font-size: .720rem !important;
    }

    .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
        line-height: 29px !important;
        padding-left: 12px !important;
    }

    .select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow {
        height: 29px !important;
    }

    .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__rendered {
        padding: 2px 6px !important;
    }

    .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice {
        font-size: .720rem !important;
        padding: 2px 10px !important;
        margin: 2px 0 !important;
    }

    .select2-container--bootstrap4 .select2-selection--multiple .select2-search--inline .select2-search__field {
        font-size: .720rem !important;
        min-height: 24px !important;
    }

    /* Dropdown items */
    .select2-container--bootstrap4 .select2-results__option {
        font-size: .720rem !important;
        padding: 4px 12px !important;
    }

    /* Dropdown search */
    .select2-container--bootstrap4 .select2-search--dropdown .select2-search__field {
        font-size: .720rem !important;
        padding: 4px 8px !important;
    }

    /* Error state */
    .select2-container--bootstrap4.select2-container--focus .select2-selection,
    .select2-container--bootstrap4.select2-container--open .select2-selection {
        border-color: #80bdff !important;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25) !important;
    }

    .is-invalid~.select2-container--bootstrap4 .select2-selection {
        border-color: #dc3545 !important;
    }

    .is-invalid~.select2-container--bootstrap4.select2-container--focus .select2-selection {
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
    }
</style>