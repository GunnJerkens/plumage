<?php

class ProjectTypeTest extends TestCase
{

  /**
   * Private class vars
   *
   * @var int
   * @var string
   * @var array
   * @var array
   */
  private $projectId, $projectType, $projectFields, $projectData;

  /**
   * Sets our private class vars
   *
   * @return void
   */
  private function setVars()
  {
    $this->project = DB::table('projects')->first();

    if($this->project === null || sizeof($this->project) !== 1) die('Failed to retrieve a project from the database.');

    $this->projectType = 'test';
    $this->projectFields = [
      [
        'field_type'     => 'text',
        'field_name'     => 'text',
        'field_editable' => 'on',
      ],
      [
        'field_type'     => 'checkbox',
        'field_name'     => 'checkbox',
        'field_editable' => 'on',
      ],
      [
        'field_type'     => 'select',
        'field_name'     => 'select',
        'field_editable' => 'on',
        'field_values'   => [['value' => 'value', 'label' => 'name']],
      ],
    ];
    $this->projectData = [
      'id'       => 1,
      'text'     => 'test text',
      'select'   => 'test value',
    ];
  }

  /**
   * ProjectType::createTypesGroup()
   *
   */
  public function testCreateTypesGroup()
  {
    $this->setVars();
    $projectType = ProjectType::createTypesGroup($this->project->id, $this->projectType);

    $this->assertInternalType('object', $projectType);
    $this->assertEquals($this->project->id, $projectType->project_id);
    $this->assertEquals($this->project->name.'_'.$this->projectType, $projectType->table_name);
  }

  /**
   * ProjectType::createTypesGroup()
   *
   * @expectedException Exception
   */
  public function testCreateTypesGroupException()
  {
    $this->setVars();

    ProjectType::createTypesGroup(83838, 'failure');
  }

  /**
   * ProjectType::addTypesFields()
   *
   */
  public function testAddTypesFields()
  {
    $this->setVars();
    $projectType = ProjectType::addTypesFields($this->project->id, $this->projectType, $this->projectFields);

    $this->assertInternalType('object', $projectType);
    $this->assertEquals($this->project->id, $projectType->project_id);
    $this->assertEquals($this->project->name.'_'.$this->projectType, $projectType->table_name);
  }

  /**
   * ProjectType::addTypesFields()
   *
   * @expectedException Exception
   */
  public function testAddTypesFieldsException()
  {
    $this->setVars();

    ProjectType::addTypesFields(83838, 'failure', []);
  }

  /**
   * ProjectType::createTypesData()
   *
   */
  public function testCreateTypesData()
  {
    $this->setVars();
    $this->project->table_name = $this->project->name."_test";
    $projectType = ProjectType::createTypesData($this->project, $this->projectData);
    $this->assertTrue($projectType);
  }

  /**
   * ProjectType::createTypesData()
   *
   * @expectedException Exception
   */
  public function testCreateTypesDataException()
  {
    $this->setVars();
    $this->project->table_name = $this->project->name."_derp";
    ProjectType::createTypesData($this->project, $this->projectData);
  }

  /**
   * ProjectType::createNewTypesData()
   *
   */
  public function testCreateNewTypesData()
  {
    $this->setVars();
    $projectType = ProjectType::addTypesFields($this->project->id, $this->projectType, $this->projectFields);
    $newTypesData = ['new field' => 'new value'];
    $response = ProjectType::createNewTypesData($projectType, $newTypesData);
    $this->assertTrue($response);
    // check that the new fields were added based on data
    $projectType = ProjectType::where('project_id', $projectType->project_id)->where('type', $projectType->type)->first();
    array_push($this->projectFields, ["field_type" => "text", "field_name" => "new field"]);
    $fields = json_encode($this->projectFields);
    $this->assertEquals($fields, $projectType->fields);
  }

  /**
   * ProjectType::createNewTypesData()
   *
   */
  public function testCreateNewTypesDataBool()
  {
    $this->setVars();
    $projectType = ProjectType::addTypesFields($this->project->id, $this->projectType, $this->projectFields);
    $newTypesData = ['new field bool' => true];
    $response = ProjectType::createNewTypesData($projectType, $newTypesData);
    $this->assertTrue($response);
    // check that the new fields were added based on data
    $projectType = ProjectType::where('project_id', $projectType->project_id)->where('type', $projectType->type)->first();
    array_push($this->projectFields, ["field_type" => "checkbox", "field_name" => "new field bool"]);
    $fields = json_encode($this->projectFields);
    $this->assertEquals($fields, $projectType->fields);
  }

  /**
   * ProjectType::setBooleanData()
   *
   */
  public function testSetBooleanDataFalse()
  {
    $this->setVars();
    $data = ProjectType::setBooleanData($this->project->name."_test", $this->projectData);
    $this->assertInternalType('array', $data);
    $this->assertEquals(false, $data['checkbox']);
  }

  /**
   * ProjectType::setBooleanData()
   *
   */
  public function testSetBooleanDataTrue()
  {
    $this->setVars();
    $this->projectData['checkbox'] = true;
    $data = ProjectType::setBooleanData($this->project->name."_test", $this->projectData);
    $this->assertInternalType('array', $data);
    $this->assertEquals(true, $data['checkbox']);
  }

  /**
   * ProjectType::deleteTypesData()
   *
   */
  public function testDeleteTypesData()
  {
    $this->setVars();
    $projectType = ProjectType::where('project_id', $this->project->id)->first();

    $response = ProjectType::deleteTypesData($this->project->id, $projectType->type, 1);
    $this->assertInternalType('int', $response);
    $this->assertEquals(1, $response);
  }

  /**
   * ProjectType::deleteTypesGroup()
   *
   */
  public function testDeleteTypesGroup()
  {
    $this->setVars();
    $response = ProjectType::deleteTypesGroup($this->project->id, $this->projectType);
    $this->assertEquals(true, $response);
  }

  /**
   * ProjectType::deleteAllTypesTables()
   *
   */
  public function testDeleteAllTypesTablesTrue()
  {
    $this->setVars();
    $response = ProjectType::deleteAllTypesTables($this->project->id);
    $this->assertEquals(true, $response);
  }

}
