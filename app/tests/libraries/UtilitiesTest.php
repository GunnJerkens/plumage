<?php

class UtilitiesTest extends TestCase
{

  /**
   * Utilities::checkEmpty()
   *
   * @return void
   */
  public function testCheckEmpty()
  {
    $array = [
      "bool"    => true,
      "string"  => "string",
      "object"  => new StdClass(),
      "integer" => 1,
      "test"    => "test"
    ];

    // Test a single dimension array
    $response = Utilities::checkEmpty($array);
    $this->assertTrue($response);

    $array['test'] = "";
    $response = Utilities::checkEmpty($array);
    $this->assertFalse($response);

    // Test a nested array
    $array['test'] = ["one" => "string", "two" => "string"];
    $response = Utilities::checkEmpty($array);
    $this->assertTrue($response);

    $array['test']['one'] = "";
    $response = Utilities::checkEmpty($array);
    $this->assertFalse($response);

    // Test a multi dimension array
    $array['test']['one'] = ["one" => "string", "two" => "string"];
    $response = Utilities::checkEmpty($array);
    $this->assertTrue($response);

    $array['test']['one']['two'] = "";
    $response = Utilities::checkEmpty($array);
    $this->assertFalse($response);
  }

}