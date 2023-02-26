<?php

namespace App\Core;

class View
{
  /**
   * Load view located in Views folder
   */
  public static function render(string $view, array $data = [])
  {
    extract($data);
    require __DIR__ . "/../../views/$view.php";
  }
}
