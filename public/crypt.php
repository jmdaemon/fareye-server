<?php
class Crypt {
    private $data;
    private $iv;
    private $key;

    // Setters
    public function setKey($key)    { $this->key = $key; }
    public function setIV($iv)      { $this->iv = $iv; }
    public function setData($data)  { $this->data = $data; }

    // Getters
    public function getKey()        { return $this->key; }
    public function getIV()         { return $this->iv; }
    public function getData()       { return $this->data; }
}

class AesUtility extends Crypt {
    const AES = 'AES-256-CBC';
    public function encrypt($data)      { return openssl_encrypt($data, "AES-256-CBC", $this->key, $this->iv); }
    public function decrypt($data, $iv) { return openssl_decrypt($data, "AES-256-CBC", $this->key, $data, $iv); }
}

class RsaUtility extends Crypt {
    // RSA 2048 Encryption
    public function transport() {}
    public function receive() {}
    public function passwordChecking() {}
}
?>
