<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Auth\login');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override(
    // function () {
    //     return view('404.php');
    // }
);
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

$routes->group('allergy-intolerance', function ($routes) {
    $routes->get('/',                  'AllergyIntoleranceController::index');
    $routes->get('create',             'AllergyIntoleranceController::create');
    $routes->post('store',             'AllergyIntoleranceController::store');
    $routes->get('edit/(:segment)',    'AllergyIntoleranceController::edit/$1');
    $routes->post('update/(:segment)', 'AllergyIntoleranceController::update/$1');
    $routes->get('delete/(:segment)',  'AllergyIntoleranceController::delete/$1');
    $routes->get('debug/(:segment)',   'AllergyIntoleranceController::debug/$1');
});

$routes->group('patiens', function ($routes) {
    $routes->get('/',                  'PatiensController::index');
    $routes->get('create',             'PatiensController::create');
    $routes->post('store',             'PatiensController::store');
    $routes->get('edit/(:segment)',    'PatiensController::edit/$1');
    $routes->post('update/(:segment)', 'PatiensController::update/$1');
    $routes->get('debug/(:segment)',   'PatiensController::debug/$1');
    $routes->get('test-doc',           'PatiensController::testDoc');
});

// $routes->group('observation', function ($routes) {
//     $routes->get('/',                  'ObservationController::index');
//     $routes->get('create',             'ObservationController::create');
//     $routes->post('store',             'ObservationController::store');
//     $routes->get('edit/(:segment)',    'ObservationController::edit/$1');
//     $routes->post('update/(:segment)', 'ObservationController::update/$1');
//     $routes->get('delete/(:segment)',  'ObservationController::delete/$1');
//     $routes->get('debug/(:segment)',   'ObservationController::debug/$1');
//     $routes->get('test-doc',           'ObservationController::testDoc');
// });

$routes->group('observation', function ($routes) {
    $routes->get('/',                  'ObservationController::index');
    $routes->get('create',             'ObservationController::create');
    $routes->post('store',             'ObservationController::store');
    $routes->get('edit/(:segment)',    'ObservationController::edit/$1');
    $routes->post('update/(:segment)', 'ObservationController::update/$1');
    $routes->get('delete/(:segment)',  'ObservationController::delete/$1');
    $routes->get('debug/(:segment)',   'ObservationController::debug/$1');
});

$routes->group('diagnostic-report', function ($routes) {
    $routes->get('/',                  'DiagnosticReportController::index');
    $routes->get('create',             'DiagnosticReportController::create');
    $routes->post('store',             'DiagnosticReportController::store');
    $routes->get('edit/(:segment)',    'DiagnosticReportController::edit/$1');
    $routes->post('update/(:segment)', 'DiagnosticReportController::update/$1');
    $routes->get('delete/(:segment)',  'DiagnosticReportController::delete/$1');
    $routes->get('debug/(:segment)',   'DiagnosticReportController::debug/$1');
    $routes->get('test-doc',           'DiagnosticReportController::testDoc');
});

$routes->group('procedure', function ($routes) {
    $routes->get('/',                  'ProcedureController::index');
    $routes->get('create',             'ProcedureController::create');
    $routes->post('store',             'ProcedureController::store');
    $routes->get('edit/(:segment)',    'ProcedureController::edit/$1');
    $routes->post('update/(:segment)', 'ProcedureController::update/$1');
    $routes->get('delete/(:segment)',  'ProcedureController::delete/$1');
    $routes->get('debug/(:segment)',   'ProcedureController::debug/$1');
    $routes->get('test-doc',           'ProcedureController::testDoc');
});

$routes->group('medication-dispense', function ($routes) {
    $routes->get('/',                  'MedicationDispenseController::index');
    $routes->get('create',             'MedicationDispenseController::create');
    $routes->post('store',             'MedicationDispenseController::store');
    $routes->get('edit/(:segment)',    'MedicationDispenseController::edit/$1');
    $routes->post('update/(:segment)', 'MedicationDispenseController::update/$1');
    $routes->get('delete/(:segment)',  'MedicationDispenseController::delete/$1');
    $routes->get('debug/(:segment)',   'MedicationDispenseController::debug/$1');
});

$routes->group('medication', function ($routes) {
    $routes->get('/',                  'MedicationController::index');
    $routes->get('create',             'MedicationController::create');
    $routes->post('store',             'MedicationController::store');
    $routes->get('edit/(:segment)',    'MedicationController::edit/$1');
    $routes->post('update/(:segment)', 'MedicationController::update/$1');
    $routes->get('delete/(:segment)',  'MedicationController::delete/$1');
    $routes->get('debug/(:segment)',   'MedicationController::debug/$1');
});

$routes->group('medication-request', function ($routes) {
    $routes->get('/',                  'MedicationRequestController::index');
    $routes->get('create',             'MedicationRequestController::create');
    $routes->post('store',             'MedicationRequestController::store');
    $routes->get('edit/(:segment)',    'MedicationRequestController::edit/$1');
    $routes->post('update/(:segment)', 'MedicationRequestController::update/$1');
    $routes->get('delete/(:segment)',  'MedicationRequestController::delete/$1');
    $routes->get('debug/(:segment)',   'MedicationRequestController::debug/$1');
    $routes->get('test-doc',           'MedicationRequestController::testDoc');
});

$routes->group('specimen', function ($routes) {
    $routes->get('/',                  'SpecimenController::index');
    $routes->get('create',             'SpecimenController::create');
    $routes->post('store',             'SpecimenController::store');
    $routes->get('edit/(:segment)',    'SpecimenController::edit/$1');
    $routes->post('update/(:segment)', 'SpecimenController::update/$1');
    $routes->get('delete/(:segment)',  'SpecimenController::delete/$1');
    $routes->get('debug/(:segment)',   'SpecimenController::debug/$1');
    $routes->get('test-doc',           'SpecimenController::testDoc');
});

$routes->group('condition', function ($routes) {
    $routes->get('/',                  'ConditionController::index');
    $routes->get('create',             'ConditionController::create');
    $routes->post('store',             'ConditionController::store');
    $routes->get('edit/(:segment)',    'ConditionController::edit/$1');
    $routes->post('update/(:segment)', 'ConditionController::update/$1');
    $routes->get('delete/(:segment)',  'ConditionController::delete/$1');
    $routes->get('debug/(:segment)',   'ConditionController::debug/$1');
    $routes->get('test-doc',           'ConditionController::testDoc');
    $routes->get('test-get',           'ConditionController::testGet');
});

$routes->group('service-request', function ($routes) {
    $routes->get('/',                  'ServiceRequestController::index');
    $routes->get('create',             'ServiceRequestController::create');
    $routes->post('store',             'ServiceRequestController::store');
    $routes->get('edit/(:segment)',    'ServiceRequestController::edit/$1');
    $routes->post('update/(:segment)', 'ServiceRequestController::update/$1');
    $routes->get('delete/(:segment)',  'ServiceRequestController::delete/$1');
    $routes->get('debug/(:segment)',   'ServiceRequestController::debug/$1');
    $routes->get('test-doc',           'ServiceRequestController::testDoc');
});

$routes->group('encounter', function ($routes) {
    $routes->get('/',            'EncounterController::index');
    $routes->get('create',       'EncounterController::create');
    $routes->post('store',       'EncounterController::store');
    $routes->get('edit/(:segment)', 'EncounterController::edit/$1');
    $routes->post('update/(:segment)', 'EncounterController::update/$1');
    $routes->get('delete/(:segment)', 'EncounterController::delete/$1');
    $routes->get('debug/(:segment)', 'EncounterController::debug/$1');
    $routes->get('test-doc', 'EncounterController::testDoc');
});

$routes->group('satusehat', function ($routes) {
    $routes->get('/',       'SatusehatController::index');
    $routes->get('patient/(:segment)',       'SatusehatController::getPatient/$1');
    $routes->get('patient-search',            'SatusehatController::searchPatientByNik');
    $routes->get('organization/(:segment)',   'SatusehatController::getOrganization/$1');
    $routes->post('encounter',                'SatusehatController::createEncounter');
    $routes->get('debug-token',               'SatusehatController::debugToken');
    $routes->post('refresh-token',            'SatusehatController::refreshToken');
});

$routes->get('/observasi', 'Observasi::index', ['filter' => 'auth']);
$routes->get('/observasi/fetchAll', 'Observasi::fetchAll', ['filter' => 'auth']);
$routes->get('/observasi/fetchObservasiByRegistrasi', 'Observasi::fetchObservasiByRegistrasi', ['filter' => 'auth']);
$routes->post('/observasi/action', 'Observasi::action', ['filter' => 'auth']);
$routes->get('/observasi/setNoRegistrasi', 'Observasi::setNoRegistrasi', ['filter' => 'auth']);
$routes->get('/observasi/printObservasi/(:any)', 'Observasi::printObservasi/$1', ['filter' => 'auth']);
$routes->post('/observasi/delete', 'Observasi::delete', ['filter' => 'auth']);
$routes->get('observasi/setDataPemeriksaanPerawat', 'Observasi::setDataPemeriksaanPerawat');
$routes->get('/observasi/getPostTindakanForPetunjuk', 'Observasi::getPostTindakanForPetunjuk', ['filter' => 'auth']);

$routes->get('/rmriwayatmedis', 'RmRiwayatMedis::index', ['filter' => 'auth']);
$routes->post('/rmriwayatmedis/searchPatient', 'RmRiwayatMedis::searchPatient', ['filter' => 'auth']);
$routes->post('/rmriwayatmedis/getPatientDetail', 'RmRiwayatMedis::getPatientDetail', ['filter' => 'auth']);
$routes->post('/rmriwayatmedis/getRiwayatKunjungan', 'RmRiwayatMedis::getRiwayatKunjungan', ['filter' => 'auth']);
$routes->post('/rmriwayatmedis/getAlergi', 'RmRiwayatMedis::getAlergi', ['filter' => 'auth']);
$routes->post('/rmriwayatmedis/getDiagnosis', 'RmRiwayatMedis::getDiagnosis', ['filter' => 'auth']);
$routes->post('/rmriwayatmedis/getDetailKunjungan', 'RmRiwayatMedis::getDetailKunjungan', ['filter' => 'auth']);

// // Route untuk RM Riwayat Medis
$routes->get('/rmriwayatmedis/kunjungan/(:any)', 'RmRiwayatMedis::kunjungan/$1', ['filter' => 'auth']);
$routes->get('/rmriwayatmedis/alergi/(:any)', 'RmRiwayatMedis::alergi/$1', ['filter' => 'auth']);
$routes->get('/rmriwayatmedis/diagnosis/(:any)', 'RmRiwayatMedis::diagnosis/$1', ['filter' => 'auth']);
$routes->post('/rmriwayatmedis/getDetailPageDataKunjungan', 'RmRiwayatMedis::getDetailPageDataKunjungan', ['filter' => 'auth']);
$routes->post('/rmriwayatmedis/getDetailPageDataAlergi', 'RmRiwayatMedis::getDetailPageDataAlergi', ['filter' => 'auth']);
$routes->post('/rmriwayatmedis/getDetailPageDataDiagnosis', 'RmRiwayatMedis::getDetailPageDataDiagnosis', ['filter' => 'auth']);

$routes->get('/skriningizi', 'Skriningizi::index', ['filter' => 'auth']);
$routes->get('/skriningizi/fetchAll', 'Skriningizi::fetchAll', ['filter' => 'auth']);
$routes->get('/skriningizi/fetchByRegistrasi', 'Skriningizi::fetchByRegistrasi', ['filter' => 'auth']);
$routes->post('/skriningizi/action', 'Skriningizi::action', ['filter' => 'auth']);
$routes->post('/skriningizi/delete', 'Skriningizi::delete', ['filter' => 'auth']);
$routes->get('/skriningizi/setNoRegistrasi', 'Skriningizi::setNoRegistrasi', ['filter' => 'auth']);
$routes->get('/skriningizi/printSkriningGizi/(:any)', 'Skriningizi::printSkriningGizi/$1', ['filter' => 'auth']);

$routes->get('/listbilling', 'Listbilling::index', ['filter' => 'auth']);
$routes->get('/listbilling/fetchFilterOptions', 'Listbilling::fetchFilterOptions', ['filter' => 'auth']);
$routes->get('/listbilling/fetchKasirList', 'Listbilling::fetchKasirList', ['filter' => 'auth']);
$routes->get('/listbilling/fetchSingleData/(:any)', 'Listbilling::fetchSingleData/$1', ['filter' => 'auth']);
$routes->get('/listbilling/fetchCanVoid/(:any)', 'Listbilling::fetchCanVoid/$1', ['filter' => 'auth']);
$routes->get('/listbilling/fetchSingleDataPrint/(:any)', 'Listbilling::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/listbilling/void', 'Listbilling::void', ['filter' => 'auth']);
$routes->post('/listbilling/reprint', 'Listbilling::reprint', ['filter' => 'auth']);
$routes->post('/listbilling/datatables', 'Listbilling::datatables', ['filter' => 'auth']);

// Billing / Riwayat Transaksi
// $routes->get('/billing', 'Billing::index', ['filter' => 'auth']);
// $routes->post('/billing/datatables', 'Billing::datatables', ['filter' => 'auth']);
// $routes->post('/billing/search', 'Billing::search', ['filter' => 'auth']);
// $routes->get('/billing/detail', 'Billing::detail', ['filter' => 'auth']);
// $routes->post('/billing/printReceipt', 'Billing::printReceipt', ['filter' => 'auth']);
// $routes->post('/billing/void', 'Billing::void', ['filter' => 'auth']);
// $routes->get('/billing/canVoid', 'Billing::canVoid', ['filter' => 'auth']);
// $routes->get('/billing/shiftSummary', 'Billing::shiftSummary', ['filter' => 'auth']);
// $routes->get('/billing/filterOptions', 'Billing::filterOptions', ['filter' => 'auth']);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// ── Routes Master Titik Keluhan (CRUD) ────────────────────
// $routes->get('/titikkeluhan', 'TitikKeluhan::index', ['filter' => 'auth']);
// $routes->get('/titikkeluhan/get-subunit-select2', 'TitikKeluhan::getSubUnitSelect2', ['filter' => 'auth']);
// $routes->get('/titikkeluhan/fetchSingleData', 'TitikKeluhan::fetchSingleData', ['filter' => 'auth']);
// $routes->post('/titikkeluhan/datatables', 'TitikKeluhan::datatables', ['filter' => 'auth']);
// $routes->post('/titikkeluhan/action', 'TitikKeluhan::action', ['filter' => 'auth']);
// $routes->post('/titikkeluhan/delete', 'TitikKeluhan::delete', ['filter' => 'auth']);

$routes->group('titikkeluhans', function ($routes) {
    $routes->get('/', 'Titikkeluhans::index');
    $routes->post('datatables', 'Titikkeluhans::datatables');
    $routes->post('action', 'Titikkeluhans::action');
    $routes->post('delete', 'Titikkeluhans::delete');
    $routes->get('fetchSingleData', 'Titikkeluhans::fetchSingleData');
    $routes->get('subunitOptions', 'Titikkeluhans::subunitOptions');
    $routes->match(['get', 'post'], 'preview', 'Titikkeluhans::preview');
    $routes->post('upload', 'Titikkeluhans::upload');
    $routes->get('download', 'Titikkeluhans::download');
});

// Upload gambar untuk master data Titik Keluhan (dipakai oleh tombol Upload di CRUD)
$routes->post('titikkeluhans/uploadGambar', 'Titikkeluhans::uploadGambar', ['filter' => 'auth']);


$routes->get('/tmstobatbaru', 'Tmstobatbaru::index', ['filter' => 'auth']);
$routes->get('/tmstobatbaru/getDropdowns', 'Tmstobatbaru::getDropdowns', ['filter' => 'auth']);
$routes->get('/tmstobatbaru/fetchSingleData', 'Tmstobatbaru::fetchSingleData', ['filter' => 'auth']);
$routes->post('/tmstobatbaru/action', 'Tmstobatbaru::action', ['filter' => 'auth']);
$routes->post('/tmstobatbaru/delete', 'Tmstobatbaru::delete', ['filter' => 'auth']);
$routes->get('/tmstobatbaru/download', 'Tmstobatbaru::download');
$routes->post('/tmstobatbaru/upload', 'Tmstobatbaru::upload');
$routes->post('/tmstobatbaru/datatables', 'Tmstobatbaru::datatables');
$routes->match(['get', 'post'], '/tmstobatbaru/preview', 'Tmstobatbaru::preview');
$routes->get('/tmstobatbaru/general', 'Tmstobatbaru::general', ['filter' => 'auth']);
$routes->post('/tmstobatbaru/saveGeneral', 'Tmstobatbaru::saveGeneral', ['filter' => 'auth']);
$routes->get('/tmstobatbaru/drugDetail/(:any)', 'Tmstobatbaru::drugDetail/$1', ['filter' => 'auth']);
$routes->post('/tmstobatbaru/saveDrugDetail/(:any)', 'Tmstobatbaru::saveDrugDetail/$1', ['filter' => 'auth']);
$routes->get('/tmstobatbaru/uomConversion/(:any)', 'Tmstobatbaru::uomConversion/$1', ['filter' => 'auth']);
$routes->post('/tmstobatbaru/saveUom/(:any)', 'Tmstobatbaru::saveUom/$1', ['filter' => 'auth']);
$routes->delete('/tmstobatbaru/deleteUom/(:any)/(:any)', 'Tmstobatbaru::deleteUom/$1/$2', ['filter' => 'auth']);
$routes->get('/tmstobatbaru/harga/(:any)', 'Tmstobatbaru::harga/$1', ['filter' => 'auth']);
$routes->post('/tmstobatbaru/saveHarga/(:any)', 'Tmstobatbaru::saveHarga/$1', ['filter' => 'auth']);
$routes->delete('/tmstobatbaru/deleteHarga/(:any)/(:any)', 'Tmstobatbaru::deleteHarga/$1/$2', ['filter' => 'auth']);
$routes->get('/tmstobatbaru/supplier/(:any)', 'Tmstobatbaru::supplier/$1', ['filter' => 'auth']);
$routes->post('/tmstobatbaru/saveSupplier/(:any)', 'Tmstobatbaru::saveSupplier/$1', ['filter' => 'auth']);
$routes->delete('/tmstobatbaru/deleteSupplier/(:any)/(:any)', 'Tmstobatbaru::deleteSupplier/$1/$2', ['filter' => 'auth']);
$routes->get('/tmstobatbaru/stock/(:any)', 'Tmstobatbaru::stock/$1', ['filter' => 'auth']);
$routes->post('/tmstobatbaru/saveStock/(:any)', 'Tmstobatbaru::saveStock/$1', ['filter' => 'auth']);
$routes->post('/tmstobatbaru/saveBatch/(:any)', 'Tmstobatbaru::saveBatch/$1', ['filter' => 'auth']);
$routes->delete('/tmstobatbaru/deleteStock/(:any)/(:num)', 'Tmstobatbaru::deleteStock/$1/$2', ['filter' => 'auth']);
$routes->get('/tmstobatbaru/dokumen/(:any)', 'Tmstobatbaru::dokumen/$1', ['filter' => 'auth']);
$routes->post('/tmstobatbaru/saveDokumen/(:any)', 'Tmstobatbaru::saveDokumen/$1', ['filter' => 'auth']);
$routes->delete('/tmstobatbaru/deleteDokumen/(:any)/(:any)', 'Tmstobatbaru::deleteDokumen/$1/$2', ['filter' => 'auth']);
$routes->get('/tmstobatbaru/getKategoriDropdown', 'Tmstobatbaru::getKategoriDropdown', ['filter' => 'auth']);
$routes->get('/tmstobatbaru/getGroupDropdown', 'Tmstobatbaru::getGroupDropdown', ['filter' => 'auth']);
$routes->get('/tmstobatbaru/getSubGroupDropdown', 'Tmstobatbaru::getSubGroupDropdown', ['filter' => 'auth']);
$routes->get('/tmstobatbaru/getSatuanDropdown', 'Tmstobatbaru::getSatuanDropdown', ['filter' => 'auth']);
$routes->get('/tmstobatbaru/getKelasHargaDropdown', 'Tmstobatbaru::getKelasHargaDropdown', ['filter' => 'auth']);
$routes->get('/tmstobatbaru/getSummary', 'Tmstobatbaru::getSummary', ['filter' => 'auth']);
$routes->get('/tmstobatbaru/getDosageFormDropdown', 'Tmstobatbaru::getDosageFormDropdown', ['filter' => 'auth']);
$routes->get('/tmstobatbaru/getFixedEnums', 'Tmstobatbaru::getFixedEnums', ['filter' => 'auth']);
$routes->get('/tmstobatbaru/getSupplierDropdown', 'Tmstobatbaru::getSupplierDropdown', ['filter' => 'auth']);
$routes->get('/tmstobatbaru/getPrincipalDropdown', 'Tmstobatbaru::getPrincipalDropdown', ['filter' => 'auth']);

/* baru3 */

// ==================== KONSULTASI DOKTER 2 ====================

// Main page
$routes->get('/konsultasidokter3', 'Konsultasidokter3::index', ['filter' => 'auth']);
$routes->get('/konsultasidokter3/index', 'Konsultasidokter3::index', ['filter' => 'auth']);

// API Data
$routes->get('/konsultasidokter3/apiDataLabGetAll', 'Konsultasidokter3::apiDataLabGetAll', ['filter' => 'auth']);
$routes->get('/konsultasidokter3/apiDataRadiologiGetAll', 'Konsultasidokter3::apiDataRadiologiGetAll', ['filter' => 'auth']);
$routes->get('/konsultasidokter3/apiDataGetTindakan', 'Konsultasidokter3::apiDataGetTindakan', ['filter' => 'auth']);
$routes->get('/konsultasidokter3/apiDataGetAnamnesa', 'Konsultasidokter3::apiDataGetAnamnesa', ['filter' => 'auth']);
$routes->get('/konsultasidokter3/apiDataGetPeriksa', 'Konsultasidokter3::apiDataGetPeriksa', ['filter' => 'auth']);
$routes->get('/konsultasidokter3/apiDataGetDiagnosa', 'Konsultasidokter3::apiDataGetDiagnosa', ['filter' => 'auth']);
$routes->get('/konsultasidokter3/apiDataGetRujukan', 'Konsultasidokter3::apiDataGetRujukan', ['filter' => 'auth']);
$routes->get('/konsultasidokter3/apiDataGetAlergiByPasien', 'Konsultasidokter3::apiDataGetAlergiByPasien', ['filter' => 'auth']);
$routes->get('/konsultasidokter3/apiDataGetDiagnosaTambahanByRegistrasi', 'Konsultasidokter3::apiDataGetDiagnosaTambahanByRegistrasi', ['filter' => 'auth']);
$routes->get('/konsultasidokter3/apiDataGetByDokter', 'Konsultasidokter3::apiDataGetByDokter', ['filter' => 'auth']);
$routes->get('/konsultasidokter3/apiDataGetByNoRegistrasi', 'Konsultasidokter3::apiDataGetByNoRegistrasi', ['filter' => 'auth']);

// Fetch Views
$routes->get('/konsultasidokter3/fetchAll', 'Konsultasidokter3::fetchAll', ['filter' => 'auth']);
$routes->get('/konsultasidokter3/fetchAllRiwayatCardByPasien', 'Konsultasidokter3::fetchAllRiwayatCardByPasien', ['filter' => 'auth']);
$routes->get('/konsultasidokter3/fetchAllAnamnesaCardByPasien', 'Konsultasidokter3::fetchAllAnamnesaCardByPasien', ['filter' => 'auth']);
$routes->get('/konsultasidokter3/fetchAllAlergi', 'Konsultasidokter3::fetchAllAlergi', ['filter' => 'auth']);

// Surat
$routes->get('/konsultasidokter3/headerRujukan', 'Konsultasidokter3::headerRujukan', ['filter' => 'auth']);
$routes->get('/konsultasidokter3/titikKeluhan', 'Konsultasidokter3::titikKeluhan', ['filter' => 'auth']);
$routes->get('/konsultasidokter3/suratLayakTerbang', 'Konsultasidokter3::suratLayakTerbang', ['filter' => 'auth']);
$routes->get('/konsultasidokter3/suratLayakTerbangIbuHamil', 'Konsultasidokter3::suratLayakTerbangIbuHamil', ['filter' => 'auth']);
$routes->get('/konsultasidokter3/suratKeteranganIstirahat', 'Konsultasidokter3::suratKeteranganIstirahat', ['filter' => 'auth']);
$routes->get('/konsultasidokter3/suratKeteranganDokter', 'Konsultasidokter3::suratKeteranganDokter', ['filter' => 'auth']);
$routes->get('/konsultasidokter3/suratKeteranganSehat', 'Konsultasidokter3::suratKeteranganSehat', ['filter' => 'auth']);

// PDF Print
$routes->get('/konsultasidokter3/print/(:any)', 'Konsultasidokter3::fetchSingleDataPrint/$1', ['filter' => 'auth']);

// Session
$routes->get('/konsultasidokter3/setNoRegistrasi', 'Konsultasidokter3::setNoRegistrasi', ['filter' => 'auth']);

// Draw Pages (Titik Keluhan)

$routes->get('/konsultasidokter3/draw/(:segment)', 'Konsultasidokter3::draw/$1', ['filter' => 'auth']);
$routes->get('/konsultasidokter3/getTitikKeluhanOptions', 'Konsultasidokter3::getTitikKeluhanOptions', ['filter' => 'auth']);

// Upload
$routes->post('/konsultasidokter3/doupload1', 'Konsultasidokter3::doupload1', ['filter' => 'auth']);

// AJAX Dropdown
$routes->get('/konsultasidokter3/ajaxKategoriAlergi/(:any)', 'Konsultasidokter3::ajaxKategoriAlergi/$1', ['filter' => 'auth']);
$routes->get('/konsultasidokter3/ajaxKategoriBiaya/(:any)', 'Konsultasidokter3::ajaxKategoriBiaya/$1', ['filter' => 'auth']);
$routes->get('/konsultasidokter3/getDropdownLayananItem', 'Konsultasidokter3::getDropdownLayananItem', ['filter' => 'auth']);

// Actions
$routes->post('/konsultasidokter3/action_rujukan', 'Konsultasidokter3::action_rujukan', ['filter' => 'auth']);
$routes->post('/konsultasidokter3/action_all', 'Konsultasidokter3::action_all', ['filter' => 'auth']);

// Delete
$routes->post('/konsultasidokter3/delete_alergi', 'Konsultasidokter3::delete_alergi', ['filter' => 'auth']);
$routes->post('/konsultasidokter3/delete_diagnosa', 'Konsultasidokter3::delete_diagnosa', ['filter' => 'auth']);
$routes->post('/konsultasidokter3/action2', 'Konsultasidokter3::action2', ['filter' => 'auth']);

/* end baru3 */

/* baru2 */

// ==================== KONSULTASI DOKTER 2 ====================

// Main page
$routes->get('/konsultasidokter2', 'Konsultasidokter2::index', ['filter' => 'auth']);
$routes->get('/konsultasidokter2/index', 'Konsultasidokter2::index', ['filter' => 'auth']);

// API Data
$routes->get('/konsultasidokter2/apiDataLabGetAll', 'Konsultasidokter2::apiDataLabGetAll', ['filter' => 'auth']);
$routes->get('/konsultasidokter2/apiDataRadiologiGetAll', 'Konsultasidokter2::apiDataRadiologiGetAll', ['filter' => 'auth']);
$routes->get('/konsultasidokter2/apiDataGetTindakan', 'Konsultasidokter2::apiDataGetTindakan', ['filter' => 'auth']);
$routes->get('/konsultasidokter2/apiDataGetAnamnesa', 'Konsultasidokter2::apiDataGetAnamnesa', ['filter' => 'auth']);
$routes->get('/konsultasidokter2/apiDataGetPeriksa', 'Konsultasidokter2::apiDataGetPeriksa', ['filter' => 'auth']);
$routes->get('/konsultasidokter2/apiDataGetDiagnosa', 'Konsultasidokter2::apiDataGetDiagnosa', ['filter' => 'auth']);
$routes->get('/konsultasidokter2/apiDataGetRujukan', 'Konsultasidokter2::apiDataGetRujukan', ['filter' => 'auth']);
$routes->get('/konsultasidokter2/apiDataGetAlergiByPasien', 'Konsultasidokter2::apiDataGetAlergiByPasien', ['filter' => 'auth']);
$routes->get('/konsultasidokter2/apiDataGetDiagnosaTambahanByRegistrasi', 'Konsultasidokter2::apiDataGetDiagnosaTambahanByRegistrasi', ['filter' => 'auth']);
$routes->get('/konsultasidokter2/apiDataGetByDokter', 'Konsultasidokter2::apiDataGetByDokter', ['filter' => 'auth']);
$routes->get('/konsultasidokter2/apiDataGetByNoRegistrasi', 'Konsultasidokter2::apiDataGetByNoRegistrasi', ['filter' => 'auth']);

// Fetch Views
$routes->get('/konsultasidokter2/fetchAll', 'Konsultasidokter2::fetchAll', ['filter' => 'auth']);
$routes->get('/konsultasidokter2/fetchAllRiwayatCardByPasien', 'Konsultasidokter2::fetchAllRiwayatCardByPasien', ['filter' => 'auth']);
$routes->get('/konsultasidokter2/fetchAllAnamnesaCardByPasien', 'Konsultasidokter2::fetchAllAnamnesaCardByPasien', ['filter' => 'auth']);
$routes->get('/konsultasidokter2/fetchAllAlergi', 'Konsultasidokter2::fetchAllAlergi', ['filter' => 'auth']);

// Surat
$routes->get('/konsultasidokter2/headerRujukan', 'Konsultasidokter2::headerRujukan', ['filter' => 'auth']);
$routes->get('/konsultasidokter2/titikKeluhan', 'Konsultasidokter2::titikKeluhan', ['filter' => 'auth']);
$routes->get('/konsultasidokter2/suratLayakTerbang', 'Konsultasidokter2::suratLayakTerbang', ['filter' => 'auth']);
$routes->get('/konsultasidokter2/suratLayakTerbangIbuHamil', 'Konsultasidokter2::suratLayakTerbangIbuHamil', ['filter' => 'auth']);
$routes->get('/konsultasidokter2/suratKeteranganIstirahat', 'Konsultasidokter2::suratKeteranganIstirahat', ['filter' => 'auth']);
$routes->get('/konsultasidokter2/suratKeteranganDokter', 'Konsultasidokter2::suratKeteranganDokter', ['filter' => 'auth']);
$routes->get('/konsultasidokter2/suratKeteranganSehat', 'Konsultasidokter2::suratKeteranganSehat', ['filter' => 'auth']);

// PDF Print
$routes->get('/konsultasidokter2/print/(:any)', 'Konsultasidokter2::fetchSingleDataPrint/$1', ['filter' => 'auth']);

// Session
$routes->get('/konsultasidokter2/setNoRegistrasi', 'Konsultasidokter2::setNoRegistrasi', ['filter' => 'auth']);

// Draw Pages (Titik Keluhan)
$routes->get('/konsultasidokter2/draw/(:segment)', 'Konsultasidokter2::draw/$1', ['filter' => 'auth']);
$routes->get('/konsultasidokter2/getTitikKeluhanOptions', 'Konsultasidokter2::getTitikKeluhanOptions', ['filter' => 'auth']);

// Upload
$routes->post('/konsultasidokter2/doupload1', 'Konsultasidokter2::doupload1', ['filter' => 'auth']);

// AJAX Dropdown
$routes->get('/konsultasidokter2/ajaxKategoriAlergi/(:any)', 'Konsultasidokter2::ajaxKategoriAlergi/$1', ['filter' => 'auth']);
$routes->get('/konsultasidokter2/ajaxKategoriBiaya/(:any)', 'Konsultasidokter2::ajaxKategoriBiaya/$1', ['filter' => 'auth']);
$routes->get('/konsultasidokter2/getDropdownLayananItem', 'Konsultasidokter2::getDropdownLayananItem', ['filter' => 'auth']);

// Actions
$routes->post('/konsultasidokter2/action_rujukan', 'Konsultasidokter2::action_rujukan', ['filter' => 'auth']);
$routes->post('/konsultasidokter2/action_all', 'Konsultasidokter2::action_all', ['filter' => 'auth']);

// Delete
$routes->post('/konsultasidokter2/delete_alergi', 'Konsultasidokter2::delete_alergi', ['filter' => 'auth']);
$routes->post('/konsultasidokter2/delete_diagnosa', 'Konsultasidokter2::delete_diagnosa', ['filter' => 'auth']);
$routes->post('/konsultasidokter2/action2', 'Konsultasidokter2::action2', ['filter' => 'auth']);

/* end baru2 */

$routes->get('/tmstpaketbaru/getItemTypeDropdown', 'Tmstpaketbaru::getItemTypeDropdown', ['filter' => 'auth']);
$routes->get('/tmstpaketbaru', 'Tmstpaketbaru::index', ['filter' => 'auth']);
$routes->get('/tmstpaketbaru/getKategoriDropdown', 'Tmstpaketbaru::getKategoriDropdown', ['filter' => 'auth']);
$routes->get('/tmstpaketbaru/fetchSingleData', 'Tmstpaketbaru::fetchSingleData', ['filter' => 'auth']);
$routes->post('/tmstpaketbaru/action', 'Tmstpaketbaru::action', ['filter' => 'auth']);
$routes->post('/tmstpaketbaru/delete', 'Tmstpaketbaru::delete', ['filter' => 'auth']);
$routes->get('/tmstpaketbaru/download', 'Tmstpaketbaru::download');
$routes->post('/tmstpaketbaru/upload', 'Tmstpaketbaru::upload');
$routes->post('/tmstpaketbaru/datatables', 'Tmstpaketbaru::datatables');
$routes->match(['get', 'post'], '/tmstpaketbaru/preview', 'Tmstpaketbaru::preview');
$routes->get('/tmstpaketbaru/packageComponents/(:any)', 'Tmstpaketbaru::packageComponents/$1', ['filter' => 'auth']);
$routes->post('/tmstpaketbaru/savePackageComponent/(:any)', 'Tmstpaketbaru::savePackageComponent/$1', ['filter' => 'auth']);
$routes->delete('/tmstpaketbaru/deletePackageComponent/(:any)/(:any)', 'Tmstpaketbaru::deletePackageComponent/$1/$2', ['filter' => 'auth']);
$routes->get('/tmstpaketbaru/searchItem', 'Tmstpaketbaru::searchItem', ['filter' => 'auth']);
$routes->get('/tmstpaketbaru/harga/(:any)', 'Tmstpaketbaru::harga/$1', ['filter' => 'auth']);
$routes->post('/tmstpaketbaru/saveHarga/(:any)', 'Tmstpaketbaru::saveHarga/$1', ['filter' => 'auth']);
$routes->delete('/tmstpaketbaru/deleteHarga/(:any)/(:any)', 'Tmstpaketbaru::deleteHarga/$1/$2', ['filter' => 'auth']);
$routes->get('/tmstpaketbaru/getSatuanDropdown', 'Tmstpaketbaru::getSatuanDropdown');
$routes->get('/tmstpaketbaru/getKelasHargaDropdown', 'Tmstpaketbaru::getKelasHargaDropdown');
// Save all components (replace)
$routes->post('/tmstpaketbaru/saveAllPackageComponents/(:any)', 'Tmstpaketbaru::saveAllPackageComponents/$1');
// Save all prices (replace)
$routes->post('/tmstpaketbaru/saveAllHarga/(:any)', 'Tmstpaketbaru::saveAllHarga/$1');

// ==================== TABEL MASTER TINDAKAN BARU ====================

// Tmsttindakanbaru Routes
$routes->get('/tmsttindakanbaru', 'Tmsttindakanbaru::index', ['filter' => 'auth']);
$routes->get('/tmsttindakanbaru/getDropdowns', 'Tmsttindakanbaru::getDropdowns', ['filter' => 'auth']);
$routes->get('/tmsttindakanbaru/fetchSingleData', 'Tmsttindakanbaru::fetchSingleData', ['filter' => 'auth']);
$routes->post('/tmsttindakanbaru/action', 'Tmsttindakanbaru::action', ['filter' => 'auth']);
$routes->post('/tmsttindakanbaru/delete', 'Tmsttindakanbaru::delete', ['filter' => 'auth']);
$routes->get('/tmsttindakanbaru/download', 'Tmsttindakanbaru::download');
$routes->post('/tmsttindakanbaru/upload', 'Tmsttindakanbaru::upload');
$routes->post('/tmsttindakanbaru/datatables', 'Tmsttindakanbaru::datatables');
$routes->match(['get', 'post'], '/tmsttindakanbaru/preview', 'Tmsttindakanbaru::preview');
$routes->get('tmsttindakanbaru/searchItem', 'Tmsttindakanbaru::searchItem');
$routes->get('/tmsttindakanbaru/getHarga/(:segment)', 'Tmsttindakanbaru::getHarga/$1', ['filter' => 'auth']);
$routes->post('/tmsttindakanbaru/saveHarga/(:segment)', 'Tmsttindakanbaru::saveHarga/$1', ['filter' => 'auth']);
$routes->post('/tmsttindakanbaru/deleteHarga/(:segment)/(:segment)', 'Tmsttindakanbaru::deleteHarga/$1/$2', ['filter' => 'auth']);
$routes->get('/tmsttindakanbaru/getKebutuhan/(:segment)', 'Tmsttindakanbaru::getKebutuhan/$1', ['filter' => 'auth']);
$routes->post('/tmsttindakanbaru/saveKebutuhan/(:segment)', 'Tmsttindakanbaru::saveKebutuhan/$1', ['filter' => 'auth']);
$routes->post('/tmsttindakanbaru/deleteKebutuhan/(:segment)/(:segment)', 'Tmsttindakanbaru::deleteKebutuhan/$1/$2', ['filter' => 'auth']);
$routes->get('/tmsttindakanbaru/getKategoriDropdown', 'Tmsttindakanbaru::getKategoriDropdown', ['filter' => 'auth']);
$routes->get('/tmsttindakanbaru/getJenisDropdown', 'Tmsttindakanbaru::getJenisDropdown', ['filter' => 'auth']);
$routes->get('/tmsttindakanbaru/getSatuanDropdown', 'Tmsttindakanbaru::getSatuanDropdown', ['filter' => 'auth']);
$routes->get('/tmsttindakanbaru/getKelasHargaDropdown', 'Tmsttindakanbaru::getKelasHargaDropdown', ['filter' => 'auth']);
$routes->get('/tmsttindakanbaru/getSummary', 'Tmsttindakanbaru::getSummary', ['filter' => 'auth']);

$routes->get('/tmstpayers', 'Tmstpayers::index', ['filter' => 'auth']);
$routes->get('/tmstpayers/fetchSingleData', 'Tmstpayers::fetchSingleData', ['filter' => 'auth']);
$routes->post('/tmstpayers/action', 'Tmstpayers::action', ['filter' => 'auth']);
$routes->post('/tmstpayers/delete', 'Tmstpayers::delete', ['filter' => 'auth']);
$routes->get('/tmstpayers/download', 'Tmstpayers::download');
$routes->post('/tmstpayers/upload', 'Tmstpayers::upload');
$routes->match(['get', 'post'], '/tmstpayers/preview', 'Tmstpayers::preview');
$routes->post('/tmstpayers/datatables', 'Tmstpayers::datatables');

// $routes->get('/deposit', 'Deposit::index', ['filter' => 'auth']);
// $routes->get('/deposit/fetchAll', 'Deposit::fetchAll', ['filter' => 'auth']);
// $routes->get('/deposit/fetchSingleData', 'Deposit::fetchSingleData', ['filter' => 'auth']);
// $routes->get('/deposit/fetchSingleDataPrint/(:any)', 'Deposit::fetchSingleDataPrint/$1', ['filter' => 'auth']);
// $routes->post('/deposit/action', 'Deposit::action', ['filter' => 'auth']);
// $routes->post('/deposit/delete', 'Deposit::delete', ['filter' => 'auth']);
// $routes->post('/deposit/store', 'Deposit::store', ['filter' => 'auth']);
// $routes->get('/deposit/registrasi', 'Deposit::fetchDataKasirListRegistrasi', ['filter' => 'auth']);
// $routes->get('/deposit/item', 'Deposit::fetchDataKasirListItem', ['filter' => 'auth']);
// $routes->get('/deposit/setnoregistrasi', 'Deposit::setNoRegistrasi', ['filter' => 'auth']);
// $routes->get('/deposit/removenoregistrasi', 'Deposit::removeNoRegistrasi', ['filter' => 'auth']);
// $routes->get('/deposit/ceksession', 'Deposit::checkSession', ['filter' => 'auth']);
// $routes->get('/deposit/nokwitansi', 'Deposit::apiDataGetNoKwitansi', ['filter' => 'auth']);
$routes->get('/deposit/listbilling', 'Deposit::fetchDataKasirListBilling', ['filter' => 'auth']);
// $routes->get('/deposit/print/(:any)', 'Deposit::fetchSingleDataPrint/$1', ['filter' => 'auth']);
// $routes->get('/deposit/edit/(:any)', 'Deposit::fetchSingleDataEdit/$1', ['filter' => 'auth']);
// $routes->get('/deposit/saldo', 'Deposit::getSaldo', ['filter' => 'auth']);
// $routes->get('/deposit/riwayat', 'Deposit::getRiwayat', ['filter' => 'auth']);
// $routes->get('/deposit/detail', 'Deposit::getDetailDeposit', ['filter' => 'auth']);
// $routes->post('/deposit/simpan', 'Deposit::simpanDeposit', ['filter' => 'auth']);
// $routes->post('/deposit/gunakan', 'Deposit::gunakanDeposit', ['filter' => 'auth']);
// $routes->post('/deposit/batal', 'Deposit::batalDeposit', ['filter' => 'auth']);
// $routes->get('deposit/tagihanpembayaran', 'Deposit::getTagihanPembayaran');
// $routes->get('deposit/payerlist', 'Deposit::payerList');
// $routes->get('deposit/ringkasanpembayaran', 'Deposit::getRingkasanPembayaran');
// $routes->post('deposit/prosespembayaran', 'Deposit::prosesPembayaran');
// $routes->get('deposit/kwitansiaktif', 'Deposit::getKwitansiAktif');
// $routes->get('deposit/riwayatpembayaran', 'Deposit::getRiwayatPembayaran');
// $routes->delete('deposit/batalpembayaran/(:any)', 'Deposit::batalPembayaran/$1');
// $routes->get('deposit/debugbilling', 'Deposit::debugBilling');
// $routes->post('/prints/print-history', 'Prints::savePrintHistory');
$routes->get('/deposit/print/(:any)', 'Deposit::fetchSingleDataPrint/$1', ['filter' => 'auth']);

// ── Halaman ──────────────────────────────────────────────────────────────────
$routes->get('/deposit', 'Deposit::index', ['filter' => 'auth']);
$routes->get('/deposit/edit', 'Deposit::edit', ['filter' => 'auth']);

// ── Registrasi (listing kunjungan untuk dipilih di layar Deposit) ───────────
// $routes->get('/deposit/registrasi', 'Deposit::apiDataGetRegistrasi');
$routes->get('/deposit/fetchall', 'Deposit::fetchAll', ['filter' => 'auth']);
$routes->get('/deposit/debugbilling', 'Deposit::debugBilling');

$routes->post('/deposit/hadir', 'Deposit::hadir');
$routes->post('/deposit/registrasi/batal', 'Deposit::batal', ['filter' => 'auth']);
$routes->post('/deposit/delete', 'Deposit::delete', ['filter' => 'auth']);
$routes->post('/deposit/store', 'Deposit::store', ['filter' => 'auth']);
$routes->post('/deposit/setnoregistrasi', 'Deposit::setNoRegistrasi', ['filter' => 'auth']);
$routes->post('/deposit/removenoregistrasi', 'Deposit::removeNoRegistrasi', ['filter' => 'auth']);

// ── Deposit (Kunjungan & Paket) ──────────────────────────────────────────────
$routes->get('/deposit/saldo', 'Deposit::getSaldo', ['filter' => 'auth']);
$routes->get('/deposit/riwayat', 'Deposit::getRiwayat', ['filter' => 'auth']);
$routes->get('/deposit/detail', 'Deposit::getDetailDeposit', ['filter' => 'auth']);
$routes->post('/deposit/simpan', 'Deposit::simpanDeposit', ['filter' => 'auth']);
$routes->post('/deposit/gunakan', 'Deposit::gunakanDeposit', ['filter' => 'auth']);
$routes->post('/deposit/batal', 'Deposit::batalDeposit', ['filter' => 'auth']);
$routes->post('/deposit/refund', 'Deposit::refundDeposit', ['filter' => 'auth']);

// ── Payment (tagihan & proses bayar) ─────────────────────────────────────────
$routes->get('/deposit/kwitansiaktif', 'Deposit::getKwitansiAktif', ['filter' => 'auth']);
$routes->get('/deposit/tagihanpembayaran', 'Deposit::getTagihanPembayaran', ['filter' => 'auth']);
$routes->get('/deposit/ringkasanpembayaran', 'Deposit::getRingkasanPembayaran', ['filter' => 'auth']);
$routes->get('/deposit/detailpembayaran', 'Deposit::getDetailPembayaran', ['filter' => 'auth']);
$routes->get('/deposit/payerlist', 'Deposit::payerList', ['filter' => 'auth']);
$routes->post('/deposit/prosespembayaran', 'Deposit::prosesPembayaran', ['filter' => 'auth']);
$routes->get('/deposit/riwayatpembayaran', 'Deposit::getRiwayatPembayaran', ['filter' => 'auth']);
$routes->post('/deposit/batalpembayaran', 'Deposit::batalPembayaran', ['filter' => 'auth']);
$routes->post('/deposit/batalpembayaran/(:num)', 'Deposit::batalPembayaran/$1', ['filter' => 'auth']);

// ── PDF ───────────────────────────────────────────────────────────────────────
// view_pdf() butuh 6 parameter posisi (pdf_name, pdf_title, pdf_data, pdf_paper,
// pdf_orientation, pdf_format) - route ini HANYA contoh, sesuaikan lagi kalau
// pemanggilannya sebenarnya lewat method lain (mis. dipanggil internal, bukan
// langsung dari URL, karena data kompleks seperti $pdf_data susah lewat URL).
$routes->get('/deposit/pdf/(:segment)/(:segment)/(:any)/(:segment)/(:segment)/(:segment)', 'Deposit::view_pdf/$1/$2/$3/$4/$5/$6');

$routes->get('/tmstwarehouses', 'Tmstwarehouses::index', ['filter' => 'auth']);
$routes->get('/tmstwarehouses/fetchSingleData', 'Tmstwarehouses::fetchSingleData', ['filter' => 'auth']);
$routes->post('/tmstwarehouses/action', 'Tmstwarehouses::action', ['filter' => 'auth']);
$routes->post('/tmstwarehouses/delete', 'Tmstwarehouses::delete', ['filter' => 'auth']);
$routes->get('/tmstwarehouses/download', 'Tmstwarehouses::download', ['filter' => 'auth']);
$routes->post('/tmstwarehouses/upload', 'Tmstwarehouses::upload', ['filter' => 'auth']);
$routes->post('/tmstwarehouses/datatables', 'Tmstwarehouses::datatables', ['filter' => 'auth']);
$routes->match(['get', 'post'], '/tmstwarehouses/preview', 'Tmstwarehouses::preview', ['filter' => 'auth']);

$routes->get('/tmstwarehousebins', 'Tmstwarehousebins::index', ['filter' => 'auth']);
// $routes->get('/tmstwarehousebins/getWarehouseDropdown', 'Tmstwarehousebins::getWarehouseDropdown', ['filter' => 'auth']);
$routes->get('/tmstwarehousebins/fetchSingleData', 'Tmstwarehousebins::fetchSingleData', ['filter' => 'auth']);
$routes->post('/tmstwarehousebins/action', 'Tmstwarehousebins::action', ['filter' => 'auth']);
$routes->post('/tmstwarehousebins/delete', 'Tmstwarehousebins::delete', ['filter' => 'auth']);
$routes->get('/tmstwarehousebins/download', 'Tmstwarehousebins::download', ['filter' => 'auth']);
$routes->post('/tmstwarehousebins/upload', 'Tmstwarehousebins::upload', ['filter' => 'auth']);
$routes->post('/tmstwarehousebins/datatables', 'Tmstwarehousebins::datatables', ['filter' => 'auth']);
$routes->match(['get', 'post'], '/tmstwarehousebins/preview', 'Tmstwarehousebins::preview', ['filter' => 'auth']);

$routes->get('/tmstbrands', 'Tmstbrands::index', ['filter' => 'auth']);
$routes->get('/tmstbrands/fetchSingleData', 'Tmstbrands::fetchSingleData', ['filter' => 'auth']);
$routes->post('/tmstbrands/action', 'Tmstbrands::action', ['filter' => 'auth']);
$routes->post('/tmstbrands/delete', 'Tmstbrands::delete', ['filter' => 'auth']);
$routes->get('/tmstbrands/download', 'Tmstbrands::download', ['filter' => 'auth']);
$routes->post('/tmstbrands/upload', 'Tmstbrands::upload', ['filter' => 'auth']);
$routes->post('/tmstbrands/datatables', 'Tmstbrands::datatables', ['filter' => 'auth']);
$routes->match(['get', 'post'], '/tmstbrands/preview', 'Tmstbrands::preview', ['filter' => 'auth']);

$routes->get('/tmstprincipals', 'Tmstprincipals::index', ['filter' => 'auth']);
$routes->get('/tmstprincipals/fetchSingleData', 'Tmstprincipals::fetchSingleData', ['filter' => 'auth']);
$routes->post('/tmstprincipals/action', 'Tmstprincipals::action', ['filter' => 'auth']);
$routes->post('/tmstprincipals/delete', 'Tmstprincipals::delete', ['filter' => 'auth']);
$routes->get('/tmstprincipals/download', 'Tmstprincipals::download', ['filter' => 'auth']);
$routes->post('/tmstprincipals/upload', 'Tmstprincipals::upload', ['filter' => 'auth']);
$routes->post('/tmstprincipals/datatables', 'Tmstprincipals::datatables', ['filter' => 'auth']);
$routes->match(['get', 'post'], '/tmstprincipals/preview', 'Tmstprincipals::preview', ['filter' => 'auth']);

// $routes->get('/kasir/payerlist', 'Kasir::payerList');
// $routes->post('/kasir/prosespembayaran', 'Kasir::prosesPembayaran');

// $routes->get('/kasir/saldo', 'Kasir::getSaldo');
// $routes->get('/kasir/riwayat', 'Kasir::getRiwayat');
// $routes->get('/kasir/get-detail-deposit', 'Kasir::getDetailDeposit');
// $routes->get('/kasir/tagihanpembayaran', 'Kasir::getTagihanPembayaran');
// $routes->get('/kasir/ringkasanpembayaran', 'Kasir::getRingkasanPembayaran');

// $routes->get('/kasir/deposit-saldo',     'Kasir::getDepositSaldo');
// $routes->get('/kasir/deposit-riwayat',   'Kasir::getDepositRiwayat');
// $routes->post('/kasir/deposit-simpan',   'Kasir::simpanDeposit');
// $routes->post('/kasir/deposit-gunakan',  'Kasir::gunakanDeposit');

$routes->post('/prints/print-history', 'Prints::savePrintHistory');

$routes->get('/tmstsuppliers', 'Tmstsuppliers::index', ['filter' => 'auth']);
$routes->get('/tmstsuppliers/fetchSingleData', 'Tmstsuppliers::fetchSingleData', ['filter' => 'auth']);
$routes->post('/tmstsuppliers/action', 'Tmstsuppliers::action', ['filter' => 'auth']);
$routes->post('/tmstsuppliers/delete', 'Tmstsuppliers::delete', ['filter' => 'auth']);
$routes->post('/tmstsuppliers/deletePermanent', 'Tmstsuppliers::deletePermanent', ['filter' => 'auth']);
$routes->post('/tmstsuppliers/restore', 'Tmstsuppliers::restore', ['filter' => 'auth']);
$routes->get('/tmstsuppliers/download', 'Tmstsuppliers::download', ['filter' => 'auth']);
$routes->post('/tmstsuppliers/upload', 'Tmstsuppliers::upload', ['filter' => 'auth']);
$routes->post('/tmstsuppliers/datatables', 'Tmstsuppliers::datatables', ['filter' => 'auth']);
$routes->match(['get', 'post'], '/tmstsuppliers/preview', 'Tmstsuppliers::preview', ['filter' => 'auth']);

$routes->get('/tmsttindakan', 'Tmsttindakan::index', ['filter' => 'auth']);
$routes->get('/tmsttindakan/fetchAll', 'Tmsttindakan::fetchAll', ['filter' => 'auth']);
$routes->get('/tmsttindakan/fetchSingleData', 'Tmsttindakan::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmsttindakan/fetchSingleDataPrint/(:any)', 'Tmsttindakan::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tmsttindakan/action', 'Tmsttindakan::action', ['filter' => 'auth']);
$routes->post('/tmsttindakan/delete', 'Tmsttindakan::delete', ['filter' => 'auth']);
$routes->get('/tmsttindakan/download', 'Tmsttindakan::download');
$routes->post('/tmsttindakan/upload', 'Tmsttindakan::upload');
$routes->post('/tmsttindakan/datatables', 'Tmsttindakan::datatables');
$routes->match(['get', 'post'], '/tmsttindakan/preview', 'Tmsttindakan::preview');
$routes->match(['get', 'post'], '/tmsttindakan/uploaded', 'Tmsttindakan::uploaded');

$routes->get('/tmstunit', 'Tmstunit::index', ['filter' => 'auth']);
$routes->get('/tmstunit/fetchAll', 'Tmstunit::fetchAll', ['filter' => 'auth']);
$routes->get('/tmstunit/fetchSingleData', 'Tmstunit::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmstunit/fetchSingleDataPrint/(:any)', 'Tmstunit::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tmstunit/action', 'Tmstunit::action', ['filter' => 'auth']);
$routes->post('/tmstunit/delete', 'Tmstunit::delete', ['filter' => 'auth']);
$routes->get('/tmstunit/download', 'Tmstunit::download');
$routes->post('/tmstunit/upload', 'Tmstunit::upload');
$routes->post('/tmstunit/datatables', 'Tmstunit::datatables');
$routes->match(['get', 'post'], '/tmstunit/preview', 'Tmstunit::preview');
$routes->match(['get', 'post'], '/tmstunit/uploaded', 'Tmstunit::uploaded');

$routes->get('/tmstsubunit', 'Tmstsubunit::index', ['filter' => 'auth']);
$routes->get('/tmstsubunit/fetchAll', 'Tmstsubunit::fetchAll', ['filter' => 'auth']);
$routes->get('/tmstsubunit/fetchSingleData', 'Tmstsubunit::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmstsubunit/fetchSingleDataPrint/(:any)', 'Tmstsubunit::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tmstsubunit/action', 'Tmstsubunit::action', ['filter' => 'auth']);
$routes->post('/tmstsubunit/delete', 'Tmstsubunit::delete', ['filter' => 'auth']);
$routes->get('/tmstsubunit/download', 'Tmstsubunit::download');
$routes->post('/tmstsubunit/upload', 'Tmstsubunit::upload');
$routes->post('/tmstsubunit/datatables', 'Tmstsubunit::datatables');
$routes->match(['get', 'post'], '/tmstsubunit/preview', 'Tmstsubunit::preview');
$routes->match(['get', 'post'], '/tmstsubunit/uploaded', 'Tmstsubunit::uploaded');

$routes->get('/tmstpakethdr', 'Tmstpakethdr::index', ['filter' => 'auth']);
$routes->get('/tmstpakethdr/fetchAll', 'Tmstpakethdr::fetchAll', ['filter' => 'auth']);
$routes->get('/tmstpakethdr/fetchSingleData', 'Tmstpakethdr::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmstpakethdr/fetchSingleDataPrint/(:any)', 'Tmstpakethdr::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tmstpakethdr/action', 'Tmstpakethdr::action', ['filter' => 'auth']);
$routes->post('/tmstpakethdr/delete', 'Tmstpakethdr::delete', ['filter' => 'auth']);
$routes->get('/tmstpakethdr/download', 'Tmstpakethdr::download');
$routes->post('/tmstpakethdr/upload', 'Tmstpakethdr::upload');
$routes->post('/tmstpakethdr/datatables', 'Tmstpakethdr::datatables');
$routes->match(['get', 'post'], '/tmstpakethdr/preview', 'Tmstpakethdr::preview');
$routes->match(['get', 'post'], '/tmstpakethdr/uploaded', 'Tmstpakethdr::uploaded');

$routes->get('/tmstpaketdtl', 'Tmstpaketdtl::index', ['filter' => 'auth']);
$routes->get('/tmstpaketdtl/fetchAll', 'Tmstpaketdtl::fetchAll', ['filter' => 'auth']);
$routes->get('/tmstpaketdtl/fetchSingleData', 'Tmstpaketdtl::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmstpaketdtl/fetchSingleDataPrint/(:any)', 'Tmstpaketdtl::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tmstpaketdtl/action', 'Tmstpaketdtl::action', ['filter' => 'auth']);
$routes->post('/tmstpaketdtl/delete', 'Tmstpaketdtl::delete', ['filter' => 'auth']);
$routes->get('/tmstpaketdtl/download', 'Tmstpaketdtl::download');
$routes->post('/tmstpaketdtl/upload', 'Tmstpaketdtl::upload');
$routes->post('/tmstpaketdtl/datatables', 'Tmstpaketdtl::datatables');
$routes->match(['get', 'post'], '/tmstpaketdtl/preview', 'Tmstpaketdtl::preview');
$routes->match(['get', 'post'], '/tmstpaketdtl/uploaded', 'Tmstpaketdtl::uploaded');

$routes->get('/tmstrevenuetype', 'Tmstrevenuetype::index', ['filter' => 'auth']);
$routes->get('/tmstrevenuetype/fetchAll', 'Tmstrevenuetype::fetchAll', ['filter' => 'auth']);
$routes->get('/tmstrevenuetype/fetchSingleData', 'Tmstrevenuetype::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmstrevenuetype/fetchSingleDataPrint/(:any)', 'Tmstrevenuetype::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tmstrevenuetype/action', 'Tmstrevenuetype::action', ['filter' => 'auth']);
$routes->post('/tmstrevenuetype/delete', 'Tmstrevenuetype::delete', ['filter' => 'auth']);
$routes->get('/tmstrevenuetype/download', 'Tmstrevenuetype::download');
$routes->post('/tmstrevenuetype/upload', 'Tmstrevenuetype::upload');
$routes->post('/tmstrevenuetype/datatables', 'Tmstrevenuetype::datatables');
$routes->match(['get', 'post'], '/tmstrevenuetype/preview', 'Tmstrevenuetype::preview');
$routes->match(['get', 'post'], '/tmstrevenuetype/uploaded', 'Tmstrevenuetype::uploaded');

$routes->get('/tmstrevenuetype', 'Tmstrevenuetype::index', ['filter' => 'auth']);
$routes->get('/tmstrevenuetype/fetchAll', 'Tmstrevenuetype::fetchAll', ['filter' => 'auth']);
$routes->get('/tmstrevenuetype/fetchSingleData', 'Tmstrevenuetype::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmstrevenuetype/fetchSingleDataPrint/(:any)', 'Tmstrevenuetype::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tmstrevenuetype/action', 'Tmstrevenuetype::action', ['filter' => 'auth']);
$routes->post('/tmstrevenuetype/delete', 'Tmstrevenuetype::delete', ['filter' => 'auth']);
$routes->get('/tmstrevenuetype/download', 'Tmstrevenuetype::download');
$routes->post('/tmstrevenuetype/upload', 'Tmstrevenuetype::upload');
$routes->post('/tmstrevenuetype/datatables', 'Tmstrevenuetype::datatables');
$routes->match(['get', 'post'], '/tmstrevenuetype/preview', 'Tmstrevenuetype::preview');
$routes->match(['get', 'post'], '/tmstrevenuetype/uploaded', 'Tmstrevenuetype::uploaded');

$routes->get('/tmstunit', 'Tmstunit::index', ['filter' => 'auth']);
$routes->get('/tmstunit/fetchAll', 'Tmstunit::fetchAll', ['filter' => 'auth']);
$routes->get('/tmstunit/fetchSingleData', 'Tmstunit::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmstunit/fetchSingleDataPrint/(:any)', 'Tmstunit::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tmstunit/action', 'Tmstunit::action', ['filter' => 'auth']);
$routes->post('/tmstunit/delete', 'Tmstunit::delete', ['filter' => 'auth']);
$routes->get('/tmstunit/download', 'Tmstunit::download');
$routes->post('/tmstunit/upload', 'Tmstunit::upload');
$routes->post('/tmstunit/datatables', 'Tmstunit::datatables');
$routes->match(['get', 'post'], '/tmstunit/preview', 'Tmstunit::preview');
$routes->match(['get', 'post'], '/tmstunit/uploaded', 'Tmstunit::uploaded');

$routes->get('/underconstruction', 'Underconstruction::index', ['filter' => 'auth']);

$routes->get('dropdown/warehouse', 'Componendropdown::warehouse', ['filter' => 'sessionCheck']);
$routes->get('dropdown/parentmenu', 'Componendropdown::parentmenu', ['filter' => 'sessionCheck']);
$routes->get('dropdown/menu', 'Componendropdown::menu', ['filter' => 'sessionCheck']);

// Custom dropdown routes
$routes->get('dropdown/customize/(:num)/(:num)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)', 'Componendropdown::customize/$1/$2/$3/$4/$5/$6/$7/$8', ['filter' => 'sessionCheck']);
$routes->get('dropdown/server1/(:num)/(:num)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)', 'Componendropdown::server1/$1/$2/$3/$4/$5/$6/$7/$8', ['filter' => 'sessionCheck']);
$routes->get('dropdown/server2/(:num)/(:num)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)', 'Componendropdown::server2/$1/$2/$3/$4/$5/$6/$7/$8', ['filter' => 'sessionCheck']);
$routes->get('dropdown/server3/(:num)/(:num)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)', 'Componendropdown::server3/$1/$2/$3/$4/$5/$6/$7/$8', ['filter' => 'sessionCheck']);
$routes->get('dropdown/server4/(:num)/(:num)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)', 'Componendropdown::server4/$1/$2/$3/$4/$5/$6/$7/$8', ['filter' => 'sessionCheck']);
$routes->get('dropdown/server5/(:num)/(:num)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)', 'Componendropdown::server5/$1/$2/$3/$4/$5/$6/$7/$8', ['filter' => 'sessionCheck']);



// 
$routes->get('/componenn', 'Componenn::index', ['filter' => 'auth']);
$routes->get('/componentwo', 'Componentwo::index', ['filter' => 'auth']);
$routes->get('/componenthree', 'Componenthree::index', ['filter' => 'auth']);

$routes->get('/cppt', 'Cppt::index', ['filter' => 'auth']);
$routes->get('/cppt/fetchAll', 'Cppt::fetchAll', ['filter' => 'auth']);
$routes->get('/cppt/fetchCpptByRegistrasi', 'Cppt::fetchCpptByRegistrasi', ['filter' => 'auth']);
$routes->post('cppt/action', 'Cppt::action', ['filter' => 'auth']);
$routes->get('/cppt/setNoRegistrasi', 'Cppt::setNoRegistrasi', ['filter' => 'auth']);
$routes->get('/cppt/printCppt/(:any)', 'Cppt::printCppt/$1', ['filter' => 'auth']);
$routes->post('/cppt/delete', 'Cppt::delete', ['filter' => 'auth']);
$routes->get('/cppt/setDataPemeriksaanPerawat', 'Cppt::setDataPemeriksaanPerawat', ['filter' => 'auth']);

$routes->get('/petunjukpasien', 'Petunjukpasien::index', ['filter' => 'auth']);
$routes->get('/petunjukpasien/fetchAll', 'Petunjukpasien::fetchAll', ['filter' => 'auth']);
$routes->get('/petunjukpasien/fetchPetunjukByRegistrasi', 'Petunjukpasien::fetchPetunjukByRegistrasi', ['filter' => 'auth']);
$routes->post('/petunjukpasien/action', 'Petunjukpasien::action', ['filter' => 'auth']);
$routes->get('/petunjukpasien/setNoRegistrasi', 'Petunjukpasien::setNoRegistrasi', ['filter' => 'auth']);
$routes->get('/petunjukpasien/printPetunjuk/(:any)', 'Petunjukpasien::printPetunjuk/$1', ['filter' => 'auth']);
$routes->post('/petunjukpasien/delete', 'Petunjukpasien::delete', ['filter' => 'auth']);
$routes->get('/petunjukpasien/fetchPetunjukJson', 'Petunjukpasien::fetchPetunjukJson', ['filter' => 'auth']);

$routes->get('/petunjukpasien', 'Petunjukpasien::index', ['filter' => 'auth']);
$routes->get('/petunjukpasien/fetchAll', 'Petunjukpasien::fetchAll', ['filter' => 'auth']);
$routes->get('/petunjukpasien/fetchPetunjukByRegistrasi', 'Petunjukpasien::fetchPetunjukByRegistrasi', ['filter' => 'auth']);
$routes->post('/petunjukpasien/action', 'Petunjukpasien::action', ['filter' => 'auth']);
$routes->get('/petunjukpasien/setNoRegistrasi', 'Petunjukpasien::setNoRegistrasi', ['filter' => 'auth']);
$routes->get('/petunjukpasien/printPetunjuk/(:any)', 'Petunjukpasien::printPetunjuk/$1', ['filter' => 'auth']);
$routes->post('/petunjukpasien/delete', 'Petunjukpasien::delete', ['filter' => 'auth']);
$routes->get('/petunjukpasien/fetchPetunjukJson', 'Petunjukpasien::fetchPetunjukJson', ['filter' => 'auth']);

$routes->get('/discharge', 'Discharge::index', ['filter' => 'auth']);
$routes->get('/discharge/fetchAll', 'Discharge::fetchAll', ['filter' => 'auth']);
$routes->get('/discharge/fetchDischargeByRegistrasi', 'Discharge::fetchDischargeByRegistrasi', ['filter' => 'auth']);
$routes->post('/discharge/action', 'Discharge::action', ['filter' => 'auth']);
$routes->get('/discharge/setNoRegistrasi', 'Discharge::setNoRegistrasi', ['filter' => 'auth']);
$routes->get('/discharge/printDischarge/(:any)', 'Discharge::printDischarge/$1', ['filter' => 'auth']);
$routes->post('/discharge/delete', 'Discharge::delete', ['filter' => 'auth']);

$routes->get('/resikojatuh', 'Resikojatuh::index', ['filter' => 'auth']);
$routes->get('/resikojatuh/fetchAll', 'Resikojatuh::fetchAll', ['filter' => 'auth']);
$routes->get('/resikojatuh/fetchResikoByRegistrasi', 'Resikojatuh::fetchResikoByRegistrasi', ['filter' => 'auth']);
$routes->post('/resikojatuh/action', 'Resikojatuh::action', ['filter' => 'auth']);
$routes->get('/resikojatuh/setNoRegistrasi', 'Resikojatuh::setNoRegistrasi', ['filter' => 'auth']);
$routes->get('/resikojatuh/printResiko/(:any)', 'Resikojatuh::printResiko/$1', ['filter' => 'auth']);
$routes->post('/resikojatuh/delete', 'Resikojatuh::delete', ['filter' => 'auth']);

$routes->get('/surgicalsafety', 'Surgicalsafety::index', ['filter' => 'auth']);
$routes->get('/surgicalsafety/fetchAll', 'Surgicalsafety::fetchAll', ['filter' => 'auth']);
$routes->get('/surgicalsafety/fetchByRegistrasi', 'Surgicalsafety::fetchByRegistrasi', ['filter' => 'auth']);
$routes->post('/surgicalsafety/action', 'Surgicalsafety::action', ['filter' => 'auth']);
$routes->get('/surgicalsafety/setNoRegistrasi', 'Surgicalsafety::setNoRegistrasi', ['filter' => 'auth']);
$routes->get('/surgicalsafety/printSurgical/(:any)', 'Surgicalsafety::printSurgical/$1', ['filter' => 'auth']);
$routes->post('/surgicalsafety/delete', 'Surgicalsafety::delete', ['filter' => 'auth']);

$routes->get('/tmstedc', 'Tmstedc::index', ['filter' => 'auth']);
$routes->get('/tmstedc/fetchAll', 'Tmstedc::fetchAll', ['filter' => 'auth']);
$routes->get('/tmstedc/fetchSingleData', 'Tmstedc::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmstedc/fetchSingleDataPrint/(:any)', 'Tmstedc::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tmstedc/action', 'Tmstedc::action', ['filter' => 'auth']);
$routes->post('/tmstedc/delete', 'Tmstedc::delete', ['filter' => 'auth']);
$routes->get('/tmstedc/download', 'Tmstedc::download');
$routes->post('/tmstedc/upload', 'Tmstedc::upload');
$routes->post('/tmstedc/datatables', 'Tmstedc::datatables');
$routes->match(['get', 'post'], '/tmstedc/preview', 'Tmstedc::preview');
$routes->match(['get', 'post'], '/tmstedc/uploaded', 'Tmstedc::uploaded');


$routes->get('/tmstcarapembayaran', 'Tmstcarapembayaran::index', ['filter' => 'auth']);
$routes->get('/tmstcarapembayaran/fetchAll', 'Tmstcarapembayaran::fetchAll', ['filter' => 'auth']);
$routes->get('/tmstcarapembayaran/fetchSingleData', 'Tmstcarapembayaran::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmstcarapembayaran/fetchSingleDataPrint/(:any)', 'Tmstcarapembayaran::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tmstcarapembayaran/action', 'Tmstcarapembayaran::action', ['filter' => 'auth']);
$routes->post('/tmstcarapembayaran/delete', 'Tmstcarapembayaran::delete', ['filter' => 'auth']);
$routes->get('/tmstcarapembayaran/download', 'Tmstcarapembayaran::download');
$routes->post('/tmstcarapembayaran/upload', 'Tmstcarapembayaran::upload');
$routes->post('/tmstcarapembayaran/datatables', 'Tmstcarapembayaran::datatables');
$routes->match(['get', 'post'], '/tmstcarapembayaran/preview', 'Tmstcarapembayaran::preview');


$routes->get('/tmstjenispembayaran', 'Tmstjenispembayaran::index', ['filter' => 'auth']);
$routes->get('/tmstjenispembayaran/fetchAll', 'Tmstjenispembayaran::fetchAll', ['filter' => 'auth']);
$routes->get('/tmstjenispembayaran/fetchSingleData', 'Tmstjenispembayaran::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmstjenispembayaran/fetchSingleDataPrint/(:any)', 'Tmstjenispembayaran::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tmstjenispembayaran/action', 'Tmstjenispembayaran::action', ['filter' => 'auth']);
$routes->post('/tmstjenispembayaran/delete', 'Tmstjenispembayaran::delete', ['filter' => 'auth']);
$routes->get('/tmstjenispembayaran/download', 'Tmstjenispembayaran::download');
$routes->post('/tmstjenispembayaran/upload', 'Tmstjenispembayaran::upload');
$routes->post('/tmstjenispembayaran/datatables', 'Tmstjenispembayaran::datatables');
$routes->match(['get', 'post'], '/tmstjenispembayaran/preview', 'Tmstjenispembayaran::preview');
$routes->match(['get', 'post'], '/tmstjenispembayaran/uploaded', 'Tmstjenispembayaran::uploaded');


$routes->get('/tmstformulir', 'Tmstformulir::index', ['filter' => 'auth']);
$routes->get('/tmstformulir/cetak/(:any)', 'Tmstformulir::cetak/$1', ['filter' => 'auth']);
$routes->get('tmstformulir/input/(:any)', 'Tmstformulir::input/$1', ['filter' => 'auth']);
$routes->post('tmstformulir/save/(:any)', 'Tmstformulir::save/$1', ['filter' => 'auth']);

$routes->get('/reporttl', 'ReportTL::index', ['filter' => 'auth']);
$routes->get('/reporttl/fetch', 'ReportTL::getAvailableReports');
$routes->post('/reporttl/generate', 'ReportTL::generateReport');
$routes->post('/reporttl/open', 'ReportTL::openDirect');

$routes->get('/reportpj', 'ReportPJ::index', ['filter' => 'auth']);
$routes->get('/reportpj/fetch', 'ReportPJ::getAvailableReports');
$routes->post('/reportpj/generate', 'ReportPJ::generateReport');
$routes->post('/reportpj/open', 'ReportPJ::openDirect');

$routes->get('/reporttb', 'ReportTB::index', ['filter' => 'auth']);
$routes->get('/reporttb/fetch', 'ReportTB::getAvailableReports');
$routes->post('/reporttb/generate', 'ReportTB::generateReport');
$routes->post('/reporttb/open', 'ReportTB::openDirect');

$routes->get('/reportis', 'ReportIS::index', ['filter' => 'auth']);
$routes->get('/reportis/fetch', 'ReportIS::getAvailableReports');
$routes->post('/reportis/generate', 'ReportIS::generateReport');
$routes->post('/reportis/open', 'ReportIS::openDirect');

$routes->get('/reportbs', 'ReportBS::index', ['filter' => 'auth']);
$routes->get('/reportbs/fetch', 'ReportBS::getAvailableReports');
$routes->post('/reportbs/generate', 'ReportBS::generateReport');
$routes->post('/reportbs/open', 'ReportBS::openDirect');

// Routes untuk Format Dokumen
$routes->get('/tdocnumberformat', 'Tdocnumberformat::index', ['filter' => 'auth']);
$routes->get('/tdocnumberformat/fetchAll', 'Tdocnumberformat::fetchAll', ['filter' => 'auth']);
$routes->get('/tdocnumberformat/fetchSingleData', 'Tdocnumberformat::fetchSingleData', ['filter' => 'auth']);
$routes->post('/tdocnumberformat/action', 'Tdocnumberformat::action', ['filter' => 'auth']);
$routes->post('/tdocnumberformat/delete', 'Tdocnumberformat::delete', ['filter' => 'auth']);
$routes->get('/tdocnumberformat/download', 'Tdocnumberformat::download');
$routes->post('/tdocnumberformat/datatables', 'Tdocnumberformat::datatables');
// Routes dropdown
$routes->get('/tdocnumberformat/getDropdownData/(:segment)', 'Tdocnumberformat::getDropdownData/$1', ['filter' => 'auth']);

// Routes untuk Master Menu
$routes->get('/tmstmenus', 'Tmstmenus::index', ['filter' => 'auth']);
$routes->get('/tmstmenus/fetchAll', 'Tmstmenus::fetchAll', ['filter' => 'auth']);
$routes->get('/tmstmenus/fetchSingleData', 'Tmstmenus::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmstmenus/fetchSingleDataPrint/(:any)', 'Tmstmenus::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tmstmenus/action', 'Tmstmenus::action', ['filter' => 'auth']);
$routes->post('/tmstmenus/delete', 'Tmstmenus::delete', ['filter' => 'auth']);
$routes->get('/tmstmenus/download', 'Tmstmenus::download');
$routes->post('/tmstmenus/upload', 'Tmstmenus::upload');
$routes->post('/tmstmenus/datatables', 'Tmstmenus::datatables');
$routes->match(['get', 'post'], '/tmstmenus/preview', 'Tmstmenus::preview');
$routes->match(['get', 'post'], '/tmstmenus/uploaded', 'Tmstmenus::uploaded');
// Routes dropdown
$routes->get('/tmstmenus/getdropdowndata/(:segment)', 'Tmstmenus::getDropdownData/$1', ['filter' => 'auth']);


$routes->get('/cobakey', 'Cobakey::index');
$routes->post('/cobakey/datatables', 'Cobakey::datatables');
$routes->get('/cobakey/getall', 'Cobakey::getall');
$routes->get('/cobakey/getby', 'Cobakey::getby');
$routes->post('/cobakey/insert', 'Cobakey::insert');
$routes->get('/cobakey/update', 'Cobakey::update');
$routes->get('/cobakey/delete', 'Cobakey::delete');

$routes->get('/tmstapprovalstage', 'Tmstapprovalstage::index', ['filter' => 'auth']);
$routes->get('/tmstapprovalstage/fetchAll', 'Tmstapprovalstage::fetchAll', ['filter' => 'auth']);
$routes->get('/tmstapprovalstage/fetchSingleData', 'Tmstapprovalstage::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmstapprovalstage/fetchSingleDataPrint/(:any)', 'Tmstapprovalstage::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tmstapprovalstage/action', 'Tmstapprovalstage::action', ['filter' => 'auth']);
$routes->post('/tmstapprovalstage/delete', 'Tmstapprovalstage::delete', ['filter' => 'auth']);
$routes->get('/tmstapprovalstage/download', 'Tmstapprovalstage::download');
$routes->post('/tmstapprovalstage/upload', 'Tmstapprovalstage::upload');
$routes->match(['get', 'post'], '/tmstapprovalstage/preview', 'Tmstapprovalstage::preview');
$routes->match(['get', 'post'], '/tmstapprovalstage/uploaded', 'Tmstapprovalstage::uploaded');

$routes->get('/tmstroleapproval', 'Tmstroleapproval::index', ['filter' => 'auth']);
$routes->get('/tmstroleapproval/fetchAll', 'Tmstroleapproval::fetchAll', ['filter' => 'auth']);
$routes->get('/tmstroleapproval/fetchSingleData', 'Tmstroleapproval::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmstroleapproval/fetchSingleDataPrint/(:any)', 'Tmstroleapproval::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tmstroleapproval/action', 'Tmstroleapproval::action', ['filter' => 'auth']);
$routes->post('/tmstroleapproval/delete', 'Tmstroleapproval::delete', ['filter' => 'auth']);
$routes->get('/tmstroleapproval/download', 'Tmstroleapproval::download');
$routes->post('/tmstroleapproval/upload', 'Tmstroleapproval::upload');
$routes->match(['get', 'post'], '/tmstroleapproval/preview', 'Tmstroleapproval::preview');
$routes->match(['get', 'post'], '/tmstroleapproval/uploaded', 'Tmstroleapproval::uploaded');

$routes->get('/tmstvoucher', 'Tmstvoucher::index', ['filter' => 'auth']);
$routes->get('/tmstvoucher/fetchAllDetail', 'Tmstvoucher::fetchAllDetail', ['filter' => 'auth']);
$routes->get('/tmstvoucher/fetchAll', 'Tmstvoucher::fetchAll', ['filter' => 'auth']);
$routes->get('/tmstvoucher/fetchSingleData', 'Tmstvoucher::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmstvoucher/fetchSingleDataPrint/(:any)', 'Tmstvoucher::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tmstvoucher/action', 'Tmstvoucher::action', ['filter' => 'auth']);
$routes->post('/tmstvoucher/delete', 'Tmstvoucher::delete', ['filter' => 'auth']);
$routes->get('/tmstvoucher/download', 'Tmstvoucher::download');
$routes->post('/tmstvoucher/upload', 'Tmstvoucher::upload');
$routes->match(['get', 'post'], '/tmstvoucher/preview', 'Tmstvoucher::preview');
$routes->match(['get', 'post'], '/tmstvoucher/uploaded', 'Tmstvoucher::uploaded');
$routes->post('/tmstvoucher/approve', 'Tmstvoucher::approve', ['filter' => 'auth']);
$routes->post('/tmstvoucher/cancel', 'Tmstvoucher::cancel', ['filter' => 'auth']);
// $routes->get('/tmstvoucher/prints1', 'Tmstvoucher::fetchAllDataPrint1', ['filter' => 'auth']); //Uji
// $routes->get('/tmstvoucher/prints2', 'Tmstvoucher::fetchAllDataPrint2', ['filter' => 'auth']); //Uji
// $routes->get('/tmstvoucher/printing1', 'Tmstvoucher::printing1', ['filter' => 'auth']); //Uji
// $routes->get('/tmstvoucher/printing2', 'Tmstvoucher::printing2', ['filter' => 'auth']); //Uji
$routes->post('/tmstvoucher/printi1', 'Tmstvoucher::printData', ['filter' => 'auth']); //Uji

$routes->get('/tmstcarabayar', 'Tmstcarabayar::index', ['filter' => 'auth']);
$routes->get('/tmstcarabayar/fetchAll', 'Tmstcarabayar::fetchAll', ['filter' => 'auth']);
$routes->get('/tmstcarabayar/fetchSingleData', 'Tmstcarabayar::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmstcarabayar/fetchSingleDataPrint/(:any)', 'Tmstcarabayar::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tmstcarabayar/action', 'Tmstcarabayar::action', ['filter' => 'auth']);
$routes->post('/tmstcarabayar/delete', 'Tmstcarabayar::delete', ['filter' => 'auth']);
$routes->get('/tmstcarabayar/download', 'Tmstcarabayar::download');
$routes->post('/tmstcarabayar/upload', 'Tmstcarabayar::upload');
$routes->match(['get', 'post'], '/tmstcarabayar/preview', 'Tmstcarabayar::preview');
$routes->match(['get', 'post'], '/tmstcarabayar/uploaded', 'Tmstcarabayar::uploaded');

$routes->get('/tappointment', 'Tappointment::index', ['filter' => 'auth']);
$routes->post('/tappointment/datatables', 'Tappointment::datatables', ['filter' => 'auth']);
$routes->get('/tappointment/fetchAll', 'Tappointment::fetchAll', ['filter' => 'auth']);
$routes->get('/tappointment/fetchAllView', 'Tappointment::fetchAllView', ['filter' => 'auth']);
$routes->get('/tappointment/fetchSingleData', 'Tappointment::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tappointment/fetchSingleDataPrint/(:any)', 'Tappointment::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tappointment/action', 'Tappointment::action', ['filter' => 'auth']);
$routes->post('/tappointment/actionRescedule', 'Tappointment::actionRescedule', ['filter' => 'auth']);
$routes->post('/tappointment/delete', 'Tappointment::delete', ['filter' => 'auth']);
$routes->post('/tappointment/hadir', 'Tappointment::hadir', ['filter' => 'auth']);
$routes->post('/tappointment/batal', 'Tappointment::batal', ['filter' => 'auth']);
$routes->get('/tappointment/getDropdown', 'Tappointment::getDropdown', ['filter' => 'auth']);

// $routes->get('/tmstglcoa', 'Tmstglcoa::index', ['filter' => 'auth']);
// $routes->get('/tmstglcoa/fetchAll', 'Tmstglcoa::fetchAll', ['filter' => 'auth']);
// $routes->get('/tmstglcoa/fetchSingleData', 'Tmstglcoa::fetchSingleData', ['filter' => 'auth']);
// $routes->get('/tmstglcoa/fetchSingleDataPrint/(:any)', 'Tmstglcoa::fetchSingleDataPrint/$1', ['filter' => 'auth']);
// $routes->post('/tmstglcoa/action', 'Tmstglcoa::action', ['filter' => 'auth']);
// $routes->post('/tmstglcoa/delete', 'Tmstglcoa::delete', ['filter' => 'auth']);
// $routes->get('/tmstglcoa/download', 'Tmstglcoa::download');
// $routes->post('/tmstglcoa/upload', 'Tmstglcoa::upload');
// $routes->match(['get', 'post'], '/tmstglcoa/preview', 'Tmstglcoa::preview');
// $routes->match(['get', 'post'], '/tmstglcoa/uploaded', 'Tmstglcoa::uploaded');
// $routes->get('/tmstglcoa/acc', 'Tmstglcoa::fetchDataAcc', ['filter' => 'auth']);
// $routes->get('/tmstglcoa/coa', 'Tmstglcoa::fetchDataCoa', ['filter' => 'auth']);

// $routes->get('/tmstglactgroup', 'Tmstglactgroup::index', ['filter' => 'auth']);
// $routes->get('/tmstglactgroup/fetchAll', 'Tmstglactgroup::fetchAll', ['filter' => 'auth']);
// $routes->get('/tmstglactgroup/fetchSingleData', 'Tmstglactgroup::fetchSingleData', ['filter' => 'auth']);
// $routes->get('/tmstglactgroup/fetchSingleDataPrint/(:any)', 'Tmstglactgroup::fetchSingleDataPrint/$1', ['filter' => 'auth']);
// $routes->post('/tmstglactgroup/action', 'Tmstglactgroup::action', ['filter' => 'auth']);
// $routes->post('/tmstglactgroup/delete', 'Tmstglactgroup::delete', ['filter' => 'auth']);
// $routes->get('/tmstglactgroup/download', 'Tmstglactgroup::download');
// $routes->post('/tmstglactgroup/upload', 'Tmstglactgroup::upload');
// $routes->match(['get', 'post'], '/tmstglactgroup/preview', 'Tmstglactgroup::preview');
// $routes->match(['get', 'post'], '/tmstglactgroup/uploaded', 'Tmstglactgroup::uploaded');

// $routes->get('/tmstglactstructur', 'Tmstglactstructur::index', ['filter' => 'auth']);
// $routes->get('/tmstglactstructur/fetchAll', 'Tmstglactstructur::fetchAll', ['filter' => 'auth']);
// $routes->get('/tmstglactstructur/fetchSingleData', 'Tmstglactstructur::fetchSingleData', ['filter' => 'auth']);
// $routes->get('/tmstglactstructur/fetchSingleDataPrint/(:any)', 'Tmstglactstructur::fetchSingleDataPrint/$1', ['filter' => 'auth']);
// $routes->post('/tmstglactstructur/action', 'Tmstglactstructur::action', ['filter' => 'auth']);
// $routes->post('/tmstglactstructur/delete', 'Tmstglactstructur::delete', ['filter' => 'auth']);
// $routes->get('/tmstglactstructur/download', 'Tmstglactstructur::download');
// $routes->post('/tmstglactstructur/upload', 'Tmstglactstructur::upload');
// $routes->match(['get', 'post'], '/tmstglactstructur/preview', 'Tmstglactstructur::preview');
// $routes->match(['get', 'post'], '/tmstglactstructur/uploaded', 'Tmstglactstructur::uploaded');


$routes->get('/tmstjenispembayaran', 'Tmstjenispembayaran::index', ['filter' => 'auth']);
$routes->get('/tmstjenispembayaran/fetchAll', 'Tmstjenispembayaran::fetchAll', ['filter' => 'auth']);
$routes->get('/tmstjenispembayaran/fetchSingleData', 'Tmstjenispembayaran::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmstjenispembayaran/fetchSingleDataPrint/(:any)', 'Tmstjenispembayaran::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tmstjenispembayaran/action', 'Tmstjenispembayaran::action', ['filter' => 'auth']);
$routes->post('/tmstjenispembayaran/delete', 'Tmstjenispembayaran::delete', ['filter' => 'auth']);
$routes->get('/tmstjenispembayaran/download', 'Tmstjenispembayaran::download');
$routes->post('/tmstjenispembayaran/upload', 'Tmstjenispembayaran::upload');
$routes->match(['get', 'post'], '/tmstjenispembayaran/preview', 'Tmstjenispembayaran::preview');
$routes->match(['get', 'post'], '/tmstjenispembayaran/uploaded', 'Tmstjenispembayaran::uploaded');


$routes->get('/tmsttypepasien', 'Tmsttypepasien::index', ['filter' => 'auth']);
$routes->get('/tmsttypepasien/fetchAll', 'Tmsttypepasien::fetchAll', ['filter' => 'auth']);
$routes->get('/tmsttypepasien/fetchSingleData', 'Tmsttypepasien::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmsttypepasien/fetchSingleDataPrint/(:any)', 'Tmsttypepasien::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tmsttypepasien/action', 'Tmsttypepasien::action', ['filter' => 'auth']);
$routes->post('/tmsttypepasien/delete', 'Tmsttypepasien::delete', ['filter' => 'auth']);
$routes->get('/tmsttypepasien/download', 'Tmsttypepasien::download');
$routes->post('/tmsttypepasien/upload', 'Tmsttypepasien::upload');
$routes->match(['get', 'post'], '/tmsttypepasien/preview', 'Tmsttypepasien::preview');
$routes->match(['get', 'post'], '/tmsttypepasien/uploaded', 'Tmsttypepasien::uploaded');


$routes->get('/goodsreceipt', 'GoodsReceipt::index', ['filter' => 'auth']);
$routes->get('/goodsreceipt/fetchAll', 'GoodsReceipt::fetchAll', ['filter' => 'auth']);
$routes->get('/goodsreceipt/fetchSingleData', 'GoodsReceipt::fetchSingleData', ['filter' => 'auth']);
$routes->get('/goodsreceipt/fetchSingleDataPrint/(:any)', 'GoodsReceipt::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/goodsreceipt/action', 'GoodsReceipt::action', ['filter' => 'auth']);
$routes->post('/goodsreceipt/delete', 'GoodsReceipt::delete', ['filter' => 'auth']);
$routes->post('/goodsreceipt/store', 'GoodsReceipt::store', ['filter' => 'auth']);
$routes->get('/goodsreceipt/registrasi', 'GoodsReceipt::fetchDataKasirListRegistrasi', ['filter' => 'auth']);
$routes->get('/goodsreceipt/po', 'GoodsReceipt::fetchDataPurchaseOrderListPO', ['filter' => 'auth']);
$routes->get('/goodsreceipt/setnoregistrasi', 'GoodsReceipt::setNoRegistrasi', ['filter' => 'auth']);
$routes->get('/goodsreceipt/removenoregistrasi', 'GoodsReceipt::removeNoRegistrasi', ['filter' => 'auth']);
$routes->get('/goodsreceipt/ceksession', 'GoodsReceipt::checkSession', ['filter' => 'auth']);
$routes->get('/goodsreceipt/nokwitansi', 'GoodsReceipt::apiDataGetNoKwitansi', ['filter' => 'auth']);
$routes->get('/goodsreceipt/listbilling', 'GoodsReceipt::fetchDataKasirListBilling', ['filter' => 'auth']);
$routes->get('/goodsreceipt/print/(:any)', 'GoodsReceipt::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->get('/goodsreceipt/edit/(:any)', 'GoodsReceipt::fetchSingleDataEdit/$1', ['filter' => 'auth']);
$routes->post('/goodsreceipt/fetchallitems', 'GoodsReceipt::fetchAllItems', ['filter' => 'auth']);


$routes->get('/purchaseorder', 'PurchaseOrder::index', ['filter' => 'auth']);
$routes->get('/purchaseorder/fetchAll', 'PurchaseOrder::fetchAll', ['filter' => 'auth']);
$routes->get('/purchaseorder/fetchSingleData', 'PurchaseOrder::fetchSingleData', ['filter' => 'auth']);
$routes->get('/purchaseorder/fetchSingleDataPrint/(:any)', 'PurchaseOrder::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/purchaseorder/action', 'PurchaseOrder::action', ['filter' => 'auth']);
$routes->post('/purchaseorder/delete', 'PurchaseOrder::delete', ['filter' => 'auth']);
$routes->post('/purchaseorder/store', 'PurchaseOrder::store', ['filter' => 'auth']);
$routes->get('/purchaseorder/registrasi', 'PurchaseOrder::fetchDataKasirListRegistrasi', ['filter' => 'auth']);
$routes->get('/purchaseorder/po', 'PurchaseOrder::fetchDataPurchaseOrderListPO', ['filter' => 'auth']);
$routes->get('/purchaseorder/setnoregistrasi', 'PurchaseOrder::setNoRegistrasi', ['filter' => 'auth']);
$routes->get('/purchaseorder/removenoregistrasi', 'PurchaseOrder::removeNoRegistrasi', ['filter' => 'auth']);
$routes->get('/purchaseorder/ceksession', 'PurchaseOrder::checkSession', ['filter' => 'auth']);
$routes->get('/purchaseorder/nokwitansi', 'PurchaseOrder::apiDataGetNoKwitansi', ['filter' => 'auth']);
$routes->get('/purchaseorder/listbilling', 'PurchaseOrder::fetchDataKasirListBilling', ['filter' => 'auth']);
$routes->get('/purchaseorder/print/(:any)', 'PurchaseOrder::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->get('/purchaseorder/edit/(:any)', 'PurchaseOrder::fetchSingleDataEdit/$1', ['filter' => 'auth']);
$routes->post('/purchaseorder/fetchallitems', 'PurchaseOrder::fetchAllItems', ['filter' => 'auth']);


$routes->get('/purchaserequestapproval', 'PurchaseRequestApproval::index', ['filter' => 'auth']);
$routes->get('/purchaserequestapproval/fetchAll', 'PurchaseRequestApproval::fetchAll', ['filter' => 'auth']);
$routes->get('/purchaserequestapproval/fetchSingleData', 'PurchaseRequestApproval::fetchSingleData', ['filter' => 'auth']);
$routes->get('/purchaserequestapproval/fetchSingleDataPrint/(:any)', 'PurchaseRequestApproval::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/purchaserequestapproval/action', 'PurchaseRequestApproval::action', ['filter' => 'auth']);
$routes->post('/purchaserequestapproval/delete', 'PurchaseRequestApproval::delete', ['filter' => 'auth']);
$routes->post('/purchaserequestapproval/store', 'PurchaseRequestApproval::store', ['filter' => 'auth']);
$routes->get('/purchaserequestapproval/registrasi', 'PurchaseRequestApproval::fetchDataKasirListRegistrasi', ['filter' => 'auth']);
$routes->get('/purchaserequestapproval/pr', 'PurchaseRequestApproval::fetchDataPurchaseRequestListPR', ['filter' => 'auth']);
$routes->get('/purchaserequestapproval/setnoregistrasi', 'PurchaseRequestApproval::setNoRegistrasi', ['filter' => 'auth']);
$routes->get('/purchaserequestapproval/removenoregistrasi', 'PurchaseRequestApproval::removeNoRegistrasi', ['filter' => 'auth']);
$routes->get('/purchaserequestapproval/ceksession', 'PurchaseRequestApproval::checkSession', ['filter' => 'auth']);
$routes->get('/purchaserequestapproval/nokwitansi', 'PurchaseRequestApproval::apiDataGetNoKwitansi', ['filter' => 'auth']);
$routes->get('/purchaserequestapproval/listbilling', 'PurchaseRequestApproval::fetchDataKasirListBilling', ['filter' => 'auth']);
$routes->get('/purchaserequestapproval/print/(:any)', 'PurchaseRequestApproval::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->get('/purchaserequestapproval/edit/(:any)', 'PurchaseRequestApproval::fetchSingleDataEdit/$1', ['filter' => 'auth']);
$routes->post('/purchaserequestapproval/fetchallitems', 'PurchaseRequestApproval::fetchAllItems', ['filter' => 'auth']);
$routes->get('/purchaserequestapproval/search', 'PurchaseRequestApproval::search', ['filter' => 'auth']);


$routes->get('/purchaserequest/getPRDetailLastestPrice', 'PurchaseRequest::getPRDetailLastestPrice', ['filter' => 'auth']);
$routes->get('/purchaserequest', 'PurchaseRequest::index', ['filter' => 'auth']);
$routes->get('/purchaserequest/fetchAll', 'PurchaseRequest::fetchAll', ['filter' => 'auth']);
$routes->get('/purchaserequest/fetchSingleData', 'PurchaseRequest::fetchSingleData', ['filter' => 'auth']);
$routes->get('/purchaserequest/fetchSingleDataPrint/(:any)', 'PurchaseRequest::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/purchaserequest/datatables', 'PurchaseRequest::datatables', ['filter' => 'auth']);
$routes->post('/purchaserequest/datatables2', 'PurchaseRequest::datatables2', ['filter' => 'auth']);
$routes->get('/purchaserequest/detail', 'PurchaseRequest::fetchSingleDataDetail', ['filter' => 'auth']);
$routes->post('/purchaserequest/action', 'PurchaseRequest::action', ['filter' => 'auth']);
$routes->post('/purchaserequest/delete', 'PurchaseRequest::delete', ['filter' => 'auth']);
$routes->post('/purchaserequest/store', 'PurchaseRequest::store', ['filter' => 'auth']);
$routes->get('/purchaserequest/registrasi', 'Purchaserequest::fetchDataKasirListRegistrasi', ['filter' => 'auth']);
$routes->get('/purchaserequest/item', 'Purchaserequest::fetchDataKasirListItem', ['filter' => 'auth']);
$routes->get('/purchaserequest/setnoregistrasi', 'Purchaserequest::setNoRegistrasi', ['filter' => 'auth']);
$routes->get('/purchaserequest/removenoregistrasi', 'Purchaserequest::removeNoRegistrasi', ['filter' => 'auth']);
$routes->get('/purchaserequest/ceksession', 'Purchaserequest::checkSession', ['filter' => 'auth']);
$routes->get('/purchaserequest/nokwitansi', 'Purchaserequest::apiDataGetNoKwitansi', ['filter' => 'auth']);
$routes->get('/purchaserequest/listbilling', 'Purchaserequest::fetchDataKasirListBilling', ['filter' => 'auth']);
$routes->get('/purchaserequest/print/(:any)', 'Purchaserequest::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->get('/purchaserequest/edit/(:any)', 'Purchaserequest::fetchSingleDataEdit/$1', ['filter' => 'auth']);
$routes->post('/purchaserequest/fetchallitems', 'Purchaserequest::fetchAllItems', ['filter' => 'auth']);



$routes->get('/tmstsupplier', 'Tmstsupplier::index', ['filter' => 'auth']);
$routes->get('/tmstsupplier/fetchAll', 'Tmstsupplier::fetchAll', ['filter' => 'auth']);
$routes->get('/tmstsupplier/fetchSingleData', 'Tmstsupplier::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmstsupplier/fetchSingleDataPrint/(:any)', 'Tmstsupplier::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tmstsupplier/action', 'Tmstsupplier::action', ['filter' => 'auth']);
$routes->post('/tmstsupplier/delete', 'Tmstsupplier::delete', ['filter' => 'auth']);
$routes->get('/tmstsupplier/download', 'Tmstsupplier::download');
$routes->post('/tmstsupplier/upload', 'Tmstsupplier::upload');
$routes->match(['get', 'post'], '/tmstsupplier/preview', 'Tmstsupplier::preview');
$routes->match(['get', 'post'], '/tmstsupplier/uploaded', 'Tmstsupplier::uploaded');

$routes->get('/tmstbranch', 'Tmstbranch::index', ['filter' => 'auth']);
$routes->get('/tmstbranch/fetchAll', 'Tmstbranch::fetchAll', ['filter' => 'auth']);
$routes->get('/tmstbranch/fetchSingleData', 'Tmstbranch::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmstbranch/fetchSingleDataPrint/(:any)', 'Tmstbranch::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tmstbranch/action', 'Tmstbranch::action', ['filter' => 'auth']);
$routes->post('/tmstbranch/delete', 'Tmstbranch::delete', ['filter' => 'auth']);
$routes->get('/tmstbranch/download', 'Tmstbranch::download');
$routes->post('/tmstbranch/upload', 'Tmstbranch::upload');
$routes->match(['get', 'post'], '/tmstbranch/preview', 'Tmstbranch::preview');
$routes->match(['get', 'post'], '/tmstbranch/uploaded', 'Tmstbranch::uploaded');

$routes->get('/tmstprincipal', 'Tmstprincipal::index', ['filter' => 'auth']);
$routes->get('/tmstprincipal/fetchAll', 'Tmstprincipal::fetchAll', ['filter' => 'auth']);
$routes->get('/tmstprincipal/fetchSingleData', 'Tmstprincipal::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmstprincipal/fetchSingleDataPrint/(:any)', 'Tmstprincipal::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tmstprincipal/action', 'Tmstprincipal::action', ['filter' => 'auth']);
$routes->post('/tmstprincipal/delete', 'Tmstprincipal::delete', ['filter' => 'auth']);
$routes->get('/tmstprincipal/download', 'Tmstprincipal::download');
$routes->post('/tmstprincipal/upload', 'Tmstprincipal::upload');
$routes->match(['get', 'post'], '/tmstprincipal/preview', 'Tmstprincipal::preview');
$routes->match(['get', 'post'], '/tmstprincipal/uploaded', 'Tmstprincipal::uploaded');

$routes->get('/tmstwarehouse', 'Tmstwarehouse::index', ['filter' => 'auth']);
$routes->get('/tmstwarehouse/fetchAll', 'Tmstwarehouse::fetchAll', ['filter' => 'auth']);
$routes->get('/tmstwarehouse/fetchSingleData', 'Tmstwarehouse::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmstwarehouse/fetchSingleDataPrint/(:any)', 'Tmstwarehouse::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tmstwarehouse/action', 'Tmstwarehouse::action', ['filter' => 'auth']);
$routes->post('/tmstwarehouse/delete', 'Tmstwarehouse::delete', ['filter' => 'auth']);
$routes->get('/tmstwarehouse/download', 'Tmstwarehouse::download');
$routes->post('/tmstwarehouse/upload', 'Tmstwarehouse::upload');
$routes->post('/tmstwarehouse/datatables', 'Tmstwarehouse::datatables');
$routes->match(['get', 'post'], '/tmstwarehouse/preview', 'Tmstwarehouse::preview');
$routes->match(['get', 'post'], '/tmstwarehouse/uploaded', 'Tmstwarehouse::uploaded');

// Location routes
$routes->get('location/getProvinsi', 'Location::getProvinsi');
$routes->get('location/getKota/(:any)', 'Location::getKota/$1');
$routes->get('location/getKecamatan/(:any)', 'Location::getKecamatan/$1');
$routes->get('location/getKelurahan/(:any)', 'Location::getKelurahan/$1');
$routes->get('location/getKodeposByKelurahan/(:any)', 'Location::getKodeposByKelurahan/$1');
$routes->get('location/searchKodepos', 'Location::searchKodepos');
$routes->get('location/getHierarchy/(:any)', 'Location::getHierarchy/$1');

$routes->get('/tmstitemradiologi', 'Tmstitemradiologi::index', ['filter' => 'auth']);
$routes->get('/tmstitemradiologi/fetchAll', 'Tmstitemradiologi::fetchAll', ['filter' => 'auth']);
$routes->get('/tmstitemradiologi/fetchSingleData', 'Tmstitemradiologi::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmstitemradiologi/fetchSingleDataPrint/(:any)', 'Tmstitemradiologi::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tmstitemradiologi/action', 'Tmstitemradiologi::action', ['filter' => 'auth']);
$routes->post('/tmstitemradiologi/delete', 'Tmstitemradiologi::delete', ['filter' => 'auth']);
$routes->get('/tmstitemradiologi/download', 'Tmstitemradiologi::download');
$routes->post('/tmstitemradiologi/upload', 'Tmstitemradiologi::upload');
$routes->match(['get', 'post'], '/tmstitemradiologi/preview', 'Tmstitemradiologi::preview');
$routes->match(['get', 'post'], '/tmstitemradiologi/uploaded', 'Tmstitemradiologi::uploaded');

$routes->get('/tdocnumsetting', 'Tdocnumsetting::index', ['filter' => 'auth']);
$routes->get('/tdocnumsetting/fetchAll', 'Tdocnumsetting::fetchAll', ['filter' => 'auth']);
$routes->get('/tdocnumsetting/fetchSingleData', 'Tdocnumsetting::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tdocnumsetting/fetchSingleDataPrint/(:any)/(:any)', 'Tdocnumsetting::fetchSingleDataPrint/$1/$2', ['filter' => 'auth']);
$routes->post('/tdocnumsetting/action', 'Tdocnumsetting::action', ['filter' => 'auth']);
$routes->post('/tdocnumsetting/delete', 'Tdocnumsetting::delete', ['filter' => 'auth']);
$routes->get('/tdocnumsetting/download', 'Tdocnumsetting::download');
$routes->post('/tdocnumsetting/upload', 'Tdocnumsetting::upload');
$routes->match(['get', 'post'], '/tdocnumsetting/preview', 'Tdocnumsetting::preview');
$routes->match(['get', 'post'], '/tdocnumsetting/uploaded', 'Tdocnumsetting::uploaded');

$routes->get('/tmstdistributor', 'Tmstdistributor::index', ['filter' => 'auth']);
$routes->get('/tmstdistributor/fetchAll', 'Tmstdistributor::fetchAll', ['filter' => 'auth']);
$routes->get('/tmstdistributor/fetchSingleData', 'Tmstdistributor::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmstdistributor/fetchSingleDataPrint/(:any)', 'Tmstdistributor::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tmstdistributor/action', 'Tmstdistributor::action', ['filter' => 'auth']);
$routes->post('/tmstdistributor/delete', 'Tmstdistributor::delete', ['filter' => 'auth']);

$routes->get('/icdapi/ajax-search-icdn', 'IcdApi::ajaxSearchIdn');

$routes->get('/tmstbooking', 'Tmstbooking::index', ['filter' => 'auth']);
$routes->get('/tmstbooking/fetchAll', 'Tmstbooking::fetchAll', ['filter' => 'auth']);
$routes->get('/tmstbooking/fetchSingleData', 'Tmstbooking::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmstbooking/fetchSingleDataPrint/(:any)', 'Tmstbooking::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->get('/tmstbooking/prints', 'Tmstbooking::fetchAllDataPrint', ['filter' => 'auth']); //Uji
$routes->post('/tmstbooking/action', 'Tmstbooking::action', ['filter' => 'auth']);
$routes->post('/tmstbooking/delete', 'Tmstbooking::delete', ['filter' => 'auth']);

$routes->get('/tpatientalergi', 'Tpatientalergi::index', ['filter' => 'auth']);
$routes->get('/tpatientalergi/fetchAll', 'Tpatientalergi::fetchAll', ['filter' => 'auth']);
$routes->get('/tpatientalergi/fetchSingleData', 'Tpatientalergi::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tpatientalergi/fetchSingleDataPrint/(:any)', 'Tpatientalergi::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tpatientalergi/action', 'Tpatientalergi::action', ['filter' => 'auth']);
$routes->post('/tpatientalergi/delete', 'Tpatientalergi::delete', ['filter' => 'auth']);
$routes->get('/tpatientalergi/download', 'Tpatientalergi::download');
$routes->post('/tpatientalergi/upload', 'Tpatientalergi::upload');
$routes->match(['get', 'post'], '/tpatientalergi/preview', 'Tpatientalergi::preview');
$routes->match(['get', 'post'], '/tpatientalergi/uploaded', 'Tpatientalergi::uploaded');

$routes->get('/tmstitemlaboratorium', 'Tmstitemlaboratorium::index', ['filter' => 'auth']);
$routes->get('/tmstitemlaboratorium/fetchAll', 'Tmstitemlaboratorium::fetchAll', ['filter' => 'auth']);
$routes->get('/tmstitemlaboratorium/fetchSingleData', 'Tmstitemlaboratorium::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmstitemlaboratorium/fetchSingleDataPrint/(:any)', 'Tmstitemlaboratorium::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tmstitemlaboratorium/action', 'Tmstitemlaboratorium::action', ['filter' => 'auth']);
$routes->post('/tmstitemlaboratorium/delete', 'Tmstitemlaboratorium::delete', ['filter' => 'auth']);
$routes->get('/tmstitemlaboratorium/download', 'Tmstitemlaboratorium::download');
$routes->post('/tmstitemlaboratorium/upload', 'Tmstitemlaboratorium::upload');
$routes->match(['get', 'post'], '/tmstitemlaboratorium/preview', 'Tmstitemlaboratorium::preview');
$routes->match(['get', 'post'], '/tmstitemlaboratorium/uploaded', 'Tmstitemlaboratorium::uploaded');

$routes->get('/pemeriksaanawal', 'PemeriksaanAwal::index', ['filter' => 'auth']);
$routes->get('/pemeriksaanawal/fetchAll', 'PemeriksaanAwal::fetchAll', ['filter' => 'auth']);
$routes->get('/pemeriksaanawal/fetchSingleData', 'PemeriksaanAwal::fetchSingleData', ['filter' => 'auth']);
$routes->get('/pemeriksaanawal/fetchSingleDataPrint/(:any)', 'PemeriksaanAwal::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/pemeriksaanawal/action', 'PemeriksaanAwal::action', ['filter' => 'auth']);
$routes->post('/pemeriksaanawal/delete', 'PemeriksaanAwal::delete', ['filter' => 'auth']);
$routes->get('/pemeriksaanawal/setNoRegistrasi', 'PemeriksaanAwal::setNoRegistrasi', ['filter' => 'auth']);
$routes->get('/pemeriksaanawal/apiDataGetAlergiByPasien', 'PemeriksaanAwal::apiDataGetAlergiByPasien', ['filter' => 'auth']);
$routes->get('/pemeriksaanawal/apiDataGetDiagnosaTambahanByRegistrasi', 'PemeriksaanAwal::apiDataGetDiagnosaTambahanByRegistrasi', ['filter' => 'auth']);
$routes->get('/pemeriksaanawal/fetchAllRiwayatCardByPasien', 'PemeriksaanAwal::fetchAllRiwayatCardByPasien', ['filter' => 'auth']);
$routes->get('/pemeriksaanawal/setDataPemeriksaanPerawat', 'PemeriksaanAwal::setDataPemeriksaanPerawat', ['filter' => 'auth']);
$routes->get('/pemeriksaanawal/fetchPemeriksaanAwalByRegistrasi', 'PemeriksaanAwal::fetchPemeriksaanAwalByRegistrasi', ['filter' => 'auth']);

$routes->get('/tdokter', 'Tdokter::index', ['filter' => 'auth']);
$routes->get('/tdokter/fetchAll', 'Tdokter::fetchAll', ['filter' => 'auth']);
$routes->get('/tdokter/fetchSingleData', 'Tdokter::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tdokter/fetchSingleDataPrint/(:any)', 'Tdokter::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tdokter/action', 'Tdokter::action', ['filter' => 'auth']);
$routes->post('/tdokter/delete', 'Tdokter::delete', ['filter' => 'auth']);

$routes->get('/tmstobat', 'Tmstobat::index', ['filter' => 'auth']);
$routes->get('/tmstobat/fetchAll', 'Tmstobat::fetchAll', ['filter' => 'auth']);
$routes->get('/tmstobat/fetchSingleData', 'Tmstobat::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmstobat/fetchSingleDataPrint/(:any)', 'Tmstobat::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tmstobat/action', 'Tmstobat::action', ['filter' => 'auth']);
$routes->post('/tmstobat/delete', 'Tmstobat::delete', ['filter' => 'auth']);
$routes->get('/tmstobat/download', 'Tmstobat::download');
$routes->post('/tmstobat/upload', 'Tmstobat::upload');
$routes->match(['get', 'post'], '/tmstobat/preview', 'Tmstobat::preview');
$routes->match(['get', 'post'], '/tmstobat/uploaded', 'Tmstobat::uploaded');

$routes->get('/tmstdiagnosa', 'Tmstdiagnosa::index', ['filter' => 'auth']);
$routes->get('/tmstdiagnosa/fetchAll', 'Tmstdiagnosa::fetchAll', ['filter' => 'auth']);
$routes->get('/tmstdiagnosa/fetchSingleData', 'Tmstdiagnosa::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmstdiagnosa/fetchSingleDataPrint/(:any)', 'Tmstdiagnosa::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tmstdiagnosa/action', 'Tmstdiagnosa::action', ['filter' => 'auth']);
$routes->post('/tmstdiagnosa/delete', 'Tmstdiagnosa::delete', ['filter' => 'auth']);
$routes->get('/tmstdiagnosa/download', 'Tmstdiagnosa::download');
$routes->post('/tmstdiagnosa/upload', 'Tmstdiagnosa::upload');
$routes->match(['get', 'post'], '/tmstdiagnosa/preview', 'Tmstdiagnosa::preview');
$routes->match(['get', 'post'], '/tmstdiagnosa/uploaded', 'Tmstdiagnosa::uploaded');

$routes->get('/tmstpaket', 'Tmstpaket::index', ['filter' => 'auth']);
$routes->get('/tmstpaket/fetchAll', 'Tmstpaket::fetchAll', ['filter' => 'auth']);
$routes->get('/tmstpaket/fetchSingleData', 'Tmstpaket::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmstpaket/fetchSingleDataPrint/(:any)', 'Tmstpaket::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tmstpaket/action', 'Tmstpaket::action', ['filter' => 'auth']);
$routes->post('/tmstpaket/delete', 'Tmstpaket::delete', ['filter' => 'auth']);
$routes->get('/tmstpaket/download', 'Tmstpaket::download');
$routes->post('/tmstpaket/upload', 'Tmstpaket::upload');
$routes->match(['get', 'post'], '/tmstpaket/preview', 'Tmstpaket::preview');
$routes->match(['get', 'post'], '/tmstpaket/uploaded', 'Tmstpaket::uploaded');

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// Auth
$routes->get('/', 'Dashboard::index', ['filter' => 'auth']);
$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']);
// Dashboard - Fitur Riwayat (untuk ROLE002 dan ROLE003)
$routes->post('/dashboard/searchPatient', 'Dashboard::searchPatient');
$routes->post('/dashboard/getPatientDetail', 'Dashboard::getPatientDetail');
$routes->post('/dashboard/getDetailKunjungan', 'Dashboard::getDetailKunjungan');

$routes->get('/auth', 'Auth::register');
$routes->get('/auth/reset', 'Auth::reset');
$routes->post('/auth/valid_register', 'Auth::valid_register');
$routes->get('/auth/changepassword', 'Auth::changepassword');
$routes->post('/auth/valid_changepassword', 'Auth::valid_changepassword');
$routes->get('/auth/login', 'Auth::login');
$routes->post('/auth/valid_login', 'Auth::valid_login');
$routes->get('/auth/logout', 'Auth::logout');
$routes->get('/user', 'User::index');

// User Non Admin
// $routes->get('/beranda', 'Beranda::index');
$routes->get('/deltafood', 'Deltafood::index');
$routes->get('/produk', 'Produk::index');
$routes->get('/produk/detail', 'Produk::detail');
$routes->get('/produk/detail/(:any)', 'Produk::detail/$1');
$routes->get('/blog', 'Blog::index');
$routes->get('/blog/detail/(:any)', 'Blog::detail/$1');
$routes->get('/blog/arsip/(:any)', 'Blog::arsip/$1');
$routes->get('/resep', 'Resep::index');
$routes->get('/resep/detail/(:any)', 'Resep::detail/$1');
$routes->get('/resep/arsip/(:any)', 'Resep::arsip/$1');
$routes->get('/tfieldvalue', 'TFieldValue::index');
$routes->get('/view_pdf', 'TFieldValue::view_pdf');

// Module Controller
$routes->get('/mod/fetchSingleDataPasien', 'Mod::fetchSingleDataPasien', ['filter' => 'auth']);
$routes->get('/mod/fetchSingleDataAsuransi', 'Mod::fetchSingleDataAsuransi', ['filter' => 'auth']);
$routes->get('/mod/getDropdown123', 'Mod::getDropdown123', ['filter' => 'auth']);
$routes->get('/mod/checkSession', 'Mod::checkSession');


$routes->get('/tmstpolyclinic', 'Tmstpolyclinic::index', ['filter' => 'auth']);
$routes->get('/tmstpolyclinic/fetchAll', 'Tmstpolyclinic::fetchAll', ['filter' => 'auth']);
$routes->get('/tmstpolyclinic/fetchSingleData', 'Tmstpolyclinic::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmstpolyclinic/fetchSingleDataPrint/(:any)', 'Tmstpolyclinic::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tmstpolyclinic/action', 'Tmstpolyclinic::action', ['filter' => 'auth']);
$routes->post('/tmstpolyclinic/delete', 'Tmstpolyclinic::delete', ['filter' => 'auth']);

$routes->get('/clinic/dokter', 'Clinic\Dokter::index');
$routes->get('/clinic/dokter/formtambah', 'Clinic\Dokter::formtambah');
$routes->get('/clinic/dokter/formedit', 'Clinic\Dokter::formedit');
$routes->get('/clinic/dokter/ambildata', 'Clinic\Dokter::ambildata');
$routes->post('/clinic/dokter/deletedata', 'Clinic\Dokter::deletedata');
$routes->post('/clinic/dokter/simpandata', 'Clinic\Dokter::simpandata');

$routes->get('/dokter', 'Dokter::index', ['filter' => 'auth']);
$routes->get('/dokter/fetchAll', 'Dokter::fetchAll', ['filter' => 'auth']);
$routes->get('/dokter/fetchSingleData', 'Dokter::fetchSingleData', ['filter' => 'auth']);
$routes->get('/dokter/fetchSingleDataPrint/(:any)/(:any)', 'Dokter::fetchSingleDataPrint/$1/$2', ['filter' => 'auth']);
$routes->post('/dokter/action', 'Dokter::action', ['filter' => 'auth']);
$routes->post('/dokter/delete', 'Dokter::delete', ['filter' => 'auth']);

$routes->get('/konsultasidokter/test', 'Konsultasidokter::test', ['filter' => 'auth']);
$routes->get('/konsultasidokter', 'Konsultasidokter::index', ['filter' => 'auth']);
$routes->get('/konsultasidokter/fetchAllAlergi', 'Konsultasidokter::fetchAllAlergi', ['filter' => 'auth']);
$routes->get('/konsultasidokter/fetchAll', 'Konsultasidokter::fetchAll', ['filter' => 'auth']);
$routes->get('/konsultasidokter/apiDataGetByDokter', 'Konsultasidokter::apiDataGetByDokter', ['filter' => 'auth']);
$routes->get('/konsultasidokter/apiDataGetByNoRegistrasi', 'Konsultasidokter::apiDataGetByNoRegistrasi', ['filter' => 'auth']);
$routes->get('/konsultasidokter/apiDataGetAlergiByPasien', 'Konsultasidokter::apiDataGetAlergiByPasien', ['filter' => 'auth']);
$routes->get('/konsultasidokter/apiDataGetDiagnosaTambahanByRegistrasi', 'Konsultasidokter::apiDataGetDiagnosaTambahanByRegistrasi', ['filter' => 'auth']);
$routes->get('/konsultasidokter/fetchAllAnamnesaCardByPasien', 'Konsultasidokter::fetchAllAnamnesaCardByPasien', ['filter' => 'auth']);
$routes->get('/konsultasidokter/fetchAllRiwayatCardByPasien', 'Konsultasidokter::fetchAllRiwayatCardByPasien', ['filter' => 'auth']);
$routes->get('/konsultasidokter/fetchAllRiwayat', 'Konsultasidokter::fetchAllRiwayat', ['filter' => 'auth']);
$routes->get('/konsultasidokter/fetchSingleData', 'Konsultasidokter::fetchSingleData', ['filter' => 'auth']);
$routes->get('/konsultasidokter/fetchSingleDataPrint/(:any)/(:any)', 'Konsultasidokter::fetchSingleDataPrint/$1/$2', ['filter' => 'auth']);

$routes->get('konsultasidokter/draw/(:segment)', 'Konsultasidokter::draw/$1', ['filter' => 'auth']);
$routes->get('konsultasidokter/getTitikKeluhanOptions', 'Konsultasidokter::getTitikKeluhanOptions', ['filter' => 'auth']);

// $routes->get('/konsultasidokter/draw/(:segment)', 'Konsultasidokter::draw/$1', ['filter' => 'auth']);
$routes->post('/konsultasidokter/doupload', 'Konsultasidokter::doupload', ['filter' => 'auth']);
$routes->post('/konsultasidokter/doupload1', 'Konsultasidokter::doupload1', ['filter' => 'auth']);

$routes->post('/konsultasidokter/action', 'Konsultasidokter::action', ['filter' => 'auth']);
$routes->post('/konsultasidokter/action2', 'Konsultasidokter::action2', ['filter' => 'auth']);
$routes->post('/konsultasidokter/action_anamnesa', 'Konsultasidokter::action_anamnesa', ['filter' => 'auth']);
$routes->post('/konsultasidokter/action_periksa', 'Konsultasidokter::action_periksa', ['filter' => 'auth']);
$routes->post('/konsultasidokter/action_diagnosa', 'Konsultasidokter::action_diagnosa', ['filter' => 'auth']);
$routes->post('/konsultasidokter/action_all', 'Konsultasidokter::action_all', ['filter' => 'auth']);
$routes->post('/konsultasidokter/action_all_draft', 'Konsultasidokter::action_all_draft', ['filter' => 'auth']);
$routes->post('/konsultasidokter/action_rujukan', 'Konsultasidokter::action_rujukan', ['filter' => 'auth']);
$routes->post('/konsultasidokter/delete', 'Konsultasidokter::delete', ['filter' => 'auth']);
$routes->get('/konsultasidokter/setNoRegistrasi', 'Konsultasidokter::setNoRegistrasi', ['filter' => 'auth']);
$routes->post('/konsultasidokter/delete_alergi', 'Konsultasidokter::delete_alergi', ['filter' => 'auth']);
$routes->post('/konsultasidokter/delete_diagnosa', 'Konsultasidokter::delete_diagnosa', ['filter' => 'auth']);
$routes->get('/konsultasidokter/apiDataGetAnamnesa', 'Konsultasidokter::apiDataGetAnamnesa', ['filter' => 'auth']);
$routes->get('/konsultasidokter/apiDataGetPeriksa', 'Konsultasidokter::apiDataGetPeriksa', ['filter' => 'auth']);
$routes->get('/konsultasidokter/apiDataGetDiagnosa', 'Konsultasidokter::apiDataGetDiagnosa', ['filter' => 'auth']);
$routes->get('/konsultasidokter/apiDataGetRujukan', 'Konsultasidokter::apiDataGetRujukan', ['filter' => 'auth']);
$routes->get('/konsultasidokter/apiDataGetTindakan', 'Konsultasidokter::apiDataGetTindakan', ['filter' => 'auth']);
$routes->get('/konsultasidokter/print/(:any)', 'Konsultasidokter::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->get('/konsultasidokter/ajaxKategoriAlergi/(:any)', 'Konsultasidokter::ajaxKategoriAlergi/$1', ['filter' => 'auth']);
$routes->get('/konsultasidokter/ajaxKategoriBiaya/(:any)', 'Konsultasidokter::ajaxKategoriBiaya/$1', ['filter' => 'auth']);
$routes->get('/konsultasidokter/ajaxItem/(:any)', 'Konsultasidokter::ajaxItem/$1', ['filter' => 'auth']);
$routes->get('/konsultasidokter/headerRujukan', 'Konsultasidokter::headerRujukan', ['filter' => 'auth']);
$routes->get('/konsultasidokter/titikKeluhan', 'Konsultasidokter::titikKeluhan', ['filter' => 'auth']);
$routes->get('/konsultasidokter/suratLayakTerbang', 'Konsultasidokter::suratLayakTerbang', ['filter' => 'auth']);
$routes->get('/konsultasidokter/suratLayakTerbangIbuHamil', 'Konsultasidokter::suratLayakTerbangIbuHamil', ['filter' => 'auth']);
$routes->get('/konsultasidokter/suratKeteranganIstirahat', 'Konsultasidokter::suratKeteranganIstirahat', ['filter' => 'auth']);
$routes->get('/konsultasidokter/suratKeteranganDokter', 'Konsultasidokter::suratKeteranganDokter', ['filter' => 'auth']);
$routes->get('/konsultasidokter/suratKeteranganSehat', 'Konsultasidokter::suratKeteranganSehat', ['filter' => 'auth']);
$routes->get('/konsultasidokter/suratKeteranganIstirahat', 'Konsultasidokter::suratKeteranganIstirahat', ['filter' => 'auth']);
$routes->get('/konsultasidokter/getDropdownLayananItem', 'Konsultasidokter::getDropdownLayananItem', ['filter' => 'auth']);
$routes->get('/konsultasidokter/apiDataLabGetAll', 'Konsultasidokter::apiDataLabGetAll', ['filter' => 'auth']);
$routes->get('/konsultasidokter/apiDataRadiologiGetAll', 'Konsultasidokter::apiDataRadiologiGetAll', ['filter' => 'auth']);
// $routes->get('/konsultasidokter/setDataPemeriksaanPerawat', 'Konsultasidokter::setDataPemeriksaanPerawat', ['filter' => 'auth']);

$routes->get('/konsultasidokter/setDataPemeriksaanPerawat', 'Konsultasidokter::setDataPemeriksaanPerawat', ['filter' => 'auth']);
$routes->get('/konsultasidokter/fetchPemeriksaanAwalByRegistrasi', 'Konsultasidokter::fetchPemeriksaanAwalByRegistrasi', ['filter' => 'auth']);

$routes->get('/konsultasidokterdraft', 'Konsultasidokterdraft::index', ['filter' => 'auth']);
$routes->get('/konsultasidokterdraft/fetchAll', 'Konsultasidokterdraft::fetchAll', ['filter' => 'auth']);
$routes->get('/konsultasidokterdraft/apiDataGetByDokter', 'Konsultasidokterdraft::apiDataGetByDokter', ['filter' => 'auth']);
$routes->get('/konsultasidokterdraft/fetchAllRiwayat', 'Konsultasidokterdraft::fetchAllRiwayat', ['filter' => 'auth']);
$routes->get('/konsultasidokterdraft/fetchSingleData', 'Konsultasidokterdraft::fetchSingleData', ['filter' => 'auth']);
$routes->get('/konsultasidokterdraft/fetchSingleDataPrint/(:any)/(:any)', 'Konsultasidokterdraft::fetchSingleDataPrint/$1/$2', ['filter' => 'auth']);
$routes->get('/konsultasidokterdraft/draw', 'Konsultasidokterdraft::draw', ['filter' => 'auth']);
$routes->post('/konsultasidokterdraft/doupload', 'Konsultasidokterdraft::doupload', ['filter' => 'auth']);
$routes->post('/konsultasidokterdraft/action', 'Konsultasidokterdraft::action', ['filter' => 'auth']);
$routes->post('/konsultasidokterdraft/action2', 'Konsultasidokterdraft::action2', ['filter' => 'auth']);
$routes->post('/konsultasidokterdraft/delete', 'Konsultasidokterdraft::delete', ['filter' => 'auth']);
$routes->get('/konsultasidokterdraft/setNoRegistrasi', 'Konsultasidokterdraft::setNoRegistrasi', ['filter' => 'auth']);

$routes->get('/fieldvalue', 'Fieldvalue::index', ['filter' => 'auth']);
$routes->get('/fieldvalue/fetchAll', 'Fieldvalue::fetchAll', ['filter' => 'auth']);
$routes->get('/fieldvalue/fetchSingleData', 'Fieldvalue::fetchSingleData', ['filter' => 'auth']);
$routes->get('/fieldvalue/fetchSingleDataPrint/(:any)/(:any)', 'Fieldvalue::fetchSingleDataPrint/$1/$2', ['filter' => 'auth']);
$routes->post('/fieldvalue/action', 'Fieldvalue::action', ['filter' => 'auth']);
$routes->post('/fieldvalue/delete', 'Fieldvalue::delete', ['filter' => 'auth']);
$routes->get('/fieldvalue/download', 'Fieldvalue::download');
$routes->post('/fieldvalue/upload', 'Fieldvalue::upload');
$routes->match(['get', 'post'], '/fieldvalue/preview', 'Fieldvalue::preview');
$routes->match(['get', 'post'], '/fieldvalue/uploaded', 'Fieldvalue::uploaded');

$routes->get('/controlparameter', 'Controlparameter::index', ['filter' => 'auth']);
$routes->get('/controlparameter/fetchAll', 'Controlparameter::fetchAll', ['filter' => 'auth']);
$routes->get('/controlparameter/fetchSingleData', 'Controlparameter::fetchSingleData', ['filter' => 'auth']);
$routes->get('/controlparameter/fetchSingleDataPrint/(:any)/(:any)', 'Controlparameter::fetchSingleDataPrint/$1/$2', ['filter' => 'auth']);
$routes->post('/controlparameter/action', 'Controlparameter::action', ['filter' => 'auth']);
$routes->post('/controlparameter/delete', 'Controlparameter::delete', ['filter' => 'auth']);

$routes->get('/menu', 'Menu::index', ['filter' => 'auth']);
$routes->get('/menu/fetchAll', 'Menu::fetchAll', ['filter' => 'auth']);
$routes->get('/menu/fetchSingleData', 'Menu::fetchSingleData', ['filter' => 'auth']);
$routes->get('/menu/fetchSingleDataPrint/(:any)/(:any)', 'Menu::fetchSingleDataPrint/$1/$2', ['filter' => 'auth']);
$routes->post('/menu/action', 'Menu::action', ['filter' => 'auth']);
$routes->post('/menu/delete', 'Menu::delete', ['filter' => 'auth']);

$routes->get('/menuheader', 'Menuheader::index', ['filter' => 'auth']);
$routes->get('/menuheader/fetchAll', 'Menuheader::fetchAll', ['filter' => 'auth']);
$routes->get('/menuheader/fetchSingleData', 'Menuheader::fetchSingleData', ['filter' => 'auth']);
$routes->get('/menuheader/fetchSingleDataPrint/(:any)/(:any)', 'Menuheader::fetchSingleDataPrint/$1/$2', ['filter' => 'auth']);
$routes->post('/menuheader/action', 'Menuheader::action', ['filter' => 'auth']);
$routes->post('/menuheader/delete', 'Menuheader::delete', ['filter' => 'auth']);

$routes->get('/tmenurole', 'Tmenurole::index', ['filter' => 'auth']);
$routes->get('/tmenurole/fetchAll', 'Tmenurole::fetchAll', ['filter' => 'auth']);
$routes->get('/tmenurole/fetchSingleData', 'Tmenurole::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmenurole/fetchSingleDataPrint/(:any)/(:any)', 'Tmenurole::fetchSingleDataPrint/$1/$2', ['filter' => 'auth']);
$routes->post('/tmenurole/action', 'Tmenurole::action', ['filter' => 'auth']);
$routes->post('/tmenurole/delete', 'Tmenurole::delete', ['filter' => 'auth']);
$routes->get('/tmenurole/download', 'Tmenurole::download');
$routes->post('/tmenurole/upload', 'Tmenurole::upload');
$routes->match(['get', 'post'], '/tmenurole/preview', 'Tmenurole::preview');
$routes->match(['get', 'post'], '/tmenurole/uploaded', 'Tmenurole::uploaded');

$routes->get('/tmstrole', 'Tmstrole::index', ['filter' => 'auth']);
$routes->get('/tmstrole/fetchAll', 'Tmstrole::fetchAll', ['filter' => 'auth']);
$routes->get('/tmstrole/fetchSingleData', 'Tmstrole::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmstrole/fetchSingleDataPrint/(:any)', 'Tmstrole::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tmstrole/action', 'Tmstrole::action', ['filter' => 'auth']);
$routes->post('/tmstrole/delete', 'Tmstrole::delete', ['filter' => 'auth']);

$routes->get('/tuserprofile', 'Tuserprofile::index', ['filter' => 'auth']);
$routes->get('/tuserprofile/fetchAll', 'Tuserprofile::fetchAll', ['filter' => 'auth']);
$routes->get('/tuserprofile/fetchSingleData', 'Tuserprofile::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tuserprofile/fetchSingleDataPrint/(:any)', 'Tuserprofile::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tuserprofile/action', 'Tuserprofile::action', ['filter' => 'auth']);
$routes->post('/tuserprofile/delete', 'Tuserprofile::delete', ['filter' => 'auth']);

$routes->get('/tdokterjadwal', 'Tdokterjadwal::index', ['filter' => 'auth']);
$routes->get('/tdokterjadwal/fetchAll', 'Tdokterjadwal::fetchAll', ['filter' => 'auth']);
$routes->get('/tdokterjadwal/fetchSingleData', 'Tdokterjadwal::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tdokterjadwal/fetchSingleDataPrint/(:any)', 'Tdokterjadwal::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tdokterjadwal/action', 'Tdokterjadwal::action', ['filter' => 'auth']);
$routes->post('/tdokterjadwal/actionRescedule', 'Tdokterjadwal::actionRescedule', ['filter' => 'auth']);
$routes->post('/tdokterjadwal/delete', 'Tdokterjadwal::delete', ['filter' => 'auth']);

$routes->get('/patient', 'Patient::index', ['filter' => 'auth']);
$routes->get('/patient/fetchAll', 'Patient::fetchAll', ['filter' => 'auth']);
$routes->get('/patient/fetchSingleData', 'Patient::fetchSingleData', ['filter' => 'auth']);
$routes->get('/patient/fetchSingleDataPrint/(:any)', 'Patient::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->get('/patient/prints', 'Patient::fetchAllDataPrint', ['filter' => 'auth']); //Uji
$routes->post('/patient/action', 'Patient::action', ['filter' => 'auth']);
$routes->post('/patient/delete', 'Patient::delete', ['filter' => 'auth']);
$routes->post('/patient/insertinto', 'Patient::insertinto', ['filter' => 'auth']);
$routes->post('/patient/insertdelete', 'Patient::insertdelete', ['filter' => 'auth']);


$routes->get('/jadwaldokter', 'Jadwaldokter::index', ['filter' => 'auth']);
$routes->get('/jadwaldokter/fetchAll', 'Jadwaldokter::fetchAll', ['filter' => 'auth']);
$routes->get('/jadwaldokter/fetchDokter', 'Jadwaldokter::fetchDokter', ['filter' => 'auth']);
$routes->get('/jadwaldokter/fetchJadwalByTgl', 'Jadwaldokter::fetchJadwalByTgl', ['filter' => 'auth']);
$routes->get('/jadwaldokter/fetchJadwalByDokter', 'Jadwaldokter::fetchJadwalByDokter', ['filter' => 'auth']);
$routes->get('/jadwaldokter/fetchSingleData', 'Jadwaldokter::fetchSingleData', ['filter' => 'auth']);
$routes->get('/jadwaldokter/fetchSingleDataPrint/(:any)', 'Jadwaldokter::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/jadwaldokter/action', 'Jadwaldokter::action', ['filter' => 'auth']);
$routes->post('/jadwaldokter/delete', 'Jadwaldokter::delete', ['filter' => 'auth']);

$routes->get('/tmstitem', 'Tmstitem::index', ['filter' => 'auth']);
$routes->get('/tmstitem/fetchAll', 'Tmstitem::fetchAll', ['filter' => 'auth']);
$routes->get('/tmstitem/fetchSingleData', 'Tmstitem::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmstitem/fetchSingleDataPrint/(:any)', 'Tmstitem::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tmstitem/action', 'Tmstitem::action', ['filter' => 'auth']);
$routes->post('/tmstitem/delete', 'Tmstitem::delete', ['filter' => 'auth']);

// $routes->get('/selfregistration', 'Selfregistration::index', ['filter' => 'auth']);
// $routes->post('/selfregistration/doupload', 'Selfregistration::doupload', ['filter' => 'auth']);

$routes->get('/selfregistration', 'Selfregistration::index');
$routes->post('/selfregistration/doupload', 'Selfregistration::doupload');
$routes->get('/selfregistration/buat', 'Selfregistration::buat');

$routes->get('/rekammedis', 'Rekammedis::index', ['filter' => 'auth']);

$routes->get('/maps', 'Maps::index', ['filter' => 'auth']);

$routes->get('/leaflet', 'Leaflet::index', ['filter' => 'auth']);

//Kunjungan Pasien 
$routes->get('/kunjunganpasien', 'Kunjunganpasien::index', ['filter' => 'auth']);
$routes->get('/kunjunganpasien/fetchAll', 'Kunjunganpasien::fetchAll', ['filter' => 'auth']);
$routes->get('/kunjunganpasien/fetchSingleData', 'Kunjunganpasien::fetchSingleData', ['filter' => 'auth']);
$routes->get('/kunjunganpasien/fetchSingleDataPrint/(:any)', 'Kunjunganpasien::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/kunjunganpasien/action', 'Kunjunganpasien::action', ['filter' => 'auth']);
$routes->post('/kunjunganpasien/delete', 'Kunjunganpasien::delete', ['filter' => 'auth']);

$routes->get('/tregistrasi', 'Tregistrasi::index', ['filter' => 'auth']);
$routes->get('/tregistrasi/fetchAll', 'Tregistrasi::fetchAll', ['filter' => 'auth']);
$routes->get('/tregistrasi/fetchAllView', 'Tregistrasi::fetchAllView', ['filter' => 'auth']);
$routes->get('/tregistrasi/fetchSingleData', 'Tregistrasi::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tregistrasi/fetchSingleDataPrint/(:any)', 'Tregistrasi::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tregistrasi/action', 'Tregistrasi::action', ['filter' => 'auth']);
$routes->post('/tregistrasi/actionRescedule', 'Tregistrasi::actionRescedule', ['filter' => 'auth']);
$routes->post('/tregistrasi/delete', 'Tregistrasi::delete', ['filter' => 'auth']);
$routes->post('/tregistrasi/hadir', 'Tregistrasi::hadir', ['filter' => 'auth']);
$routes->post('/tregistrasi/batal', 'Tregistrasi::batal', ['filter' => 'auth']);
$routes->get('/tregistrasi/getDropdown', 'Tregistrasi::getDropdown', ['filter' => 'auth']);
$routes->post('/tregistrasi/datatables', 'Tregistrasi::datatables');

$routes->get('/rptregistrasi', 'RptRegistrasi::index', ['filter' => 'auth']);
$routes->get('/rptregistrasi/search', 'RptRegistrasi::search', ['filter' => 'auth']);
$routes->get('/rptregistrasi/prints', 'RptRegistrasi::fetchAllDataPrint', ['filter' => 'auth']); //Uji

$routes->get('/inqregistrasi', 'InqRegistrasi::index', ['filter' => 'auth']);
$routes->get('/inqregistrasi/search', 'InqRegistrasi::search', ['filter' => 'auth']);
$routes->get('/inqregistrasi/prints', 'InqRegistrasi::fetchAllDataPrint', ['filter' => 'auth']); //Uji

$routes->get('/inqsurat', 'InqSurat::index', ['filter' => 'auth']);
$routes->get('/inqsurat/search', 'InqSurat::search', ['filter' => 'auth']);
$routes->get('/inqsurat/prints', 'InqSurat::fetchAllDataPrint', ['filter' => 'auth']); //Uji
$routes->post('/inqsurat/action', 'InqSurat::action', ['filter' => 'auth']);
$routes->post('/inqsurat/delete', 'InqSurat::delete', ['filter' => 'auth']);

$routes->get('/ttarif', 'Ttarif::index', ['filter' => 'auth']);
$routes->get('/ttarif/fetchAll', 'Ttarif::fetchAll', ['filter' => 'auth']);
$routes->get('/ttarif/fetchSingleData', 'Ttarif::fetchSingleData', ['filter' => 'auth']);
$routes->get('/ttarif/fetchSingleDataPrint/(:any)', 'Ttarif::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/ttarif/action', 'Ttarif::action', ['filter' => 'auth']);
$routes->post('/ttarif/delete', 'Ttarif::delete', ['filter' => 'auth']);

$routes->get('/tasuransipersen', 'Tasuransipersen::index', ['filter' => 'auth']);
$routes->get('/tasuransipersen/fetchAll', 'Tasuransipersen::fetchAll', ['filter' => 'auth']);
$routes->get('/tasuransipersen/fetchSingleData', 'Tasuransipersen::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tasuransipersen/fetchSingleDataPrint/(:any)', 'Tasuransipersen::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tasuransipersen/action', 'Tasuransipersen::action', ['filter' => 'auth']);
$routes->post('/tasuransipersen/delete', 'Tasuransipersen::delete', ['filter' => 'auth']);

$routes->get('/tasuransi', 'Tasuransi::index', ['filter' => 'auth']);
$routes->get('/tasuransi/fetchAll', 'Tasuransi::fetchAll', ['filter' => 'auth']);
$routes->get('/tasuransi/fetchSingleData', 'Tasuransi::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tasuransi/fetchSingleDataPrint/(:any)', 'Tasuransi::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tasuransi/action', 'Tasuransi::action', ['filter' => 'auth']);
$routes->post('/tasuransi/delete', 'Tasuransi::delete', ['filter' => 'auth']);

$routes->get('/temployee', 'Temployee::index', ['filter' => 'auth']);
$routes->get('/temployee/fetchAll', 'Temployee::fetchAll', ['filter' => 'auth']);
$routes->get('/temployee/fetchSingleData', 'Temployee::fetchSingleData', ['filter' => 'auth']);
$routes->get('/temployee/fetchSingleDataPrint/(:any)', 'Temployee::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/temployee/action', 'Temployee::action', ['filter' => 'auth']);
$routes->post('/temployee/delete', 'Temployee::delete', ['filter' => 'auth']);

// $routes->get('/deposit', 'Deposit::index', ['filter' => 'auth']);
// $routes->get('/deposit/fetchAll', 'Deposit::fetchAll', ['filter' => 'auth']);
// $routes->get('/deposit/fetchSingleData', 'Deposit::fetchSingleData', ['filter' => 'auth']);
// $routes->get('/deposit/fetchSingleDataPrint/(:any)', 'Deposit::fetchSingleDataPrint/$1', ['filter' => 'auth']);
// $routes->post('/deposit/action', 'Deposit::action', ['filter' => 'auth']);
// $routes->post('/deposit/delete', 'Deposit::delete', ['filter' => 'auth']);
// $routes->post('/deposit/store', 'Deposit::store', ['filter' => 'auth']);
$routes->get('/deposit/registrasi', 'Deposit::fetchDataKasirListRegistrasi', ['filter' => 'auth']);
// $routes->get('/deposit/item', 'Deposit::fetchDataKasirListItem', ['filter' => 'auth']);
// // $routes->get('/deposit/item/(:any)', 'Deposit::fetchDataKasirListItem/$1', ['filter' => 'auth']);
$routes->get('/deposit/setnoregistrasi', 'Deposit::setNoRegistrasi', ['filter' => 'auth']);
// $routes->get('/deposit/removenoregistrasi', 'Deposit::removeNoRegistrasi', ['filter' => 'auth']);
// $routes->get('/deposit/ceksession', 'Deposit::checkSession', ['filter' => 'auth']);
// $routes->get('/deposit/nokwitansi', 'Deposit::apiDataGetNoKwitansi', ['filter' => 'auth']);
$routes->get('/deposit/listbilling', 'Deposit::fetchDataKasirListBilling', ['filter' => 'auth']);
// $routes->get('/deposit/print/(:any)', 'Deposit::fetchSingleDataPrint/$1', ['filter' => 'auth']);
// $routes->get('/deposit/edit/(:any)', 'Deposit::fetchSingleDataEdit/$1', ['filter' => 'auth']);

// $routes->get('/kasir', 'Kasir::index', ['filter' => 'auth']);
// $routes->get('/kasir/fetchAll', 'Kasir::fetchAll', ['filter' => 'auth']);
// $routes->get('/kasir/fetchSingleData', 'Kasir::fetchSingleData', ['filter' => 'auth']);
// $routes->get('/kasir/fetchSingleDataPrint/(:any)', 'Kasir::fetchSingleDataPrint/$1', ['filter' => 'auth']);
// $routes->post('/kasir/action', 'Kasir::action', ['filter' => 'auth']);
// $routes->post('/kasir/delete', 'Kasir::delete', ['filter' => 'auth']);
// $routes->post('/kasir/store', 'Kasir::store', ['filter' => 'auth']);
$routes->get('/kasir/registrasi', 'Kasir::fetchDataKasirListRegistrasi', ['filter' => 'auth']);
// $routes->get('/kasir/item', 'Kasir::fetchDataKasirListItem', ['filter' => 'auth']);
// $routes->get('/kasir/setnoregistrasi', 'Kasir::setNoRegistrasi', ['filter' => 'auth']);
// $routes->get('/kasir/removenoregistrasi', 'Kasir::removeNoRegistrasi', ['filter' => 'auth']);
// $routes->get('/kasir/ceksession', 'Kasir::checkSession', ['filter' => 'auth']);
// $routes->get('/kasir/nokwitansi', 'Kasir::apiDataGetNoKwitansi', ['filter' => 'auth']);
// $routes->get('/kasir/listbilling', 'Kasir::fetchDataKasirListBilling', ['filter' => 'auth']);
$routes->get('/kasir/print/(:any)', 'Kasir::fetchSingleDataPrint/$1', ['filter' => 'auth']);
// $routes->get('/kasir/edit/(:any)', 'Kasir::fetchSingleDataEdit/$1', ['filter' => 'auth']);
// $routes->post('/kasir/fetchallitems', 'Kasir::fetchAllItems', ['filter' => 'auth']);

$routes->get('/kasir', 'Kasir::index');
$routes->get('/kasir/edit', 'Kasir::edit');

// ── Registrasi (listing kunjungan untuk dipilih di layar Deposit) ───────────
// $routes->get('/kasir/registrasi', 'Kasir::apiDataGetRegistrasi');
$routes->get('/kasir/fetchall', 'Kasir::fetchAll', ['filter' => 'auth']);
$routes->get('/kasir/debugbilling', 'Kasir::debugBilling', ['filter' => 'auth']);

$routes->post('/kasir/hadir', 'Kasir::hadir', ['filter' => 'auth']);
$routes->post('/kasir/registrasi/batal', 'Kasir::batal', ['filter' => 'auth']);
$routes->post('/kasir/delete', 'Kasir::delete', ['filter' => 'auth']);
$routes->post('/kasir/store', 'Kasir::store', ['filter' => 'auth']);
$routes->post('/kasir/setnoregistrasi', 'Kasir::setNoRegistrasi', ['filter' => 'auth']);
$routes->post('/kasir/removenoregistrasi', 'Kasir::removeNoRegistrasi', ['filter' => 'auth']);

// ── Deposit (Kunjungan & Paket) ──────────────────────────────────────────────
$routes->get('/kasir/saldo', 'Kasir::getSaldo', ['filter' => 'auth']);
$routes->get('/kasir/riwayat', 'Kasir::getRiwayat', ['filter' => 'auth']);
$routes->get('/kasir/detail', 'Kasir::getDetailDeposit', ['filter' => 'auth']);
$routes->post('/kasir/simpan', 'Kasir::simpanDeposit', ['filter' => 'auth']);
$routes->post('/kasir/gunakan', 'Kasir::gunakanDeposit', ['filter' => 'auth']);
$routes->post('/kasir/batal', 'Kasir::batalDeposit', ['filter' => 'auth']);
$routes->post('/kasir/refund', 'Kasir::refundDeposit', ['filter' => 'auth']);

// ── Payment (tagihan & proses bayar) ─────────────────────────────────────────
$routes->get('/kasir/kwitansiaktif', 'Kasir::getKwitansiAktif', ['filter' => 'auth']);
$routes->get('/kasir/tagihanpembayaran', 'Kasir::getTagihanPembayaran', ['filter' => 'auth']);
$routes->get('/kasir/ringkasanpembayaran', 'Kasir::getRingkasanPembayaran', ['filter' => 'auth']);
$routes->get('/kasir/detailpembayaran', 'Kasir::getDetailPembayaran', ['filter' => 'auth']);
$routes->get('/kasir/payerlist', 'Kasir::payerList', ['filter' => 'auth']);
$routes->post('/kasir/prosespembayaran', 'Kasir::prosesPembayaran', ['filter' => 'auth']);
$routes->get('/kasir/riwayatpembayaran', 'Kasir::getRiwayatPembayaran', ['filter' => 'auth']);
$routes->post('/kasir/batalpembayaran', 'Kasir::batalPembayaran', ['filter' => 'auth']);
$routes->post('/kasir/batalpembayaran/(:num)', 'Kasir::batalPembayaran/$1', ['filter' => 'auth']);


/*
 * --------------------------------------------------------------------
 * Coba Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */

// ------------------------------------ Start Routes Rifaaa ------------------------------------

// Administrative Service > Currency & Rate > Currency Rate Type | Created By Rifa | 05 Maret 2026
$routes->get('/tmstcurrencyratetype', 'Tmstcurrencyratetype::index', ['filter' => 'auth']);
$routes->post('/tmstcurrencyratetype/datatables', 'Tmstcurrencyratetype::datatables', ['filter' => 'auth']);
$routes->post('/tmstcurrencyratetype/getDetailsByToCurrency', 'Tmstcurrencyratetype::getDetailsByToCurrency', ['filter' => 'auth']);
$routes->get('/tmstcurrencyratetype/getAllCurrencies', 'Tmstcurrencyratetype::getAllCurrencies', ['filter' => 'auth']);
$routes->get('/tmstcurrencyratetype/getAllRateTypes', 'Tmstcurrencyratetype::getAllRateTypes', ['filter' => 'auth']);
$routes->get('/tmstcurrencyratetype/fetchSingleData', 'Tmstcurrencyratetype::fetchSingleData', ['filter' => 'auth']);
$routes->post('/tmstcurrencyratetype/action', 'Tmstcurrencyratetype::action', ['filter' => 'auth']);
$routes->post('/tmstcurrencyratetype/delete', 'Tmstcurrencyratetype::delete', ['filter' => 'auth']);
$routes->post('/tmstcurrencyratetype/checkDuplicate', 'Tmstcurrencyratetype::checkDuplicate', ['filter' => 'auth']);
// Administrative Service > Currency & Rate > Currency Rate Type | Created By Rifa | 05 Maret 2026

// Account Receiveble (A/R) > A/R Setup > A/R Customers Group | Created By Rifa | 2 Maret 2026
$routes->get('/tmstarcustomersgroup', 'Tmstarcustomersgroup::index', ['filter' => 'auth']);
$routes->post('/tmstarcustomersgroup/action', 'Tmstarcustomersgroup::action', ['filter' => 'auth']);
$routes->post('/tmstarcustomersgroup/datatables', 'Tmstarcustomersgroup::datatables', ['filter' => 'auth']);
$routes->get('/tmstarcustomersgroup/fetchSingleData', 'Tmstarcustomersgroup::fetchSingleData', ['filter' => 'auth']);
// Account Receiveble (A/R) > A/R Setup > A/R Customers Group | Created By Rifa | 2 Maret 2026

// Account Receiveble (A/R) > A/R Setup > A/R Customers | Created By Rifa | 2 Maret 2026
$routes->get('/tmstarcustomers', 'Tmstarcustomers::index', ['filter' => 'auth']);
$routes->post('/tmstarcustomers/action', 'Tmstarcustomers::action', ['filter' => 'auth']);
$routes->post('/tmstarcustomers/datatables', 'Tmstarcustomers::datatables', ['filter' => 'auth']);
$routes->get('/tmstarcustomers/fetchSingleData', 'Tmstarcustomers::fetchSingleData', ['filter' => 'auth']);
// Account Receiveble (A/R) > A/R Setup > A/R Customers | Created By Rifa | 2 Maret 2026

// Account Receiveble (A/R) > A/R Setup > A/R Terms | Created By Rifa | 2 Maret 2026
$routes->get('/tmstarterms', 'Tmstarterms::index', ['filter' => 'auth']);
$routes->post('/tmstarterms/action', 'Tmstarterms::action', ['filter' => 'auth']);
$routes->post('/tmstarterms/datatables', 'Tmstarterms::datatables', ['filter' => 'auth']);
$routes->get('/tmstarterms/fetchSingleData', 'Tmstarterms::fetchSingleData', ['filter' => 'auth']);
// Account Receiveble (A/R) > A/R Setup > A/R Terms | Created By Rifa | 2 Maret 2026

// Account Receiveble (A/R) > A/R Setup > A/R Revenue Code | Created By Rifa | 2 Maret 2026
$routes->get('/tmstarrevenuecode', 'Tmstarrevenuecode::index', ['filter' => 'auth']);
$routes->post('/tmstarrevenuecode/action', 'Tmstarrevenuecode::action', ['filter' => 'auth']);
$routes->post('/tmstarrevenuecode/datatables', 'Tmstarrevenuecode::datatables', ['filter' => 'auth']);
$routes->get('/tmstarrevenuecode/fetchSingleData', 'Tmstarrevenuecode::fetchSingleData', ['filter' => 'auth']);
// Account Receiveble (A/R) > A/R Setup > A/R Revenue Code | Created By Rifa | 2 Maret 2026

// Account Receiveble (A/R) > A/R Setup > A/R Account Set| Created By Rifa | 2 Maret 2026
$routes->get('/tmstaraccountset', 'Tmstaraccountset::index', ['filter' => 'auth']);
$routes->post('/tmstaraccountset/action', 'Tmstaraccountset::action', ['filter' => 'auth']);
$routes->post('/tmstaraccountset/datatables', 'Tmstaraccountset::datatables', ['filter' => 'auth']);
$routes->get('/tmstaraccountset/fetchSingleData', 'Tmstaraccountset::fetchSingleData', ['filter' => 'auth']);
// Account Receiveble (A/R) > A/R Setup > A/R Account Set | Created By Rifa | 2 Maret 2026

// Account Receiveble (A/R) > A/R Setup > A/R Option > Created By Rifa | 2 Maret 2026
$routes->get('/tmstaroption', 'Tmstaroption::index', ['filter' => 'auth']);
$routes->get('/tmstaroption/fetchGlOptionPosting', 'Tmstaroption::fetchGlOptionPosting', ['filter' => 'auth']);
$routes->post('/tmstaroption/saveGlOptionPosting', 'Tmstaroption::saveGlOptionPosting', ['filter' => 'auth']);
// Account Receiveble (A/R) > A/R Setup > A/R Option > Created By Rifa | 2 Maret 2026

// Administrative Service > Currency & Rate > Currency Rate | Created By Rifa | 27 Februari 2026
$routes->get('/tmstcurrencyrate', 'Tmstcurrencyrate::index', ['filter' => 'auth']);
$routes->post('/tmstcurrencyrate/datatables', 'Tmstcurrencyrate::datatables', ['filter' => 'auth']);
$routes->post('/tmstcurrencyrate/getDetailsByToCurrency', 'Tmstcurrencyrate::getDetailsByToCurrency', ['filter' => 'auth']);
$routes->get('/tmstcurrencyrate/getAllCurrencies', 'Tmstcurrencyrate::getAllCurrencies', ['filter' => 'auth']);
$routes->get('/tmstcurrencyrate/getAllRateTypes', 'Tmstcurrencyrate::getAllRateTypes', ['filter' => 'auth']);
$routes->get('/tmstcurrencyrate/getCurrencyId', 'Tmstcurrencyrate::getCurrencyId', ['filter' => 'auth']);
$routes->get('/tmstcurrencyrate/fetchSingleData', 'Tmstcurrencyrate::fetchSingleData', ['filter' => 'auth']);
$routes->post('/tmstcurrencyrate/action', 'Tmstcurrencyrate::action', ['filter' => 'auth']);
$routes->post('/tmstcurrencyrate/delete', 'Tmstcurrencyrate::delete', ['filter' => 'auth']);
$routes->post('/tmstcurrencyrate/deleteDetail', 'Tmstcurrencyrate::deleteDetail', ['filter' => 'auth']);
$routes->post('/tmstcurrencyrate/checkDuplicate', 'Tmstcurrencyrate::checkDuplicate', ['filter' => 'auth']);
// Administrative Service > Currency & Rate > Currency Rate | Created By Rifa | 27 Februari 2026

// Administrative Service > Currency & Rate > Currency Code | Created By Rifa | 27 Februari 2026
$routes->get('/tmstcurrencycode', 'Tmstcurrencycode::index', ['filter' => 'auth']);
$routes->post('/tmstcurrencycode/action', 'Tmstcurrencycode::action', ['filter' => 'auth']);
$routes->post('/tmstcurrencycode/datatables', 'Tmstcurrencycode::datatables', ['filter' => 'auth']);
$routes->get('/tmstcurrencycode/fetchSingleData', 'Tmstcurrencycode::fetchSingleData', ['filter' => 'auth']);
// Administrative Service > Currency & Rate > Currency Code | Created By Rifa | 27 Februari 2026

// Administrative Service > Tax Services > Tax Group | Created By Rifa | 27 Februari 2026
$routes->get('/tmsttaxgroup', 'Tmsttaxgroup::index', ['filter' => 'auth']);
$routes->get('tmsttaxgroup/getLineNoDropdown', 'Tmsttaxgroup::getLineNoDropdown', ['filter' => 'auth']);
$routes->get('tmsttaxgroup/getRateTypeDropdown', 'Tmsttaxgroup::getRateTypeDropdown', ['filter' => 'auth']);
$routes->get('tmsttaxgroup/fetchSingleData', 'Tmsttaxgroup::fetchSingleData', ['filter' => 'auth']);
$routes->post('tmsttaxgroup/datatables', 'Tmsttaxgroup::datatables', ['filter' => 'auth']);
$routes->post('tmsttaxgroup/datatablesgroupheader', 'Tmsttaxgroup::datatablesgroupheader', ['filter' => 'auth']);
$routes->post('tmsttaxgroup/action', 'Tmsttaxgroup::action', ['filter' => 'auth']);
// Administrative Service > Tax Services > Tax Group | Created By Rifa | 27 Februari 2026

// Administrative Service > Tax Services > Tax Rate | Created By Rifa | 27 Februari 2026
$routes->get('/tmsttaxrate', 'Tmsttaxrate::index', ['filter' => 'auth']);
$routes->post('/tmsttaxrate/action', 'Tmsttaxrate::action', ['filter' => 'auth']);
$routes->post('/tmsttaxrate/datatables', 'Tmsttaxrate::datatables', ['filter' => 'auth']);
$routes->post('/tmsttaxrate/datatablestaxclass', 'Tmsttaxrate::datatablestaxclass', ['filter' => 'auth']);
$routes->get('/tmsttaxrate/fetchSingleData', 'Tmsttaxrate::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmsttaxrate/getTaxRateDetails', 'Tmsttaxrate::getTaxRateDetails', ['filter' => 'auth']);
$routes->get('/tmsttaxrate/getDetailData', 'Tmsttaxrate::getDetailData', ['filter' => 'auth']);
$routes->post('/tmsttaxrate/deleteDetail', 'Tmsttaxrate::deleteDetail', ['filter' => 'auth']);
// Administrative Service > Tax Services > Tax Rate | Created By Rifa | 27 Februari 2026

// Administrative Service > Tax Services > Tax Class | Created By Rifa | 27 Februari 2026
$routes->get('/tmsttaxclass', 'Tmsttaxclass::index', ['filter' => 'auth']);
$routes->post('/tmsttaxclass/action', 'Tmsttaxclass::action', ['filter' => 'auth']);
$routes->post('/tmsttaxclass/datatables', 'Tmsttaxclass::datatables', ['filter' => 'auth']);
$routes->get('/tmsttaxclass/fetchSingleData', 'Tmsttaxclass::fetchSingleData', ['filter' => 'auth']);
// Administrative Service > Tax Services > Tax Class | Created By Rifa | 27 Februari 2026

// General Ledger (G/L) > G/L Periodic Processing > G/L Recurring Process| Created By Rifa | 11 Maret 2026
$routes->get('/tmstglrecurringprocess', 'tmstglrecurringprocess::index', ['filter' => 'auth']);
// General Ledger (G/L) > G/L Periodic Processing > G/L Recurring Process| Created By Rifa | 11 Maret 2026

// General Ledger (G/L) > G/L Transaction Entry > G/L Budget Entry | Created By Rifa | 11 Maret 2026
$routes->get('/tmstglbudgetentry', 'Tmstglbudgetentry::index', ['filter' => 'auth']);
// General Ledger (G/L) > G/L Transaction Entry > G/L Budget Entry | Created By Rifa | 11 Maret 2026

// General Ledger (G/L) > G/L Periodic Processing > G/L Reverse Process | Created By Rifa | 25 Februari 2026
$routes->get('/tmstglreverseprocess', 'Tmstglreverseprocess::index', ['filter' => 'auth']);
$routes->post('/tmstglreverseprocess/action', 'Tmstglreverseprocess::action', ['filter' => 'auth']);
$routes->post('/tmstglreverseprocess/datatables', 'Tmstglreverseprocess::datatables', ['filter' => 'auth']);
// General Ledger (G/L) > G/L Periodic Processing > G/L Reverse Process | Created By Rifa | 25 Februari 2026

// Administrative Services > Company Profile | Created By Rifa | 25 Februari 2026
$routes->get('/companyprofile', 'Companyprofile::index', ['filter' => 'auth']);
$routes->get('/companyprofile/fetchAll', 'Companyprofile::fetchAll', ['filter' => 'auth']);
$routes->get('/companyprofile/fetchAddress', 'Companyprofile::fetchAddress', ['filter' => 'auth']);
$routes->post('/companyprofile/saveAddress', 'Companyprofile::saveAddress', ['filter' => 'auth']);
$routes->get('/companyprofile/fetchEmail', 'Companyprofile::fetchEmail', ['filter' => 'auth']);
$routes->post('/companyprofile/saveEmail', 'Companyprofile::saveEmail', ['filter' => 'auth']);
// Administrative Services > Company Profile | Created By Rifa | 25 Februari 2026

// General Ledger (G/L) > General Ledger (G/L) > G/L Periodic Processing > G/L Allocation Process | Created By Rifa | 3 Februari 2026
$routes->get('/tmstglallocationprocess', 'Tmstglallocationprocess::index', ['filter' => 'auth']);
$routes->post('/tmstglallocationprocess/action', 'Tmstglallocationprocess::action', ['filter' => 'auth']);
// General Ledger (G/L) > General Ledger (G/L) > G/L Periodic Processing > G/L Allocation Process | Created By Rifa | 3 Februari 2026

// General Ledger (G/L) > General Ledger (G/L) > G/L Transaction Entry > G/L Allocation Entry | Created By Rifa | 02 Februari 2026
$routes->get('/tmstglallocationentry', 'Tmstglallocationentry::index', ['filter' => 'auth']);
$routes->get('/tmstglallocationentry', 'Tmstglallocationentry::detail', ['filter' => 'auth']);
$routes->get('/tmstglallocationentry/fetchAll', 'Tmstglallocationentry::fetchAll', ['filter' => 'auth']);
$routes->get('/tmstglallocationentry/fetchSingleData', 'Tmstglallocationentry::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmstglallocationentry/fetchSingleDataPrint/(:any)', 'Tmstglallocationentry::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tmstglallocationentry/action', 'Tmstglallocationentry::action', ['filter' => 'auth']);
$routes->post('/tmstglallocationentry/datatables', 'Tmstglallocationentry::datatables', ['filter' => 'auth']);
$routes->post('/tmstglallocationentry/delete', 'Tmstglallocationentry::delete', ['filter' => 'auth']);
$routes->post('/tmstglallocationentry/checkduplicate', 'Tmstglallocationentry::checkDuplicate', ['filter' => 'auth']);
$routes->get('/tmstglallocationentry/download', 'Tmstglallocationentry::download');
$routes->post('/tmstglallocationentry/import', 'Tmstglallocationentry::import');
$routes->post('/tmstglallocationentry/upload', 'Tmstglallocationentry::upload');
$routes->match(['get', 'post'], '/tmstglallocationentry/preview', 'Tmstglallocationentry::preview');
$routes->match(['get', 'post'], '/tmstglallocationentry/uploaded', 'Tmstglallocationentry::uploaded');
// General Ledger (G/L) > General Ledger (G/L) > G/L Transaction Entry > G/L Allocation Entry | Created By Rifa | 02 Februari 2026

// General Ledger (G/L) > G/L Setup > G/L Chart of Account | Created By Rifa | 16 Januari 2026
$routes->get('/tmstglcoa', 'Tmstglcoa::index', ['filter' => 'auth']);
$routes->get('/tmstglcoa/fetchAll', 'Tmstglcoa::fetchAll', ['filter' => 'auth']);
$routes->get('/tmstglcoa/fetchSingleData', 'Tmstglcoa::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmstglcoa/fetchSingleDataPrint/(:any)', 'Tmstglcoa::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tmstglcoa/action', 'Tmstglcoa::action', ['filter' => 'auth']);

$routes->post('/tmstglcoa/datatables', 'Tmstglcoa::datatables', ['filter' => 'auth']);
$routes->post('/tmstglcoa/datatablesaccountclosing', 'Tmstglcoa::datatablesaccountclosing', ['filter' => 'auth']);
$routes->post('/tmstglcoa/datatablesaccountgroup', 'Tmstglcoa::datatablesaccountgroup', ['filter' => 'auth']);
$routes->post('/tmstglcoa/delete', 'Tmstglcoa::delete', ['filter' => 'auth']);
$routes->post('/tmstglcoa/checkDuplicate', 'Tmstglcoa::checkDuplicate', ['filter' => 'auth']);
$routes->get('/tmstglcoa/download', 'Tmstglcoa::download');
$routes->post('/tmstglcoa/import', 'Tmstglcoa::import');
$routes->post('/tmstglcoa/upload', 'Tmstglcoa::upload');
$routes->get('/tmstglcoa/exportExcel', 'Tmstglcoa::exportExcel', ['filter' => 'auth']);
$routes->get('/tmstglcoa/exportExcel/(:any)', 'Tmstglcoa::exportExcel/$1', ['filter' => 'auth']);
$routes->match(['get', 'post'], '/tmstglcoa/preview', 'Tmstglcoa::preview');
$routes->match(['get', 'post'], '/tmstglcoa/uploaded', 'Tmstglcoa::uploaded');
// General Ledger (G/L) > G/L Setup > G/L Chart of Account | Created By Rifa | 16 Januari 2026

// General Ledger (G/L) > G/L Setup > G/L Account Structure | Created By Rifa | 15 Januari 2026
$routes->get('/tmstglactstructur', 'Tmstglactstructur::index', ['filter' => 'auth']);
$routes->get('/tmstglactstructur/fetchAll', 'Tmstglactstructur::fetchAll', ['filter' => 'auth']);
$routes->get('/tmstglactstructur/fetchSingleData', 'Tmstglactstructur::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmstglactstructur/fetchSingleDataPrint/(:any)', 'Tmstglactstructur::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tmstglactstructur/action', 'Tmstglactstructur::action', ['filter' => 'auth']);
$routes->post('/tmstglactstructur/datatables', 'Tmstglactstructur::datatables', ['filter' => 'auth']);
$routes->post('/tmstglactstructur/delete', 'Tmstglactstructur::delete', ['filter' => 'auth']);
$routes->post('/tmstglactstructur/checkduplicate', 'Tmstglactstructur::checkDuplicate', ['filter' => 'auth']);
$routes->get('/tmstglactstructur/download', 'Tmstglactstructur::download');
$routes->post('/tmstglactstructur/import', 'Tmstglactstructur::import');
$routes->post('/tmstglactstructur/upload', 'Tmstglactstructur::upload');
$routes->get('/tmstglactstructur/exportExcel', 'Tmstglactstructur::exportExcel', ['filter' => 'auth']);
$routes->get('/tmstglactstructur/exportExcel/(:any)', 'Tmstglactstructur::exportExcel/$1', ['filter' => 'auth']);
$routes->get('/tmstglactstructur/printData', 'Tmstglactstructur::printData', ['filter' => 'auth']);
$routes->get('/tmstglactstructur/printData/(:any)', 'Tmstglactstructur::printData/$1', ['filter' => 'auth']);
$routes->match(['get', 'post'], '/tmstglactstructur/preview', 'Tmstglactstructur::preview');
$routes->match(['get', 'post'], '/tmstglactstructur/uploaded', 'Tmstglactstructur::uploaded');
// General Ledger (G/L) > G/L Setup > G/L Account Structure | Created By Rifa | 15 Januari 2026

// General Ledger (G/L) > General Ledger (G/L) > G/L Setup > G/L Account Group | Created By Rifa | 15 Januari 2026
$routes->get('/tmstglactgroup', 'Tmstglactgroup::index', ['filter' => 'auth']);
$routes->get('/tmstglactgroup/fetchAll', 'Tmstglactgroup::fetchAll', ['filter' => 'auth']);
$routes->get('/tmstglactgroup/fetchSingleData', 'Tmstglactgroup::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmstglactgroup/fetchSingleDataPrint/(:any)', 'Tmstglactgroup::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tmstglactgroup/action', 'Tmstglactgroup::action', ['filter' => 'auth']);
$routes->post('/tmstglactgroup/datatables', 'Tmstglactgroup::datatables', ['filter' => 'auth']);
$routes->post('/tmstglactgroup/delete', 'Tmstglactgroup::delete', ['filter' => 'auth']);
$routes->post('/tmstglactgroup/checkDuplicate', 'Tmstglactgroup::checkDuplicate', ['filter' => 'auth']);
$routes->get('/tmstglactgroup/download', 'Tmstglactgroup::download');
$routes->post('/tmstglactgroup/import', 'Tmstglactgroup::import');
$routes->post('/tmstglactgroup/upload', 'Tmstglactgroup::upload');
$routes->get('/tmstglactgroup/printData', 'Tmstglactgroup::printData', ['filter' => 'auth']);
$routes->get('/tmstglactgroup/printData/(:any)', 'Tmstglactgroup::printData/$1', ['filter' => 'auth']);
$routes->get('/tmstglactgroup/exportExcel', 'Tmstglactgroup::exportExcel', ['filter' => 'auth']);
$routes->get('/tmstglactgroup/exportExcel/(:any)', 'Tmstglactgroup::exportExcel/$1', ['filter' => 'auth']);
$routes->match(['get', 'post'], '/tmstglactgroup/preview', 'Tmstglactgroup::preview');
$routes->match(['get', 'post'], '/tmstglactgroup/uploaded', 'Tmstglactgroup::uploaded');
// General Ledger (G/L) > G/L Setup > G/L Account Group | Created By Rifa | 15 Januari 2026

// General Ledger (G/L) > G/L Periodic Processing | G/L Closing Year | Created By Rifa | 06 Januari 2026
$routes->get('/tmstglclosingyear', 'Tmstglclosingyear::index', ['filter' => 'auth']);
$routes->post('/tmstglclosingyear/startClosing', 'Tmstglclosingyear::startClosing', ['filter' => 'auth']);
$routes->post('/tmstglclosingyear/action', 'Tmstglclosingyear::action', ['filter' => 'auth']);
// General Ledger (G/L) > G/L Periodic Processing | G/L Closing Year | Created By Rifa | 06 Januari 2026

// General Ledger (G/L) > G/L Setup | G/L Segment | Created By Rifa | 22 Desember 2025
$routes->get('/tmstglsegment', 'Tmstglsegment::index', ['filter' => 'auth']);
$routes->get('/tmstglsegment/fetchAll', 'Tmstglsegment::fetchAll', ['filter' => 'auth']);
$routes->get('/tmstglsegment/fetchSingleData', 'Tmstglsegment::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmstglsegment/fetchSingleDataPrint/(:any)', 'Tmstglsegment::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tmstglsegment/action', 'Tmstglsegment::action', ['filter' => 'auth']);
$routes->post('/tmstglsegment/datatables', 'Tmstglsegment::datatables', ['filter' => 'auth']);
$routes->post('/tmstglsegment/delete', 'Tmstglsegment::delete', ['filter' => 'auth']);
$routes->post('/tmstglsegment/checkduplicate', 'Tmstglsegment::checkDuplicate', ['filter' => 'auth']);
$routes->get('/tmstglsegment/download', 'Tmstglsegment::download');
$routes->get('/tmstglsegment/exportExcel', 'Tmstglsegment::exportExcel', ['filter' => 'auth']);
$routes->get('/tmstglsegment/exportExcel/(:any)', 'Tmstglsegment::exportExcel/$1', ['filter' => 'auth']);
$routes->get('/tmstglsegment/printData', 'Tmstglsegment::printData', ['filter' => 'auth']);
$routes->get('/tmstglsegment/printData/(:any)', 'Tmstglsegment::printData/$1', ['filter' => 'auth']);
$routes->post('/tmstglsegment/import', 'Tmstglsegment::import');
$routes->post('/tmstglsegment/upload', 'Tmstglsegment::upload');
$routes->match(['get', 'post'], '/tmstglsegment/preview', 'Tmstglsegment::preview');
$routes->match(['get', 'post'], '/tmstglsegment/uploaded', 'Tmstglsegment::uploaded');
// General Ledger (G/L) > G/L Setup | G/L Segment | Created By Rifa | 22 Desember 2025

// Administrative Services | Fiscal Calender | Fiscal Year | Created By Rifa | 08 Desember 2025
$routes->get('/tmstfiscalcalender', 'Tmstfiscalcalender::index', ['filter' => 'auth']);
$routes->get('/tmstfiscalcalender/fetchAll', 'Tmstfiscalcalender::fetchAll', ['filter' => 'auth']);
$routes->get('/tmstfiscalcalender/fetchSingleData', 'Tmstfiscalcalender::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmstfiscalcalender/fetchSingleDataPrint/(::any)', 'Tmstfiscalcalender::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tmstfiscalcalender/action', 'Tmstfiscalcalender::action', ['filter' => 'auth']);
$routes->post('/tmstfiscalcalender/datatables', 'Tmstfiscalcalender::datatables', ['filter' => 'auth']);
$routes->post('/tmstfiscalcalender/delete', 'Tmstfiscalcalender::delete', ['filter' => 'auth']);
$routes->post('/tmstfiscalcalender/checkduplicate', 'Tmstfiscalcalender::checkDuplicate', ['filter' => 'auth']);
// Administrative Services | Fiscal Calender | Fiscal Year | Created By Rifa | 08 Desember 2025

// Administrative Services | Fiscal Calender | Fiscal Calender Lock | Created By Rifa | 11 Desember 2025
$routes->get('/tmstfiscalcalenderlock', 'Tmstfiscalcalenderlock::index', ['filter' => 'auth']);
$routes->get('/tmstfiscalcalenderlock/fetchAll', 'Tmstfiscalcalenderlock::fetchAll', ['filter' => 'auth']);
$routes->get('/tmstfiscalcalenderlock/fetchSingleData', 'Tmstfiscalcalenderlock::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmstfiscalcalenderlock/fetchSingleDataPrint/(::any)', 'Tmstfiscalcalenderlock::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tmstfiscalcalenderlock/action', 'Tmstfiscalcalenderlock::action', ['filter' => 'auth']);
$routes->post('/tmstfiscalcalenderlock/datatables', 'Tmstfiscalcalenderlock::datatables', ['filter' => 'auth']);
$routes->post('/tmstfiscalcalenderlock/pivot', 'Tmstfiscalcalenderlock::pivot', ['filter' => 'auth']);
$routes->post('/tmstfiscalcalenderlock/delete', 'Tmstfiscalcalenderlock::delete', ['filter' => 'auth']);
$routes->post('/tmstfiscalcalenderlock/checkduplicate', 'Tmstfiscalcalenderlock::checkDuplicate', ['filter' => 'auth']);
$routes->post(
    '/tmstfiscalcalenderlock/update-lock',
    'Tmstfiscalcalenderlock::updateLock',
    ['filter' => 'auth']
);
// Administrative Services | Fiscal Calender | Fiscal Calender Lock | Created By Rifa | 11 Desember 2025

// General Ledger (G/L) > G/L Setup | G/L Option | Created By Rifa | 28 Oktober 2025
$routes->get('/tmstgloption', 'Tmstgloption::index', ['filter' => 'auth']);
$routes->get('/tmstgloption/fetchGlOptionPosting', 'Tmstgloption::fetchGlOptionPosting', ['filter' => 'auth']);
$routes->post('/tmstgloption/saveGlOptionPosting', 'Tmstgloption::saveGlOptionPosting', ['filter' => 'auth']);
$routes->get('/tmstgloption/fetchGlOptionSegment', 'Tmstgloption::fetchGlOptionSegment', ['filter' => 'auth']);
$routes->post('/tmstgloption/saveGlOptionSegment', 'Tmstgloption::saveGlOptionSegment', ['filter' => 'auth']);
// General Ledger (G/L) > G/L Setup | G/L Option | Created By Rifa | 28 Oktober 2025

// General Ledger (G/L) > G/L Transaction Entry | G/L Journal Entry | Created By Rifa | 07 Oktober 2025
$routes->get('/tmstgljournal', 'Tmstgljournal::index', ['filter' => 'auth']);
$routes->get('/tmstgljournal/fetchAll', 'Tmstgljournal::fetchAll', ['filter' => 'auth']);
$routes->get('/tmstgljournal/fetchSingleData', 'Tmstgljournal::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmstgljournal/fetchSingleDataPrint/(:any)', 'Tmstgljournal::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tmstgljournal/action', 'Tmstgljournal::action', ['filter' => 'auth']);
$routes->post('/tmstgljournal/updateDetail', 'Tmstgljournal::updateDetail', ['filter' => 'auth']);
$routes->post('/tmstgljournal/datatables', 'Tmstgljournal::datatables', ['filter' => 'auth']);
$routes->post('/tmstgljournal/datatablesmastercoa', 'Tmstgljournal::datatablesmastercoa', ['filter' => 'auth']);
$routes->post('/tmstgljournal/datatablesfiscalcalender', 'Tmstgljournal::datatablesfiscalcalender', ['filter' => 'auth']);
$routes->post('/tmstgljournal/datatablesbatchentry', 'Tmstgljournal::datatablesbatchentry', ['filter' => 'auth']);
$routes->post('/tmstgljournal/reverseBatchEntry', 'Tmstgljournal::reverseBatchEntry', ['filter' => 'auth']);
$routes->get('/tmstgljournal/getBatchEntry', 'Tmstgljournal::getBatchEntry', ['filter' => 'auth']);
$routes->get('/tmstgljournal/getSrceDesc', 'Tmstgljournal::getSrceDesc', ['filter' => 'auth']);
$routes->get('/tmstgljournal/checkBalance', 'Tmstgljournal::checkBalance', ['filter' => 'auth']);
$routes->get('/tmstgljournal/getSourceLedger', 'Tmstgljournal::getSourceLedger', ['filter' => 'auth']);
$routes->get('/tmstgljournal/getSourceType', 'Tmstgljournal::getSourceType', ['filter' => 'auth']);
$routes->get('/tmstgljournal/getFiscalYear', 'Tmstgljournal::getFiscalYear', ['filter' => 'auth']);
$routes->get('/tmstgljournal/getAllowImport', 'Tmstgljournal::getAllowImport', ['filter' => 'auth']);
$routes->get('/tmstgljournal/getSummaryData', 'Tmstgljournal::getSummaryData', ['filter' => 'auth']);
$routes->get('/tmstgljournal/getUpdatedSummaryData', 'Tmstgljournal::getUpdatedSummaryData', ['filter' => 'auth']);
$routes->delete('/tmstgljournal/delete/(:segment)/(:segment)/(:segment)', 'Tmstgljournal::delete/$1/$2/$3', ['filter' => 'auth']);
$routes->put('/tmstgljournal/deleteBatchEntry', 'Tmstgljournal::deleteBatchEntry', ['filter' => 'auth']);
$routes->get('/tmstgljournal/download', 'Tmstgljournal::download');
$routes->get('/tmstgljournal/export', 'Tmstgljournal::export');
$routes->post('/tmstgljournal/upload', 'Tmstgljournal::upload');
$routes->post('/tmstgljournal/previewAndValidate', 'Tmstgljournal::previewAndValidate');
$routes->post('/tmstgljournal/clearBatchEntry', 'Tmstgljournal::clearBatchEntry');
$routes->match(['get', 'post'], '/tmstgljournal/preview', 'Tmstgljournal::preview');
$routes->match(['get', 'post'], '/tmstgljournal/uploaded', 'Tmstgljournal::uploaded');
$routes->match(['get', 'post'], '/tmstgljournal/clearTempFile', 'Tmstgljournal::clearTempFile');
$routes->post('/tmstgljournal/savedata', 'Tmstgljournal::savedata', ['filter' => 'auth']);
// General Ledger (G/L) > G/L Transaction Entry | G/L Journal Entry | Created By Rifa | 07 Oktober 2025

// General Ledger (G/L) > G/L Setup | G/L Source Code | Created By Rifa | 07 Oktober 2025
$routes->get('/tmstglsourceledger', 'Tmstglsourceledger::index', ['filter' => 'auth']);
$routes->get('/tmstglsourceledger/fetchAll', 'Tmstglsourceledger::fetchAll', ['filter' => 'auth']);
$routes->get('/tmstglsourceledger/fetchSingleData', 'Tmstglsourceledger::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmstglsourceledger/fetchSingleDataPrint/(:any)', 'Tmstglsourceledger::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tmstglsourceledger/action', 'Tmstglsourceledger::action', ['filter' => 'auth']);
$routes->post('/tmstglsourceledger/datatables', 'Tmstglsourceledger::datatables', ['filter' => 'auth']);
$routes->post('/tmstglsourceledger/delete', 'Tmstglsourceledger::delete', ['filter' => 'auth']);
$routes->post('/tmstglsourceledger/checkduplicate', 'Tmstglsourceledger::checkDuplicate', ['filter' => 'auth']);
$routes->get('/tmstglsourceledger/download', 'Tmstglsourceledger::download');
$routes->post('/tmstglsourceledger/import', 'Tmstglsourceledger::import');
$routes->post('/tmstglsourceledger/upload', 'Tmstglsourceledger::upload');
$routes->get('/tmstglsourceledger/exportExcel', 'Tmstglsourceledger::exportExcel', ['filter' => 'auth']);
$routes->get('/tmstglsourceledger/exportExcel/(:any)', 'Tmstglsourceledger::exportExcel/$1', ['filter' => 'auth']);
$routes->get('/tmstglsourceledger/printData', 'Tmstglsourceledger::printData', ['filter' => 'auth']);
$routes->get('/tmstglsourceledger/printData/(:any)', 'Tmstglsourceledger::printData/$1', ['filter' => 'auth']);
$routes->match(['get', 'post'], '/tmstglsourceledger/preview', 'Tmstglsourceledger::preview');
$routes->match(['get', 'post'], '/tmstglsourceledger/uploaded', 'Tmstglsourceledger::uploaded');
// General Ledger (G/L) > G/L Setup | G/L Source Code | Created By Rifa | 07 Oktober 2025

// General Ledger (G/L) > G/L Transaction Entry | G/L Batch Entry | Created By Rifa | 07 Oktober 2025
$routes->get('/tmstglbatchlist', 'Tmstglbatchlist::index', ['filter' => 'auth']);
$routes->post('/tmstglbatchlist', 'Tmstglbatchlist::index');
$routes->get('/tmstglbatchlist/fetchAll', 'Tmstglbatchlist::fetchAll', ['filter' => 'auth']);
$routes->get('/tmstglbatchlist/fetchSingleData', 'Tmstglbatchlist::fetchSingleData', ['filter' => 'auth']);
$routes->get('/tmstglbatchlist/fetchSingleDataPrint/(:any)', 'Tmstglbatchlist::fetchSingleDataPrint/$1', ['filter' => 'auth']);
$routes->post('/tmstglbatchlist/action', 'Tmstglbatchlist::action', ['filter' => 'auth']);
$routes->post('/tmstglbatchlist/datatables', 'Tmstglbatchlist::datatables', ['filter' => 'auth']);
$routes->post('/tmstglbatchlist/delete', 'Tmstglbatchlist::delete', ['filter' => 'auth']);
$routes->get('/tmstglbatchlist/download', 'Tmstglbatchlist::download');
$routes->post('/tmstglbatchlist/upload', 'Tmstglbatchlist::upload');
$routes->post('/tmstglbatchlist/updateBatch', 'Tmstglbatchlist::updateBatch', ['filter' => 'auth']);
$routes->post('/tmstglbatchlist/PostBatch', 'Tmstglbatchlist::PostBatch');
$routes->match(['get', 'post'], '/tmstglbatchlist/preview', 'Tmstglbatchlist::preview');
$routes->match(['get', 'post'], '/tmstglbatchlist/uploaded', 'Tmstglbatchlist::uploaded');
// General Ledger (G/L) > G/L Transaction Entry | G/L Batch Entry | Created By Rifa | 07 Oktober 2025

// ------------------------------------ End Routes Rifaaa ------------------------------------


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
