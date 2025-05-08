<?php

namespace OrionApi\Core;

use OrionApi\Core\Exception\ExceptionHandler;
use OrionApi\Core\Http\Router;

/**
 * This is the main Class of this framework. It acts as main entry point for all reqeusts.
 * @author Shyam Dubey
 * @since 2025
 *
 */
class App
{

    private static $global_exception_handler_class;

    /**
     * This function starts the application by ensuring that Routes are initialized and global exception handling is started.
     * @author Shyam Dubey
     * @since 2025
     */
    public static function start()
    {
        //keep this function on the first line so that it can handle all exceptions globally.
        ExceptionHandler::init(self::$global_exception_handler_class);
        Router::init();
    }

    public static function set_global_exception_handler_class($class){
        self::$global_exception_handler_class = $class;
    }
}
