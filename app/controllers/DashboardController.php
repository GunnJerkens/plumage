<?php

class DashboardController extends Controller {

  /**
   * Handles GET requests for /dashboard
   *
   * @return view
   */
  public function getDashboard() {
    return View::make('layouts.dashboard');
  }

  /**
   * Handles GET requests for /mapper
   *
   * @return view
   */
  public function getMapper() {
    return View::make('layouts.mapper');
  }
}
