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
    /**
     * Create a new folder
     * 
     * @param string $path The full path to the folder
     * @param octal $mode The permissions to set IN OCTAL
     * @return boolean
     */
    static function createFolder($path, $mode=0755) {
        $path = realpath($path);
        
        if(!mkdir($path, $mode)) {
            return FALSE;
        }
        
        if(self::chmod($path, $mode) === FALSE) {
            return FALSE;
        }
        
        return TRUE;
    }
    
    /**
     * Create and write data to a file
     * 
     * @param string $path The full path to the file, including filename
     * @param string $data The data to write to the file
     * @param octal $mode The permissions to set IN OCTAL
     * @return boolean
     */
    static function createFile($path, $data='', $mode=0644) {
        $path         = realpath($path);
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
    
    /**
     * Set permissions on a file or folder
     * 
     * @param string $path The ful path to the file or folder to modify
     * @param octal $mode The permissions to set IN OCTAL
     * @return boolean
     */
    static function chmod($path, $mode) {
        $path = realpath($path);
        
        if(!chmod($path, $mode)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
}