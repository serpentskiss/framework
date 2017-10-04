<?php

/**
 * parser.php
 * 
 * @name        parser.php
 * @package     framework.local
 * @version     4.0.0
 * @since       09-May-2017 12:03:22
 * @author      Jon Thompson
 * 
 * Parses the requested URL and validates it
 */


// ------------------------------------------------------------------------------
/**
 * Get some relevant server variables
 */
$HTTP_HOST      = $_SERVER["HTTP_HOST"];
$QUERY_STRING   = $_SERVER["QUERY_STRING"];
$REMOTE_ADDR    = $_SERVER["REMOTE_ADDR"];
$REQUEST_METHOD = $_SERVER["REQUEST_METHOD"];
$REQUEST_SCHEME = $_SERVER["REQUEST_SCHEME"];
$REQUEST_TIME   = $_SERVER["REQUEST_TIME"];
$REQUEST_URI    = $_SERVER["REQUEST_URI"];


// ------------------------------------------------------------------------------
/**
 * Redirect if we're forcing https and it's not being used
 */
if(\config\config::USE_HTTPS === TRUE && $REQUEST_SCHEME != "https") {
    header("Location:https://{$HTTP_HOST}{$REQUEST_URI}");
    exit;
}


// ------------------------------------------------------------------------------
/**
 * Parse the requested URI
 */
list($section, $action, $data) = explode("/", trim($REQUEST_URI, "/"), 3);


/**
 * We require 3 parts to be passed to the framework. If any are missing, set 
 * them to default
 */
if($section == "") {
    $section = "default";
} else {
    $section = urldecode($section);
}

if($action == "") {
    $action = "default";
} else {
    $action = urldecode($action);
}

if($data == "") {
    $data = NULL;
}


// ------------------------------------------------------------------------------
/**
 * Validate the section and action parts. ALPHANUMERIC ONLY! The data part can 
 * contain anything, so we should validate that in the PHP script that is being 
 * called, not here
 */
try {
    if(!\validate\validate::validateURI($section) || !\validate\validate::validateURI($action)) {
        throw new customException("The page you've requested can't be found. Are you sure it's correct?</p><p>Click <a href='" . \config\config::BASE_URL . "'>here</a> to go back to the homepage");
    }
} catch (customException $e) {
    echo $e->httpError(404);
    exit;
}


// ------------------------------------------------------------------------------
/**
 * Certain directories are protected. Stop any attempts to access them
 */
try {
    if(in_array($section, $protectedDirectories)) {
        throw new customException("Attempt to directly access a protected directory");
    }
} catch (customException $e) {
    echo $e->httpError(403);
    exit;
}


// ------------------------------------------------------------------------------
/**
 * Make sure the requested parts exist
 */
try {
    if(!file_exists(\config\config::DIR_SITE . "/{$section}") && !is_dir(\config\config::DIR_SITE . "/{$section}")) {
        throw new \customException("Requested section {$section} not found");
    } 
} catch (\customException $e) {
    echo $e->httpError(404);
    exit;
}

try {
    if(!file_exists(\config\config::DIR_SITE . "/{$section}/{$action}.php") && !is_file(\config\config::DIR_SITE . "/{$section}/{$action}.php")) {
        throw new customException("Requested page {$section}/{$action} not found");
    }
} catch (customException $e) {
    echo $e->httpError(404);
    exit;
}