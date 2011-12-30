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
	currItemNo = this.store.getValue(item, "Supp_ArtNo");
	currArtNo = this.store.getValue(item, "ELK_ArtNo");
}

function clickEditName() {
	currGridRow = null;
	currGridCol = null;
	
	// input
	dijit.byId('thisFabId').attr('value',currFabId);
	dijit.byId('thisFabId').attr('disabled','disabled');
	dijit.byId('thisItemNo').attr('value',currItemNo);
	dijit.byId('thisItemNo').attr('disabled','disabled');
	dijit.byId('thisArtNo').attr('value',currArtNo);
	
	//alert('clickEditName, thisFabId:'+currFabId+', thisItemNo:'+currItemNo+', thisArtNo: '+currArtNo);
	dojo.style("editName", "opacity", "0");
	var fadeArgs = {
        node: "editName"
    };
    dojo.fadeIn(fadeArgs).play();
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

	function saveNewName() {
		var fabId= dijit.byId('thisFabId').get('value');
		var Supp_ArtNo = dojo.attr('thisItemNo','value');
		var ELK_ArtNo = dojo.attr('thisArtNo','value');
		var UserName = dojo.byId('UserName').innerHTML;
		var param = newNameParam(fabId, Supp_ArtNo, ELK_ArtNo, UserName, 0);
		
		//quick check for blanks
		if(fabId && Supp_ArtNo && ELK_ArtNo) {

			// all good
			dojo.byId("xhrResponse").innerHTML = "param="+param;
					
			//The parameters to pass to xhrPost, the message, and the url to send it to
			//Also, how to handle the return and callbacks.
			var xhrArgs = {
						url: "classes/db_nameSave.php",
						postData: param,
						handleAs: "text",
						load: function(data) {
							dojo.byId("xhrResponse").innerHTML = data;
							
							//feedback
							dojo.byId("nameStatus").innerHTML = "Record Saved! "+fabId+": "+Supp_ArtNo+" ["+ELK_ArtNo+"]";
							var fadeArgs = {node: "nameStatus"};
							dojo.fadeIn(fadeArgs).play();
							
							// clear form
							nameForm.reset();	
							
						},
						error: function(error) {
							dojo.byId("xhrResponse").innerHTML = "error: "+error;
						}
			}
			dojo.byId("xhrResponse").innerHTML = "Saving New Finishing..."
			//Call the asynchronous xhrPost
			var deferred = dojo.xhrPost(xhrArgs);
		}
	}

	function newNameParam(fabId, itemNo, ArtNo, UserName, Verbose) {
			var param = "FabID="+encodeURIComponent(fabId);
				param += "&Supp_ArtNo="+encodeURIComponent(itemNo);
				param += "&ELK_ArtNo="+encodeURIComponent(ArtNo);
				param += "&UserName="+encodeURIComponent(UserName);
				param += "&Verbose="+Verbose; //verbose feedback
				param += "&sid="+Math.random();
		return param;
	}