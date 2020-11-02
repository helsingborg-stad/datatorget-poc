<?php 

namespace HbgStyleGuide\Controller;

use \HbgStyleGuide\Helper\Redirect as Redirect; 
use \HbgStyleGuide\Helper\Curl as Curl;
use \HbgStyleGuide\Helper\Validate as Validate;

abstract class BaseController {

  protected $data;
  protected $action = null;
  protected $Validate; 

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