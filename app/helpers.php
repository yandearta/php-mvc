<?php

// Get config value from config file
if (!function_exists('config')) {
  function config($key, $default = null)
  {
    // Load config file data into an array
    $config = require __DIR__ . '/../config/app.php';

    // Split the key into segments
    $segments = explode('.', $key);

    // Loop through the segments
    foreach ($segments as $segment) {
      // If the segment doesn't exist, return the default value
      if (!isset($config[$segment])) return $default;

      // Otherwise, set the config to the value of the segment
      $config = $config[$segment];
    }

    // Return the config
    return $config;
  }
}

// Get base url
if (!function_exists('get_base_url')) {
  function get_base_url()
  {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $base_url = $protocol . $_SERVER['HTTP_HOST'];
    return $base_url;
  }
}
