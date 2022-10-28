<?php

class Simple_Limited_Access_utils
{
  public function getCurrentLogFile($file = 'access.log')
  {
    $upload_dir = wp_upload_dir();
    if (isset($upload_dir['basedir']) and isset($upload_dir['subdir'])) {
      $dir = $upload_dir['basedir'] . '/simple-limited-access' . $upload_dir['subdir'];
      if (!is_dir($dir)) {
        wp_mkdir_p($dir);
      }
      return $dir . '/' . $file;
    }
    return false;
  }


  public function checkUsrPwd($usr, $pwd)
  {
    if (get_option('simple_limited_access_list')) {
      $skuList = explode(PHP_EOL, get_option('simple_limited_access_list'));
      $result = array_map('trim', $skuList);
      foreach ($result as $key => $coppia) {
        $u = explode(':', $coppia);
        if (count($u) == 2) {
          $result[$key] = strtolower($u[0]) . ':' . $u[1];
        }
      }
      if (in_array(strtolower($usr) . ':' . $pwd, $result)) {
        return true;
      }
    }
    return false;
  }
}
