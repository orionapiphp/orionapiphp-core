<?php


namespace OrionApi\Core\Security;

use OrionApi\Core\Enums\HttpStatus;
use OrionApi\Core\Exception\UnauthorizedException;

/**
 * This class provides CORS configuration
 * @author Shyam Dubey
     * @since v1.0.0
     * @version v1.0.0
 */
class CorsSecurity
{

    private static $allowed_domains = [];



    public static function set_allowed_domain($allowed_domain)
    {
        self::$allowed_domains = array($allowed_domain);
    }


    /**
     * This function ensures that cors and disabled or enabled and which cors are allowed
     * You can modify the behaviour in @link App\\Setting.php file.
     * @author Shyam Dubey
     * @since v1.0.0
     * @version v1.0.0
     */
    public static function init($allowed_domain)
    {

        self::$allowed_domains = $allowed_domain;

        // Allow from any origin
        header("Access-Control-Allow-Origin: *");

        // Allow specific methods
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

        // Allow specific headers
        header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

        // Handle preflight requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            http_response_code(HttpStatus::OK->value);
            exit;
        }
        $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : "";
        if (!in_array("*", self::$allowed_domains) && !in_array($host, self::$allowed_domains)) {
            throw new UnauthorizedException("Invalid Domain. Add this domain in Settings under variable CORS_DOMAINS");
        }
    }
}
