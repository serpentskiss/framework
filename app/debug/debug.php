<?php

/**
 * debug/debug.php
 * 
 * A debugging display class
 * 
 * @name        debug.php
 * @package     framework.local
 * @version     4.0.0
 * @since       09-May-2017 16:22:46
 * @author      Jon Thompson
 * 
 * Display debugging data
 */

namespace debug;

class debug {
    static function dumpServer($title='') {
        ksort($_SERVER);
        $data = print_r($_SERVER, TRUE);
        $html = self::terminalHtml($data, $title);
        
        echo $html;
    }
    
    static function terminalHtml($data, $title='') {
        if($title != "") {
            $title = " : $title";
        }
        
        $html = "
        <link rel='stylesheet' href='/css/font-awesome.min.css'>
        <link rel='stylesheet' href='/css/terminal.css'>
        <div class='terminal'>
            <div class='header'>Debugging Data Dump{$title}</div>
            <div class='home'><i class='fa fa-floppy-o' aria-hidden='true'></i></div>
            <div class='body'><pre>{$data}</pre></div>
        </div>";
        
        return $html;
    }
}