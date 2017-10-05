<?php

/**
 * core/settings.php
 * 
 * Settings
 * 
 * @name        settings.php
 * @package     framework.local
 * @version     4.0.0
 * @since       09-May-2017 16:19:26
 * @author      Jon Thompson
 * 
 * Miscellaneous settings
 */

// ------------------------------------------------------------------------------
/**
 * These directories have no direct URL access to them
 */
$protectedDirectories = array(
    "site",
    "core",
    "includes",
    "uploads"
);


/**
 * HTML template variable default values for non-config data
 */
$metaData               = "";
$socialMediaMetaData    = "";
$currentDate            = date("l jS F, Y");
$currentTime            = date("h:i:s a");
$metaPageDescription = '';
$metaPageKeywords = '';
$metaPageAuthor = '';
$pageTitle = '';
$twitterUsername = '';
$facebookAdminId = '';
$facebookImageLarge = '';
$twitterImageLarge = '';
$twitterImageSmall = '';


/**
 * Misc
 */
$allowedImageTypes = array(
    "jpg",
    "jpeg",
    "png",
    "gif"
);

date_default_timezone_set("Europe/London");
