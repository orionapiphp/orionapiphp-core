<?php

namespace OrionApi\Core\Exception;

use Exception;
/**
 * This exception is thrown when any null value received at any point where Null values are not supposed to be.
 * 
 * 
 * @author Shyam Dubey
 * @since v1.0.0
 * @version 1.0.0
 */
class NullPointerException extends Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}