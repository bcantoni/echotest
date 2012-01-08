# Echo webservice test

A simple webservice call which echos back data about the request.
Can be useful for testing and debugging webservice clients.

Inspired by http://respondto.it/ and http://requestb.in/.

## Usage

Make a request to the Echo service using Curl or your webservice 
client or app:

http://scooterlabs.com/echo  
http://scooterlabs.com/echo.json  
http://scooterlabs.com/echo.xml  

By default, the service responds with plain text, but can return 
JSON or XML.

## Examples

Plain text response:

    $ curl http://scooterlabs.com/echo
    Array
    (
        [method] => GET
        [headers] => Array
            (
                [User-Agent] => curl/7.19.7 (universal-apple-darwin10.0) libcurl/7.19.7 OpenSSL/0.9.8r zlib/1.2.3
                [Host] => scooterlabs.com
                [Accept] => */*
            )

        [request] => Array
            (
                [foo] => bar
            )

        [client_ip] => 68.125.160.82
        [time_utc] => 2012-01-08T21:33:28+0000
        [info] => Echo service from Scooterlabs (http://www.scooterlabs.com)
    )

JSON response:

    $ curl http://scooterlabs.com/echo.json?foo=bar
    {"method":"GET","headers":{"User-Agent":"curl\/7.19.7 (universal-apple-darwin10.0) libcurl\/7.19.7 OpenSSL\/0.9.8r zlib\/1.2.3","Host":"scooterlabs.com","Accept":"*\/*"},"request":{"foo":"bar"},"client_ip":"68.125.160.82","time_utc":"2012-01-08T21:33:36+0000","info":"Echo service from Scooterlabs (http:\/\/www.scooterlabs.com)"}

XML response:

    $ curl http://scooterlabs.com/echo.xml?foo=bar
    <?xml version="1.0"?>
    <echo><method>GET</method><headers><User-Agent>curl/7.19.7 (universal-apple-darwin10.0) libcurl/7.19.7 OpenSSL/0.9.8r zlib/1.2.3</User-Agent><Host>scooterlabs.com</Host><Accept>*/*</Accept></headers><request><foo>bar</foo></request><client_ip>68.125.160.82</client_ip><time_utc>2012-01-08T21:33:48+0000</time_utc><info>Echo service from Scooterlabs (http://www.scooterlabs.com)</info></echo>

## Installation

To run on your own server, install `echo.php` file to a suitable location 
and add the following to your Apache config or local `.htaccess` file:

    # Echo test script
    <IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^echo /echo.php [L]
    </IfModule>

If you install `echo.php` into a location other than the root of your
web server, you'll need to adjust the rewrite rules a bit.

