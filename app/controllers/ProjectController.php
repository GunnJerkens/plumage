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
        'error'      => true,
        'message'    => 'Alpha characters only',
        'type_data' => $input['table_name']
      ];
    } else {
      $response = ProjectType::createTypesGroup($project_id, $input);
    }
    return Redirect::back()->with($response);
  }

  /**
   * Handles GET requests for /project/{project_id}/{project_type}/delete
   *
   * @return redirect
   */
  public function postProjectDelete($project_id, $project_type) {
    $response = ProjectType::deleteTypesGroup($project_id, $project_type);
    return Redirect::back()->with($response);
  }

  public function postProjectTypeEdit($project_id, $project_type) {
    var_dump(Input::all());
    die();
  }

}
