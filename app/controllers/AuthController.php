<?php

class AuthController extends Controller
{

  /**
   * Handles GET requests from /
   *
   * @return view
   */
  public function getDefault()
  {
    if(Sentry::check()) {
      return Redirect::to('dashboard');
    }

    return View::make('layouts.auth');
  }

  /**
   * Handles POST requests from /
   *
   * @return redirect
   */
  public function postLogin()
  {
    $input = Input::except('_token');
    $response['error'] = true;
    try {
      $credentials = [
        'email'    => isset($input['email']) ? $input['email'] : '',
        'password' => isset($input['password']) ? $input['password'] : '',
      ];
      $user = Sentry::authenticate($credentials, true);
      $response['error'] = false;
    }
    catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
      $response['message'] = Lang::get('auth.username');
    }
    catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
      $response['message'] = Lang::get('auth.password');
    }
    catch (Cartalyst\Sentry\Users\WrongPasswordException $e) {
      $response['message'] = Lang::get('auth.password');
    }
    catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
      $response['message'] = Lang::get('auth.not_found');
    }
    catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {
      $response['message'] = Lang::get('auth.deactivated');
    }
    catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
      $response['message'] = Lang::get('auth.suspended');
    }
    catch (Cartalyst\Sentry\Throttling\UserBannedException $e) {
      $response['message'] = Lang::get('auth.banned');
    }
    finally {
      if($response['error']) {
        return Redirect::back()->with($response);
      }

      return Redirect::to('dashboard');
    }
  }

  /**
   * Handles GET requests from /logout
   *
   * @return redirect
   */
  public function getLogout()
  {
    Sentry::logout();
    return Redirect::to('/');
  }

}
