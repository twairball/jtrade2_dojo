<?php
// includes path... what a pain
$includes_path = dirname(dirname(__FILE__)).'/includes/art_mod_includes.php';
$constants_path = dirname(dirname(__FILE__)).'/includes/artDB_constants.php';
//echo "includes path = $includes_path<br> constants_path = $constants_path<br>";
	 
require_once $includes_path;
require_once $constants_path;

class artDB_Mysql {
	private $conn;
	
	function __construct() {
		$this->conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME) or 
					  die('There was a problem connecting to the database.');
	}

	/*using mysqli and bind_param.... doesn't bloody work
  	function getArray_PublicItemDetails($artId) {
				
		$query = "SELECT fabID, ELK_ArtNo, Comp, Density, YarnCount, 
    WidthPrint, CuttablePrint, Weight_gm2, Weight_gyd, Finishing 
				FROM fabricvw
				WHERE ELK_ArtNo LIKE CONCAT('%', ?, '%')";
				
		  $stmt = $this->conn->prepare($query);   
		
			$rows = Array(); // returned object
			$stmt->bind_param('s', $artID);
			
      if($stmt->execute()) {
  			while($r=$stmt->fetch()) {
  			   $rows[] = $r;
  			}
				$stmt->close();
        return $rows;
			} else {
			       die(printf("error: %s.\n", $stmt->error));
			}	
	}
	
	function getJSON_PublicItemDetails($artId){
		$data = $this->getArray_PublicItemDetails($artId);
    return json_encode($data);
  }
*/
	
	//public fab article details for search
	function getJSON2($artId) {
				
		$query = "SELECT fabID, ELK_ArtNo, Comp, Density, YarnCount, 
    WidthPrint, CuttablePrint, Weight_gm2, Weight_gyd, Finishing 
				FROM fabricvw
				WHERE ELK_ArtNo LIKE '%".$artId."%'";
		
		mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD);
		mysql_select_db(DB_NAME);
      	
		  if($result = mysql_query($query)){		
			$rows = Array(); // returned object
			$rows['identifier'] = "fabID";
			//$rows['labels'] = "fabID";
			
  			while($r=mysql_fetch_assoc($result)) {
  			   $rows['items'][] = $r;
  			}

			return json_encode($rows);
        } else {
          die(mysql_error());
        }

	}

	//public fab article details for search
	function jsonArtNames($artId) {
				
		$query = "SELECT fabID, ELK_ArtNo, Supp_ArtNo, Comp, Density, YarnCount, 
    WidthPrint, CuttablePrint, Weight_gm2, Weight_gyd, Finishing 
				FROM fabricvw
				WHERE ELK_ArtNo LIKE '%".$artId."%'";
		
			mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD);
			mysql_select_db(DB_NAME);
      	
		  if($result = mysql_query($query)){		
			$rows = Array(); // returned object
			$rows['identifier'] = "fabID";
			//$rows['labels'] = "fabID";
			
  			while($r=mysql_fetch_assoc($result)) {
  			   $rows['items'][] = $r;
  			}

			return json_encode($rows);
        } else {
          die(mysql_error());
        }

	}
	
	//search by supplier ItemId
	function json_SuppItemByItemId($itemId) {
		$query = "SELECT fabID, Supp_ArtNo, SupplierID,  Comp, Density, YarnCount, 
    WidthPrint, CuttablePrint, Weight_gm2, Weight_gyd, Finishing, Supp_FinishingNum
				FROM fabricvw
				WHERE Supp_ArtNo LIKE '%".$itemId."%' ";
		
		mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD);
		mysql_select_db(DB_NAME);
      	
		  if($result = mysql_query($query)){		
			$rows = Array(); // returned object
			$rows['identifier'] = "fabID";
			
  			while($r=mysql_fetch_assoc($result)) {
  			   $rows['items'][] = $r;
  			}

			return json_encode($rows);
        } else {
          die(mysql_error());
        }
	}

	function json_SIByFabId($fabId) {
		$query = "SELECT fabID, Supp_ArtNo, SupplierID, Comp, Density, YarnCount, 
    WidthPrint, CuttablePrint, Weight_gm2, Weight_gyd, Finishing 
				FROM fabricvw
				WHERE fabID=".$fabId;
		
		mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD);
		mysql_select_db(DB_NAME);
      	
		  if($result = mysql_query($query)){		
			$rows = Array(); // returned object
			$rows['identifier'] = "fabID";
			
  			while($r=mysql_fetch_assoc($result)) {
  			   $rows['items'][] = $r;
  			}
			
			return json_encode($rows);
        } else {
          die(mysql_error());
        }
		
	}
	
	//returns key=>value array.... json too frustrating
	function array_SIByFabId($fabId) {
		$sql = "SELECT f.*, n.Supp_FinishingNum
				FROM fabric f, finishing n
				WHERE fabID=$fabId
				AND f.FinID = n.FinID";
		
		mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD) or die(mysql_error());
		mysql_select_db(DB_NAME) or die(mysql_error());
      	$result = mysql_query($sql) or die(mysql_error());
			
		// only want the 1st result
		while($row=mysql_fetch_array($result)){
			//var_dump($row);
			return $row;
  		}
		
	}
	
	
	
	//static lists for dropdown boxes
	function json_SuppliersList() {
		$query = "SELECT SupplierID, FullName FROM supplier";
		
		mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD);
		mysql_select_db(DB_NAME);
      	
			$result = mysql_query($query) or die(mysql_error());	
			$rows = Array(); // returned object
			$rows['identifier'] = "SupplierID";
			
  			while($r=mysql_fetch_assoc($result)) {
  			   $rows['items'][] = $r;
  			}

			return json_encode($rows);
	}
	
	//static lists for dropdown boxes
	function json_FinishingList($supplierID) {
		$query = "SELECT * FROM finishing where SupplierID = '$supplierID' Order by finishing DESC";
		
		mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD);
		mysql_select_db(DB_NAME);
      	
			$result = mysql_query($query) or die(mysql_error());		
			$rows = Array(); // returned object
			$rows['identifier'] = "FinID";
			$rows['label'] = "Supp_FinishingNum";
  			while($r=mysql_fetch_assoc($result)) {
  			   $rows['items'][] = $r;
  			}

			return json_encode($rows);

	}

	//static lists for dropdown boxes
	function json_FinishingList2() {
		$query = "SELECT * FROM finishing DESC";
		
		mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD);
		mysql_select_db(DB_NAME);
      	
			$result = mysql_query($query) or die(mysql_error());	
			$rows = Array(); // returned object
			$rows['identifier'] = "FinID";
			
  			while($r=mysql_fetch_assoc($result)) {
  			   $rows['items'][] = $r;
  			}

			return json_encode($rows);
		
	}
	
	//insert new finishing
	function db_InsertNewFinishing ($Fin,$SupplierID,$SuppFin,$UserName) {
		$query = "INSERT INTO finishing (Finishing, SupplierID, Supp_FinishingNum, lastEditedBy, TimeStamp) 
            VALUES ('$Fin','$SupplierID','$SuppFin','$UserName',CURRENT_TIMESTAMP)"; 
		$result = 0;
		
		mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD);
		mysql_select_db(DB_NAME);
		
		$result = mysql_query($query) or die(mysql_error());
		return $result;
		
	}
	//update new name
	function db_UpdateName ($fabID, $Supp_ArtNo, $ELK_ArtNo, $UserName) {
		$query = "UPDATE fabric SET 
			ELK_ArtNo = '$ELK_ArtNo',
			lastEditedBy = '$UserName',
			TimeStamp = CURRENT_TIMESTAMP 
			WHERE fabID=$fabID"; 
		$result = 0;
		
		mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD);
		mysql_select_db(DB_NAME);
		
		$result = mysql_query($query) or die(mysql_error());
		return $result;
		
	}
	
	//insert new item
	function db_InsertNewItem ($ELK_ArtNo, $Supp_ArtNo, $SupplierID, $Comp, $Density, $YarnCount, $Width, $WidthUnit, $Cuttable, $Weight_gm2, $Weight_gyd, $FinID, $Remark, $UserName) {
		$query = "INSERT INTO fabric (ELK_ArtNo,Supp_ArtNo,SupplierID,Comp,Density,YarnCount,Width,WidthUnit,Cuttable,Weight_gm2,Weight_gyd,FinID,
      				REMARK,	lastEditedBy, TimeStamp
      		) VALUES(
      			'$ELK_ArtNo','$Supp_ArtNo','$SupplierID','$Comp','$Density','$YarnCount','$Width','$WidthUnit',
      			'$Cuttable','$Weight_gm2','$Weight_gyd','$FinID','$Remark','$UserName',CURRENT_TIMESTAMP)";
		$result = 0;
		
		mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD);
		mysql_select_db(DB_NAME);
		
		$result = mysql_query($query) or die(mysql_error());
		return $result;
		
	}

	//update item
	function db_UpdateItem ($fabID, $ELK_ArtNo, $Supp_ArtNo, $SupplierID, $Comp, $Density, $YarnCount, $Width, $WidthUnit, $Cuttable, $Weight_gm2, $Weight_gyd, $FinID, $Remark, $UserName) {
		$query = "UPDATE fabric SET 
				ELK_ArtNo = '$ELK_ArtNo',
				Supp_ArtNo = '$Supp_ArtNo',
				SupplierID = '$SupplierID',
				Comp = '$Comp',
				Density = '$Density',
				YarnCount = '$YarnCount',
				Width = '$Width',
				WidthUnit = '$WidthUnit',
				Cuttable = '$Cuttable',
				Weight_gm2 = '$Weight_gm2',
				Weight_gyd = '$Weight_gyd',
				FinID = '$FinID',
				REMARK = '$Remark',
				lastEditedBy = '$UserName',
				TimeStamp = CURRENT_TIMESTAMP 
				where fabID='$fabID'";
		$result = 0;
		
		mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD);
		mysql_select_db(DB_NAME);
		
		$result = mysql_query($query) or die(mysql_error());
		return $result;
		
	}
	
	//returns a default ELK_ArtNo name for un-named articles
	function getBlankName() {
		return "_UNNAMED_";
	}
}