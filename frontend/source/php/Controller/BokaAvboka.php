<?php 

namespace HbgStyleGuide\Controller;

use \HbgStyleGuide\Helper\Redirect as Redirect; 
use \HbgStyleGuide\Helper\Curl as Curl;
use \HbgStyleGuide\Helper\User as User;

class BokaAvboka Extends BaseController {
 
  public function __construct() {
    parent::__construct(__CLASS__);

    if(!isset($_GET['id'])) {
      new Redirect('/mitt-konto', ['action' => 'unbooking-error']); 
    }
  }

  /**
   * Card payment action
   *
   * @param array $req
   * @return void
   */
  public function actionUnbook(array $req) {
    

    new Redirect('/mitt-konto', ['action' => 'unbooking-success']); 
  }
}