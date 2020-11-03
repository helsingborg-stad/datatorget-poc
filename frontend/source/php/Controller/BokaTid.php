<?php 

namespace HbgStyleGuide\Controller;

use \HbgStyleGuide\Helper\Redirect as Redirect; 
use \HbgStyleGuide\Helper\Curl as Curl;
use \HbgStyleGuide\Helper\User as User;

class BokaTid Extends BaseController {
  
  public function __construct() {
    parent::__construct(__CLASS__);

    if(!isset($_GET['id'])) {
      new Redirect('/', ['action' => '404']); 
    }

    $cpage = isset($_GET['pagination']) ? $_GET['pagination'] : 1; 
    
    $this->data['times'] = $this->getTimes(); 
    $this->data['roomName'] = $this->getRoomName(); 

    if(!$this->data['roomName']) {
      new Redirect('/', ['action' => '404']); 
    }

    //Check response
    if($this->data['times']) {
      $this->data['pages'] = $this->getPages(count($this->data['times'])); 
      $this->data['currentTimes'] = $this->data['times'][$cpage];
    } else {
      $this->data['currentTimes'] = [];
      $this->data['pages'] = false;
    }
    
  }

  public function getRoomName() {
    
    $curl = new Curl('GET', MS_BOOKING . '/api/v1/resurs/hamta', [
      'resursId' => $_GET['id']
    ]);

    if($curl->isValid == true) {
      return $curl->response->namn;
    } 

    return false; 

  }

  public function getTimes() {

    //Make req
    $curl = new Curl('GET', MS_BOOKING . '/api/v1/resurstid/lista', [
      'resursId' => $_GET['id']
    ]);

    if($curl->isValid == true) {

      //Check if valid
      foreach($curl->response as &$item) {

        //Translate data
        $item->uid = base64_encode($item->resurstidId); 
        $item->day = date("j F Y", strtotime($item->startTid)); 
        $item->startTime = date("H:i", strtotime($item->startTid)); 
        $item->endTime = date("H:i", strtotime($item->slutTid)); 
        $item->isAvailable = (bool) $item->tillganglig; 
        $item->bookingNumber = (int) $item->bokningsnr; 

        //Remove untranslated
        unset($item->startTid);
        unset($item->slutTid);
        unset($item->resurstidId);
        unset($item->bokningsnr);
        unset($item->tillganglig);
      }

      return array_chunk((array) $curl->response, 10);
    }

    return false; 
  }

  public function getPages($max) {
    $stack = array();
    for($i = 1; $i < $max; $i++) {
      $stack[] = ['href' => '?pagination='. ($i) .'&id=' . $_GET['id'], 'label' => 'Page ' . $i]; 
    }
    return $stack; 
  }
}