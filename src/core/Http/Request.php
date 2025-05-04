<?php

namespace Core\Http;
/**
 * Handles all requests in this framework. This class is useful for getting URL Params, Request Body and Request Headers
 * @author Shyam Dubey
 * @since 2025
 */
class Request{

    private static $params;
    private static $headers;

    public function __construct()
    {
        self::$params = $_REQUEST;
        self::$headers = apache_request_headers();
    }

    /**
     * This function is used to get the Request Body of any request. Mostly used for POST, PUT type requests.
     * @return jsonobject
     * @author Shyam Dubey
     * @since 2025
     */
    public static function get_body(){
        return json_decode(file_get_contents("php://input"));
    }


    /**
     * This function is used to get the Request Headers of any request. Useful for Authentication etc.
     * @return array
     * @author Shyam Dubey
     * @since 2025
     */
    public static function get_headers():array{
        if(self::$headers == null){
        return apache_request_headers();
        }
        else{
            return self::$headers;
        }
    }

    /**
     * This function is used to get the Request Params [$_GET, $_POST, $_COOKIE] of any request.
     * @return associativearray
     * @author Shyam Dubey
     * @since 2025
     */
    public static function get_params(){
        if(self::$params == null){
            return $_REQUEST;
        }
        else{
            return self::$params;
        }
    }

    public static function update(Request $request){
        self::$params = $request::get_params();
        self::$headers = $request::get_headers();
    }


    

}