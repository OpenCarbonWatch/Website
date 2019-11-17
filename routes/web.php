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
    Route::get('/france/regions-departments', 'HomeController@franceRegionsDepartments')->name('france-regions-departments');
});
