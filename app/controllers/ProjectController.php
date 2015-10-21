<?php

class ProjectController extends BaseController
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
    parent::__construct();
  }

  /**
   * Handles POST requests for /dashboard
   *
   * @return redirect
   */
  public function createProject()
  {
    if (!Utilities::checkEmpty($this->input)) {
      $response = ['error' => true, 'message' => Lang::get('project.fields_empty')];
    } elseif (!$this->checkNaming($this->input['project_name'])) {
      $response = ['error' => true, 'message' => Lang::get('project.alpha_chars'), 'input_text' => $this->input['project_name']];
    } else {
      Project::create([
        'user_id'   => $this->user->id,
        'name'      => $this->input['project_name'],
        'is_active' => true
      ]);
      $response = ['error' => false, 'message' => Lang::get('project.project_create')];
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
      $response = ['error' => true, 'message' => Lang::get('project.types_naming')];
    } else {
      ProjectType::createTypesGroup($project_id, $this->input['table_name']);
      $response = ['error' => false, 'message' => Lang::get('project.type_create')];
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
      return Redirect::back()->with(['error' => false, 'message' => Lang::get('project.project_delete')]);
    } else {
      return Redirect::back()->with(['error' => true, 'message' => Lang::get('project.delete_error')]);
    }
   }

  /**
   * Handles POST requests for /project/{project_id}/access
   *
   * @return redirect
   */
  public function postProjectAccess($project_id)
  {
    $project = Project::where('id', $project_id)->first();
    $access  = ProjectAccess::where('project_id', $project_id)->where('user_id', $this->user->id)->first();

    if($this->user->is_admin || $project->is_owner || $access->can_add_users) {
      if($this->input['mode'] === "create") {
        ProjectAccess::create([
          'project_id' => $project_id,
          'user_id'    => $this->input['id'],
        ]);
        $response = ['error' => false, 'message' => Lang::get('project.user_add')];
        return Redirect::back()->with();
      } else {
        ProjectAccess::where('project_id', $project_id)->where('user_id', $this->input['id'])->update([
          "can_add_users" => isset($this->input['can_add_users']) ? true : false,
          "can_edit"      => isset($this->input['can_edit']) ? true : false,
          "can_delete"    => isset($this->input['can_delete']) ? true : false,
        ]);
        $response = ['error' => false, 'message' => Lang::get('project.user_update')];
      }
    } else {
      $response = ['error' => true, 'message' => Lang::get('project.project_perm')];
    }
    return Redirect::back()->with($response);
  }

  /**
   * Handles POST requests for /project/{project_id}/access-remove
   *
   * @return redirect
   */
  public function postProjectAccessRemove($project_id) {
    $access = ProjectAccess::where('project_id', $project_id)->where('user_id', $this->input['id'])->delete();
    return Redirect::back()->with(['error' => false, 'message' => Lang::get('project.user_remove')]);
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
    $response = ['error' => true, 'message' => Lang::get('project.type_missing')];
    foreach ($this->input as $data) {
      $state    = ProjectType::createTypesData($projectType->table_name, $data);
      $response = ['error' => false, 'message' => Lang::get('project.type_updated')];
      // TODO::fix this, idk why I thought return integers was clever? It should
      // just throw exceptions like a normal human being. -ps
      if ($state === 404) { 
        $response = ['error' => true, 'message' => Lang::get('project.type_missing')];
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
    if (!Utilities::checkEmpty($this->input)) {
      $response = ['error' => true, 'message' => Lang::get('project.fields_empty')];
    }

    try {
      $projectType = ProjectType::addTypesFields($project_id, $project_type, $this->input);
      $response = ['error' => false, 'message' => Lang::get('fields_updated')];
    } catch(Exception $e) {
      $response = ['error' => true, 'message' => Lang::get('error.default')];
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
      $response = ['error' => true, 'message' => Lang::get('error.json_malformed')];
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
    return Redirect::back()->with(['error' => false, 'message' => Lang::get('project.types_deleted')]);
  }

  /**
   * Handles POST requests for /project/{project_id}/{project_type}/delete-row
   *
   * @return json
   */
  public function postProjectTypeDeleteRow($project_id, $project_type)
  {
    ProjectType::deleteTypesData($project_id, $project_type, $this->input['row']);
    return Response::json(['error' => false, 'message' => Lang::get('project.types_row_removed')]);
  }

  /**
   * Handles POST requests for /project/{project_id}/{project_type}/delete-field
   *
   * @return json
   */
  public function postProjectDeleteField($project_id, $project_type)
  {
    $column  = isset($this->input['column']) ? $this->input['column'] : false;
    $project = Project::where('id', $project_id)->first();
    $state   = ProjectType::removeTypesFields($project, $project_type, $column);
    if($state) {
      $state = ['error' => false, 'message' => Lang::get('project.fields_deleted')];
    } else {
      $state = ['error' => true, 'message' => Lang::get('project.fields_deleted_failed')];
    }
    return Response::json($state);
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
    return (!preg_match('/^[a-z-_]+$/', $string)) ? false : true;
  }

}
