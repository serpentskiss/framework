<?php

/**
 * index.php
 * 
 * The main controller for the framework
 * 
 * @name        index.php
 * @package     framework.local
 * @version     4.0.0
 * @since       08-May-2017 16:58:13
 * @author      Jon Thompson
 * 
 * Routes all URIs through here to serve the site
 */


// ------------------------------------------------------------------------------
/**
 * Initialise the framework
 */
require_once(dirname(__FILE__) . "/config.php");
require_once(\config\config::DIR_WEB . "/bootstrap.php");

if(\config\config::DEBUG === TRUE) {
    \debug\debug::dumpServer("Server Vars");
}

try {
    if(!file_exists(\config\config::DIR_INCLUDES . "/parser.php")) {
        throw new customException("Cannot find core file parser.php");
    } else {
        require_once(\config\config::DIR_INCLUDES . "/parser.php");
    }
} catch (customException $e) {
    echo $e->httpError(404);
    exit;
}

try {
    if(!file_exists(\config\config::DIR_INCLUDES . "/loader.php")) {
        throw new customException("Cannot find core file loader.php");
    }  else {
        require_once(\config\config::DIR_INCLUDES . "/loader.php");
    }
} catch (customException $e) {
    echo $e->httpError(404);
    exit;
}
