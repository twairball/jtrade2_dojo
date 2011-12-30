
<html>
<head>
<?php // includes path... what a pain
require_once 'includes/art_mod_includes.php'; ?>

<?php
// fetch artNo from GET
if(isset($_GET['artId'])) {
	$artId = $_GET['artId'];
	$jsonArtNames = "'classes/jsonArtNames.php?artId=$artId'";
} else {
	$artId = "_UNNAMED_";
	$jsonArtNames = "'classes/jsonArtNames.php?artId=$artId'";
}

?>

<?php
//confirm membership priviledges 
require_once '../classes/Membership.php';
$membership = New Membership();
$membership->confirm_Member();
$user = $membership->get_username();
$artPriv = $membership->get_ArtPriv();

$reqPrivArray = array('3'); // required priv level
$membership->confirm_artPriv($reqPrivArray); //confirm sufficient priviledges
?>

<title>JTrade v2.0 -- (Internal) Article Naming</title>

<link rel="stylesheet" type="text/css" href="/dojo/dojo/resources/dojo.css" />
<link rel="stylesheet" type="text/css" href="/jtrade2/template.css" />
<link rel="stylesheet" type="text/css" href="/dojo/dijit/themes/claro/claro.css" />
<link rel="stylesheet" type="text/css" href="/dojo/dojox/grid/resources/Grid.css" />
<link rel="stylesheet" type="text/css" href="/dojo/dojox/grid/resources/claroGrid.css" />
<link rel="stylesheet" type="text/css" href="/dojo/dojox/grid/enhanced/resources/EnhancedGrid_rtl.css" />
<link rel="stylesheet" type="text/css" href="/dojo/dojox/grid/enhanced/resources/claro/EnhancedGrid.css" />

<script type="text/javascript" src="/dojo/dojo/dojo.js" djConfig="parseOnLoad:true"></script>
<script type="text/javascript" src="viewNames.js"></script>

<script type="text/javascript">
	dojo.require("dojox.grid.DataGrid");
	dojo.require("dojox.grid.EnhancedGrid");
	/* enhanced grid plugins */
	dojo.require("dojox.grid.enhanced.plugins.Menu");
	dojo.require("dojo.data.ItemFileReadStore");
	dojo.require("dijit.form.Form");
	dojo.require("dijit.form.TextBox");
    dojo.require("dijit.form.Button");
	dojo.require("dijit.Menu");
	
	/* variables to keep track of grid selection */
	var currGridRow=null;
	var currGridCol=null;
	var currFabId=null;
	var currItemNo = null;
	var currArtNo = null;


</script>

<script type="text/javascript">
dojo.addOnLoad(function() {
	/* data store init*/
	var dataStore = new dojo.data.ItemFileReadStore({ url: <?php echo $jsonArtNames; ?>});
	var grid = dijit.byId("detailsGrid");
	grid.setStore(dataStore);
	
	/* grid menu */
	var gridMenu = dojo.byId('gridMenu');
	dojo.connect(grid,"onCellContextMenu", grid, storeCellMenu); //bind right-click

	//for fading in
	dojo.style("editName", "opacity", "0");
	dojo.style("nameStatus", "opacity", "0"); //feedback
	
	//event bind
	dojo.connect(dijit.byId('saveNewName'),'onClick',saveNewName);
});


</script>

</head>

<body class="claro"  style="margin: 10px">
<h1 id="mainheader">(Internal) Article Naming</h1> 

<!-- Menu based on priviledges -->
<?php 
	include_once('classes/artDB_menu.php'); 
	$menu = new artDB_Menu();
	echo $menu->printMenu($artPriv);
?>

<div id="logout"> <!-- Logout -->
You're logged in as: <b><div id="UserName"><?php echo $user?></div></b> | <a href="/jtrade2/login.php?status=loggedout">Log Out</a><br>
</div>


<div style="height: 20px"></div>
<form id="search" action="viewNames.php">
	<h2>Search by Fabric Art No</h2>
	<input type="text" name="artId" value="<?php echo $artId;?>" dojoType="dijit.form.TextBox"
trim="true" id="artId">
    <button dojoType="dijit.form.Button" type="submit">Submit</button>
	
</form>
	
	<div id="results" style="width: 950px; height: 400px">
		<h2>Results</h2>
		<!--<table id="detailsGrid" dojoType="dojox.grid.DataGrid"
								selectable = "true"
								onRowContextMenu="onRowContextMenu"
								onCellContextMenu="onCellContextMenu">-->
								
		<table id="detailsGrid" dojoType="dojox.grid.EnhancedGrid"
								plugins="{menus:{
											cellMenu:'gridMenu'}
										}">
	  		<thead>
	    		<tr>
	      			<th field="fabID" width="40px">fabID</th>
	      			<th field="ELK_ArtNo" width="100px">ELK_ArtNo</th>
					<th field="Supp_ArtNo" width="100px">Item No</th>
	      			<th field="Comp">Comp</th>
	      			<th field="Density">Density</th>
					<th field="YarnCount" width="150px">Yarn Count</th>
					<th field="WidthPrint" width="40px">Width</th>
					<th field="Weight_gm2" width="40px">g/m2</th>
					<th field="Finishing" width="300px">Finishing</th>
	    		</tr>
	  		</thead>
		</table>
	</div>
	<br>
	<br>
	<br>
<div id="editName">
		<form id="nameForm">
		<table>
			<tr><td><label for="thisFabId">FabId:  </label></td>
				<td><input data-dojo-type="dijit.form.TextBox" id="thisFabId" name="thisFabId"></td>
				</tr>
			<tr><td><label for="thisItemNo">Item No:  </label></td>
				<td><input data-dojo-type="dijit.form.TextBox" id="thisItemNo" name="thisItemNo"></td>
				</tr>
			<tr><td><label for="thisArtNo">ELK Art No:  </label></td>
				<td><input data-dojo-type="dijit.form.TextBox" id="thisArtNo" name="thisArtNo"></td>
				</tr>
			<tr><td><button data-dojo-type="dijit.form.Button" type="submit" id="saveNewName">Save Name</button></td>
				<td><button data-dojo-type="dijit.form.Button" type="reset" id="nameReset">Clear</button></td>
				</tr>
			<tr><td colspan="2"><div id="nameStatus" style="background-color: yellow"></div>
		</table>
		</form>
</div>

<div dojoType="dijit.Menu" id="gridMenu" style="display: none;">
	<div dojoType="dijit.MenuItem">ArtPriv = <?php echo $artPriv;?></div>
	<div dojoType="dijit.MenuItem" onClick="clickEditName"
		iconClass="dijitEditorIcon dijitEditorIconCut">Edit Name</div>
	<div dojoType="dijit.MenuItem" onClick="clickEditItem"
		iconClass="dijitEditorIcon dijitEditorIconCut">Edit Article</div>
	<div dojoType="dijit.MenuItem">

	</div>
	<div dojoType="dijit.MenuSeparator"></div>
	<div dojoType="dijit.MenuItem" onClick="clickViewQuotations">View Quotations</div>
	<div dojoType="dijit.MenuItem" onClick="clickIssueSC">IssueSC</div>
	
</div>

<span id="xhrResponse">xhrResponse.</span>




</body>
</html>
