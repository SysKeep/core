<?php

/**
 * Tests for the Components\Database class.
 * 
 * @author Sebastiano Racca
 */


require_once __DIR__ . "/../bootstrap.php";
require_once ROOT_DIR. "/src/components/database.php";

use PHPUnit\Framework\TestCase;
use Components\Database;

final class DatabaseTest extends TestCase{
    protected $database;

    /**
     * Initialize the Database object with test credentials.
     */
    protected function setUp(): void{
        $this->database = new Database('test_username', 'test_password');
    }

    /**
     * Create a new database with name and surname.
     */
    public function testNewDatabase(){
        $result = $this->database->new('John', 'Doe');
        $this->assertTrue($result);
    }

    /**
     * Load an existing database.
     */
    public function testLoadDatabase(){
        $result = $this->database->load();
        $this->assertTrue($result);
    }

    /**
     * Get the user object.
     */
    public function testGetUser(){
        $this->database->load();
        $user = $this->database->getUser();
        $this->assertNotEmpty($user);
    }

    /**
     * Create a new item.
     */
    public function testNewItem(){
        $this->database->load();
        $itemId = $this->database->newItem(['name' => 'Item 1']);
        $this->assertNotFalse($itemId);
    }

    /**
     * Get an existing item.
     */
    public function testGetOneItem(){
        $this->database->load();
        $item = $this->database->getOneItem(1);
        $this->assertNotEmpty($item);
    }

    /**
     * Delete an existing item.
     */
    public function testDeleteItem(){
        $this->database->load();
        $result = $this->database->deleteItem(1);
        $this->assertTrue($result);
    }

    /**
     * Delete the database.
     */
    public function testDeleteDatabase(){
        $this->database->load();
        $result = $this->database->delete();
        $this->assertTrue($result);
    }
}
