<?php

class ViewController extends BaseController
{

  /**
   * Class construct
   */
  function __construct()
  {
    parent::__construct();
  }

  /**
   * Handles GET requests for /dashboard
   *
   * @return view
   */
  public function getDashboard()
  {
    if($this->user->hasAnyAccess(['manage'])) {
      $projects = Project::all();
    } else if(!empty($projects = $this->setProjects())) {
      $projects = Project::whereIn('id', $projects)->orWhere('user_id', $this->user->id)->orderBy('id')->get();
    } else {
      $projects = Project::where('user_id', $this->user->id)->orderBy('id')->get();
    }
    return View::make('layouts.dashboard')->with([
      'projects' => $projects
    ]);
  }

  /**
   * Sets the projects for viewing
   *
   * @return array
   */
  private function setProjects()
  {
    $ids = [];
    $projects = ProjectAccess::where('user_id', $this->user->id)->get();
    foreach($projects as $project) {
      if($project->user_id === $this->user->id) {
        $ids[] = $project->project_id;
      }
    }
    return $ids;
  }
  /**
   * Handles GET requests for /mapper
   *
   * @return view
   */
  public function getMapper()
  {
    return View::make('layouts.mapper');
  }

  /**
   * Handles GET requests for /project/{project_id}
   * 
   * @param int
   *
   * @return view
   */
  public function getProject($project_id)
  {
    $project      = Project::where('id', $project_id)->first();
    $projectTypes = ProjectType::where('project_id', $project_id)->get();
    return View::make('layouts.project')->with([
      'project'       => $project,
      'project_types' => $projectTypes,
      'edit'          => !$this->user->hasAnyAccess(['manage']) && $this->user->id !== $project->user_id ? false : true,
      'users'         => $this->user->hasAnyAccess(['manage']) ? User::all() : false,
    ]);
  }

  /**
   * Handles GET requests for /project/{project_id}/{project_type}
   *
   * @param int
   *
   * @return view
   */
  public function getProjectType($project_id, $project_type)
  {
    $projectType = ProjectType::where('project_id', $project_id)->where('type', $project_type)->first();
    $itemData    = DB::table($projectType->table_name)->get();
    return View::make('layouts.type')->with([
      'project' => $projectType,
      'fields'  => json_decode($projectType->fields),
      'items'   => $itemData,
      'user'    => $this->user,
    ]);
  }

  /**
   * Handles GET requests for /project/{project_id}/{project_type}/edit
   *
   * @param int
   *
   * @return view
   */
  public function getProjectTypeEdit($project_id, $project_type)
  {
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
  public function getManage()
  {
    return View::make('layouts.manage')->with(['users' => User::all()]);
  }

}
