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
  $deny      = true;
  $user      = Sentry::getUser();
  $projectID = $route->getParameter('project_id');
  $project   = Project::where('id', $projectID)->with('access')->first();
  foreach($project->access as $access) {
    if($access->project_id === (int) $projectID) {
      $deny = false;
      break;
    }
  }
  if(!$user->hasAnyAccess(['manage']) && $user->id !== $project->user_id && $deny) {
    return Redirect::to('404');
  }
});

Route::filter('manage_check', function() {
  if(!Sentry::getUser()->hasAnyAccess(['manage'])) {
    return Redirect::to('404');
  }
});

Route::filter('edit_check', function($route) {
  $user      = Sentry::getUser();
  $projectID = $route->getParameter('project_id');
  $project   = Project::where('id', $projectID)->where('user_id', $user->id)->first();
  if(!Sentry::getUser()->hasAnyAccess(['manage']) && null === $project) {
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
