<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2016 OA Wu Design
 */

class Tinypngs extends Site_controller {

  public function clean () {
    Tinypng::update_all (array (
        'set' => 'quantity = 0',
      ));
  }
  public function index ($psw = '') {
    if ($psw != md5 (Cfg::setting ('psws', 'tingpng')))
      return $this->output_json (array (
          'status' => false,
        ));

    if (!$tinypng = Tinypng::find ('one', array ('select' => 'id,`key`,quantity', 'conditions' => array ('quantity < quota'))))
      return $this->output_json (array (
          'status' => false
        ));

    $tinypng->quantity += 1;
    $tinypng->save ();

    return $this->output_json (array (
        'status' => true,
        'key' => $tinypng->key
      ));
  }
}
