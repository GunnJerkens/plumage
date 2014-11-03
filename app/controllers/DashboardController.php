<?php

class DashboardController extends Controller {

  /**
   * Handles GET requests for /dashboard
   *
   * @return view
   */
  public function getDashboard() {
    $projects = Project::all();
    return View::make('layouts.dashboard')->with([
      'projects' => $projects
    ]);
  }

  /**
   * Handles GET requests for /mapper
   *
   * @return view
   */
  public function getMapper() {
    return View::make('layouts.mapper');
  }

  /**
   * Handles GET requests for /project/{project_id}
   * 
   * @param int
   *
   * @return view
   */
  public function getProject($project_id) {
    $project      = Project::where('id', $project_id)->first();
    $projectTypes = ProjectType::where('project_id', $project_id)->get();
    return View::make('layouts.project')->with([
      'project'       => $project,
      'project_types' => $projectTypes
    ]);
  }

  /**
   * Handles GET requests for /project/{project_id}/{project_type}
   *
   * @param int
   *
   * @return view
   */
  public function getProjectType($project_id, $project_type) {


    return View::make('layouts.sites')->with([


    ]);
  }

  /**
   * Handles GET requests for /project/{project_id}/{project_type}/edit
   *
   * @param int
   *
   * @return view
   */
  public function getProjectTypeEdit($project_id, $project_type) {
    $projectType = ProjectType::where('project_id', $project_id)->where('type', $project_type)->first();
    return View::make('layouts.sites-edit')->with([
      'fields' => json_decode($projectType->fields)
    ]);
  }

}
