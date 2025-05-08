<?php


namespace OrionApi\Core\Exception;

use InvalidArgumentException;
use OrionApi\Core\Enums\HttpStatus;
use OrionApi\Core\Http\Response;
use OrionApi\Core\Log\LoggerFactory;
use Throwable;

/**
 * This class handles the Exceptions globally and generates the response based on the exception.
 * @author Shyam Dubey
 * @since 2025
 */
class ExceptionHandler
{

    private static LoggerFactory $logger;

    /**
     * This function initiate the Exception Handler Globally. All the exceptions will be handled by this method.
     * Please ensure you place this method on the top of index.php file. So that it can handle every exception in your application.
     * @author Shyam Dubey
     * @since 2025
     */
    public static function init($class)
    {
        if($class == null){
            throw new InvalidArgumentException("Class name can not be null.");
        }
        if(!class_exists($class)){
            $class = self::class;
        }
        self::$logger = LoggerFactory::get_logger($class);
        set_exception_handler([$class, 'handle']);
    }


    /**
     * Do not use this function directly. Global exception handles it automatically.
     * @author Shyam Dubey
     * @since 2025
     */
    public static function handle(Throwable $ex)
    {
        $message = $ex->getMessage();
        $stacktrace = $ex->getTraceAsString();
        $response["message"] = $message;
        $response["stacktrace"] = $stacktrace;
        $response["statusCode"] = HttpStatus::INTERNAL_SERVER_ERROR->value;
        $response["time"] = time();
        self::$logger->error(json_encode($response));
        Response::json(HttpStatus::INTERNAL_SERVER_ERROR, $response);
    }
}
