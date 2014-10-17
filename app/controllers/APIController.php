<?php

class APIController extends Controller {

  /**
   * Handles GET requests for /api/{project_name}/{project_field}
   *
   * @return json
   */
  public function getProjectField($project_name, $project_field) {
    $response = [
      'Message' => 'Welcome to the API.'
    ];
    return Response::json($response);
  }

}
