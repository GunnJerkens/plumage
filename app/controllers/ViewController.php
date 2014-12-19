<?php

class ViewController extends Controller {

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
    $projectType = ProjectType::where('project_id', $project_id)->where('type', $project_type)->first();
    $itemData    = DB::table($projectType->table_name)->get();
    return View::make('layouts.type')->with([
      'project' => $projectType,
      'fields'  => json_decode($projectType->fields),
      'items'   => $itemData
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
    return View::make('layouts.type-edit')->with([
      'fields' => json_decode($projectType->fields)
    ]);
  }

  /**
   * Handles GET requests for /manage
   *
   * @return view
   */
  public function getManage() {
    $user = Sentry::getUser();
    return View::make('layouts.manage')->with([
      'users'    => User::all(),
      'throttle' => Sentry::findThrottlerByUserId($user->id),
      'access'   => ProjectAccess::where('user_id', $user->id)->get()
    ]);
  }

}
