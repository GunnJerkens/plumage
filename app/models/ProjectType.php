<?php

class ProjectType extends Eloquent
{

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
   * @param integer, string
   *
   * @return object
   */
  public static function createTypesGroup($project_id, $tableName)
  {
    $tableName = strtolower($tableName);
    $project   = Project::where('id', $project_id)->first();

    if($project === null) throw new Exception('Project not found');

    $projectType = ProjectType::create([
      'project_id' => $project->id,
      'type'       => $tableName,
      'table_name' => $project->name.'_'.$tableName
    ]);

    Schema::create($projectType->table_name, function($table) {
      $table->increments('id');
    });

    return $projectType;
  }

  /**
   * Update the project type fields
   *
   * @param int, string, array
   *
   * @return object
   */
  public static function addTypesFields($project_id, $project_type, $data)
  {
    $projectType = self::where('project_id', $project_id)->where('type', $project_type)->first();

    if(null === $projectType) throw new Exception('Project type not found.');

    $data = self::createFieldsColumns($projectType->table_name, $data);
    $projectType->fields = self::formatFields($data);
    $projectType->save();

    return $projectType;
  }

  /**
   * Remove the project type fields
   *
   * @param object, string, string
   *
   * @return bool
   */
  public static function removeTypesFields($project, $type, $column)
  {
    $type   = self::where('project_id', $project->id)->where('type', $type)->first();
    $fields = json_decode($type->fields);
    $match  = false;
    foreach($fields as $key=>$value) {
      if(isset($value->field_name) && $value->field_name === $column) {
        unset($fields[$key]);
        $match = true;
      }
    }
    if($match) {
      $type->fields = json_encode($fields);
      $type->save();
      self::deleteFieldsColumns($type->table_name, [$column]);
    }
    return $match ? true : false;
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
   * Adds the individual data to the type, performs an upsert yo
   *
   * @param string, array
   *
   * @return true|int
   */
  public static function createTypesData($tableName, $data)
  {
    if(!Schema::hasTable($tableName)) {
      throw new Exception('TableNotFoundException');
    }

    $dataset = isset($data['id']) ? DB::table($tableName)->where('id', $data['id'])->first() : null;

    if($dataset === null) {
      $db = DB::table($tableName)->insert($data);
    } else {
      $data = self::setBooleanData($tableName, $data);
      $db = DB::table($tableName)->where('id', $dataset->id)->update($data);
    }

    return $db;
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
    if($columns && sizeof($columns) > 0) {
      foreach($columns as $column) {
        if($column->getType()->getName() === 'boolean') {
          $columnName = $column->getName();
          $data[$columnName] = isset($data[$columnName]) ? true : false;
        }
      }
    }
    return $data;
   }

  /**
   * Deletes the specific data from the type
   *
   * @param int, string, int
   *
   * @return int
   */
  public static function deleteTypesData($project_id, $project_type, $project_row)
  {
    $projectType = self::where('project_id', $project_id)->where('type', $project_type)->first();
    return DB::table($projectType->table_name)->where('id', $project_row)->delete();
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
    $type    = self::where('project_id', $project_id)->where('type', $type)->first();
    Schema::drop($type->table_name);
    $type->delete();

    return true;
  }

  /**
   * Delete all project types tables
   *
   * @return void
   */
  public static function deleteAllTypesTables($project_id)
  {
    $projectType = self::where('project_id', $project_id)->get();
    if(0 !== sizeof($projectType)) {
      foreach($projectType as $project) {
        if(Schema::hasTable($project->table_name)) {
          Schema::drop($project->table_name);
        }
      }
    }
    return true;
  }

}
