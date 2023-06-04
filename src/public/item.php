<?php
/**
 * This endpoint handles the items in the vault
 * Please refer to the doc/methods/item.md to know how to use it
 * 
 * @author Sebastiano Racca
 */



switch($_SERVER['REQUEST_METHOD']){

    case "POST": // Creating a new item

        if(isset($_ENV['ALLOWED_ITEM_KEYS']))
            $availableKeys = explode(" ", $_ENV['ALLOWED_ITEM_KEYS']);
        else {
            $availableKeys = [
                "type",
                "website",
                "username",
                "password",
                "description",
            ];
        }
        
        $atLeastOneKey = true;

        require_once "../apiEnvirorment.php";

        // Creating the item
        $newItem = $db->newItem($values);

        if($newItem !== false){
            $response->httpCode = 204;
            $logger->additionalContent[] = $newItem;
            $logger->notice("Item creted.");
        }

        break;
        
    case "GET": // Retrieving info about an item or all the items in the vault

        $availableKeys = [
            "id",
        ];

        require_once "../apiEnvirorment.php";

        if(isset($values["id"])){
            $item = $db->getOneItem($values["id"]);

            if($item){ // The item was found

                $response->httpCode = 200;
                $response->body = $item;

            } else{

                $response->httpCode = 404;
                $response->body = ["error" => "Item not found"];

            }

        } else{
            $response->httpCode = 200;
            $response->body = $db->getAllItems();
        }

        break;

    case "DELETE": // Deleting an item

        $requiredKeys = [
            "id",
        ];

        require_once "../apiEnvirorment.php";

        if($db->deleteItem($values["id"])){

            $logger->additionalContent[] = $values["id"];
            $logger->notice("Item deleted.");
            
            $response->httpCode = 204;

        } else{

            $response->httpCode = 404;
            $response->body = ["error" => "Item not found"];
        }

        break;

    case "OPTIONS":
        $noAuthRequired = true;
        require_once "../apiEnvirorment.php";
        
        $response->httpCode = 204;
        break;

    default: // Other request methods
        $response->httpCode = 405;
        $response->body = ["error" => "Invalid Request Method"];
}


$response->allowMethods(["OPTIONS", "GET", "POST", "DELETE"]);
$response->send();


?>