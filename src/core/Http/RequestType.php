<?php


namespace Core\Http;

/**
 * This class ensures the type of any request which is coming to the server.
 * @author Shyam Dubey
 * @since 2025
 */
class RequestType
{


    /**
     * This class ensures the type of any request is GET.
     * @author Shyam Dubey
     * @since 2025
     */
    public static function get()
    {
        if (RequestType::get_request_type() == 'GET') {
            return true;
        } else {
            return false;
        }
    }


    /**
     * This class ensures the type of any request is POST.
     * @author Shyam Dubey
     * @since 2025
     */
    public static function post()
    {
        if (RequestType::get_request_type() == 'POST') {
            return true;
        } else {
            return false;
        }
    }


    /**
     * This class ensures the type of any request is DELETE.
     * @author Shyam Dubey
     * @since 2025
     */
    public static function delete()
    {
        if (RequestType::get_request_type() == 'DELETE') {
            return true;
        } else {
            return false;
        }
    }


    /**
     * This class ensures the type of any request is PUT.
     * @author Shyam Dubey
     * @since 2025
     */
    public static function put()
    {
        if (RequestType::get_request_type() == 'PUT') {
            return true;
        } else {
            return false;
        }
    }


    /**
     * This class ensures the type of any request is MERGE.
     * @author Shyam Dubey
     * @since 2025
     */
    public static function merge()
    {
        if (RequestType::get_request_type() == 'MERGE') {
            return true;
        } else {
            return false;
        }
    }


    private static function get_request_type()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}
