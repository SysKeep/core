<?php
/**
 * This endpoint handles the users in the database/ directory
 * Please refer to user.md to know how to use it
 * 
 * @author Sebastiano Racca
 */


switch($_SERVER['REQUEST_METHOD']){

    case "POST": // Creating a new user

        $noAuthRequired = true;

        $requiredKeys = [
            "username",
            "password",
            "name",
            "surname",
        ];

        require_once "../apiEnvirorment.php";


        $db = new Components\Database($values["username"], $values["password"]);

        // Creating the database
        if($db->new($values["name"], $values["surname"])){
            $response->httpCode = 204;

            $logger->notice("User created.");

        } else{
            $response->httpCode = 409;
            $response->body = ["error" => "The user already exists"];

            $logger->warning("User already exists.");
        }


        break;
        
    case "GET": // Info about the user
        require_once "../apiEnvirorment.php";

        $response->httpCode = 200;
        $response->body = $db->getUser();

        break;

    case "DELETE": // Delete the user

        require_once "../apiEnvirorment.php";

        if($db->delete()){
            $response->httpCode = 204;

            $logger->notice("User deleted.");
        }

        break;


    case "OPTIONS":
        $noAuthRequired = true;
        require_once "../apiEnvirorment.php";
        
        $response->httpCode = 204;
        break;

    default: // Other request methods
        $noAuthRequired = true;
        require_once "../apiEnvirorment.php";
        
        $response->httpCode = 405;
        $response->body = ["error" => "Invalid Request Method"];
}


$response->allowMethods(["OPTIONS", "GET", "POST", "DELETE"]);
$response->send();


?>