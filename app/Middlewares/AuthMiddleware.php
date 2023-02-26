<?php

namespace App\Middlewares;

use App\Core\View;

class AuthMiddleware
{
  function handle(): void
  {
    if (!isset($_SESSION['user'])) {
      View::redirect(config('app.base_url') . '/login');
    }
  }
}
