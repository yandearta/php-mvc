<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
  private $db_connection;
  private $db_host;
  private $db_port;
  private $db_username;
  private $db_password;
  private $db_name;

  // Database Handler
  private $dbh;

  // Statement
  private $stmt;

  public function __construct()
  {
    $this->db_connection = config('db.connection');
    $this->db_host = config('db.host');
    $this->db_port = config('db.port');
    $this->db_name = config('db.database');
    $this->db_username = config('db.username');
    $this->db_password = config('db.password');

    // Data Source Name
    $dsn = "$this->db_connection:host=$this->db_host;port=$this->db_port;dbname=$this->db_name";

    // Set PDO options
    $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

    try {
      $this->dbh = new PDO($dsn, $this->db_username, $this->db_password, $options);
    } catch (PDOException $e) {
      die($e->getMessage());
    }
  }

  /**
   * Prepare statement with query
   */
  public function query(string $query)
  {
    $this->stmt = $this->dbh->prepare($query);
  }

  /**
   * Binds a value to a parameter
   */
  public function bind(string $param, string|int|bool|null $value)
  {
    $type = PDO::PARAM_STR;
    if (is_int($value)) $type = PDO::PARAM_INT;
    if (is_bool($value)) $type = PDO::PARAM_BOOL;
    if (is_null($value)) $type = PDO::PARAM_NULL;

    $this->stmt->bindValue($param, $value, $type);
  }

  /**
   * Execute the prepared statement
   */
  public function execute()
  {
    try {
      return $this->stmt->execute();
    } catch (PDOException $e) {
      die($e->getMessage());
    }
  }

  /**
   * Get result set as array of objects
   */
  public function all()
  {
    $this->execute();
    return $this->stmt->fetchAll(PDO::FETCH_OBJ);
  }

  /**
   * Get single record as object
   */
  public function single()
  {
    $this->execute();
    return $this->stmt->fetch(PDO::FETCH_OBJ);
  }
}
