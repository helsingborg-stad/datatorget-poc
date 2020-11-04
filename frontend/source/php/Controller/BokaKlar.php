<?php 

namespace HbgStyleGuide\Controller;

use \HbgStyleGuide\Helper\Redirect as Redirect; 
use \HbgStyleGuide\Helper\Curl as Curl;
use \HbgStyleGuide\Helper\User as User;

class BokaKlar Extends BaseController {
 
  public function __construct() {
    parent::__construct(__CLASS__);

    if(!isset($_GET['id'])) {
      new Redirect('/', ['action' => 'payment-error']); 
    }
  }

  /**
   * Card payment action
   *
   * @param array $req
   * @return void
   */
  public function actionCardPayment(array $req) {
    $this->makePayment('swish', $req); 
  }

  /**
   * Swish payment action
   *
   * @param array $req
   * @return void
   */
  public function actionSwishPayment(array $req) {
    $this->makePayment('swish', $req); 
  }

  private function makePayment($method, $req) {

    

  }
}