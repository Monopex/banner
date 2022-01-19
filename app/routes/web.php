<?php

namespace App\Routes;

use App\Core\Routes;
use App\Controllers\IndexController;

class Web extends Routes
{

  public static function start()
  {
    Routes::get('/index1.html', IndexController::class, 'first');
    Routes::get('/index2.html', IndexController::class, 'second');
    Routes::get('/banner.php', IndexController::class, 'banner');
  }
}
