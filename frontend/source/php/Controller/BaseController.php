<?php 

namespace HbgStyleGuide\Controller;

use \HbgStyleGuide\Helper\Redirect as Redirect; 
use \HbgStyleGuide\Helper\Curl as Curl;
use \HbgStyleGuide\Helper\Validate as Validate;
use \HbgStyleGuide\Helper\User as User;

abstract class BaseController {

  public $data = [];
  protected $action = null;
  protected $validate; 

  /**
   * Define that __construct should exists in all classes inherit 
   */
  public function __construct($child) {

    $this->validate = new Validate(); 

    //Listen for actions 
    $this->action = $this->initActionListener(); 

    //Trigger action 
    if(method_exists($child, "action".ucfirst($this->action))) {
      $this->{"action".ucfirst($this->action)}($_REQUEST); 
    }

    //Trigger global action
    if(method_exists(__CLASS__, "action".ucfirst($this->action))) {
      $this->{"action".ucfirst($this->action)}($_REQUEST); 
    }

    //Add usr obj
    $this->data['user'] = $this->getUserData();
  }

  public function actionLogout() {
    $user = new User();
    $user->logout(); 
    new Redirect('/', ['action' => 'logoutmsg']); 
  }

  /**
   * Get userdata to view
   *
   * @return void
   */
  public function getUserData() {
    $user = new User();
    if($user->isAuthenticated()) {
      return $user->get(); 
    } else {
      return false; 
    }
  }

  /**
   * Returns data from instance
   *
   * @return array
   */
  public function getData() : array 
  {
    return (array) $this->data; 
  }

  /**
   * Inits action listener
   *
   * @return void
   */
  public function initActionListener() {
    if(isset($_GET['action'])) {
      return $this->action = $_GET['action'];
    }
    return $this->action = false; 
  }
}