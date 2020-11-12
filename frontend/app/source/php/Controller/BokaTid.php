<?php 

namespace HbgStyleGuide\Controller;

use \HbgStyleGuide\Helper\Redirect as Redirect; 
use \HbgStyleGuide\Helper\Curl as Curl;
use \HbgStyleGuide\Helper\User as User;

class BokaTid Extends BaseController {
  
  public function __construct() {
    
    parent::__construct(__CLASS__);

    //Prevent uninlogged users 
    $user = new User();
    if(!$user->isAuthenticated()) {
      new Redirect('/', ['action' => 'not-authenticated', 'origin' => 'bokatid']); 
    }

    //Check if id exists
    if(!isset($_GET['id'])) {
      new Redirect('/', ['action' => '404', 'origin' => 'bokatid']); 
    }

    //Get current page
    $cpage = isset($_GET['pagination']) ? $_GET['pagination'] : 1; 
    
    //Get avabile times
    $this->data['times']    = $this->getTimes();
    $this->data['roomName'] = $this->getRoomName();

    //Roomname not found
    if(!$this->data['roomName']) {
      new Redirect('/', ['action' => '404', 'origin' => 'bokatid']); 
    }

    //Check response
    if($this->data['times']) {
      $this->data['pages']        = $this->getPages(count($this->data['times'])); 
      $this->data['currentTimes'] = $this->data['times'][$cpage];
    } else {
      $this->data['currentTimes'] = [];
      $this->data['pages']        = false;
    }
    
  }

  /**
   * Get the room name
   *
   * @return string | false
   */
  public function getRoomName() {
    
    $curl = new Curl('GET', MS_BOOKING . '/api/v1/resurs/hamta', [
      'resursId' => $this->decodeData($_GET['id'])
    ]);

    if($curl->isValid == true) {
      return $curl->response->namn;
    } 

    return false; 

  }

  /**
   * Get avabile times
   *
   * @return void
   */
  public function getTimes() {

    //Make req
    $curl = new Curl('GET', MS_BOOKING . '/api/v1/resurstid/lista', [
      'resursId' => $this->decodeData($_GET['id'])
    ]);

    if($curl->isValid == true) {

      //Check if valid
      foreach($curl->response as &$item) {

        //Translate data
        $item->uid = $this->encodeData($item->resurstidId);
        $item->day = date("j F Y", strtotime($item->startTid));
        $item->startTime = date("H:i", strtotime($item->startTid));
        $item->endTime = date("H:i", strtotime($item->slutTid));
        $item->isAvailable = (bool) $item->tillganglig;
        $item->bookingNumber = (int) $item->bokningsnr;
        $item->passTrough = $this->encodeData($item);

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

  /**
   * Pagination wathcer
   *
   * @param   int    $max        Max pages to render
   * @return  array  $stack      The link stack
   */
  public function getPages($max) {
    $stack = array();
    for($i = 1; $i < $max; $i++) {
      $stack[] = ['href' => '?pagination='. ($i) .'&id=' . $_GET['id'], 'label' => 'Page ' . $i]; 
    }
    return $stack; 
  }

  /**
   * Registeres booking
   *
   * @param array $req
   * @return void
   */
  public function actionMakeBooking($req) {

    //Verify signature
    if(isset($req['data']) && base64_decode($req['data'], true)) {
      $req['data'] = $this->decodeData($req['data']);
    } else {
      new Redirect('/boka/tid', ['action' => 'payment-error-id', 'origin' => 'bokatid']); 
    }

    //Make accessable
    $bookingData = $req['data']; 

    //Get user data
    $user = new User();

    //Make req
    $curl = new Curl('GET', MS_BOOKING . '/api/v1/bokning/skapa', [
      'resursid' => $bookingData->resursId,
      'startTid' => $bookingData->startTid,
      'slutTid' => $bookingData->slutTid,
      'kundnr' => $user->get()->kundnr
    ]); 

    //Check if is valid response
    if($curl->isValid) {
      new Redirect('/boka/betala', [
        'id'    => $this->encodeData($req['bookingid']),
        'response' => $this->encodeData($curl->response),
        'origin' => 'bokatid'
      ]); 
    } else {
      new Redirect('/boka/tid', ['action' => 'payment-order-error', 'origin' => 'bokatid']); 
    }
  }
}