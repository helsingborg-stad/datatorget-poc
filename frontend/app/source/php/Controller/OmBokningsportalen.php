<?php 

namespace HbgStyleGuide\Controller;

use \HbgStyleGuide\Helper\Redirect as Redirect; 
use \HbgStyleGuide\Helper\Curl as Curl;
use \HbgStyleGuide\Helper\User as User;

class OmBokningsportalen Extends BaseController {
  public function __construct() {
    $this->data['apis'] = [
      ['text' => 'Bokning', 'href' => MS_BOOKING . "/swagger/index.html"],
      ['text' => 'Användare', 'href' => MS_USER . "/swagger/index.html"],
      ['text' => 'Betalning', 'href' => MS_PAYMENT . "/swagger/index.html"]
    ]; 
  }
}