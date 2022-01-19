<?php

namespace App\Core;

class Request
{
  /**
   * @return string
   */
  public function user_agent (): string
  {
    return $_SERVER['HTTP_USER_AGENT'];
  }

  /**
   * @return string
   */
  public function referer ()
  {
    $referer = '';
    $referer = @$_SERVER['HTTP_REFERER'];
    return $referer;
  }

  /**
   * @return string
   */
  public function ip (): string
  {
    $ip  = $_SERVER['REMOTE_ADDR'];
    $ip  = (@$_SERVER['HTTP_CLIENT_IP'])? $_SERVER['HTTP_CLIENT_IP']: $ip;
    $ip  = (@$_SERVER['HTTP_X_FORWARDED_FOR'])? $_SERVER['HTTP_X_FORWARDED_FOR']: $ip;
    return $ip;
  }
}
