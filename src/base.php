<?php
/**
 * The porpuse of this file is to inizialise varibles and include all the required components.
 * 
 * @author Sebastiano Racca
 */

require_once __DIR__ . "/../vendor/autoload.php";

define("ROOT_DIR", substr_replace(__DIR__, "", strrpos(__DIR__, "src"), strlen("src")));

// Loading .env variables
if (file_exists(ROOT_DIR . ".env")) {
    $dotenv = Dotenv\Dotenv::createImmutable(ROOT_DIR);
    $dotenv->load();
}

$logger = new Components\Logger\Logger(
    (bool)($_ENV['LOGGER'] ?? false),
    ROOT_DIR . "log/syskeep.log",
    array_filter([
        $_SERVER['HTTP_ORIGIN'] ?? null,
        $_SERVER['REMOTE_ADDR'] ?? null,
        $_SERVER['HTTP_X_FORWARDED_FOR'] ?? null,
        $_SERVER['REQUEST_METHOD'] ?? null,
    ])
);





?>