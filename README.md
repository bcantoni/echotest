# Echo Webservice

A simple webservice call which echos back data about the request. Can be useful for testing and debugging webservice clients.

Inspired by http://respondto.it/ and http://requestb.in/ (both of which are no longer in service). See my blog post [Recent HTTP Request Inspector Services](http://www.cantoni.org/2019/04/30/recent-http-request-inspector-services) for an updated list of similar services.

http://httpbin.org/ is similar with lot of additional controls about the response generation.

## Usage

Make a request to the Echo service using Curl or your webservice 
client or app:

http://scooterlabs.com/echo  
http://scooterlabs.com/echo.json  
http://scooterlabs.com/echo.xml  

By default, the service responds with plain text, but can return 
JSON or XML.

## Data Returned

In all data formats, the following data is returned:

* `method`: the HTTP method used (GET, HEAD, POST, etc.)
* `headers`: all HTTP headers received
* `request`: all data parameters (query parameters or POST data)
* `client_ip`: best guess at originating client IP address (from HTTP headers)
* `time_utc`: request time (UTC)

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

Plain text response with public IP address:

    $ curl http://scooterlabs.com/echo?ip
    10.11.12.13

JSON response:

    $ curl --silent curl http://scooterlabs.com/echo.json?foo=bar | json_xs
    {
       "info" : "Echo service from Scooterlabs (http://www.scooterlabs.com)",
       "request" : {
          "foo" : "bar"
       },
       "headers" : {
          "User-Agent" : "curl/7.21.3 (i386-portbld-freebsd7.3) libcurl/7.21.3 OpenSSL/1.0.0e zlib/1.2.3 libidn/1.22",
          "Accept" : "*/*",
          "Host" : "scooterlabs.com"
       },
       "client_ip" : "66.39.158.129",
       "time_utc" : "2012-01-08T22:07:54+0000",
       "method" : "GET"
    }

XML response:

    $ curl --silent http://scooterlabs.com/echo.xml?foo=bar | xml_pp
    
    <?xml version="1.0"?>
    <echo>
      <method>GET</method>
      <headers>
        <User-Agent>curl/7.19.7 (universal-apple-darwin10.0) libcurl/7.19.7 OpenSSL/0.9.8r zlib/1.2.3</User-Agent>
        <Host>scooterlabs.com</Host>
        <Accept>*/*</Accept>
      </headers>
      <request>
        <foo>bar</foo>
      </request>
      <client_ip>68.122.10.221</client_ip>
      <time_utc>2012-03-24T17:05:49+0000</time_utc>
      <info>Echo service from Scooterlabs (http://www.scooterlabs.com)</info>
    </echo>

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

