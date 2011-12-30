<?php
// check login
require_once 'classes/Membership.php';
$membership = New Membership();
$membership->confirm_Member();
$user = $membership->get_username();
?>

<?php
//get the q parameter from URL
$q=$_GET["q"];
$getstring = "?";
foreach ($_GET as $key => $value){
  $getstring .=$key."=".$value."&";
}
?>

<html>

<head>
<link rel="stylesheet" href="../js/dijit/themes/tundra/tundra.css">
<script src="../js/dojo/dojo.js"></script>
</head>

<body class="tundra">
<h2>View/Search Fabric Articles DB</h2>

<form class="myForm" name="searchItem" action="searchFabric.php" method="get">
<div id="itemDIV" style="position: relative; ">
	<table>
	<tr><td class='label'>Item Name:</td>
		<td class='formInput'>
		<input type="text" name="q" id="name" onBlur="" size="50" value=<?php echo $q ?> >
    <a href="searchFabric.php?q=*">get all</a>
    </td>
    <td><button action="submit">Submit</button></td>
    </tr>
  </table>
</div>
</form>

</body>
</html>