<?php

class AccountController extends BaseController
{

  /**
   * Class vars
   *
   * @var $formPart string
   */
  private $formPart;

  /**
   * Class constructor function
   *
   */
  function __construct()
  {
    parent::__construct();
    $this->formPart = Input::get('form_part');
  }

  /**
   * Handles POST requests for /account
   *
   * @return redirect
   */
  public function postAccount()
  {
    $response = ['error' => false, 'message' => 'Update something.'];
    switch ($this->formPart) {
      case 'email':
        $response = $this->updateUserEmail();
        break;
      case 'password':
        $response = $this->updateUserPassword();
        break;
    }
    return Redirect::back()->with($response);
  }

  /**
   * Validates and updates the user's email
   *
   * @return array
   */
  private function updateUserEmail()
  {
    $rules = [
      'email_new'     => 'required|email',
      'email_confirm' => 'required|same:email_new|email'
    ];
    $validator = Validator::make($this->input, $rules);
    if ($validator->fails()) {
      $response = ['error' => true, 'message' => 'New email and confirm email must match.']; // temp message
    } else {
      $this->user->email = Input::get('email_new');
      $this->user->save();
      $response = ['error' => false, 'message' => 'Email updated.'];
    }
    return $response;
  }

  /**
   * Validates and updates the user's password
   *
   * @return array
   */
  private function updateUserPassword()
  {
    if (!Hash::check(Input::get('password_old'), $this->user->password)) {
      $response = ['error' => true, 'message' => 'Password invalid.'];
    } else {
      $rules = [
        'password_new'     => 'required',
        'password_confirm' => 'required|same:password_new'
      ];
      $validator = Validator::make($this->input, $rules);
      if ($validator->fails()) {
        $response = ['error' => true, 'message' => 'New password and confirm password must match.']; // temp message
      } else {
        $this->user->password = Input::get('password_new');
        $this->user->save();
        $response = ['error' => false, 'message' => 'Password updated.'];
      }
    }
    return $response;
  }

}
