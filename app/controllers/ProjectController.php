<?php

class ProjectController extends Controller {

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


}
