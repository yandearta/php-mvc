<?php

use App\Core\Router;

// Start session
if (!session_id()) session_start();

// Load packages
require_once __DIR__ . '/../vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

// Set app default timezone
date_default_timezone_set(config('app.timezone'));

// Load routes
require_once __DIR__ . '/../routes/web.php';

// Run routes
Router::run();
