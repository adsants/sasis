<?php
class Encrypt_decrypt extends CI_Controller {
    protected $_ci;
    
    function __construct(){
        $this->_ci = &get_instance();
    }
    
	function getText($action, $string) {
		$output = false;	 
		
		$encrypt_method = "AES-256-CBC";
		$secret_key 	= 'K3yIn1UntukSiak';
		$secret_iv 		= 'bismillah';
	 
		$key 	= hash('sha256', $secret_key);
		
		$iv 	= substr(hash('sha256', $secret_iv), 0, 16);
	 
		if( $action == 'encrypt' ) {
			$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
			$output = base64_encode($output);
		}
		else if( $action == 'decrypt' ){
			$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
		}
		
		return $output;
	}
	
	
	function generateRandomString($length =  null) {
	//	$characters = '123456789ABCDEFGHJKLMNPQRSTUVWXYZ';
		$characters = '1234567890';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
}
