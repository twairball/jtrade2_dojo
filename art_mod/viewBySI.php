
<html>
<head>
<?php // includes path... what a pain
require_once 'includes/art_mod_includes.php'; ?>

<?php // fetch itemId from GET
if(isset($_GET['itemId'])) {
	$itemId = $_GET['itemId'];
	$myUrl = "'classes/jsonSuppItemSearch.php?itemId=$itemId'";
} else {
	$itemId = "Search New";
	$myUrl = "'classes/jsonSuppItemSearch.php?itemId=~";
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

<title>JTrade v2.0 -- (Buy-In) Search Item Details</title>

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

/* clickEdit */
function clickEdit() {
	//alert('clickEdit: r='+currGridRow+', c='+currGridCol+', fabId='+currFabId);
	var myUrl = 'editItem.php?fabId='+currFabId;
	//alert('url='+myUrl);
	
	currGridRow = null;
	currGridCol = null;
	currFabId = null;
	window.location = myUrl;
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
<h1 id="mainheader">View/Search Buy-in Items</h1> 

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
<form id="search" action="viewBySI.php">
	<h2>Search by Supplier Item No.</h2>
	<input type="text" name="itemId" value="<?php echo $itemId;?>" dojoType="dijit.form.TextBox"
trim="true" id="itemId">
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
					<th field="SupplierID" width="40px">SuppID</th>
	      			<th field="Supp_ArtNo" width="100px">ItemNo</th>
	      			<th field="Comp">Comp</th>
	      			<th field="Density">Density</th>
					<th field="YarnCount" width="150px">Yarn Count</th>
					<th field="WidthPrint" width="40px">Width</th>
					<th field="Weight_gm2" width="40px">g/m2</th>
					<th field="Finishing" width="300px">Finishing</th>
					<th field="Supp_FinishingNum">Finish No</th>
	    		</tr>
	  		</thead>
		</table>
	</div>

<div dojoType="dijit.Menu" id="gridMenu" style="display: none;">
	<div dojoType="dijit.MenuItem">ArtPriv = <?php echo $artPriv;?></div>
	<div dojoType="dijit.MenuSeparator"></div>
	<div dojoType="dijit.MenuItem" onClick="clickEdit"
		iconClass="dijitEditorIcon dijitEditorIconCut">Edit Article</div>
	<div dojoType="dijit.MenuItem" onClick="clickEdit()">View Pricing</div>
	<div dojoType="dijit.MenuItem">Issue PO</div>
</div>





</body>
</html>
