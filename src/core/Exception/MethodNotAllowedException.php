<?php 

namespace Core\Exception;

use Exception;

class MethodNotAllowedException extends Exception{

    public function __construct($message){
        parent::__construct($message);
    }


    
    
}

