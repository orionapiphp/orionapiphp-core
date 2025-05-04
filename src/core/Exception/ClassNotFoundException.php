<?php


namespace Core\Exception;

use Exception;

class ClassNotFoundException extends Exception{


    public function __construct($message = "Class Not Found"){
        parent::__construct($message);
    }
    
}