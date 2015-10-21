<?php

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

/**
 * Checks if a user is authed
 *
 * @return void || redirect
 */
Route::filter('sentry_check', function() {
  if (!Sentry::check()) return Redirect::to('/');
});

/**
 * Checks if a user is an admin
 *
 * @return void || redirect
 */
Route::filter('manage_check', function() {
  if (!Sentry::getUser()->hasAnyAccess(['manage'])) {
    return Redirect::to('404');
  }
});

/**
 * Checks if a user can access a project
 *
 * @return void || redirect
 */
Route::filter('project_check', function($route) {
  $project_id = $route->getParameter('project_id');
  $user       = Sentry::getUser();
  $project    = Project::where('id', $project_id)->first();
  $access     = ProjectAccess::where('project_id', $project_id)->where('user_id', $user->id)->first();

  if($user->is_admin || $project->is_owner || $access !== null) {
    return;
  }

  return Redirect::to('404');
});

/**
 * Checks if a user can edit a project
 *
 * @return void || redirect
 */
Route::filter('edit_check', function($route) {
  $project_id = $route->getParameter('project_id');
  $user       = Sentry::getUser();
  $project    = Project::where('id', $project_id)->first();
  $access     = ProjectAccess::where('project_id', $project_id)->where('user_id', $user->id)->first();

  if($user->is_admin || $project->is_owner || $access !== null) {
    return;
  }

  return Redirect::to('404');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

/**
 * Filters standard HTTP POST requests
 *
 * @return void
 */
Route::filter('csrf', function() {
  if (Session::token() !== Input::get('_token')) {
    throw new Illuminate\Session\TokenMismatchException;
  }
});

/**
 * Filters AJAX POST requests
 *
 * @return void
 */
Route::filter('csrf_ajax', function() {
  if (Session::token() != Request::header('x-csrf-token')) {
    throw new Illuminate\Session\TokenMismatchException;
  }
});
