<?php 

namespace HbgStyleGuide\Controller;

use \HbgStyleGuide\Helper\Redirect as Redirect; 
use \HbgStyleGuide\Helper\Curl as Curl;

class RegistreraKonto Extends BaseController {
  public function __construct() {
    parent::__construct(__CLASS__);
  }

  /**
   * Login action
   *
   * @param array $req
   * @return void
   */
  public function actionRegister(array $req) {

    //Set vars that should be used
    $req = (object) array_merge([
      'name' => false,
      'pnr' => false,
      'email' => false,
    ], $req);

    if(!$this->validate::pnr($req->pnr)) {
      new Redirect('/registrera-konto', ['action' => 'registration-error-pnr']); 
    }
    
    //Make req
    $curl = new Curl('GET', MS_USER . '/api/v1/kund/skapa', [
      'namn' => $req->name,
      'personnr' => $req->pnr,
      'epost' => $req->email
    ]);

    //Check if is valid response
    if($curl->isValid) {
      new Redirect('/', ['action' => 'registration-success']); 
    } else {
      new Redirect('/', ['action' => 'registration-error']); 
    }
  }
}