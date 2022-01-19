<?php

namespace App\Core;

/**
 * Class ENV
 * @property string DB_TYPE
 * @property string DB_HOST
 * @property string DB_NAME
 * @property string DB_PREFIX
 * @property string DB_USERNAME
 * @property string DB_PASSWORD
 */
class ENV
{

  /**
   * @var array
   */
  private static $data = [];

  private static function init()
  {
    $file = file_get_contents(GLOBAL_DIR . '/.env');
    foreach (explode(PHP_EOL, $file) as $line) {
      if (strlen($line) > 0) {
        $params = explode('=', $line);
        if (strlen($params[0]) > 0) {
          self::$data[$params[0]] = $params[1];
        }
      }
    }
  }

  /**
   * @param $name
   * @return string
   */
  public static function get(string $name): string
  {
    if (empty(self::$data)) self::init();
    return self::$data[$name] ?? '';
  }
}
