<?php
require_once 'artDB_Mysql.php';
$artDB = new artDB_Mysql;
$artId = $_GET["artId"];
$json2 = $artDB->getJSON2($artId);

echo $json2;
?>