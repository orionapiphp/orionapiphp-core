<?php

namespace OrionApi\Core\Middleware;

use OrionApi\Core\Http\Request;

/**
 * This interface helps to create custom Middlewares which can be used to perform any specific task before the execution of any real logic.
 * @author Shyam Dubey
 * @since 2025
 */
interface MiddlewareInterface
{

    /**
     * This function intercepts the incoming request. 
     * @author Shyam Dubey
     * @since 2025
     */
    function handle(Request $request): Request;
}
