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
}
