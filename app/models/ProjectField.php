<?php

class ProjectField extends Eloquent {

  use SoftDeletingTrait;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'projects_fields';

  /**
   * Fillable items in the database
   *
   * @var array
   */
  protected $fillable = ['project_id', 'name', 'table_name'];

  /**
   * Create project fields group
   *
   * @param int,array
   *
   * @return array
   */
  public static function createFieldsGroup($project_id, $data) {

    $project = Project::where('id', $project_id)->first();
    $data['table_name'] = strtolower($data['table_name']);

    $projectTable = self::create([
      'project_id' => $project_id,
      'name'       => $data['table_name'],
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

}
