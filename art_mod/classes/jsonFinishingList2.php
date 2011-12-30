<?php
require_once '../includes/art_mod_includes.php';
require_once 'artDB_Mysql.php';

$artDB = new artDB_Mysql;
//$s = $_GET['supplierID'];
$json = $artDB->json_FinishingList2();

echo $json;
?>