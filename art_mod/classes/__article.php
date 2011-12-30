<?php
require 'artDB_Mysql.php';

class Article {

  function getJSON_publicItemDetails ($artID) {
    $mysql = new artDB_Mysql();
    $rows = $mysql->getArray_PublicItemDetails()
  }

}
?>
