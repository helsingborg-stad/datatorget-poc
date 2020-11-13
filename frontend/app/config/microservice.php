<?php

  //Get env vars
  $env = array(
    'MS_BOOKING' => getenv('MS_BOOKING'), 
    'MS_USER' => getenv('MS_USER'),
    'MS_PAYMENT' => getenv('MS_PAYMENT')
  );

  //Define default values
  $default = array(
    'MS_BOOKING' => "http://193.180.109.41:30001", 
    'MS_USER' => "http://193.180.109.41:30002",
    'MS_PAYMENT' => "http://193.180.109.41:30004"
  ); 

  //Fallback to default
  foreach($env as $key => $item) {
    if($item === false) {
      $env[$key] = $default[$key]; 
    }
  }

  //Set
  foreach($env as $key => $item) {
    define($key, $item); 
  }