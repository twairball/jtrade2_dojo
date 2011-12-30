<?php

class artDB_Menu {

	function printMenu($artPriv) {
		
		$printStr = "";
		$printStr .= '<div id="menu">
								<a href="../index.php">Menu</a> | 
								<a href="viewPub.php">Search Art</a> | ';
		
		// all priviledges
		if ($artPriv == 3) {
			$printStr .= '<a href="viewNames.php" style="background-color: #CCFFFF">Art Naming</a> | ';	
		}
		
		// buy/cost side only
		if ($artPriv ==1 || $artPriv ==3) {
			$printStr .= '<a href="viewBySI.php" style="background-color: #FFCCFF">Search Item</a> |
						<a href="editItem.php" style="background-color: #FFCCFF">Add Item</a> | 
						<a href="suppliers.php" style="background-color: #FFCCFF">Suppliers</a> | 
						<a href="costing.php" style="background-color: #FFCCFF">Costing</a> | 
						<a href="artPO.php" style="background-color: #FFCCFF">PO</a> | ';
			
		} 
		
		// sales side only
		if ($artPriv == 2 || $artPriv == 3) {
			$printStr .= '<a href="clients.php" style="background-color: #CCFF99">Clients</a> | 
						<a href="quotation.php" style="background-color: #CCFF99">Quotations</a> | 
						<a href="artSC.php" style="background-color: #CCFF99">SC</a> | 
						<a href="artInvoice.php" style="background-color: #CCFF99">Invoices</a> | ';		
		}
		// close printStr
		$printStr .= '</div>';
			
		return $printStr;
	}
		
}
		
?>