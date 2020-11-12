<?php

namespace HbgStyleGuide\Helper;

class User
{
    private $authCookieName = "dataportalen_auth_cookie"; 
    private $authLength = 60 * 60 * 10;

    public function set($data) {
        setcookie($this->authCookieName, json_encode($data), time() + $this->authLength, "/"); 
    }

    public function isAuthenticated() {
        return (bool) $this->get(); 
    }

    public function get() {
        if(isset($_COOKIE[$this->authCookieName])) {
            $data = json_decode($_COOKIE[$this->authCookieName]); 

            if(is_object($data) && !empty($data) && isset($data->kundnr)) {

                $curl = new Curl('GET', MS_USER . '/api/v1/kund/sokkundnr', [
                    'kundnr' => $data->kundnr
                ]);

                return (object) $curl->response; 
            }
        }
        return false; 
    }

    public function logout() {
        setCookie($this->authCookieName, null, -1, "/"); 
    }
}