<?php

class APIController extends Controller {

  /**
   * Handles GET requests for /api/{project_name}/{project_type}
   *
   * @return json
   */
  public function getProjectType($project_name, $project_type) {
    $response = [
      'Message' => 'Welcome to the API.'
    ];
    return Response::json($response);
  }

  /**
   * Handles POST requests for /api/{project_name}/{project_type}
   *
   * @return json
   */
  public function postProjectType($project_name, $project_type) {
    $response = [
      'Message' => 'Welcome to the API.'
    ];
    return Response::json($response);
  }

}
