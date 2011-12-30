<?php

require_once 'classes/Membership.php';
$membership = New Membership();

$membership->confirm_Member();
$user = $membership->get_username();
$artPriv = $membership->get_ArtPriv();
?>

<html>

<head>
<meta charset="utf-8">
<title> JTrade v2.0  -- Login -- </title>
<title>JTrade v2.0 -- (Public) View Article Details</title>
<link rel="stylesheet" type="text/css"
 href="/dojo/dijit/themes/claro/claro.css" />

<link rel="stylesheet" type="text/css"
 href="/dojo/dojox/grid/resources/Grid.css" />

 <link rel="stylesheet" type="text/css"
 href="/dojo/dojox/grid/resources/claroGrid.css" />
 
 <link rel="stylesheet" href="/dojo/dojo/resources/dojo.css" />

 <script type="text/javascript" src="/dojo/dojo/dojo.js" djConfig="parseOnLoad:true"></script>

 <style>
 .priv {display: none;}
 #artPriv1 {background-color:orange;}
 #artPriv2 {background-color:pink;}
 #artPriv3 {background-color:#E0E0E0 ;}
 </style>
<script>


function init() {
	// check priviledges and stuff
	var artPriv = <?php echo $artPriv; ?>;

		var artPriv1 = dojo.byId("artPriv1");
		var artPriv2 = dojo.byId("artPriv2");	
		
	if(artPriv == 1) {
		// show artPriv1
		dojo.style(artPriv1,"display","block");
	} else if (artPriv == 2) {
		// show artPriv2
		dojo.style(artPriv2,"display","block");
	} else if (artPriv == 3) {
		// show artPriv1 and artPriv2
		dojo.style(artPriv1,"display","block");
		dojo.style(artPriv2,"display","block");
		dojo.style(artPriv3,"display","block");
	}
	
};



dojo.ready(init);


</script>


</head>

<body class="tundra">
You're logged in as: <b><?php echo $user?></b> | <a href="login.php?status=loggedout">Log Out</a><br>

<div >

	<div style="margin: 0 2em 0 281px;">
		<h1>JTrade v2</h1>
		<i>Aug 2011</i><br>
		
		<br>
		<br>
		<br>
		
		<table>
		<tr><td><h3> --- Articles DB --- </h3></td></tr>
		<tr><td>artPriv= <?php echo $artPriv ?></td></tr>
		<tr><td><a href="art_mod/viewPub.php">Search Article Details</a></td></tr>

		</table>
		
		<div id="artPriv1" class="priv">
			<table>
			<tr><td><a href="art_mod/viewBySI.php">Add/Edit Supplier Items</a></td></tr>
			<tr><td>Fabric suppliers</tr>
			<tr><td>Article costing</tr>
			<tr><td>search/edit PO</tr>		
			</table>
		</div>
		
		<div id="artPriv2" class="priv">
			<table>
			<tr><td>Clients</td></tr>
			<tr><td>article quotations</td></tr>
			<tr><td>search/edit S/C</td></tr>	
			<tr><td>search/edit Invoice</td></tr>
			</table>
		</div>		

		<div id="artPriv3" class="priv">
			<table>
			<tr><td><a href="art_mod/viewNames.php">Article naming</a></td></tr>
			</table>
		</div>	
		
		<table>
		<tr><td><h3> --- Accessories DB --- </h3></td></tr>
		</table>
		
		<table>
		<tr><td><h3> --- Styles DB --- </h3></td></tr>
		</table>
		
		
	</div>
</div>

</body>


</html>
