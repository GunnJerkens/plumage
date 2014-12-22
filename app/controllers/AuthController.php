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
    return View::make('layouts.default');
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
        'email'    => $input['email'],
        'password' => $input['password'],
      ];
      $user = Sentry::authenticate($credentials, true);
      $response['error'] = false;
    }
    catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
      $response['message'] = 'Login field is required.';
    }
    catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
      $response['message'] = 'Password field is required.';
    }
    catch (Cartalyst\Sentry\Users\WrongPasswordException $e) {
      $response['message'] = 'Wrong password, try again.';
    }
    catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
      $response['message'] = 'User was not found.';
    }
    catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {
      $response['message'] = 'User is not activated.';
    }

    catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
      $response['message'] = 'User is suspended.';
    }
    catch (Cartalyst\Sentry\Throttling\UserBannedException $e) {
      $response['message'] = 'User is banned.';
    }
    finally {
      if($response['error']) {
        return Redirect::back()->with($response);
      } else {
        return Redirect::to('dashboard');
      }
    }
  }

  /**
   * Handles GET request from /logout
   *
   * @return redirect
   */
  public function getLogout()
  {
    Sentry::logout();
    return Redirect::to('/');
  }

}
