<?php
ini_set('display_errors','off');
define('GLOBAL_DIR', __DIR__);
spl_autoload_register(function ($class) {
  $path = str_replace('\\', '/', strtolower($class));
  $file_path = GLOBAL_DIR.'/'.$path.'.php';
  if (file_exists($file_path)) require_once $file_path;
});

use App\Core\Bootstrap;
Bootstrap::init();
