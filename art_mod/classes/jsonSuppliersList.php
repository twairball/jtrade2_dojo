<?php
require_once '../includes/art_mod_includes.php';
require_once 'artDB_Mysql.php';

$artDB = new artDB_Mysql;
//$artId = $_GET["artId"];
$json = $artDB->json_SuppliersList();

echo $json;
?>