<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title> JTrade v2.0  -- ArtDB / Search Article -- </title>
<?php
//confirm membership priviledges 
require_once 'classes/Membership.php';
$membership = New Membership();
$membership->confirm_Member();
$user = $membership->get_username();
$artPriv = $membership->get_ArtPriv();
?>

<script src="/dojo/dojo/dojo.js"></script>
<link rel="stylesheet" href="/dojo/dijit/themes/tundra/tundra.css">
<link rel="stylesheet" href="/dojo/dojo/resources/dojo.css" />
<script>
  function init() {
    };
  dojo.ready(init);
</script>


</head>

<?php
//get the q parameter from URL
$q=$_GET["q"];

$getstring = "?";
foreach ($_GET as $key => $value){
  $getstring .=$key."=".$value."&";
}

?>

<body class="tundra">
<div id="overlay"></div>
<div id="dialog">
  <div id="dialogMsg"></div>
  <br><div id="dialogButton"></div>
</div>


<h1>View/Search Fabric Articles</h1> 

You're logged in as: <b><?php echo $user?></b> | <a href="login.php?status=loggedout">Log Out</a><br>


<div class="wrapper">

<form name="searchItem" action="view.php" method="get">
<div id="itemDIV" style="position: relative; ">
	<table>
	<tr><td class='label'>Item Name:</td>
		<td class='formInput'>
		<input type="text" name="q" id="name" onBlur="" size="50" value=<?php echo $q ?>>
    <a href="view.php?q=*">get all</a>
    </td>
    <td><button action="submit">Submit</button></td>
    </tr>
  </table>
</div>
</form>

<div id="results" style="position: relative;">
  <table id="resultsTbl" name="resultsTbl">
    <tr><th width='5%' style="text-align: left">View/Edit</th>
        <th width='5%' style="text-align: left">Delete</th>
        <th width='15%' style="text-align: left">Art. No</th>
<!--
        <th width='10%' style="text-align: left">Supplier Item#</th>
        <th width='5%' style="text-align: left">Supplier</th>
        -->
		<th width='10%' style="text-align: left">Comp</th>
		<th width='15%' style="text-align: left">Density</th>
		<th width='20%' style="text-align: left">Yarn Count</th>
		<th width='5%' style="text-align: left">Width</th>
		<th width='5%' style="text-align: left">Weight g/m2</th>
		<th width='20%' style="text-align: left">Finishing</th>
<!-- 
		<th width='10%' style="text-align: left">Finish #</th>
	-->
    </tr>
 
<?php

//lookup all hints from array if length of q>0
if (strlen($q) > 0) {

  if($q == '*') {
    $sql = "select f.*, n.Finishing, n.Supp_FinishingNum from fabric f, finishing n 
            where f.FinID = n.FinID order by f.TimeStamp DESC";
  } else {

	 $sql = "select f.*, n.Finishing, n.Supp_FinishingNum from fabric f, finishing n where f.FinID = n.FinID
              and (ELK_ArtNo like '%".strtoupper($q)."%' 
                  or Supp_ArtNo like '%".strtoupper($q)."%') 
              order by f.TimeStamp DESC";
	}
	
	echo('sql = '.$sql."<br>");
	
                	/* DB connection + print 

  mysql_connect("localhost","jtrade","jtrade") or die(mysql_error());
  //mysql_query("SET NAMES 'utf8'"); //UTF8 
	mysql_select_db("jtextile") or die(mysql_error());
	$result = mysql_query($sql) or die(mysql_error());
	
  $rowCount = 0;
	
	while($row=mysql_fetch_array($result)){
		
		$fabID = $row['fabID'];
		$ELK_ArtNo = $row['ELK_ArtNo'];
		$Supp_ArtNo = $row['Supp_ArtNo'];
		$SupplierID = $row['SupplierID'];
		$Comp = $row['Comp'];
		$Density = $row['Density'];
		$YarnCount = $row['YarnCount'];
		$Width = $row['Width'];
		$WidthUnit = $row['WidthUnit'];
		$Cuttable = $row['Cuttable'];
		$Weight_gm2 = $row['Weight_gm2'];
		$Weight_gyd = $row['Weight_gyd'];
		$FinID = $row['FinID'];	
    $Finishing = $row['Finishing'];	
		$SuppFin = $row['Supp_FinishingNum'];	
		
		$cellClass = "";
		if(($rowCount % 2) == 1) {
      		$cellClass = "shaded";
    	}
		echo "<tr class=$cellClass>";
		echo "<td><a href='item.php?f=$fabID'>View</a></td>";
		echo "<td><a href='javascript:;' onclick='deleteItem(\"".$fabID."\")'>Delete</a></td>";
		echo "<td>$ELK_ArtNo</td>";
		echo "<td>$Supp_ArtNo</td>";
		echo "<td>$SupplierID</td>";
		echo "<td>$Comp</td>";
		echo "<td>$Density</td>";
		echo "<td>$YarnCount</td>";
		echo "<td>$Width$WidthUnit</td>";
		echo "<td>$Weight_gm2</td>";
		echo "<td>$Finishing</td>";
		echo "<td>$SuppFin</td>";
		
		echo "</tr>";

		$rowCount++;
	}
} else {
    echo "<tr><td colspan='6'>Enter item name to search</td></tr>";
*/
}


?>   


  </table>
</div>
</div>

</body>
</html>