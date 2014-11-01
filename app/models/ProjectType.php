<?php

class ProjectType extends Eloquent {

  use SoftDeletingTrait;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'projects_types';

  /**
   * Fillable items in the database
   *
   * @var array
   */
  protected $fillable = ['project_id', 'type', 'table_name'];

  /**
   * Create project types group
   *
   * @param int,array
   *
   * @return array
   */
  public static function createTypesGroup($project_id, $data) {
    $project = Project::where('id', $project_id)->first();
    $data['table_name'] = strtolower($data['table_name']);

    $projectTable = ProjectType::create([
      'project_id' => $project_id,
      'type'       => $data['table_name'],
      'table_name' => $project->name_adj.'_'.$data['table_name']
    ]);

    Schema::create($projectTable->table_name, function($table) {
      $table->increments('id');
    });

    $response = [
      'error' => false,
      'message' => 'Created project type successfully.'
    ];

    return $response;
  }

  /**
   * Update the project type fields
   *
   * @param int, string, array
   *
   * @return array
   */
  public static function addTypesFields($project_id, $project_type, $data) {
    $projectType = ProjectType::where('project_id', $project_id)->where('type', $project_type)->first();
    if(null === $projectType) {
      $response = ['error' => true, 'message' => 'Project type not found.'];
    } else {
      $projectType->fields = json_encode($data);
      $projectType->save();
      $response = ['error' => false, 'message' => 'Fields updated successfully.'];
    }
    return $response;
  }

  /**
   * Delete project types group
   *
   * @param int, string
   *
   * @return response
   */
  public static function deleteTypesGroup($project_id, $type) {
    $project = Project::where('id', $project_id)->first();
    $type   = ProjectType::where('name', $type)->first();

    Schema::drop($type->table_name);
    $type->delete();

    $response = [
      'error' => false,
      'message' => 'Type set deleted.'
    ];

    return $response;
  }

}
