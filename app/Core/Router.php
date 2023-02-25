<?php

namespace App\Core;

class Router
{
  /**
   * Routes list
   */
  private static array $routes = [];

  /**
   * Add route to routes list
   */
  public static function add(string $method, string $path, string $controller, string $function, array $middlewares = []): void
  {
    // Add route to routes array
    self::$routes[] = [
      'method' => $method,
      'path' => $path,
      'controller' => $controller,
      'function' => $function,
      'middlewares' => $middlewares
    ];
  }

  /**
   * Return 404 page not found
   */
  public static function not_found(string|null $message = null): void
  {
    http_response_code(404);

    if ($message) die($message);

    // Set 404 page path
    $not_found_page = __DIR__ . '/../../app/Views/404.php';

    // Die if 404 page doesn't exist
    if (!file_exists($not_found_page)) die("<p>404 Page not found</p>");

    // Return 404 page
    die(require $not_found_page);
  }

  /**
   * Run routes
   */
  public static function run(): void
  {
    // Set default path
    $path = '/';

    // Set path & method if it exists
    if (isset($_SERVER['PATH_INFO'])) $path = filter_var($_SERVER['PATH_INFO'], FILTER_SANITIZE_URL);
    $method = $_SERVER['REQUEST_METHOD'];

    // Check if route exists
    foreach (self::$routes as $route) {
      /**
       * Replace {} & {int} with regex
       * Example: /users/{} => /users/([0-9a-zA-Z]*)
       * Example: /users/{int} => /users/([0-9]*)
       */
      $route['path'] = str_replace("{}", "([0-9a-zA-Z]*)", $route['path']);
      $route['path'] = str_replace("{int}", "([0-9]*)", $route['path']);
      $pattern = '#^' . $route['path'] . '$#';

      if (preg_match($pattern, $path, $params) && $method === $route['method']) {
        // Run middlewares
        foreach ($route['middlewares'] as $middleware) {
          $middleware = new $middleware;
          $middleware->handle();
        }

        $controller = new $route['controller'];
        $function = $route['function'];

        if (!method_exists($controller, $function)) {
          self::not_found('<p><b>Error: </b>Method <b>' . $route['function'] . '</b> doesn\'t exist in <b>' . $route['controller']) . '</b></p>';
        }

        array_shift($params);
        // Run Controller & Function, and send Params if exists
        call_user_func_array([$controller, $function], $params);
        return;
      }
    }

    // Return 404 if route doesn't exist
    self::not_found();
  }
}
