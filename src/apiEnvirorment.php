<?php

/**
 * This file should be included in every endpoint.
 * Its porpuse is to validate credentials (if needed) and set some additional vars.
 * 
 * @author Sebastiano Racca
 */

require_once __DIR__ . "/base.php";

// Setting up the reponse
$response = new Components\Response();

header("Content-Type: application/json");


// Checks if the origin is allowed
if(!$response->allowOrigin(($_ENV['ALLOWED_ORIGINS'] == "") ? null : explode(" ", $_ENV['ALLOWED_ORIGINS']))){
    
    $logger->notice("The origin was denied.");

    $response->httpCode = 403;
    $response->body = ["error" => "Request not allowed from this origin"];
    $response->send();
}



// The user needs the Authorization header to proceed
if(!($noAuthRequired ?? false)){
    $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? false;
    
    // There is an Authorization header
    if ($authHeader){
        $authHeader = explode(' ', $authHeader);

        if (count($authHeader) === 2){

            if($authHeader[0] === 'Basic'){
                $auth = explode(':', base64_decode($authHeader[1]));
                $validAuth = true;
            }

        }

    }


    // The Authorization header is not valid
    if(!($validAuth ?? false)){
        $response->httpCode = 400;
        $response->body = ["error" => "Invalid Authorization header format"];
        $response->send();
    }



    $db = new Components\Database($auth[0] ?? "", $auth[1] ?? "", $logger);
    $logger->additionalContent[] = $auth[0];

    // Credentials are invalid
    if(!$db->load()){
        $logger->warning("Invalid Authorization credentials.");

        $response->httpCode = 401;
        $response->body = ["error" => "Invalid Authorization credentials"];
        $response->send();
    }


}

// Where the request methods will get their contents
$requestMethod = match($_SERVER['REQUEST_METHOD']){
    "POST" => $_POST,
    "GET" => $_GET,
    "DELETE" => $_GET,
    default => json_decode(file_get_contents('php://input'), true)
};

// Checking required keys
if(isset($requiredKeys)){
    // Check if all $requiredKeys are set in $requestMethod
    if(count(array_diff_key(array_flip($requiredKeys), $requestMethod)) > 0){
        
        $response->httpCode = 400;
        $response->body = ["error" => "Must specify all the required fields (" . implode(", ", $requiredKeys) . ")"];
        $response->send();

    }


    $values = array_intersect_key($requestMethod, array_flip($requiredKeys));

}

// Checking optional keys
if(isset($availableKeys)){
    $values = array_intersect_key($requestMethod, array_flip($availableKeys));

    if(($atLeastOneKey ?? false) && count($values) <= 0){
        $response->httpCode = 400;
        $response->body = ["error" => "Must specify at least one key (" . implode(", ", $availableKeys) . ")"];
        $response->send();
    }
}





?>