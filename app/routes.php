<?php

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::get('/', ['as' => 'default', 'uses' => 'AuthController@getDefault']);
Route::post('/', ['before' => 'csrf', 'uses' => 'AuthController@postLogin']);

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/

Route::group(['before' => 'sentry_check'], function() {

    Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@getDashboard']);
    Route::get('mapper', ['as' => 'mapper', 'uses' => 'DashboardController@getMapper']);
    Route::get('logout', ['as' => 'logout', 'uses' => 'AuthController@getLogout']);

});
