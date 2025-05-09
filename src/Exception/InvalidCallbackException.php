<?php

namespace OrionApi\Core\Exception;

use Exception;

/**
 * InvalidCallbackException is generated if the callback function which you have mentioned in Router::get() function is not found.
 * 
 * @author Shyam Dubey
 * @since v1.0.0
 * @version 1.0.0
 */
class InvalidCallbackException extends Exception{


    public function __construct($message){
        if(strlen($message) == 0){
            $message = "Invalid Callback Function Provided.";
        }
        parent::__construct($message);
    }

}