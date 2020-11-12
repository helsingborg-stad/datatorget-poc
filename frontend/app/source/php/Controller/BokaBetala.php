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

    if(!isset($_GET['response'])) {
      new Redirect('/', ['action' => '404', 'origin' => 'bokabetala']); 
    }
  }

  /**
   * Card payment action
   *
   * @param array $req
   * @return void
   */
  public function actionCardPayment(array $req) {
    
    $payment = $this->makePayment('card', $req); 

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

  /**
   * Worlds most refined and awesome payment method. 
   * Or a peice of junk. 
   *
   * @param string $method
   * @param array $req
   * @return void
   */
  private function makePayment($method, $req) {
    
    //Decide response 
    $response = $this->decodeData($req['response']); 

    //Get current user
    $user = new User();

    //Make req
    $curl = new Curl('GET', MS_PAYMENT . '/api/v1/betalorder/sok', [
      'referens' => $response->bokningsnr,
      'kundnr' => $user->get()->kundnr
    ]); 

    //Check if is valid response
    if($curl->isValid) {

      $curl->response = (array) $curl->response; 

      if(isset($curl->response[0])) {
        
        $latest = $curl->response[0]; 
     
        $curl = new Curl('GET', MS_PAYMENT . '/api/v1/betalorder/betala', [
          'betalorderid' => $latest->betalorderid,
          'belopp' => ($latest->beloppTotalt - $latest->beloppBetalt)
        ]); 
     
        if($curl->isValid) {
          return true; 
        }
     
      }

    }

    return false; 
  }
}