<?php

namespace App\Core;
use App\Core\Request;

class Routes
{
  private static $query_string;

  // Route::get('/payment-success', [PaymentResultController::class, 'paymentSuccess']);
  /**
   * @param $name
   * @param $class
   * @param $method
   * @return void
   */
  public static function get(string $path, string $class, string $method): void
  {
    if (empty(self::$query_string)) self::$query_string = str_replace('?'.$_SERVER['QUERY_STRING'], '', $_SERVER['REQUEST_URI']);
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && self::$query_string == $path) {
      try {
        $params = [
          new Request()
        ];
        $new_class = new $class();
        $result = call_user_func_array([$new_class, $method], $params);
      } catch (\Throwable $th) {
        throw $th;
      }
      if (!empty($result)) {
        echo $result;
      }
      die;
    }
  }
}
