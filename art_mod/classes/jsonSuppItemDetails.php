<?php
require_once 'artDB_Mysql.php';
$artDB = new artDB_Mysql;

$jsonBlank = '{"identifier":"fabID",
				"items":[
					{"fabID":"",
					"Supp_ArtNo":"",
					"SupplierID":"FDF",
					"Comp":"",
					"Density":"",
					"YarnCount":"",
					"WidthPrint":"",
					"CuttablePrint":"",
					"Weight_gm2":"",
					"Weight_gyd":"",
					"Finishing":""}
					]
			}';
if(isset($_GET['fabId'])) {
	if($_GET['fabId'] > 0){
		$fabId = $_GET["fabId"];
		$json2 = $artDB->json_SIByFabId($fabId);
		echo $json2;
	} else {
		echo $jsonBlank;
	}
} else {
	echo $jsonBlank;
}


?>