<?php 
	
	namespace Crm\AdminBundle\Entity;
	/**
	* 
	*/
	class Encodage 
	{
		public static $key =  "!@#$%^&*";

		function __construct()
		{
			# code...
		}

		/**
		 * Returns an encrypted & utf8-encoded
		 */
		public static function encrypt($pure_string) {
		    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
		    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		    $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH,Encodage::$key, utf8_encode($pure_string), MCRYPT_MODE_ECB, $iv);
		    return $encrypted_string;
		}

		/**
		 * Returns decrypted original string
		 */
		public static function decrypt($encrypted_string) {
		    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
		    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		    $decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, Encodage::$key, $encrypted_string, MCRYPT_MODE_ECB, $iv);
		    return $decrypted_string;
		}
	

}

