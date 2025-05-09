<?php

namespace OrionApi\Core\Exception;

use Exception;
/**
 * This exception is thrown when any resource is not found.
 * @author Shyam Dubey
 * @since v1.0.0
 * @version 1.0.0
 */
class ResourceNotFoundException extends Exception
{

    public function __construct($message)
    {
        parent::__construct($message);
    }
}