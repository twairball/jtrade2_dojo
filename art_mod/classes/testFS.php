<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html dir="ltr">
    
    <head>
        <style type="text/css">
            body, html { font-family:helvetica,arial,sans-serif; font-size:90%; }
        </style>
<script type="text/javascript" src="/dojo/dojo/dojo.js" djConfig="parseOnLoad:true"></script>
        <script type="text/javascript">
            dojo.require("dijit.form.FilteringSelect");
            dojo.require("dojo.data.ItemFileReadStore");
        </script>
		
		<script type="text/javascript">
			dojo.addOnLoad(function() {
				// bug? Filtering select default value 
				dijit.byId('supplierSelect').attr('value','FDF');
			});
			
		</script>
		
        <link rel="stylesheet" type="text/css" href="/dojo/dijit/themes/claro/claro.css" />
    </head>
    
    <body class=" claro ">
        <div data-dojo-type="dojo.data.ItemFileReadStore" data-dojo-id="stateStore"
        data-dojo-props="url:'jsonSuppliersList.php'">
        </div>
        <input data-dojo-type="dijit.form.FilteringSelect" value="FDF"
				data-dojo-props="store:stateStore, searchAttr:'FullName'"
				name="supplierID" id="supplierSelect">

				<p>
    <button onClick="alert(dijit.byId('supplierSelect').get('value'))">
        Get value
    </button>
    <button onClick="alert(dijit.byId('supplierSelect').get('displayedValue'))">
        Get displayed value
    </button>
</p>

    </body>

</html>