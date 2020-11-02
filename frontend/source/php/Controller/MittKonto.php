<?php 

namespace HbgStyleGuide\Controller;

use \HbgStyleGuide\Helper\Redirect as Redirect; 
use \HbgStyleGuide\Helper\Curl as Curl;
use \HbgStyleGuide\Helper\User as User;

class MittKonto Extends BaseController {
  
  public function __construct() {
    parent::__construct(__CLASS__);

    
  }

  /**
   * Login action
   *
   * @param array $req
   * @return void
   */
  public function actionUpdate(array $req) {

    //Set vars that should be used
    $req = (object) array_merge([
      'name' => false,
      'email' => false
    ], $req);

    //Check for login
    $user = new User();
    if(!$user->isAuthenticated()) {
      new Redirect('/mitt-konto', ['action' => 'not-authenticated']); 
    }

    //Validate inputs
    if(!$this->validate::empty($req->name)) {
      new Redirect('/mitt-konto', ['action' => 'registration-error-name']); 
    }
    if(!$this->validate::email($req->email)) {
      new Redirect('/mitt-konto', ['action' => 'registration-error-email']); 
    }

    //Make req
    $curl = new Curl('GET', MS_USER . '/api/v1/kund/uppdatera', [
      'kundnr' => $user->get()->kundnr,
      'namn' => $req->name,
      'epost' => $req->email
    ]);
    
    //Check if is valid response
    if($curl->isValid) {
      new Redirect('/mitt-konto', ['action' => 'update-success']); 
    } else {
      new Redirect('/mitt-konto', ['action' => 'update-error']); 
    }
  }
}