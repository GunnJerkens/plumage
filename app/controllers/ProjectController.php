<?php

class ProjectController extends Controller {

  /**
   * Private class vars
   *
   * @var $input array
   * @var $user object
   * @var $projectID int
   * @var $projectType object
   */
  protected $input, $user, $projectID, $projectType;

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
    if(!$this->checkNaming($this->input['project_name'])) {
      Project::create([
        'user_id'   => $this->user->id,
        'name'      => $this->input['project_name'],
        'is_active' => true
      ]);
    }
    return Redirect::back()->with(['error' => false, 'message' => 'Created new project successfully.']);
  }

  /**
   * Handles POST requests for /project/{project_id}
   *
   * @return redirect
   */
  public function postProject($project_id) {
    $response = $this->checkNaming($this->input['table_name']);
    if(!$response) {
      $response = ProjectType::createTypesGroup($project_id, $this->input);
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
    foreach($this->input as $data) {
      $response    = ProjectType::createTypesData($projectType->table_name, $data);
      if($response['error'] === true) {
        break;
      }
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
    if(true === ($response = $this->checkEmpty())) {
      $response = ProjectType::addTypesFields($project_id, $project_type, $this->input);
    }
    return Redirect::back()->with($response);
  }

  public function postProjectTypeBulk($project_id, $project_type) {
    $json        = json_decode($this->input['json_data']);
    $projectType = ProjectType::where('project_id', $project_id)->where('type', $project_type)->first();
    if($json) {
      foreach($json as $data) {
        $data->id = null;
        $response    = ProjectType::createTypesData($projectType->table_name, (array) $data);
        if($response['error'] === true) {
          break;
        }
      }
    } else {
      $response = ['error' => true, 'message' => 'Malformed json data.'];
    } 
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
      $response = ['error' => true, 'message' => 'Alpha lowercase characters only', 'input_text' => $string];
    } else {
      $response = false;
    }
    return $response;
  }

  /**
   * Make sure Type Fields are not empty on POST
   *
   * @return true || array
   */
  private function checkEmpty() {
    foreach($this->input as $field) {
      if(empty($field['field_name']) || empty($field['field_type'])) {
        return ['error' => true, 'message' => 'Fields require a name and type.'];
      }
    }
    return true;
  }

}
