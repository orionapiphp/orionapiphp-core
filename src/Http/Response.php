<?php

namespace OrionApi\Core\Http;

use OrionApi\Core\Enums\HttpStatus;
use OrionApi\Core\Exception\InvalidResponseTypeException;

/**
 * This class is responsible for returning the response back to the user.
 * 
 * @author Shyam Dubey
 * @since v1.0.0
 * @version v1.0.0
 */
class Response
{

    private static $data;
    private static HttpStatus $statusCode;
    private static $return_type;
    public const RETURN_TYPE_JSON = "JSON";
    private static $headers;


    private function __construct($data, HttpStatus $status, $return_type = Response::RETURN_TYPE_JSON)
    {
        self::$data = $data;
        self::$statusCode = $status;
        self::$return_type = $return_type;
    }


    /**
     * Ensures that the output is json. Takes two params HttpStatus and $data
     * Content-type:application/json
     * 
     * @author Shyam Dubey
     * @since v1.0.0
     * @version v1.0.0
     */
    public static function json(HttpStatus $statusCode, $data)
    {
        self::$statusCode = $statusCode;
        self::$data = $data;
        $return_type = self::RETURN_TYPE_JSON;
        return new Response($data, $statusCode, $return_type);
    }


    /**
     * Return the data in the response
     * 
     * @author Shyam Dubey
     * @since v1.0.0
     * @version v1.0.0
     */
    public static function get_data()
    {
        return self::$data;
    }


    /**
     * Returns the response status code [200,404,500 etc]
     * @author Shyam Dubey
     * @since v1.0.0
     * @version v1.0.0
     */
    public static function get_status_code()
    {
        return self::$statusCode->value;
    }


    /**
     * returns the Return type of response [JSON]
     * 
     * @author Shyam Dubey
     * @since v1.0.0
     * @version v1.0.0
     */
    public static function get_return_type()
    {
        return self::$return_type;
    }


    /**
     * This function prints the output to the end user directly. Execution of request terminates here. 
     * As soon as you write Response::out() anywhere in the code. The request terminates there and
     * JSON output is generated.
     * 
     * @author Shyam Dubey
     * @since v1.0.0
     * @version v1.0.0
     */
    public static function out(HttpStatus $status, $data, $return_type = Response::RETURN_TYPE_JSON)
    {
        if ($return_type != Response::RETURN_TYPE_JSON) {
            throw new InvalidResponseTypeException("Invalid response type provided.");
        }

        header("content-type:application/json");
        http_response_code($status->value);
        echo json_encode($data);
        die();
        return;
        exit(0);
    }


    /**
     * Returns the headers in response
     * 
     * @author Shyam Dubey
     * @since v1.0.0
     * @version v1.0.0
     */
    public static function get_headers()
    {
        self::$headers = headers_list();
        return self::$headers;
    }
}
