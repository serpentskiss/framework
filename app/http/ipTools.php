<?php

/**
 * TITLE HERE
 * 
 * @name        whois.php
 * @package     jonthompson.co.uk.local
 * @version     
 * @since       06-Feb-2017 11:45:28
 * @author      Jon Thompson
 * @abstract    
 */

namespace http;

class ipTools {
    
    static function inetnum($ipAddress) {
        $ipAddress = trim($ipAddress);

        if (filter_var($ipAddress, FILTER_VALIDATE_IP) === FALSE) {
            throw new \Exception("You don't appear to have a valid IP address - odd!");
        }

        $out = array();

        $cmd = "/usr/bin/whois {$ipAddress}";
        exec($cmd, $out);

        if (!count($out)) {
            throw new \Exception("Empty response from WHOIS");
        }

        $data = array();

        foreach ($out as $line) {
            $line = trim($line);

            if (!preg_match("/^($|#|%)/", $line)) {
                //if(substr($line, 0, 1) != '#' && $line != "") {
                $line = preg_replace("/: +/", ":", $line);
                if(strstr($line, ":")) {
                    list($key, $value) = explode(":", $line, 2);
                    $data[$key] = $value;
                }
            }
        }

        if (array_key_exists("inetnum", $data)) {
            list($startIpAddress, $endIpAddress) = explode(" - ", $data["inetnum"]);
            $cidr = self::ipToCidr($startIpAddress, $endIpAddress);
            return array("inetnum" => $data["inetnum"], "cidr" => $cidr);
        } elseif (array_key_exists("NetRange", $data)) {
            list($startIpAddress, $endIpAddress) = explode(" - ", $data["NetRange"]);
            $cidr = self::ipToCidr($startIpAddress, $endIpAddress);
            return array("inetnum" => $data["NetRange"], "cidr" => $cidr);
        } 

        return FALSE;
    }

    static function ipToCidr($startIpAddress, $endIpAddress) {
        $return = array();
        $num = ip2long($endIpAddress) - ip2long($startIpAddress) + 1;
        $bin = decbin($num);

        $chunk = str_split($bin);
        $chunk = array_reverse($chunk);
        $start = 32 - count($chunk) + 1;

        while ($start <= 32) {
            if ($chunk[32 - $start] != 0) {

                $start_ip = isset($range) ? long2ip(ip2long($range[1]) + 1) : $startIpAddress;
                $range = self::cidr2ip($start_ip . '/' . ($start));

                $return[] = $start_ip . '/' . ($start);
            }
            $start++;
        }
        return $return;
    }

    static function cidr2ip($cidr) {
        $ip_arr = explode('/', $cidr);
        $start = ip2long($ip_arr[0]);
        $nm = $ip_arr[1];
        $num = pow(2, 32 - $nm);
        $end = $start + $num - 1;
        return array($ip_arr[0], long2ip($end));
    }

}
