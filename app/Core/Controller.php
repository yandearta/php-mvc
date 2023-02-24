<?php

namespace App\Core;

class Controller
{
  /**
   * Load view located in Views folder
   */
  public function view(string $view, array $data = [])
  {
    extract($data);
    require_once __DIR__ . "/../../views/$view.php";
  }

  /**
   * Load model located in Models folder
   */
  public function model(string $model)
  {
    $model = "App\Models\\$model";
    return new $model;
  }
}
