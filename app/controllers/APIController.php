<?php

class APIController extends Controller {

  /**
   * Protected class vars
   *
   * @var $project object
   * @var $projectType object
   * @var $projectData object
   */
  protected $project, $projectType, $projectTypeData;

  /**
   * Project constructor
   *
   * @return void
   */
  function __construct() {
    $this->beforeFilter('@setProject');
    $this->beforeFilter('@setProjectType');
    $this->beforeFilter('@setProjectTypeData');
  }

  /**
   * Sets the project object on the class protected var $project
   *
   * @param object, pbject
   *
   * @return void || function()
   */
  public function setProject($route, $request) {
    $project_name = $route->getParameter('project_name');
    $project      = Project::where('name_adj', $project_name)->first();
    if($project != null) {
      $this->project = $project;
    } else {
      return $this->getAPIMissing();
    }
  }

  /**
   * Sets the project object on the class protected var $projectType
   *
   * @param object, object
   *
   * @return void || function()
   */
  public function setProjectType($route, $request) {
    $project_type = $route->getParameter('project_type');
    $projectType  = ProjectType::where('project_id', $this->project->id)->where('type', $project_type)->first();
    if($projectType != null) {
      $this->projectType = $projectType;
    } else {
      return $this->getAPIMissing();
    }
  }

  /**
   * Sets the project object on the class protected var $projectTypeData
   *
   * @param object, object
   *
   * @return void || function()
   */
  public function setProjectTypeData($route, $request) {
    $projectTypeData = DB::Table($this->projectType->table_name)->get();
    if($projectTypeData != null) {
      $this->projectTypeData = $projectTypeData;
    } else {
      return $this->getAPIMissing();
    }
  }

  /**
   * Handles GET requests that are off the space time continuum
   *
   * @return json
   */
  public function getAPIMissing() {
    $quotes = [
      'There\'s that word again. "Heavy." Why are things so heavy in the future? Is there a problem with the Earth\'s gravitational pull?',
      'Roads? Where we\'re going, we don\'t need roads.',
      'Great Scott!',
      'Ronald Reagan? The actor?',
      'You want a Pepsi, pal, you\'re gonna pay for it.',
      'This is heavy.',
      'No, no, no, no, no, this sucker\'s electrical, but I need a nuclear reaction to generate the 1.21 gigawatts of electricity I need.',
      'What\'s a rerun?',
      'What-what the hell is a gigawatt?',
      'If you put your mind to it, you can accomplish anything.',
      'Weight has nothing to do with it.'
    ];
    $key = array_rand($quotes);
    return Response::json($quotes[$key], 404);
  }

  /**
   * Handles GET requests for /api/{project_name}/{project_type}
   *
   * @return json
   */
  public function getProjectTypeData() {
    return Response::json($this->projectTypeData);
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
