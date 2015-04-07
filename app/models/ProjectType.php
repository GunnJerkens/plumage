<?php

class ProjectType extends Eloquent
{

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
   * @return true
   */
  public static function createTypesGroup($project_id, $data)
  {
    $project = Project::where('id', $project_id)->first();
    $data['table_name'] = strtolower($data['table_name']);

    $projectTable = ProjectType::create([
      'project_id' => $project_id,
      'type'       => $data['table_name'],
      'table_name' => $project->name.'_'.$data['table_name']
    ]);

    Schema::create($projectTable->table_name, function($table) {
      $table->increments('id');
    });
    return true;
  }

  /**
   * Update the project type fields
   *
   * @param int, string, array
   *
   * @return true|int
   */
  public static function addTypesFields($project_id, $project_type, $data)
  {
    $projectType = ProjectType::where('project_id', $project_id)->where('type', $project_type)->first();
    if(null === $projectType) {
      $state = 404;
    } else {
      $data = self::createFieldsColumns($projectType->table_name, $data);
      $projectType->fields = self::formatFields($data);
      $projectType->save();
      $state = true;
    }
    return $state;
  }

  /**
   * Format fields
   *
   *
   */
  private static function formatFields($data)
  {
    foreach($data as &$fields) {
      if(isset($fields['field_name_orig'])) {
        unset($fields['field_name_orig']);
      }
    }
    return json_encode($data);
  }

  /**
   * Create fields columns
   *
   * @param string, array
   *
   * @return array
   */
  private static function createFieldsColumns($tableName, $data)
  {
    foreach($data as &$field) {

      $field['field_name'] = self::fieldNameWhiteList($field['field_name']);

      if(isset($field['field_name_orig']) && $field['field_name'] !== $field['field_name_orig']) {
        Schema::table($tableName, function($table) use ($field) {
          $table->renameColumn($field['field_name_orig'], $field['field_name']);
        });
      } else if(!Schema::hasColumn($tableName, $field['field_name'])) {
        Schema::table($tableName, function($table) use ($field) {
          if($field['field_type'] === 'checkbox') {
            $table->boolean($field['field_name'])->default(false);
          } else {
            $table->mediumText($field['field_name'])->nullable();
          }
        });
      }
    }
    return $data;
  }

  /**
   * Validates the types field names against a whitelist
   *
   * @param string
   *
   * @return string
   */
  private static function fieldNameWhiteList($fieldName)
  {
    $whitelist = ['id'];
    if(in_array($fieldName, $whitelist)) {
      $fieldName = $fieldName.'_';
    }
    return $fieldName;
  }

  /**
   * Delete fields columns
   *
   * @param string, array
   *
   * @return void
   */
  private static function deleteFieldsColumns($tableName, $columns)
  {
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
   * @return true|int
   */
  public static function createTypesData($tableName, $data)
  {
    if(!Schema::hasTable($tableName)) {
      $state = 404;
    } else {
      $state = true;
      $id = $data['id'];
      unset($data['id']);
      $set = DB::table($tableName)->where('id', $id)->first();
      if($set === null) {
        DB::table($tableName)->insert($data);
      } else {
        $data = self::setBooleanData($tableName, $data);
        DB::table($tableName)->where('id', $id)->update($data);
      }
    }
    return $state;
  }

  /**
   * Set the boolean data true or false, checks data against column names/type
   *
   * @param string, array
   *
   * @return array
   */
   public static function setBooleanData($tableName, $data) {
    $columns = DB::connection()->getDoctrineSchemaManager()->listTableColumns($tableName);
    foreach($columns as $column) {
      if($column->getType()->getName() === 'boolean') {
        $columnName = $column->getName();
        $data[$columnName] = isset($data[$columnName]) ? true : false;
      }
    }
    return $data;
   }

  /**
   * Deletes the specific data from the type
   *
   * @param int, string, int
   *
   * @return void
   */
  public static function deleteTypesData($project_id, $project_type, $project_row)
  {
    $projectType = self::where('project_id', $project_id)->where('type', $project_type)->first();
    DB::table($projectType->table_name)->where('id', $project_row)->delete();
  }

  /**
   * Delete project types group
   *
   * @param int, string
   *
   * @return bool
   */
  public static function deleteTypesGroup($project_id, $type)
  {
    $project = Project::where('id', $project_id)->first();
    $type    = ProjectType::where('type', $type)->first();

    Schema::drop($type->table_name);
    $type->delete();

    return true;
  }

}
