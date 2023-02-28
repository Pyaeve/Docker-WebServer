<?php

class Encryption{
	
	private $default_key;

	public static function Encrypt($value, $key = authToken) {
		return @openssl_encrypt($value, 'AES-256-CBC', $key);
	}

	public static function Decrypt($value, $key = authToken) {
		return @openssl_decrypt($value, 'AES-256-CBC', $key);
	}
}

?>