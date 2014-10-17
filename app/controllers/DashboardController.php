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
   * @return view
   */
  public function getProject($project_id) {
    $project = Project::where('id', $project_id)->first();
    return View::make('layouts.project')->with([
      'project' => $project
    ]);
  }

}
