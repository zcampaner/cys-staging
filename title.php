<?php
	//var_export($_GET["sidebar"]);die;
	if ($_GET["sidebar"]==='users'){
		$sTitle = 'Users';
	}
	if ($_GET["sidebar"]==='hotels'){
		$sTitle = 'Hotels';
	} 
	// $sTitle = "Hello World";
?>
<title><?php echo $sTitle;?> - Central Yield System Database</title>

<!-- <title>Default- Central Yield System Database</title> -->