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

    public function httpError($httpCode=404) {
        $httpResponse = \http\httpResponse::getCode($httpCode);
        $errorMessage = $this->message;
        $fileName = str_replace(\config\config::DIR_BASE, "", $this->file);
        $lineNumber = $this->line;
        
        if(file_exists(\config\config::DIR_TEMPLATES . "/" . \config\config::TEMPLATE . "/{$httpCode}.php")) {
            $errorPage = file_get_contents(\config\config::DIR_TEMPLATES . "/" . \config\config::TEMPLATE . "/{$httpCode}.php");
        } elseif(file_exists(\config\config::DIR_TEMPLATES . "/" . \config\config::TEMPLATE . "/error.php")) {
            $errorPage = file_get_contents(\config\config::DIR_TEMPLATES . "/" . \config\config::TEMPLATE . "/error.php");
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
                                <td>__HTTP_CODE__ __HTTP_ERROR__</td>
                            </tr>
                            <tr>
                                <td>File</td>
                                <td>__FILE_NAME__</td>
                            </tr>
                            <tr>
                                <td>Line</td>
                                <td>__LINE_NUMBER__</td>
                            </tr>
                            <tr>
                                <td>Message</td>
                                <td>__ERROR_MESSAGE__</td>
                            </tr>
                        </tbody>
                    </table>
EOD;
        }
        
        $searchReplace = array(
            "__LINE_NUMBER__"   => $lineNumber,
            "__FILE_NAME__"     => $fileName,
            "__ERROR_MESSAGE__" => $errorMessage,
            "__HTTP_CODE__"     => $httpCode,
            "__HTTP_ERROR__"    => $httpResponse["text"]
        );
        
        $errorPage = str_replace(array_keys($searchReplace), array_values($searchReplace), $errorPage);
        
        $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
        header($protocol . ' ' . $httpCode . ' ' . $httpResponse["text"]);
        echo $errorPage;
        
        exit;
    }
}
