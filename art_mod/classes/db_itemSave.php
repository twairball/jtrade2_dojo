<?php
	require_once 'artDB_Mysql.php';
	$artDB = new artDB_Mysql;
	
	//clean up escape char
	$_POST = preg_replace('/([\'\"+])/','\\\$1',$_POST);
  

	//(fabId, SuppID, Supp_ArtNo, Comp, Density, YarnCount, Width, WidthUnit, Cuttable, Weight_gm2, Weight_gyd, FinID, Remark, UserName)
	//post submit
	//$fabID = $_POST['fabID']; // <--- its blank anyway, we're adding new record.
	$ELK_ArtNo = $artDB->getBlankName();
	$Supp_ArtNo = $_POST['Supp_ArtNo'];
	$SupplierID = $_POST['SupplierID'];
	$Comp = $_POST['Comp'];
	$Density = $_POST['Density'];
	$YarnCount = $_POST['YarnCount'];
	$Width = $_POST['Width'];
	$WidthUnit = $_POST['WidthUnit'];
	$Cuttable = $_POST['Cuttable'];
	$Weight_gm2 = $_POST['Weight_gm2'];
	$Weight_gyd = $_POST['Weight_gyd'];
	$FinID = $_POST['FinID'];		
	$Remark = $_POST['Remark'];
	$UserName = $_POST['UserName'];	
	$verbose = $_POST['Verbose'];
	$result= 0;
  
	//php escape strings for width unit to save without '\'
	//		$remarks = str_replace("\n", "<br>", ($row['remarks']));
	$WidthUnit = str_replace("\\\"", "\"", $WidthUnit);

	/*
		  //echo "<br>------- update record --------<br>";
	     $sql = "UPDATE fabric SET 
				ELK_ArtNo = '".$ELK_ArtNo."',
				Supp_ArtNo = '".$Supp_ArtNo."',
				SupplierID = '".$SupplierID."',
				Comp = '".$Comp."',
				Density = '".$Density."',
				YarnCount = '".$YarnCount."',
				Width = '".$Width."',
				WidthUnit = '".$WidthUnit."',
				Cuttable = '".$Cuttable."',
				Weight_gm2 = '".$Weight_gm2."',
				Weight_gyd = '".$Weight_gyd."',
				FinID = '".$FinID."',
        REMARK = '".$Remark."' where fabID='".$fabID."' ";
		*/

	if ($verbose) {
		var_dump($_POST);
  		echo "<br>------- insert record --------<br>";
		// new record   
		$sql = "INSERT INTO fabric (ELK_ArtNo,Supp_ArtNo,SupplierID,Comp,Density,YarnCount,Width,WidthUnit,
					Cuttable,Weight_gm2,Weight_gyd,FinID,
      				REMARK,	UserName, TimeStamp
      		) VALUES(
      			'$ELK_ArtNo','$Supp_ArtNo','$SupplierID','$Comp','$Density','$YarnCount','$Width','$WidthUnit',
      			'$Cuttable','$Weight_gm2','$Weight_gyd','$FinID','$Remark','$UserName',CURRENT_TIMESTAMP)";
		  	echo "sql=".$sql;
	}
		// execute query
		$result = $artDB->db_InsertNewItem($ELK_ArtNo, $Supp_ArtNo, $SupplierID, $Comp, $Density, 
							$YarnCount, $Width, $WidthUnit, $Cuttable, $Weight_gm2, $Weight_gyd, 
							$FinID, $Remark, $UserName);
		if($verbose) {echo "<br>....result =".$result;}
	
?>





