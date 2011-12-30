<?php

require_once 'artDB_Mysql.php';
$artDB = new artDB_Mysql;
$artId = "M656";

$rows = $artDB->getArray_PublicItemDetails($artId);
$json = $artDB->getJSON_PublicItemDetails($artId);

$json2 = $artDB->getJSON_BySI($artId);
echo("testing echo<br>");

echo("json=".$json."<br>");

echo ("<br>foreach: <br>");
foreach ($rows as $key=>$value) {
  echo ("key=".$key.", value=".$value."<br>");

}
echo("json2=".$json2."<br>");
?>

<html>
<head>
<meta charset="utf-8">
<title> Test JSON -- </title>
<script src="/dojo/dojo/dojo.js"></script>
<link rel="stylesheet" href="/dojo/dijit/themes/tundra/tundra.css">
<link rel="stylesheet" href="/dojo/dojo/resources/dojo.css" />

<script>
    dojo.require("dojo.data.ItemFileReadStore");
    dojo.require("dijit.form.ComboBox");
    dojo.require("dijit.form.Button");
	
	dojo.dialogAlert("hello dojo");
    //Now set up a linkage so that the store can be reloaded.
    dojo.addOnLoad(function() {
        dojo.connect(dijit.byId("reloadButton2"), "onClick", function() {
            //Reset the url and call close.  Note this could be a different JSON file, but for this example, just
            //Showing how you would set the URL.
            reloadableStore2.url = "getJSON_publicArtDetails.php?artId=MK-M805";
            reloadableStore2.close();
        });
    });
</script>
</head>

<body class="tundra">

<div dojoType="dojo.data.ItemFileReadStore" url="getJSON_publicArtDetails.php?artId=MK-M805"
jsId="reloadableStore2" urlPreventCache="true" clearOnClose="true">
</div>
<div dojoType="dijit.form.ComboBox" store="reloadableStore2" searchAttr="name">
</div>
<div id="reloadButton2" dojoType="dijit.form.Button">
    Reload DataStore
</div>

</body>

</html>