<?php

namespace OrionApi\Core\Log;

/**
 * LoggerInterface provides key functions for logging the messages in application.
 * @author Shyam Dubey
 * @since v1.0.0
 * @version v1.0.0
 */
interface LoggerInterface
{


    static function get_logger($className);
    function log($message);
    function info($message);
    function warn($message);
    function error($message);
}
