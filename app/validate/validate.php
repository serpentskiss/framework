<?php

/**
 * TITLE HERE
 * 
 * @name        validate.php
 * @package     jukebox2.local
 * @version     
 * @since       29-Dec-2016 09:32:09
 * @author      Jon Thompson
 * @abstract    
 */
namespace validate;

class validate {
    /**
     * Check if a section or action part of a path contains invalid characters
     * 
     * @param string $string The section or action path to test
     * @return boolean
     */
    static function alphaNumeric($string) {
        if(preg_match("/[^a-zA-Z0-9-_]/", $string)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    

    /**
     * Check that a requested section is valid and exists under /site
     * 
     * @param string $section The section to look for
     * @return boolean
     */
    static function sectionPath($section) {
        $path = \config::WEB . "/site/{$section}/";

        if(!file_exists($path) || !is_dir($path)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }


    /**
     * Check that an action.php file exists under the requested section
     * 
     * @param string $section The section to look for
     * @param string $action The name of the PHP file to look for
     * @return boolean
     */
    static function actionPath($section, $action) {
        $path = \config::WEB . "/site/{$section}/{$action}.php";

        if(!file_exists($path) || !is_file($path)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    static function validateURI($URI) {
        if(preg_match("/[^a-zA-Z0-9_-]/", $URI)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    static function validateFilename($filename) {
        if(preg_match("/[^a-zA-Z0-9_.-]/", $filename)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
}