<?php
require_once 'artDB_Mysql.php';
$artDB = new artDB_Mysql;
$fabId = $_GET["fabId"];
$json2 = $artDB->json_SIByFabId($fabId);

echo $json2;

//echo "<br><br> ARRAY PRINT <br><br>";
//var_dump($artDB->array_SIByFabId($fabId));

?>