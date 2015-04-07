<?php

class ProjectController extends Controller
{

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
  function __construct()
  {
    $this->input = Input::except('_token');
    $this->user  = Sentry::getUser();
  }

  /**
   * Handles POST requests for /dashboard
   *
   * @return redirect
   */
  public function createProject()
  {
    if (!$this->checkEmpty()) {
      $response = ['error' => true, 'message' => 'Fields cannot be empty.'];
    } elseif (!$this->checkNaming($this->input['project_name'])) {
      $response = ['error' => true, 'message' => 'Alpha lowercase characters only.', 'input_text' => $this->input['project_name']];
    } else {
      Project::create([
        'user_id'   => $this->user->id,
        'name'      => $this->input['project_name'],
        'is_active' => true
      ]);
      $response = ['error' => false, 'message' => 'Created new project successfully.'];
    }
    return Redirect::back()->with($response);
  }

  /**
   * Handles POST requests for /project/{project_id}
   *
   * @return redirect
   */
  public function postProject($project_id)
  {
    if (!$this->checkNaming($this->input['table_name'])) {
      $response = ['error' => true, 'message' => 'Types may only contain lowercase a-z, underscores, & dashes.'];
    } else {
      ProjectType::createTypesGroup($project_id, $this->input);
      $response = ['error' => false, 'message' => 'Created project type successfully.'];
    }
    return Redirect::back()->with($response);
  }

  /**
   * Handles POST requests for /project/{project_id}/delete
   *
   * @return redirect
   */
   public function postProjectDelete($project_id)
   {
    $deleteTypesTables = ProjectType::deleteAllTypesTables($project_id);
    if($deleteTypesTables) {
      ProjectType::where('project_id', $project_id)->delete();
      Project::where('id', $project_id)->delete();
      return Redirect::back()->with(['error' => false, 'message' => 'Project deleted successfully.']);
    } else {
      return Redirect::back()->with(['error' => true, 'message' => 'Error delete all type sets.']);
    }
   }

  /**
   * Handles POST requests for /project/{project_id}/access
   *
   * @return redirect
   */
  public function postProjectAccess($project_id)
  {
    $access  = ProjectAccess::where('project_id', $project_id)->where('user_id', $this->input['id'])->first();
    $project = Project::where('id', $project_id)->first();

    if(!$access && $this->input['id'] != $project->user_id) {
      ProjectAccess::create([
        'project_id' => $project_id,
        'user_id'    => $this->input['id'],
      ]);
      return Redirect::back()->with(['error' => false, 'message' => 'Added user access successfully.']);
    } else {
      return Redirect::back()->with(['error' => true, 'message' => 'User already has access.']);
    }
  }

  /**
   * Handles POST requests for /project/{project_id}/accessremove
   *
   * @return redirect
   */
  public function postProjectAccessRemove($project_id) {
    $access = ProjectAccess::where('project_id', $project_id)->where('user_id', $this->input['id'])->delete();
    return Redirect::back()->with(['error' => false, 'message' => 'Users access removed sucessfully.']);
  }

  /**
   * Handles POST requests for /project/{project_id}/{project_type}
   *
   * @param int, string
   *
   * @return redirect
   */
  public function postProjectType($project_id, $project_type)
  {
    $projectType = ProjectType::where('project_id', $project_id)->where('type', $project_type)->first();
    foreach ($this->input as $data) {
      $state    = ProjectType::createTypesData($projectType->table_name, $data);
      $response = ['error' => false, 'message' => 'Type data updated successfully.'];
      if ($state === 404) {
        $response = ['error' => true, 'message' => 'Type table does not exist.'];
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
  public function postProjectTypeEdit($project_id, $project_type)
  {
    if (!$this->checkEmpty()) {
      $response = ['error' => true, 'message' => 'Fields cannot be empty.'];
    } else {
      $state = ProjectType::addTypesFields($project_id, $project_type, $this->input);
      if ($state === 404) {
        $response = ['error' => true, 'message' => 'Project type not found.'];
      } else {
        $response = ['error' => false, 'message' => 'Fields updated successfully.'];
      }
    }
    return Redirect::back()->with($response);
  }

  /**
   * Handles POST requests for /project/
   *
   * @param int, string
   *
   * @return redirect
   */
  public function postProjectTypeBulk($project_id, $project_type)
  {
    $projectType = ProjectType::where('project_id', $project_id)->where('type', $project_type)->first();
    if (is_array($json = json_decode($this->input['json_data']))) {
      foreach ($json as $data) {
        $data->id = null;
        $response = ProjectType::createTypesData($projectType->table_name, (array) $data);
        if ($response['error'] === true) {
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
  public function deleteProjectType($project_id, $project_type)
  {
    ProjectType::deleteTypesGroup($project_id, $project_type);
    return Redirect::back()->with(['error' => false, 'message' => 'Type set deleted.']);
  }

  /**
   *
   *
   *
   *
   */
  public function postProjectTypeDeleteRow($project_id, $project_type)
  {
    ProjectType::deleteTypesData($project_id, $project_type, $this->input['row']);
    return Response::json(['error' => false, 'message' => 'Removed row successfully.']);
  }

  /**
   * Make sure a project is all lowercase, no special chars
   *
   * @param string
   *
   * @return bool
   */
  private function checkNaming($string)
  {
    $state = true;
    if (!preg_match('/^[a-z-_]+$/', $string)) {
      $state = false;
    }
    return $state;
  }

  /**
   * Make sure Type Fields are not empty on POST
   *
   * @return true || array
   */
  private function checkEmpty()
  {
    $state = true;
    foreach ($this->input as $field) {
      if ($field === "" || empty($field)) {
        $state = false;
      }
    }
    return $state;
  }

}
