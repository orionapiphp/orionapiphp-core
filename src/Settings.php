<?php

namespace OrionApi\Core;

use OrionApi\Core\Log\LogPattern;

class Settings{
    
    const CORS_DOMAINS = "*";
    const LOG_IN_CUSTOM_DIR = true;
    const LOG_DIR = __DIR__."/../logs/";
    const LOG_FILE_PATTERN = LogPattern::DDMMYYYY_LOGS;
}