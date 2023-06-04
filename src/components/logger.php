<?php

/**
 * Logger Class.
 * This class provides logging functionality.
 * 
 * @package Components\Logger
 */


namespace Components\Logger;

class Types{
    const INFO = "INFO";
    const NOTICE = "NOTICE";
    const WARNING = "WARNING";
    const ERROR = "ERROR";
}

final class Logger{
    public bool $enabled;
    protected string $fileName;
    public ?array $additionalContent;


    /**
     * Logger constructor.
     * Initializes the Logger object with settings for logging.
     *
     * @param bool        $enabled             Whether logging is enabled or not.
     * @param string|null $fileName            The name of the log file.
     * @param array|null  $additionalContent   Additional content to be included in the log message.
     */
    public function __construct(bool $enabled, ?string $fileName = null, ?array $additionalContent = null){
        $this->enabled = $enabled;
        $this->fileName = $fileName;
        $this->additionalContent = $additionalContent;
    }

    /**
     * Logs a message with the specified type.
     *
     * @param string $message   The message to be logged.
     * @param string $type      The type of the log message.
     */
    protected function log(string $message, string $type): void{
        if($this->enabled)
            error_log(
                '[' . date('d/m/Y H:i:s') . "][$type]" .
                (isset($this->additionalContent) ? ("[" . implode("][", $this->additionalContent) . "]") : "") .
                ": $message" . PHP_EOL,
                3,
                $this->fileName
            );
    }
    
    /**
     * Logs an info message.
     *
     * @param string $message The message to be logged.
     */
    public function info(string $message): void{
        $this->log($message, Types::INFO);
    }

    /**
     * Logs an notice message.
     *
     * @param string $message The message to be logged.
     */
    public function notice(string $message): void{
        $this->log($message, Types::NOTICE);
    }

    /**
     * Logs an warning message.
     *
     * @param string $message The message to be logged.
     */
    public function warning(string $message): void{
        $this->log($message, Types::WARNING);
    }

    /**
     * Logs an error message.
     *
     * @param string $message The message to be logged.
     */
    public function error(string $message): void{
        $this->log($message, Types::ERROR);
    }

}

?>