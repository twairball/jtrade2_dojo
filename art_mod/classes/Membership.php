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
			
			header("location: index.php");
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
		if($_SESSION['status'] !='authorized') header("location: login.php");

	}
	
}