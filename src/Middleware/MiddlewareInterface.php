<?php

namespace OrionApi\Core\Middleware;

use OrionApi\Core\Http\Request;
use OrionApi\Core\Http\Response;

/**
 * This interface helps to create custom Middlewares which can be used to perform any specific task before the execution of any real logic.
 * @author Shyam Dubey
 * @since v1.0.0
 * @version v1.0.0
 */
interface MiddlewareInterface
{

    /**
     * This function intercepts the incoming request. 
     * @author Shyam Dubey
     * @since v1.0.0
     * @version v1.0.0
     */
    function handle_request(Request $request): Request;

    /**
     * This function intercepts the outgoing response. 
     * @author Shyam Dubey
     * @since v1.0.0
     * @version v1.0.0
     */
    function handle_response(Response $response): Response;
}
