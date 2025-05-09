<?php

namespace OrionApi\Core\Exception;

use Exception;
/**
 * 
 * This exception is thrown when any middleware or exceptionhandler does not implements the interface. 
 * It can be used in your code to ensure that the object is not instance of any class.
 * 
 * 
 * 
 * @author Shyam Dubey
 * @since v1.0.0
 * @version 1.0.0
 */
class NotAnInstanceException extends Exception{

    public function __construct($message)
    {
        parent::__construct($message);
    }
}