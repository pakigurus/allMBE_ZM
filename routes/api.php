<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user()->load('userProfile');
});
//Iqamah Routes
Route::get('/iqamah', 'Rest\IqamahController@getIqamah');
Route::post('/iqamah', 'Rest\IqamahController@addIqamah');
Route::get('/single-iqamah', 'Rest\IqamahController@singleMasajidIqamah');

//skills Routes
Route::resource('/skills', 'Rest\SkillsController');
Route::get('interest', 'Rest\SkillsController@interestIndex');



//R4Dua
Route::resource('/req-for-dua', 'Rest\ReqForDuaController');


//utilities route
Route::get('/wfdays', 'Rest\UtilController@getWFDays');


//Route Contribute
Route::resource('/contribute-with-time', 'Rest\ContributeWithTimeController');
Route::resource('/contribute-with-skills', 'Rest\ContributeWithSkillsController');


//Route that have both access user and guests

Route::post('/add-masajid', 'Rest\MasajidController@store');
Route::get('/google-masajid/{id}', 'Rest\MasajidController@GoogleShow');

Route::get('/near-by-masajids', 'Rest\MasajidController@nearByMasajids');
Route::get('/near-by-non-masajids', 'Rest\MasajidController@nearByNonMasajids');

Route::post('/near-by-events', 'Rest\EventController@nearByEvents');
Route::post('/near-by-announcements', 'Rest\AnnouncementController@nearByAnnouncements');

Route::resource('/events', 'Rest\EventController');
Route::resource('/announcement', 'Rest\AnnouncementController');
Route::resource('/faq', 'Rest\FaqController');
Route::resource('/feedback', 'Rest\FeedbackController');

//get data by googleid
Route::get('/announcement-google/{id}', 'Rest\AnnouncementController@getByMasajidId');
Route::get('/event-google/{id}', 'Rest\EventController@getByMasajidId');


//dua routes
Route::resource('/dua',  'Rest\DuaController');
Route::get('/dua-type/{id}', 'Rest\DuaController@duaType');
Route::get('/dua-sub-type/{id}', 'Rest\DuaController@duaSubType');


Route::post('/dua-import', 'Web\DuaController@importDua');



//login routes
Route::post('/login', 'Rest\AuthController@login');
Route::post('/register', 'Rest\AuthController@register');
Route::post('/forgot-password', 'Rest\AuthController@forgotPassword');
Route::get('/masajid/{id}', 'Rest\MasajidController@show');


Route::middleware('auth:api')->group(function(){
    Route::post('/logout', 'Rest\AuthController@logout');

    //Masajid Crud route
    Route::resource('/masajid', 'Rest\MasajidController');

    //User Profile Route
    Route::resource('/user',  'Rest\UserProfileController');
    Route::post('/user/upload-image', 'Rest\UserProfileController@uploadImage');
    Route::get('/verify', 'Rest\UserProfileController@verify');
    Route::get('/verify-code/{type}', 'Rest\UserProfileController@verifyCode');
    Route::post('/verify-code-otp', 'Rest\UserProfileController@verifyCodeOTP');
    Route::put('/update-password', 'Rest\UserProfileController@updatePassword');

    //Dua Routes
    Route::get('/make-fav-dua/{id}', 'Rest\DuaController@addToFav');
    Route::delete('/remove-fav-dua/{id}', 'Rest\DuaController@removeFromFav');
    Route::get('/fav-dua', 'Rest\DuaController@favDuaList');

    //events
    Route::get('/user-fav-events', 'Rest\EventController@favEvents');
    Route::get('/events/add-to-fav/{id}', 'Rest\EventController@addToFav');
    Route::delete('/events/remove-to-fav/{id}', 'Rest\EventController@removeFromFav');


    Route::get('/user-events', 'Rest\EventController@userEvents');
    Route::get('/user-events/{id}', 'Rest\EventController@userSingleEvents');
    Route::put('/user-events/reschedule/{id}', 'Rest\EventController@RescheduleEvent');
    Route::delete('/user-events/{id}', 'Rest\EventController@destroy');


    //Announcement

    Route::get('/user-announcements', 'Rest\AnnouncementController@userAnnouncements');
    Route::get('/user-announcements/{id}', 'Rest\AnnouncementController@userSingleAnnouncements');
    Route::delete('/user-announcements/{id}', 'Rest\AnnouncementController@destroy');


    Route::get('/announcements/add-to-fav/{id}', 'Rest\AnnouncementController@addToFav');
    Route::get('/user-fav-announcements', 'Rest\AnnouncementController@favAnnouncements');
    Route::delete('/announcements/remove-to-fav/{id}', 'Rest\AnnouncementController@removeFromFav');


    Route::get('/user-dualist', 'Rest\ReqForDuaController@userDuaList');
    Route::get('/user-dua/{id}', 'Rest\ReqForDuaController@userDua');
    Route::put('/user-dua/{id}', 'Rest\ReqForDuaController@userDuaEdit');
    Route::put('/user-dua-extend/{id}', 'Rest\ReqForDuaController@userDuaExtend');


    Route::get('user-non-events', 'Rest\NonEventController@userNonEvents');
    Route::get('user-non-announcements', 'Rest\NonAnnouncementController@userNonAnnouncements');
});


//settings route
Route::get('settings/about-us', 'Rest\SettingsController@aboutUs');
Route::resource('settings', 'Rest\SettingsController');


//islamic calendar
Route::get('islamic-calendar', 'Rest\IslamicCalendarController@getIslamicMonthCalendar');
//this is to add holidays in list
Route::get('islamic-holidays-adding-file', 'Rest\IslamicCalendarController@islamicHolidaysAddingFile');
Route::get('islamic-holidays', 'Rest\IslamicCalendarController@islamicHolidays');
Route::get('islamic-calendar-prayer-timing', 'Rest\IslamicCalendarController@prayerTimingOnDate');


Route::get('modules', 'Rest\IntroductionScreensController@modules');
Route::get('intro-screen/{module_name}', 'Rest\IntroductionScreensController@index');

Route::post('feed-a-need', 'Rest\FeedANeedController@store');

Route::resource('non-events', 'Rest\NonEventController');
Route::resource('non-announcements', 'Rest\NonAnnouncementController');
