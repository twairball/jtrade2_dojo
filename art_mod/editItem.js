	
	/* to show 2 columns for finishingSelect */
	function myLabelFunc(item, store){
            var label=store.getValue(item, 'Finishing')+" : #"+store.getValue(item, 'Supp_FinishingNum');
            return label;
    }
	
	function suppFsOnChange() {
		var suppID= dijit.byId('supplierSelect').get('value'); //new supplierID
		jsonFinishingList = 'classes/jsonFinishingList.php?supplierID='+suppID; // ammend jsonFinishingList
		refreshFinFS(); // refresh finishing
	}
	
	function fsFetch() {
		var fsValue = dijit.byId('finishingSelect').get('value');
		//alert('test fetch: '+fsValue);
	        //Fetch the data.
			finishingStore.fetch({
                query: {
                    FinID: fsValue
                },
				onBegin: startFetch,
                onComplete: gotItems,
				onError: fetchFailed 
            });
	}
	
	function startFetch(size, request) {
		var list = dojo.byId("list2");
                if (list) {
                    while (list.firstChild) {
                        list.removeChild(list.firstChild);
                    }
                }
	}
	
	function fetchFailed(error, request) {
         alert("fsFinishing / fetch failed:"+error);
	}
	
	function gotItems(items, request) {
		// debugging
		
		var list = dojo.byId("list2");
		//alert('gotItems, items.length='+items.length);
		for (i = 0; i < items.length; i++) {
			var item = items[i];
			list.appendChild(document.createTextNode(finishingStore.getValue(item, "FinID")
				+ " : " + finishingStore.getValue(item, "Supp_FinishingNum")
			));
			//list.appendChild(document.createElement("br"));
        }
		
		dojo.byId("finID").value = finishingStore.getValue(item, "FinID");
		dojo.byId("Supp_FinishingNum").value = finishingStore.getValue(item, "Supp_FinishingNum");
		
	}
	

    function saveYes() {
        dijit.byId("dialogColor").hide();
		
		var fabId = dojo.attr('fabId','value')
		var SuppID= dijit.byId('supplierSelect').get('value');
		var Supp_ArtNo = dojo.attr('Supp_ArtNo','value');
		var Comp = dojo.attr('Comp','value');
		var Density = dojo.attr('Density','value');
		var YarnCount = dojo.attr('YarnCount','value');
		var Width = dojo.attr('Width','value');
		var WidthUnit = dijit.byId('WidthUnit').get('value');
		var Cuttable = dojo.attr('Cuttable','value');
		var Weight_gm2 = dojo.attr('Weight_gm2','value');
		var Weight_gyd = dojo.attr('Weight_gyd','value');
		var FinID = dojo.attr('finID','value');
		var Remark = dojo.attr('Remark','value');
		var UserName = dojo.byId('UserName').innerHTML;
		var param = getPostParam(fabId, SuppID, Supp_ArtNo, Comp, Density, YarnCount, Width, WidthUnit, Cuttable, Weight_gm2, Weight_gyd, FinID, Remark, UserName, 0); 
		//alert('param = '+param);
		//alert('widthUnit='+encodeURIComponent(WidthUnit));
		
		var url; // url of php to call mysql save 
		if(fabId) {
			url = "classes/db_itemUpdate.php"; // update
		} else {
			url = "classes/db_itemSave.php"; // add new
		}
			
		//quick check for blanks
		if(SuppID && FinID && Supp_ArtNo) {

			//alert ('url = '+url);
			dojo.byId("xhrResponse").innerHTML = "param="+param;
					
			//The parameters to pass to xhrPost, the message, and the url to send it to
			//Also, how to handle the return and callbacks.
			var xhrArgs = {
					url: url,
					postData: param,
					handleAs: "text",
					load: function(data) {
						dojo.byId("xhrResponse").innerHTML = data;	
						//feedback
						dojo.byId("editStatus").innerHTML = "Record Saved! "+SuppID+": "+Supp_ArtNo+" ["+FinID+"]";
						var fadeArgs = {node: "editStatus"};
						dojo.fadeIn(fadeArgs).play();

					},
					error: function(error) {
							dojo.byId("xhrResponse").innerHTML = "error: "+error;
					}
			}
			dojo.byId("xhrResponse").innerHTML = "Saving New Finishing..."
			//Call the asynchronous xhrPost
			var deferred = dojo.xhrPost(xhrArgs);
			
		} else {
			alert('check supplier, finishing, and article number are entered');
		}
	
    }
	
    function saveNo() {
        dijit.byId("dialogColor").hide();
    }
	
	function getPostParam(fabId, SuppID, Supp_ArtNo, Comp, Density, YarnCount, Width, WidthUnit, Cuttable, Weight_gm2, Weight_gyd, FinID, Remark, UserName, Verbose) {
		
		var param = "fabID="+encodeURIComponent(fabId); 
		param=param+"&Supp_ArtNo="+encodeURIComponent(Supp_ArtNo);
		param=param+"&SupplierID="+encodeURIComponent(SuppID);
		param=param+"&Comp="+encodeURIComponent(Comp);
		param=param+"&Density="+encodeURIComponent(Density);
		param=param+"&YarnCount="+encodeURIComponent(YarnCount);
		param=param+"&Width="+encodeURIComponent(Width);
		param=param+"&WidthUnit="+encodeURIComponent(WidthUnit);
		param=param+"&Cuttable="+encodeURIComponent(Cuttable);
		param=param+"&Weight_gm2="+encodeURIComponent(Weight_gm2);
		param=param+"&Weight_gyd="+encodeURIComponent(Weight_gyd);
		param=param+"&FinID="+encodeURIComponent(FinID);
		param=param+"&Remark="+encodeURIComponent(Remark);
		param=param+"&UserName="+encodeURIComponent(UserName);
		param=param+"&Verbose="+encodeURIComponent(Verbose);
		param=param+"&sid="+Math.random();
		
	return param;
	}
	
	function saveNewFinishing() {
		var suppID= dijit.byId('supplierSelect').get('value');
		var newFinishing = dojo.attr('newFinishing','value');
		var newSuppFin = dojo.attr('newSuppFin','value');
		var UserName = dojo.byId('UserName').innerHTML;
		var param = newFinParam(suppID, newFinishing, newSuppFin, UserName, 0);
		
		//quick check for blanks
		if(suppID) {
			if(newFinishing) {
				if((suppID = "FDF") && (!newSuppFin)) {
					// add additional catch for blank FDF finishing number
					alert('FDF Finishing Num# is blank');
				} else {
					// all good
					//alert('saveNewFinishing, suppID='+suppID+'\n Finishing='+newFinishing+'\n SuppFin='+newSuppFin+'\n UserName='+UserName);
					dojo.byId("xhrResponse").innerHTML = "param="+param;
					
					//The parameters to pass to xhrPost, the message, and the url to send it to
					//Also, how to handle the return and callbacks.
					var xhrArgs = {
						url: "classes/db_finishingSave.php",
						postData: param,
						handleAs: "text",
						load: function(data) {
							dojo.byId("xhrResponse").innerHTML = data;
							
							//feedback
							dojo.byId("newFinStatus").innerHTML = "Record Saved! "+suppID+": "+newFinishing+" ["+newSuppFin+"]";
							var fadeArgs = {node: "newFinStatus"};
							dojo.fadeIn(fadeArgs).play();
							
							// clear form
							newFinForm.reset();
							
							//refresh store
							refreshFinFS();
								
							
						},
						error: function(error) {
							dojo.byId("xhrResponse").innerHTML = "error: "+error;
						}
					}
					dojo.byId("xhrResponse").innerHTML = "Saving New Finishing..."
					//Call the asynchronous xhrPost
					var deferred = dojo.xhrPost(xhrArgs);
					
				}
			} else {
				//blank finishing
				alert('Finishing is blank');
			}
		} else {
			//blank suppID
			alert('supplier is blank');
		}
	}
	
	function newFinParam(suppID, newFinishing, newSuppFin, UserName, Verbose) {
			var param = "SupplierID="+encodeURIComponent(suppID);
				param += "&Fin="+encodeURIComponent(newFinishing);
				param += "&SuppFin="+encodeURIComponent(newSuppFin);
				param += "&UserName="+encodeURIComponent(UserName);
				param += "&Verbose="+Verbose; //verbose feedback
				param += "&sid="+Math.random();
		return param;
	}
	
	//doesnt actually do anything...
	function clearForm() {
		alert('clearForm');
		// used to clear some fields for adding new item, because onChange fires after load
		var list = dojo.byId("list2");
                if (list) {
                    while (list.firstChild) {
                        list.removeChild(list.firstChild);
                    }
                }
		dojo.byId("finID").value = "";
		dojo.byId("Supp_FinishingNum").value = "";
	}