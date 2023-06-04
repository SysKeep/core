<?php

/**
 * Database Class.
 * This class provides functionality for managing a database in the database/ directory.
 * 
 * @package Components
 */


namespace Components;

require_once ROOT_DIR . "src/components/crypt.php";

use \Components\Crypt;
use \Components\Logger\Logger;


final class Database{
    protected string $username, $password, $filename;
    protected ?object $db;
    protected Crypt $crypt;

    /**
     * Database constructor.
     * Initializes the Database object with a username and password.
     * 
     * @param string $username   Username of the database.
     *                           Used to check if the database exists or not.
     * @param string $password   The password for the user.
     *                           Used as encryption key.
     */
    public function __construct(string $username, string $password){
        $this->username = $username;
        $this->password = $password;
        $this->db = NULL;

        $this->crypt = new Crypt($password);
    }


    /**
     * Checks if the database exists.
     * 
     * @return bool Wheter the database exists.
     */
    protected function exists(): bool{
        return file_exists(\ROOT_DIR . "database/$this->username.json.enc");
    }


    /**
     * Loads the contents of a database.
     * 
     * @return bool True if the file was found and decrypted.
     *              False if the username or password are incorrect.
     */
    public function load(): bool{
        if(!$this->exists())
            return false;
        
        $this->filename = \ROOT_DIR . "database/$this->username.json.enc";
        
        $this->db = json_decode(
            $this->crypt->decrypt(file_get_contents($this->filename))
        );

        return $this->db != NULL;
        
    }


    /**
     * Updates the contents of a database.
     * 
     * @return bool True on success.
     */
    protected function update(): bool{
        return file_put_contents(
            $this->filename,
            $this->crypt->encrypt(json_encode($this->db))
        ) !== false;
    }


    /**
     * Creates a new database for the user.
     * 
     * @param string      $name      The name displayed for the user.
     * @param string|null $surname   The surname of the user.
     * 
     * @return bool                  True on success.
     *                               False if the user already exists or if the file couldn't be created.
     */
    public function new(string $name, ?string $surname): bool{

        if($this->load())
            return false;

        return file_put_contents(
            \ROOT_DIR . "database/$this->username.json.enc",
            $this->crypt->encrypt(json_encode([
                    "user" => [
                        "name" => $name,
                        "surname" => $surname,
                    ],
                    "vault" => (object)[]
                ]))
        ) !== false;

    }


    /**
     * Deletes a database.
     * 
     * @return bool True on success.
     *              False on failure.
     */
    public function delete(): bool{
        return unlink($this->filename);
    }


    /**
     * Returns info about the user.
     * 
     * @return object The user.
     */
    public function getUser(): object{
        return $this->db->user;
    }


    /**
     * Adds an items to a database's vault
     * 
     * @return int|false The new item's id
     *                   False if update() failed
     */
    public function newItem(array|object $element): int | false {
        $keys = array_keys((array) $this->db->vault);
        $lastItemId = (int) end($keys);

        $this->db->vault->{$lastItemId + 1} = $element;

        if($this->update())
            return $lastItemId + 1;
        
        return false;
    }
    
    


    /**
     * Returns info about an item in the vault
     * 
     * @return object|false The item if it was found
     *                      False if the item doesn't exists
     */
    public function getOneItem(int $id): object | false{
        return $this->db->vault->$id ?? false;
    }


    /**
     * Returns all the items in the vault
     * 
     * @return object The items
     */
    public function getAllItems(): object{
        return $this->db->vault;
    }


    /**
     * Deletes an item in the vault
     * 
     * @return bool True id the item exists and was deleted
     *              False if the item doesn't exists
     */
    public function deleteItem(int $id): bool{
        if(!isset($this->db->vault->$id))
            return false;

        unset($this->db->vault->$id);

        return $this->update();
    }
}



?>