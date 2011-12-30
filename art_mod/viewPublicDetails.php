
<html>
<head>

<?php
// fetch artId from GET
if(isset($_GET['artId'])) {
	$artId = $_GET['artId'];
	$myUrl = "'classes/getJSON_publicArtDetails.php?artId=$artId'";
} else {
	$artId = "Search New";
	$myUrl = "'classes/getJSON_publicArtDetails.php?artId=~";
}

?>

<?php
//confirm membership priviledges 
require_once 'classes/Membership.php';
$membership = New Membership();
$membership->confirm_Member();
$user = $membership->get_username();
$artPriv = $membership->get_ArtPriv();
?>


<title>JTrade v2.0 -- (Public) View Article Details</title>
<link rel="stylesheet" type="text/css"
 href="/dojo/dijit/themes/claro/claro.css" />

<link rel="stylesheet" type="text/css"
 href="/dojo/dojox/grid/resources/Grid.css" />

 <link rel="stylesheet" type="text/css"
 href="/dojo/dojox/grid/resources/claroGrid.css" />
 
 <link rel="stylesheet" href="/dojo/dojo/resources/dojo.css" />
</head>

<body class="claro"  style="margin: 10px">
<h1>View/Search Fabric Articles</h1> 
You're logged in as: <b><?php echo $user?></b> | <a href="/jtrade2/login.php?status=loggedout">Log Out</a><br>
<div style="height: 20px"></div>
<form id="search" action="viewPublicDetails.php">
	<h2>Search by Fabric Art No</h2>
	<input type="text" name="artId" value="<?php echo $artId;?>" dojoType="dijit.form.TextBox"
trim="true" id="artId">
    <button dojoType="dijit.form.Button" type="submit">Submit</button>
	
</form>

	<div id="results" style="width: 950px; height: 400px">
		<h2>Results</h2>
		<table id="detailsGrid" dojoType="dojox.grid.DataGrid">
	  		<thead>
	    		<tr>
	      			<th field="fabID" width="40px">fabID</th>
	      			<th field="ELK_ArtNo" width="100px">ELK_ArtNo</th>
	      			<th field="Comp">Comp</th>
	      			<th field="Density">Density</th>
					<th field="YarnCount" width="150px">Yarn Count</th>
					<th field="Width" width="40px">Width</th>
					<th field="WidthUnit" width="30px">.</th>
					<th field="Weight_gm2" width="40px">g/m2</th>
					<th field="Finishing" width="300px">Finishing</th>
	    		</tr>
	  		</thead>
		</table>
	</div>

<script type="text/javascript" src="/dojo/dojo/dojo.js" djConfig="parseOnLoad:true"></script>

<script type="text/javascript">
	dojo.require("dojox.grid.DataGrid");
	dojo.require("dojo.data.ItemFileReadStore");
	dojo.require("dijit.form.Form");
	dojo.require("dijit.form.TextBox");
    dojo.require("dijit.form.Button");

</script>

<script type="text/javascript">
dojo.ready(function() {
	var dataStore =
	new dojo.data.ItemFileReadStore({ url: <?php echo $myUrl; ?>});
	var grid = dijit.byId("detailsGrid");
	grid.setStore(dataStore);
});
</script>

</body>
</html>
