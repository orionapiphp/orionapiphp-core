<?php

namespace OrionApi\Core\Http;

use BadMethodCallException;
use OrionApi\Core\Enums\HttpStatus;
use OrionApi\Core\Exception\ClassNotFoundException;
use OrionApi\Core\Exception\InvalidResponseTypeException;
use OrionApi\Core\Exception\MethodNotFoundException;
use OrionApi\Core\Exception\NotAnInstanceException;
use OrionApi\Core\Exception\ResourceNotFoundException;
use OrionApi\Core\Middleware\MiddlewareInterface;

/**
 * This class contains functions for handling requests in application.
 * @author Shyam Dubey
 * @since v1.0.0
 * @version v1.0.0
 */
class Router
{

    private static $middlewaresQueue = [];
    private static $global_middlewares = [];
    private static $routes = [];
    private static $exempted_routes = [];


    /**
     * This method is used to handle the get request in your application.
     * it takes two required parameters (url and callback, middlewares = []) 
     * url at which you want to perform any callback 
     * Syntax for callback function is Service@function_name 
     * @example Router::get("/user", "UserService@get_all_users); 
     * This Router will now call the function get_all_users() of UserService.
     * middlewares are optional you can put middlewares in the method the request will pass through the middleware
     * @author Shyam Dubey
     * @since v1.0.0
     * @version v1.0.0
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
     * This Router will now call the function get_all_users() of UserService.
     * middlewares are optional you can put middlewares in the method the request will pass through the middleware
     * @author Shyam Dubey
     * @since v1.0.0
     * @version v1.0.0
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
     * Now how you will get the {user_id} value in function delete_by_id($params) 
     * 
     * 
     * Declare a variable in function like 
     * 
     * --------------------------------------------------------
     * 
     * 
     * class UserService {
     * 
     *    public function delele_by_id($params){
     *          $user_id = $params['user_id']  ////// the user_id should be same as you have written in your Router::delete
     *      }
     * }
     * 
     * After gettig the $user_id you can perform action to delete the user. 
     * middlewares are optional you can put middlewares in the method the request will pass through the middleware
     * @author Shyam Dubey
     * @since v1.0.0
     * @version v1.0.0
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
     * 
     * 
     * You can get the Request_body by using the Request::get_body() function anywhere in the classes.
     * 
     * middlewares are optional you can put middlewares in the method the request will pass through the middleware
     * @author Shyam Dubey
     * @since v1.0.0
     * @version v1.0.0
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
     * @since v1.0.0
     * @version v1.0.0
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


        $request = new Request($url);
        if (gettype($middlewares) == 'object') {
            array_push(self::$middlewaresQueue, $middlewares);
        } else if (count($middlewares) > 0) {
            self::$middlewaresQueue = array_merge($middlewares);
        }

        if (count(self::$exempted_routes) == 0 && count(self::$global_middlewares) > 0) {
            self::$middlewaresQueue = array_merge(self::$middlewaresQueue, self::$global_middlewares);
        } else if (count(self::$exempted_routes) > 0) {
            if (!in_array($url, self::$exempted_routes)) {
                self::$middlewaresQueue = array_merge(self::$middlewaresQueue, self::$global_middlewares);
            }
        }

        foreach (self::$middlewaresQueue as $middleware) {
            $m = new $middleware;
            if (!$m instanceof MiddlewareInterface) {
                throw new NotAnInstanceException($m::class . " is not instance of " . MiddlewareInterface::class);
            }
            $request = $m->handle_request($request);
            Request::update($request);
        }
        $params["request_body"] = Request::get_body();

        if(gettype($callback) == 'array' || gettype($callback) == 'object' ){
            Response::out(HttpStatus::OK, $callback);
            
        }
        else if (!stripos($callback, "@")) {
            // throw new InvalidCallbackException("Invalid Callback Function Provided. Please ensure your call back function consists @ symbol to separate the controller and function.");
            Response::out(HttpStatus::OK, $callback);
            
        }
        $arr = explode("@", $callback);
        $controller = $arr[0];
        $controller_method = $arr[1];


        if (class_exists($controller)) {
            if(!method_exists($controller, $controller_method)){
                throw new MethodNotFoundException($controller_method." method not found in class ".$controller);
            }
            $instance = new $controller;
            $response = $instance->$controller_method($params);
            if (!$response instanceof Response) {
                $response = Response::json(HttpStatus::OK, $response);
            }
            foreach (self::$middlewaresQueue as $middleware) {
                $m = new $middleware;
                if (!$m instanceof MiddlewareInterface) {
                    throw new NotAnInstanceException($m::class . " is not instance of " . MiddlewareInterface::class);
                }
                $response = $m->handle_response($response);
            }
            if ($response instanceof Response) {
                if ($response->get_return_type() == Response::RETURN_TYPE_JSON) {
                    header("content-type:application/json");
                    http_response_code($response->get_status_code());
                    echo json_encode($response->get_data());
                    die();
                } else {
                    throw new InvalidResponseTypeException("Invalid Response Type. It should be Response::json()");
                }
            } else {
                throw new InvalidResponseTypeException("Invalid Response Type. It should be Response::json()");
            }
        } else {
            throw new ClassNotFoundException($controller . " Class Not Found.");
        }
    }


    /**
     * This method searches for all the routes which you have added in index.php file. 
     * 
     * @author Shyam Dubey
     * @since v1.0.0
     * @version v1.0.0
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
                throw new ResourceNotFoundException("Not Found");
                //    echo Response::out(HttpStatus::NOT_FOUND, ["message" => "Not Found"]);
            }
        } else {
            throw new ResourceNotFoundException("Not Found");
            //    echo Response::out(HttpStatus::NOT_FOUND, ["message" => "Not Found"]);
        }
    }


    /** 
     * This function takes array of middlewares which applied on each request. It sets these global middlewares on every route.
     * Use this to set the middlewares on each route.
     * 
     * 
     * If you want to exempt some routes from these global middlewares, you can provide those routes as a second parameter in the form of array. 
     * 
     * The name should be exact match of what you have written in Route::get()post() ... etc functions.
     * 
     * @author Shyam Dubey
     * @since v1.0.0
     * @version v1.0.0
     */
    public static function set_global_middlewares($middlewares, $except = [])
    {
        if (gettype($middlewares) == 'array') {
            self::$global_middlewares = array_merge(self::$global_middlewares, $middlewares);
        } else {
            array_push(self::$global_middlewares, $middlewares);
        }

        self::$exempted_routes = $except;
    }
}
