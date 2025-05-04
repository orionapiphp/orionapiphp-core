<?php

namespace Core\Http;

use BadMethodCallException;
use Core\Enums\HttpStatus;
use Core\Exception\ClassNotFoundException;
use Core\Exception\InvalidCallbackException;
use Core\Exception\NotAnInstanceException;
use Core\Middleware\MiddlewareInterface;

/**
 * This class contains functions for handling requests in application.
 * @author Shyam Dubey
 * @since 2025
 */
class Router
{

    private static $middlewaresQueue = [];
    private static $routes = [];


    /**
     * This method is used to handle the get request in your application.
     * it takes two required parameters (url and callback, middlewares = []) 
     * url at which you want to perform any callback 
     * Syntax for callback function is Service@function_name 
     * @example Router::get("/user", "UserService@get_all_users);
     * middlewares are optional you can put middlewares in the method the request will pass through the middleware
     * @author Shyam Dubey
     * @since 2025
     */
    public static function get($url, $callback, $middlewares = [])
    {
        $url = $url;
        $callback = $callback;

        $route["url"] = $url;
        $route["callback"] = $callback;
        $route["method"] = 'GET';
        $route["middlewares"] = $middlewares;

        array_push(self::$routes, $route);
    }

    /**
     * This method is used to handle the post request in your application.
     * it takes two required parameters (url and callback, middlewares = []) 
     * url at which you want to perform any callback 
     * Syntax for callback function is Service@function_name 
     * @example Router::post("/user", "UserService@save_user);
     * middlewares are optional you can put middlewares in the method the request will pass through the middleware
     * @author Shyam Dubey
     * @since 2025
     */
    public static function post($url, $callback, $middlewares = [])
    {
        $url = $url;
        $callback = $callback;

        $route["url"] = $url;
        $route["callback"] = $callback;
        $route["method"] = 'POST';
        $route["middlewares"] = $middlewares;

        array_push(self::$routes, $route);
    }

    /**
     * This method is used to handle the delete request in your application.
     * it takes two required parameters (url and callback, middlewares = []) 
     * url at which you want to perform any callback 
     * Syntax for callback function is Service@function_name 
     * @example Router::delete("/user/{user_id}", "UserService@delete_by_id);
     * middlewares are optional you can put middlewares in the method the request will pass through the middleware
     * @author Shyam Dubey
     * @since 2025
     */
    public static function delete($url, $callback, $middlewares = [])
    {
        $url = $url;
        $callback = $callback;

        $route["url"] = $url;
        $route["callback"] = $callback;
        $route["method"] = 'DELETE';
        $route["middlewares"] = $middlewares;

        array_push(self::$routes, $route);
    }

    /**
     * This method is used to handle the put request in your application.
     * it takes two required parameters (url and callback, middlewares = []) 
     * url at which you want to perform any callback 
     * Syntax for callback function is Service@function_name 
     * @example Router::put("/user", "UserService@update_user);
     * middlewares are optional you can put middlewares in the method the request will pass through the middleware
     * @author Shyam Dubey
     * @since 2025
     */
    public static function put($url, $callback, $middlewares = [])
    {
        $url = $url;
        $callback = $callback;

        $route["url"] = $url;
        $route["callback"] = $callback;
        $route["method"] = 'PUT';
        $route["middlewares"] = $middlewares;

        array_push(self::$routes, $route);
    }

    /**
     * This method is used to handle the merge request in your application.
     * it takes two required parameters (url and callback, middlewares = []) 
     * url at which you want to perform any callback 
     * Syntax for callback function is Service@function_name 
     * @example Router::merge("/user", "UserService@any_function);
     * middlewares are optional you can put middlewares in the method the request will pass through the middleware
     * @author Shyam Dubey
     * @since 2025
     */
    public static function merge($url, $callback, $middlewares = [])
    {
        $url = $url;
        $callback = $callback;

        $route["url"] = $url;
        $route["callback"] = $callback;
        $route["method"] = 'MERGE';
        $route["middlewares"] = $middlewares;

        array_push(self::$routes, $route);
    }


    private static function handle($url, $callback, $requestMethod, $params = [], $middlewares = [])
    {

        if ($_SERVER['REQUEST_METHOD'] != $requestMethod) {
            throw new BadMethodCallException("Method not allowed.");
        }

        $params["request_body"] = Request::get_body();

        $request = new Request();
        if (count($middlewares) > 0) {
            self::$middlewaresQueue = array_merge($middlewares);
        }

        foreach (self::$middlewaresQueue as $middleware) {
            $m = new $middleware;
            if (!$m instanceof MiddlewareInterface) {
                throw new NotAnInstanceException($m::class . " is not instance of " . MiddlewareInterface::class);
            }
            $request = $m->handle($request);
            Request::update($request);
        }

        if (!stripos($callback, "@")) {
            throw new InvalidCallbackException("Invalid Callback Function Provided. Please ensure your call back function consists @ symbol to separate the controller and fucntion.");
        }
        $arr = explode("@", $callback);
        $controller = $arr[0];
        $controller_method = $arr[1];


        if (class_exists($controller) && method_exists($controller, $controller_method)) {
            $instance = new $controller;
            $instance->$controller_method($params);
        } else {
            throw new ClassNotFoundException($controller . " Class Not Found.");
        }
    }


    /**
     * This method searches for all the routes which you have added in index.php file. 
     * This function should be placed at the end of index.php so that it searches for the routes after the routes are registered.
     * @author Shyam Dubey
     * @since 2025
     */
    public static function init()
    {
        $routeUri = $_SERVER['REQUEST_URI'];
        if (count(self::$routes) > 0) {
            $route_found = false;
            foreach (self::$routes as $route) {
                $url = trim($routeUri, '/');

                $patternRegex = preg_replace('/\{(\w+)\}/', '(?P<\1>[^/]+)', trim($route['url'], '/'));
                $patternRegex = "@^" . $patternRegex . "$@";

                if (preg_match($patternRegex, $url, $matches)) {
                    $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                    $route_found = true;
                    self::handle($route['url'], $route['callback'], $route['method'], $params, $middleware = $route['middlewares']);
                }
                // }
            }
            if (!$route_found) {
                Response::json(HttpStatus::NOT_FOUND, ["message" => "Not Found"]);
            }
        } else {
            Response::json(HttpStatus::NOT_FOUND, ["message" => "Not Found"]);
        }
    }
}
