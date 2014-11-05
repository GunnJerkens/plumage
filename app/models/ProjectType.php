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
      self::createFieldsColumns($projectType->table_name, $data);
      $projectType->fields = json_encode($data);
      $projectType->save();
      $response = ['error' => false, 'message' => 'Fields updated successfully.'];
    }
    return $response;
  }

  /**
   * Create fields columns
   *
   * @param string, array
   *
   * @return void
   */
  private static function createFieldsColumns($tableName, $data) {
    foreach($data as $field) {
      if(!Schema::hasColumn($tableName, $field['field_name'])) {
        Schema::table($tableName, function($table) use ($field) {
          $table->string($field['field_name']);
        });
      }
    }
  }

  /**
   * Delete fields columns
   *
   * @param string, array
   *
   * @return void
   */
  private static function deleteFieldsColumns($tableName, $columns) {
    foreach($columns as $column) {
      if(Schema::hasColumn($tableName, $column)) {
        Schema::table($tableName, function($table) use ($column) {
          $table->dropColumn($column);
        });
      }
    }
  }

  /**
   * Adds the individual data to the type
   *
   * @param string, array
   *
   * @return array
   */
  public static function createTypesData($tableName, $data) {
    if(!Schema::hasTable($tableName)) {
      $response = ['error' => true, 'message' => 'Type table does not exist.'];
      return $response;
    }
    $id = $data['id'];
    unset($data['id']);
    $set = DB::table($tableName)->where('id', $id)->first();
    if(null === $set) {
      $set = DB::table($tableName)->insert($data);
    } else {
      $set = DB::table($tableName)->where('id', $id)->update($data);
    }
    return ['error' => false, 'message' => 'Type data updated successfully.'];
  }

  /**
   * Deletes the specific data from the type
   *
   * @param 
   *
   * @return array
   */
  public static function deleteTypesData() {

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
    $type    = ProjectType::where('type', $type)->first();

    Schema::drop($type->table_name);
    $type->delete();

    $response = [
      'error' => false,
      'message' => 'Type set deleted.'
    ];
    return $response;
  }

}
