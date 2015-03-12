<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase {

  /**
   * Creates the application.
   *
   * @return \Symfony\Component\HttpKernel\HttpKernelInterface
   */
  public function createApplication() {
    $unitTesting = true;
    $testEnvironment = 'testing';

    return require __DIR__.'/../../bootstrap/start.php';

    Session::start();
    Route::enableFilters();
  }

  public function setUp() {
    parent::setUp();
    DB::beginTransaction();
    Mail::pretend();
  }

  public function tearDown() {
    parent::tearDown();
    DB::rollback();
  }

}
