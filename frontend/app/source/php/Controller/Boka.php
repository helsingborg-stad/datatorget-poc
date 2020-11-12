<?php 

namespace HbgStyleGuide\Controller;

use \HbgStyleGuide\Helper\Redirect as Redirect; 
use \HbgStyleGuide\Helper\Curl as Curl;
use \HbgStyleGuide\Helper\User as User;

class Boka Extends BaseController {
  public function __construct() {
    new Redirect('/boka/resurs'); 
  }
}