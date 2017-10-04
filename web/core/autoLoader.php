<?php

/**
 * core/autoLoader.php
 * 
 * Class autoloader
 * 
 * @name        autoLoader.php
 * @package     framework.local
 * @version     3.0.0
 * @since       09-May-2017 10:25:58
 * @author      Jon Thompson
 * 
 * Autoload a class without the need to include the file first
 */


// ------------------------------------------------------------------------------
/**
 * In certain situations, we'll not have the config file loaded, so we're 
 * including it here as well
 */
if(file_exists("config.php")) {
    include_once("config.php");
} elseif(file_exists("../config.php")) {
    include_once("../config.php");
} elseif(file_exists(__DIR__ . "/../config.php")) {
    include_once(__DIR__ . "/../config.php");
}

// ------------------------------------------------------------------------------
function autoload($requestedClassName) {
    $className  = ltrim($requestedClassName, '\\');
    $fileName   = '';
    $namespace  = '';

    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace  = substr($className, 0, $lastNsPos);
        $className  = substr($className, $lastNsPos + 1);
        $fileName   = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }

    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

    /**
     * Set the app path to be first, as these can override global stuff
     */
    $include = \config\config::DIR_LIBRARY . "/{$fileName}";

    

    try {
        if (file_exists($include) && is_file($include)) {
            include_once($include);
        } else {
            throw new \customException("Cannot find requested class {$include}");
        }
    } catch (\customException $e) {
        echo $e->httpError(404);
        exit;
    }
    
    
    if (file_exists($include) && is_file($include)) {
        include_once($include);
    } else {
        $http = \config\config::USE_HTTPS === TRUE ? "https" : "http";
        
        $errorData = array( "errorCode"     => 404, 
                            "requestedURI"  => "{$http}://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], 
                            "requestedFile" => $include,
                            "context"       => "Requested class \\{$namespace}\\{$className} not found",
                            "errorMessage"  => "We can't seem to find a file we need to run properly, so we're going to have to stop here"
                );
        try {
            throw new \Exception(json_encode($errorData));
        } catch (\customException $ex) {
            
        }
                            
    }
}


// ------------------------------------------------------------------------------
spl_autoload_register('autoload');
