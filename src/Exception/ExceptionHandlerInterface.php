<?php

namespace OrionApi\Core\Exception;

use Throwable;
/**
 * If you want to make your class as ExceptionHandler. Just create a class and implements this interface. 
 * This interface provides a method handle(Throwable $ex)
 * which will provide you the exception details in your class. Implement this function as per your choice. 
 * 
 * If you want to generate the output for the user. You can just use Response::out() function. 
 * 
 * 
 * @author Shyam Dubey
 * @since v1.0.0
 * @version 1.0.0
 */

interface ExceptionHandlerInterface {

    static function handle(Throwable $ex);
}
