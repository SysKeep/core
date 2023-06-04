<?php

/**
 * Tests for the Components\Crypt class.
 * 
 * @author Sebastiano Racca
 */

require_once __DIR__ . "/../bootstrap.php";
require_once ROOT_DIR . "/src/components/crypt.php";


use PHPUnit\Framework\TestCase;
use Components\Crypt;

class CryptTest extends TestCase{
    protected $key;
    protected $crypt;

    protected function setUp(): void{
        $this->key = 'my_secret_key';
        $this->crypt = new Crypt($this->key);
    }

    /**
     * Test encryption and decryption of a string.
     * 
     * This test encrypts a string using the `encrypt` method of the Crypt class
     * and then decrypts it using the `decrypt` method. It asserts that the 
     * decrypted string matches the original string and that the encrypted 
     * string is not the same as the original string.
     */
    public function testEncryptDecrypt(){
        $string = 'Hello, World!';
        $encryptedString = $this->crypt->encrypt($string);
        $decryptedString = $this->crypt->decrypt($encryptedString);

        $this->assertNotEquals($string, $encryptedString);
        $this->assertEquals($string, $decryptedString);
    }

    /**
     * Test generation of initialization vector (IV).
     * 
     * This test generates an IV using the `gen_iv` method of the Crypt class
     * and asserts that the generated IV is a non-empty string.
     */
    public function testGenIV(){
        $iv = Crypt::genIV();

        $this->assertIsString($iv);
        $this->assertNotEmpty($iv);
    }
}



?>