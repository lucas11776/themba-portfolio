<?php

namespace Database;

use PDO;
use Database\Classes\Query as Query;

class Db extends Query
{
  /**
   * Create new record in table
   * 
   * @param   string
   * @param   array
   * @return  boolean
   */
  public function create (string $table, array $data)
  {
    return $this->_insert($table, $data);
  }

  /**
   * Get record in table
   * 
   * @param   string
   * @param   array
   * @return  boolean
   */
  public function get (string $table, array $where = null, int $limit = null)
  {
    return $this->_where($table, $where, $limit)->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Update record in table
   * 
   * @param   string
   * @param   array
   * @param   array
   * @return  boolean
   */
  public function update (string $table, array $where, array $data)
  {
    return $this->_update($table, $where, $data);
  }

  /**
   * Count number of records in database
   * 
   * @param   string
   * @return  boolean
   */
  public function count(string $table, array $where = null)
  {
    return $this->_count($table, $where)->fetch(PDO::FETCH_ASSOC);
  }

  /**
   * Delete record in table
   * 
   * @param   string
   * @param   array
   * @return  boolean
   */
  public function delete (string $table, array $where)
  {
    return $this->_delete($table, $where);
  }
}
