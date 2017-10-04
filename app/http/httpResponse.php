<?php

/**
 * TITLE HERE
 * 
 * @name        httpResponse.php
 * @package     jonthompson.co.uk.local
 * @version     
 * @since       28-Apr-2017 09:36:07
 * @author      Jon Thompson
 * @abstract    
 */

namespace http;

class httpResponse {
    static function getCode($httpCode) {
        $httpCodes = self::setCodes();
        
        if(!array_key_exists($httpCode, $httpCodes)) {
            return FALSE;
        } else {
            return $httpCodes[$httpCode];
        }
    }

    static function setCodes() {
        $httpCodes[100] = array("text" => "Continue", "description" => "The server has received the request headers and the client should proceed to send the request body (in the case of a request for which a body needs to be sent; for example, a POST request). Sending a large request body to a server after a request has been rejected for inappropriate headers would be inefficient. To have a server check the request's headers, a client must send Expect: 100-continue as a header in its initial request and receive a 100 Continue status code in response before sending the body. The response 417 Expectation Failed indicates the request should not be continued.");
        $httpCodes[101] = array("text" => "Switching Protocols", "description" => "The requester has asked the server to switch protocols and the server has agreed to do so.");
        $httpCodes[102] = array("text" => "Processing", "description" => "A WebDAV request may contain many sub-requests involving file operations, requiring a long time to complete the request. This code indicates that the server has received and is processing the request, but no response is available yet. This prevents the client from timing out and assuming the request was lost.");
        $httpCodes[103] = array("text" => "Checkpoint", "description" => "Used in the resumable requests proposal to resume aborted PUT or POST requests.");
        $httpCodes[103] = array("text" => "Early Hints", "description" => "Used to return some response headers before entire HTTP response.");
        $httpCodes[200] = array("text" => "OK", "description" => "Standard response for successful HTTP requests. The actual response will depend on the request method used. In a GET request, the response will contain an entity corresponding to the requested resource. In a POST request, the response will contain an entity describing or containing the result of the action.");
        $httpCodes[201] = array("text" => "Created", "description" => "The request has been fulfilled, resulting in the creation of a new resource.");
        $httpCodes[202] = array("text" => "Accepted", "description" => "The request has been accepted for processing, but the processing has not been completed. The request might or might not be eventually acted upon, and may be disallowed when processing occurs.");
        $httpCodes[203] = array("text" => "Non-Authoritative Information", "description" => "The server is a transforming proxy (e.g. a Web accelerator) that received a 200 OK from its origin, but is returning a modified version of the origin's response.");
        $httpCodes[204] = array("text" => "No Content", "description" => "The server successfully processed the request and is not returning any content.");
        $httpCodes[205] = array("text" => "Reset Content", "description" => "The server successfully processed the request, but is not returning any content. Unlike a 204 response, this response requires that the requester reset the document view.");
        $httpCodes[206] = array("text" => "Partial Content", "description" => "The server is delivering only part of the resource (byte serving) due to a range header sent by the client. The range header is used by HTTP clients to enable resuming of interrupted downloads, or split a download into multiple simultaneous streams.");
        $httpCodes[207] = array("text" => "Multi-Status", "description" => "The message body that follows is an XML message and can contain a number of separate response codes, depending on how many sub-requests were made.");
        $httpCodes[208] = array("text" => "Already Reported", "description" => "The members of a DAV binding have already been enumerated in a preceding part of the (multistatus) response, and are not being included again.");
        $httpCodes[226] = array("text" => "IM Used", "description" => "The server has fulfilled a request for the resource, and the response is a representation of the result of one or more instance-manipulations applied to the current instance.");
        $httpCodes[300] = array("text" => "Multiple Choices", "description" => "Indicates multiple options for the resource from which the client may choose (via agent-driven content negotiation). For example, this code could be used to present multiple video format options, to list files with different filename extensions, or to suggest word-sense disambiguation.");
        $httpCodes[301] = array("text" => "Moved Permanently", "description" => "This and all future requests should be directed to the given URI.");
        $httpCodes[302] = array("text" => "Found", "description" => "This is an example of industry practice contradicting the standard. The HTTP/1.0 specification (RFC 1945) required the client to perform a temporary redirect (the original describing phrase was &quot;Moved Temporarily&quot;), but popular browsers implemented 302 with the functionality of a 303 See Other. Therefore, HTTP/1.1 added status codes 303 and 307 to distinguish between the two behaviours. However, some Web applications and frameworks use the 302 status code as if it were the 303.");
        $httpCodes[303] = array("text" => "See Other", "description" => "The response to the request can be found under another URI using a GET method. When received in response to a POST (or PUT/DELETE), the client should presume that the server has received the data and should issue a redirect with a separate GET message.");
        $httpCodes[304] = array("text" => "Not Modified", "description" => "Indicates that the resource has not been modified since the version specified by the request headers If-Modified-Since or If-None-Match. In such case, there is no need to retransmit the resource since the client still has a previously-downloaded copy.");
        $httpCodes[305] = array("text" => "Use Proxy", "description" => "The requested resource is available only through a proxy, the address for which is provided in the response. Many HTTP clients (such as Mozilla and Internet Explorer) do not correctly handle responses with this status code, primarily for security reasons.");
        $httpCodes[306] = array("text" => "Switch Proxy", "description" => "No longer used. Originally meant &quot;Subsequent requests should use the specified proxy.&quot;");
        $httpCodes[307] = array("text" => "Temporary Redirect", "description" => "In this case, the request should be repeated with another URI; however, future requests should still use the original URI. In contrast to how 302 was historically implemented, the request method is not allowed to be changed when reissuing the original request. For example, a POST request should be repeated using another POST request.");
        $httpCodes[308] = array("text" => "Permanent Redirect", "description" => "The request and all future requests should be repeated using another URI. 307 and 308 parallel the behaviors of 302 and 301, but do not allow the HTTP method to change. So, for example, submitting a form to a permanently redirected resource may continue smoothly.");
        $httpCodes[400] = array("text" => "Bad Request", "description" => "The server cannot or will not process the request due to an apparent client error (e.g., malformed request syntax, too large size, invalid request message framing, or deceptive request routing).");
        $httpCodes[401] = array("text" => "Unauthorized", "description" => "Similar to 403 Forbidden, but specifically for use when authentication is required and has failed or has not yet been provided. The response must include a WWW-Authenticate header field containing a challenge applicable to the requested resource. See Basic access authentication and Digest access authentication. 401 semantically means &quot;unauthenticated&quot;, i.e. the user does not have the necessary credentials. Note: Some sites issue HTTP 401 when an IP address is banned from the website (usually the website domain) and that specific address is refused permission to access a website.");
        $httpCodes[402] = array("text" => "Payment Required", "description" => "Reserved for future use. The original intention was that this code might be used as part of some form of digital cash or micropayment scheme, but that has not happened, and this code is not usually used. Google Developers API uses this status if a particular developer has exceeded the daily limit on requests.");
        $httpCodes[403] = array("text" => "Forbidden", "description" => "The request was valid, but the server is refusing action. The user might not have the necessary permissions for a resource.");
        $httpCodes[404] = array("text" => "Not Found", "description" => "The requested resource could not be found but may be available in the future. Subsequent requests by the client are permissible.");
        $httpCodes[405] = array("text" => "Method Not Allowed", "description" => "A request method is not supported for the requested resource; for example, a GET request on a form that requires data to be presented via POST, or a PUT request on a read-only resource.");
        $httpCodes[406] = array("text" => "Not Acceptable", "description" => "The requested resource is capable of generating only content not acceptable according to the Accept headers sent in the request. See Content negotiation.");
        $httpCodes[407] = array("text" => "Proxy Authentication Required", "description" => "The client must first authenticate itself with the proxy.");
        $httpCodes[408] = array("text" => "Request Timeout", "description" => "The server timed out waiting for the request. According to HTTP specifications: &quot;The client did not produce a request within the time that the server was prepared to wait. The client MAY repeat the request without modifications at any later time.&quot;");
        $httpCodes[409] = array("text" => "Conflict", "description" => "Indicates that the request could not be processed because of conflict in the request, such as an edit conflict between multiple simultaneous updates.");
        $httpCodes[410] = array("text" => "Gone", "description" => "Indicates that the resource requested is no longer available and will not be available again. This should be used when a resource has been intentionally removed and the resource should be purged. Upon receiving a 410 status code, the client should not request the resource in the future. Clients such as search engines should remove the resource from their indices. Most use cases do not require clients and search engines to purge the resource, and a &quot;404 Not Found&quot; may be used instead.");
        $httpCodes[411] = array("text" => "Length Required", "description" => "The request did not specify the length of its content, which is required by the requested resource.");
        $httpCodes[412] = array("text" => "Precondition Failed", "description" => "The server does not meet one of the preconditions that the requester put on the request.");
        $httpCodes[413] = array("text" => "Payload Too Large", "description" => "The request is larger than the server is willing or able to process. Previously called &quot;Request Entity Too Large&quot;.");
        $httpCodes[414] = array("text" => "URI Too Long", "description" => "The URI provided was too long for the server to process. Often the result of too much data being encoded as a query-string of a GET request, in which case it should be converted to a POST request. Called &quot;Request-URI Too Long&quot; previously.");
        $httpCodes[415] = array("text" => "Unsupported Media Type", "description" => "The request entity has a media type which the server or resource does not support. For example, the client uploads an image as image/svg+xml, but the server requires that images use a different format.");
        $httpCodes[416] = array("text" => "Range Not Satisfiable", "description" => "The client has asked for a portion of the file (byte serving), but the server cannot supply that portion. For example, if the client asked for a part of the file that lies beyond the end of the file. Called &quot;Requested Range Not Satisfiable&quot; previously.");
        $httpCodes[417] = array("text" => "Expectation Failed", "description" => "The server cannot meet the requirements of the Expect request-header field.");
        $httpCodes[418] = array("text" => "I'm a teapot", "description" => "This code was defined in 1998 as one of the traditional IETF April Fools' jokes, in RFC 2324, Hyper Text Coffee Pot Control Protocol, and is not expected to be implemented by actual HTTP servers. The RFC specifies this code should be returned by teapots requested to brew coffee. This HTTP status is used as an Easter egg in some websites, including Google.com.");
        $httpCodes[420] = array("text" => "Enhance Your Calm", "description" => "Returned by version 1 of the Twitter Search and Trends API when the client is being rate limited; versions 1.1 and later use the 429 Too Many Requests response code instead.");
        $httpCodes[420] = array("text" => "Method Failure", "description" => "A deprecated response used by the Spring Framework when a method has failed.");
        $httpCodes[421] = array("text" => "Misdirected Request", "description" => "The request was directed at a server that is not able to produce a response (for example because a connection reuse).");
        $httpCodes[422] = array("text" => "Unprocessable Entity", "description" => "The request was well-formed but was unable to be followed due to semantic errors.");
        $httpCodes[423] = array("text" => "Locked", "description" => "The resource that is being accessed is locked.");
        $httpCodes[424] = array("text" => "Failed Dependency", "description" => "The request failed due to failure of a previous request (e.g., a PROPPATCH).");
        $httpCodes[426] = array("text" => "Upgrade Required", "description" => "The client should switch to a different protocol such as TLS/1.0, given in the Upgrade header field.");
        $httpCodes[428] = array("text" => "Precondition Required", "description" => "The origin server requires the request to be conditional. Intended to prevent &quot;the 'lost update' problem, where a client GETs a resource's state, modifies it, and PUTs it back to the server, when meanwhile a third party has modified the state on the server, leading to a conflict.&quot;");
        $httpCodes[429] = array("text" => "Too Many Requests", "description" => "The user has sent too many requests in a given amount of time. Intended for use with rate-limiting schemes.");
        $httpCodes[431] = array("text" => "Request Header Fields Too Large", "description" => "The server is unwilling to process the request because either an individual header field, or all the header fields collectively, are too large.");
        $httpCodes[440] = array("text" => "Login Time-out", "description" => "The client's session has expired and must log in again.");
        $httpCodes[444] = array("text" => "No Response", "description" => "Used to indicate that the server has returned no information to the client and closed the connection.");
        $httpCodes[449] = array("text" => "Retry With", "description" => "The server cannot honour the request because the user has not provided the required information.");
        $httpCodes[450] = array("text" => "Blocked by Windows Parental Controls", "description" => "The Microsoft extension code indicated when Windows Parental Controls are turned on and are blocking access to the given webpage.");
        $httpCodes[451] = array("text" => "Redirect", "description" => "Used in Exchange ActiveSync when either a more efficient server is available or the server cannot access the users' mailbox. The client is expected to re-run the HTTP AutoDiscover operation to find a more appropriate server.");
        $httpCodes[451] = array("text" => "Unavailable For Legal Reasons", "description" => "A server operator has received a legal demand to deny access to a resource or to a set of resources that includes the requested resource. The code 451 was chosen as a reference to the novel Fahrenheit 451.");
        $httpCodes[495] = array("text" => "SSL Certificate Error", "description" => "An expansion of the 400 Bad Request response code, used when the client has provided an invalid client certificate.");
        $httpCodes[496] = array("text" => "SSL Certificate Required", "description" => "An expansion of the 400 Bad Request response code, used when a client certificate is required but not provided.");
        $httpCodes[497] = array("text" => "HTTP Request Sent to HTTPS Port", "description" => "An expansion of the 400 Bad Request response code, used when the client has made a HTTP request to a port listening for HTTPS requests.");
        $httpCodes[498] = array("text" => "Invalid Token", "description" => "Returned by ArcGIS for Server. Code 498 indicates an expired or otherwise invalid token.");
        $httpCodes[499] = array("text" => "Client Closed Request", "description" => "Used when the client has closed the request before the server could send a response.");
        $httpCodes[499] = array("text" => "Token Required", "description" => "Returned by ArcGIS for Server. Code 499 indicates that a token is required but was not submitted.");
        $httpCodes[500] = array("text" => "Internal Server Error", "description" => "A generic error message, given when an unexpected condition was encountered and no more specific message is suitable.");
        $httpCodes[501] = array("text" => "Not Implemented", "description" => "The server either does not recognize the request method, or it lacks the ability to fulfill the request. Usually this implies future availability (e.g., a new feature of a web-service API).");
        $httpCodes[502] = array("text" => "Bad Gateway", "description" => "The server was acting as a gateway or proxy and received an invalid response from the upstream server.");
        $httpCodes[503] = array("text" => "Service Unavailable", "description" => "The server is currently unavailable (because it is overloaded or down for maintenance). Generally, this is a temporary state.");
        $httpCodes[504] = array("text" => "Gateway Time-out", "description" => "The server was acting as a gateway or proxy and did not receive a timely response from the upstream server.");
        $httpCodes[505] = array("text" => "HTTP Version Not Supported", "description" => "The server does not support the HTTP protocol version used in the request.");
        $httpCodes[506] = array("text" => "Variant Also Negotiates", "description" => "Transparent content negotiation for the request results in a circular reference.");
        $httpCodes[507] = array("text" => "Insufficient Storage", "description" => "The server is unable to store the representation needed to complete the request.");
        $httpCodes[508] = array("text" => "Loop Detected", "description" => "The server detected an infinite loop while processing the request (sent in lieu of 208 Already Reported).");
        $httpCodes[509] = array("text" => "Bandwidth Limit Exceeded", "description" => "The server has exceeded the bandwidth specified by the server administrator; this is often used by shared hosting providers to limit the bandwidth of customers.");
        $httpCodes[510] = array("text" => "Not Extended", "description" => "Further extensions to the request are required for the server to fulfill it.");
        $httpCodes[511] = array("text" => "Network Authentication Required", "description" => "The client needs to authenticate to gain network access. Intended for use by intercepting proxies used to control access to the network (e.g., &quot;captive portals&quot; used to require agreement to Terms of Service before granting full Internet access via a Wi-Fi hotspot).");
        $httpCodes[520] = array("text" => "Unknown Error", "description" => "The 520 error is used as a &quot;catch-all response for when the origin server returns something unexpected&quot;, listing connection resets, large headers, and empty or invalid responses as common triggers.");
        $httpCodes[521] = array("text" => "Web Server Is Down", "description" => "The origin server has refused the connection from Cloudflare.");
        $httpCodes[522] = array("text" => "Connection Timed Out", "description" => "Cloudflare could not negotiate a TCP handshake with the origin server.");
        $httpCodes[523] = array("text" => "Origin Is Unreachable", "description" => "Cloudflare could not reach the origin server; for example, if the DNS records for the origin server are incorrect.");
        $httpCodes[524] = array("text" => "A Timeout Occurred", "description" => "Cloudflare was able to complete a TCP connection to the origin server, but did not receive a timely HTTP response.");
        $httpCodes[525] = array("text" => "SSL Handshake Failed", "description" => "Cloudflare could not negotiate a SSL/TLS handshake with the origin server.");
        $httpCodes[526] = array("text" => "Invalid SSL Certificate", "description" => "Cloudflare could not validate the SSL/TLS certificate that the origin server presented.");
        $httpCodes[527] = array("text" => "Railgun Error", "description" => "Error 527 indicates that the requests timeout or failed after the WAN connection has been established.");
        $httpCodes[530] = array("text" => "Site is frozen", "description" => "Used by the Pantheon web platform to indicate a site that has been frozen due to inactivity.");
        $httpCodes[598] = array("text" => "Network read timeout error", "description" => "Used by some HTTP proxies to signal a network read timeout behind the proxy to a client in front of the proxy.");
        $httpCodes[599] = array("text" => "Network connect timeout error", "description" => "Used to indicate when the connection to the network times out.");
    
        return $httpCodes;
    }

    
}
