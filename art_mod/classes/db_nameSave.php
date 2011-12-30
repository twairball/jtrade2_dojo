<?php
	require_once 'artDB_Mysql.php';
	$artDB = new artDB_Mysql;
	
	//clean up escape char
	$_POST = preg_replace('/([\'\"+])/','\\\$1',$_POST);
  

		$fabID = $_POST['FabID'];
		$Supp_ArtNo = $_POST['Supp_ArtNo'];	
		$ELK_ArtNo = $_POST['ELK_ArtNo'];	
		$UserName = $_POST['UserName'];	
		$verbose = $_POST['Verbose'];
		$result= 0;

		//connect to db
		//mysql_connect("localhost","jtrade","jtrade") or die(mysql_error());
		//mysql_select_db("jtextile") or die(mysql_error());	

	if ($verbose) {
		var_dump($_POST);
	
		echo "<br>------- insert record --------<br>";
		$sql = "UPDATE fabric SET 
			ELK_ArtNo = '$ELK_ArtNo',
			lastEditedBy = '$UserName',
			TimeStamp = CURRENT_TIMESTAMP 
			WHERE fabID=$fabID"; 
		echo "sql=".$sql;
	}
	// execute query
		$result = $artDB->db_UpdateName($fabID, $Supp_ArtNo, $ELK_ArtNo, $UserName);
		if($verbose) {echo "<br>....result =".$result;}

?>





