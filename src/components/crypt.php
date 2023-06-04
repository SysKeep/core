<?php

/**
 * Crypt Class.
 * This class provides encryption and decryption functionalities using AES-256-CBC algorithm.
 * 
 * @package Components
 */


namespace Components;


final class Crypt{
    protected string $key; // Encryption key

    
    /**
     * Crypt constructor.
     *
     * Initializes the Crypt object with a key.
     * It also loads the initialization vector (IV) from a file.
     *
     * @param string $key The encryption key.
     */
    public function __construct(string $key){
        $this->key = $key;
        $this->iv = file_get_contents(\ROOT_DIR . "iv.bin");
    }

    /**
     * Encrypts a string using AES-256-CBC algorithm.
     *
     * @param string $string The string to be encrypted.
     * @return string The encrypted string.
     */
    public function encrypt(string $string): string{
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-256-CBC'));
        
        return base64_encode(
            openssl_encrypt($string, 'AES-256-CBC', $this->key, 0, $this->iv) .
            '::' .
            $this->iv
        );
    }

    /**
     * Decrypts an encrypted string using AES-256-CBC algorithm.
     *
     * @param string $encryptedString The encrypted string to be decrypted.
     * @return string The decrypted string.
     */
    public function decrypt(string $encryptedString): string{
        $parts = explode('::', base64_decode($encryptedString), 2);
        return openssl_decrypt($parts[0], 'AES-256-CBC', $this->key, 0, $parts[1] ?? "");
    }

    /**
     * Generates a random initialization vector (IV) for AES-256-CBC algorithm.
     *
     * @return string The generated initialization vector.
     */
    public static function genIV(): string{
        return openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-256-CBC'));
    }
}



?>