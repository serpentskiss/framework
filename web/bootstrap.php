<?php

/**
 * bootstrap.php
 * 
 * Bootstrap loader
 * 
 * @name        bootstrap.php
 * @package     framework.local
 * @version     4.0.0
 * @since       08-May-2017 16:58:09
 * @author      Jon Thompson
 * 
 * File to call in other required files, needed for the normal operation of the 
 * framework
 */

$bootstrapFiles = [
    /*"core/errorReporting.php",*/ 
    "core/customErrors.php",
    "core/autoLoader.php", 
    "core/routes.php",
    "core/settings.php"
    ];


foreach($bootstrapFiles as $bootstrapFile) {
    if(!file_exists(dirname(__FILE__) . "/{$bootstrapFile}")) {
        $errorMessage = "We can't seem to find a file we need to run properly, so we're going to have to stop here.";
        $logMessage   = date("Y-m-d H:i:s") . " : Cannot find file " . dirname(__FILE__) . "/{$bootstrapFile}\n";
        include_once("basicErrorReport.php");
        exit;
    } else {
        require_once($bootstrapFile);
    }
}

