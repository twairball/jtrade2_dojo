<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html dir="ltr">
    
    <head>
        <style type="text/css">
            body, html { font-family:helvetica,arial,sans-serif; font-size:90%; }
        </style>
        <script src="http://ajax.googleapis.com/ajax/libs/dojo/1.6/dojo/dojo.xd.js"
        djConfig="parseOnLoad: true">
        </script>
        <script type="text/javascript">
            dojo.require("dijit.form.FilteringSelect");
            dojo.require("dojo.data.ItemFileReadStore");
            dojo.addOnLoad(function() {
				
				//supplier
                new dijit.form.ComboBox({
                    store: suppStore,
                    autoComplete: true,
                    style: "width: 150px;",
                    required: true,
                    id: "suppSel",
					searchAttr: "FullName",
                    onChange: function(suppID) {
						alert("suppID = "+suppID);
						// when supplierId changes, query finishing
						dijit.byId('finSel').query.suppID = suppID || "*";
                    }
                },
                "supplier");
				
				//finishing
                new dijit.form.FilteringSelect({
                    store: finStore,
                    autoComplete: true,
                    query: {
                        suppID: "*"
                    },
					searchAttr: "Finishing",
                    style: "width: 150px;",
                    id: "finSel"
                },
                "finishing");
            });
        </script>
        <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/dojo/1.6/dijit/themes/claro/claro.css"
        />
    </head>
    
    <body class=" claro ">
<!-- data store for suppliers combo box -->
<div data-dojo-type="dojo.data.ItemFileReadStore" data-dojo-id="suppStore"
        data-dojo-props="url:'jsonSuppliersList.php'"></div>
		
<!-- data store for Finishing combo box -->
<div data-dojo-type="dojo.data.ItemFileReadStore" data-dojo-id="finStore"
        data-dojo-props="url:'jsonFinishingList2.php'"></div>
		
        <label for="supplier">
            supplier:
        </label>
        <input id="supplier">
        <label for="finishing">
            finishing:
        </label>
        <input id="finishing">

    </body>

</html>