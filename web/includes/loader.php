<?php

/**
 * loader.php
 * 
 * @name        loader.php
 * @package     framework.local
 * @version     4.0.0
 * @since       09-May-2017 12:04:35
 * @author      Jon Thompson
 * 
 * Calls in the scripts that generate the HTML output that the user will see
 */


// ------------------------------------------------------------------------------
/**
 * Check if the requested URI is part of our routing section, and load it in now 
 * if it is
 */
if(count($routes)) {
    if(in_array("{$section}/{$action}", $routes)) {
        include_once(\config\config::DIR_SITE . "/{$section}/{$action}.php");
        exit;
    }
}


// ------------------------------------------------------------------------------
/**
 * Check for cached content
 */
$fileToInclude  = \config\config::DIR_SITE . "/{$section}/{$action}.php";
$htmlOut        = "";
$foundCache     = FALSE;
$cacheFileName  = \config\config::DIR_CACHE . "/{$section}_{$action}";

if(\config\config::USE_CACHE === TRUE) {
    /**
     * Check the cache dir exists
     */
    if(!file_exists(\config\config::DIR_CACHE) && !is_dir(\config\config::DIR_CACHE)) {
        mkdir(\config\config::DIR_CACHE, 0775, TRUE);
        chmod(\config\config::DIR_CACHE, 0775);
        $foundCache = FALSE;
    } elseif(file_exists($cacheFileName)) {
        $htmlOut = $cacheFileName;
        $foundCache = TRUE;
    }
}


// ------------------------------------------------------------------------------
/**
 * If we haven't found a cached version, load the requested page in via the 
 * templates as normal
 */
if($foundCache !== TRUE) {
    ob_start();
    
    if(file_exists(\config\config::DIR_TEMPLATES . "/" . \config\config::TEMPLATE . "/header.php")) {
        $requiredFiles[] = \config\config::DIR_TEMPLATES . "/" . \config\config::TEMPLATE . "/header.php";
    }
    
    if(file_exists(\config\config::DIR_TEMPLATES . "/" . \config\config::TEMPLATE . "/menu.php")) {
        $requiredFiles[] = \config\config::DIR_TEMPLATES . "/" . \config\config::TEMPLATE . "/menu.php";
    }
    
    $requiredFiles[] = $fileToInclude;
    
    if(file_exists(\config\config::DIR_TEMPLATES . "/" . \config\config::TEMPLATE . "/footer.php")) {
        $requiredFiles[] = \config\config::DIR_TEMPLATES . "/" . \config\config::TEMPLATE . "/footer.php";
    }

    
    foreach($requiredFiles as $requiredFile) {
        try {
            if(!file_exists($requiredFile)) {
                throw new \customException("We can't seem to find the required file " . basename($requiredFile));
            } else {
                include_once($requiredFile);
            }
        } catch (\customException $e) {
            echo $e->httpError(404);
            exit;
        }
    }
    
    $htmlOut = ob_get_contents();
    ob_end_clean();
}


// ------------------------------------------------------------------------------
/**
 * Search/replace on template variables
 */
$searchReplace = [
    "[_BASE_URL_]"                  => \config\config::BASE_URL,
    "[_SITE_NAME_]"                 => \config\config::SITE_NAME,
    "[_META_DATA_]"                 => $metaData,
    "[_SOCIAL_MEDIA_META_DATA_]"    => $socialMediaMetaData,
    "[_CURRENT_DATE_]"              => $currentDate,
    "[_CURRENT_TIME_]"              => $currentTime
];

$finalHtml = str_replace(array_keys($searchReplace), array_values($searchReplace), $htmlOut);


// ------------------------------------------------------------------------------
/**
 * If caching is required and allowed by the script being included, save the file
 */
if(\config\config::USE_CACHE === TRUE && !defined("DO_NOT_CACHE") && !file_exists($cacheFileName)) {
    file_put_contents($cacheFileName, $finalHtml);
}


// ------------------------------------------------------------------------------
echo $finalHtml;
exit;