<?php

use App\Controllers\HomeController;
use App\Core\Router;

Router::add('GET', '/', HomeController::class, 'index');
