<?php

class AuthController extends Controller {

  /**
   * Handles GET requests from /
   *
   * @return view
   */
  public function getDefault() {
    return View::make('layouts.default');
  }

  /**
   * Handles POST requests from /
   *
   * @return redirect
   */
  public function postLogin() {
    $input = Input::except('_token');
    try {
      $credentials = [
        'email'    => $input['email'],
        'password' => $input['password'],
      ];
      $user = Sentry::authenticate($credentials, true);
      return Redirect::to('dashboard');
    }
    catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
      echo 'Login field is required.';
    }
    catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
        echo 'Password field is required.';
    }
    catch (Cartalyst\Sentry\Users\WrongPasswordException $e) {
        echo 'Wrong password, try again.';
    }
    catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
        echo 'User was not found.';
    }
    catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {
        echo 'User is not activated.';
    }

    catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
        echo 'User is suspended.';
    }
    catch (Cartalyst\Sentry\Throttling\UserBannedException $e) {
        echo 'User is banned.';
    }
  }

  /**
   * Handles GET request from /logout
   *
   * @return redirect
   */
  public function getLogout() {
    Sentry::logout();
    return Redirect::to('/');
  }

}
