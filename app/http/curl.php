<?php
/**
 * cUrl - Fetch data from a URL
 * -----------------------------------------------------------------------------
 * This sets a lot of defaults for ease of use, which can be overwritten by
 * using setters.
 *
 * Configurable options are boolean, and set to mimick browser access to a URL
 * by default
 *
 *
 * Configurable options
 * -----------------------------------------------------------------------------
 * ->reuseCookies   : Default: FALSE
 * ->getHttpHeaders : Default: FALSE
 * ->spoofUserAgent : Default: TRUE
 *
 *
 * Example:
 * -----------------------------------------------------------------------------
 * $curl      = new curl;
 * $curl->url = "http://www.last.fm/music/The+Mission/+wiki";
 *
 * if($return = $curl->getPage() === FALSE) {
 *     echo "An error occurred:\n<br />";
 *     echo $curl->error;
 *     exit;
 * } else {
 *     echo $return;
 * }
 *
 *
 * @author     Jon Thompson
 * @copyright  2016 Jon Thompson
 * @license    GPL2 (https://opensource.org/licenses/GPL-2.0)
 */

/*$curl      = new curl;
$curl->url = "http://www.last.fm/music/The+Mission/+wiki";
$return = $curl->getPage();

if($return === FALSE) {
    echo "An error occurred:\n<br />";
    echo $curl->error;
    exit;
} else {
    echo $return;
}*/
namespace http;

class curl {

    /**
     * Error messages
     * @var string
     */
    public $error;

    /**
     * The URL to fetch
     * @var string
     */
    public $url;

    /**
     * Re-use cookies from previous sessions?
     * @var BOOLEAN
     */
    public $reuseCookies = FALSE;

    /**
     * Fetch the HTTP headers?
     * @var BOOLEAN
     */
    public $getHttpHeaders = FALSE;

    /**
     * Send a spoofed UserAgent string to trick pages?
     * @var BOOLEAN
     */
    public $spoofUserAgent = TRUE;

    /**
     * The current curl session
     * @var resource
     */
    private $curlSession;

    /**
     * Set a default UserAgent string in case the list isn't available
     * @var string
     */
    //private $defaultUserAgent = "Googlebot/2.1 (+http://www.google.com/bot.html)";
    private $defaultUserAgent = "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.95 Safari/537.36";
    
    /**
     * Fetch data from the given URL
     * @return string|BOOLEAN The page fetched from the URL, or FALSE if errors
     */
    function getPage() {
        if ($this->url === "") {
            $this->error = "No URL to fetch";
            return FALSE;
        }

        if (!$this->validateUrl($this->url)) {
            $this->error = "Not a valid URL";
            return FALSE;
        }

        if ($this->reuseCookies === FALSE && file_exists(dirname(__FILE__) . "/cookieJar") && is_file(dirname(__FILE__) . "/cookieJar")) {
            unlink(dirname(__FILE__) . "/cookieJar");
        }

        if (!file_exists(dirname(__FILE__) . "/cookieJar") && !is_file(dirname(__FILE__) . "/cookieJar")) {
            touch(dirname(__FILE__) . "/cookieJar");
            chmod(dirname(__FILE__) . "/cookieJar", 0777);
        }

        // Open the socket
        $this->curlSession = curl_init();
        // Set the destination
        curl_setopt($this->curlSession, CURLOPT_URL, $this->url);
        curl_setopt($this->curlSession, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($this->curlSession, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($this->curlSession, CURLOPT_FORBID_REUSE, TRUE);
        curl_setopt($this->curlSession, CURLOPT_FRESH_CONNECT, TRUE);
        // cUrl Cookies/Sessions
        curl_setopt($this->curlSession, CURLOPT_COOKIESESSION, $this->reuseCookies);
        curl_setopt($this->curlSession, CURLOPT_COOKIEJAR, dirname(__FILE__) . "/cookieJar");
        // Spoof the user agent string
        curl_setopt($this->curlSession, CURLOPT_USERAGENT, $this->setUserAgent());
        // Spoof the outgoing HTTP headers
        curl_setopt($this->curlSession, CURLOPT_HTTPHEADER, $this->setHttpHeaders());
        // We don't want the HTTP headers normally. Set to TRUE if we do
        curl_setopt($this->curlSession, CURLOPT_HEADER, $this->getHttpHeaders);
        // Save the returned page in a variable
        curl_setopt($this->curlSession, CURLOPT_RETURNTRANSFER, TRUE);
        // Fail if there's an error > HTTP 400
        curl_setopt($this->curlSession, CURLOPT_FAILONERROR, TRUE);

        // Execute the request
        $return = curl_exec($this->curlSession);

        if($return === FALSE || $return == "") {
            $errorMessage = curl_error($this->curlSession);
            $errorNumber  = curl_errno($this->curlSession);
            $this->error  = "here: [{$errorNumber}] {$errorMessage}";
            return FALSE;
        }

        // Close the session
        curl_close($this->curlSession);

        // Return the page
        return $return;
    }

    /**
     * Set a spoofed UserAgent string
     * @return string The UserAgent string to use
     */
    private function setUserAgent() {
        if ($this->spoofUserAgent !== TRUE) {
            return $this->defaultUserAgent;
        } else {
            $userAgents = file(dirname(__FILE__) . "/userAgents", FILE_IGNORE_NEW_LINES);
            $userAgent = $userAgents[mt_rand(0, count($userAgents) - 1)];

            if ($userAgent == "") {
                return $this->defaultUserAgent;
            } else {
                return $userAgent;
            }
        }
    }

    /**
     * Build a set of HTTP headers to add to the cUrl requets to spoof a browser
     * @return string The HTTP headers to add to the cUrl request
     */
    function setHttpHeaders() {
        $header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
        $header[] = "Cache-Control: max-age=0";
        $header[] = "Connection: keep-alive";
        $header[] = "Keep-Alive: 300";
        $header[] = "Accept-Charset: utf-8,ISO-8859-1;q=0.7,*;q=0.7";
        $header[] = "Accept-Language: en-us,en;q=0.5";
        $header[] = "Pragma: "; // browsers keep this blank.

        return $header;
    }

    /**
     * Validate a URL
     * @param string $url The URL to check
     * @return string|BOOLEAN The URl, or FALSE if invalid
     */
    function validateUrl($url) {
        return filter_var($url, FILTER_VALIDATE_URL);
    }

}
