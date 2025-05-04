<?php

namespace Core\Exception;

use Exception;

class NotAnInstanceException extends Exception{

    public function __construct($message)
    {
        parent::__construct($message);
    }
}