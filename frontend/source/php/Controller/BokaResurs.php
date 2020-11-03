<?php 

namespace HbgStyleGuide\Controller;

use \HbgStyleGuide\Helper\Redirect as Redirect; 
use \HbgStyleGuide\Helper\Curl as Curl;
use \HbgStyleGuide\Helper\User as User;

class BokaResurs Extends BaseController {
  
  public function __construct() {
    parent::__construct(__CLASS__);
    
    $this->data['locations'] = $this->getLocations(); 
  }

  public function getLocations() {

    //Make req
    $curl = new Curl('GET', MS_BOOKING . '/api/v1/resurs/lista', []);
    
    if($curl->isValid) {
      return $curl->response;
    }

    return false; 
  }
}