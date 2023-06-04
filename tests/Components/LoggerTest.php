<?php

/**
 * Tests for the Components\Logger\* classes.
 * 
 * @author Sebastiano Racca
 */


require_once __DIR__ . "/../bootstrap.php";
require_once ROOT_DIR . "/src/components/logger.php";

use PHPUnit\Framework\TestCase;
use Components\Logger\Logger;
use Components\Logger\Types;

class LoggerTest extends TestCase{

    /**
     * Test logging methods of the Logger class.
     * 
     * This test creates an instance of the Logger class with logging enabled
     * and specifies the log file path as "log/test.log". It then calls various
     * logging methods (info, notice, warning, error) with a test message. 
     * The purpose of this test is to ensure that the logging methods execute 
     * without throwing any exceptions.
     */
    public function testLogging(){
        $logger = new Logger(true, "log/test.log");
        $message = "This is a test message";

        $logger->info($message);
        $logger->notice($message);
        $logger->warning($message);
        $logger->error($message);

        $this->assertTrue(true);
    }
}

?>