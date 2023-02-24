<?php

namespace App\Middlewares;

class AuthMiddleware
{
  function handle(): void
  {
    if (!isset($_SESSION['user'])) {
      die(header('Location: ' . config('app.base_url') . '/login'));
    }
  }
}
