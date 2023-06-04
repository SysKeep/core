<?php

/**
 * Response Class.
 * This class provides methods for sending HTTP responses.
 * 
 * @package Components
*/


namespace Components;


final class Response{
    public int $httpCode;
    public array|object|null $body;


    /**
     * Response constructor.
     * Initialises the response with default values.
     */
    public function __construct(){
        $this->body = null;
        $this->httpCode = 204;
    }


    /**
     * Sends an response to the HTTP Request.
     * 
     * @param bool $exit Wheter to exit the program or not.
     *                   Default is set to true.
     */
    public function send(bool $exit = true): void{
        http_response_code($this->httpCode ?? 200);

        if(isset($this->body))
            echo json_encode($this->body);
        
        if($exit) exit;
    }


    /**
     * Sets the alowed HTTP Methods.
     * 
     * @param array $methods The allowed methods.
     */
    public function allowMethods(array $methods): void{
        header("Access-Control-Allow-Methods: " . implode(", ", $methods));
    }


    /**
     * Sets the Access-Control-Allow-Origin header.
     * 
     * @param array|null $origins The allowed origins.
     * 
     * @return bool True if the origin is allowed.
     *              False if the origin is not allowed.
     */
    public function allowOrigin(?array $origins): bool{
        
        if(empty($origins)){
            header("Access-Control-Allow-Origin: null");
            return false;
        }

        if(in_array("*", $origins)){
            header("Access-Control-Allow-Origin: *");
            return true;
        }

        if(!in_array($_SERVER['HTTP_ORIGIN'] ?? null, $origins))
            return false;

        header("Access-Control-Allow-Origin: " . ($_SERVER['HTTP_ORIGIN'] ?? "*"));
        return true;
    }


    /**
     * Sets the alowed Headers.
     * 
     * @param array $headers The allowed headers.
     */
    public function allowHeaders(?array $headers){
        header("Access-Control-Allow-Headers: " . implode(" ", $headers));   
    }
}


?>