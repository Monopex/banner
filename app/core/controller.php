<?php

namespace App\Core;

class Controller
{

  /**
   * @param $path
   */
  public function Image(string $path)
  {
    header('Content-type: image/png');
    readfile(GLOBAL_DIR . '/storage/' . $path);
  }

  /**
   * @param $name
   * @return string
   */
  public function Template(string $name): string
  {
    return file_get_contents(GLOBAL_DIR . '/templates/' . $name);
  }
}
