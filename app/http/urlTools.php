<?php

/**
 * TITLE HERE
 * 
 * @name        urlTools.php
 * @package     git-framework.local
 * @version     
 * @since       03-Oct-2017 15:30:47
 * @author      Jon Thompson
 * @abstract    
 */

namespace http;

class urlTools {
    
    /**
     * Slugify a string for use in a URL
     * 
     * @param string $string The text to slugify
     * @param boolean|int $maxLength The maximum length for the returned slug. Set to TRUE to use the entire string, or an integer to truncate it
     * @return string The slugified text
     */
    static function slugify($string, $maxLength=25) {
        // Set the length of the return
        if($maxLength === "TRUE") {
            $maxLength = strlen($string);
        } elseif(intval($maxLength) < 1) {
            $maxLength = 20;
        } else {
            $maxLength = intval($maxLength);
        }
        
        // Capitalise each word we find
        $parts = explode(" ", preg_replace("/\s+/", " ", $string));
        
        foreach($parts as &$part) {
            $part = ucwords($part);
        } 
        
        $formattedString = implode(" ", $parts);
        
        // Remove any non-alphanumeric characters to make it URL-friendly
        $searchReplace = array(
            "/\s+/" => "-",
            "/[^a-zA-Z0-9 _+-]/" => ""
        );
        
        return substr(preg_replace(array_keys($searchReplace), array_values($searchReplace), $formattedString), 0, $maxLength);
    }
}