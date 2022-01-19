<?php

namespace App\Core;
/*
	@DataBase
*/

use \PDO;
use \PDOException;
use App\Core\ENV;

class DataBase
{
  private static $PDO;
  private $table_name = '';
  private $query = '';
  private $set_update = '';
  private $where_data = '';
  private $where_data_i = 0;
  private $prepare_data = [];
  private $function_field = [];

  public function __construct(string $table)
  {
    $this->table_name = $table;
  }

  private static function connect()
  {
    if (!empty(self::$PDO)) return;
    try {
      self::$PDO = new PDO(
        ENV::get('DB_TYPE') . ':host=' . ENV::get('DB_HOST') . ';dbname=' . ENV::get('DB_NAME'),
        ENV::get('DB_USERNAME'),
        ENV::get('DB_PASSWORD')
      );
      self::$PDO->query("SET NAMES utf8");
    } catch (PDOException $Exception) {
      echo 'Ошибка подключения';
    }
  }

  /**
   * @param $field
   * @return string
   */
  private function INET_ATON(string $field): string
  {
    return 'INET_ATON(' . $field . ')';
  }

  /**
   * @param $field
   * @return string
   */
  private function INET_NTOA(string $field): string
  {
    return 'INET_NTOA(' . $field . ')';
  }

  /**
   * @param $field
   * @return string
   */
  public function convert_ip(string $field): object
  {
    $this->function_field[$field] = 'INET_ATON';
    return $this;
  }

  /**
   * @param $field
   * @return string
   */
  public function ip(string $field): object
  {
    $this->function_field[$field] = 'INET_NTOA';
    return $this;
  }

  private function run()
  {
    $result_set = self::$PDO->prepare($this->query);
    $result_set->execute($this->prepare_data);
    return $result_set->fetch(PDO::FETCH_OBJ);
  }

  /**
   * @param $field
   * @return object
   */
  public function get_exists(string $field): int
  {
    $this->query = 'SELECT `' . $field . '` FROM ' . $this->table_name . ' WHERE ' . $this->where_data;
    $response = $this->run();
    return ($response === false) ? 0 : $response->id;
  }

  /**
   * @param $table
   * @return object
   */
  public static function table(string $table): object
  {
    DataBase::connect();
    return new DataBase($table);
  }

  /**
   * @param $field
   * @param $value1
   * @param $value2
   */
  public function where(string $field, $value1, $value2 = null)
  {
    $sign = '=';
    if ($value2 !== null) {
      $sign = $value1;
      $value1 = $value2;
    }
    if (strlen($this->where_data) > 0) {
      $this->where_data .= ' AND ';
    }
    $function_name = $this->function_field[$field];
    $this->where_data .= (!empty($function_name)) ? $this->$function_name('`' . $field . '`') : '`' . $field . '`';
    $this->where_data .= $sign . ' :field_' . $this->where_data_i;
    $this->prepare_data[':field_' . $this->where_data_i] = $value1;
    $this->where_data_i++;
    return $this;
  }

  /**
   * @param $field
   * @return object
   */
  public function increment(string $field): object
  {
    $this->set_update .= ' `' . $field . '`=`' . $field . '` + 1';
    return $this;
  }

  /**
   * @param $fields
   */
  public function create(array $fields)
  {
    $query = 'INSERT INTO ' . $this->table_name . ' (';
    $Keys = ''; // Храняться поля к которым обращаемся
    $Value = ''; // Храняться значения которые записываем
    foreach ($fields as $k => $v) {
      $function_name = $this->function_field[$k];
      $Keys .= '`' . $k . '`,';
      $Value .= (!empty($function_name)) ? $this->$function_name(':' . $k) . ',' : ':' . $k . ',';
    }
    $Keys = substr($Keys, 0, -1);
    $Value = substr($Value, 0, -1);
    $query .= $Keys . ') VALUES (' . $Value . ')';

    $this->prepare_data = $fields;
    $this->query = $query;
    $this->run();
  }

  /**
   * @param $fields
   */
  public function update(array $fields)
  {
    $query = 'UPDATE ' . $this->table_name . ' SET ';
    $prepare = [];
    foreach ($fields as $k => $v) {
      $query .= '`' . $k . '` = :' . $k . ',';
      $prepare[':' . $k] = $v;
    }
    $this->prepare_data = array_merge($prepare, $this->prepare_data);
    $this->query = substr($query, 0, -1);
    if (!empty($this->set_update)) $this->query .= ', ' . $this->set_update;
    $this->query .= ' WHERE ' . $this->where_data;
    $this->run();
  }

  public function __destruct()
  {
    $this->PDO = null;
  }
}
