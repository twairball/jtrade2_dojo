
<html>
<head>
<?php // includes path... what a pain
require_once 'includes/art_mod_includes.php'; //echo "include_path: ".get_include_path()."<br>";
?>

<?php // fetch artId from GET

require_once 'classes/artDB_Mysql.php';
$artDB = new artDB_Mysql;

//setup variables add new item
	$fabId ="";

	$Supp_ArtNo = "";
	$SupplierID = "FDF"; // default supplier
	$Comp = "";
	$Density ="";
	$YarnCount = "";
	$Width = "57"; // default
	$WidthUnit = htmlspecialchars("\""); //html special chars for \"
	$Cuttable = "56"; // default
	$Weight_gm2 = "";
	$Weight_gyd = "";
	$FinID = "";
	$Supp_FinishingNum = "";
	$TimeStamp = "";
	$lastEditedBy = "";
	$Remark = "";
	$jsonSIDetails = "'classes/jsonSuppItemDetails.php?fabId=-1'";
	$jsonFinishingList = "'classes/jsonFinishingList.php?supplierID=$SupplierID'";
	
if(isset($_GET['fabId'])) {
	$fabId = $_GET['fabId'];
	
	$itemArray = Array();
	$itemArray = $artDB->array_SIByFabId($fabId);
	
	$Supp_ArtNo = $itemArray['Supp_ArtNo'];
	$SupplierID = $itemArray['SupplierID'];
	$Comp = $itemArray['Comp'];
	$Density = $itemArray['Density'];
	$YarnCount = $itemArray['YarnCount'];
	$Width = $itemArray['Width'];
	$WidthUnit = htmlspecialchars($itemArray['WidthUnit']); //html special chars for \"
	$Cuttable = $itemArray['Cuttable'];
	$Weight_gm2 = $itemArray['Weight_gm2'];
	$Weight_gyd = $itemArray['Weight_gyd'];
	$FinID = $itemArray['FinID'];
	$Supp_FinishingNum = $itemArray['Supp_FinishingNum'];
	$TimeStamp = $itemArray['TimeStamp'];
	$lastEditedBy = htmlspecialchars($itemArray['lastEditedBy']);
	$Remark = htmlspecialchars($itemArray['REMARK']);
	$jsonSIDetails = "'classes/jsonSuppItemDetails.php?fabId=$fabId'";
	$jsonFinishingList = "'classes/jsonFinishingList.php?supplierID=$SupplierID'";
	//echo "jsonFin = $jsonFinishingList<br>";
} else {
	$Supp_ArtNo = "";
}
?>

<?php
//confirm membership priviledges 
require_once '../classes/Membership.php';
$membership = New Membership();
$membership->confirm_Member();
$user = $membership->get_username();
$artPriv = $membership->get_ArtPriv();

$reqPrivArray = array('1','3'); // required priv level
$membership->confirm_artPriv($reqPrivArray); //confirm sufficient priviledges
?>

<title>JTrade v2.0 -- (Buy-In) Edit Item Details</title>

<script type="text/javascript" src="/dojo/dojo/dojo.js" djConfig="parseOnLoad:true"></script>
<link rel="stylesheet" type="text/css" href="/dojo/dojo/resources/dojo.css" />
<link rel="stylesheet" type="text/css" href="/jtrade2/template.css" />
<link rel="stylesheet" type="text/css" href="/dojo/dijit/themes/claro/claro.css" />
		
<script type="text/javascript" src="editItem.js"></script>

<script type="text/javascript"> <!-- dojo Requires -->
	dojo.require("dojo.data.ItemFileReadStore");
	dojo.require("dojo.data.ItemFileWriteStore");
	dojo.require("dijit.form.Form");
	dojo.require("dijit.form.Select");	
	dojo.require("dijit.form.TextBox");
    dojo.require("dijit.form.Button");
	dojo.require("dijit.Menu");
    dojo.require("dijit.form.FilteringSelect");
	dojo.require("dijit.Dialog");

</script>


<script type="text/javascript"> <!-- dojo addOnLoad -->

	var jsonFinishingList = <?php echo $jsonFinishingList?>; //url of json for FinishingList used in finishingSelect fs

	dojo.addOnLoad(function() {

		//loading by JSON doesn't work....
		//dijit.byId("editForm").attr('value',dijit.byId('itemRecordStore').getValue('items'));
                
		// create the dialog:
        var dialogColor = dijit.byId("dialogColor");
		dojo.style("newFinStatus", "opacity", "0"); //feedback
		// event binds
        dojo.connect(dijit.byId("saveButton"), "onClick", dialogColor, "show");
		dojo.connect(dijit.byId('supplierSelect'), 'onChange', suppFsOnChange);
		dojo.connect(dijit.byId('finishingSelect'), 'onChange', fsFetch);
		dojo.connect(dijit.byId('saveYes'), 'onClick', saveYes);
		dojo.connect(dijit.byId('saveNo'), 'onClick', saveNo);
		dojo.connect(dijit.byId('newFinSaveButton'),'onClick',saveNewFinishing);
		
		
		/*
		// debugging select
		dojo.connect(dijit.byId("WidthUnit"), "onChange", function () {
			alert(dijit.byId("WidthUnit").get('value'));
		});
		
	    //for debugging
		dojo.connect(dijit.byId("reloadFs"), "onClick", function() {
			var fs = dijit.byId('finishingSelect');
			fs.store.close();
			finishingStore =  new dojo.data.ItemFileReadStore({url: jsonFinishingList});
			finishingStore.fetch({ onBegin: function(total){ console.log("reload finFs: There are now ", total, " items in this store."); } });
			fs.store = finishingStore;	
        });
		*/
		
		//check num items in fs
		finishingStore.fetch({ onBegin: function(total){ console.log("finishingStore: There are now ", total, " items in this store."); } });
	});
	
	dojo.ready(function() {
		// bug? Filtering select default value 
		dijit.byId('supplierSelect').attr('value','<?php echo $SupplierID;?>');
		dijit.byId('finishingSelect').attr('value','<?php echo $FinID;?>');
	
	});
	
	// refresh filteringselect... what a pain
	function refreshFinFS () {
		var fs = dijit.byId('finishingSelect');
		fs.store.close();
		finishingStore =  new dojo.data.ItemFileReadStore({url: jsonFinishingList});
		finishingStore.fetch({ onBegin: function(total){ console.log("store: There are now ", total, " items in this store."); } });
		fs.store = finishingStore;
	}
</script>


<body class="claro"  style="margin: 10px">

<h1 id="mainheader">(Buy-In) Item Edit</h1> 

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

<!-- data store for suppliers combo box -->
<div data-dojo-type="dojo.data.ItemFileReadStore" data-dojo-id="suppStore"
        data-dojo-props="url:'classes/jsonSuppliersList.php'"></div>

<!-- data store for Finishing combo box -->
<!--<div dojoType="dojo.data.ItemFileReadStore" url=""
		id="finishingStore" 
		jsId="finishingStore" urlPreventCache="true" clearOnClose="true"></div>
-->
<div data-dojo-type="dojo.data.ItemFileWriteStore" data-dojo-id="finishingStore"
        data-dojo-props="url:<?php echo $jsonFinishingList?>"></div>


<form id="editForm" action="viewPub.php">

	<h2>Enter/Edit Details</h2>
	
	<table>
	<tr>
		<td><label for="fabId">FabID: </label></td>
		<td><input type="text" name="fabID" id="fabId" dojoType="dijit.form.TextBox"
			readOnly="true" trim="true" value="<?php echo $fabId;?>">
		</td>
	<tr>
		<td><label for="Supp_ArtNo">Item No. </label></td>
		<td><input type="text" name="Supp_ArtNo" id="Supp_ArtNo" 
			value="<?php echo $Supp_ArtNo;?>" dojoType="dijit.form.TextBox"	trim="true" >	
		</td>
	<tr>
		<td><label for="supplierSelect">Supplier </label></td>
		<td><input data-dojo-type="dijit.form.FilteringSelect" 
				data-dojo-props="store:suppStore, searchAttr:'FullName'"
				name="SupplierID" 
				id="supplierSelect"
				value="<?php echo $SupplierID;?>">
				
		</td>
	<tr>
		<td><label for="Comp">Comp </label></td>
		<td><input type="text" name="Comp" id="Comp" 
			value="<?php echo $Comp;?>" dojoType="dijit.form.TextBox"	trim="true" >				
		</tr>
	<tr>
		<td><label for="Density">Density </label></td>
		<td><input type="text" name="Density" id="Density" 
			value="<?php echo $Density;?>" dojoType="dijit.form.TextBox"	trim="true" >	
		</tr>
	<tr>
		<td><label for="YarnCount">YarnCount </label></td>
		<td><input type="text" name="YarnCount" id="YarnCount" 
			value="<?php echo $YarnCount;?>" dojoType="dijit.form.TextBox"	trim="true" >	
		</td>
	<tr>
		<td><label for="Width">Width </label></td>
		<td><input type="text" name="Width" id="Width" style="width: 5em;"
			value="<?php echo $Width;?>" dojoType="dijit.form.TextBox"	trim="true" >	
			<select name="WidthUnit" id="WidthUnit" dojoType="dijit.form.Select">
				<option value="&quot;" <?php if($WidthUnit=="\"") {echo "selected=\"selected\"";} ?>>&quot;</option>
				<option value="cm" <?php if($WidthUnit=="cm") {echo "selected=\"selected\"";} ?>>cm</option>
			</select>
			<label for="Cuttable">Cuttable </label>
			<input type="text" name="Cuttable" id="Cuttable"  style="width: 5em;"
			value="<?php echo $Cuttable;?>" dojoType="dijit.form.TextBox"	trim="true" >
		</td>
	<tr>
		<td><label for="Weight_gm2">Weight </label></td>
		<td><input type="text" name="Weight_gm2" id="Weight_gm2" style="width: 5em;"
			value="<?php echo $Weight_gm2;?>" dojoType="dijit.form.TextBox"	trim="true" >	g/m2
	<tr>
		<td><label for="Weight_gyd"> </label></td>
		<td><input type="text" name="Weight_gyd" id="Weight_gyd" style="width: 5em;"
			value="<?php echo $Weight_gyd;?>" dojoType="dijit.form.TextBox"	trim="true" >	g/yd

	<tr>
		<td><label for="FinID">FinID: </label></td>
		<td><input type="text" name="finID" id="finID" style="width: 5em;"
			dojoType="dijit.form.TextBox" readOnly="true" trim="true" value="<?php echo $FinID;?>">
		</td>
	<tr>	
		<td><label for="finishingSelect">Finishing </label></td>
		<td><input data-dojo-type="dijit.form.FilteringSelect" 
				data-dojo-props="store:finishingStore, labelFunc:myLabelFunc, searchAttr:'Finishing'"
				name="Finishing" id="finishingSelect" urlPreventCache="true" clearOnClose="true">
										
				<span id="list2" style="visibility: hidden">list2.</span> <!-- for debugging -->
				<!--<button data-dojo-type="dijit.form.Button" type="submit" id="reloadFs">reload</button>
				-->
		</td>
	<tr>
		<td><label for="SuppFinNum">FinishingNum </label></td>
		<td><input type="text" name="Supp_FinishingNum" id="Supp_FinishingNum"
			dojoType="dijit.form.TextBox" readOnly="true" trim="true" value="<?php echo $Supp_FinishingNum;?>">
		</td>
	<tr>
		<td><label for="Remark">Remark </label></td>
		<td><input type="text" name="Remark" id="Remark" 
			value="<?php echo $Remark;?>" dojoType="dijit.form.TextBox"	trim="true" >	
		</tr>

	</table>
</form>
		<br>
		<br>
		<br>
			<table>
			<tr>
				<td><!-- add finishing dropdown button -->
				
				<div data-dojo-type="dijit.form.DropDownButton" id="newFinDDB"><span>Add New Finishing</span>
					<div data-dojo-type="dijit.TooltipDialog">
					<form id="newFinForm" action="db_finishingSave.php">
					<table>
					<tr><td width="10em"><label for="newFinishing">Finishing:</label></td>
						<td><input data-dojo-type="dijit.form.TextBox" id="newFinishing" name="newFinishing"></td>
					</tr>
					<tr><td><label for="newSuppFin">Finishing Num:</label></td>
						<td><input data-dojo-type="dijit.form.TextBox" id="newSuppFin" name="newSuppFin"></td>
					</tr>
					<tr><td><button data-dojo-type="dijit.form.Button" type="submit" id="newFinSaveButton">Save New</button></td>
						<td><button data-dojo-type="dijit.form.Button" type="reset" id="newFinReset">Reset</button></td>
					</tr>
					<tr>
						<td colspan='2'><div id="newFinStatus" style="background-color: yellow"></div></td>
					</tr></table>
					
					</div>
			</div>
</form>

			
				<td><!-- save button and diablog background -->
					<!-- dialog background -->
					<style type="text/css">
						#dialogColor_underlay { background-color:green; }
					</style>
					<div id="dialogColor" title="JTrade v2.0 " dojoType="dijit.Dialog">
						Confirm to save ?
						<button dojoType="dijit.form.Button" id="saveYes" type="button">Confirm</button>
						<button dojoType="dijit.form.Button" id="saveNo" type="button">Cancel</button>
					</div>
					<!-- save button -->
					<button dojoType="dijit.form.Button" id="saveButton" type="button">Save Record</button>
				</td>
				<td style="text-size: 9pt;">
				<b>Last saved:</b> <i><?php echo $TimeStamp; ?></i> <br>
				<b>Edited by:</b> <i><?php echo $lastEditedBy; ?></i>
				</td>
			</table>

	<div id="editStatus" style="background-color:yellow"></div>		

	<span id="xhrResponse">xhrResponse.</span>
	
			
</body>
