<?php

//$db_host        = "MAURICIO-261D0B\MAURICIO";
$db_host        = "kcclbd12des";
$db_name        = "Db_Personal";
$db_username    = "contrato";
$db_password    = "contrato";
 
	$nom=mssql_connect($db_host,$db_username,$db_password);
	mssql_select_db($db_name) or die (error_conexion);

?>
