<?php

//$db_host        = "10.0.28.80";
$db_host        = "KCCLBD12DES";
$db_name        = "Incentivo";
$db_username    = "contrato";
$db_password    = "contrato";

	//$rep=mssql_connect($db_host,$db_username,$db_password);
	//mssql_select_db($db_name) or die (error_conexion);
	
	$pdoInc = new PDO('sqlsrv:Server=' . $db_host . ';Database='. $db_name,$db_username,$db_password);

	if($pdoInc == null)
		die (error_conexion);
?>
