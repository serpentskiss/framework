<?php

/**
 * TITLE HERE
 * 
 * @name        ops.php
 * @package     git-framework.local
 * @version     
 * @since       03-Oct-2017 16:56:03
 * @author      Jon Thompson
 * @abstract    
 */

namespace file;

class operations {
    
    static function createFolder($path, $mode=0755) {
        if(!mkdir($path, $mode)) {
            return FALSE;
        }
        
        if(self::chmod($path, $mode) === FALSE) {
            return FALSE;
        }
        
        return TRUE;
    }
    
    static function createFile($path, $data='', $mode=0644) {
        $parentFolder = dirname($path);
        
        if(!fileExists($parentFolder) && !is_dir($parentFolder)) {
            return FALSE;
        }
        
        if(!file_put_contents($path, $data)) {
            return FALSE;
        }
        
        if(self::chmod($path, $mode) === FALSE) {
            return FALSE;
        }
        
        return TRUE;
    }
    
    static function chmod($path, $mode) {
        if(!chmod($path, $mode)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
}