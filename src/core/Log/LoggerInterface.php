<?php

namespace Core\Log;

/**
 * LoggerInterface provides key functions for logging the messages in application.
 * @author Shyam Dubey
 * @since 2025
 */
interface LoggerInterface
{


    static function get_logger($className);
    function log($message);
    function info($message);
    function warn($message);
    function error($message);
}
