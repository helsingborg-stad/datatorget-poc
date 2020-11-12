<?php 

namespace HbgStyleGuide\Controller;

use \HbgStyleGuide\Helper\Redirect as Redirect; 
use \HbgStyleGuide\Helper\Curl as Curl;
use \HbgStyleGuide\Helper\User as User;

class BokaBetala Extends BaseController {
  
  public function __construct() {
    parent::__construct(__CLASS__);

    //Prevent uninlogged users 
    $user = new User();
    if(!$user->isAuthenticated()) {
      new Redirect('/', ['action' => 'not-authenticated']); 
    }

    if(!isset($_GET['id'])) {
      new Redirect('/', ['action' => '404']); 
    }

    //Get data
    $this->data['resourceTimeId'] = base64_encode($_GET['id']);
  }

  /**
   * Card payment action
   *
   * @param array $req
   * @return void
   */
  public function actionCardPayment(array $req) {
    
    $payment = $this->makePayment('swish', $req); 

    if($payment) {
      new Redirect('/boka/klar', ['action' => 'payment-success', 'method' => 'card']); 
    }

    new Redirect('/boka/betala', ['action' => 'payment-error', 'id' => $req['id']]);
  }

  /**
   * Swish payment action
   *
   * @param array $req
   * @return void
   */
  public function actionSwishPayment(array $req) {
    
    $payment = $this->makePayment('swish', $req); 

    if($payment) {
      new Redirect('/boka/klar', ['action' => 'payment-success', 'method' => 'swish']); 
    }

    new Redirect('/boka/betalaswish', ['action' => 'payment-error', 'id' => $req['id']]);
  }

  private function makePayment($method, $req) {
    return true; 
  }
}