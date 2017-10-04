<?php

/**
 * TITLE HERE
 * 
 * @name        header.php
 * @package     framework.local
 * @version     
 * @since       09-May-2017 14:47:12
 * @author      Jon Thompson
 * @abstract    
 */

?>
<html>
    <head>
        <meta charset='utf-8'>
        <meta  name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'>
        <link rel="icon" type="image/png" href="http://remote.jonthompson.co.uk/generic/images/gearIcon.png" sizes="32x32">
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <meta name="description" content="Full-height, single-column responsive template with fixed header and footer">
        <meta name="keywords" content="full-height, single-column, responsive, html template, fixed header, fixed footer">
        <meta name="author" content="Jon Thompson">

        <title><?php echo \config\config::SITE_NAME; ?></title>

        
        <script src="/js/jquery.js"></script>
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css" />
        <link rel="stylesheet" href="/css/font-awesome.min.css">
        <link rel="stylesheet" href="/css/php.css?<?php echo time(); ?>">
        
    </head>
    <body>
        <main id='main'>
            <p>The header</p>