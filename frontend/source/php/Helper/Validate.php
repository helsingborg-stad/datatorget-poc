<?php

namespace HbgStyleGuide\Helper;

class Validate
{
    public static function pnr($string)
    {   
        if(preg_replace('/\D/', '', $string) == $string) {
            if(strlen($string) == 10) {
                return true; 
            }
        }

        return false; 
    }

    public static function empty($string)
    {
        return (bool) !empty($string); 
    }

    public static function email($string)
    {  
        if (filter_var($string, FILTER_VALIDATE_EMAIL)) {
            return true; 
        }
        return false; 
    }
}
