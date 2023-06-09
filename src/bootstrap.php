<?php

/**
 * This file runs some envirorment checks and restores the database if needed
 * 
 * @author Sebastiano Racca
 */


require_once "base.php";

define("RESET", "\033[0m");
define("GREEN", "\033[32m");
define("YELLOW", "\033[33m");
define("RED", "\033[31m");


if(!file_exists(ROOT_DIR . ".env")){
    echo RED . "Please add your .env file\n" . RESET . "\tSee https://github.com/SysKeep/core/blob/main/doc/env-usage.md\n";
    exit(1);
}

// Generates the iv.bin file
if(!file_exists(ROOT_DIR . "iv.bin") || in_array("--force", $argv)){

    $file = fopen('iv.bin', 'wb');
    fwrite($file, Components\Crypt::genIV());
    fclose($file);
    
    echo YELLOW . "IV generated\n" . RESET;

    foreach(glob(ROOT_DIR . 'database/*') as $file){

        if($file != ROOT_DIR . ".gitkeep")
            if(!unlink($file)){
                echo RED . "Couldn't remove $file.\n" . RESET;
            }
    }

    echo YELLOW . "Database cleaned.\n" . RESET;
}



?>