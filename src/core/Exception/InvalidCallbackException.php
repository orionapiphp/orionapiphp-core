<?php

namespace Core\Exception;

use Exception;

class InvalidCallbackException extends Exception{


    public function __construct($message){
        if(strlen($message) == 0){
            $message = "Invalid Callback Function Provided.";
        }
        parent::__construct($message);
    }

}