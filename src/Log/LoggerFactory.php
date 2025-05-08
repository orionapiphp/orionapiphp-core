<?php


namespace OrionApi\Core\Log;

use OrionApi\Core\Settings;
use OrionApi\Core\Enums\HttpStatus;
use OrionApi\Core\Http\Response;
use Exception;
use InvalidArgumentException;
use OrionApi\Core\Exception\ClassNotFoundException;

/**
 * This class is factory class for providing log features. It generates the log in logs directory in the given format.
 * @author Shyam Dubey
 * @since 2025
 */
class LoggerFactory implements LoggerInterface
{

    private static $className;
    private $log_dir;


    public function set_log_dir($dir){
        $this->log_dir = $dir;
    }


    /**
     * Get the Logger Instance.
     * @author Shyam Dubey
     * @since 2025
     */
    public static function get_logger($className)
    {
        self::$className = $className;
        return new LoggerFactory($className);
    }



    /**
     * For Logging messages of type INFO.
     * @author Shyam Dubey
     * @since 2025
     */
    public function log($message)
    {
        $final_message = date("Y-m-d h:i:s", time()) . " | INFO | " . self::$className . ".php | " . $message;
        $this->logMessage($final_message);
    }


    /**
     * For logging messages of type INFO
     * @author Shyam Dubey
     * @since 2025
     */
    public function info($message)
    {
        $final_message = date("Y-m-d h:i:s", time()) . " | INFO | " . self::$className . ".php | " . $message;
        $this->logMessage($final_message);
    }



    /**
     * For logging messages of type WARN
     * @author Shyam Dubey
     * @since 2025
     */
    public function warn($message)
    {
        $final_message = date("Y-m-d h:i:s", time()) . " | WARN | " . self::$className . ".php | " . $message;
        $this->logMessage($final_message);
    }



    /**
     * For logging messages of type ERROR
     * @author Shyam Dubey
     * @since 2025
     */
    public function error($message)
    {
        $final_message = date("Y-m-d h:i:s", time()) . " | ERROR | " . self::$className . ".php | " . $message;
        $this->logMessage($final_message);
    }



    /**
     * This is private function which enters the data in log file for any of the function mentioned in this class like log(), info(), warn(), error():
     * @author Shyam Dubey
     * @since 2025
     */
    private function logMessage($fullMessage)
    {
        //check whether user want to log the message in custom directory
        if (!class_exists(Settings::class)) {
            throw new ClassNotFoundException(Settings::class . " class not found.");
        }
        $dir = $this->log_dir;
        if($dir == null){
            throw new InvalidArgumentException("Could not found log directory. Set the log directory by LoggerFactory->set_log_dir() function.");
        }
        try {
            if (is_dir($dir)) {
                $logPattern = Settings::LOG_FILE_PATTERN;
                $logPatternCases = LogPattern::cases();
                if (!in_array($logPattern, $logPatternCases)) {
                    throw new Exception("Log pattern could not be found. It should be one of the following " . implode(", ", $logPatternCases));
                }
                if ($logPattern == LogPattern::DDMMYYYY_LOGS) {
                    $today = date("Y-m-d", time());
                    $file_name = $dir . "/" . $today . "_logs.log";
                    if (!file_exists($file_name)) {
                        $f = fopen($file_name, "w");
                    } else {
                        $f = fopen($file_name, "a");
                    }
                    fwrite($f, $fullMessage . "\n");
                }
            } else {
                mkdir($dir, 744);
            }
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $stacktrace = $ex->getTraceAsString();
            $response["message"] = $message;
            $response["stacktrace"] = $stacktrace;
            $response["statusCode"] = HttpStatus::INTERNAL_SERVER_ERROR->value;
            $response["time"] = time();
            echo Response::json(HttpStatus::INTERNAL_SERVER_ERROR, $response);
        }
    }
}
