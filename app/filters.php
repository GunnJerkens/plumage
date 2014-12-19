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

Route::filter('sentry_check', function() {
  if (!Sentry::check()) return Redirect::to('/');
});

Route::filter('project_check', function($route) {
  $user       = Sentry::getUser();
  $project_id = $route->getParameter('project_id');
  $project    = Project::where('user_id', $user->id)->where('id', $project_id)->first();
  $access     = ProjectAccess::where('project_id', $project_id)->where('user_id', $user->id)->get();
  if(null === $project && null === $access) {
    return Redirect::to('404');
  }
});

Route::filter('manage_check', function() {
  if(!Sentry::getUser()->hasAnyAccess(['manage'])) {
    return Redirect::to('404');
  }
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

Route::filter('csrf', function() {
  if (Session::token() !== Input::get('_token')) {
    throw new Illuminate\Session\TokenMismatchException;
  }
});
