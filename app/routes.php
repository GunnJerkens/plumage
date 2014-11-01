<?php

/*
|--------------------------------------------------------------------------
| 404 Routes
|--------------------------------------------------------------------------
*/

App::missing(function($exception) {
  return Response::view('layouts.error', array(), 404);
});

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
    Route::get('project/{project_id}', ['uses' => 'DashboardController@getProject']);
    Route::get('project/{project_id}/{project_type}', ['uses' => 'DashboardController@getProjectType']);
    Route::get('project/{project_id}/{project_type}/edit', ['uses' => 'DashboardController@getProjectTypeEdit']);
    Route::get('project/{project_id}/{project_type}/delete', ['uses' => 'ProjectController@postProjectDelete']);
    Route::get('mapper', ['as' => 'mapper', 'uses' => 'DashboardController@getMapper']);
    Route::get('logout', ['as' => 'logout', 'uses' => 'AuthController@getLogout']);


    // Route::get('project/{project_id}/{project_type}/edit', ['uses' => 'DashboardController@getProjectTypeEdit']);



});

Route::group(['before' => 'sentry_check|csrf'], function() {


  Route::post('project/{project_id}', ['uses' => 'ProjectController@postProject']);
  Route::post('project/{project_id}/{project_type}/edit', ['uses' => 'ProjectController@postProjectTypeEdit']);

});

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::get('api/{project_name}/{project_type}', ['uses' => 'APIController@getProjectType']);