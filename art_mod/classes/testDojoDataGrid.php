<!DOCTYPE html>
<html>
<head>
<title>The Simplest Dojo DataGrid Example of All Time</title>
<link rel="stylesheet" type="text/css"
 href="/dojo/dijit/themes/claro/claro.css" />

<link rel="stylesheet" type="text/css"
 href="/dojo/dojox/grid/resources/Grid.css" />

 <link rel="stylesheet" type="text/css"
 href="/dojo/dojox/grid/resources/claroGrid.css" />
</head>

<body class="claro">
	<div style="width: 800px; height: 400px">
		<table id="detailsGrid" dojoType="dojox.grid.DataGrid">
	  		<thead>
	    		<tr>
	      			<th field="fabID">fabID</th>
	      			<th field="ELK_ArtNo">ELK_ArtNo</th>
	      			<th field="Comp">Comp</th>
	      			<th field="Density">Density</th>
					<th field="YarnCount">Yarn Count</th>
					<th field="Finishing" width="150px">Finishing</th>
	    		</tr>
	  		</thead>
		</table>
	</div>

<script type="text/javascript" src="/dojo/dojo/dojo.js" djConfig="parseOnLoad:true"></script>

<script type="text/javascript">
	dojo.require("dojox.grid.DataGrid");
	dojo.require("dojo.data.ItemFileReadStore");
</script>

<script type="text/javascript">
dojo.ready(function() {
	var dataStore =
	new dojo.data.ItemFileReadStore({ url: 'getJSON_publicArtDetails.php?artId=MK-M805'});
	var grid = dijit.byId("detailsGrid");
	grid.setStore(dataStore);
});
</script>

</body>
</html>
