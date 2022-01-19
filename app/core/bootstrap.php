<?php

namespace App\Core;

use App\Routes\Web;

class Bootstrap
{

  public static function init()
  {
    Web::start();
  }
}
