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

    Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'ViewController@getDashboard']);
    Route::get('mapper', ['as' => 'mapper', 'uses' => 'ViewController@getMapper']);
    Route::get('manage', ['as' => 'manage', 'before' => 'manage_check', 'uses' => 'ViewController@getManage']);
    Route::get('logout', ['as' => 'logout', 'uses' => 'AuthController@getLogout']);

});

Route::group(['before' => 'sentry_check|project_check'], function() {

    Route::get('project/{project_id}', ['uses' => 'ViewController@getProject']);
    Route::get('project/{project_id}/{project_type}', ['uses' => 'ViewController@getProjectType']);
    Route::get('project/{project_id}/{project_type}/edit', ['uses' => 'ViewController@getProjectTypeEdit']);
    Route::get('project/{project_id}/{project_type}/delete', ['uses' => 'ProjectController@deleteProjectType']);

});

Route::group(['before' => 'sentry_check|csrf'], function() {

  Route::post('dashboard', ['uses' => 'ProjectController@createProject']);
  Route::post('project/{project_id}', ['uses' => 'ProjectController@postProject']);
  Route::post('project/{project_id}/{project_type}', ['uses' => 'ProjectController@postProjectType']);
  Route::post('project/{project_id}/{project_type}/edit', ['uses' => 'ProjectController@postProjectTypeEdit']);
  Route::post('project/{project_id}/{project_type}/bulk', ['uses' => 'ProjectController@postProjectTypeBulk']);

  Route::post('manage/ban', ['before' => 'manage_check', 'uses' => 'ManageController@banUsers']);

});

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::get('api/missing', ['as' => 'api.missing', 'uses' => 'APIController@getAPIMissing']);
Route::get('api/{project_name}/{project_type}', ['uses' => 'APIController@getProjectTypeData']);