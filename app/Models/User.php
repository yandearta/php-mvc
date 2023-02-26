<?php

namespace App\Models;

use App\Core\Database;

class User extends Database
{
  private static $table = 'users';

  public static function getAll()
  {
    self::query("SELECT * FROM " . self::$table);
    return self::all();
  }

  public static function getById(int $id)
  {
    self::query("SELECT * FROM " . self::$table . " WHERE id = :id");
    self::bind(':id', $id);
    return self::single();
  }
}
