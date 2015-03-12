<?php

class ProjectTypeTest extends TestCase {

  public function testCreateTypesGroup() {
    $data['table_name'] = 'test_type';
    $state = ProjectType::createTypesGroup(1, $data);

    $this->assertTrue($state);
  }

}