<?php 

namespace HbgStyleGuide\Controller;

use \HbgStyleGuide\Helper\Redirect as Redirect; 
use \HbgStyleGuide\Helper\Curl as Curl;
use \HbgStyleGuide\Helper\User as User;

class Home Extends BaseController {
 
  public function __construct() {
    parent::__construct(__CLASS__);

    $user = new User();

    if($user->isAuthenticated()) {
      new Redirect('/boka'); 
    }
  }

  /**
   * Login action
   *
   * @param array $req
   * @return void
   */
  public function actionLogin(array $req) {

    //Alwasy set vars that should be used
    $req = (object) array_merge(['pnr' => false], $req); 

    //Validate
    if(!$this->validate::pnr($req->pnr)) {
      new Redirect('/', ['action' => 'registration-error-pnr']); 
    }

    //Make req
    $curl = new Curl('GET', MS_USER . '/api/v1/kund/sokpersonnr', ['personnr' => $req->pnr]); 

    //Check if is valid response
    if($curl->isValid) {

      $user = new User();
      $user->set($curl->response); 

      new Redirect('/boka'); 

    } else {
      new Redirect('/', ['action' => 'login-error']); 
    }
  }
}