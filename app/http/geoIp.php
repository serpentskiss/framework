<?php

/**
 * TITLE HERE
 * 
 * @name        geoip.php
 * @package     jonthompson.co.uk.local
 * @version     
 * @since       01-Feb-2017 10:50:29
 * @author      Jon Thompson
 * @abstract    
 */
namespace http;

class geoIp {
    /**
     * Retrieve geolocation info from ipinfo.io
     * 
     * @param string $ipAddress The IP address to look up
     * @return array
     * @throws \Exception
     */
    static function ipinfo_io($ipAddress) {
        $ipAddress = trim($ipAddress);
        
        if(filter_var($ipAddress, FILTER_VALIDATE_IP) === FALSE) {
            throw new \Exception("You don't appear to have a valid IP address - odd!");
        }
        
        $ipAddress = str_replace("-", ".", $ipAddress);
        $url       = "http://ipinfo.io/{$ipAddress}/json";
        
        $curl                 = new \http\curl;
        $curl->url            = $url;
        $curl->spoofUserAgent = TRUE;
        $curl->reuseCookies   = TRUE;
        $return               = $curl->getPage();
        
        if ($return === FALSE) {
            throw new \Exception($curl->error);
        }
        
        $data = json_decode($return, TRUE);
    
        $geoIp["ipAddress"]     = $ipAddress;
        $geoIp["hostname"]      = gethostbyaddr($ipAddress);
        $geoIp["city"]          = $data["city"];
        $geoIp["region"]        = $data["region"];
        $geoIp["regionName"]    = NULL;
        $geoIp["country"]       = NULL;
        $geoIp["countryCode"]   = $data["country"];
        list($lon, $lat)        = explode(",", $data["loc"]);
        $geoIp["lon"]           = floatval($lon);
        $geoIp["lat"]           = floatval($lat);
        $geoIp["as"]            = $data["org"];
        $geoIp["isp"]           = NULL;
        $geoIp["timezone"]      = NULL;
        $geoIp["zip"]           = NULL;
        
        return $geoIp;
    }
    static function ip_api_com($ipAddress) {
        $ipAddress = trim($ipAddress);
        
        if(filter_var($ipAddress, FILTER_VALIDATE_IP) === FALSE) {
            throw new \Exception("You don't appear to have a valid IP address - odd!");
        }
        
        $url = "http://ip-api.com/json/{$ipAddress}";
        
        $curl                 = new \http\curl;
        $curl->url            = $url;
        $curl->spoofUserAgent = TRUE;
        $curl->reuseCookies   = TRUE;
        $return               = $curl->getPage();
        
        if ($return === FALSE) {
            throw new \Exception($curl->error);
        }
        
        $data = json_decode($return, TRUE);
        
        $geoIp["ipAddress"]     = $ipAddress;
        $geoIp["hostname"]      = gethostbyaddr($ipAddress);
        $geoIp["city"]          = $data["city"];
        $geoIp["region"]        = $data["region"];
        $geoIp["regionName"]    = $data["regionName"];
        $geoIp["country"]       = $data["country"];
        $geoIp["countryCode"]   = $data["countryCode"];
        $geoIp["lon"]           = $data["lon"];
        $geoIp["lat"]           = $data["lat"];
        $geoIp["as"]            = $data["as"];
        $geoIp["isp"]           = $data["isp"];
        $geoIp["timezone"]      = $data["timezone"];
        $geoIp["zip"]           = $data["zip"];
        
        return $geoIp;
    }
}