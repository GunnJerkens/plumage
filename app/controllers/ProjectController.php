<?php

class ProjectController extends Controller {

  /**
   * Handles POST requests for /project/{project_id}
   *
   * @return view
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

}
