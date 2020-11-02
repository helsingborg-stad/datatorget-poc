<?php 

namespace HbgStyleGuide\Controller;

use \HbgStyleGuide\Helper\Redirect as Redirect; 
use \HbgStyleGuide\Helper\Curl as Curl;
use \HbgStyleGuide\Helper\User as User;

class Boka Extends BaseController {
  
  public function __construct() {


    parent::__construct(__CLASS__);

    $cpage = isset($_GET['pagination']) ? $_GET['pagination'] : 1; 
    
    $this->data['times'] = $this->getTimes(); 
    $this->data['currentTimes'] = $this->data['times'][$cpage];
    $this->data['pages'] = $this->getPages(count($this->data['times'])); 
  }

  public function getTimes() {

    //Make req
    $curl = new Curl('GET', MS_BOOKING . '/api/v1/resurstid/lista', ['resursId', $_GET['id']]);

    if($curl->isValid) {
      return array_chunk((array) $curl->response, 10);
    }

    return false; 
  }

  public function getPages($max) {
    $stack = array();
    for($i = 0; $i < $max; $i++) {
      $stack[] = ['href' => '?pagination='. ($i+1) .'&id=' . $_GET['id'], 'label' => 'Page ' . $i]; 
    }
    return $stack; 
  }
}