<?php

class Crypt {
    private $data;
    private $iv;
    private $key;

    // Setters
    public function setKey($key)    { $key = $key; }
    public function setIV($iv)      { $iv = $iv; }
    public function setData($data)  { $iv = $data; }

    // Getters
    public function getKey()        { return $this->key; }
    public function getIV()         { return $this->iv; }
    public function getData()       { return $this->data; }
}

class AesUtility extends Crypt {
    const AES = 'AES-256-CBC';
    // private const RSA = "";
    // AES-256 Encryption

    public function encrypt($data) { return openssl_encrypt($data, "AES-256-CBC", $key, $iv); }
    public function decrypt($data, $iv) {
        //$byte_array = unpack('C*', 'The quick fox jumped over the lazy brown dog');
        //var_dump($byte_array);  // $byte_array should be int[] which can be converted
                                // to byte[] in C# since values are range of 0 - 255
                                
        return openssl_decrypt($data, "AES-256-CBC", $key, $data, $iv);
    }
    
    // RSA 2048 Encryption
    public function transport() {}
    public function receive() {}
    public function passwordChecking() {}
}
?>
