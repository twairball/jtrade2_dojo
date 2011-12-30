
<html>
<head>
<?php // includes path... what a pain
require_once 'includes/art_mod_includes.php'; ?>

<?php
// fetch artNo from GET
if(isset($_GET['artId'])) {
	$artId = $_GET['artId'];
	$myUrl = "'classes/jsonPublicArtSearch.php?artId=$artId'";
} else {
	$artId = "Search New";
	$myUrl = "'classes/jsonPublicArtSearch.php?artId=~";
}

?>

<?php
//confirm membership priviledges 
require_once '../classes/Membership.php';
$membership = New Membership();
$membership->confirm_Member();
$user = $membership->get_username();
$artPriv = $membership->get_ArtPriv();
?>

<title>JTrade v2.0 -- (Public) View Article Details</title>

<link rel="stylesheet" type="text/css" href="/dojo/dojo/resources/dojo.css" />
<link rel="stylesheet" type="text/css" href="/jtrade2/template.css" />
<link rel="stylesheet" type="text/css" href="/dojo/dijit/themes/claro/claro.css" />
<link rel="stylesheet" type="text/css" href="/dojo/dojox/grid/resources/Grid.css" />
<link rel="stylesheet" type="text/css" href="/dojo/dojox/grid/resources/claroGrid.css" />
<link rel="stylesheet" type="text/css" href="/dojo/dojox/grid/enhanced/resources/EnhancedGrid_rtl.css" />
<link rel="stylesheet" type="text/css" href="/dojo/dojox/grid/enhanced/resources/claro/EnhancedGrid.css" />
<script type="text/javascript" src="/dojo/dojo/dojo.js" djConfig="parseOnLoad:true"></script>

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
	
/* cellClick */
function cellClick() {
	alert('cellClick: '+e.cellNode.innerHTML+" Row: "+e.rowIndex+" Col: "+e.cellIndex);
}

/* called on onCellContextMenu */
function storeCellMenu(e) {
	currGridRow = e.rowIndex;
	currGridCol = e.cellIndex;
	
	item = this.getItem(currGridRow);
	currFabId = this.store.getValue(item, "fabID");
}

function clickEditItem() {
	currGridRow = null;
	currGridCol = null;
	window.location = 'editItem.php?fabId='+currFabId;
}

function clickViewQuotations() {
	currGridRow = null;
	currGridCol = null;
	window.location = 'viewQuotations.php?fabId='+currFabId;
}
function clickIssueSC() {
	currGridRow = null;
	currGridCol = null;
	window.location = 'clickIssueSC.php?fabId='+currFabId;
}

</script>

<script type="text/javascript">
dojo.addOnLoad(function() {
	/* data store init*/
	var dataStore = new dojo.data.ItemFileReadStore({ url: <?php echo $myUrl; ?>});
	var grid = dijit.byId("detailsGrid");
	grid.setStore(dataStore);
	
	/* grid menu */
	var gridMenu = dojo.byId('gridMenu');
	//gridMenu.bindDomNode(grid.domNode);
	//dojo.connect(grid,"onCellClick", null, cellClick);
	dojo.connect(grid,"onCellContextMenu", grid, storeCellMenu);

});


</script>

</head>

<body class="claro"  style="margin: 10px">
<h1 id="mainheader">View/Search Fabric Articles</h1> 

<!-- Menu based on priviledges -->
<?php 
	include_once('classes/artDB_menu.php'); 
	$menu = new artDB_Menu();
	echo $menu->printMenu($artPriv);
?>

<div id="logout">
You're logged in as: <b><?php echo $user?></b> | <a href="/jtrade2/login.php?status=loggedout">Log Out</a><br>
</div>


<div style="height: 20px"></div>
<form id="search" action="viewPub.php">
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

<div dojoType="dijit.Menu" id="gridMenu" style="display: none;">
	<div dojoType="dijit.MenuItem">ArtPriv = <?php echo $artPriv;?></div>
	<div dojoType="dijit.MenuItem" onClick="clickEditItem"
		iconClass="dijitEditorIcon dijitEditorIconCut">Edit Article</div>	
	<div dojoType="dijit.MenuSeparator"></div>
	<div dojoType="dijit.MenuItem" onClick="clickViewQuotations">View Quotations</div>
	<div dojoType="dijit.MenuItem" onClick="clickIssueSC">IssueSC</div>
</div>





</body>
</html>
