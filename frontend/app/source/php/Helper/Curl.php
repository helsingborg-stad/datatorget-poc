<?php

namespace HbgStyleGuide\Helper;

use Jumbojett\OpenIDConnectClient;

class Curl
{
    public $response = false;
    public $isValid = false;

    public function __construct($type, $url, $data = null, $contentType = 'json', $headers = null)
    {
        //Arguments are stored here
        $arguments = null;

        //Oauth 
        if(!isset($_COOKIE['oauthSessionCookie'])) {
            $token = $this->oAuthToken(); 
            if(!empty($token)) {
                setcookie('oauthSessionCookie', $token, time() + (3000), "/");
            }
        } else {
            $token = $_COOKIE['oauthSessionCookie']; 
        }

        if(!is_array($headers)) {
            $headers = []; 
        }
        
        $headers[] = "Authorization: OAuth " . $token;
        
        switch (strtoupper($type)) {
            /**
             * Method: GET
             */
            case 'GET':
                // Append $data as querystring to $url
                if (is_array($data)) {
                    $url .= '?' . http_build_query($data);
                }

                // Set curl options for GET
                $arguments = array(
                    CURLOPT_RETURNTRANSFER      => true,
                    CURLOPT_HEADER              => false,
                    CURLOPT_FOLLOWLOCATION      => true,
                    CURLOPT_SSL_VERIFYPEER      => false,
                    CURLOPT_SSL_VERIFYHOST      => false,
                    CURLOPT_URL                 => $url,
                    CURLOPT_CONNECTTIMEOUT_MS   => 2000,
                );

                break;

            /**
             * Method: POST
             */
            case 'POST':
                // Set curl options for POST
                $arguments = array(
                    CURLOPT_RETURNTRANSFER      => 1,
                    CURLOPT_URL                 => $url,
                    CURLOPT_POST                => 1,
                    CURLOPT_HEADER              => false,
                    CURLOPT_POSTFIELDS          => http_build_query($data),
                    CURLOPT_CONNECTTIMEOUT_MS   => 3000,
                    CURLOPT_REFERER             =>  get_option('home_url')
                );

                break;
        }

        /**
         * Set up external options
         */
        if (isset($this->curlOptions) && !empty($this->curlOptions) && is_array($this->curlOptions)) {
            foreach ($this->curlOptions as $optionName => $optionValue) {
                $arguments[$optionName] = $optionValue;
            }
        }

        /**
         * Set up headers if given
         */
        if ($headers) {
            $arguments[CURLOPT_HTTPHEADER] = $headers;
        }

        /**
         * Do the actual curl
         */
        $ch = curl_init();
        curl_setopt_array($ch, $arguments);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $response = curl_exec($ch);
        curl_close($ch);

        /**
         * json to object
         */
        if($decodedJson = json_decode($response)) {
          $response = (object) $decodedJson; 
        } else {
          $response = false; 
        }

        if(is_object($response) && !empty($response)) {
            if(isset($response->errors) && $response->status != 200) {
                $this->isValid = false;
            } else {
                $this->isValid = true;
            }
        } else {
            $this->isValid = false;
        }

        /**
         * Return the response
         */
        $this->response = $response;
    }

    private function oAuthToken() {

        $oidc = new OpenIDConnectClient(
            'http://datatorget2.helsingborg.se:30099',
            'webui',
            'secret'
        );

        $oidc->providerConfigParam(
            array('token_endpoint'=>'http://datatorget2.helsingborg.se:30099/connect/token')
        );

        $oidc->addScope('datatorget1');

        return $oidc->requestClientCredentialsToken()->access_token;
                
    }
}