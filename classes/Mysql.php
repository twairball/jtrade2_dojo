<?php

//require_once 'constants.php';

class Mysql {
	private $conn;

	function __construct() {
		 $db_server = 'localhost';
		 $db_user = 'jtrade2';
		 $db_passwd = 'whiteG00se';
		 $db_table = 'membership';
	
		$this->conn = new mysqli($db_server, $db_user, $db_passwd, $db_table) or 
					  die('There was a problem connecting to the database.');
	}
	
	function verify_Username_and_Pass($un, $pwd) {
				
		$query = "SELECT *
				FROM users
				WHERE username = ? AND password = ?
				LIMIT 1";
				
		if($stmt = $this->conn->prepare($query)) {
			$stmt->bind_param('ss', $un, $pwd);
			$stmt->execute();
			
			if($stmt->fetch()) {
				$stmt->close();
				return true;
			} else {
			//die(printf("error: %s.\n", $stmt->error));
			}
		}
		
	}

	function verify_UserPassArtPriv($un, $pwd, $priv) {
				
		$query = "SELECT *
				FROM users
				WHERE username = ? AND password = ? AND artPriv = ?
				LIMIT 1";
				
		if($stmt = $this->conn->prepare($query)) {
			$stmt->bind_param('sss', $un, $pwd, $priv);
			$stmt->execute();
			
			if($stmt->fetch()) {
				$stmt->close();
				return true;
			} else {
			//die(printf("error: %s.\n", $stmt->error));
			}
		}
		
	}
	
	
	function getArtPriv($un, $pwd) {
				
		$query = "SELECT artPriv
				FROM users
				WHERE username = ? AND password = ?
				LIMIT 1";
				
		$priv = -1;
		if($stmt = $this->conn->prepare($query)) {
			$stmt->bind_param('ss', $un, $pwd);
			$stmt->execute();
			$stmt->bind_result($priv);
			
			if($stmt->fetch()) {
				$stmt->close();
				return $priv;
			} else {
				die(printf("priv error: %s.\n", $stmt->error));
			}
		}
		
	}
	
	
}