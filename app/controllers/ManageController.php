<?php

class ManageController extends Controller
{

  /**
   * Class variables
   *
   * @var $input|array
   * @var $user|object
   */
  protected $input, $user;

  /**
   * Class constructor function
   *
   */
  function __construct()
  {
    $this->input = Input::except('token');
  }

  /**
   * Handles POST requests for /manage/delete
   *
   * @return redirect
   */
  public function deleteUser()
  {
    $user     = User::where('id', $this->input['user_id'])->first();
    $response = ['error' => true, 'message' => 'User not found.'];
    if($user) {
      DB::table('projects_access')->where('user_id', $user->id)->delete();
      DB::table('throttle')->where('user_id', $user->id)->delete();
      DB::table('users_groups')->where('user_id', $user->id)->delete();
      $user->delete();
      $response = ['error' => false, 'message' => 'User has been deleted.'];
    }
    return Redirect::back()->with($response);
  }

  /**
   * Handles POST requests for /manage/create
   *
   * @return redirect
   */
  public function createUser()
  {
    $newUser = Sentry::createUser([
      'email'      => $this->input['email'],
      'password'   => $this->input['password'],
      'activated'  => true
    ]);
    $group = Sentry::findGroupByName($this->input['group']);
    $newUser->addGroup($group);
    return Redirect::back()->with(['error' => false, 'message' => 'User created successfully.']);
  }

  /**
   * Deliver timely email notification to a new user with their email and password
   *
   * @return void
   */
  private function emailNewUserCreds()
  {
    $data = $this->input;
    Mail::send('emails.welcome', $data, function($message) use ($data) {
      $message->to($data['email'])->subject('Plumage Account Created');
    });
  }

}
