<?php

namespace OrionApi\Core\Exception;

use Exception;
/**
 * This exception is thrown when the response type of generated response is not matched to what other functions, classes needs.
 * Mostly used to verify during returning the output to the end user.
 * 
 * 
 * @author Shyam Dubey
 * @since v1.0.0
 * @version 1.0.0
 */
class InvalidResponseTypeException extends Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}