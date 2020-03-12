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
    // Texts
    Route::get('/texts/about', 'TextsController@showAbout')->name('texts-about');
    Route::get('/texts/context', 'TextsController@showContext')->name('texts-context');
    Route::get('/texts/what-we-do', 'TextsController@showWhatWeDo')->name('texts-what-we-do');
    Route::get('/texts/how-to-help', 'TextsController@showHowToHelp')->name('texts-how-to-help');
    // France data
    Route::get('/france', 'HomeController@france')->name('france');
    Route::get('/france/search', 'HomeController@franceSearch')->name('france-search');
    Route::post('/france/search', 'HomeController@franceBuildSearchObject')->name('france-search-build');
    Route::get('/france/search/{search}', 'HomeController@franceViewSearchResults')->name('france-search-results');
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

Route::group([], function() {
    Route::get('/france/search/data/activity/{query}', 'SearchController@franceSearchDataActivity')->name('france-search-data-activity');
    Route::get('/france/search/data/geography/{query}', 'SearchController@franceSearchDataGeography')->name('france-search-data-geography');
});
