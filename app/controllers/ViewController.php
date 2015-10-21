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
      $projects = Project::orderby('name')->get();
    } else if(false !== ($projects = ProjectAccess::getUserProjects($this->user->id))) {
      $projects = Project::whereIn('id', $projects)->orWhere('user_id', $this->user->id)->orderBy('name')->get();
    } else {
      $projects = Project::where('user_id', $this->user->id)->orderBy('name')->get();
    }
    return View::make('layouts.dashboard')->with([
      'projects' => $projects
    ]);
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
    $project = Project::where('id', $project_id)->first();
    $types   = ProjectType::where('project_id', $project_id)->get();
    $access  = ProjectAccess::where('project_id', $project_id)->where('user_id', $this->user->id)->first();

    return View::make('layouts.project')->with(array_merge($this->default, [
      'project' => $project,
      'types'   => $types,
      'access' => $access,
      'users'   => $this->user->hasAnyAccess(['manage']) ? User::all() : false,
    ]));
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

  /**
   * Handles GET requests for /account
   *
   * @return view
   */
  public function getAccount()
  {
    return View::make('layouts.account')->with(['user' => $this->user]);
  }

}
