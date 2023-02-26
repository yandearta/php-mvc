<?php

namespace App\Core;

use PDO;
use PDOException;
use PDOStatement;

class Database
{
  // PDO instance
  private static ?PDO $pdo;

  // PDO statement
  private static ?PDOStatement $stmt;

  public static function init()
  {
    $db_connection = config('db.connection');
    $db_host = config('db.host');
    $db_port = config('db.port');
    $db_database = config('db.database');
    $db_username = config('db.username');
    $db_password = config('db.password');

    // Data Source Name
    $dsn = "$db_connection:host=$db_host;port=$db_port;dbname=$db_database";

    // Set PDO options
    $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

    try {
      self::$pdo = new PDO($dsn, $db_username, $db_password, $options);
    } catch (PDOException $e) {
      exit("Database connection failed: " . $e->getMessage());
    }
  }

  /**
   * Prepare statement with query
   */
  protected static function query(string $query)
  {
    self::$stmt = self::$pdo->prepare($query);
  }

  /**
   * Binds a value to a parameter
   */
  protected static function bind(string $param, string|int|bool|null $value)
  {
    $type = PDO::PARAM_STR;
    if (is_int($value)) $type = PDO::PARAM_INT;
    if (is_bool($value)) $type = PDO::PARAM_BOOL;
    if (is_null($value)) $type = PDO::PARAM_NULL;

    self::$stmt->bindValue($param, $value, $type);
  }

  /**
   * Execute the prepared statement
   */
  protected static function execute()
  {
    return self::$stmt->execute();
  }

  /**
   * Get result set as array of objects
   */
  protected static function all()
  {
    self::execute();
    return self::$stmt->fetchAll(PDO::FETCH_OBJ);
  }

  /**
   * Get single record as object
   */
  protected static function single()
  {
    self::execute();
    return self::$stmt->fetch(PDO::FETCH_OBJ);
  }
}
