<?php

class ProjectTypeTest extends TestCase {

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
   * Constructor
   *
   */
  function __construct()
  {
    $this->setVars();
  }

  /**
   * Sets our private class vars
   *
   * @return void
   */
  private function setVars()
  {
    $this->projectId = 1;
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
      'id'     => '1',
      'text'   => 'test text',
      'select' => 'test value',
    ];
  }

  /**
   * ProjectType::createTypesGroup()
   *
   */
  public function testCreateTypesGroup()
  {
    $state = ProjectType::createTypesGroup($this->projectId, ['table_name' => $this->projectType]);
    $this->assertTrue($state);
  }

  /**
   * ProjectType::addTypesFields()
   *
   */
  public function testAddTypesFields()
  {
    // Test a success
    $state = ProjectType::addTypesFields($this->projectId, $this->projectType, $this->projectFields);
    $this->assertTrue($state);

    // Test a failure
    $state = ProjectType::addTypesFields(42, 'nope', []);
    $this->assertInternalType('int', $state);
    $this->assertEquals(404, $state);
  }

  /**
   * ProjectType::createTypesData()
   *
   */
  public function testCreateTypesData()
  {
    // Test a success
    $state = ProjectType::createTypesData('example_test', $this->projectData);
    $this->assertTrue($state);

    // Test a failure
    $state = ProjectType::createTypesData('example_derp', $this->projectData);
    $this->assertInternalType('int', $state);
    $this->assertEquals(404, $state);
  }

  /**
   * ProjectType::setBooleanData()
   *
   */
  public function testSetBooleanData()
  {
    // Test setting the checkbox attribute to false
    $data = ProjectType::setBooleanData('example_test', $this->projectData);
    $this->assertInternalType('array', $data);
    $this->assertEquals(false, $data['checkbox']);

    // Test setting the checkbox attribute to true
    $this->projectData['checkbox'] = true;
    $data = ProjectType::setBooleanData('example_test', $this->projectData);
    $this->assertInternalType('array', $data);
    $this->assertEquals(true, $data['checkbox']);
  }

  /**
   * ProjectType::deleteTypesData()
   *
   */
  public function testDeleteTypesData()
  {
    // This needs to be built off of seed data
  }

  /**
   * ProjectType::deleteTypesGroup()
   *
   */
  public function testDeleteTypesGroup()
  {
    $state = ProjectType::deleteTypesGroup($this->projectId, $this->projectType);
    $this->assertEquals(true, $state);
  }

  /**
   * ProjectType::deleteAllTypesTables()
   *
   */
  public function testDeleteAllTypesTables()
  {
    // This needs to be built off of seed data
  }

}
