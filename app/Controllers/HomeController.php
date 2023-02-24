<?php

namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller
{
  public function index(): void
  {
    $this->view('index', ['title' => 'PHP MVC Starter Kit']);
  }
}
