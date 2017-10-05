<?php

/**
 * AN EXAMPLE HTML HEADER TEMPLATE
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
        <!-- +--------------------------------------------------------------+
             | Shim for older versions of IE                                |
             +--------------------------------------------------------------+ -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <!-- +--------------------------------------------------------------+
             | Meta Tags                                                    |
             +--------------------------------------------------------------+ -->
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'>
        <meta name="description" content="[__META_PAGE_DESCRIPTION__]">
        <meta name="keywords" content="[__META_PAGE_KEYWORDS__]">
        <meta name="author" content="[__META_PAGE_AUTHOR__]">
        <meta name="web-author" content="[__META_PAGE_AUTHOR__]">
        <meta name="robots" content="index, follow">
        <meta name="revisit-after" content="1 month">
        <meta name="abstract" content="[__META_PAGE_DESCRIPTION__]">
        <meta name="contact" content="[__META_CONTACT_EMAIL_ADDRESS__]">
        <meta name="copyright" content="[__META_COPYRIGHT__]">
        <meta name="googlebot" content="noodp">
        <meta name="language" content="English">
        
        <!-- +--------------------------------------------------------------+
             | Social Media Meta Tags                                       |
             +--------------------------------------------------------------+ -->
        <meta property="og:title" content="[__PAGE_TITLE__]" />
        <meta property="og:url" content="[__PAGE_URL__]" />
        <meta property="og:site_name" content="[_SITE_NAME_]" />
        <meta property="og:type" content="article" />
        <meta property="og:image" content="[__FACEBOOK_IMAGE_LARGE__]" />
        <meta property="og:description" content="[__META_PAGE_DESCRIPTION__]" />
        <meta property="fb:admins" content="[__FACEBOOK_ADMIN_ID__]" />
        
        <meta name="twitter:card" content="[__TWITTER_IMAGE_LARGE__]" />
        <meta name="twitter:site" content="[_SITE_NAME_]" />
        <meta name="twitter:title" content="[__PAGE_TITLE__]" />
        <meta name="twitter:description" content="[__META_PAGE_DESCRIPTION__]" />
        <meta name="twitter:creator" content="[__TWITTER_USER__]" />
        <meta name="twitter:image" content="[__TWITTER_IMAGE_SMALL__]" />
        <meta name="twitter:image:src" content="[__TWITTER_IMAGE_LARGE__]">
        
        <meta itemprop="name" content="[__PAGE_TITLE__]">
        <meta itemprop="description" content="[__META_PAGE_DESCRIPTION__]">
        <meta itemprop="image" content="[__FACEBOOK_IMAGE_LARGE__]">
        
        <!-- +--------------------------------------------------------------+
             | Javascript plugins                                           |
             +--------------------------------------------------------------+ -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>                       <!-- jQuery -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>                 <!-- jQuery Forms -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.7.1/clipboard.min.js"></script>              <!-- Copy To Clipboard -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.8.1/prism.min.js"></script>                         <!-- Prism Syntax Highlighting -->
        
        <!-- +--------------------------------------------------------------+
             | CSS                                                          |
             +--------------------------------------------------------------+ -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css" />           <!-- CSS Reset -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" /> <!-- Font Awesome -->
        <link rel="stylesheet" href="/css/php.css?<?php echo time(); ?>">
        
        <!-- +--------------------------------------------------------------+
             | Icons                                                        |
             +--------------------------------------------------------------+ -->
        <link rel="icon" type="image/png" href="" sizes="32x32">
        
        
        <title>[__PAGE_TITLE__]</title>
    </head>
    <body>
        <main id='main'>
            <p>The header</p>