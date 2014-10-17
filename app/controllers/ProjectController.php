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
        'field_data' => $input['table_name']
      ];
    } else {
      $response = ProjectField::createFieldsGroup($project_id, $input);
    }
    return Redirect::back()->with($response);
  }

  /**
   * Handles GET requests for /project/{project_id}/{project_field}/delete
   *
   * @return redirect
   */
  public function postProjectDelete($project_id, $project_field) {
    $response = ProjectField::deleteFieldsGroup($project_id, $project_field);
    return Redirect::back()->with($response);
  }

}
