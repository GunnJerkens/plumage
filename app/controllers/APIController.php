<?php

class APIController extends Controller {

  /**
   * Handles GET requests for /api/
   *
   * @return json
   */
  public function getAPI() {
    $response = ['Message' => 'Welcome to the API.'];
    return Response::json($response);
  }

  /**
   * Handles GET requests for /api/{project_name}/{project_type}
   *
   * @return json
   */
  public function getProjectType($project_name, $project_type) {
    $project     = Project::where('name_adj', $project_name)->first();
    $projectType = ProjectType::where('project_id', $project->id)->first();
    $projectData = DB::Table($projectType->table_name)->get();
    return Response::json($projectData);
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
