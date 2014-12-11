<?php

class ManageController extends Controller {

  /**
   * Class variables
   *
   * @var $input|array
   * @var $user|object
   */
  protected $input, $user;

  /**
   *
   *
   *
   */
  function __construct() {
    $this->input = Input::except('token');
  }

  /**
   * Handles POST requests for /manage/ban
   *
   * @return redirect
   */
  public function banUsers() {
    $throttle = Sentry::findThrottlerByUserId($this->input['user_id']);
    if ($throttle->isBanned()) {
      $throttle->unBan();
      $response = ['error' => false, 'message' => 'User has been unbanned.'];
    } else {
      $throttle->ban();
      $response = ['error' => false, 'message' => 'User has been banned.'];
    }
    return Redirect::back()->with($response);
  }


}