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
   * Unbook
   *
   * @param array $req
   * @return void
   */
  public function actionUnbook(array $req) {
  
    $curl = new Curl('GET', MS_BOOKING . '/api/v1/bokning/avboka', [
      'bokningsnr' => $this->decodeData($_GET['id'])
    ]);

    if($curl->isValid == true) {
      new Redirect('/mitt-konto', ['action' => 'unbooking-success']); 
    } 

    new Redirect('/mitt-konto', ['action' => 'unbooking-error']); 
    
  }
}