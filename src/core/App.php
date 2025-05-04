<?php

namespace Core;

use Core\Exception\ExceptionHandler;
use Core\Http\Router;

/**
 * This is the main Class of this framework. It acts as main entry point for all reqeusts.
 * @author Shyam Dubey
 * @since 2025
 *
 */
class App
{

    /**
     * This function starts the application by ensuring that Routes are initialized and global exception handling is started.
     * @author Shyam Dubey
     * @since 2025
     */
    public static function start()
    {
        //keep this function on the first line so that it can handle all exceptions globally.
        ExceptionHandler::init();
        Router::init();
    }
}
