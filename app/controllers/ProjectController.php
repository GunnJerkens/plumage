<?php

class ProjectController extends Controller {

  /**
   * Private class vars
   *
   * @var $input array
   */
  protected $input, $user;

  /**
   * Class constructor
   *
   * @return void
   */
  function __construct() {
    $this->input = Input::except('_token');
    $this->user  = Sentry::getUser();
  }

  /**
   * Handles POST requests for /dashboard
   *
   * @return redirect
   */
  public function createProject() {
    $response = $this->checkNaming($this->input['project_name']);
    if(!$response) {
      $response = Project::createNewProject($this->user->id, $this->input['project_name']);
    }
    return Redirect::back()->with($response);
  }

  /**
   * Handles POST requests for /project/{project_id}
   *
   * @return redirect
   */
  public function postProject($project_id) {
    $input = Input::except('_token');
    if(!preg_match('/^[a-z]+$/', $input['table_name'])) {
      $response = [
        'error'     => true,
        'message'   => 'Alpha lowercase characters only',
        'type_data' => $input['table_name']
      ];
    } else {
      $response = ProjectType::createTypesGroup($project_id, $input);
    }
    return Redirect::back()->with($response);
  }

  /**
   * Handles POST requests for /project/{project_id}/{project_type}
   *
   * @param int, string
   *
   * @return redirect
   */
  public function postProjectType($project_id, $project_type) {
    $projectType = ProjectType::where('project_id', $project_id)->where('type', $project_type)->first();
    $input       = Input::except('_token');
    foreach($input as $data) {
      $response    = ProjectType::createTypesData($projectType->table_name, $data);
    }
    return Redirect::back()->with($response);
  }

  /**
   * Handles POST requests for /project/{project_id}/{project_type}/edit
   *
   * @param int, string
   *
   * @return redirect
   */
  public function postProjectTypeEdit($project_id, $project_type) {
    $response = ProjectType::addTypesFields($project_id, $project_type, Input::except('_token'));
    return Redirect::back()->with($response);
  }

  /**
   * Handles GET requests for /project/{project_id}/{project_type}/delete
   *
   * @return redirect
   */
  public function deleteProjectType($project_id, $project_type) {
    $response = ProjectType::deleteTypesGroup($project_id, $project_type);
    return Redirect::back()->with($response);
  }

  /**
   * Make sure a project is all lowercase, no special chars
   *
   * @param $string
   *
   * @return array|false
   */
  private function checkNaming($string) {
    if(!preg_match('/^[a-z]+$/', $string)) {
      $response = ['error' => true, 'message' => 'Alpha lowercase characters only' ];
    } else {
      $response = false;
    }
    return $response;
  }

}
