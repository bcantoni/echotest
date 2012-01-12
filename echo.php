<?php
/*
 * Echo test webservice - respond with request and header details
 *
 * http://scooterlabs.com/echo - plain text
 * http://scooterlabs.com/echo.json - JSON format
 * http://scooterlabs.com/echo.xml - XML format
 *
 * Brian Cantoni <brian AT cantoni.org>
 * https://github.com/bcantoni/echotest
 */

if (function_exists('getallheaders')) {
    $all_headers = getallheaders();
} else {
    $all_headers = array();
}

// remove any Google Adsense cookies
removeGoogleAdsense ();

$data = array (
    'method' => $_SERVER['REQUEST_METHOD'],
    'headers' => $all_headers,
    'request' => $_REQUEST,
//    'server' => $_REQUEST, // only advisable for debug, don't make public
    'client_ip' => get_ip_address (),
    'time_utc' => gmdate (DATE_ISO8601),
    'info' => 'Echo service from Scooterlabs (http://www.scooterlabs.com)',
);

$uri = $_SERVER['REQUEST_URI'];
if (preg_match ('/^\/echo.json/', $uri)) {
    header ("Content-type: application/json");
    print json_encode ($data) . "\n";
} else if (preg_match ('/^\/echo.xml*/', $uri)) {
    header ("Content-type: application/xml");
    print array_to_xml ($data, new SimpleXMLElement ('<echo/>'))->asXML();
} else {
    header ("Content-type: text/plain");
    print_r ($data);
}

/*
 * Recursively convert PHP array to XML string
 *
 * modified from original: http://stackoverflow.com/a/3289602/9965
 */
function array_to_xml (array $arr, SimpleXMLElement $xml) {
    foreach ($arr as $k => $v) {
        is_array ($v)
            ? array_to_xml ($v, $xml->addChild ($k))
            : $xml->addChild ($k, xmlEscape ($v));
    }
    return $xml;
}

/*
 * Escape special XML chars
 *
 */
function xmlEscape($string) {
    return str_replace(array('&', '<', '>', '\'', '"'), array('&amp;', '&lt;', '&gt;', '&apos;', '&quot;'), $string);
}

/*
 * Remove Google Adsense cookies if present in global $_REQUEST
 *
 */
function removeGoogleAdsense () {
    if ($_REQUEST) {
        foreach ($_REQUEST as $k=>$v) {
            if (preg_match ('/^__utm/', $k)) {
                unset ($_REQUEST[$k]);
            }
        }
    }
}

/*
 * Return best match for client IP address
 *
 * source: http://www.kavoir.com/2010/03/php-how-to-detect-get-the-real-client-ip-address-of-website-visitors.html
 */
function get_ip_address() {
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
                    return $ip;
                }
            }
        }
    }
    return ('');
}

