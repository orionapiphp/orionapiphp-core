<?php

namespace OrionApi\Core\Http;

use OrionApi\Core\Enums\HttpStatus;

/**
 * This class is responsible for returning the response back to the user.
 * @author Shyam Dubey
 * @since 2025
 */
class Response
{

    private static $data;
    private static HttpStatus $statusCode;


    /**
     * Returns the output in form of JSON. 
     * Content-type:application/json
     * @author Shyam Dubey
     * @since 2025
     */
    public static function json(HttpStatus $statusCode, $data)
    {
        self::$statusCode = $statusCode;
        self::$data = $data;
        header("Content-type:application/json");
        http_response_code($statusCode->value);
        return json_encode($data);
    }


    public static function get_data()
    {
        return self::$data;
    }

    public static function get_status_code()
    {
        return self::$statusCode;
    }

}
