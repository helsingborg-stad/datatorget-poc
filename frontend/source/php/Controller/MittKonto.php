<?php 

namespace HbgStyleGuide\Controller;

use \HbgStyleGuide\Helper\Redirect as Redirect; 
use \HbgStyleGuide\Helper\Curl as Curl;
use \HbgStyleGuide\Helper\User as User;

class MittKonto Extends BaseController {
  
  public function __construct() {
    parent::__construct(__CLASS__);

    //Check for login
    $user = new User();
    if(!$user->isAuthenticated()) {
      new Redirect('/', ['action' => 'not-authenticated']); 
    }

    $this->data['bookings'] = $this->getMyBookings($user->get()->kundnr); 
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

    //Validate inputs
    if(!$this->validate::empty($req->name)) {
      new Redirect('/mitt-konto', ['action' => 'registration-error-name']); 
    }
    if(!$this->validate::email($req->email)) {
      new Redirect('/mitt-konto', ['action' => 'registration-error-email']); 
    }

    $user = new User(); 

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

  public function getMyBookings($knr) {

    //Make req
    $curl = new Curl('GET', MS_BOOKING . '/api/v1/bokning/lista', [
      //'kundnr' => $knr
    ]);
    
    if($curl->isValid) {
      //Check if valid
      foreach($curl->response as &$item) {

        $resource = new Curl('GET', MS_BOOKING . '/api/v1/resurs/hamta', [
          'resursId' => $item->resurstider[0]->resursId
        ]);

        if($resource->isValid) {
            $resourceName = $resource->response->namn; 
        } else {
          $resourceName = "Okänd resurs"; 
        }

        //Translate data
        $item->uid = base64_encode($item->bokningsnr); 
        $item->day = date("j F Y", strtotime($item->startTid)); 
        $item->startTime = date("H:i", strtotime($item->startTid)); 
        $item->endTime = date("H:i", strtotime($item->slutTid)); 
        $item->isPaid = (bool) $item->betald; 
        $item->isCanceled = (bool) $item->avbokad; 
        $item->passTrough = base64_encode(json_encode($item)); 
        $item->resourceName = $resourceName; 

        //Remove untranslated
        unset($item->startTid);
        unset($item->slutTid);
        unset($item->bokningsnr);
        unset($item->tillganglig);
      }

      array_reverse((array) $curl->response); 

      return (object) $curl->response; 

    }

    return false; 
  }
}