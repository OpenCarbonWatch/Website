<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect']
], function () {
    // Localized routes
    Route::get('/', 'HomeController@home')->name('home');
    Route::get('/france', 'HomeController@france')->name('france');
    Route::get('/france/organizations/{id}', 'HomeController@franceOrganization')->name('france-organization');
    Route::get('/france/regions-departments', 'HomeController@franceRegionsDepartments')->name('france-regions-departments');
    Route::get('/france/cities', 'HomeController@franceCities')->name('france-cities');
    Route::get('/france/city-groups', 'HomeController@franceCityGroups')->name('france-city-groups');
    Route::get('/france/state', 'HomeController@franceState')->name('france-state');
    Route::get('/france/other-public', 'HomeController@franceOtherPublic')->name('france-other-public');
    Route::get('/france/companies', 'HomeController@franceCompanies')->name('france-companies');
    Route::get('/france/specialized-private', 'HomeController@franceSpecializedPrivate')->name('france-specialized-private');
    Route::get('/france/associations', 'HomeController@franceAssociations')->name('france-associations');
});
