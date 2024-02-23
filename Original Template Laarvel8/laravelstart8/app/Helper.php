<?php
	function encrypt_password($password){

		$key  	= 'swebin';
		$key2 	= 'sosp@$%Ck';
		$string 	= $password; 

		$output = false;
		$encrypt_method = "AES-256-CBC";
		$key 	= hash( 'sha256', $key );
		$iv 	= substr( hash( 'sha256', $key2 ), 0, 16 );
		$output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
		return $output;
	}


	 function decrypt_password($password){


		$key  		= 'swebin';
		$key2 		= 'sosp@$%Ck';
		$string 	= $password; 
		

		$output 	= false;
		$encrypt_method = "AES-256-CBC";
		$key 		= hash( 'sha256', $key );
		$iv 		= substr( hash( 'sha256', $key2 ), 0, 16 );
		$output 	= openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
		return $output;
	}
	
		 function file_extesion($image){
		 		 
		 	//get filename with extension
			$filenamewithextension = $image->getClientOriginalName();
			//get filename without extension
			$filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
			//get file extension
			$extension = $image->getClientOriginalExtension();
 			//filename to store
			$main_img = substr($filename,0,70).'_'.time().'.'.$extension;
			
			return $main_img;
		 }
	
