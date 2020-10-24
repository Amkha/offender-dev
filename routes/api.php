<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::patch('settings/password', 'Settings\PasswordController@update');
    
//------------------------------------------------------------------------------amkha----------------------------------------
    Route::apiResources(['users' => 'API\UsermanageController']);
    Route::get('users', 'API\UsermanageController@index');
    Route::post('users', 'API\UsermanageController@store');
    Route::put('users', 'API\UsermanageController@update');
    Route::delete('users', 'API\UsermanageController@destroy');

    Route::apiResources(['offender' => 'API\OffenderController']);
    Route::get('findOffender', 'API\OffenderController@search');
    Route::put('offender', 'API\OffenderController@update');
    Route::post('offender', 'API\OffenderController@store');
    Route::delete('offender', 'API\OffenderController@destroy');
    Route::get('getAlloffenders', 'API\OffenderController@getAlloffenders');

    Route::apiResources(['nationality' => 'API\NationalityController']);
    //ManagementunitController getBusinesses
    Route::get('getProvinces', 'API\ManagementunitController@getProvinces');
    Route::get('getDistricts', 'API\ManagementunitController@getDistricts');
    Route::get('getVillages', 'API\ManagementunitController@getVillages');
    Route::get('loadDistricts', 'API\ManagementunitController@loadDistricts');
    Route::get('loadVillages', 'API\ManagementunitController@loadVillages');
    Route::get('getBusinesses', 'API\ManagementunitController@getBusinesses');
    Route::get('getNetworks', 'API\ManagementunitController@getNetworks');

    Route::apiResources(['mcase' => 'API\MCaseController']);
    Route::get('getCaseTypes', 'API\MCaseController@getCaseTypes');
    Route::get('getUnits', 'API\MCaseController@getUnits');
    Route::get('getCaseStatus', 'API\MCaseController@getCaseStatus');
    Route::put('mcase', 'API\MCaseController@update');
    Route::post('mcase', 'API\MCaseController@store');
    Route::delete('mcase', 'API\MCaseController@destroy');
    Route::get('getAllCases', 'API\MCaseController@getAllCases');
    Route::get('getCases', 'API\MCaseController@getCases');

    Route::apiResources(['business' => 'API\BusinessController']);
    Route::get('findBusiness', 'API\BusinessController@search');
    Route::get('getCountries', 'API\BusinessController@getCountries');
    Route::put('business', 'API\BusinessController@update');
    Route::post('business', 'API\BusinessController@store');
    Route::delete('business', 'API\BusinessController@delete');
    Route::get('getAllBusinesses', 'API\BusinessController@getAllBusinesses');
    Route::get('getBusinesses/{id}', 'API\BusinessController@getBusinesses');

    Route::apiResources(['network' => 'API\NetworkController']);
    Route::get('findNetwork', 'API\NetworkController@search');
    Route::put('network', 'API\NetworkController@update');
    Route::post('network', 'API\NetworkController@store');
    Route::delete('network', 'API\NetworkController@destroy');
    Route::get('getNetworktypes', 'API\NetworkController@getNetworktypes');
    Route::get('getNetworkCrimelevels', 'API\NetworkController@getNetworkCrimelevels');
    Route::get('getNetworkTrafficking', 'API\NetworkController@getNetworkTrafficking');
    Route::get('getNetworks/{id}', 'API\NetworkController@getNetworks');

});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});
