<?php

namespace Database\Classes;

use Database\Classes\Connection as Connection;

class Query extends Connection
{
  /**
   * Execute query to database
   * 
   * @var string
   */
  public function query (string $sql)
  {
    return $this->db_conn->query($sql);
  }

  /**
   * Insert item in database
   * 
   * @param   string
   * @param   array
   * @return  boolean
   */
  public function _insert (string $table, array $data)
  {
    return $this->db_conn->query(
      "INSERT INTO {$table} (" . implode(',', array_keys($data)) . ") VALUES (" . $this->array_values_string($data) . ");"
    );
  }

  /**
   * Get item by where clue
   * 
   * @param   string
   * @param   array
   * @return  array
   */
  public function _where (string $table, array $where = null, int $limit = null)
  {
    return $this->db_conn->query(
      "SELECT * FROM {$table} WHERE " . ($where === null ? "1" : $this->array_keys_values($where)) . "  ORDER BY `id` DESC " . ($limit === null ? "" : " LIMIT {$limit};") . ""
    );
  }

  /**
   * Count number records in table
   * 
   * @param   string
   * @param   array
   * @return  array
   */
  public function _count(string $table, array $where = null)
  {
    return $this->db_conn->query("SELECT COUNT(*) AS count FROM {$table} WHERE " . ($where === null ? "1" : $this->array_keys_values($where)));
  }

  /**
   * Updated item in database
   * 
   * @param   string
   * @param   array
   * @param   array
   * @return  array
   */
  public function _update (string $table, array $where, array $data)
  {
    return $this->db_conn->query(
      "UPDATE {$table} SET " . $this->array_keys_values($data) . " WHERE " . $this->array_keys_values($where) . ";"
    );
  }

  /**
   * Delete item in database
   * 
   * @param   string
   * @param   array
   * @return  array
   */
  public function _delete (string $table, array $where)
  {
    return $this->db_conn->query(
      "DELETE FROM {$table} WHERE " . $this->array_keys_values($where) . ";"
    );
  }

  /**
   * Convert array to values string
   * 
   * @param   array
   * @return  string
   */
  public function array_values_string (array $data)
  {
    $string = "";
    $len = count($data) - 1;
    $values = array_values($data); // get array values

    for ($i = 0; $i < count($data); $i++)
    {
      if ($i !== $len) $string .= "'" . $values[$i] . "'" . ",";
      if ($i === $len) $string .= "'" . $values[$i] . "'";
    }

    return $string;
  }

  /**
   * Convert array key value & pair to string
   */
  public function array_keys_values (array $data)
  {
    $string = "";
    $len = count($data) - 1;
    $array_keys = array_keys($data); // get array keys
    $array_values = array_values($data); // get array values
    
    for ($i = 0; $i < count($data); $i++)
    {
      if ($i !== $len) $string .= $array_keys[$i] . "=" . "'" . $array_values[$i] . "'" . ",";
      if ($i === $len) $string .= $array_keys[$i] . "=" . "'" . $array_values[$i] . "'";
    }
    
    return $string;
  }

}
