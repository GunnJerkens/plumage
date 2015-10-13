<?php

class ProjectAccessTest extends TestCase
{

  /**
   * ProjectAccess::getUserProjects()
   *
   */
  public function testGetUserProjects()
  {
    $response = ProjectAccess::getUserProjects(2);

    $this->assertInternalType('array', $response);
    $this->assertEquals(1, $response[0]);

    $response = ProjectAccess::getUserProjects(999);
    $this->assertFalse($response);
  }

}