<?php

/**
 * core/routes.php
 * 
 * Static routes
 * 
 * @name        routes.php
 * @package     framework.local
 * @version     
 * @since       09-May-2017 11:24:15
 * @author      Jon Thompson
 * 
 * Static routes that bypass the templating system. Used when a script is called 
 * eg via jQuery from another script, or a POST processor
 */

$routes = array(
    "error/404",
    "error/403",
);