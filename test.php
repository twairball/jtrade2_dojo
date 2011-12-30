<?php

require 'classes/Mysql.php';

	$un = 'jerry';
	$pwd = 'f00tball';
	
		$mysql = New Mysql();
		$ensure = $mysql->verify_Username_and_Pass($un, md5($pwd));
		echo $ensure;
		?>
		
		<body>
		$un = <?php echo $un; ?>
		$pwd = <?php echo $pwd; ?>
		$ensure = <?php echo $ensure; ?>
		</body>