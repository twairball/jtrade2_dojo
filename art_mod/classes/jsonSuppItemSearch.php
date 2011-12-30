<?php
require_once 'artDB_Mysql.php';
$artDB = new artDB_Mysql;
$itemId = $_GET["itemId"];
$json2 = $artDB->json_SuppItemByItemId($itemId);

//echo "itemId = $itemId <br>";
echo $json2;

?>