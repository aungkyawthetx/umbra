<?php

require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Core/Database.php';

class UserController extends Controller
{
  public function terms()
  {
    $this->view('pages/terms');
  }
}