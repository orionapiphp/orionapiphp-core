<?php 

namespace OrionApi\Core\Exception;

use Exception;
/**
 * This exception is thrown when any url is hitted with incorrect Method [GET, POST, PUT, DELETE, MERGE]
 * 
 * 
 * @author Shyam Dubey
 * @since v1.0.0
 * @version 1.0.0
 */
class MethodNotAllowedException extends Exception{

    public function __construct($message){
        parent::__construct($message);
    }


    
    
}

