<?php
	require_once 'artDB_Mysql.php';
	$artDB = new artDB_Mysql;
	
	//clean up escape char
	$_POST = preg_replace('/([\'\"+])/','\\\$1',$_POST);
  

		$SupplierID = $_POST['SupplierID'];
		$Fin = $_POST['Fin'];	
		$SuppFin = $_POST['SuppFin'];	
		$UserName = $_POST['UserName'];	
		$verbose = $_POST['Verbose'];
		$result= 0;

		//connect to db
		//mysql_connect("localhost","jtrade","jtrade") or die(mysql_error());
		//mysql_select_db("jtextile") or die(mysql_error());	
	
	if ($verbose) {
		var_dump($_POST);
	
		echo "<br>------- insert record --------<br>";
		$sql = "INSERT INTO finishing (Finishing, SupplierID, Supp_FinishingNum, lastEditedBy, TimeStamp) 
            VALUES ('$Fin','$SupplierID','$SuppFin','$UserName',CURRENT_TIMESTAMP)"; 
		echo "sql=".$sql;
	}
	// execute query
		$result = $artDB->db_InsertNewFinishing($Fin, $SupplierID, $SuppFin, $UserName);
		if($verbose) {echo "<br>....result =".$result;}

?>





