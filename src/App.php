<?php

namespace OrionApi\Core;

use OrionApi\Core\Exception\ExceptionHandler;
use OrionApi\Core\Exception\ExceptionHandlerInterface;
use OrionApi\Core\Http\Router;

/**
 * This is the main Class of this framework. It acts as main entry point for all reqeusts.
 * @author Shyam Dubey
 * @since v1.0.0
 * @version v1.0.0
 *
 */
class App
{

    private  $global_exception_handler_class;

    /**
     * This function starts the application by ensuring that Routes are initialized and global exception handling is started.
     * @author Shyam Dubey
     * @since v1.0.0
     * @version v1.0.0
     */
    public function start()
    {
        //keep this function on the first line so that it can handle all exceptions globally.
        if($this->global_exception_handler_class == null){
            $this->global_exception_handler_class = ExceptionHandler::class;
        }
        ExceptionHandler::init($this->global_exception_handler_class);
        Router::init();

    }

    /**
     * This function sets the global exception handler class. By default we have added class @link OrionApi\Exception\ExceptionHandler 
     * which handles all the exceptions globally and generates the logs and output. 
     * Keep this function on the top of the index.php file. so that it can handle and generate logs without any unwanted output.
     * 
     * 
     * @author Shyam Dubey
     * @since v1.0.0
     * @version v1.0.0
     */
    public function start_global_exception($exception_class)
    {
        $this->global_exception_handler_class = $exception_class;
    }
}
