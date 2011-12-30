<?php

require 'Mysql.php';

class Membership {


	function validate_user($un, $pwd) {
		$mysql = New Mysql();
		$ensure_credentials = $mysql->verify_Username_and_Pass($un, md5($pwd));
		
		if($ensure_credentials) {
			$_SESSION['status'] = 'authorized';
			$_SESSION['username'] = $un;
			
			
			//get priv for articles DB
			$artPriv = $mysql->getArtPriv($un, md5($pwd));	
			$_SESSION['artPriv'] = $artPriv;
			
			header("location: /jtrade2/index.php");
		} else return "Please enter a correct username and password";
		
	} 
	
	function log_User_Out() {
		if(isset($_SESSION['status'])) {
			unset($_SESSION['status']);
			
			if(isset($_COOKIE[session_name()])) 
				setcookie(session_name(), '', time() - 1000);
				session_destroy();
		}
	}
	
	function get_username(){
		if(isset($_SESSION['username'])) return $_SESSION['username'];
	}
	
	function get_artPriv(){
		if(isset($_SESSION['artPriv'])) return $_SESSION['artPriv'];
	}
	
	function confirm_Member() {
		session_start();
		if($_SESSION['status'] !='authorized') header("location: /jtrade2/login.php");

	}
	
	function confirm_artPriv($reqPrivArray) {
		if(isset($_SESSION['status'])) {
			$authorized = 0;
			//echo "looping privArray<br>";
			foreach ($reqPrivArray as $v) {
				//echo "v = $v, artPriv = ".$_SESSION['artPriv']."<br>";
				if($_SESSION['artPriv'] == $v) $authorized =1;
			}
			if(!$authorized) header("location: /jtrade2/index.php");
		}
	}
	
}