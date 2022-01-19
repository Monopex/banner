<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Controller;
use App\Core\DataBase;

class IndexController extends Controller
{
  public function first(Request $request)
  {
    return $this->Template('index1.html');
  }

  public function second()
  {
    return $this->Template('index2.html');
  }

  public function banner(Request $request)
  { // Stop SOLID, Going down to hell
    $id = DataBase::table('views_log')
      ->ip('ip_address')
      ->where('ip_address', $request->ip())
      ->where('user_agent', $request->user_agent())
      ->where('page_url', $request->referer())
      ->get_exists('id');
    if ($id > 0) {
      DataBase::table('views_log')
        ->ip('ip_address')
        ->where('id', $id)
        ->increment('views_count')
        ->update([
          'view_date' => date('Y-m-d H:i:s')
        ]);
    } else {
      DataBase::table('views_log')
        ->convert_ip('ip_address')
        ->create([
          'ip_address' => $request->ip(),
          'user_agent' => $request->user_agent(),
          'view_date' => date('Y-m-d H:i:s'),
          'page_url' => $request->referer(),
        ]);
    }
    $file_name = str_replace('.html', '', array_pop(
      explode('/', $request->referer())
    ));
    $this->Image($file_name.'.png');
  }
}
