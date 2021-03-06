<?php

/**
 * CUSTOM EXCEPTION HANDLER
 * 
 * @name        customErrors.php
 * @package     framework.local
 * @version     
 * @since       10-May-2017 12:03:14
 * @author      Jon Thompson
 * @abstract    Trap all errors thrown from the framework   
 */
error_reporting(E_ALL ^ (E_NOTICE | E_DEPRECATED));
include_once("autoLoader.php");

class customException extends Exception {

    public function errorMessage() {
        $this->httpError();
    }

    /**
     * Display a custom error page
     * 
     * @param int $httpCode The HTTP error code to send with the error page
     */
    public function httpError($httpCode=404) {
        /**
         * Get/set the error page to display. Check in the templates directory 
         * for (in this order)
         * - a {HTTP CODE}.php file
         * - a generic error.php
         * - use the built-in default HTML
         */
        if(file_exists(\config\config::DIR_TEMPLATES . "/" . \config\config::TEMPLATE . "/{$httpCode}.php")) {
            $errorPage = \config\config::DIR_TEMPLATES . "/" . \config\config::TEMPLATE . "/{$httpCode}.php";
        } elseif(file_exists(\config\config::DIR_TEMPLATES . "/" . \config\config::TEMPLATE . "/error.php")) {
            $errorPage = \config\config::DIR_TEMPLATES . "/" . \config\config::TEMPLATE . "/error.php";
        } else {
            $errorPage = <<<EOD
                    <link href="https://fonts.googleapis.com/css?family=Raleway:400,400i,700" rel="stylesheet">
                    <style>
                        html {font-family: "Raleway"}
                        h1 {margin: 0; padding: 0; font-szie: 1.4em; text-align: center; color: #345;}
                        thead tr.header {background-color: #BBC;}
                        table {border-collapse: collapse; border: 1px solid #BBC; width: auto; margin: 10px auto;color: #567;}
                        tbody tr:nth-child(odd) {background-color: #EEF;}
                        td {padding: 3px 10px;}
                    </style>
                    
                    <table>
                        <thead>
                            <tr class='header'>
                                <td colspan='2'><h1>An Error Has Occurred</h1></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>HTTP Code</td>
                                <td>[__HTTP_CODE__] [__HTTP_ERROR__]</td>
                            </tr>
                            <tr>
                                <td>Generated By</td>
                                <td>[__GENERATED_BY__]</td>
                            </tr>
                            <tr>
                                <td>Message</td>
                                <td>[__ERROR_MESSAGE__]</td>
                            </tr>
                            <tr>
                                <td>Trace</td>
                                <td>[__TRACE__]</td>
                            </tr>
                        </tbody>
                    </table>
EOD;
        }
        
        
        ob_start();
        if(file_exists(\config\config::DIR_TEMPLATES . "/" . \config\config::TEMPLATE . "/header.php")) {
            include_once(\config\config::DIR_TEMPLATES . "/" . \config\config::TEMPLATE . "/header.php");
        }
        
        if(file_exists(\config\config::DIR_TEMPLATES . "/" . \config\config::TEMPLATE . "/menu.php")) {
            include_once(\config\config::DIR_TEMPLATES . "/" . \config\config::TEMPLATE . "/menu.php");
        }
        
        if(file_exists($errorPage)) {
            include_once($errorPage);
        } else {
            echo $errorPage;
        }
        
        if(file_exists(\config\config::DIR_TEMPLATES . "/" . \config\config::TEMPLATE . "/footer.php")) {
            include_once(\config\config::DIR_TEMPLATES . "/" . \config\config::TEMPLATE . "/footer.php");
        }

        
        /**
         * Get the error data
         */
        $httpResponse = \http\httpResponse::getCode($httpCode);
        $errorMessage = $this->message;
        $fileName     = str_replace(\config\config::DIR_BASE, "", $this->file);
        $lineNumber   = $this->line;
        
        /**
         * There's sometimes referal data in the trace entries. Use it if available
         */
        $trace     = $this->getTrace();
        $traceLine = $trace[1]["line"];
        $traceFile = str_replace(\config\config::DIR_BASE, "", $trace[1]["file"]);
        $traceText = $traceLine != '' && $traceFile != '' ? "Line {$traceLine} : {$traceFile}" : "None available";
        
        $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
        header($protocol . ' ' . $httpCode . ' ' . $httpResponse["text"]);
        
        $errorPage = ob_get_contents();
        
        /**
         * Replace the template placeholders with real data and display the 
         * error page with an appropriate HTTP response code
         */
        $searchReplace = array(
            "[_BASE_URL_]"                      => \config\config::BASE_URL,
            "[_SITE_NAME_]"                     => \config\config::SITE_NAME,
            "[_META_DATA_]"                     => $metaData,
            "[_SOCIAL_MEDIA_META_DATA_]"        => $socialMediaMetaData,
            "[_CURRENT_DATE_]"                  => $currentDate,
            "[_CURRENT_TIME_]"                  => $currentTime,
            "[__META_PAGE_DESCRIPTION__]"       => $metaPageDescription,
            "[__META_PAGE_KEYWORDS__]"          => $metaPageKeywords,
            "[__META_PAGE_AUTHOR__]"            => $metaPageAuthor,
            "[__PAGE_TITLE__]"                  => $httpCode,
            "[__META_CONTACT_EMAIL_ADDRESS__]"  => \config\config::ADMIN_EMAIL_ADDRESS,
            "[__META_COPYRIGHT__]"              => \config\config::SITE_NAME,
            "[__TWITTER_USER__]"                => $twitterUsername,
            "[__PAGE_URL__]"                    => \config\config::BASE_URL . "{$section}/{$action}",
            "[__FACEBOOK_ADMIN_ID__]"           => $facebookAdminId,
            "[__FACEBOOK_IMAGE_LARGE__]"        => $facebookImageLarge, /* 1200x1200 image */
            "[__TWITTER_IMAGE_LARGE__]"         => $twitterImageLarge,  /* 280x150 image */
            "[__TWITTER_IMAGE_SMALL__]"         => $twitterImageSmall,  /* 120x120 image */
            "[__LINE_NUMBER__]"                 => $lineNumber,
            "[__FILE_NAME__]"                   => $fileName,
            "[__GENERATED_BY__]"                => "Line {$lineNumber} : {$fileName}",
            "[__ERROR_MESSAGE__]"               => str_replace(\config\config::DIR_BASE, "", $errorMessage),
            "[__HTTP_CODE__]"                   => $httpCode,
            "[__HTTP_ERROR__]"                  => $httpResponse["text"],
            "[__TRACE__]"                       => $traceText
        );
        
        $errorPage = str_replace(array_keys($searchReplace), array_values($searchReplace), $errorPage);
        
        
        ob_end_clean();
        
        
        echo $errorPage;
        exit;
    }
}
