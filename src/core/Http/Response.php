<?php

namespace Core\Http;

use Core\Enums\HttpStatus;

/**
 * This class is responsible for returning the response back to the user.
 * @author Shyam Dubey
 * @since 2025
 */
class Response
{

    /**
     * Returns the output in form of JSON. 
     * Content-type:application/json
     * @author Shyam Dubey
     * @since 2025
     */
    public static function json(HttpStatus $statusCode, $data)
    {
        header("Content-type:application/json");
        http_response_code($statusCode->value);
        echo json_encode($data);
        die();
    }
}
