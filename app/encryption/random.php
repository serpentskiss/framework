<?php

/**
 * TITLE HERE
 * 
 * @name        random.php
 * @package     tests.local
 * @version     
 * @since       09-Feb-2017 12:59:44
 * @author      Jon Thompson
 * @abstract    
 */

namespace encryption;

class random {
    /**
     * Customisable options
     */
    var $stringLength              = 12;
    var $hasUpperCase              = TRUE;
    var $hasNumeric                = TRUE;
    var $hasSpecial                = TRUE;
    var $removeConfusingCharacters = TRUE;
    var $mustHaveNumeric           = TRUE;
    var $mustHaveUpperCase         = TRUE;
    var $mustHaveSpecialCharacter  = TRUE;
    var $upperCaseOnly             = FALSE;
    var $serialNumberStyle         = FALSE;
    /**
     * Confusing characters
     */
    private $confusingCharacters = "!1lIoO0.,:;'\"[]{}()";

    /**
     * Character lists
     */
    const SPECIAL_CHARACTERS = "!@$%&*()_-+={}[]:;,.?'\"";
    const ALPHABETICAL       = "abcdefghijklmnopqrstuvwxyz";
    const ALPHABETICAL_UC    = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    const NUMERIC            = "0123456789";
    
    
    function generateString() {
        $stringLength = intval($this->stringLength);
        
        if($stringLength < 1 || $stringLength > 100) {
            $stringLength = 10;
        }
        
        /**
         * Build the string of characters to use
         */
        if($this->serialNumberStyle !== FALSE) {
            $baseString = self::ALPHABETICAL_UC . self::NUMERIC;
        } else {
            if($this->upperCaseOnly !== FALSE) {
                $baseString = self::ALPHABETICAL_UC;
            } else {
                $baseString = self::ALPHABETICAL;
            }

            if($this->hasUpperCase !== FALSE) {
                $baseString .= self::ALPHABETICAL_UC;
            }

            if($this->hasNumeric !== FALSE) {
                $baseString .= self::NUMERIC;
            }

            if($this->hasSpecial !== FALSE) {
                $baseString .= self::SPECIAL_CHARACTERS;
            }
        }
        
        $confusingCharacters = str_split($this->confusingCharacters);
        
        if($this->removeConfusingCharacters === TRUE) {
            $baseString = str_replace($confusingCharacters, "", $baseString);
        }
               
        
        $availableCharacters = str_split($baseString);
        $characterCount      = count($availableCharacters);
        $randomString        = "";
        
        if($this->serialNumberStyle === FALSE) {
            if($this->mustHaveSpecialCharacter === TRUE) {
                $specialCharacters = str_split(str_replace($confusingCharacters, "", self::SPECIAL_CHARACTERS));
                $randomNumber      = self::generateRandomNumber(1, count($specialCharacters)) - 1;
                $randomString     .= $specialCharacters[$randomNumber];
                $stringLength--;
            }
        }
        
        if($this->mustHaveNumeric === TRUE) {
            $numbers       = str_split(str_replace($confusingCharacters, "", self::NUMERIC));
            $randomNumber  = self::generateRandomNumber(1, count($numbers)) - 1;
            $randomString .= $numbers[$randomNumber];
            $stringLength--;
        }

        if($this->mustHaveUpperCase === TRUE) {
            $upperCase     = str_split(str_replace($confusingCharacters, "", self::ALPHABETICAL_UC));
            $randomNumber  = self::generateRandomNumber(1, count($upperCase)) - 1;
            $randomString .= $upperCase[$randomNumber];
            $stringLength--;
        }
        
        for($ct = 0; $ct < $stringLength; $ct++) {
            $randomNumber  = self::generateRandomNumber(1, $characterCount) - 1;
            $randomString .= $availableCharacters[$randomNumber];
        }
        
        if($this->serialNumberStyle !== FALSE) {
            return implode("-", str_split(str_shuffle($randomString), 4));
        } else {
            return str_shuffle($randomString);
        }
    }
    
    
    static function generateRandomNumber($min=1, $max=100) {
        $min = intval($min);
        $max = intval($max);
        
        if($min < 1) {
            $min = 1;
        }
        
        if($max < 1) {
            $max = 100;
        }
        
        $digits = strlen(dechex($max));
        
        if($digits % 2 == 1) {
            $digits++;
        }
        
        $dec = NULL;
        
        while(intval($dec) < $min || intval($dec) > $max) {
            $bytes = openssl_random_pseudo_bytes($digits);
            $hex   = bin2hex($bytes);
            $dec   = hexdec($hex);
        }
        
        return intval($dec);
    }
}