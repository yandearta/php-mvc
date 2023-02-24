<?php

namespace App\Models;

use App\Core\Database;

class User
{
  private $table = 'users';
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  public function getAll()
  {
    $this->db->query("SELECT * FROM $this->table");
    return $this->db->all();
  }

  public function getById(int $id)
  {
    $this->db->query("SELECT * FROM $this->table WHERE id = :id");
    $this->db->bind('id', $id);
    return $this->db->single();
  }
}
