<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth/login');
})->name('admin.login');

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
Auth::routes();

Route::prefix('admin')->middleware('AdminPanelRoutes')->group(function () {
Route::get('/utils', 'Web\QrCodeController@updateMasajidPlaceData');
Route::get('/generate', 'Web\QrCodeController@generateKey');

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('/masajid', 'Web\MasajidController');
Route::get('/report-masajid/{id}', 'Web\MasajidController@report');
Route::get('/feed-a-need-masajid/{id}', 'Web\MasajidController@feedANeed');
Route::get('/masajid-map-view', 'Web\MasajidController@mapsView');

Route::resource('/dua', 'Web\MasajidController');
Route::post('/dua-import', 'Web\DuaController@importDua');

//events
Route::post('/approve-event/{id}', 'Web\EventsController@approveEvent');
Route::resource('/events', 'Web\EventsController');
//announcements
Route::post('/approve-announcement/{id}', 'Web\AnnouncementController@approveAnnouncement');
Route::resource('/announcement', 'Web\AnnouncementController');
//Dua
Route::resource('/dua', 'Web\DuaController');
Route::post('/dua/add-dua', 'Web\DuaController@addDua');
Route::resource('/dua-sub-type', 'Web\DuaSubTypesController');
Route::post('/import-dua', 'Web\DuaController@importDua');
Route::get('/dua-sample-download', 'Web\DuaController@sampleDownload');

//FAQ
Route::resource('/faq', 'Web\FaqController');



//User Management
Route::post('/is-masajid-user/{id}', 'Web\UserController@isMasajidUser');
Route::get('/assign-masajids', 'Web\UserController@assignMasajid');
Route::get('/get-masajids/{id}', 'Web\UserController@getMasajids')->name('get-masajids');
Route::post('/un-assign-masajid', 'Web\UserController@unAssignMasajids');
Route::post('/assign-masajid', 'Web\UserController@assignMasajidToUser');
Route::resource('/user', 'Web\UserController');
Route::get('/app-user', 'Web\UserController@appUser');
Route::get('/user-verify', 'Web\UserController@verifyBackendUser');

//role management
Route::resource('/permission', 'Web\PermissionsController');
Route::resource('/role', 'Web\RolesController');
Route::resource('/assign-permission-to-role', 'Web\AssignPermissionsToRolesController');
Route::post('/select-ajax', 'Web\AssignPermissionsToRolesController@getAllPermissions')->name('select-ajax');

//assign role to user
Route::resource('assign-role', 'Web\AssignRoleController');
Route::post('assign-role-to-user', 'Web\AssignRoleController@assignRoleToUser');
Route::post('un-assign-role', 'Web\AssignRoleController@unAssignRole');

Route::get('qr-code', 'Web\QrCodeController@view');
Route::post('qr-code/generate', 'Web\QrCodeController@generate');
Route::get('qr-code/download', 'Web\QrCodeController@download');

//csv exporter
Route::get('csv-export/{param}', 'Web\CSVExportController@csvExport');


//skills
Route::resource('skills', 'Web\SkillsController');
Route::resource('settings', 'Web\SettingsController');
Route::post('settings/add-about-us', 'Web\SettingsController@addAboutUS');
Route::post('settings/add-terms-and-conditions', 'Web\SettingsController@addTermsAndConditions');


//Route Contribute
Route::resource('/contribute-with-time', 'Web\ContributeWithTimeController');
Route::resource('/contribute-with-skills', 'Web\ContributeWithSkillsController');

// Feedback View
Route::resource('/feedback', 'Rest\FeedbackController');


//RForDua
Route::get('dua-appeal/delete/{id}', 'Web\ReqForDuaController@destroy');

Route::resource('dua-appeal', 'Web\ReqForDuaController');
Route::resource('/iqamah', 'Web\IqamahController');
Route::post('/iqamah/view', 'Web\IqamahController@Masajid');
Route::post('/iqamah/delete-all/{id}', 'Web\IqamahController@deleteAddRecord');

});

//modules verification
Route::get('verify-modules/{module}/{id}', 'Web\VerifyModulesController@verifyModules');


//User app webview pages
Route::get('about-us', 'Web\SettingsController@showAboutUs');
Route::get('terms-and-conditions', 'Web\SettingsController@showTermsAndConditions');


//Web Routes
Route::group(['prefix' => 'app', 'namespace' => 'App'], function () {
    Route::get('/', 'DashboardController@index')->name('user.dashboard');
});
