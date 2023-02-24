<?php

return [
  // Application configuration
  'app' => [
    'base_url' => $_ENV['APP_BASE_URL'] ?? get_base_url(),
    'timezone' => $_ENV['APP_TIMEZONE'] ?? 'Asia/Jakarta'
  ],

  // Database configuration
  'db' => [
    'connection' => $_ENV['DB_CONNECTION'] ?? 'mysql',
    'host' => $_ENV['DB_HOST'] ?? 'localhost',
    'port' => $_ENV['DB_PORT'] ?? '3306',
    'database' => $_ENV['DB_DATABASE'] ?? 'db',
    'username' => $_ENV['DB_USERNAME'] ?? 'root',
    'password' => $_ENV['DB_PASSWORD'] ?? ''
  ]
];
