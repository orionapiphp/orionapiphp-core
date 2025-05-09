<?php

namespace OrionApi\Core\Http;

use OrionApi\Core\Exception\NullPointerException;

/**
 * Handles all requests in this framework. This class is useful for getting URL Params, Request Body and Request Headers, 
 * URL on which the request is coming.
 * @author Shyam Dubey
 * @since 2025
 */
class Request
{

    private static $request_params;
    private static $request_cookies;
    private static $headers;
    private static $request_body;
    private static $url;


    public function __construct($url)
    {
        self::$request_params = $_REQUEST;
        self::$request_cookies = $_COOKIE;
        self::$headers = apache_request_headers();
        self::$request_body = self::get_body();
        self::$url = $url;
    }

    /**
     * This function is used to get the Request Body of any request. Mostly used for POST, PUT type requests.
     * @return jsonobject
     * @author Shyam Dubey
     * @since 2025
     */
    public static function get_body()
    {
        self::$request_body = json_decode(file_get_contents("php://input"));
        return self::$request_body;
    }


    /**
     * This function is used to get the Request Headers of any request. Useful for Authentication etc.
     * @return array
     * @author Shyam Dubey
     * @since 2025
     */
    public static function get_headers(): array
    {
        if (self::$headers == null) {
            return apache_request_headers();
        } else {
            return self::$headers;
        }
    }

    /**
     * This function is used to get the Request Params [$_GET, $_POST, $_COOKIE] of any request.
     * @return associativearray
     * @author Shyam Dubey
     * @since 2025
     */
    public static function get_params()
    {
        if (self::$request_params == null) {
            return $_REQUEST;
        } else {
            return self::$request_params;
        }
    }


    /**
     * This function updates the current request. You must use this function if you are changing the Request in middleware.
     * After making changes, Don't forget to update the request.
     * 
     * @author Shyam Dubey
     * @since v1.0.0
     * @version 1.0.0
     */
    public static function update(Request $request)
    {
        self::$request_params = $request::get_params();
        self::$headers = $request::get_headers();
        self::$request_body = $request::get_body();
        self::$request_cookies = $request::get_headers();
        self::$url = $request::get_url();
    }


    /**
     * To set the request body, this function is used. It throws NullPointerException when the request body is null and you want to set
     * some value to the request body.
     * 
     * @author Shyam Dubey
     * @since v1.0.0
     * @version 1.0.0
     */
    public static function set_body($body)
    {
        if (self::$request_body == null) {
            throw new NullPointerException("Request body is null. Can not set the value");
        }
        self::$request_body = $body;
    }


    /**
     * To set the headers of request.
     * @author Shyam Dubey
     * @since v1.0.0
     * @version 1.0.0
     */
    public static function set_headers($headers)
    {
        self::$headers = $headers;
    }

    /**
     * set cookies in incoming request.
     * 
     * @author Shyam Dubey
     * @since v1.0.0
     * @version 1.0.0
     */
    public static function set_cookies($cookies)
    {
        self::$request_cookies = $cookies;
    }



    /**
     * To get the cookies of request.
     * 
     * @author Shyam Dubey
     * @since v1.0.0
     * @version 1.0.0
     */
    public static function get_cookies()
    {
        if (self::$request_cookies == null) {
            return $_COOKIE;
        } else {
            return self::$request_cookies;
        }
    }


    /**
     * To get the url on which request is coming.
     * 
     * @author Shyam Dubey
     * @since v1.0.0
     * @version 1.0.0
     */
    public static function get_url()
    {
        return self::$url;
    }
}
