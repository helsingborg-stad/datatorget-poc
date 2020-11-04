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

    if(!isset($_GET['id'])) {
      new Redirect('/', ['action' => '404']); 
    }

    $user = new User();

    $this->data['user'] = $user->get(); 
    
  }
}